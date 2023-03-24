<?php
/**
 * Karaka
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
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Module\InstallerAbstract;
use phpOMS\Module\ModuleInfo;

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
        $stock->type = 0;
        StockMapper::create()->execute($stock);

        $stockLocation        = new StockLocation((string) ($stock->getId() . '-1'));
        $stockLocation->stock = $stock;
        StockLocationMapper::create()->execute($stockLocation);
    }
}
