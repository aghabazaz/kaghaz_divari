<?php

class textTemplateController extends \f\controller
{

    /**
     *
     * @var \f\textTemplateView
     */
    private $view ;

    public function __construct()
    {
        require_once 'textTemplateView.php' ;
        $this->view = new textTemplateView ;
        parent::__construct() ;
    }

      public function index()
    {
        return $this->render(array (
                    'breadcrumb' => 'cms.textTemplate.index',
                    'content'    => $this->view->renderGrid()
                )) ;
    }
    public function textTemplateAdd ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'cms.textTemplate.textTemplateAdd',
                    'content'    => $this->view->renderTextTemplateAdd ()
                ) ) ;
    }
    public function textTemplateSave ()
    {
        return $this->response ( \f\ttt::service ( 'cms.textTemplate.textTemplateSave',
                                                   $this->request->getAssocParams () ) ) ;
    }
    
    public function textTemplateList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderTextTemplateGrid ( $requestDataTble ) ) ;
    }
    public function textTemplateEdit ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'cms.textTemplate.textTemplateEdit',
                    'content'    => $this->view->renderTextTemplateAdd ( $this->request->getParam ( 0 ) )
                ) ) ;
    }
    
    public function textTemplateDelete ()
    {
        return $this->response ( \f\ttt::service ( 'cms.textTemplate.textTemplateDelete',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function textTemplateStatus ()
    {
        return $this->response ( \f\ttt::service ( 'cms.textTemplate.textTemplateStatus',
                                                   $this->request->getAssocParams () ) ) ;
    }


}
