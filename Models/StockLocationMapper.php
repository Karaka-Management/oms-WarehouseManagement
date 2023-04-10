<?php
/**
 * Karaka
 *
 * PHP Version 8.1
 *
 * @package   Modules\WarehouseManagement\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
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
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 *
 * @template T of StockLocation
 * @extends DataMapperFactory<T>
 */
final class StockLocationMapper extends DataMapperFactory
{
    /**
     * Columns.
     *
     * @var array<string, array{name:string, type:string, internal:string, autocomplete?:bool, readonly?:bool, writeonly?:bool, annotations?:array}>
     * @since 1.0.0
     */
    public const COLUMNS = [
        'warehousemgmt_stocklocation_id'     => ['name' => 'warehousemgmt_stocklocation_id',    'type' => 'int',    'internal' => 'id'],
        'warehousemgmt_stocklocation_name'   => ['name' => 'warehousemgmt_stocklocation_name', 'type' => 'string', 'internal' => 'name'],
        'warehousemgmt_stocklocation_stock'  => ['name' => 'warehousemgmt_stocklocation_stock',  'type' => 'int',    'internal' => 'stock'],
        'warehousemgmt_stocklocation_x'      => ['name' => 'warehousemgmt_stocklocation_x',  'type' => 'int',    'internal' => 'x'],
        'warehousemgmt_stocklocation_y'      => ['name' => 'warehousemgmt_stocklocation_y',  'type' => 'int',    'internal' => 'y'],
        'warehousemgmt_stocklocation_z'      => ['name' => 'warehousemgmt_stocklocation_z',  'type' => 'int',    'internal' => 'z'],
    ];

    /**
     * Belongs to.
     *
     * @var array<string, array{mapper:class-string, external:string, column?:string, by?:string}>
     * @since 1.0.0
     */
    public const BELONGS_TO = [
        'stock' => [
            'mapper'     => StockMapper::class,
            'external'   => 'warehousemgmt_stocklocation_stock',
        ],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    public const TABLE = 'warehousemgmt_stocklocation';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    public const PRIMARYFIELD = 'warehousemgmt_stocklocation_id';
}
