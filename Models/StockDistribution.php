<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\Warehousing\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\WarehouseManagement\Models;

/**
 * Warehouse class.
 *
 * @package Modules\Warehousing\Models
 * @license OMS License 2.2
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

    // @remark We don't care about the location because that is just an internal thing and not all companies really care about that.
}
