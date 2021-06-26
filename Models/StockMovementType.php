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

use phpOMS\Stdlib\Base\Enum;

/**
 * Sex type enum.
 *
 * @package Modules\WarehouseManagement\Models
 * @license OMS License 1.0
 * @link    https://orange-management.org
 * @since   1.0.0
 */
abstract class StockMovementType extends Enum
{
    public const MERGE    = 1;
    public const SPLIT    = 2;
    public const INCREASE = 4;
    public const DECREASE = 8;
    public const TRANSFER = 16;


    // @todo: subtypes, maybe creates as database subtypes during install.
    public const DESTROY            = 1; // 8
    public const RETURN             = 1; // 8
    public const INVENTORY_PLUS     = 1; // 4
    public const INVENTORY_MINUS    = 1; // 8
    public const PURCHASE           = 1; // 4
    public const SALE               = 1; // 4
    public const MANUFACTURE_CREATE = 1; // 4
    public const MANUFACTURE_USE    = 1; // 8
    public const MANUAL             = 1; // 1-16
}
