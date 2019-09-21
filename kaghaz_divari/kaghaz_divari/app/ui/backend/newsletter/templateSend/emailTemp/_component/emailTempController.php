<?php

class emailTempController extends \f\controller
{

    /**
     *
     * @var \f\coreView
     */
    private $view ;

    public function __construct ()
    {
        require_once 'emailTempView.php' ;
        $this->view = new emailTempView ;
        parent::__construct () ;
    }

    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'newsletter.templateSend.emailTemp.index',
                    'content'    => $this->view->renderEmailTempList ()
                ) ) ;
    }

    public function emailTempAdd ()
    {
        //\f\pre('sda');
        return $this->render ( array (
                    'breadcrumb' => 'newsletter.templateSend.emailTemp.tempAdd',
                    'content'    => $this->view->renderEmailTempAdd ()
                ) ) ;
    }

    public function emailTempSave ()
    {
        $params = $this->request->getAssocParams () ;
        $params['type'] = 'email';
        return $this->response ( \f\ttt::service ( 'newsletter.templateSend.tempSave',
                                                   $params ) ) ;
    }

    public function emailTempList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderEmailTempGrid ( $requestDataTble ) ) ;
    }

    public function emailTempEdit ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'newsletter.templateSend.emailTemp.emailTempEdit',
                    'content'    => $this->view->renderEmailTempAdd ( $this->request->getParam ( 0 ) )
                ) ) ;
    }

    public function emailTempDelete ()
    {
        return $this->response ( \f\ttt::service ( 'newsletter.templateSend.tempDelete',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function emailTempStatus ()
    {
        return $this->response ( \f\ttt::service ( 'newsletter.templateSend.tempStatus',
                                                   $this->request->getAssocParams () ) ) ;
    }



}
