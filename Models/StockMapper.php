<?php
/**
 * Jingga
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

use Modules\Admin\Models\AddressMapper;
use phpOMS\DataStorage\Database\Mapper\DataMapperFactory;

/**
 * WarehouseManagement mapper class.
 *
 * @package Modules\WarehouseManagement\Models
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 *
 * @template T of Stock
 * @extends DataMapperFactory<T>
 */
final class StockMapper extends DataMapperFactory
{
    /**
     * Columns.
     *
     * @var array<string, array{name:string, type:string, internal:string, autocomplete?:bool, readonly?:bool, writeonly?:bool, annotations?:array}>
     * @since 1.0.0
     */
    public const COLUMNS = [
        'warehousemgmt_stock_id'       => ['name' => 'warehousemgmt_stock_id',    'type' => 'int',    'internal' => 'id'],
        'warehousemgmt_stock_name'     => ['name' => 'warehousemgmt_stock_name', 'type' => 'string', 'internal' => 'name'],
        'warehousemgmt_stock_unit'     => ['name' => 'warehousemgmt_stock_unit',  'type' => 'int',    'internal' => 'unit'],
        'warehousemgmt_stock_address'  => ['name' => 'warehousemgmt_stock_address',  'type' => 'int',    'internal' => 'address'],
    ];

    /**
     * Has one relation.
     *
     * @var array<string, array{mapper:class-string, external:string, by?:string, column?:string, conditional?:bool}>
     * @since 1.0.0
     */
    public const OWNS_ONE = [
        'address' => [
            'mapper'   => AddressMapper::class,
            'external' => 'warehousemgmt_stock_address',
        ],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    public const TABLE = 'warehousemgmt_stock';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    public const PRIMARYFIELD = 'warehousemgmt_stock_id';
}
