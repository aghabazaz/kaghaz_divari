<?php
/**
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 * @package core.setting
 * @category component
 */
class settingController extends \f\controller
{

    /**
     *
     * @var userView
     */
    private $view ;

    public function __construct()
    {
        require_once 'settingView.php' ;
        $this->view = new settingView ;
        parent::__construct() ;
    }

    public function index()
    {
        return $this->render(array (
                    'breadcrumb' => 'core.setting.index',
                    'content'    => $this->view->renderDashboard()
                )) ;
    }

}
