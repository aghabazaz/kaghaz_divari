<?php

class memberListController extends \f\controller
{

    /**
     *
     * @var \f\portfolioView
     */
    private $view ;

    public function __construct()
    {
        require_once 'memberListView.php';
        $this->view = new memberListView ;
        parent::__construct() ;
    }

    public function index()
    {
        return $this->render(array (
                    'breadcrumb' => 'member.memberList.index',
                    'content'    => $this->view->renderGrid()
                )) ;
    }

}
