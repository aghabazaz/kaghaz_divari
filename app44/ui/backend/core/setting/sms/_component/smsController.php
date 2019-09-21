<?php

class smsController extends \f\controller
{

    /**
     *
     * @var \f\smsView
     */
    private $view ;

    public function __construct()
    {
        require_once 'smsView.php' ;
        $this->view = new smsView ;
        parent::__construct() ;
    }
    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'core.setting.sms.index',
                    'content'    => $this->view->renderSmsSetting (),
                ) ) ;
    }
    public function smsSettingSave ()
    {
       return $this->response(\f\ttt::service('core.setting.sms.smsSettingSave', $this->request->getAssocParams())) ;
    }

    

}
