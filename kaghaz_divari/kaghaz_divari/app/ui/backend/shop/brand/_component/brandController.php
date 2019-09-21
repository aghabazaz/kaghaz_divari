<?php

class brandController extends \f\controller
{

    /**
     *
     * @var \f\slideView
     */
    private $view ;

    public function __construct ()
    {
        require_once 'brandView.php' ;
        $this->view = new brandView ;
        parent::__construct () ;
    }

    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.brand.index',
                    'content'    => $this->view->renderGrid ()
                ) ) ;
    }

    public function brandList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderBrandGrid ( $requestDataTble ) ) ;
    }

    public function brandAdd ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.brand.brandAdd',
                    'content'    => $this->view->renderBrandAdd ()
                ) ) ;
    }

    public function brandSave ()
    {
        return $this->response ( \f\ttt::service ( 'shop.brand.brandSave',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function brandEdit ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.brand.brandEdit',
                    'content'    => $this->view->renderBrandAdd ( $this->request->getParam ( 0 ) )
                ) ) ;
    }

    public function brandDelete ()
    {
        return $this->response ( \f\ttt::service ( 'shop.brand.brandDelete',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function brandStatus ()
    {
        return $this->response ( \f\ttt::service ( 'shop.brand.brandStatus',
                                                   $this->request->getAssocParams () ) ) ;
    }

}
