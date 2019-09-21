<?php

class creditSettlementController extends \f\controller
{

    /**
     *
     * @var \f\slideView
     */
    private $view ;

    public function __construct ()
    {
        require_once 'creditSettlementView.php';
        $this->view = new creditSettlementView ;
        parent::__construct () ;
    }

    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'member.creditSettlement.index',
                    'content'    => $this->view->renderGrid ()
                ) ) ;
    }

    public function returnedCreditSettlementList ()
    {
       // \f\pre('sdf');
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderCreditSettlementGrid ( $requestDataTble ) ) ;
    }

    public function returnedCreditSettlementDetails ()
    {

        return $this->render ( array (
                    'breadcrumb' => 'member.creditSettlement.renderReturnedCreditSettlementDetail',
                    'content'    => $this->view->renderReturnedCreditSettlementDetail ( $this->request->getParam ( 0 ) )
                ) ) ;
    }

    public function returnedProductSave ()
    {
        return $this->response ( \f\ttt::service ( 'shop.order.orderSave',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function setInputPrice ()
    {
        return $this->response ( array (
                    'content' => $this->view->renderSetInputPrice ( $this->request->getAssocParams () )
                ) ) ;
    }
    public function creditSettlementFun(){
        //\f\pre('sdf');
        return $this->response (\f\ttt::dal ( 'shop.order.creditSettlement',
            $this->request->getAssocParams () ) );

    }

}
