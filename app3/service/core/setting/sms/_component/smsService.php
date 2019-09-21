<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \chartex\core\smsCenter
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class smsService extends \f\service
{

    public function smsSettingSave ()
    {
        $param = $this->request->getAssocParams () ;

        \f\ttt::service ( 'core.setting.saveKeyGroup',
                          array (
            'keyValues' => $param,
            'params'    => array (
                'userId'      => \f\ttt::dal ( 'core.auth.getUserOwner' ),
                'componentId' => 'smsCenter' ) ) ) ;

        $data = array (
            'result'  => 'success',
            'message' => \f\ifm::t ( 'saveSettings' ) ) ;

        return $data ;
    }

    public function getSmsSetting ()
    {
        $ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;

        if ( ! $ownerId )
        {
            $ownerId = \f\ttt::dal ( 'core.auth.getOwnerFront' ) ;
        }
        return \f\ttt::service ( 'core.setting.getKeyGroup',
                                 array (
                    'keys'   => array (),
                    'params' => array (
                        'userId'      => $ownerId,
                        'componentId' => 'smsCenter' ) ) ) ;
    }

    public function sendSingleSms ()
    {
        $params   = $this->request->getAssocParams () ;
        $settings = $this->getSmsSetting () ;

        require_once( \f\ifm::app ()->baseDir . "/ifm/lib/nusoap.php" ) ;
        $client = new nusoap_client ( $settings[ 'webService' ], 'wsdl' ) ;

        $paramArray = array (
            'UserName'     => $settings[ 'userName' ]
            ,
            'Pass'         => $settings[ 'passWord' ]
            ,
            'Domain'       => $settings[ 'domain' ]
            ,
            'SmsText'      => $params[ 'txt' ]
            ,
            'MobileNumber' => $params[ 'receiver' ]
            ,
            'SenderNumber' => $settings[ 'senderNumber' ]
            ,
            'sendType'     => 'DynamicText'
            ,
            'smsMode'      => 'SaveInPhone' ) ;

       // \f\pre($paramArray);
        $client->soap_defencoding = 'UTF-8' ;
        $client->decode_utf8      = false ;

        //\f\pre($paramArray);
        $result = $client->call ( 'SendSingleSms',
                                  array (
            'parameters' => $paramArray ), '', '', false, true ) ;

        //\f\pre($result);
        return $result ;
    }

//    public function sendSingleSms()
//    {
//        $params = $this->request->getAssocParams();
//        $settings = $this->getSmsSetting();
////        require_once(\f\ifm::app()->baseDir . "/ifm/lib/nusoap.php");
////        $client = new nusoap_client ($settings['webService'], 'wsdl');
////        $client = new SoapClient($settings['webService']);
//        $paramsArray = [
//            'UserName' => $settings['userName'],
//            'Pass' => $settings['passWord'],
//            'Domain' => $settings['domain'],
//            'SmsText' => $params['txt'],
//            'MobileNumber' => $params['receiver'],
//            'SenderNumber' => $settings['senderNumber'],
//            'sendType' => 'DynamicText',
//            'smsMode' => 'SaveInPhone'];
//        \f\pre($paramsArray);
//
////        $client->soap_defencoding = 'UTF-8';
////        $client->decode_utf8 = false;
//
//        //\f\pre($paramArray);
////        $result = $client->call('SendSingleSms',
////            ['parameters' => $paramsArray], '', '',
////            false, true);
//        $result = $client->SendSingleSms($paramsArray)->SendSmsResult;
//        return $result;
//    }

    public function sendGroupSms ()
    {
        $params   = $this->request->getAssocParams () ;
        $settings = $this->getSmsSetting () ;

        if ( $settings[ 'webService' ] )
        {
            $client     = new SoapClient ( $settings[ 'webService' ] ) ;
//            $paramArray = array (
//                'UserName' => $settings[ 'userName' ]
//                ,
//                'Pass'     => $settings[ 'passWord' ]
//                ,
//                'Domain'   => $settings[ 'domain' ] ) ;
//
//            $client->Login ( $paramArray ) ;


            $paramArray = array (
                'UserName'     => $settings[ 'userName' ]
                ,
                'Pass'         => $settings[ 'passWord' ]
                ,
                'Domain'       => $settings[ 'domain' ]
                ,
                'SmsText'      => $params[ 'txt' ]
                ,
                'MobileNumber' => $params[ 'receiver' ]
                ,
                'SenderNumber' => $settings[ 'senderNumber' ]
                ,
                'sendType'     => 'DynamicText'
                ,
                'smsMode'      => 'SaveInPhone' ) ;

            

            $result = $client->SendSms ( $paramArray )->SendSmsResult->long ;

            if ( $result > 0 || $result[ 0 ] > 0 )
            {
                $result = array (
                    'success',
                    \f\ifm::t ( 'smsSend' ),
                    $settings[ 'senderNumber' ] ) ;
            }
            else
            {
                $result = array (
                    'error',
                    \f\ifm::t ( 'faildSendSms' ) ) ;
            }
        }
        else
        {
            $result = array (
                'error',
                \f\ifm::t ( 'noSmsSettings' ) ) ;
        }
        return $result ;
    }

    public function credit ()
    {
        $settings = $this->getSmsSetting () ;
        if ( $settings[ 'webService' ] )
        {
            require_once( \f\ifm::app ()->baseDir . "/ifm/lib/nusoap.php" ) ;
            $client = new nusoap_client ( 'http://panel.payamakpardaz.com/smssendwebserviceforphp.asmx?wsdl',
                                          'wsdl' ) ;

            $paramArray = array (
                'UserName' => $settings[ 'userName' ]
                ,
                'Pass'     => $settings[ 'passWord' ]
                ,
                'Domain'   => $settings[ 'domain' ] ) ;

            //$client->Login ( $paramArray ) ;
            //\f\pre($paramArray);
            $result = $client->call ( 'getCredit',
                                      array (
                'parameters' => $paramArray ), '', '', false, true ) ;
        }
        else
        {
            $result = array (
                'error',
                \f\ifm::t ( 'noSmsSettings' ) ) ;
        }
        return $result ;
    }

    public function sendSingleSmsWithSave ()
    {
        $params = $this->request->getAssocParams () ;

        //\f\pr($params);
        $settings = $params[ 'setting' ] ;

        require_once( \f\ifm::app ()->baseDir . "/ifm/lib/nusoap.php" ) ;
        $client = new nusoap_client ( 'http://pzi.ir/smsSendWebService.asmx?wsdl',
                                      'wsdl' ) ;

        $paramArray = array (
            'UserName' => $settings[ 'userName' ]
            ,
            'Pass'     => $settings[ 'passWord' ]
            ,
            'Domain'   => $settings[ 'domain' ] ) ;

        $result = $client->call ( 'Login',
                                  array (
            'parameters' => $paramArray ), '', '', false, true ) ;

        $paramArray = array (
            'SmsText'      => $params[ 'txt' ]
            ,
            'MobileNumber' => $params[ 'receiver' ]
            ,
            'SenderNumber' => $settings[ 'senderNumber' ]
            ,
            'smsMode'      => 'SaveInPhone' ) ;

        $client->soap_defencoding = 'UTF-8' ;
        $client->decode_utf8      = false ;

        $result = $client->call ( 'SendSingleSms',
                                  array (
            'parameters' => $paramArray ), '', '', false, true ) ;
        //\f\pr($result);

        $params[ 'result' ] = $result[ 'SendSingleSmsResult' ] ;
        \f\ttt::dal ( 'core.setting.sms.saveMessage', $params ) ;
        return $result ;
    }

    public function sendSmsArdinData ()
    {
        require_once( \f\ifm::app ()->baseDir . "/ifm/lib/nusoap/nusoap.php" ) ;

        $client = new soapclient_nu ( 'http://www.zsg.ir/webservice/soap/smsService.php?wsdl',
                                      'wsdl' ) ;


        $client->soap_defencoding = 'UTF-8' ;
        $client->decode_utf8      = false ;
        $err                      = $client->getError () ;

        $settings = $this->getSmsSetting () ;
        $param    = $this->request->getAssocParams () ;

        //\f\pre($settings);

        $params = array (
            'username'         => $settings[ 'userName' ],
            'password'         => $settings[ 'passWord' ],
            'sender_number'    => array (
                $settings[ 'senderNumber' ] ),
            'receiver_number'  => array (
                $param[ 'reciver_number' ] ),
            'note'             => array (
                $param[ 'message' ] ),
            'date'             => array (
                '0' ),
            'request_uniqueid' => array (),
            'flash'            => 'no',
            'onlysend'         => 'ok',
                ) ;



        $md_res = $client->call ( "send_sms", $params ) ;

        // Check for errors
        $err2 = $client->getError () ;
        if ( $err2 )
        {
            echo '<h2>Error</h2><pre>' . $err2 . '</pre>' ;
        }
        else
        {
            //print_r( $md_res);
        }

        // echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
        //echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
        //echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->debug_str, ENT_QUOTES) . '</pre>';
    }

}
