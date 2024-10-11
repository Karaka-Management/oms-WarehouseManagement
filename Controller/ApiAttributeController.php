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

namespace Modules\WarehouseManagement\Controller;

use Modules\Attribute\Models\Attribute;
use Modules\Attribute\Models\AttributeType;
use Modules\Attribute\Models\AttributeValue;
use Modules\Attribute\Models\AttributeValueType;
use Modules\Attribute\Models\NullAttributeType;
use Modules\Attribute\Models\NullAttributeValue;
use Modules\WarehouseManagement\Models\Attribute\LotAttributeMapper;
use Modules\WarehouseManagement\Models\Attribute\LotAttributeTypeL11nMapper;
use Modules\WarehouseManagement\Models\Attribute\LotAttributeTypeMapper;
use Modules\WarehouseManagement\Models\Attribute\LotAttributeValueL11nMapper;
use Modules\WarehouseManagement\Models\Attribute\LotAttributeValueMapper;
use phpOMS\Localization\BaseStringL11n;
use phpOMS\Localization\ISO639x1Enum;
use phpOMS\Message\Http\RequestStatusCode;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;

/**
 * WarehouseManagement class.
 *
 * @package Modules\WarehouseManagement
 * @license OMS License 2.2
 * @link    https://jingga.app
 * @since   1.0.0
 */
final class ApiAttributeController extends Controller
{
    /**
     * Api method to create Attribute
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
    public function apiLotAttributeCreate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateLotAttributeCreate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidCreateResponse($request, $response, $val);

            return;
        }

        $attribute = $this->createLotAttributeFromRequest($request);
        $this->createModel($request->header->account, $attribute, LotAttributeMapper::class, 'attribute', $request->getOrigin());
        $this->createStandardCreateResponse($request, $response, $attribute);
    }

    /**
     * Method to create lot attribute from request.
     *
     * @param RequestAbstract $request Request
     *
     * @return Attribute
     *
     * @since 1.0.0
     */
    private function createLotAttributeFromRequest(RequestAbstract $request) : Attribute
    {
        $attribute       = new Attribute();
        $attribute->ref  = (int) $request->getData('ref');
        $attribute->type = new NullAttributeType((int) $request->getData('type'));

        if ($request->hasData('value_id')) {
            $attribute->value = new NullAttributeValue((int) $request->getData('value_id'));
        } else {
            $newRequest = clone $request;
            $newRequest->setData('value', $request->getData('value'), true);

            $value = $this->createLotAttributeValueFromRequest($newRequest);

            $attribute->value = $value;
        }

        return $attribute;
    }

