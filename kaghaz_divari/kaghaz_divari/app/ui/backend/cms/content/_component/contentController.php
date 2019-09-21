<?php

class contentController extends \f\controller
{

    /**
     *
     * @var \f\coreView
     */
    private $view ;

    public function __construct()
    {
        require_once 'contentView.php' ;
        $this->view = new contentView ;
        parent::__construct() ;
    }

    public function index()
    {
        return $this->render(array (
                    'breadcrumb' => 'cms.content.index',
                    'content'    => $this->view->renderContentList()
                )) ;
    }
    public function contentAdd ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'cms.content.contentAdd',
                    'content'    => $this->view->renderContentAdd ()
                ) ) ;
    }
    
     public function contentSave ()
    {
        return $this->response ( \f\ttt::service ( 'cms.content.contentSave',
                                                   $this->request->getAssocParams () ) ) ;
    }
    
    public function contentList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderContentGrid ( $requestDataTble ) ) ;
    }
    public function contentEdit ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'cms.content.contentEdit',
                    'content'    => $this->view->renderContentAdd ( $this->request->getParam ( 0 ) )
                ) ) ;
    }
    
    public function contentDelete ()
    {
        return $this->response ( \f\ttt::service ( 'cms.content.contentDelete',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function contentStatus ()
    {
        return $this->response ( \f\ttt::service ( 'cms.content.contentStatus',
                                                   $this->request->getAssocParams () ) ) ;
    }
    public function contentSpecial ()
    {
        return $this->response ( \f\ttt::service ( 'cms.content.contentSpecial',
                                                   $this->request->getAssocParams () ) ) ;
    }
    
   
    

}

