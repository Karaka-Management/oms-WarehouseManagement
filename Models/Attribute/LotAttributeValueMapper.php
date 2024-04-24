<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\WarehouseManagement\Models\Attribute
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\WarehouseManagement\Models\Attribute;

use Modules\Attribute\Models\AttributeValue;
use phpOMS\DataStorage\Database\Mapper\DataMapperFactory;

/**
 * Lot mapper class.
 *
 * @package Modules\WarehouseManagement\Models\Attribute
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 *
 * @template T of AttributeValue
 * @extends DataMapperFactory<T>
 */
final class LotAttributeValueMapper extends DataMapperFactory
{
    /**
     * Columns.
     *
     * @var array<string, array{name:string, type:string, internal:string, autocomplete?:bool, readonly?:bool, writeonly?:bool, annotations?:array}>
     * @since 1.0.0
     */
    public const COLUMNS = [
        'warehousemgmt_attr_value_id'       => ['name' => 'warehousemgmt_attr_value_id',       'type' => 'int',      'internal' => 'id'],
        'warehousemgmt_attr_value_default'  => ['name' => 'warehousemgmt_attr_value_default',  'type' => 'bool',     'internal' => 'isDefault'],
        'warehousemgmt_attr_value_valueStr' => ['name' => 'warehousemgmt_attr_value_valueStr', 'type' => 'string',   'internal' => 'valueStr'],
        'warehousemgmt_attr_value_valueInt' => ['name' => 'warehousemgmt_attr_value_valueInt', 'type' => 'int',      'internal' => 'valueInt'],
        'warehousemgmt_attr_value_valueDec' => ['name' => 'warehousemgmt_attr_value_valueDec', 'type' => 'float',    'internal' => 'valueDec'],
        'warehousemgmt_attr_value_valueDat' => ['name' => 'warehousemgmt_attr_value_valueDat', 'type' => 'DateTime', 'internal' => 'valueDat'],
        'warehousemgmt_attr_value_unit'     => ['name' => 'warehousemgmt_attr_value_unit', 'type' => 'string', 'internal' => 'unit'],
        'warehousemgmt_attr_value_deptype'  => ['name' => 'warehousemgmt_attr_value_deptype', 'type' => 'int', 'internal' => 'dependingAttributeType'],
        'warehousemgmt_attr_value_depvalue' => ['name' => 'warehousemgmt_attr_value_depvalue', 'type' => 'int', 'internal' => 'dependingAttributeValue'],
    ];

    /**
     * Has many relation.
     *
     * @var array<string, array{mapper:class-string, table:string, self?:?string, external?:?string, column?:string}>
     * @since 1.0.0
     */
    public const HAS_MANY = [
        'l11n' => [
            'mapper'   => LotAttributeValueL11nMapper::class,
            'table'    => 'warehousemgmt_attr_value_l11n',
            'self'     => 'warehousemgmt_attr_value_l11n_value',
            'column'   => 'content',
            'external' => null,
        ],
    ];

    /**
     * Model to use by the mapper.
     *
     * @var class-string<T>
     * @since 1.0.0
     */
    public const MODEL = AttributeValue::class;

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    public const TABLE = 'warehousemgmt_attr_value';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    public const PRIMARYFIELD = 'warehousemgmt_attr_value_id';
}
