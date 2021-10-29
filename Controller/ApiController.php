<?php
/**
 * Orange Management
 *
 * PHP Version 8.0
 *
 * @package   Modules\WarehouseManagement
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://orange-management.org
 */
declare(strict_types=1);

namespace Modules\WarehouseManagement\Controller;

use Modules\WarehouseManagement\Models\Stock;
use Modules\WarehouseManagement\Models\StockLocation;
use Modules\WarehouseManagement\Models\StockLocationMapper;
use Modules\WarehouseManagement\Models\StockMapper;
use Modules\WarehouseManagement\Models\StockShelf;
use Modules\WarehouseManagement\Models\StockShelfMapper;

/**
 * WarehouseManagement api controller class.
 *
 * @package Modules\WarehouseManagement
 * @license OMS License 1.0
 * @link    https://orange-management.org
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
    public function eventStockCreateInternal(
        int $account,
        mixed $old,
        mixed $new,
        int $type = 0,
        string $trigger = '',
        string $module = null,
        string $ref = null,
        string $content = null,
        string $ip = null
    ) : void
    {
        $stock       = new Stock($new->number);
        $stock->type = 1;
        StockMapper::create($stock);

        $stockLocation        = new StockLocation($stock->name . '-1');
        $stockLocation->stock = $stock->getId();
        StockLocationMapper::create($stockLocation);

        $stockShelf           = new StockShelf($stockLocation->name . '-1');
        $stockShelf->location = $stockLocation->getId();
        StockShelfMapper::create($stockShelf);
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
        int $type = 0,
        string $trigger = '',
        string $module = null,
        string $ref = null,
        string $content = null,
        string $ip = null
    ) : void
    {
        if ($trigger === 'POST:Module:Billing-bill_element-create') {
            // @todo: if is bill element create, create stock movement
            return;
        } elseif ($trigger === 'POST:Module:Billing-bill_element-update') {
            // quantity change
            // lot changes
            // stock changes
            // all other changes ignore!
            // check availability again, if not available abort bill
            return;
        } elseif ($trigger === 'POST:Module:Billing-bill_element-delete') {
            // @todo: delete stock movement
            return;
        } elseif ($trigger === 'POST:Module:Billing-bill-delete') {
            // @todo: delete stock movements
            return;
        } elseif ($trigger === 'POST:Module:Billing-bill-update') {
            // is receiver update -> change all movements
            // is status update -> change all movements (delete = delete)
            return;
        }
    }
}
