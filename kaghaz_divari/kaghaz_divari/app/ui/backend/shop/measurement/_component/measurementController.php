<?php

class measurementController extends \f\controller
{

    /**
     *
     * @var \f\cmsView
     */
    private $view ;

    public function __construct ()
    {
        require_once 'measurementView.php';
        $this->view = new measurementView ;
        parent::__construct () ;
    }

    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.measurement.index',
                    'content'    => $this->view->renderGrid ()
                ) ) ;
    }

    public function measurementList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderMeasurementGrid ( $requestDataTble ) ) ;
    }

    public function measurementAdd ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.measurement.measurementAdd',
                    'content'    => $this->view->renderMeasurementAdd ()
        ));
    }

    public function measurementSave ()
    {
        return $this->response ( \f\ttt::service ( 'shop.measurement.measurementSave',
            $this->request->getAssocParams () ) ) ;
    }

    public function measurementEdit ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.measurement.measurementEdit',
                    'content'    => $this->view->renderMeasurementAdd ( $this->request->getParam ( 0 ) )
                ) ) ;
    }

    public function measurementStatus ()
    {
        return $this->response ( \f\ttt::service ( 'shop.measurement.measurementStatus',
            $this->request->getAssocParams () ) ) ;
    }

    public function measurementDelete ()
    {
        return $this->response ( \f\ttt::service ( 'shop.measurement.measurementDelete',
            $this->request->getAssocParams () ) ) ;
    }
}
