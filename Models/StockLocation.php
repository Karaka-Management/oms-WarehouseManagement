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
class StockLocation
{
    /**
     * ID.
     *
     * @var int
     * @since 1.0.0
     */
    public int $id = 0;

    public string $name = '';

    public Stock $stock;

    public ?StockType $type = null;

    public int $x = 0;

    public int $y = 0;

    public int $z = 0;

    public array $shelfs = [];

    /**
     * Constructor.
     *
     * @param string $name Stock name
     *
     * @since 1.0.0
     */
    public function __construct(string $name = '')
    {
        $this->name  = $name;
        $this->stock = new NullStock();
    }
}
