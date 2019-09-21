<?php

class contactController extends \f\controller
{

    /**
     *
     * @var \f\coreView
     */
    private $view ;

    public function __construct()
    {
        require_once 'contactView.php' ;
        $this->view = new contactView ;
        parent::__construct() ;
    }

    public function index()
    {
        return $this->render(array (
                    'breadcrumb' => 'cms.contact.index',
                    'content'    => $this->view->renderGrid()
                )) ;
    }
    public function contactList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderContactGrid ( $requestDataTble ) ) ;
    }
    public function contactDelete ()
    {
        return $this->response ( \f\ttt::service ( 'cms.contact.contactDelete',
                                                   $this->request->getAssocParams () ) ) ;
    }
    
    public function answerToComment ()
    {
        $params=  $this->request->getAssocParams();
        return $this->response ( array('content'=>$this->view->renderAnswerToComment ($params)) ) ;
    }
    
    public function sendAnswer ()
    {
        $params=  $this->request->getAssocParams();
        
        //\f\pr($params);
        
        $result=\f\ttt::service ( 'core.setting.email.sendEmailSmtp',
                                  array (
                    'toAddress' => $params[ 'reciever_email' ],
                    'content'   => $this->contentEmail ( $params ),
                    'title'     => $params['title'],
                    'fromName'  => 'ایران رنکینگ',
                    'toName'    => $params[ 'reciever_name' ],
                ) ) ;
        
        //\f\pre($result);
        if($result)
        {
            return $this->response(array('result'=>'success','message'=>'ارسال پاسخ با موفقیت انجام شد.'));
        }
        else
        {
            return $this->response(array('result'=>'error','message'=>'خطا در ارسال ...'));
        }
        
       
       
    }
    private function contentEmail ( $params )
    {
        $content='<div>'.nl2br($params['answer']).'</div>';
        $content.='<div style="border-radius:5px;padding:10px 5px;margin:20px 0px 0px 0px;background:#eee"><strong>پیام شما : </strong><br>'.nl2br($params['message']).'</div>';
        
        return $content;
        
    }

    

}
