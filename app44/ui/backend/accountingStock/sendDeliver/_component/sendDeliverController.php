<?php

class sendDeliverController extends \f\controller
{

    /**
     *
     * @var \f\slideView
     */
    private $view ;

    public function __construct ()
    {
        require_once 'sendDeliverView.php' ;
        $this->view = new sendDeliverView ;
        parent::__construct () ;
    }

    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'accountingStock.sendDeliver.index',
                    'content'    => $this->view->renderGrid ()
                ) ) ;
    }

    public function sendDeliverList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderSendDeliverGrid ( $requestDataTble ) ) ;
    }

    public function sendDeliverDetail ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'accountingStock.sendDeliver.sendDeliverDetail',
                    'content'    => $this->view->renderSendDeliverDetail ( $this->request->getParam ( 0 ) )
                ) ) ;
    }

    public function sendDeliverSave ()
    {
        //\f\pre($this->request->getAssocParams ());

        return $this->response ( \f\ttt::service ( 'shop.order.orderSave',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function setInputPrice ()
    {
        return $this->response ( array (
                    'content' => $this->view->renderSetInputPrice ( $this->request->getAssocParams () )
                ) ) ;
    }
}
