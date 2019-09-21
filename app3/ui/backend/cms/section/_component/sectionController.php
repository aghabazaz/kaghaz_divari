<?php

class sectionController extends \f\controller
{

    /**
     *
     * @var \f\coreView
     */
    private $view ;

    public function __construct()
    {
        require_once 'sectionView.php' ;
        $this->view = new sectionView ;
        parent::__construct() ;
    }

    public function index()
    {
        return $this->render(array (
                    'breadcrumb' => 'cms.section.index',
                    'content'    => $this->view->renderGrid()
                )) ;
    }
    public function sectionAdd ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'cms.section.sectionAdd',
                    'content'    => $this->view->renderSectionAdd ()
                ) ) ;
    }
    public function sectionSave ()
    {
        return $this->response ( \f\ttt::service ( 'cms.section.sectionSave',
                                                   $this->request->getAssocParams () ) ) ;
    }
    
    public function sectionList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderSectionGrid ( $requestDataTble ) ) ;
    }
    public function sectionEdit ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'cms.section.sectionEdit',
                    'content'    => $this->view->renderSectionAdd ( $this->request->getParam ( 0 ) )
                ) ) ;
    }
    
    public function sectionDelete ()
    {
        return $this->response ( \f\ttt::service ( 'cms.section.sectionDelete',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function sectionStatus ()
    {
        return $this->response ( \f\ttt::service ( 'cms.section.sectionStatus',
                                                   $this->request->getAssocParams () ) ) ;
    }

}
