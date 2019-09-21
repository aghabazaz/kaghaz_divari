<?php

class reportsController extends \f\controller
{

    /**
     *
     * @var \f\reportsView
     */
    private $view ;

    public function __construct ()
    {
        require_once 'reportsView.php' ;
        $this->view = new reportsView ;
        parent::__construct () ;
    }

    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'accountingStock.reports.index',
                    'content'    => $this->view->renderReports (),
                ) ) ;
    }

    public function reportsSave ()
    {
        //\f\pre('salam');
        return $this->response ( \f\ttt::service ( 'shop.order.reportsSave',
                                                   $this->request->getAssocParams () ) ) ;
    }

}
