<?php

class colleagueController extends \f\controller
{

    /**
     *
     * @var \f\slideView
     */
    private $view ;

    public function __construct ()
    {
        require_once 'colleagueView.php' ;
        $this->view = new colleagueView ;
        parent::__construct () ;
    }

    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.colleague.index',
                    'content'    => $this->view->renderGrid ()
                ) ) ;
    }

    public function colleagueList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderColleagueGrid ( $requestDataTble ) ) ;
    }

    public function colleagueAdd ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.colleague.colleagueAdd',
                    'content'    => $this->view->renderColleagueAdd ()
                ) ) ;
    }

    public function colleagueSave ()
    {
        return $this->response ( \f\ttt::service ( 'shop.colleague.colleagueSave',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function colleagueEdit ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.colleague.colleagueEdit',
                    'content'    => $this->view->renderColleagueAdd ( $this->request->getParam ( 0 ) )
                ) ) ;
    }

    public function colleagueDelete ()
    {
        return $this->response ( \f\ttt::service ( 'shop.colleague.colleagueDelete',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function colleagueStatusis ()
    {
        return $this->response ( \f\ttt::service ( 'shop.colleague.colleagueStatus',
                                                   $this->request->getAssocParams () ) ) ;
    }

}
