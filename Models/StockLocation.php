<?php
/**
 * Orange Management
 *
 * PHP Version 8.0
 *
 * @package   Modules\Warehousing\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Modules\WarehouseManagement\Models;

/**
 * Warehouse class.
 *
 * @package Modules\Warehousing\Models
 * @license OMS License 1.0
 * @link    https://orange-management.org
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
    private int $id = 0;

    public string $name = '';

    public int | Stock $stock = 0;

    public int $x = 0;

    public int $y = 0;

    public int $z = 0;

    public function __construct(string $name = '')
    {
        $this->name = $name;
    }

    public function getId() : int
    {
    	return $this->id;
    }
}
