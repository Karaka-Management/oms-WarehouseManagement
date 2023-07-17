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

use Modules\Admin\Models\Address;

/**
 * Warehouse class.
 *
 * @package Modules\Warehousing\Models
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
class StockType
{
    /**
     * ID.
     *
     * @var int
     * @since 1.0.0
     */
    public int $id = 0;

    /**
     * NAme.
     *
     * @var string
     * @since 1.0.0
     */
    public string $name = '';
}
