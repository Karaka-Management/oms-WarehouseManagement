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
final class StockShelfMapper extends DataMapperAbstract
{
    /**
     * Columns.
     *
     * @var array<string, array{name:string, type:string, internal:string, autocomplete?:bool, readonly?:bool, writeonly?:bool, annotations?:array}>
     * @since 1.0.0
     */
    protected static array $columns = [
        'warehousemgmt_stockshelf_id'    => ['name' => 'warehousemgmt_stockshelf_id',    'type' => 'int',    'internal' => 'id'],
        'warehousemgmt_stockshelf_name' => ['name' => 'warehousemgmt_stockshelf_name', 'type' => 'string', 'internal' => 'name'],
        'warehousemgmt_stockshelf_location'  => ['name' => 'warehousemgmt_stockshelf_location',  'type' => 'int',    'internal' => 'location'],
        'warehousemgmt_stockshelf_x'  => ['name' => 'warehousemgmt_stockshelf_x',  'type' => 'int',    'internal' => 'x'],
        'warehousemgmt_stockshelf_y'  => ['name' => 'warehousemgmt_stockshelf_y',  'type' => 'int',    'internal' => 'y'],
        'warehousemgmt_stockshelf_z'  => ['name' => 'warehousemgmt_stockshelf_z',  'type' => 'int',    'internal' => 'z'],
    ];

    /**
     * Belongs to.
     *
     * @var array<string, array{mapper:string, external:string}>
     * @since 1.0.0
     */
    protected static array $belongsTo = [
        'location' => [
            'mapper'     => StockMapper::class,
            'external'   => 'warehousemgmt_stockshelf_location',
        ],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    protected static string $table = 'warehousemgmt_stockshelf';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    protected static string $primaryField = 'warehousemgmt_stockshelf_id';
}