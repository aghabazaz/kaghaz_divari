<?php
/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \cms\advertisement
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class advertisementService extends \f\service
{
    /**
     *
     * @var shortcutMapper 
     */
    private $mapper ;

    public function __construct ()
    {
        $this->mapper = \f\dalFactory::make ( 'cms.advertisement' ) ;
    }
    public function advertisementList ()
    {
        return \f\ttt::dal ( 'cms.advertisement.advertisementList',
                             $this->request->getAssocParams () ) ;
    }
    public function advertisementSave()
    {
        $params = $this->request->getAssocParams () ;
        if($params['id'])
        {
             $result = \f\ttt::dal ( 'cms.advertisement.advertisementSaveEdit', $params ) ;
             $msg=\f\ifm::t ( 'advertiseSaveEdit' );
             $reset=FALSE;
        }
        else
        {
             $result = \f\ttt::dal ( 'cms.advertisement.advertisementSave', $params ) ;
             $msg=\f\ifm::t ( 'advertiseSave' );
             $reset=TRUE;
        }
       
        
        if ( $result )
        {
            $data = array ( 'result'  => 'success', 'message' => $msg, 'reset' => $reset ) ;
        }
        else
        {
            $data = array ( 'result'  => 'error', 'message' => \f\ifm::t ( 'dbError' ) ) ;
        }
        
        return $data;
       
    }
     public function advertisementDelete ()
    {
        return \f\ttt::dal ( 'cms.advertisement.advertisementDelete',
                             $this->request->getAssocParams () ) ;
    }
     public function advertisementStatus ()
    {
        return \f\ttt::dal ( 'cms.advertisement.advertisementStatus',
                             $this->request->getAssocParams () ) ;
    }

    public function getAdvertisementById ()
    {
        $param = $this->request->getAssocParams () ;    
        return \f\ttt::dal ( 'cms.advertisement.getAdvertisementById',
                            $param ) ;
    }
    
    public function getContactByOwnerId ()
    {
        return \f\ttt::dal ( 'cms.advertisement.getContactByOwnerId',
                             $this->request->getAssocParams () ) ;
    }
    
    public function getMainPageContact ()
    {
        return \f\ttt::dal ( 'cms.advertisement.getMainPageContact',
                             $this->request->getAssocParams () ) ;
    }
    
    public function requestSave()
    {
        $params = $this->request->getAssocParams () ;
        $result = \f\ttt::dal ( 'cms.advertisement.requestSave', $params ) ;
        
       
            
       
        
        if ( $result )
        {
            \f\ttt::service('core.setting.sms.sendSmsArdinData',
                    array(
                        'reciver_number'=>'09132502072',
                        'message'=>'یک درخواست تبلیغاتی جدید در سایت ثبت شد.'
                    ));
            
            \f\ttt::service('core.setting.email.sendEmailSmtp',array(
                 'toAddress'=>$params['email'],
                 'content'=>  $this->contentRequestAdvertise($params),
                 'title'=>'ثبت درخواست تبلیغات در انتخاب 24',
                 'fromName'=>'Entekhab 24',
                 'toName'=>$params[ 'name' ],
             ));
            
            \f\ttt::service('core.setting.sms.sendSmsArdinData',
                    array(
                        'reciver_number'=>$params['phone'],
                        'message'=>'سرور ارجمند : '.$params['name'].'
   با سلام
پیرو درخواست شما در وبسایت انتخاب 24 یک ایمیل حاوی اطلاعات لازم جهت درج تبلیغ در سایت به ایمیل  '.$params['email'].'   ارسال شد.
    با احترام - وب سایت انتخاب 24 '
                    ));
            
            $data = array ( 'result'  => 'success', 'message' => 'درخواست شما با موفقیت ثبت شد. مراحل بعدی از طریق ایمیل به اطلاع شما خواهد رسید.') ;
        }
        else
        {
            $data = array ( 'result'  => 'errorResponse', 'message' => 'اشکال در ارتباط با سرور! لطفا چند لحظه دیگر تلاش کنید...' ) ;
        }
        
        return $data;
    }
    public function contentRequestAdvertise($params)
    {
        $content='با سلام';
        $content.='<br>';
        $content.='پیرو درخواستی که برای ثبت آگهی در وب سایت داده اید لطفا بنر تبلیغ خود را در یکی از فرمت های jpg ، png ، gif و یا swf در اندازه مشخص شده برای پلن انتخاب شده خود به همین آدرس ایمیل ارسال کنید.'; 
        $content.='<br>';
        $content.='همچنین یک عکس با متن مناسب هر طور که صلاح می دانید برای درج تبلیغ شما در کانال تلگرام برای ما ارسال کنید.';
        $content.='<br>';
        $content.='بعد از قرار دادن تبلیغ از سمت ما شماره کارت بانکی برای واریز هزینه ارسال خواهد شد.';
        $content.='<br>';
        $content.='با احترام';

        return $content;
    }
    public function requestList ()
    {
         //\f\pr('salam');
        return \f\ttt::dal ( 'cms.advertisement.requestList',
                             $this->request->getAssocParams () ) ;
    }
    
     public function requestDelete ()
    {
        return \f\ttt::dal ( 'cms.advertisement.requestDelete',
                             $this->request->getAssocParams () ) ;
    }
    public function getListAdvertiseByPlan()
    {
        
        return \f\ttt::dal ( 'cms.advertisement.getListAdvertiseByPlan',
                             $this->request->getAssocParams () ) ;
    }


}