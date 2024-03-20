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

use Modules\WarehouseManagement\Models\NullStockLocation;

/**
 * @internal
 */
final class NullStockLocationTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @covers \Modules\WarehouseManagement\Models\NullStockLocation
     * @group module
     */
    public function testNull() : void
    {
        self::assertInstanceOf('\Modules\WarehouseManagement\Models\StockLocation', new NullStockLocation());
    }

    /**
     * @covers \Modules\WarehouseManagement\Models\NullStockLocation
     * @group module
     */
    public function testId() : void
    {
        $null = new NullStockLocation(2);
        self::assertEquals(2, $null->id);
    }

    /**
     * @covers \Modules\WarehouseManagement\Models\NullStockLocation
     * @group module
     */
    public function testJsonSerialize() : void
    {
        $null = new NullStockLocation(2);
        self::assertEquals(['id' => 2], $null->jsonSerialize());
    }
}
