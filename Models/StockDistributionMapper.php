<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\WarehouseManagement\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\WarehouseManagement\Models;

use phpOMS\DataStorage\Database\Mapper\DataMapperFactory;

/**
 * WarehouseManagement mapper class.
 *
 * @package Modules\WarehouseManagement\Models
 * @license OMS License 2.2
 * @link    https://jingga.app
 * @since   1.0.0
 *
 * @template T of StockDistribution
 * @extends DataMapperFactory<T>
 */
final class StockDistributionMapper extends DataMapperFactory
{
    /**
     * Columns.
     *
     * @var array<string, array{name:string, type:string, internal:string, autocomplete?:bool, readonly?:bool, writeonly?:bool, annotations?:array}>
     * @since 1.0.0
     */
    public const COLUMNS = [
        'warehousemgmt_stock_distribution_id'        => ['name' => 'warehousemgmt_stock_distribution_id',             'type' => 'int',    'internal' => 'id'],
        'warehousemgmt_stock_distribution_item'      => ['name' => 'warehousemgmt_stock_distribution_item',  'type' => 'int',    'internal' => 'item'],
        'warehousemgmt_stock_distribution_lot'       => ['name' => 'warehousemgmt_stock_distribution_lot',  'type' => 'int',    'internal' => 'lot'],
        'warehousemgmt_stock_distribution_stock'     => ['name' => 'warehousemgmt_stock_distribution_stock',  'type' => 'int',    'internal' => 'stock'],
        'warehousemgmt_stock_distribution_stocktype' => ['name' => 'warehousemgmt_stock_distribution_stocktype',  'type' => 'int',    'internal' => 'stockType'],
        'warehousemgmt_stock_distribution_quantity'  => ['name' => 'warehousemgmt_stock_distribution_quantity',  'type' => 'int',    'internal' => 'quantity'],
    ];

    /**
     * Model to use by the mapper.
     *
     * @var class-string<T>
     * @since 1.0.0
     */
    public const MODEL = StockDistribution::class;

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    public const TABLE = 'warehousemgmt_stock_distribution';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    public const PRIMARYFIELD = 'warehousemgmt_stock_distribution_id';
}
