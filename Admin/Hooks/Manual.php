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

return [
    '/POST:Module:Billing\-bill_element\-(create|update|delete)/' => [
        'callback' => ['\Modules\WarehouseManagement\Controller\ApiController:eventBillUpdateInternal'],
    ],
    '/POST:Module:Billing\-bill\-(update|delete)/' => [
        'callback' => ['\Modules\WarehouseManagement\Controller\ApiController:eventBillUpdateInternal'],
    ],
];
