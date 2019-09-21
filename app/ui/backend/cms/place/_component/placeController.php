<?php

class placeController extends \f\controller
{

    /**
     *
     * @var \f\placeView
     */
    private $view ;

    public function __construct()
    {
        require_once 'placeView.php' ;
        $this->view = new placeView ;
        parent::__construct() ;
    }

    public function index()
    {
        return $this->render(array (
                    'breadcrumb' => 'cms.place.index',
                    'content'    => $this->view->renderGrid()
                )) ;
    }

}
