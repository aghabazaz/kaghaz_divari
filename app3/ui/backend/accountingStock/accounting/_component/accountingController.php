<?php

class accountingController extends \f\controller
{

    /**
     *
     * @var \f\slideView
     */
    private $view ;

    public function __construct ()
    {
        require_once 'accountingView.php' ;
        $this->view = new accountingView ;
        parent::__construct () ;
    }

    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'accountingStock.accounting.index',
                    'content'    => $this->view->renderGrid ()
                ) ) ;
    }

    public function accountingList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderAccountingGrid ( $requestDataTble ) ) ;
    }

    public function accountingDetail ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'accountingStock.accounting.accountingDetail',
                    'content'    => $this->view->renderAccountingDetail ( $this->request->getParam ( 0 ) )
                ) ) ;
    }

    public function accountingSave ()
    {
        return $this->response ( \f\ttt::service ( 'shop.order.orderSave',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function accountingDelete ()
    {
        return $this->response ( \f\ttt::service ( 'shop.order.orderDelete',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function orderItemDelete ()
    {
        $params = $this->request->getAssocParams () ;

        $result = \f\ttt::service ( 'shop.orderItem.orderItemDelete', $params ) ;
        return $this->response ( array (
                    'result' => $result
                ) ) ;
    }

}
