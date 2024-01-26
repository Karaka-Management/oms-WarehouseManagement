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

use Modules\Attribute\Models\AttributeType;
use phpOMS\DataStorage\Database\Mapper\DataMapperFactory;

/**
 * Lot mapper class.
 *
 * @package Modules\WarehouseManagement\Models\Attribute
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 *
 * @template T of AttributeType
 * @extends DataMapperFactory<T>
 */
final class LotAttributeTypeMapper extends DataMapperFactory
{
    /**
     * Columns.
     *
     * @var array<string, array{name:string, type:string, internal:string, autocomplete?:bool, readonly?:bool, writeonly?:bool, annotations?:array}>
     * @since 1.0.0
     */
    public const COLUMNS = [
        'warehousemgmt_attr_type_id'       => ['name' => 'warehousemgmt_attr_type_id',       'type' => 'int',    'internal' => 'id'],
        'warehousemgmt_attr_type_name'     => ['name' => 'warehousemgmt_attr_type_name',     'type' => 'string', 'internal' => 'name', 'autocomplete' => true],
        'warehousemgmt_attr_type_datatype' => ['name' => 'warehousemgmt_attr_type_datatype',   'type' => 'int',    'internal' => 'datatype'],
        'warehousemgmt_attr_type_fields'   => ['name' => 'warehousemgmt_attr_type_fields',   'type' => 'int',    'internal' => 'fields'],
        'warehousemgmt_attr_type_custom'   => ['name' => 'warehousemgmt_attr_type_custom',   'type' => 'bool',   'internal' => 'custom'],
        'warehousemgmt_attr_type_pattern'  => ['name' => 'warehousemgmt_attr_type_pattern',  'type' => 'string', 'internal' => 'validationPattern'],
        'warehousemgmt_attr_type_required' => ['name' => 'warehousemgmt_attr_type_required', 'type' => 'bool',   'internal' => 'isRequired'],
    ];

    /**
     * Has many relation.
     *
     * @var array<string, array{mapper:class-string, table:string, self?:?string, external?:?string, column?:string}>
     * @since 1.0.0
     */
    public const HAS_MANY = [
        'l11n' => [
            'mapper'   => LotAttributeTypeL11nMapper::class,
            'table'    => 'warehousemgmt_attr_type_l11n',
            'self'     => 'warehousemgmt_attr_type_l11n_type',
            'column'   => 'content',
            'external' => null,
        ],
        'defaults' => [
            'mapper'   => LotAttributeValueMapper::class,
            'table'    => 'warehousemgmt_lot_attr_default',
            'self'     => 'warehousemgmt_lot_attr_default_type',
            'external' => 'warehousemgmt_lot_attr_default_value',
        ],
    ];

    /**
     * Model to use by the mapper.
     *
     * @var class-string<T>
     * @since 1.0.0
     */
    public const MODEL = AttributeType::class;

    /**
     * Primary table.
     *
     * @var string
     * @since 1.0.0
     */
    public const TABLE = 'warehousemgmt_attr_type';

    /**
     * Primary field name.
     *
     * @var string
     * @since 1.0.0
     */
    public const PRIMARYFIELD = 'warehousemgmt_attr_type_id';
}