    /**
     * Validate lot attribute create request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
     */
    private function validateLotAttributeCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['type'] = !$request->hasData('type'))
            || ($val['value'] = (!$request->hasData('value') && !$request->hasData('value_id')))
            || ($val['lot'] = !$request->hasData('lot'))
        ) {
            return $val;
        }

        return [];
    }

    /**
     * Api method to create lot attribute l11n
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
    public function apiLotAttributeTypeL11nCreate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateLotAttributeTypeL11nCreate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidCreateResponse($request, $response, $val);

            return;
        }

        $attrL11n = $this->createLotAttributeTypeL11nFromRequest($request);
        $this->createModel($request->header->account, $attrL11n, LotAttributeTypeL11nMapper::class, 'attr_type_l11n', $request->getOrigin());
        $this->createStandardCreateResponse($request, $response, $attrL11n);
    }

    /**
     * Method to create lot attribute l11n from request.
     *
     * @param RequestAbstract $request Request
     *
     * @return BaseStringL11n
     *
     * @since 1.0.0
     */
    private function createLotAttributeTypeL11nFromRequest(RequestAbstract $request) : BaseStringL11n
    {
        $attrL11n           = new BaseStringL11n();
        $attrL11n->ref      = $request->getDataInt('ref') ?? 0;
        $attrL11n->language = ISO639x1Enum::tryFromValue($request->getDataString('language')) ?? $request->header->l11n->language;
        $attrL11n->content  = $request->getDataString('content') ?? '';

        return $attrL11n;
    }

    /**
     * Validate lot attribute l11n create request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
     */
    private function validateLotAttributeTypeL11nCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['content'] = !$request->hasData('content'))
            || ($val['ref'] = !$request->hasData('ref'))
        ) {
            return $val;
        }

        return [];
    }

    /**
     * Api method to create lot attribute type
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
    public function apiLotAttributeTypeCreate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateLotAttributeTypeCreate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidCreateResponse($request, $response, $val);

            return;
        }

        $attrType = $this->createLotAttributeTypeFromRequest($request);
        $this->createModel($request->header->account, $attrType, LotAttributeTypeMapper::class, 'attr_type', $request->getOrigin());
        $this->createStandardCreateResponse($request, $response, $attrType);
    }

    /**
     * Method to create lot attribute from request.
     *
     * @param RequestAbstract $request Request
     *
     * @return AttributeType
     *
     * @since 1.0.0
     */
    private function createLotAttributeTypeFromRequest(RequestAbstract $request) : AttributeType
    {
        $attrType                    = new AttributeType($request->getDataString('name') ?? '');
        $attrType->datatype          = AttributeValueType::tryFromValue($request->getDataInt('datatype')) ?? AttributeValueType::_STRING;
        $attrType->custom            = $request->getDataBool('custom') ?? false;
        $attrType->isRequired        = $request->getDataBool('is_required') ?? false;
        $attrType->validationPattern = $request->getDataString('validation_pattern') ?? '';
        $attrType->setL11n(
            $request->getDataString('content') ?? '',
            ISO639x1Enum::tryFromValue($request->getDataString('language')) ?? ISO639x1Enum::_EN
        );
        $attrType->setFields($request->getDataInt('fields') ?? 0);

        return $attrType;
    }

    /**
     * Validate lot attribute create request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
     */
    private function validateLotAttributeTypeCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['content'] = !$request->hasData('content'))
            || ($val['name'] = !$request->hasData('name'))
        ) {
            return $val;
        }

        return [];
    }

    /**
     * Api method to create lot attribute value
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
    public function apiLotAttributeValueCreate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateLotAttributeValueCreate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidCreateResponse($request, $response, $val);

            return;
        }

        $attrValue = $this->createLotAttributeValueFromRequest($request);
        $this->createModel($request->header->account, $attrValue, LotAttributeValueMapper::class, 'attr_value', $request->getOrigin());

        if ($attrValue->isDefault) {
            $this->createModelRelation(
                $request->header->account,
                (int) $request->getData('type'),
                $attrValue->id,
                LotAttributeTypeMapper::class, 'defaults', '', $request->getOrigin()
            );
        }

        $this->createStandardCreateResponse($request, $response, $attrValue);
    }

    /**
     * Method to create lot attribute value from request.
     *
     * @param RequestAbstract $request Request
     *
     * @return AttributeValue
     *
     * @since 1.0.0
     */
    private function createLotAttributeValueFromRequest(RequestAbstract $request) : AttributeValue
    {
        /** @var \Modules\Attribute\Models\AttributeType $type */
        $type = LotAttributeTypeMapper::get()
            ->where('id', $request->getDataInt('type') ?? 0)
            ->execute();

        $attrValue            = new AttributeValue();
        $attrValue->isDefault = $request->getDataBool('default') ?? false;
        $attrValue->setValue($request->getDataString('value'), $type->datatype);

        if ($request->hasData('content')) {
            $attrValue->setL11n(
                $request->getDataString('content') ?? '',
                ISO639x1Enum::tryFromValue($request->getDataString('language')) ?? ISO639x1Enum::_EN
            );
        }

        return $attrValue;
    }

    /**
     * Validate lot attribute value create request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
     */
    private function validateLotAttributeValueCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['type'] = !$request->hasData('type'))
            || ($val['value'] = !$request->hasData('value'))
        ) {
            return $val;
        }

        return [];
    }

    /**
     * Api method to create lot attribute l11n
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
    public function apiLotAttributeValueL11nCreate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : void
    {
        if (!empty($val = $this->validateLotAttributeValueL11nCreate($request))) {
            $response->header->status = RequestStatusCode::R_400;
            $this->createInvalidCreateResponse($request, $response, $val);

            return;
        }

        $attrL11n = $this->createLotAttributeValueL11nFromRequest($request);
        $this->createModel($request->header->account, $attrL11n, LotAttributeValueL11nMapper::class, 'attr_value_l11n', $request->getOrigin());
        $this->createStandardCreateResponse($request, $response, $attrL11n);
    }

    /**
     * Method to create lot attribute l11n from request.
     *
     * @param RequestAbstract $request Request
     *
     * @return BaseStringL11n
     *
     * @since 1.0.0
     */
    private function createLotAttributeValueL11nFromRequest(RequestAbstract $request) : BaseStringL11n
    {
        $attrL11n           = new BaseStringL11n();
        $attrL11n->ref      = $request->getDataInt('ref') ?? 0;
        $attrL11n->language = ISO639x1Enum::tryFromValue($request->getDataString('language')) ?? $request->header->l11n->language;
        $attrL11n->content  = $request->getDataString('content') ?? '';

        return $attrL11n;
    }

    /**
     * Validate lot attribute l11n create request
     *
     * @param RequestAbstract $request Request
     *
     * @return array<string, bool>
     *
     * @since 1.0.0
     */
    private function validateLotAttributeValueL11nCreate(RequestAbstract $request) : array
    {
        $val = [];
        if (($val['title'] = !$request->hasData('title'))
            || ($val['value'] = !$request->hasData('value'))
        ) {
            return $val;
        }

        return [];
    }
}
