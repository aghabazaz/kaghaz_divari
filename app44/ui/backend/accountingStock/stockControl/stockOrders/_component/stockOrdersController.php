<?php

class stockOrdersController extends \f\controller
{

    /**
     *
     * @var \f\slideView
     */
    private $view ;

    public function __construct ()
    {
        require_once 'stockOrdersView.php' ;
        $this->view = new stockOrdersView ;
        parent::__construct () ;
    }

    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'accountingStock.stockControl.stockOrders.index',
                    'content'    => $this->view->renderGrid ()
                ) ) ;
    }

    public function stockOrdersList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderStockOrdersGrid ( $requestDataTble ) ) ;
    }

    public function stockOrdersDetail ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'accountingStock.stockControl.stockOrders.stockOrdersDetail',
                    'content'    => $this->view->renderStockOrdersDetail ( $this->request->getParam ( 0 ) )
                ) ) ;
    }

    public function stockOrdersSave ()
    {
        return $this->response ( \f\ttt::service ( 'shop.order.orderSave',
                                                   $this->request->getAssocParams () ) ) ;
    }


}
