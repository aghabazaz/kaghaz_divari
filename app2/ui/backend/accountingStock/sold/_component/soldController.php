<?php

class soldController extends \f\controller
{

    /**
     *
     * @var \f\slideView
     */
    private $view ;

    public function __construct ()
    {
        require_once 'soldView.php' ;
        $this->view = new soldView ;
        parent::__construct () ;
    }

    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'accountingStock.sold.index',
                    'content'    => $this->view->renderGrid ()
                ) ) ;
    }

    public function soldList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderSoldGrid ( $requestDataTble ) ) ;
    }

    public function soldDetail ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'accountingStock.sold.soldDetail',
                    'content'    => $this->view->renderSoldDetail ( $this->request->getParam ( 0 ) )
                ) ) ;
    }


}
