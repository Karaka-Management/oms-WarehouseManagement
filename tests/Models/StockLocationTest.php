<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\WarehouseManagement\tests\Models;

use Modules\WarehouseManagement\Models\StockLocation;

/**
 * @internal
 */
final class StockLocationTest extends \PHPUnit\Framework\TestCase
{
    private StockLocation $stock;

    /**
     * {@inheritdoc}
     */
    protected function setUp() : void
    {
        $this->stock = new StockLocation();
    }

    /**
     * @covers Modules\WarehouseManagement\Models\StockLocation
     * @group module
     */
    public function testDefault() : void
    {
        self::assertEquals(0, $this->stock->id);
    }
}
