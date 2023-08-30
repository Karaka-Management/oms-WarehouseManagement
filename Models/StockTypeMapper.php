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

use phpOMS\DataStorage\Database\Mapper\DataMapperFactory;

/**
 * WarehouseManagement mapper class.
 *
 * @package Modules\WarehouseManagement\Models
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 *
 * @template T of StockType
 * @extends DataMapperFactory<T>
 */
final class StockTypeMapper extends DataMapperFactory
{
    /**
     * Columns.
     *
     * @var array<string, array{name:string, type:string, internal:string, autocomplete?:bool, readonly?:bool, writeonly?:bool, annotations?:array}>
     * @since 1.0.0
     */
    public const COLUMNS = [
        'warehousemgmt_stock_type_id'    => ['name' => 'warehousemgmt_stock_type_id',    'type' => 'int',    'internal' => 'id'],
        'warehousemgmt_stock_type_name'  => ['name' => 'warehousemgmt_stock_type_name', 'type' => 'string', 'internal' => 'name'],
    ];

    /**
     * Has many relation.
     *
     * @var array<string, array{mapper:class-string, table:string, self?:?string, external?:?string, column?:string}>
     * @since 1.0.0
     */
    public const HAS_MANY = [
        'l11n' => [
            'mapper'            => StockTypeL11nMapper::class,
            'table'             => 'warehousemgmt_stock_type_l11n',
            'self'              => 'warehousemgmt_stock_type_l11n_type',
            'column'            => 'content',
            'external'          => null,
        ],
    ];

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    public const TABLE = 'warehousemgmt_stock_type';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    public const PRIMARYFIELD = 'warehousemgmt_stock_type_id';

    /**
     * Model to use by the mapper.
     *
     * @var class-string<T>
     * @since 1.0.0
     */
    public const MODEL = StockType::class;
}
