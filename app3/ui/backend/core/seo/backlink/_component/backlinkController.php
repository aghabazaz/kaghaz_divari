<?php

class backlinkController extends \f\controller
{

    /**
     *
     * @var backlinkView
     */
    private $view ;

    public function __construct()
    {
        require_once 'backlinkView.php' ;
        $this->view = new backlinkView ;
        parent::__construct() ;
    }

    public function index()
    {
        return $this->render(array (
                    'breadcrumb' => 'core.seo.backlink.index',
                    'content'    => $this->view->renderListBacklink()
                )) ;
    }
    public function backlinkList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderBacklinkGrid ( $requestDataTble ) ) ;
    }
    public function backlinkDetail ()
    {
        $params= $this->request->getNonAssocParams();
        return $this->render ( array (
                    'breadcrumb' => 'core.seo.backlink.backlinkDetail',
                    'content'    => $this->view->renderBacklinkDetail ($params[0])
                ) ) ;
    } 
    public function backlinkDelete ()
    {
        return $this->response ( \f\ttt::service ( 'core.seo.backlink.backlinkDelete',
                                                   $this->request->getAssocParams () ) ) ;
    }
    public function updateInfo()
    {
        return $this->response ( \f\ttt::service ( 'core.seo.backlink.updateInfo',
                                                   $this->request->getAssocParams () ) ) ;
    }


}
