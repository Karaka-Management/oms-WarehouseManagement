<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   Modules\Warehousing\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\WarehouseManagement\Models;

/**
 * Warehouse class.
 *
 * @package Modules\Warehousing\Models
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
class StockDistribution
{
    /**
     * ID.
     *
     * @var int
     * @since 1.0.0
     */
    public int $id = 0;

    public int $quantity = 0;

    public ?int $lot = null;

    public int $item = 0;

    public int $stock = 0;

    public int $stockType = 0;
}
