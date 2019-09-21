<?php

class emailController extends \f\controller
{

    /**
     *
     * @var \f\emailView
     */
    private $view ;

    public function __construct()
    {
        require_once 'emailView.php' ;
        $this->view = new emailView ;
        parent::__construct() ;
    }
    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'core.setting.email.index',
                    'content'    => $this->view->renderEmailSetting (),
                ) ) ;
    }
    public function emailSettingSave ()
    {
       return $this->response(\f\ttt::service('core.setting.email.emailSettingSave', $this->request->getAssocParams())) ;
    }

    

}
