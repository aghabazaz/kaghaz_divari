<?php

class shopSettingController extends \f\controller
{

    /**
     *
     * @var \f\shopSettingView
     */
    private $view ;

    public function __construct()
    {
        require_once 'shopSettingView.php' ;
        $this->view = new shopSettingView ;
        parent::__construct() ;
    }
    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.shopSetting.index',
                    'content'    => $this->view->renderEmailSetting (),
                ) ) ;
    }
    public function settingSave ()
    {
        $pa = $this->request->getAssocParams () ;
        $pa['mobileNumber'] = json_encode($pa['mobileNumber']);
       return $this->response(\f\ttt::service('shop.shopSetting.settingSave', $this->request->getAssocParams())) ;
    }

    

}
