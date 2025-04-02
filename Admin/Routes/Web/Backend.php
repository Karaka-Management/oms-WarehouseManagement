<?php
/**
 * Jingga
 *
 * PHP Version 8.2
 *
 * @package   Modules\WarehouseManagement
 * @copyright Dennis Eichhorn
 * @license   OMS License 2.2
 * @version   1.0.0
 * @link      https://jingga.app
 */
declare(strict_types=1);

use Modules\WarehouseManagement\Controller\BackendController;
use Modules\WarehouseManagement\Models\PermissionCategory;
use phpOMS\Account\PermissionType;
use phpOMS\Router\RouteVerb;

return [
    '^/warehouse/stock/list(\?.*$|$)' => [
        [
            'dest'       => '\Modules\WarehouseManagement\Controller\BackendController:viewStockList',
            'verb'       => RouteVerb::GET,
            'active'     => true,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::STOCK,
            ],
        ],
    ],
    '^/warehouse/stock/view(\?.*$|$)' => [
        [
            'dest'       => '\Modules\WarehouseManagement\Controller\BackendController:viewStock',
            'verb'       => RouteVerb::GET,
            'active'     => true,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::STOCK,
            ],
        ],
    ],
    '^/warehouse/stock/create(\?.*$|$)' => [
        [
            'dest'       => '\Modules\WarehouseManagement\Controller\BackendController:viewStockCreate',
            'verb'       => RouteVerb::GET,
            'active'     => true,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::CREATE,
                'state'  => PermissionCategory::STOCK,
            ],
        ],
    ],
    '^/warehouse/stock/type/list(\?.*$|$)' => [
        [
            'dest'       => '\Modules\WarehouseManagement\Controller\BackendController:viewStockTypeList',
            'verb'       => RouteVerb::GET,
            'active'     => true,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::STOCK,
            ],
        ],
    ],
    '^/warehouse/stock/type/view(\?.*$|$)' => [
        [
            'dest'       => '\Modules\WarehouseManagement\Controller\BackendController:viewStockType',
            'verb'       => RouteVerb::GET,
            'active'     => true,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::STOCK,
            ],
        ],
    ],
    '^/warehouse/stock/type/create(\?.*$|$)' => [
        [
            'dest'       => '\Modules\WarehouseManagement\Controller\BackendController:viewStockTypeCreate',
            'verb'       => RouteVerb::GET,
            'active'     => true,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::CREATE,
                'state'  => PermissionCategory::STOCK,
            ],
        ],
    ],
    '^/warehouse/stock/location/list(\?.*$|$)' => [
        [
            'dest'       => '\Modules\WarehouseManagement\Controller\BackendController:viewStockLocationList',
            'verb'       => RouteVerb::GET,
            'active'     => true,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::STOCK_LOCATION,
            ],
        ],
    ],
    '^/warehouse/stock/location/view(\?.*$|$)' => [
        [
            'dest'       => '\Modules\WarehouseManagement\Controller\BackendController:viewStockLocation',
            'verb'       => RouteVerb::GET,
            'active'     => true,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::STOCK_LOCATION,
            ],
        ],
    ],
    '^/warehouse/stock/location/create(\?.*$|$)' => [
        [
            'dest'       => '\Modules\WarehouseManagement\Controller\BackendController:viewStockLocationCreate',
            'verb'       => RouteVerb::GET,
            'active'     => true,
            'permission' => [
                'module' => BackendController::NAME,
                'type'   => PermissionType::READ,
                'state'  => PermissionCategory::STOCK_LOCATION,
            ],
        ],
    ],
];
