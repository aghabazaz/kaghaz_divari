<?php

class pasargadController extends \f\controller
{

    /**
     *
     * @var \f\pasargadView
     */
    private $view ;

    public function __construct()
    {
        require_once 'pasargadView.php' ;
        $this->view = new pasargadView ;
        parent::__construct() ;
    }
     public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'core.setting.bank.pasargad.index',
                    'content'    => $this->view->renderPasargadBankSetting (),
                ) ) ;
    }
    public function pasargadBankSettingSave ()
    {
       return $this->response(\f\ttt::service('core.setting.bank.pasargad.pasargadBankSettingSave', $this->request->getAssocParams())) ;
    }
    
    

    

}
