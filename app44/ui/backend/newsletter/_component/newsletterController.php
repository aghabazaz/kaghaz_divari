<?php

class newsletterController extends \f\controller
{

    /**
     *
     * @var \f\cmsView
     */
    private $view ;

    public function __construct()
    {
        require_once 'newsletterView.php' ;
        $this->view = new newsletterView ;
        parent::__construct() ;
    }

    public function index()
    {
        return $this->render(array (
                    'breadcrumb' => 'newsletter.index',
                    'content'    => $this->view->renderGrid()
                )) ;
    }

}
