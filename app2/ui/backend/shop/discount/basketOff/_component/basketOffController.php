<?php

class basketOffController extends \f\controller
{

    /**
     *
     * @var \f\cmsView
     */
    private $view ;

    public function __construct ()
    {
        require_once 'basketOffView.php';
        $this->view = new basketOffView ;
        parent::__construct () ;
    }

    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.discount.basketOff.index',
                    'content'    => $this->view->renderGrid ()
                ) ) ;
    }

    public function basketOffList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderBasketOffGrid ( $requestDataTble ) ) ;
    }

    public function basketOffAdd ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.discount.basketOff.basketOffAdd',
                    'content'    => $this->view->renderBasketOffAdd ()
        ));
    }

    public function basketOffSave ()
    {
        return $this->response ( \f\ttt::service ( 'shop.discount.basketOff.basketOffSave',
            $this->request->getAssocParams () ) ) ;
    }

    public function basketOffEdit ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.discount.basketOff.basketOffEdit',
                    'content'    => $this->view->renderBasketOffAdd ( $this->request->getParam ( 0 ) )
                ) ) ;
    }

    public function basketOffStatus ()
    {
        return $this->response ( \f\ttt::service ( 'shop.discount.basketOff.basketOffStatus',
            $this->request->getAssocParams () ) ) ;
    }

    public function basketOffDelete ()
    {
        return $this->response ( \f\ttt::service ( 'shop.discount.basketOff.basketOffDelete',
            $this->request->getAssocParams () ) ) ;
    }
}
