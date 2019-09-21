<?php

class shopController extends \f\controller
{

    /**
     *
     * @var \f\cmsView
     */
    private $view ;

    public function __construct()
    {
        require_once 'shopView.php' ;
        $this->view = new shopView ;
        parent::__construct() ;
    }

    public function index()
    {
        return $this->render(array (
                    'breadcrumb' => 'shop.index',
                    'content'    => $this->view->renderGrid()
                )) ;
    }

}
