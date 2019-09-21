<?php

class slideController extends \f\controller
{

    /**
     *
     * @var \f\slideView
     */
    private $view ;

    public function __construct()
    {
        require_once 'slideView.php' ;
        $this->view = new slideView ;
        parent::__construct() ;
    }

      public function index()
    {
        return $this->render(array (
                    'breadcrumb' => 'cms.slide.index',
                    'content'    => $this->view->renderGrid()
                )) ;
    }
    public function slideAdd ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'cms.slide.slideAdd',
                    'content'    => $this->view->renderSlideAdd ()
                ) ) ;
    }
    public function slideSave ()
    {
        return $this->response ( \f\ttt::service ( 'cms.slide.slideSave',
                                                   $this->request->getAssocParams () ) ) ;
    }
    
    public function slideList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderSlideGrid ( $requestDataTble ) ) ;
    }
    public function slideEdit ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'cms.slide.slideEdit',
                    'content'    => $this->view->renderSlideAdd ( $this->request->getParam ( 0 ) )
                ) ) ;
    }
    
    public function slideDelete ()
    {
        return $this->response ( \f\ttt::service ( 'cms.slide.slideDelete',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function slideStatus ()
    {
        return $this->response ( \f\ttt::service ( 'cms.slide.slideStatus',
                                                   $this->request->getAssocParams () ) ) ;
    }


}
