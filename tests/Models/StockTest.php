<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   tests
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\WarehouseManagement\tests\Models;

use Modules\WarehouseManagement\Models\Stock;

/**
 * @internal
 */
#[\PHPUnit\Framework\Attributes\CoversClass(\Modules\WarehouseManagement\Models\Stock::class)]
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

    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testDefault() : void
    {
        self::assertEquals(0, $this->stock->id);
    }
}
