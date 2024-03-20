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

use Modules\Admin\Models\Account;
use Modules\Admin\Models\NullAccount;

/**
 * Warehouse class.
 *
 * @package Modules\Warehousing\Models
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
class StockTransaction
{
    /**
     * ID.
     *
     * @var int
     * @since 1.0.0
     */
    public int $id = 0;

    public int $quantity = 0;

    public ?string $lot = null;

    public int $from = 0;

    public int $to = 0;

    public int $type = StockTransactionType::TRANSFER;

    public int $subtype = 0;

    public string $reference = '';

    public int $billElement = 0;

    public int $state = StockTransactionState::DRAFT;

    public int $item = 0;

    public ?int $fromLot = null;

    public ?int $fromStock = null;

    public ?int $fromStockType = null;

    public ?int $toLot = null;

    public ?int $toStock = null;

    public ?int $toStockType = null;

    /**
     * Creator.
     *
     * @var Account
     * @since 1.0.0
     */
    public Account $createdBy;

    /**
     * Created.
     *
     * @var \DateTimeImmutable
     * @since 1.0.0
     */
    public \DateTimeImmutable $createdAt;

    /**
     * Constructor.
     *
     * @since 1.0.0
     */
    public function __construct()
    {
        $this->createdBy = new NullAccount();
        $this->createdAt = new \DateTimeImmutable('now');
    }
}
