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

use Modules\WarehouseManagement\Models\NullStock;

/**
 * @internal
 */
final class NullStockTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @covers Modules\WarehouseManagement\Models\NullStock
     * @group module
     */
    public function testNull() : void
    {
        self::assertInstanceOf('\Modules\WarehouseManagement\Models\Stock', new NullStock());
    }

    /**
     * @covers Modules\WarehouseManagement\Models\NullStock
     * @group module
     */
    public function testId() : void
    {
        $null = new NullStock(2);
        self::assertEquals(2, $null->id);
    }

    /**
     * @covers Modules\WarehouseManagement\Models\NullStock
     * @group module
     */
    public function testJsonSerialize() : void
    {
        $null = new NullStock(2);
        self::assertEquals(['id' => 2], $null);
    }
}
