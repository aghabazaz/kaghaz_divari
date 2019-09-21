<?php

class stateController extends \f\controller
{

    /**
     *
     * @var \f\stateView
     */
    private $view ;

    public function __construct()
    {
        require_once 'stateView.php' ;
        $this->view = new stateView ;
        parent::__construct() ;
    }

     public function index()
    {
        return $this->render(array (
                    'breadcrumb' => 'cms.place.state.index',
                    'content'    => $this->view->renderGrid()
                )) ;
    }
    public function stateAdd ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'cms.place.state.stateAdd',
                    'content'    => $this->view->renderStateAdd ()
                ) ) ;
    }
    public function stateSave ()
    {
        return $this->response ( \f\ttt::service ( 'cms.place.state.stateSave',
                                                   $this->request->getAssocParams () ) ) ;
    }
    
    public function stateList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderStateGrid ( $requestDataTble ) ) ;
    }
    public function stateEdit ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'cms.place.state.stateEdit',
                    'content'    => $this->view->renderStateAdd ( $this->request->getParam ( 0 ) )
                ) ) ;
    }
    
    public function stateDelete ()
    {
        return $this->response ( \f\ttt::service ( 'cms.place.state.stateDelete',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function stateStatus ()
    {
        return $this->response ( \f\ttt::service ( 'cms.place.state.stateStatus',
                                                   $this->request->getAssocParams () ) ) ;
    }


}
