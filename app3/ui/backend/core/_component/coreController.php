<?php

class coreController extends \f\controller
{

    /**
     *
     * @var \f\coreView
     */
    private $view ;

    public function __construct()
    {
        require_once 'coreView.php' ;
        $this->view = new coreView ;
        parent::__construct() ;
    }

    public function index()
    {
        return $this->render(array (
                    'breadcrumb' => 'core.index',
                    'content'    => $this->view->renderGrid()
                )) ;
    }

}
