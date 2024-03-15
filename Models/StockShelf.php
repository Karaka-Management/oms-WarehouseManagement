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
class StockShelf
{
    /**
     * ID.
     *
     * @var int
     * @since 1.0.0
     */
    public int $id = 0;

    public string $name = '';

    public int | StockLocation $location = 0;

    public ?int $type = null;

    public int $x = 0;

    public int $y = 0;

    public int $z = 0;

    /**
     * Constructor.
     *
     * @param string $name Shelf name
     *
     * @since 1.0.0
     */
    public function __construct(string $name = '')
    {
        $this->name = $name;
    }
}
