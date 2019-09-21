<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \chartex\core\pasargadBankCenter
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class pasargadService extends \f\service
{

    public function pasargadBankSettingSave ()
    {
        $param = $this->request->getAssocParams () ;

        \f\ttt::service ( 'core.setting.saveKeyGroup',
                          array (
            'keyValues' => $param,
            'params'    => array (
                'userId'      => \f\ttt::dal ( 'core.auth.getUserOwner' ),
                'componentId' => 'pasargadBankSetting' ) ) ) ;

        $data = array (
            'result'  => 'success',
            'message' => \f\ifm::t ( 'saveSettings' ) ) ;

        return $data ;
    }
    public function getPasargadBankSetting ()
    {
        return \f\ttt::service ( 'core.setting.getKeyGroup',
                                 array (
                    'keys'   => array (),
                    'params' => array (
                        'userId'      => \f\ttt::dal ( 'core.auth.getUserOwner' ),
                        'componentId' => 'pasargadBankSetting' ) ) ) ;
    }
    public function pasargadPay ()
    {
        require_once( \f\ifm::app ()->baseDir."/ifm/lib/pasargad/RSAProcessor.class.php" );
        require_once( \f\ifm::app ()->baseDir."/ifm/lib/pasargad/parser.php" );
        
        $params =  $this->request->getAssocParams();
        $settings=  $this->getPasargadBankSetting();
        
        $price=  $params['price'];
        $callbackUrl=$params['callbackUrl'];
        $save=  (is_array($params['save']))?$params['save']:array();
        
       
        //$p=new RSAProcessor

        $processor = new RSAProcessor ( \f\ifm::app ()->baseDir . \f\DS . 'upload' . \f\DS . 'bank' . \f\DS . 'pasargad' . \f\DS . $settings[ 'terminalID' ].".xml",
                                        RSAKeyType::XMLFile ) ;

        $terminalCode = $settings[ 'terminalID' ] ;
        $merchantCode = $settings[ 'merchantID' ] ;


        $amount          = $price ; // مبلغ فاكتور
        $redirectAddress = $callbackUrl ;
        $invoiceNumber   = rand ( 0, 1000 ) + date ( Hms ) ; //شماره فاكتور
        $timeStamp       = date ( "Y/m/d H:i:s" ) ;
        $invoiceDate     = date ( "Y/m/d H:i:s" ) ; //تاريخ فاكتور
        $action          = "1003" ;  // 1003 : براي درخواست خريد 

        $data   = "#" . $merchantCode . "#" . $terminalCode . "#" . $invoiceNumber . "#" . $invoiceDate . "#" . $amount . "#" . $redirectAddress . "#" . $action . "#" . $timeStamp . "#" ;
        $data   = sha1 ( $data, true ) ;
        $data1  = $processor->sign ( $data ) ; // امضاي ديجيتال 
        $result = base64_encode ( $data1 ) ; // base64_encode 

        if ( $result )
        {
            $save[ 1 ][ 'bankid' ]  ='pasargad' ;
            $save[ 1 ][ 'orderid' ] = $invoiceNumber ;

            $res=\f\ttt::dal( 'core.setting.bank.savePay',$save);

            $data = array (
                'pasargad',
                'اتصال به درگاه بانک پاسارگاد',
                $merchantCode,
                $terminalCode,
                $invoiceNumber,
                $invoiceDate,
                $amount,
                $timeStamp,
                $result,
                $action,
                $redirectAddress ) ;
            echo json_encode ( $data ) ;
        }

        //$sendingData =  "merchantCode=". $merchantCode ."&terminalCode=". $terminalCode ."&invoiceNumber=". $invoiceNumber ."&invoiceDate=". $invoiceDate ."&amount=". $amount ."&timeStamp=". $timeStamp ."&sign=".$result."&redirectAddress=".$redirectAddress."&action=".$action;
    }

    /*     * ********************************************************* */
    public function checkPasargad ()
    {
        
        //require_once( \f\ifm::app ()->baseDir."/ifm/lib/pasargad/RSAProcessor.class.php" );
        require_once( \f\ifm::app ()->baseDir."/ifm/lib/pasargad/parser.php" );
        
        $params =  $this->request->getAssocParams();
        $settings=  $this->getPasargadBankSetting();

        $orderId=$params['orderId'];
        $SaleReferenceId=$params[' SaleReferenceId'];
        $resCode=$params['resCode'];
        //pr($_GET);
        $fields = array (
            'invoiceUID' => $SaleReferenceId ) ;
        //pr($fields);
        $result = post2https ( $fields,
                               'https://pep.shaparak.ir/CheckTransactionResult.aspx' ) ;
        $array  = makeXMLTree ( $result ) ;

        //pr($array);
        //pre($array["resultObj"]["result"]);
        $this->verifyPasargad($array[ "resultObj" ]);

        return $array[ "resultObj" ][ "result" ] ;
    }

    public function verifyPasargad ($payInfo)
    {
        require_once( \f\ifm::app ()->baseDir."/ifm/lib/pasargad/RSAProcessor.class.php" );
        require_once( \f\ifm::app ()->baseDir."/ifm/lib/pasargad/parser.php" );

        $fields = array (
            'MerchantCode'  => $payInfo['merchantCode'], //shomare ye moshtari e shoma.
            'TerminalCode'  => $payInfo['terminalCode'], //shomare ye terminal e shoma.
            'InvoiceNumber' => $payInfo['invoiceNumber'], //shomare ye factor tarakonesh.
            'InvoiceDate'   => $payInfo['invoiceDate'], //tarikh e tarakonesh.
            'amount'        => $payInfo['amount'], //mablagh e tarakonesh. faghat adad.
            'TimeStamp'     => date ( "Y/m/d H:i:s" ), //zamane jari ye system.
            'sign'          => ''        //reshte ye ersali ye code shode. in mored automatic por mishavad. 
        ) ;
        
        

        $processor = new RSAProcessor ( \f\ifm::app ()->baseDir . \f\DS . 'upload' . \f\DS . 'bank' . \f\DS . 'pasargad' . \f\DS . $settings[ 'terminalID' ].".xml",
                                        RSAKeyType::XMLFile ) ;

        $data           = "#" . $fields[ 'MerchantCode' ] . "#" . $fields[ 'TerminalCode' ] . "#" . $fields[ 'InvoiceNumber' ] . "#" . $fields[ 'InvoiceDate' ] . "#" . $fields[ 'amount' ] . "#" . $fields[ 'TimeStamp' ] . "#" ;
        $data           = sha1 ( $data, true ) ;
        $data           = $processor->sign ( $data ) ;
        $fields[ 'sign' ] = base64_encode ( $data ) ; // base64_encode 
        
        //pr($fields);
        //$sendingData  = "MerchantCode=" . $merchantCode . "&TerminalCode=" . $terminalCode . "&InvoiceNumber=" . $invoiceNumber . "&InvoiceDate=" . $invoiceDate . "&amount=" . $amount . "&TimeStamp=" . $timeStamp . "&sign=" . $fields[ 'sign' ] ;
        $verifyresult = post2https ( $fields,'https://pep.shaparak.ir/VerifyPayment.aspx' ) ;
        $array        = makeXMLTree ( $verifyresult ) ;
        
       // pr($array);
	
     
       
    }


}
