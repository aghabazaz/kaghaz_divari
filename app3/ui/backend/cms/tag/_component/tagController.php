<?php

class tagController extends \f\controller
{

    /**
     *
     * @var \f\coreView
     */
    private $view ;

    public function __construct()
    {
        require_once 'tagView.php' ;
        $this->view = new tagView ;
        parent::__construct() ;
    }

    public function index()
    {
        return $this->render(array (
                    'breadcrumb' => 'cms.tag.index',
                    'content'    => $this->view->renderGrid()
                )) ;
    }
    public function tagAdd ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'cms.tag.tagAdd',
                    'content'    => $this->view->renderTagAdd ()
                ) ) ;
    }
    public function tagSave ()
    {
        return $this->response ( \f\ttt::service ( 'cms.tag.tagSave',
                                                   $this->request->getAssocParams () ) ) ;
    }
    
    public function tagList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderTagGrid ( $requestDataTble ) ) ;
    }
    public function tagEdit ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'cms.tag.tagEdit',
                    'content'    => $this->view->renderTagAdd ( $this->request->getParam ( 0 ) )
                ) ) ;
    }
    
    public function tagDelete ()
    {
        return $this->response ( \f\ttt::service ( 'cms.tag.tagDelete',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function tagStatus ()
    {
        return $this->response ( \f\ttt::service ( 'cms.tag.tagStatus',
                                                   $this->request->getAssocParams () ) ) ;
    }

}
