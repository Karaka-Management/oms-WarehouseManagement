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

use Modules\WarehouseManagement\Models\StockMovement;

/**
 * @internal
 */
final class StockMovementTest extends \PHPUnit\Framework\TestCase
{
    private StockMovement $movement;

    /**
     * {@inheritdoc}
     */
    protected function setUp() : void
    {
        $this->movement = new StockMovement();
    }

    /**
     * @covers Modules\WarehouseManagement\Models\StockMovement
     * @group module
     */
    public function testDefault() : void
    {
        self::assertEquals(0, $this->movement->getId());
    }
}