<?php

class reportController extends \f\controller
{

    /**
     *
     * @var \f\coreView
     */
    private $view ;

    public function __construct()
    {
        require_once 'reportView.php' ;
        $this->view = new reportView ;
        parent::__construct() ;
    }

    public function index()
    {
        return $this->render(array (
                    'breadcrumb' => 'cms.report.index',
                    'content'    => $this->view->renderDashboard()
                )) ;
    }
    
}
