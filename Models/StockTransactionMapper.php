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
 * @template T of StockTransaction
 * @extends DataMapperFactory<T>
 */
final class StockTransactionMapper extends DataMapperFactory
{
    /**
     * Columns.
     *
     * @var array<string, array{name:string, type:string, internal:string, autocomplete?:bool, readonly?:bool, writeonly?:bool, annotations?:array}>
     * @since 1.0.0
     */
    public const COLUMNS = [
        'warehousemgmt_stock_transaction_id'             => ['name' => 'warehousemgmt_stock_transaction_id',             'type' => 'int',    'internal' => 'id'],
        'warehousemgmt_stock_transaction_state'          => ['name' => 'warehousemgmt_stock_transaction_state', 'type' => 'int',   'internal' => 'state'],
        'warehousemgmt_stock_transaction_quantity'       => ['name' => 'warehousemgmt_stock_transaction_quantity', 'type' => 'int',   'internal' => 'quantity'],
        'warehousemgmt_stock_transaction_type'           => ['name' => 'warehousemgmt_stock_transaction_type', 'type' => 'int',   'internal' => 'type'],
        'warehousemgmt_stock_transaction_item'           => ['name' => 'warehousemgmt_stock_transaction_item', 'type' => 'int',   'internal' => 'item'],
        'warehousemgmt_stock_transaction_from_lot'       => ['name' => 'warehousemgmt_stock_transaction_from_lot', 'type' => 'int',   'internal' => 'fromLot'],
        'warehousemgmt_stock_transaction_from_stock'     => ['name' => 'warehousemgmt_stock_transaction_from_stock', 'type' => 'int',   'internal' => 'fromStock'],
        'warehousemgmt_stock_transaction_from_stocktype' => ['name' => 'warehousemgmt_stock_transaction_from_stocktype', 'type' => 'int',   'internal' => 'fromStockType'],
        'warehousemgmt_stock_transaction_to_lot'         => ['name' => 'warehousemgmt_stock_transaction_to_lot', 'type' => 'int',   'internal' => 'toLot'],
        'warehousemgmt_stock_transaction_to_stock'       => ['name' => 'warehousemgmt_stock_transaction_to_stock', 'type' => 'int',   'internal' => 'toStock'],
        'warehousemgmt_stock_transaction_to_stocktype'   => ['name' => 'warehousemgmt_stock_transaction_to_stocktype', 'type' => 'int',   'internal' => 'toStockType'],
        'warehousemgmt_stock_transaction_bill_element'   => ['name' => 'warehousemgmt_stock_transaction_bill_element', 'type' => 'int',   'internal' => 'billElement'],
    ];

    /**
     * Model to use by the mapper.
     *
     * @var class-string<T>
     * @since 1.0.0
     */
    public const MODEL = StockTransaction::class;

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    public const TABLE = 'warehousemgmt_stock_transaction';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    public const PRIMARYFIELD = 'warehousemgmt_stock_transaction_id';
}
