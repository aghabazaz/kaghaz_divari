<?php

class stockControlController extends \f\controller
{

    /**
     *
     * @var \f\cmsView
     */
    private $view ;

    public function __construct()
    {
        require_once 'stockControlView.php' ;
        $this->view = new stockControlView ;
        parent::__construct() ;
    }

    public function index()
    {
        return $this->render(array (
                    'breadcrumb' => 'accountingStock.stockControl.index',
                    'content'    => $this->view->renderGrid()
                )) ;
    }

}
