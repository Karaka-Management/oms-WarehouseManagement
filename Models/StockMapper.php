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

use Modules\Admin\Models\AddressMapper;
use Modules\ClientManagement\Models\ClientMapper;
use Modules\ItemManagement\Models\StockIdentifierType;
use Modules\SupplierManagement\Models\SupplierMapper;
use phpOMS\DataStorage\Database\Mapper\DataMapperFactory;
use phpOMS\DataStorage\Database\Query\Builder;

/**
 * WarehouseManagement mapper class.
 *
 * @package Modules\WarehouseManagement\Models
 * @license OMS License 2.2
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
        'warehousemgmt_stock_id'        => ['name' => 'warehousemgmt_stock_id',    'type' => 'int',    'internal' => 'id'],
        'warehousemgmt_stock_name'      => ['name' => 'warehousemgmt_stock_name', 'type' => 'string', 'internal' => 'name'],
        'warehousemgmt_stock_unit'      => ['name' => 'warehousemgmt_stock_unit',  'type' => 'int',    'internal' => 'unit'],
        'warehousemgmt_stock_client'    => ['name' => 'warehousemgmt_stock_client',  'type' => 'int',    'internal' => 'client'],
        'warehousemgmt_stock_supplier'  => ['name' => 'warehousemgmt_stock_supplier',  'type' => 'int',    'internal' => 'supplier'],
        'warehousemgmt_stock_inventory' => ['name' => 'warehousemgmt_stock_inventory',  'type' => 'bool',    'internal' => 'inventory'],
        'warehousemgmt_stock_address'   => ['name' => 'warehousemgmt_stock_address',  'type' => 'int',    'internal' => 'address'],
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
     * Belongs to.
     *
     * @var array<string, array{mapper:class-string, external:string, column?:string, by?:string}>
     * @since 1.0.0
     */
    public const BELONGS_TO = [
        'client' => [
            'mapper'   => ClientMapper::class,
            'external' => 'warehousemgmt_stock_client',
        ],
        'supplier' => [
            'mapper'   => SupplierMapper::class,
            'external' => 'warehousemgmt_stock_supplier',
        ],
    ];

    /**
     * Has many relation.
     *
     * @var array<string, array{mapper:class-string, table:string, self?:?string, external?:?string, column?:string}>
     * @since 1.0.0
     */
    public const HAS_MANY = [
        'locations' => [
            'mapper'   => StockLocationMapper::class,
            'table'    => 'warehousemgmt_stocklocation',
            'self'     => 'warehousemgmt_stocklocation_stock',
            'external' => null,
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

    /**
     * Get stock distributions
     *
     * @param int[] $items Items
     *
     * @return array{dists:array, reserved:array, ordered:array}
     *
     * @since 1.0.0
     */
    public static function getStockDistribution(array $items) : array
    {
        $dists    = [];
        $reserved = [];
        $ordered  = [];

        if (empty($items)) {
            return [
                'dists'    => $dists,
                'reserved' => $reserved,
                'ordered'  => $ordered,
            ];
        }

        $itemIdsString = \implode(',', $items);

        // @todo only select sales stock. Therefore we need a place to define the sales stock(s)
        /** @var \Modules\WarehouseManagement\Models\StockDistribution[] $temp */
        $temp = StockDistributionMapper::getAll()
            ->where('item', $items, 'IN')
            ->executeGetArray();

        foreach ($temp as $t) {
            if (!isset($dists[$t->item])) {
                $dists[$t->item] = [];
            }

            // @todo These numbers might need adjustments for delivery notes/invoices depending on
            // how we implement them in the warehouse management (maybe flag them in the transaction protocol as reserved?)
            // also remember the SD issue where delivery notes can be technically still in stock -> stock value still belongs to company
            // solution: "just" do a soft adjust of the available numbers?! but don't change the actual stock in the db
            // the SD solution where actually delivered delivery notes can be adjusted after "archiving" will not be allowed
            // to allow them to see what happened with such a delivery note maybe we can implement a view shows how many of the items are
            // actually still outstanding. This shouldn't be anything special since we need importing of delivery notes anyways and marking
            // old delivery note elements in a way to show which line items or even sub-line items got invoiced/returned etc.
            $dists[$t->item][] = $t;
        }

        $stockIdentifier = StockIdentifierType::NONE;

        $sql = <<<SQL
        SELECT billing_bill_element.billing_bill_element_item,
            billing_type.billing_type_name,
            SUM(billing_bill_element.billing_bill_element_quantity) AS quantity
        FROM billing_bill_element
        LEFT JOIN itemmgmt_item ON billing_bill_element.billing_bill_element_item = itemmgmt_item.itemmgmt_item_id
        LEFT JOIN billing_bill ON billing_bill_element.billing_bill_element_bill = billing_bill.billing_bill_id
        LEFT JOIN billing_type ON billing_bill.billing_bill_type = billing_type.billing_type_id
        WHERE billing_bill_element.billing_bill_element_item IN ({$itemIdsString})
            AND itemmgmt_item.itemmgmt_item_stockidentifier != {$stockIdentifier}
            AND billing_type.billing_type_name IN ('sales_order_confirmation', 'purchase_order')
        GROUP BY billing_bill_element.billing_bill_element_item, billing_type.billing_type_name;
        SQL;

        $query   = new Builder(self::$db);
        $results = $query->raw($sql)->execute()?->fetchAll(\PDO::FETCH_ASSOC) ?? [];

        foreach ($results as $result) {
            if (!isset($reserved[(int) $result['billing_bill_element_item']])) {
                $reserved[(int) $result['billing_bill_element_item']] = 0;
                $ordered[(int) $result['billing_bill_element_item']]  = 0;
            }

            if ($result['billing_type_name'] === 'sales_order_confirmation') {
                $reserved[(int) $result['billing_bill_element_item']] += (int) $result['quantity'];
            } else {
                $ordered[(int) $result['billing_bill_element_item']] += (int) $result['quantity'];
            }
        }

        return [
            'dists'    => $dists,
            'reserved' => $reserved,
            'ordered'  => $ordered,
        ];
    }
}
