<?php

class wikiController extends \f\controller
{

    /**
     *
     * @var \f\slideView
     */
    private $view ;

    public function __construct ()
    {
        require_once 'wikiView.php' ;
        $this->view = new wikiView ;
        parent::__construct () ;
    }

    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.wiki.index',
                    'content'    => $this->view->renderGrid ()
                ) ) ;
    }

    public function wikiList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderWikiGrid ( $requestDataTble ) ) ;
    }

    public function wikiAdd ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.wiki.wikiAdd',
                    'content'    => $this->view->renderWikiAdd ()
                ) ) ;
    }

    public function wikiSave ()
    {
        return $this->response ( \f\ttt::service ( 'shop.wiki.wikiSave',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function wikiEdit ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.wiki.wikiEdit',
                    'content'    => $this->view->renderWikiAdd ( $this->request->getParam ( 0 ) )
                ) ) ;
    }

    public function wikiDelete ()
    {
        return $this->response ( \f\ttt::service ( 'shop.wiki.wikiDelete',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function wikiStatus ()
    {
        return $this->response ( \f\ttt::service ( 'shop.wiki.wikiStatus',
                                                   $this->request->getAssocParams () ) ) ;
    }

}
