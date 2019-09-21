<?php

class mostSellRepController extends \f\controller
{

    /**
     *
     * @var \f\cmsView
     */
    private $view ;

    public function __construct ()
    {
        require_once 'mostSellRepView.php';
        $this->view = new mostSellRepView ;
        parent::__construct () ;
    }

    public function mostSellRep ()
    {
        return $this->render ( array (
            'breadcrumb' => 'accountingStock.statisticalReports.mostSellRep.mostSellRepIndex',
            'content'    => $this->view->renderGrid ()
        ) ) ;
    }


    public function index ()
    {
        //\f\pre('dsf');
        return $this->render ( array (
                    'breadcrumb' => 'accountingStock.statisticalReports.mostSellRep.index',
                    'content'    => $this->view->mostSellRepIndex ()
                ) ) ;
    }

    public function mostSellRepCatList(){
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderMostSellRepCatList ( $requestDataTble ) ) ;
    }
    public function mostSellRepBrandList(){
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderMostSellRepBrandList ( $requestDataTble ) ) ;
    }
    public function mostSellRepBaseOnProduct(){
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderMostSellRepProductList ( $requestDataTble ) ) ;
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
