<?php

class makerController extends \f\controller
{

    /**
     *
     * @var \f\slideView
     */
    private $view ;

    public function __construct ()
    {
        require_once 'makerView.php' ;
        $this->view = new makerView ;
        parent::__construct () ;
    }

    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.maker.index',
                    'content'    => $this->view->renderGrid ()
                ) ) ;
    }

    public function makerList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderMakerGrid ( $requestDataTble ) ) ;
    }

    public function makerAdd ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.maker.makerAdd',
                    'content'    => $this->view->renderMakerAdd ()
                ) ) ;
    }

    public function makerSave ()
    {
        return $this->response ( \f\ttt::service ( 'shop.maker.makerSave',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function makerEdit ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.maker.makerEdit',
                    'content'    => $this->view->renderMakerAdd ( $this->request->getParam ( 0 ) )
                ) ) ;
    }

    public function makerDelete ()
    {
        return $this->response ( \f\ttt::service ( 'shop.maker.makerDelete',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function makerStatus ()
    {
        return $this->response ( \f\ttt::service ( 'shop.maker.makerStatus',
                                                   $this->request->getAssocParams () ) ) ;
    }

}
