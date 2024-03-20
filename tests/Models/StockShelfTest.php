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

use Modules\WarehouseManagement\Models\StockShelf;

/**
 * @internal
 */
final class StockShelfTest extends \PHPUnit\Framework\TestCase
{
    private StockShelf $stock;

    /**
     * {@inheritdoc}
     */
    protected function setUp() : void
    {
        $this->stock = new StockShelf();
    }

    /**
     * @covers \Modules\WarehouseManagement\Models\StockShelf
     * @group module
     */
    public function testDefault() : void
    {
        self::assertEquals(0, $this->stock->id);
    }
}
