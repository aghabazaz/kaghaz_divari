<?php

class requestController extends \f\controller
{

    /**
     *
     * @var \f\coreView
     */
    private $view ;

    public function __construct()
    {
        require_once 'requestView.php' ;
        $this->view = new requestView ;
        parent::__construct() ;
    }

    public function index()
    {
       return $this->render(array (
                    'breadcrumb' => 'news.advertisement.request.index',
                    'content'    => $this->view->renderGrid()
                )) ;
    }
    public function requestList ()
    {
       
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderRequestGrid ( $requestDataTble ) ) ;
    }
    public function requestDelete ()
    {
        return $this->response ( \f\ttt::service ( 'news.advertisement.requestDelete',
                                                   $this->request->getAssocParams () ) ) ;
    }
    
   
}
