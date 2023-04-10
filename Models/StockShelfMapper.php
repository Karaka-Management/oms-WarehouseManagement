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
 * @template T of StockShelf
 * @extends DataMapperFactory<T>
 */
final class StockShelfMapper extends DataMapperFactory
{
    /**
     * Columns.
     *
     * @var array<string, array{name:string, type:string, internal:string, autocomplete?:bool, readonly?:bool, writeonly?:bool, annotations?:array}>
     * @since 1.0.0
     */
    public const COLUMNS = [
        'warehousemgmt_stockshelf_id'        => ['name' => 'warehousemgmt_stockshelf_id',    'type' => 'int',    'internal' => 'id'],
        'warehousemgmt_stockshelf_name'      => ['name' => 'warehousemgmt_stockshelf_name', 'type' => 'string', 'internal' => 'name'],
        'warehousemgmt_stockshelf_location'  => ['name' => 'warehousemgmt_stockshelf_location',  'type' => 'int',    'internal' => 'location'],
        'warehousemgmt_stockshelf_x'         => ['name' => 'warehousemgmt_stockshelf_x',  'type' => 'int',    'internal' => 'x'],
        'warehousemgmt_stockshelf_y'         => ['name' => 'warehousemgmt_stockshelf_y',  'type' => 'int',    'internal' => 'y'],
        'warehousemgmt_stockshelf_z'         => ['name' => 'warehousemgmt_stockshelf_z',  'type' => 'int',    'internal' => 'z'],
    ];

    /**
     * Belongs to.
     *
     * @var array<string, array{mapper:class-string, external:string, column?:string, by?:string}>
     * @since 1.0.0
     */
    public const BELONGS_TO = [
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
    public const TABLE = 'warehousemgmt_stockshelf';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    public const PRIMARYFIELD = 'warehousemgmt_stockshelf_id';
}
