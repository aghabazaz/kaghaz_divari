<?php

class guaranteeController extends \f\controller
{

    /**
     *
     * @var \f\slideView
     */
    private $view ;

    public function __construct ()
    {
        require_once 'guaranteeView.php' ;
        $this->view = new guaranteeView ;
        parent::__construct () ;
    }

    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.guarantee.index',
                    'content'    => $this->view->renderGrid ()
                ) ) ;
    }

    public function guaranteeList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderGuaranteeGrid ( $requestDataTble ) ) ;
    }

    public function guaranteeAdd ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.guarantee.guaranteeAdd',
                    'content'    => $this->view->renderGuaranteeAdd ()
                ) ) ;
    }

    public function guaranteeSave ()
    {
        return $this->response ( \f\ttt::service ( 'shop.guarantee.guaranteeSave',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function guaranteeEdit ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.guarantee.guaranteeEdit',
                    'content'    => $this->view->renderGuaranteeAdd ( $this->request->getParam ( 0 ) )
                ) ) ;
    }

    public function guaranteeDelete ()
    {
        return $this->response ( \f\ttt::service ( 'shop.guarantee.guaranteeDelete',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function guaranteeStatus ()
    {
        return $this->response ( \f\ttt::service ( 'shop.guarantee.guaranteeStatus',
                                                   $this->request->getAssocParams () ) ) ;
    }

}
