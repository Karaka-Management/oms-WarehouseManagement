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

use Modules\WarehouseManagement\Models\StockType;
use Modules\WarehouseManagement\Models\StockTypeL11nMapper;
use Modules\WarehouseManagement\Models\StockTypeMapper;
use phpOMS\Localization\BaseStringL11n;
use phpOMS\Localization\ISO639x1Enum;
use phpOMS\Message\Http\RequestStatusCode;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;

/**
 * Warehouse class.
 *
 * @package Modules\WarehouseManagement
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 */
final class ApiStockTypeController extends Controller
{
    /**
     * Api method to create item stock type
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiStockTypeCreate(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        if (!empty($val = $this->validateStockTypeCreate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidCreateResponse($request, $response, $val);

            return;
        }

        $stockType = $this->createStockTypeFromRequest($request);
        $this->createModel($request->header->account, $stockType, StockTypeMapper::class, 'stock_type', $request->getOrigin());
        $this->createStandardCreateResponse($request, $response, $stockType);
    }

    /**
     * Method to create item attribute from request.
     *
     * @param RequestAbstract $request Request
     *
     * @return StockType
     *
     * @since 1.0.0
     */
    private function createStockTypeFromRequest(RequestAbstract $request) : StockType
    {
        $stockType       = new StockType();
        $stockType->name = $request->getDataString('name') ?? '';
        $stockType->setL11n($request->getDataString('title') ?? '', $request->getDataString('language') ?? ISO639x1Enum::_EN);

        return $stockType;
    }

    /**
     * Validate item attribute create request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
     */
    private function validateStockTypeCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['title'] = !$request->hasData('title'))
            || ($val['name'] = !$request->hasData('name'))
        ) {
            return $val;
        }

        return [];
    }

    /**
     * Api method to create item attribute l11n
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param mixed            $data     Generic data
     *
     * @return void
     *
     * @api
     *
     * @since 1.0.0
     */
    public function apiStockTypeL11nCreate(RequestAbstract $request, ResponseAbstract $response, mixed $data = null) : void
    {
        if (!empty($val = $this->validateStockTypeL11nCreate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidCreateResponse($request, $response, $val);

            return;
        }

        $stockTypeL11n = $this->createStockTypeL11nFromRequest($request);
        $this->createModel($request->header->account, $stockTypeL11n, StockTypeL11nMapper::class, 'stock_type_l11n', $request->getOrigin());
        $this->createStandardCreateResponse($request, $response, $stockTypeL11n);
    }

    /**
     * Method to create item attribute l11n from request.
     *
     * @param RequestAbstract $request Request
     *
     * @return BaseStringL11n
     *
     * @since 1.0.0
     */
    private function createStockTypeL11nFromRequest(RequestAbstract $request) : BaseStringL11n
    {
        $stockTypeL11n      = new BaseStringL11n();
        $stockTypeL11n->ref = $request->getDataInt('type') ?? 0;
        $stockTypeL11n->setLanguage(
            $request->getDataString('language') ?? $request->header->l11n->language
        );
        $stockTypeL11n->content = $request->getDataString('title') ?? '';

        return $stockTypeL11n;
    }

    /**
     * Validate item attribute l11n create request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
     */
    private function validateStockTypeL11nCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['title'] = !$request->hasData('title'))
            || ($val['type'] = !$request->hasData('type'))
        ) {
            return $val;
        }

        return [];
    }
}
