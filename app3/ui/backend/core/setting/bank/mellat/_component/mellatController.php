<?php

class mellatController extends \f\controller
{

    /**
     *
     * @var \f\mellatView
     */
    private $view ;

    public function __construct()
    {
        require_once 'mellatView.php' ;
        $this->view = new mellatView ;
        parent::__construct() ;
    }
     public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'core.setting.bank.mellat.index',
                    'content'    => $this->view->renderMellatBankSetting (),
                ) ) ;
    }
    public function mellatBankSettingSave ()
    {
       return $this->response(\f\ttt::service('core.setting.bank.mellat.mellatBankSettingSave', $this->request->getAssocParams())) ;
    }
    
    

    

}
