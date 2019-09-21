<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \chartex\core\smsCenter
 * @category component
 * @author Akram Gharakhani <akramgharakhani@yahoo.com>
 */
class smsCenterService extends \f\service
{
    public function portSave(){
        $param=  $this->request->getAssocParams();
        
        \f\ttt::service ( 'core.setting.saveKeyGroup',array('keyValues'=>$param,'params'=>array('userId'=>\f\ttt::dal('core.auth.getUserOwner') , 'componentId' => 'smsCenter'))) ;
        
        $data=array('result'=>'success',  'message'=>\f\ifm::t ('saveSettings'));
        
        return $data;
    }
    
    public function getPortSetting()
    {
        return \f\ttt::service ( 'core.setting.getKeyGroup',array('keys'=>array(),'params'=>array('userId'=>\f\ttt::dal('core.auth.getUserOwner') , 'componentId' => 'smsCenter'))) ;
        
    }
    
    public function sendSingleSms()
    {
        $params =  $this->request->getAssocParams();
        $settings = $this->getPortSetting();
         
        require_once( \f\ifm::app ()->baseDir."/ifm/lib/nusoap.php" );
        $client=new nusoap_client('http://pzi.ir/smsSendWebService.asmx?wsdl','wsdl');

        $paramArray = array('UserName' =>$settings['userName']
                           ,'Pass' => $settings['passWord']
                           ,'Domain'=>$settings['domain']);

        $result = $client->call('Login', array('parameters' => $paramArray), '', '', false, true);
        
        $paramArray = array('SmsText'=>$params['txt']
                        ,'MobileNumber'=>$params['receiver']
                        ,'SenderNumber'=>$settings['senderNumber']
                        ,'smsMode'=>'SaveInPhone');
        
        $client->soap_defencoding= 'UTF-8';
        $client->decode_utf8=false;

        $result = $client->call('SendSingleSms', array('parameters' => $paramArray), '', '', false, true);
        return $result;
    }
    
    public function sendGroupSms()
    {
        $params =  $this->request->getAssocParams();
        $settings = $this->getPortSetting();
       
        if($settings['webService'])
        {
            $client=new SoapClient($settings['webService']);
            $paramArray = array('UserName' => $settings['userName']
                           ,'Pass' => $settings['passWord']
                           ,'Domain'=> $settings['domain']);

            $client->Login($paramArray);

            $param1 = array('SmsText'=> $params['txt']
                            ,'MobileNumber'=> $params['receiver']
                            ,'SenderNumber'=>$settings['senderNumber']
                            ,'sendType'=>'StaticText'
                            ,'smsMode'=>'SaveInPhone'
                            );

            $result=$client->SendSms($param1)->SendSmsResult->long;
            
            if($result>0 || $result[0]>0)
            {
                $result=array( 'success' , \f\ifm::t ('smsSend'), $settings['senderNumber']);
            }
            else
            {
                $result=array( 'error' , \f\ifm::t ('faildSendSms') );
            }
        }
        else
        {
            $result=array( 'error', \f\ifm::t ('noSmsSettings') );
        }
        return $result;
    }
    
    public function credit()
    {
        $settings = $this->getPortSetting();
        if($settings['webService'])
        {
            $client=new SoapClient( $settings['webService'] );

            $paramArray = array('UserName' =>$settings['userName']
                           ,'Pass' => $settings['passWord']
                           ,'Domain'=>$settings['domain']);

            $client->Login($paramArray);
            $result=$client->getCredit()->getCreditResult;
        }
        else
        {
            $result=array('error', \f\ifm::t ('noSmsSettings') );
        }
        return $result;
    }
    
    public function sendSingleSmsWithSave()
    {
        $params =  $this->request->getAssocParams();
        
        //\f\pr($params);
        $settings = $params['setting'];
         
        require_once( \f\ifm::app ()->baseDir."/ifm/lib/nusoap.php" );
        $client=new nusoap_client('http://pzi.ir/smsSendWebService.asmx?wsdl','wsdl');

        $paramArray = array('UserName' =>$settings['userName']
                           ,'Pass' => $settings['passWord']
                           ,'Domain'=>$settings['domain']);

        $result = $client->call('Login', array('parameters' => $paramArray), '', '', false, true);
        
        $paramArray = array('SmsText'=>$params['txt']
                        ,'MobileNumber'=>$params['receiver']
                        ,'SenderNumber'=>$settings['senderNumber']
                        ,'smsMode'=>'SaveInPhone');
        
        $client->soap_defencoding= 'UTF-8';
        $client->decode_utf8=false;

        $result = $client->call('SendSingleSms', array('parameters' => $paramArray), '', '', false, true);
        //\f\pr($result);
        
        $params['result']=$result['SendSingleSmsResult'];
        \f\ttt::dal( 'core.smsCenter.saveMessage',$params);
        return $result;
    }
}