<?php

class wholesalerController extends \f\controller
{

    /**
     *
     * @var \f\slideView
     */
    private $view ;

    public function __construct ()
    {
        require_once 'wholesalerView.php' ;
        $this->view = new wholesalerView ;
        parent::__construct () ;
    }

    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.wholesaler.index',
                    'content'    => $this->view->renderGrid ()
                ) ) ;
    }

    public function wholesalerList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderWholesalerGrid ( $requestDataTble ) ) ;
    }

    public function wholesalerAdd ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.wholesaler.wholesalerAdd',
                    'content'    => $this->view->renderWholesalerAdd ()
                ) ) ;
    }

    public function wholesalerSave ()
    {
        return $this->response ( \f\ttt::service ( 'shop.wholesaler.wholesalerSave',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function wholesalerEdit ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.wholesaler.wholesalerEdit',
                    'content'    => $this->view->renderWholesalerAdd ( $this->request->getParam ( 0 ) )
                ) ) ;
    }

    public function wholesalerDelete ()
    {
        return $this->response ( \f\ttt::service ( 'shop.wholesaler.wholesalerDelete',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function WholesalerStatus ()
    {
        return $this->response ( \f\ttt::service ( 'shop.wholesaler.WholesalerStatus',
                                                   $this->request->getAssocParams () ) ) ;
    }

}
