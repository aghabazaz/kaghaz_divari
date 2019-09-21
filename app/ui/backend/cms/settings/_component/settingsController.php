<?php

class settingsController extends \f\controller
{

    /**
     *
     * @var \f\settingsView
     */
    private $view ;

    public function __construct()
    {
        require_once 'settingsView.php' ;
        $this->view = new settingsView ;
        parent::__construct() ;
    }
    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'cms.settings.index',
                    'content'    => $this->view->renderEmailSetting (),
                ) ) ;
    }
    public function settingSave ()
    {
       return $this->response(\f\ttt::service('cms.settings.settingSave', $this->request->getAssocParams())) ;
    }

    

}
