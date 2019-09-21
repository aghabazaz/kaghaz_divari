<?php

class itemsController extends \f\controller
{

    /**
     *
     * @var \f\coreView
     */
    private $view ;

    public function __construct()
    {
        require_once 'itemsView.php' ;
        $this->view = new itemsView ;
        parent::__construct() ;
    }

    public function index()
    {
       return $this->render(array (
                    'breadcrumb' => 'cms.advertisement.items.index',
                    'content'    => $this->view->renderGrid()
                )) ;
    }
     public function itemsAdd ()
    {
       
        return $this->render ( array (
                    'breadcrumb' => 'cms.advertisement.items.itemsAdd',
                    'content'    => $this->view->renderItemsAdd ()
                ) ) ;
    }
    public function itemsSave ()
    {
        return $this->response ( \f\ttt::service ( 'cms.advertisement.advertisementSave',
                                                   $this->request->getAssocParams () ) ) ;
    }
    
    public function itemsList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderItemsGrid ( $requestDataTble ) ) ;
    }
    public function itemsEdit ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'cms.advertisement.items.itemsEdit',
                    'content'    => $this->view->renderItemsAdd ( $this->request->getParam ( 0 ) )
                ) ) ;
    }
    
    public function itemsDelete ()
    {
        return $this->response ( \f\ttt::service ( 'cms.advertisement.advertisementDelete',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function itemsStatus ()
    {
        return $this->response ( \f\ttt::service ( 'cms.advertisement.advertisementStatus',
                                                   $this->request->getAssocParams () ) ) ;
    }
    
   
}
