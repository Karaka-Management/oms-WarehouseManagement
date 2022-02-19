<?php
/**
 * Karaka
 *
 * PHP Version 8.0
 *
 * @package   Modules\WarehouseManagement
 * @copyright Dennis Eichhorn
 * @license   OMS License 1.0
 * @version   1.0.0
 * @link      https://karaka.app
 */
declare(strict_types=1);

use Modules\WarehouseManagement\Controller\BackendController;
use Modules\WarehouseManagement\Models\PermissionState;
use phpOMS\Account\PermissionType;
use phpOMS\Router\RouteVerb;

return [
    '^.*/warehouse/stock/list.*$' => [
        [
            'dest'       => '\Modules\WarehouseManagement\Controller\BackendController:viewStockList',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionState::STOCK,
            ],
        ],
    ],
    '^.*/warehouse/stock(\?.*)?$' => [
        [
            'dest'       => '\Modules\WarehouseManagement\Controller\BackendController:viewStock',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionState::STOCK,
            ],
        ],
    ],
    '^.*/warehouse/stock/location/list.*$' => [
        [
            'dest'       => '\Modules\WarehouseManagement\Controller\BackendController:viewStockLocationList',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionState::STOCK_LOCATION,
            ],
        ],
    ],
    '^.*/warehouse/stock/location(\?.*)?$' => [
        [
            'dest'       => '\Modules\WarehouseManagement\Controller\BackendController:viewStockLocation',
            'verb'       => RouteVerb::GET,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionState::STOCK_LOCATION,
            ],
        ],
    ],
];
