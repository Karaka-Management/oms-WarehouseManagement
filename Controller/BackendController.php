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

use Modules\WarehouseManagement\Models\StockLocationMapper;
use Modules\WarehouseManagement\Models\StockMapper;
use Modules\WarehouseManagement\Models\StockTypeL11nMapper;
use Modules\WarehouseManagement\Models\StockTypeMapper;
use phpOMS\Contract\RenderableInterface;
use phpOMS\Message\RequestAbstract;
use phpOMS\Message\ResponseAbstract;
use phpOMS\Views\View;

/**
 * WarehouseManagement class.
 *
 * @package Modules\WarehouseManagement
 * @license OMS License 2.0
 * @link    https://jingga.app
 * @since   1.0.0
 * @codeCoverageIgnore
 */
final class BackendController extends Controller
{
    /**
     * Routing end-point for application behavior.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return RenderableInterface Returns a renderable object
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewStockTypeList(RequestAbstract $request, ResponseAbstract $response, array $data = []) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);

        $view->setTemplate('/Modules/WarehouseManagement/Theme/Backend/stock-type-list');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1001302001, $request, $response);

        if ($request->getData('ptype') === 'p') {
            $view->data['types'] = StockTypeMapper::getAll()
                    ->with('l11n')
                    ->where('l11n/language', $response->header->l11n->language)
                    ->limit(25)
                    ->execute();
        } elseif ($request->getData('ptype') === 'n') {
            $view->data['types'] = StockTypeMapper::getAll()
                    ->with('l11n')
                    ->where('l11n/language', $response->header->l11n->language)
                    ->limit(25)
                    ->execute();
        } else {
            $view->data['types'] = StockTypeMapper::getAll()
                    ->with('l11n')
                    ->where('l11n/language', $response->header->l11n->language)
                    ->limit(25)
                    ->executeGetArray();
        }

        return $view;
    }

    /**
     * Routing end-point for application behavior.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return RenderableInterface Returns a renderable object
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewStockList(RequestAbstract $request, ResponseAbstract $response, array $data = []) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);

        $view->setTemplate('/Modules/WarehouseManagement/Theme/Backend/stock-list');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1001302001, $request, $response);

        if ($request->getData('ptype') === 'p') {
            $view->data['stocks'] = StockMapper::getAll()
                    ->limit(25)
                    ->execute();
        } elseif ($request->getData('ptype') === 'n') {
            $view->data['stocks'] = StockMapper::getAll()
                    ->limit(25)
                    ->execute();
        } else {
            $view->data['stocks'] = StockMapper::getAll()
                    ->limit(25)
                    ->executeGetArray();
        }

        return $view;
    }

    /**
     * Routing end-point for application behavior.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return RenderableInterface Returns a renderable object
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewStock(RequestAbstract $request, ResponseAbstract $response, array $data = []) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);

        $view->setTemplate('/Modules/WarehouseManagement/Theme/Backend/stock-view');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1001302001, $request, $response);

        $view->data['stock'] = StockMapper::get()
            ->with('locations')
            ->with('locations/type')
            ->with('locations/type/l11n')
            ->where('id', (int) $request->getData('id'))
            ->where('locations/type/l11n/language', [$request->header->l11n->language, null])
            ->execute();

        $view->data['types'] = StockTypeMapper::getAll()
            ->with('l11n')
            ->where('l11n/language', $request->header->l11n->language)
            ->executeGetArray();

        return $view;
    }

    /**
     * Routing end-point for application behavior.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return RenderableInterface Returns a renderable object
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewStockCreate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);

        $view->setTemplate('/Modules/WarehouseManagement/Theme/Backend/stock-view');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1001302001, $request, $response);

        return $view;
    }

    /**
     * Routing end-point for application behavior.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return RenderableInterface Returns a renderable object
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewStockType(RequestAbstract $request, ResponseAbstract $response, array $data = []) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);

        $view->setTemplate('/Modules/WarehouseManagement/Theme/Backend/stock-type-view');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1001302001, $request, $response);

        $view->data['type'] = StockMapper::get()
            ->where('id', (int) $request->getData('id'))->execute();

        $l11nValues = StockTypeL11nMapper::getAll()
            ->with('type')
            ->where('ref', $view->data['type']->id)
            ->executeGetArray();

        $view->data['l11nView']   = new \Web\Backend\Views\L11nView($this->app->l11nManager, $request, $response);
        $view->data['l11nValues'] = $l11nValues;

        return $view;
    }

    /**
     * Routing end-point for application behavior.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return RenderableInterface Returns a renderable object
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewStockTypeCreate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);

        $view->setTemplate('/Modules/WarehouseManagement/Theme/Backend/stock-type-view');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1001302001, $request, $response);

        return $view;
    }

    /**
     * Routing end-point for application behavior.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return RenderableInterface Returns a renderable object
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewStockLocationList(RequestAbstract $request, ResponseAbstract $response, array $data = []) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);

        $view->setTemplate('/Modules/WarehouseManagement/Theme/Backend/stock-location-list');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1001302001, $request, $response);

        $view->data['locations'] = StockLocationMapper::getAll()
            ->with('stock')
            ->with('type')
            ->with('type/l11n')
            ->where('type/l11n/language', [$request->header->l11n->language, null])
            ->limit(25)
            ->executeGetArray();

        return $view;
    }

    /**
     * Routing end-point for application behavior.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return RenderableInterface Returns a renderable object
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewStockLocation(RequestAbstract $request, ResponseAbstract $response, array $data = []) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);

        $view->setTemplate('/Modules/WarehouseManagement/Theme/Backend/stock-location-view');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1001302001, $request, $response);

        $view->data['location'] = StockLocationMapper::get()
            ->with('stock')
            ->with('shelfs')
            ->with('type')
            ->with('type/l11n')
            ->where('type/l11n/language', [$request->header->l11n->language, null])
            ->where('id', (int) $request->getData('id'))
            ->execute();

        $view->data['types'] = StockTypeMapper::getAll()
            ->with('l11n')
            ->where('l11n/language', $request->header->l11n->language)
            ->executeGetArray();

        return $view;
    }

    /**
     * Routing end-point for application behavior.
     *
     * @param RequestAbstract  $request  Request
     * @param ResponseAbstract $response Response
     * @param array            $data     Generic data
     *
     * @return RenderableInterface Returns a renderable object
     *
     * @since 1.0.0
     * @codeCoverageIgnore
     */
    public function viewStockLocationCreate(RequestAbstract $request, ResponseAbstract $response, array $data = []) : RenderableInterface
    {
        $view = new View($this->app->l11nManager, $request, $response);

        $view->setTemplate('/Modules/WarehouseManagement/Theme/Backend/stock-location-view');
        $view->data['nav'] = $this->app->moduleManager->get('Navigation')->createNavigationMid(1001302001, $request, $response);

        $view->data['types'] = StockTypeMapper::getAll()
            ->with('l11n')
            ->where('l11n/language', $request->header->l11n->language)
            ->executeGetArray();

        return $view;
    }
}
