<?php

class customProductRequestController extends \f\controller
{

    /**
     *
     * @var \f\slideView
     */
    private $view ;

    public function __construct ()
    {
        require_once 'customProductRequestView.php';
        $this->view = new customProductRequestView ;
        parent::__construct () ;
    }

    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.customProductRequest.index',
                    'content'    => $this->view->renderGrid ()
                ) ) ;
    }

    public function customProductRequestList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderCustomProductRequestGrid ( $requestDataTble ) ) ;
    }

    public function customProductRequestAdd ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.customProductRequest.customProductRequestAdd',
                    'content'    => $this->view->renderCustomProductRequestAdd ()
                ) ) ;
    }

    public function customProductRequestSave ()
    {
        return $this->response ( \f\ttt::service ( 'shop.customProductRequest.customProductRequestSave',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function customProductRequestEdit ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.customProductRequest.customProductRequestEdit',
                    'content'    => $this->view->renderCustomProductRequestAdd ( $this->request->getParam ( 0 ) )
                ) ) ;
    }

    public function customProductRequestDelete ()
    {
        return $this->response ( \f\ttt::service ( 'shop.customProductRequest.customProductRequestDelete',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function customProductRequestStatus ()
    {
        return $this->response ( \f\ttt::service ( 'shop.customProductRequest.customProductRequestStatus',
                                                   $this->request->getAssocParams () ) ) ;
    }

}
