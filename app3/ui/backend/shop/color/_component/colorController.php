<?php

class colorController extends \f\controller
{

    /**
     *
     * @var \f\slideView
     */
    private $view ;

    public function __construct ()
    {
        require_once 'colorView.php' ;
        $this->view = new colorView ;
        parent::__construct () ;
    }

    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.color.index',
                    'content'    => $this->view->renderGrid ()
                ) ) ;
    }

    public function colorList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderColorGrid ( $requestDataTble ) ) ;
    }

    public function colorAdd ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.color.colorAdd',
                    'content'    => $this->view->renderColorAdd ()
                ) ) ;
    }

    public function colorSave ()
    {
        return $this->response ( \f\ttt::service ( 'shop.color.colorSave',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function colorEdit ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.color.colorEdit',
                    'content'    => $this->view->renderColorAdd ( $this->request->getParam ( 0 ) )
                ) ) ;
    }

    public function colorDelete ()
    {
        return $this->response ( \f\ttt::service ( 'shop.color.colorDelete',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function colorStatus ()
    {
        return $this->response ( \f\ttt::service ( 'shop.color.colorStatus',
                                                   $this->request->getAssocParams () ) ) ;
    }

}
