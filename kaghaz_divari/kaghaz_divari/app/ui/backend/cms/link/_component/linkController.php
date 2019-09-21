<?php

class linkController extends \f\controller
{

    /**
     *
     * @var \f\bookingView
     */
    private $view ;

    public function __construct ()
    {
        require_once 'linkView.php' ;
        $this->view = new linkView ;
        parent::__construct () ;
    }

    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'cms.link.index',
                    'content'    => $this->view->renderGrid ()
                ) ) ;
    }

}