<?php

class webpageController extends \f\controller
{

    /**
     *
     * @var webpageView
     */
    private $view ;

    public function __construct ()
    {
        require_once 'webpageView.php' ;
        $this->view = new webpageView ;
        parent::__construct () ;
    }

    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'core.seo.webpage.index',
                    'content'    => $this->view->renderListWebpage ()
                ) ) ;
    }

    public function webpageList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderWebpageGrid ( $requestDataTble ) ) ;
    }

    public function webpageDetail ()
    {
        $params = $this->request->getNonAssocParams () ;
        return $this->render ( array (
                    'breadcrumb' => 'core.seo.webpage.webpageDetail',
                    'content'    => $this->view->renderWebpageDetail ( $params[ 0 ] )
                ) ) ;
    }

    public function webpageSave ()
    {
        return $this->response ( \f\ttt::service ( 'core.seo.webpage.webpageSave',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function webpageDelete ()
    {
        return $this->response ( \f\ttt::service ( 'core.seo.webpage.webpageDelete',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function updateInfo ()
    {
        return $this->response ( \f\ttt::service ( 'core.seo.webpage.updateInfo',
                                                   $this->request->getAssocParams () ) ) ;
    }

    

}
