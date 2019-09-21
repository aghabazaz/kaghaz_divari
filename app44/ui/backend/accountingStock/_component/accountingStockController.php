<?php

class accountingStockController extends \f\controller
{

    /**
     *
     * @var \f\cmsView
     */
    private $view ;

    public function __construct()
    {
        require_once 'accountingStockView.php' ;
        $this->view = new accountingStockView ;
        parent::__construct() ;
    }

    public function index()
    {
        return $this->render(array (
                    'breadcrumb' => 'accountingStock.index',
                    'content'    => $this->view->renderGrid()
                )) ;
    }

}
