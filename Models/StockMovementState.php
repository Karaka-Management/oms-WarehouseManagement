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
 * Stock movement state enum.
 *
 * @package Modules\WarehouseManagement\Models
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
abstract class StockMovementState extends Enum
{
    public const DRAFT = 1;

    public const PICKING = 2;

    public const PICKUP = 3;

    public const TRANSIT = 4;

    public const LOST = 5;

    public const ARRIVED = 6;
}
