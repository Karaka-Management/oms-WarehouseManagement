<?php
/**
 * Jingga
 *
 * PHP Version 8.2
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
use Modules\ClientManagement\Models\NullClient;
use Modules\ItemManagement\Models\StockIdentifierType;
use Modules\SupplierManagement\Models\NullSupplier;
use Modules\WarehouseManagement\Models\NullStock;
use Modules\WarehouseManagement\Models\NullStockType;
use Modules\WarehouseManagement\Models\Stock;
use Modules\WarehouseManagement\Models\StockDistribution;
use Modules\WarehouseManagement\Models\StockDistributionMapper;
use Modules\WarehouseManagement\Models\StockLocation;
use Modules\WarehouseManagement\Models\StockLocationMapper;
use Modules\WarehouseManagement\Models\StockMapper;
use Modules\WarehouseManagement\Models\StockShelf;
use Modules\WarehouseManagement\Models\StockShelfMapper;
use Modules\WarehouseManagement\Models\StockTransaction;
use Modules\WarehouseManagement\Models\StockTransactionMapper;
use Modules\WarehouseManagement\Models\StockTransactionState;
use Modules\WarehouseManagement\Models\StockTransactionType;
use phpOMS\Message\Http\RequestStatusCode;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;

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
     * Api method to create stock
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiStockCreate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateStockCreate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidCreateResponse($request, $response, $val);

            return;
        }

        $stock = $this->createStockFromRequest($request);
        $this->createModel($request->header->account, $stock, StockMapper::class, 'stock', $request->getOrigin());

        $request->setData('name', $request->getDataString('name') . '-1', true);
        $request->setData('stock', $stock->id, true);

        $stock = $this->createStockLocationFromRequest($request);
        $this->createModel($request->header->account, $stock, StockLocationMapper::class, 'stocklocation', $request->getOrigin());

        $this->createStandardCreateResponse($request, $response, $stock);
    }

    /**
     * Validate stock create request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
     */
    private function validateStockCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['name'] = !$request->hasData('name'))
        ) {
            return $val;
        }

        return [];
    }

    /**
     * Method to create stock from request.
     *
     * @param RequestAbstract $request Request
     *
     * @return Stock
     *
     * @since 1.0.0
     */
    private function createStockFromRequest(RequestAbstract $request) : Stock
    {
        $stock            = new Stock();
        $stock->name      = $request->getDataString('name') ?? '';
        $stock->unit      = $request->getDataInt('unit') ?? 1;
        $stock->inventory = $request->getDataBool('inventory') ?? false;

        $stock->client   = $request->hasData('client') ? new NullClient((int) $request->getData('client')) : null;
        $stock->supplier = $request->hasData('supplier') ? new NullSupplier((int) $request->getData('supplier')) : null;

        return $stock;
    }

    /**
     * Api method to create stock
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiStockLocationCreate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateStockLocationCreate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidCreateResponse($request, $response, $val);

            return;
        }

        $stock = $this->createStockLocationFromRequest($request);
        $this->createModel($request->header->account, $stock, StockLocationMapper::class, 'stocklocation', $request->getOrigin());
        $this->createStandardCreateResponse($request, $response, $stock);
    }

    /**
     * Validate stock create request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
     */
    private function validateStockLocationCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['name'] = !$request->hasData('name'))
            || ($val['stock'] = !$request->hasData('stock'))
        ) {
            return $val;
        }

        return [];
    }

    /**
     * Method to create stock from request.
     *
     * @param RequestAbstract $request Request
     *
     * @return StockLocation
     *
     * @since 1.0.0
     */
    private function createStockLocationFromRequest(RequestAbstract $request) : StockLocation
    {
        $location        = new StockLocation();
        $location->name  = $request->getDataString('name') ?? '';
        $location->stock = new NullStock($request->getDataInt('stock') ?? 1);

        // @todo Define default type instead of just 1
        $location->type = new NullStockType($request->getDataInt('type') ?? 1);

        return $location;
    }

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
        ?int $type = null,
        string $trigger = '',
        ?string $module = null,
        ?string $ref = null,
        ?string $content = null,
        ?string $ip = null
    ) : void
    {
        /** @var \Modules\ClientManagement\Models\Client|\Modules\SupplierManagement\Models\Supplier $new */
        $stock = new Stock($new->number);
        StockMapper::create()->execute($stock);

        $stockLocation        = new StockLocation($stock->name . '-1');
        $stockLocation->stock = $stock;
        StockLocationMapper::create()->execute($stockLocation);

        $stockShelf           = new StockShelf($stockLocation->name . '-1');
        $stockShelf->location = $stockLocation;
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
     *
     * @todo Cleanup/restructure so this function works with database transactions and exceptions. This function is very critical!
     *          Maybe do the transaction outside wherever the updateModel/createModel/... functions are called.
     */
    public function eventBillUpdateInternal(
        int $account,
        mixed $old,
        mixed $new,
        ?int $type = null,
        string $trigger = '',
        ?string $module = null,
        ?string $ref = null,
        ?string $content = null,
        ?string $ip = null
    ) : void
    {
        // Directly/manually creating a transaction is handled in the API Create/Update functions.
        $isBillElement = $new instanceof BillElement;

        /** @var \Modules\Billing\Models\Bill|\Modules\Billing\Models\BillElement $new */
        /** @var \Modules\Billing\Models\Bill $bill */
        $bill = BillMapper::get()
            ->with('type')
            ->with('elements')
            ->with('elements/container')
            ->with('elements/item')
            ->with('supplier')
            ->with('client')
            ->where('id', $isBillElement ? $new->bill->id : $new->id) /* @phpstan-ignore-line */
            ->where('type/transferStock', true)
            ->execute();

        // Has stock movement?
        if ($bill->id === 0 || !$bill->type->transferStock) {
            return;
        }

        /*
        Only necessary if actual client/supplier stock
        $externalStock = 1;
        if ($bill->client !== null) {
            $externalStock = StockMapper::get()
                ->where('client', $bill->client->id)
                ->limit(1)
                ->execute();
        } elseif ($bill->supplier !== null) {
            $externalStock = StockMapper::get()
                ->where('supplier', $bill->supplier->id)
                ->limit(1)
                ->execute();
        }
        */

        // @todo check if old element existed -> removed/changed item
        // @todo we cannot have transaction->to and transaction->from  be the id of client/supplier because the IDs can overlap

        // @todo How to differentiate between stock movement
        //      invoice with prior delivery note(s),
        //      invoice with partly delivery note(s),
        //      invoice with no delivery note
        // @todo Handle bill drafts (now only finalization moves stock, how do we reserve stock?)
        foreach ($bill->elements as $element) {
            if ($element->item === 0 || $element->item === null
                || $element->item->stockIdentifier === StockIdentifierType::NONE
            ) {
                continue;
            }

            $dist = StockDistributionMapper::get()
                ->where('item', $element->item->id)
                ->where('stock', 1) // @todo fix
                ->where('stockType', 1) // @todo fix
                ->where('lot', $element->item->stockIdentifier === StockIdentifierType::NUMBER ? null : '')
                ->limit(1)
                ->execute();

            // @todo how to handle only reserving items for drafted bills (not yet shipped)

            if ($trigger === 'Billing-bill_element-create') {
                // Check stock availability
                if ($bill->type->sign > 0 && $dist->quantity < $element->quantity->getInt()) {
                    continue;
                }

                /** @var \Modules\Billing\Models\BillElement $new */

                // Handle stock quantity
                /////////////////////////////////////////////////////////////////

                // @todo handle stock returns!!!
                if ($bill->type->sign > 0) {
                    $dist->quantity -= $element->quantity->getInt();

                    StockDistributionMapper::update()->execute($dist);
                } elseif ($dist->id === 0) {
                    $dist           = new StockDistribution();
                    $dist->item     = $element->item->id;
                    $dist->quantity = $element->quantity->getInt();

                    $dist->lot       = null; // @todo handle correct
                    $dist->stock     = 1; // @todo handle correct
                    $dist->stockType = 1; // @todo handle correct

                    StockDistributionMapper::create()->execute($dist);
                } else {
                    $dist->quantity += $element->quantity->getInt();

                    StockDistributionMapper::update()->execute($dist);
                }

                // Handle transfer protocol
                /////////////////////////////////////////////////////////////////

                $transaction              = new StockTransaction();
                $transaction->billElement = $new->id;
                $transaction->state       = StockTransactionState::DRAFT;

                // @todo load default stock movement for bill type/organization settings (default stock location, default lot order e.g. FIFO/LIFO)
                // @todo find stock candidates

                $transaction->type     = StockTransactionType::TRANSFER; // @todo depends on bill type
                $transaction->quantity = $new->quantity->getInt(); // @todo may require split quantity if not sufficient available from one lost
                $transaction->item     = $element->item->id;

                // @todo allow consignment bills
                // @todo allow to pass stocklocation for entire bill to avoid re-defining it

                // @todo allow custom stock location
                if ($bill->type->sign > 0) {
                    // Handle from
                    // @todo find possible candidate based on defined default stock for bill type/org/location
                    $transaction->fromStock     = 1; // @todo requires update
                    $transaction->fromStockType = 1; // @todo requires update

                    // Handle to
                    $transaction->toStock     = null; // @todo requires update
                    $transaction->toStockType = null; // @todo requires update

                    if (($bill->client?->id ?? 0) !== 0) {
                        // @todo remove phpstan this is just a bug fix until phpstan fixes this bug
                        /** @phpstan-ignore-next-line */
                        $transaction->to = $bill->client->id;
                    } elseif (($bill->supplier?->id ?? 0) !== 0) {
                        // @todo remove phpstan this is just a bug fix until phpstan fixes this bug
                        /** @phpstan-ignore-next-line */
                        $transaction->to = $bill->supplier->id;
                    }

                    if ($bill->type->transferType === BillTransferType::SALES) {
                        $transaction->subtype = StockTransactionType::SALE;
                    } elseif ($bill->type->transferType === BillTransferType::PURCHASE) {
                        $transaction->subtype = StockTransactionType::RETURN;
                    }
                } else {
                    // Handle from
                    $transaction->fromStock     = null; // @todo requires update
                    $transaction->fromStockType = null; // @todo requires update

                    if (($bill->client?->id ?? 0) !== 0) {
                        // @todo remove phpstan this is just a bug fix until phpstan fixes this bug
                        /** @phpstan-ignore-next-line */
                        $transaction->from = $bill->client->id;
                    } elseif (($bill->supplier?->id ?? 0) !== 0) {
                        // @todo remove phpstan this is just a bug fix until phpstan fixes this bug
                        /** @phpstan-ignore-next-line */
                        $transaction->from = $bill->supplier->id;
                    }

                    // Handle to
                    // @todo find possible candidate based on defined default stock for bill type/org/location
                    $transaction->toStock     = 1; // @todo requires update
                    $transaction->toStockType = 1; // @todo requires update

                    if ($bill->type->transferType === BillTransferType::SALES) {
                        $transaction->subtype = StockTransactionType::RETURN;
                    } elseif ($bill->type->transferType === BillTransferType::PURCHASE) {
                        $transaction->subtype = StockTransactionType::PURCHASE;
                    }
                }

                StockTransactionMapper::create()->execute($transaction);
            } elseif ($trigger === 'Billing-bill_element-update') {
                /** @var \Modules\Billing\Models\BillElement $new */
                /** @var \Modules\Billing\Models\BillElement $old */
                /** @var \Modules\WarehouseManagement\Models\StockTransaction[] $transactions */
                $transactions = StockTransactionMapper::getAll()
                    ->where('billElement', $new->id)
                    ->executeGetArray();

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
                if ($new->item?->id !== $old->item?->id) {
                    // @todo: also undo stock amount in stock distribution
                    StockTransactionMapper::delete()->execute($transactions);

                    $this->eventBillUpdateInternal(
                        $account, $old, $new,
                        $type, 'Billing-bill_element-create', $module, $ref, $content, $ip
                    );
                }

                // @todo handle same item but quantity update
            } elseif ($trigger === 'Billing-bill_element-delete') {
                /** @var \Modules\Billing\Models\BillElement $new */
                /** @var \Modules\WarehouseManagement\Models\StockTransaction[] $transactions */
                $transactions = StockTransactionMapper::getAll()
                    ->where('billElement', $new->id)
                    ->executeGetArray();

                StockTransactionMapper::delete()->execute($transactions);
            } elseif ($trigger === 'Billing-bill-delete') {
                foreach ($bill->elements as $element) {
                    /** @var \Modules\WarehouseManagement\Models\StockTransaction[] $transactions */
                    $transactions = StockTransactionMapper::getAll()
                        ->where('billElement', $element->id)
                        ->executeGetArray();

                    StockTransactionMapper::delete()->execute($transactions);
                    // @todo consider not to delete but mark as deleted?
                }
            } elseif ($trigger === 'Billing-bill-update') {
                // is receiver update -> change all movements
                // is status update -> change all movements (delete = delete)

                /** @var \Modules\Billing\Models\Bill $new */
                if ($new->status === BillStatus::DELETED) {
                    $this->eventBillUpdateInternal(
                        $account, $old, $new,
                        $type, 'Billing-bill-delete', $module, $ref, $content, $ip
                    );
                } elseif ($new->status === BillStatus::ARCHIVED) {
                    foreach ($bill->elements as $element) {
                        /** @var \Modules\WarehouseManagement\Models\StockTransaction[] $transactions */
                        $transactions = StockTransactionMapper::getAll()
                            ->where('billElement', $element->id)
                            ->executeGetArray();

                        foreach ($transactions as $transaction) {
                            $transaction->state = StockTransactionState::TRANSIT; // @todo change to more specific

                            StockTransactionMapper::update()->execute($transaction);
                        }
                    }
                }
            }
        }
    }
}
