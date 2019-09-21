<?php

class zarinpalController extends \f\controller
{

    /**
     *
     * @var \f\zarinpalView
     */
    private $view ;

    public function __construct()
    {
        require_once 'zarinpalView.php' ;
        $this->view = new zarinpalView ;
        parent::__construct() ;
    }
     public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'core.setting.bank.zarinpal.index',
                    'content'    => $this->view->renderZarinpalBankSetting (),
                ) ) ;
    }
    public function zarinpalBankSettingSave ()
    {
       return $this->response(\f\ttt::service('core.setting.bank.zarinpal.zarinpalBankSettingSave', $this->request->getAssocParams())) ;
    }
    
    

    

}
