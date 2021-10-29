<?php
/**
 * Orange Management
 *
 * PHP Version 8.0
 *
 * @package   Modules\WarehouseManagement\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Modules\WarehouseManagement\Models;

use phpOMS\DataStorage\Database\DataMapperAbstract;

/**
 * WarehouseManagement mapper class.
 *
 * @package Modules\WarehouseManagement\Models
 * @license OMS License 1.0
 * @link    https://orange-management.org
 * @since   1.0.0
 */
final class StockLocationMapper extends DataMapperAbstract
{
    /**
     * Columns.
     *
     * @var array<string, array{name:string, type:string, internal:string, autocomplete?:bool, readonly?:bool, writeonly?:bool, annotations?:array}>
     * @since 1.0.0
     */
    protected static array $columns = [
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
     * @var array<string, array{mapper:string, external:string}>
     * @since 1.0.0
     */
    protected static array $belongsTo = [
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
    protected static string $table = 'warehousemgmt_stocklocation';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    protected static string $primaryField = 'warehousemgmt_stocklocation_id';
}
