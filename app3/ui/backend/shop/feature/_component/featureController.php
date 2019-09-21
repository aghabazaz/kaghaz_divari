<?php

class featureController extends \f\controller
{

    /**
     *
     * @var \f\slideView
     */
    private $view ;

    public function __construct ()
    {
        require_once 'featureView.php' ;
        $this->view = new featureView ;
        parent::__construct () ;
    }

    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.feature.index',
                    'content'    => $this->view->renderGrid ()
                ) ) ;
    }

    public function featureList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderFeatureGrid ( $requestDataTble ) ) ;
    }

    public function featureAdd ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.feature.featureAdd',
                    'content'    => $this->view->renderFeatureAdd ()
                ) ) ;
    }

    public function featureSave ()
    {
        return $this->response ( \f\ttt::service ( 'shop.feature.featureSave',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function featureEdit ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.feature.featureEdit',
                    'content'    => $this->view->renderFeatureAdd ( $this->request->getParam ( 0 ) )
                ) ) ;
    }

    public function featureDelete ()
    {
        return $this->response ( \f\ttt::service ( 'shop.feature.featureDelete',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function featureStatus ()
    {
        return $this->response ( \f\ttt::service ( 'shop.feature.featureStatus',
                                                   $this->request->getAssocParams () ) ) ;
    }

}
