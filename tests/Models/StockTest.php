<?php
/**
 * Karaka
 *
 * PHP Version 8.0
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://karaka.app
 */
declare(strict_types=1);

namespace Modules\WarehouseManagement\tests\Models;

use Modules\WarehouseManagement\Models\Stock;

/**
 * @internal
 */
final class StockTest extends \PHPUnit\Framework\TestCase
{
    private Stock $stock;

    /**
     * {@inheritdoc}
     */
    protected function setUp() : void
    {
        $this->stock = new Stock();
    }

    /**
     * @covers Modules\WarehouseManagement\Models\Stock
     * @group module
     */
    public function testDefault() : void
    {
        self::assertEquals(0, $this->stock->getId());
    }
}