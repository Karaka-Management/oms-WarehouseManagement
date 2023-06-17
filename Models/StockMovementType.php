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

use phpOMS\Stdlib\Base\Enum;

/**
 * Sex type enum.
 *
 * @package Modules\WarehouseManagement\Models
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
abstract class StockMovementType extends Enum
{
    public const MERGE = 1;

    public const SPLIT = 2;

    public const INCREASE = 4;

    public const DECREASE = 8;

    public const TRANSFER = 16;

    // @todo: subtypes, maybe creates as database subtypes during install.
    public const DESTROY = 101;

    public const RETURN = 102;

    public const INVENTORY_PLUS = 103;

    public const INVENTORY_MINUS = 104;

    public const PURCHASE = 105;

    public const SALE = 106;

    public const MANUFACTURE_CREATE = 107;

    public const MANUFACTURE_USE = 108;

    public const MANUAL = 109;
}
