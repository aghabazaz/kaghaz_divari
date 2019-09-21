<?php

class websiteController extends \f\controller
{

    /**
     *
     * @var websiteView
     */
    private $view ;

    public function __construct()
    {
        require_once 'websiteView.php' ;
        $this->view = new websiteView ;
        parent::__construct() ;
    }

    public function index()
    {
        return $this->render(array (
                    'breadcrumb' => 'core.website.index',
                    'content'    => $this->view->renderGrid()
                )) ;
    }

    public function siteList()
    {
        return $this->response($this->view->renderSiteGrid($this->request->getAssocParams())) ;
    }

    public function remove()
    {
        return $this->response(\f\ttt::service('core.website.siteRemove',
                                               $this->request->getAssocParams())) ;
    }

    public function active()
    {
        return $this->response(\f\ttt::service('core.website.siteActive',
                                               $this->request->getAssocParams())) ;
    }

    public function siteAdd()
    {
        return $this->render( array(
            'breadcrumb' => 'core.website.siteAdd',
            'content' => $this->view->renderSiteAdd()
        )) ;
    }

    public function siteEdit()
    {        
        return $this->render( array(
            'breadcrumb' => 'core.website.siteEdit',
            'content' => $this->view->renderSiteAdd( $this->request->getParam ( 0 ) )
        ) ) ;
    }

    public function saveSite()
    {
                return $this->response(\f\ttt::service('core.website.saveSite',
                                               $this->request->getAssocParams())) ;
    }

    public function checkDomain()
    {
        return $this->response(\f\ttt::service('core.website.checkDomain',
                                               $this->request->getAssocParams())) ;
    }

}
