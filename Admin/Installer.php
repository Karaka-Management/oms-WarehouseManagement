<?php
/**
 * Orange Management
 *
 * PHP Version 8.0
 *
 * @package   Modules\WarehouseManagement\Admin
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Modules\WarehouseManagement\Admin;

use phpOMS\Config\SettingsInterface;
use phpOMS\DataStorage\Database\DatabasePool;
use phpOMS\Localization\ISO639x1Enum;
use phpOMS\Module\InstallerAbstract;
use phpOMS\Module\ModuleInfo;
use Modules\WarehouseManagement\Models\Stock;
use Modules\WarehouseManagement\Models\StockMapper;
use Modules\WarehouseManagement\Models\StockLocation;
use Modules\WarehouseManagement\Models\StockLocationMapper;

/**
 * Installer class.
 *
 * @package Modules\WarehouseManagement\Admin
 * @license OMS License 1.0
 * @link    https://orange-management.org
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
    public static function install(DatabasePool $dbPool, ModuleInfo $info, SettingsInterface $cfgHandler) : void
    {
        parent::install($dbPool, $info, $cfgHandler);

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
        StockMapper::create($stock);

        $stockLocation        = new StockLocation((string) ($stock->getId() . '-1'));
        $stockLocation->stock = $stock;
        StockLocationMapper::create($stockLocation);
    }
}
