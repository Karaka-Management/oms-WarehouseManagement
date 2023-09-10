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
abstract class StockEvaluation extends Enum
{
    // ifrs, hgb, ...
    public int $type = 0;

    // lifo, fifo, ...
    public int $method = StockEvaluationMethod::SPECIFIC_IDENTIFICATION;

    public int $altmethod = StockEvaluationMethod::WEIGHTED_AVERAGE;

    // script to run for evaluation
    public int $script = 0;

    public int $evaluationcategory = 0;

    public int $itemsegment = 0;

    public int $itemgroup = 0;

    public int $itemtype = 0;

    public int $itemsection = 0;

    public int $item = 0;

    // days, month
    public int $intervalType = 0;

    // range, last sold, ...
    public int $limitLow = 0;

    // range, last sold, ...
    public int $limitHigh = 0;

    public int $value = 0;

    public float $evaluation = 0.0;
}
