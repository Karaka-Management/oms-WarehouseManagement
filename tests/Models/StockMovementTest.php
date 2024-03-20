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

use Modules\WarehouseManagement\Models\StockTransaction;

/**
 * @internal
 */
#[\PHPUnit\Framework\Attributes\CoversClass(\Modules\WarehouseManagement\Models\StockTransaction::class)]
final class StockMovementTest extends \PHPUnit\Framework\TestCase
{
    private StockTransaction $movement;

    /**
     * {@inheritdoc}
     */
    protected function setUp() : void
    {
        $this->movement = new StockTransaction();
    }

    #[\PHPUnit\Framework\Attributes\Group('module')]
    public function testDefault() : void
    {
        self::assertEquals(0, $this->movement->id);
    }
}
