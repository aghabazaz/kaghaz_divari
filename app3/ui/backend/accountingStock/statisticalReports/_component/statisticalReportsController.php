<?php

class statisticalReportsController extends \f\controller
{

    /**
     *
     * @var \f\portfolioView
     */
    private $view ;

    public function __construct()
    {
        require_once 'statisticalReportsView.php';
        $this->view = new statisticalReportsView ;
        parent::__construct() ;
    }

    public function index()
    {
        return $this->render(array (
                    'breadcrumb' => 'accountingStock.statisticalReports.index',
                    'content'    => $this->view->renderGrid()
                )) ;
    }

}
