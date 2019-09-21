<?php

class newsController extends \f\controller
{

    /**
     *
     * @var \f\coreView
     */
    private $view ;

    public function __construct()
    {
        require_once 'newsView.php' ;
        $this->view = new newsView ;
        parent::__construct() ;
    }

    public function index()
    {
        return $this->render(array (
                    'breadcrumb' => 'cms.news.index',
                    'content'    => $this->view->renderContentList()
                )) ;
    }
    public function newsAdd ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'cms.news.newsAdd',
                    'content'    => $this->view->renderContentAdd ()
                ) ) ;
    }
    
     public function newsSave ()
    {
        return $this->response ( \f\ttt::service ( 'cms.news.newsSave',
                                                   $this->request->getAssocParams () ) ) ;
    }
    
    public function newsList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderContentGrid ( $requestDataTble ) ) ;
    }
    public function newsEdit ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'cms.news.newsEdit',
                    'content'    => $this->view->renderContentAdd ( $this->request->getParam ( 0 ) )
                ) ) ;
    }
    
    public function newsDelete ()
    {
        return $this->response ( \f\ttt::service ( 'cms.news.newsDelete',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function newsStatus ()
    {
        return $this->response ( \f\ttt::service ( 'cms.news.newsStatus',
                                                   $this->request->getAssocParams () ) ) ;
    }
    
   
    

}

