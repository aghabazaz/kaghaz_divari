<?php

class amazingController extends \f\controller
{

    /**
     *
     * @var \f\slideView
     */
    private $view ;

    public function __construct ()
    {
        require_once 'amazingView.php' ;
        $this->view = new amazingView ;
        parent::__construct () ;
    }

    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.amazing.index',
                    'content'    => $this->view->renderGrid ()
                ) ) ;
    }

    public function amazingList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderAmazingGrid ( $requestDataTble ) ) ;
    }

    public function amazingAdd ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.amazing.amazingAdd',
                    'content'    => $this->view->renderAmazingAdd ()
                ) ) ;
    }

    public function amazingSave ()
    {
        return $this->response ( \f\ttt::service ( 'shop.amazing.amazingSave',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function amazingEdit ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.amazing.amazingEdit',
                    'content'    => $this->view->renderAmazingAdd ( $this->request->getParam ( 0 ) )
                ) ) ;
    }

    public function amazingDelete ()
    {
        return $this->response ( \f\ttt::service ( 'shop.amazing.amazingDelete',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function amazingStatus ()
    {
        return $this->response ( \f\ttt::service ( 'shop.amazing.amazingStatus',
                                                   $this->request->getAssocParams () ) ) ;
    }

}
