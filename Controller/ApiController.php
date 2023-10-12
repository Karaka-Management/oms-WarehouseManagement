<?php
/**
 * Jingga
 *
 * PHP Version 8.1
 *
 * @package   Modules\WarehouseManagement
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.0
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

namespace Modules\WarehouseManagement\Controller;

use Modules\Billing\Models\BillElement;
use Modules\Billing\Models\BillMapper;
use Modules\Billing\Models\BillStatus;
use Modules\Billing\Models\BillTransferType;
use Modules\WarehouseManagement\Models\Stock;
use Modules\WarehouseManagement\Models\StockLocation;
use Modules\WarehouseManagement\Models\StockLocationMapper;
use Modules\WarehouseManagement\Models\StockMapper;
use Modules\WarehouseManagement\Models\StockMovement;
use Modules\WarehouseManagement\Models\StockMovementMapper;
use Modules\WarehouseManagement\Models\StockMovementState;
use Modules\WarehouseManagement\Models\StockMovementType;
use Modules\WarehouseManagement\Models\StockShelf;
use Modules\WarehouseManagement\Models\StockShelfMapper;

/**
 * WarehouseManagement api controller class.
 *
 * @package Modules\WarehouseManagement
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
final class ApiController extends Controller
{
    /**
     * Event after creating a stock
     *
     * @param int         $account Account
     * @param mixed       $old     Old stock model
     * @param mixed       $new     New / created stock model
     * @param null|int    $type    Event type (usually mapper hash)
     * @param string      $trigger Trigger name
     * @param null|string $module  Module name who triggers the event
     * @param null|string $ref     Reference (e.g. reference to a different model)
     * @param null|string $content Content for the event (e.g. comment, values, ...)
     * @param null|string $ip      Ip of the account
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function eventStockCreateInternal(
        int $account,
        mixed $old,
        mixed $new,
        int $type = null,
        string $trigger = '',
        string $module = null,
        string $ref = null,
        string $content = null,
        string $ip = null
    ) : void
    {
        /** @var \Modules\ClientManagement\Models\Client|\Modules\SupplierManagement\Models\Supplier $new */
        $stock = new Stock($new->number);
        StockMapper::create()->execute($stock);

        $stockLocation        = new StockLocation($stock->name . '-1');
        $stockLocation->stock = $stock->id;
        StockLocationMapper::create()->execute($stockLocation);

        $stockShelf           = new StockShelf($stockLocation->name . '-1');
        $stockShelf->location = $stockLocation->id;
        StockShelfMapper::create()->execute($stockShelf);
    }

    /**
     * Event after doing anything with a bill
     *
     * @param int         $account Account
     * @param mixed       $old     Old bill model
     * @param mixed       $new     New / created bill model
     * @param int         $type    Event type (usually mapper hash)
     * @param string      $trigger Trigger name
     * @param null|string $module  Module name who triggers the event
     * @param null|string $ref     Reference (e.g. reference to a different model)
     * @param null|string $content Content for the event (e.g. comment, values, ...)
     * @param null|string $ip      Ip of the account
     *
     * @return void
     *
     * @since 1.0.0
     */
    public function eventBillUpdateInternal(
        int $account,
        mixed $old,
        mixed $new,
        int $type = null,
        string $trigger = '',
        string $module = null,
        string $ref = null,
        string $content = null,
        string $ip = null
    ) : void
    {
        // Directly/manually creating a transaction is handled in the API Create/Update functions.

        /** @var \Modules\Billing\Models\Bill|\Modules\Billing\Models\BillElement $new */
        /** @var \Modules\Billing\Models\Bill $bill */
        $bill = BillMapper::get()
            ->with('type')
            ->with('supplier')
            ->with('client')
            ->where('id', $new instanceof BillElement ? $new->bill->id : $new->id)
            ->execute();

        // Has stock movement?
        if ($bill->id !== 0 && !$bill->type->transferStock) {
            return;
        }

        // @todo: check if old element existed -> removed/changed item
        // @todo: we cannot have transaction->to and transaction->from  be the id of client/supplier because the IDs can overlap

        $transaction = new StockMovement();

        if ($trigger === 'POST:Module:Billing-bill_element-create') {
            /** @var \Modules\Billing\Models\BillElement $new */

            $transaction->billElement = $new->id;
            $transaction->state       = StockMovementState::DRAFT;

            // @todo: load default stock movement for bill type/organization settings (default stock location, default lot order e.g. FIFO/LIFO)
            // @todo: find stock candidates

            $transaction->type     = StockMovementType::TRANSFER; // @todo: depends on bill type
            $transaction->quantity = $new->getQuantity(); // @todo may require split quantity if not sufficient available from one lost

            // @todo: allow consignment bills
            // @todo: allow to pass stocklocation for entire bill to avoid re-defining it

            // @todo: allow custom stock location
            if ($bill->type->sign > 0) {
                // Handle from
                // @todo: find possible candidate based on defined default stock for bill type/org/location

                // Handle to
                if (($bill->client?->id ?? 0) !== 0) {
                    // @todo: remove phpstan this is just a bug fix until phpstan fixes this bug
                    /** @phpstan-ignore-next-line */
                    $transaction->to = $bill->client->id;
                } elseif (($bill->supplier?->id ?? 0) !== 0) {
                    // @todo: remove phpstan this is just a bug fix until phpstan fixes this bug
                    /** @phpstan-ignore-next-line */
                    $transaction->to = $bill->supplier->id;
                }

                if ($bill->type->transferType === BillTransferType::SALES) {
                    $transaction->subtype = StockMovementType::SALE;
                } elseif ($bill->type->transferType === BillTransferType::PURCHASE) {
                    $transaction->subtype = StockMovementType::PURCHASE;
                }
            } else {
                // Handle from
                if (($bill->client?->id ?? 0) !== 0) {
                    // @todo: remove phpstan this is just a bug fix until phpstan fixes this bug
                    /** @phpstan-ignore-next-line */
                    $transaction->from = $bill->client->id;
                } elseif (($bill->supplier?->id ?? 0) !== 0) {
                    // @todo: remove phpstan this is just a bug fix until phpstan fixes this bug
                    /** @phpstan-ignore-next-line */
                    $transaction->from = $bill->supplier->id;
                }

                // Handle to
                // @todo: find possible candidate based on defined default stock for bill type/org/location

                if ($bill->type->transferType === BillTransferType::SALES
                    || $bill->type->transferType === BillTransferType::PURCHASE
                ) {
                    $transaction->subtype = StockMovementType::RETURN;
                }
            }

            return;
        } elseif ($trigger === 'POST:Module:Billing-bill_element-update') {
            /** @var \Modules\Billing\Models\BillElement $new */
            /** @var \Modules\Billing\Models\BillElement $old */
            /** @var \Modules\WarehouseManagement\Models\StockMovement[] $transactions */
            $transactions = StockMovementMapper::getAll()
                ->where('billElement', $new->id)
                ->execute();

            /*
            if ($new->item === $old->item) {
                // quantity change
                // lot changes
                // stock changes
                // all other changes ignore!
                // check availability again, if not available abort bill
                // maybe from an algorithmic point of view first set quantity to zero
                // and then do normal algorithm like for a new element
            }
            */
            if ($new->item !== $old->item) {
                StockMovementMapper::delete()->execute($transactions);

                $this->eventBillUpdateInternal(
                    $account, $old, $new,
                    $type, 'POST:Module:Billing-bill_element-create', $module, $ref, $content, $ip
                );
            }

            return;
        } elseif ($trigger === 'POST:Module:Billing-bill_element-delete') {
            /** @var \Modules\Billing\Models\BillElement $new */
            /** @var \Modules\WarehouseManagement\Models\StockMovement[] $transactions */
            $transactions = StockMovementMapper::getAll()
                ->where('billElement', $new->id)
                ->execute();

            StockMovementMapper::delete()->execute($transactions);

            return;
        } elseif ($trigger === 'POST:Module:Billing-bill-delete') {
            /** @var \Modules\Billing\Models\Bill $new */
            /** @var \Modules\Billing\Models\Bill $bill */
            $bill = BillMapper::get()
                ->with('type')
                ->with('elements')
                ->with('supplier')
                ->with('client')
                ->where('id', $new->id)
                ->execute();

            foreach ($bill->elements as $element) {
                /** @var \Modules\WarehouseManagement\Models\StockMovement[] $transactions */
                $transactions = StockMovementMapper::getAll()
                    ->where('billElement', $element->id)
                    ->execute();

                StockMovementMapper::delete()->execute($transactions);
                // @todo: consider not to delete but mark as deleted?
            }

            return;
        } elseif ($trigger === 'POST:Module:Billing-bill-update') {
            // is receiver update -> change all movements
            // is status update -> change all movements (delete = delete)

            /** @var \Modules\Billing\Models\Bill $new */
            if ($new->status === BillStatus::DELETED) {
                $this->eventBillUpdateInternal(
                    $account, $old, $new,
                    $type, 'POST:Module:Billing-bill-delete', $module, $ref, $content, $ip
                );
            } elseif ($new->status === BillStatus::ARCHIVED) {
                /** @var \Modules\Billing\Models\Bill $bill */
                $bill = BillMapper::get()
                    ->with('type')
                    ->with('elements')
                    ->with('supplier')
                    ->with('client')
                    ->where('id', $new->id)
                    ->execute();

                foreach ($bill->elements as $element) {
                    /** @var \Modules\WarehouseManagement\Models\StockMovement[] $transactions */
                    $transactions = StockMovementMapper::getAll()
                        ->where('billElement', $element->id)
                        ->execute();

                    foreach ($transactions as $transaction) {
                        $transaction->state = StockMovementState::TRANSIT; // @todo: change to more specific

                        StockMovementMapper::update()->execute($transaction);
                    }
                }
            }

            return;
        }
    }
}
