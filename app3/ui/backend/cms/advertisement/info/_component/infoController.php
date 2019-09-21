<?php

class infoController extends \f\controller
{

    /**
     *
     * @var \f\coreView
     */
    private $view ;

    public function __construct()
    {
        require_once 'infoView.php' ;
        $this->view = new infoView ;
        parent::__construct() ;
    }

    public function index()
    {
       return $this->render(array (
                    'breadcrumb' => 'news.info.index',
                    'content'    => $this->view->renderGrid()
                )) ;
    }
    
   
}
