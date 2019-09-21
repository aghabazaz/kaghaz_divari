<?php

class baseInfoController extends \f\controller
{

    /**
     *
     * @var baseInfoView
     */
    private $view ;

    public function __construct ()
    {
        require_once 'baseInfoView.php' ;
        $this->view = new baseInfoView ;
        parent::__construct () ;
        
    }
    public function index()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.baseInfo.index',
                    'content'    => $this->view->renderBaseInfoList ()
                ) ) ;
    }
    public function baseInfoList ()
    {

        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderBaseInfoGrid ( $requestDataTble ) ) ;
    }
    
    public function baseInfoAdd ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.baseInfo.baseInfoAdd',
                    'content'    => $this->view->renderBaseInfoAdd ()
                ) ) ;
    }
    
    public function baseInfoSave ()
    {
        return $this->response ( \f\ttt::service ( 'shop.baseInfo.baseInfoSave',
                                                   $this->request->getAssocParams () ) ) ;
    }
    
     public function baseInfoEdit ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.baseInfo.baseInfoEdit',
                    'content'    => $this->view->renderBaseInfoAdd ( $this->request->getParam ( 0 ) )
                ) ) ;
    }
    public function baseInfoDelete ()
    {
        return $this->response ( \f\ttt::service ( 'shop.baseInfo.baseInfoDelete',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function baseInfoStatus ()
    {
        return $this->response ( \f\ttt::service ( 'shop.baseInfo.baseInfoStatus',
                                                   $this->request->getAssocParams () ) ) ;
    }
    

   

}