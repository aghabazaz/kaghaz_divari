<?php

class memberController extends \f\controller
{

    /**
     *
     * @var \f\companyView
     */
    private $view ;

    public function __construct()
    {
        require_once 'memberView.php';
        $this->view = new memberView ;
        parent::__construct() ;
    }

    public function index()
    {
        return $this->render(array (
                    'breadcrumb' => 'member.index',
                    'content'    => $this->view->renderGrid()
                )) ;
    }

}
