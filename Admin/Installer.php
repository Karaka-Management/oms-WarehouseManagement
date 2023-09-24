<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   Modules\WarehouseManagement\Admin
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\WarehouseManagement\Admin;

use Modules\WarehouseManagement\Models\Stock;
use Modules\WarehouseManagement\Models\StockLocation;
use Modules\WarehouseManagement\Models\StockLocationMapper;
use Modules\WarehouseManagement\Models\StockMapper;
use phpOMS\Application\ApplicationAbstract;
use phpOMS\Config\SettingsInterface;
use phpOMS\Message\Http\HttpRequest;
use phpOMS\Message\Http\HttpResponse;
use phpOMS\Module\InstallerAbstract;
use phpOMS\Module\ModuleInfo;
use phpOMS\Uri\HttpUri;

/**
 * Installer class.
 *
 * @package Modules\WarehouseManagement\Admin
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
final class Installer extends InstallerAbstract
{
    /**
     * Path of the file
     *
     * @var string
     * @since 1.0.0
     */
    public const PATH = __DIR__;

    /**
     * {@inheritdoc}
     */
    public static function install(ApplicationAbstract $app, ModuleInfo $info, SettingsInterface $cfgHandler) : void
    {
        parent::install($app, $info, $cfgHandler);

        self::createDefaultStock();

        /* Stock types */
        $fileContent = \file_get_contents(__DIR__ . '/Install/types.json');
        if ($fileContent === false) {
            return;
        }

        /** @var array $types */
        $types = \json_decode($fileContent, true);
        if ($types === false) {
            return;
        }

        self::createStockTypes($app, $types);
    }

    /**
     * Creates a default stock
     *
     * @return void
     *
     * @since 1.0.0
     */
    private static function createDefaultStock() : void
    {
        $stock       = new Stock('Default');
        $stock->unit = 1;
        StockMapper::create()->execute($stock);

        $stockLocation        = new StockLocation((string) ($stock->id . '-1'));
        $stockLocation->stock = $stock;
        StockLocationMapper::create()->execute($stockLocation);
    }

    /**
     * Install default stock types
     *
     * @param ApplicationAbstract $app   Application
     * @param array               $types Stock types
     *
     * @return array
     *
     * @since 1.0.0
     */
    private static function createStockTypes(ApplicationAbstract $app, array $types) : array
    {
        $stockTypes = [];

        /** @var \Modules\WarehouseManagement\Controller\ApiStockTypeController $module */
        $module = $app->moduleManager->getModuleInstance('WarehouseManagement', 'ApiStockType');

        // @todo: allow multiple alternative stock templates
        // @todo: implement ordering of templates

        foreach ($types as $type) {
            $response = new HttpResponse();
            $request  = new HttpRequest(new HttpUri(''));

            $request->header->account = 1;
            $request->setData('name', $type['name'] ?? '');
            $request->setData('title', \reset($type['l11n']));
            $request->setData('language', \array_keys($type['l11n'])[0] ?? 'en');

            $module->apiStockTypeCreate($request, $response);

            $responseData = $response->get('');
            if (!\is_array($responseData)) {
                continue;
            }

            $stockType = \is_array($responseData['response'])
                ? $responseData['response']
                : $responseData['response']->toArray();

            $stockTypes[] = $stockType;

            $isFirst = true;
            foreach ($type['l11n'] as $language => $l11n) {
                if ($isFirst) {
                    $isFirst = false;
                    continue;
                }

                $response = new HttpResponse();
                $request  = new HttpRequest(new HttpUri(''));

                $request->header->account = 1;
                $request->setData('title', $l11n);
                $request->setData('language', $language);
                $request->setData('type', $stockType['id']);

                $module->apiStockTypeL11nCreate($request, $response);
            }
        }

        return $stockTypes;
    }
}
