<?php

class returnedProductController extends \f\controller
{

    /**
     *
     * @var \f\slideView
     */
    private $view ;

    public function __construct ()
    {
        require_once 'returnedProductView.php';
        $this->view = new returnedProductView ;
        parent::__construct () ;
    }

    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'accountingStock.returnedProduct.index',
                    'content'    => $this->view->renderGrid ()
                ) ) ;
    }

    public function returnedProductList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderReturnedProductGrid ( $requestDataTble ) ) ;
    }

    public function returnedProductDetail ()
    {
        //\f\pre('gui');
        return $this->render ( array (
                    'breadcrumb' => 'accountingStock.returnedProduct.returnedProductDetail',
                    'content'    => $this->view->renderReturnedProductDetail ( $this->request->getParam ( 0 ) )
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

}
