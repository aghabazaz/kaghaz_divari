<?php

class smsTempController extends \f\controller
{

    /**
     *
     * @var \f\coreView
     */
    private $view ;

    public function __construct ()
    {
        require_once 'smsTempView.php' ;
        $this->view = new smsTempView ;
        parent::__construct () ;
    }

    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'newsletter.templateSend.smsTemp.index',
                    'content'    => $this->view->renderSmsTempList ()
                ) ) ;
    }

    public function smsTempAdd ()
    {
        //\f\pre('sda');
        return $this->render ( array (
                    'breadcrumb' => 'newsletter.templateSend.smsTemp.tempAdd',
                    'content'    => $this->view->renderSmsTempAdd ()
                ) ) ;
    }

    public function smsTempSave ()
    {
        $params = $this->request->getAssocParams () ;
        $params['type'] = 'sms';
        return $this->response ( \f\ttt::service ( 'newsletter.templateSend.tempSave',
                                                   $params ) ) ;
    }

    public function smsTempList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderSmsTempGrid ( $requestDataTble ) ) ;
    }

    public function smsTempEdit ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'newsletter.templateSend.smsTemp.smsTempEdit',
                    'content'    => $this->view->renderSmsTempAdd ( $this->request->getParam ( 0 ) )
                ) ) ;
    }

    public function smsTempDelete ()
    {
        return $this->response ( \f\ttt::service ( 'newsletter.templateSend.tempDelete',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function smsTempStatus ()
    {
        return $this->response ( \f\ttt::service ( 'newsletter.templateSend.tempStatus',
                                                   $this->request->getAssocParams () ) ) ;
    }



}
