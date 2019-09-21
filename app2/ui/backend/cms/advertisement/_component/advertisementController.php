<?php

class advertisementController extends \f\controller
{

    /**
     *
     * @var \f\coreView
     */
    private $view ;

    public function __construct()
    {
        require_once 'advertisementView.php' ;
        $this->view = new advertisementView ;
        parent::__construct() ;
    }

    public function index()
    {
       return $this->render(array (
                    'breadcrumb' => 'cms.advertisement.index',
                    'content'    => $this->view->renderGrid()
                )) ;
    }
    
   
}
