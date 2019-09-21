<?php

class memberSettingController extends \f\controller
{

    /**
     *
     * @var \f\memberSettingView
     */
    private $view ;

    public function __construct()
    {
        require_once 'memberSettingView.php' ;
        $this->view = new memberSettingView ;
        parent::__construct() ;
    }
    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'member.memberSetting.index',
                    'content'    => $this->view->renderEmailSetting (),
                ) ) ;
    }
    public function settingSave ()
    {
       return $this->response(\f\ttt::service('member.memberSetting.settingSave', $this->request->getAssocParams())) ;
    }

    

}
