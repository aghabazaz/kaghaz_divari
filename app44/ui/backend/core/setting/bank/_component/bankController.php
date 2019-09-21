<?php

class bankController extends \f\controller
{

    /**
     *
     * @var \f\bankView
     */
    private $view ;

    public function __construct()
    {
        require_once 'bankView.php' ;
        $this->view = new bankView ;
        parent::__construct() ;
    }
    public function index()
    {
        return $this->render(array (
                    'breadcrumb' => 'core.setting.bank.index',
                    'content'    => $this->view->renderDashboard()
                )) ;
    }

    

}
