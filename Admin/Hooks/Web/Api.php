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

return [
    'POST:Module:ClientManagement-client-create' => [
        'callback' => ['\Modules\WarehouseManagement\Controller\ApiController:eventStockCreateInternal'],
    ],
    'POST:Module:SupplierManagement-supplier-create' => [
        'callback' => ['\Modules\WarehouseManagement\Controller\ApiController:eventStockCreateInternal'],
    ],
    '/POST:Module:Billing\-bill(_element)*\-(create|delete|update)/' => [
        'callback' => ['\Modules\WarehouseManagement\Controller\ApiController:eventBillUpdateInternal'],
    ],
];
