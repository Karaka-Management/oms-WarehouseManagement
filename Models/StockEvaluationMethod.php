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
 * Stock evaluation type enum.
 *
 * @package Modules\WarehouseManagement\Models
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
abstract class StockEvaluationMethod extends Enum
{
    public const LIFO = 1;

    public const FIFO = 2;

    public const WEIGHTED_AVERAGE = 3;

    public const SPECIFIC_IDENTIFICATION = 4;

    public const STANDARD_COST = 5;

    public const REPLACEMENT = 6;

    public const MANUAL = 9;
}
