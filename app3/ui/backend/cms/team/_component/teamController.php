<?php

class teamController extends \f\controller
{

    /**
     *
     * @var \f\teamView
     */
    private $view ;

    public function __construct()
    {
        require_once 'teamView.php' ;
        $this->view = new teamView ;
        parent::__construct() ;
    }

    public function index()
    {
        return $this->render(array (
                    'breadcrumb' => 'cms.team.index',
                    'content'    => $this->view->renderGrid()
                )) ;
    }

}
