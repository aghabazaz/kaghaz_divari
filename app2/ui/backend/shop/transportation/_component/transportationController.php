<?php

class transportationController extends \f\controller
{

    /**
     *
     * @var \f\slideView
     */
    private $view ;

    public function __construct ()
    {
        require_once 'transportationView.php' ;
        $this->view = new transportationView ;
        parent::__construct () ;
    }

    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.transportation.index',
                    'content'    => $this->view->renderGrid ()
                ) ) ;
    }

    public function transportationList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderTransportationGrid ( $requestDataTble ) ) ;
    }

    public function transportationAdd ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.transportation.transportationAdd',
                    'content'    => $this->view->renderTransportationAdd ()
                ) ) ;
    }

    public function transportationSave ()
    {
        return $this->response ( \f\ttt::service ( 'shop.transportation.transportationSave',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function transportationEdit ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.transportation.transportationEdit',
                    'content'    => $this->view->renderTransportationAdd ( $this->request->getParam ( 0 ) )
                ) ) ;
    }

    public function transportationDelete ()
    {
        return $this->response ( \f\ttt::service ( 'shop.transportation.transportationDelete',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function transportationStatus ()
    {
        return $this->response ( \f\ttt::service ( 'shop.transportation.transportationStatus',
                                                   $this->request->getAssocParams () ) ) ;
    }

}
