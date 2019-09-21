<?php

class ratingOptionsController extends \f\controller
{

    /**
     *
     * @var \f\slideView
     */
    private $view ;

    public function __construct ()
    {
        require_once 'ratingOptionsView.php' ;
        $this->view = new ratingOptionsView ;
        parent::__construct () ;
    }

    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.ratingOptions.index',
                    'content'    => $this->view->renderGrid ()
                ) ) ;
    }

    public function ratingOptionsList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderRatingOptionsGrid ( $requestDataTble ) ) ;
    }

    public function ratingOptionsAdd ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.ratingOptions.ratingOptionsAdd',
                    'content'    => $this->view->renderRatingOptionsAdd ()
                ) ) ;
    }

    public function ratingOptionsSave ()
    {
        return $this->response ( \f\ttt::service ( 'shop.ratingOptions.ratingOptionsSave',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function ratingOptionsEdit ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.ratingOptions.ratingOptionsEdit',
                    'content'    => $this->view->renderRatingOptionsAdd ( $this->request->getParam ( 0 ) )
                ) ) ;
    }

    public function ratingOptionsDelete ()
    {
        return $this->response ( \f\ttt::service ( 'shop.ratingOptions.ratingOptionsDelete',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function ratingOptionsStatus ()
    {
        return $this->response ( \f\ttt::service ( 'shop.ratingOptions.ratingOptionsStatus',
                                                   $this->request->getAssocParams () ) ) ;
    }

}
