<?php

class linkcategoryController extends \f\controller
{

    /**
     *
     * @var \f\doctorView
     */
    private $view ;

    public function __construct ()
    {
        require_once 'linkcategoryView.php' ;
        $this->view = new linkcategoryView ;
        parent::__construct () ;
    }

    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'cms.link.linkcategory.index',
                    'content'    => $this->view->renderGrid ()
                ) ) ;
    }

    public function linkcategoryList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderLinkCategoryGrid ( $requestDataTble ) ) ;
    }

    public function linkcategoryStatus ()
    {
        return $this->response ( \f\ttt::service ( 'cms.link.linkcategory.linkcategoryStatus',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function linkcategoryDelete ()
    {
        return $this->response ( \f\ttt::service ( 'cms.link.linkcategory.linkcategoryDelete',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function linkcategoryAdd ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'cms.link.linkcategory.attachmentcategoryAdd',
                    'content'    => $this->view->renderlinkcategoryAdd ()
                ) ) ;
    }

    public function linkcategorySave ()
    {
        $param = $this->request->getAssocParams () ;
        return $this->response ( \f\ttt::service ( 'cms.link.linkcategory.linkcategorySave',
                                                   $param ) ) ;
    }

    public function linkcategoryEdit ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'cms.link.linkcategory.linkcategoryEdit',
                    'content'    => $this->view->renderlinkcategoryAdd ( $this->request->getParam ( 0 ) )
                ) ) ;
    }

}
