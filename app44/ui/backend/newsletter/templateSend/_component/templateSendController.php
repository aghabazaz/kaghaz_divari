<?php

class templateSendController extends \f\controller
{

    /**
     *
     * @var \f\productView
     */
    private $view ;

    public function __construct()
    {
        require_once 'templateSendView.php' ;
        $this->view = new templateSendView ;
        parent::__construct() ;
    }

    public function index()
    {
        return $this->render(array (
                    'breadcrumb' => 'newsletter.templateSend.index',
                    'content'    => $this->view->renderGrid()
                )) ;
    }

}
