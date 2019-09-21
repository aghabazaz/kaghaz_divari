<?php

class cmsController extends \f\controller
{

    /**
     *
     * @var \f\cmsView
     */
    private $view ;

    public function __construct()
    {
        require_once 'cmsView.php' ;
        $this->view = new cmsView ;
        parent::__construct() ;
    }

    public function index()
    {
        return $this->render(array (
                    'breadcrumb' => 'cms.index',
                    'content'    => $this->view->renderGrid()
                )) ;
    }

}
