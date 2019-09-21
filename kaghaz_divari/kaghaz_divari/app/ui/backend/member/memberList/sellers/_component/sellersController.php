<?php

class sellersController extends \f\controller
{

    /**
     *
     * @var \f\cmsView
     */
    private $view ;

    public function __construct ()
    {
        require_once 'sellersView.php';
        $this->view = new sellersView ;
        parent::__construct () ;
    }

    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'member.memberList.sellers.index',
                    'content'    => $this->view->renderGrid ()
                ) ) ;
    }

    public function sellersList ()
    {   //\f\pr('salma');
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderSellersGrid ( $requestDataTble ) ) ;
    }

    public function sellersAdd ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'member.memberList.sellers.sellersAdd',
                    'content'    => $this->view->renderSellersAdd ()
                ) ) ;
    }

    public function sellersSave ()
    {
        return $this->response ( \f\ttt::service ( 'member.memberListSave',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function sellersEdit ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'member.memberList.sellers.sellersEdit',
                    'content'    => $this->view->renderSellersAdd ( $this->request->getParam ( 0 ) )
                ) ) ;
    }

    public function sellersStatus ()
    {
        return $this->response ( \f\ttt::service ( 'member.memberListStatus',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function sellersDelete ()
    {
        return $this->response ( \f\ttt::service ( 'member.memberListDelete',
                                                   $this->request->getAssocParams () ) ) ;
    }
}
