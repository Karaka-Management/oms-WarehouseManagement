<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   Modules\WarehouseManagement\Models\Attribute
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\WarehouseManagement\Models\Attribute;

use Modules\Attribute\Models\Attribute;
use phpOMS\DataStorage\Database\Mapper\DataMapperFactory;

/**
 * Lot mapper class.
 *
 * @package Modules\WarehouseManagement\Models\Attribute
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 *
 * @template T of Attribute
 * @extends DataMapperFactory<T>
 */
final class LotAttributeMapper extends DataMapperFactory
{
    /**
     * Columns.
     *
     * @var array<string, array{name:string, type:string, internal:string, autocomplete?:bool, readonly?:bool, writeonly?:bool, annotations?:array}>
     * @since 1.0.0
     */
    public const COLUMNS = [
        'warehousemgmt_lot_attr_id'    => ['name' => 'warehousemgmt_lot_attr_id',    'type' => 'int', 'internal' => 'id'],
        'warehousemgmt_lot_attr_lot'   => ['name' => 'warehousemgmt_lot_attr_lot',  'type' => 'int', 'internal' => 'ref'],
        'warehousemgmt_lot_attr_type'  => ['name' => 'warehousemgmt_lot_attr_type',  'type' => 'int', 'internal' => 'type'],
        'warehousemgmt_lot_attr_value' => ['name' => 'warehousemgmt_lot_attr_value', 'type' => 'int', 'internal' => 'value'],
    ];

    /**
     * Has one relation.
     *
     * @var array<string, array{mapper:class-string, external:string, by?:string, column?:string, conditional?:bool}>
     * @since 1.0.0
     */
    public const OWNS_ONE = [
        'type' => [
            'mapper'   => LotAttributeTypeMapper::class,
            'external' => 'warehousemgmt_lot_attr_type',
        ],
        'value' => [
            'mapper'   => LotAttributeValueMapper::class,
            'external' => 'warehousemgmt_lot_attr_value',
        ],
    ];

    /**
     * Model to use by the mapper.
     *
     * @var class-string<T>
     * @since 1.0.0
     */
    public const MODEL = Attribute::class;

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    public const TABLE = 'warehousemgmt_lot_attr';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    public const PRIMARYFIELD = 'warehousemgmt_lot_attr_id';
}
