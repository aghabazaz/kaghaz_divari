<?php

/**
 * @author Yuness Mehdian <mehdian.y@gmail.com>
 * @package \chartex\core
 * @category ui
 */
class dashboardController extends \f\controller
{

    /**
     *
     * @var dashboardView
     */
    private $view ;

    public function __construct()
    {
        include 'dashboardView.php' ;
        $this->view = new dashboardView ;
        parent::__construct() ;
    }

    public function index()
    {
        return $this->render(array (
                    'legacyPanel' => true,
                    'content'     => $this->view->renderGrid()
                )) ;
    }

}
