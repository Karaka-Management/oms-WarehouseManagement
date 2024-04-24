<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\Warehousing\Models
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\WarehouseManagement\Models;

use Modules\ClientManagement\Models\Client;
use Modules\SupplierManagement\Models\Supplier;
use phpOMS\Stdlib\Base\Address;

/**
 * Warehouse class.
 *
 * @package Modules\Warehousing\Models
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 *
 * @todo Add attributes for stock
 *      This is important for things like warehousing cost ratio (Lagerkostensatz)
 *          HR + energy + insurance + interest rate + machinery (e.g. depreciation) + leasing + cleaning
 *          + security + maintenance + ...
 */
class Stock
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

    public int $unit = 0;

    public ?Client $client = null;

    public ?Supplier $supplier = null;

    public ?Address $address = null;

    public bool $inventory = false;

    public array $locations = [];

    /**
     * Constructor.
     *
     * @param string $name Stock name
     *
     * @since 1.0.0
     */
    public function __construct(string $name = '')
    {
        $this->name = $name;
    }
}
