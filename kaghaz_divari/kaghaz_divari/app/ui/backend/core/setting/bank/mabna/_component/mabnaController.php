<?php

class mabnaController extends \f\controller
{

    /**
     *
     * @var \f\mabnaView
     */
    private $view ;

    public function __construct()
    {
        require_once 'mabnaView.php' ;
        $this->view = new mabnaView ;
        parent::__construct() ;
    }
     public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'core.setting.bank.mabna.index',
                    'content'    => $this->view->renderMabnaBankSetting (),
                ) ) ;
    }
    public function mabnaBankSettingSave ()
    {
       return $this->response(\f\ttt::service('core.setting.bank.mabna.mabnaBankSettingSave', $this->request->getAssocParams())) ;
    }
    
    

    

}
