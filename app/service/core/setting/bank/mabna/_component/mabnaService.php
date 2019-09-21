<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \chartex\core\mabnaBankCenter
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class mabnaService extends \f\service
{

    public function mabnaBankSettingSave ()
    {
        $param = $this->request->getAssocParams () ;

        \f\ttt::service ( 'core.setting.saveKeyGroup',
                          array (
            'keyValues' => $param,
            'params'    => array (
                'userId'      => \f\ttt::dal ( 'core.auth.getUserOwner' ),
                'componentId' => 'mabnaBankSetting' ) ) ) ;

        $data = array (
            'result'  => 'success',
            'message' => \f\ifm::t ( 'saveSettings' ) ) ;

        return $data ;
    }

    public function getMabnaBankSetting ()
    {
        $userId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;
        if ( ! $userId )
        {
            $userId = \f\ttt::dal ( 'core.auth.getOwnerFront' ) ;
        }
        return \f\ttt::service ( 'core.setting.getKeyGroup',
                                 array (
                    'keys' => array ( ),
                    'params' => array (
                        'userId'      => $userId,
                        'componentId' => 'mabnaBankSetting' ) ) ) ;
    }

    public function mabnaPay ()
    {
        $params   = $this->request->getAssocParams () ;
        $settings = $this->getMabnaBankSetting () ;
		
		//\f\pre($params);

        $__AMT           = ! empty ( $params[ 'price' ] ) ? $params[ 'price' ] : 0 ;
        $__CRN           = rand ( 0, 1000 ) + date ( Hms ) ;         // seller code
        $__MID           = $settings[ 'merchantID' ] ;   // merchant ID
        $__TID           = $settings[ 'terminalID' ] ;         // terminal ID
        $__PUBLIC_KEY    = $settings[ 'publicKey' ] ;
        $__PRIVATE_KEY   = $settings[ 'privateKey' ] ;
        $__REFADD        = $params[ 'callbackUrl' ] ;   //referral Address
        $__REFRENCE_SOAP = "https://mabna.shaparak.ir/TokenService?wsdl" ;
		//\f\pre($__REFADD);

        //$row = \f\ttt::dal ( 'core.setting.bank.getInfoPay', $params ) ;
        $save        = (is_array ( $params[ 'save' ] )) ? $params[ 'save' ] : array ( ) ;

        require_once( \f\ifm::app ()->baseDir . "/ifm/lib/nusoap.php" ) ;

        $client = new nusoap_client ( $__REFRENCE_SOAP, 'wsdl' ) ;

        $error = $client->getError () ;
        print_r ( $error ) ;
		
		$source = $__AMT . $__CRN . $__MID . $__REFADD . $__TID;

        $pub_key = $__PUBLIC_KEY ;


        $key_resource = openssl_get_publickey ( $pub_key ) ;

        // Amount
        openssl_public_encrypt ( $__AMT, $crypt_text, $key_resource ) ;
        $Amount = base64_encode ( $crypt_text ) ;

		
// CRN
        openssl_public_encrypt ( $__CRN, $crypt_text, $key_resource ) ;
        $CRN = base64_encode ( $crypt_text ) ;

// MID
        openssl_public_encrypt ( $__MID, $crypt_text, $key_resource ) ;
        $MID = base64_encode ( $crypt_text ) ;

// TID
        openssl_public_encrypt ( $__TID, $crypt_text, $key_resource ) ;
        $TID = base64_encode ( $crypt_text ) ;

// Referral address
        openssl_public_encrypt ( $__REFADD, $crypt_text, $key_resource ) ;
        $referral = base64_encode ( $crypt_text ) ;

        $key      = $__PRIVATE_KEY ;
        $private_key = openssl_pkey_get_private ( $key ) ;

        $signature = '' ;
		
		//\f\pre($private_key);
        if ( ! openssl_sign ( $source, $signature, $private_key,
                              OPENSSL_ALGO_SHA1 ) )
        {
			
            return array ( 'result'  => 'error', 'message' => 'خطا در اتصال به درگاه بانک!' ) ;
        }

// make proper array of token params
        $inputArray = array (
            "Token_param" =>
            array (
                "AMOUNT"        => $Amount,
                "CRN"           => $CRN,
                "MID"           => $MID,
                "REFERALADRESS" => $referral,
                "SIGNATURE"     => base64_encode ( $signature ),
                "TID"           => $TID,
            )
                ) ;
        $WSResult       = $client->call ( "reservation", $inputArray ) ;
        $error          = $client->getError () ;

// final signature is created
        $signature = base64_decode ( $WSResult[ "return" ][ "signature" ] ) ;

// state whether signature is okay or not
        $ok = openssl_verify ( $WSResult[ "return" ][ "token" ], $signature,
                               $key_resource ) ;

// free the key from memory
        openssl_free_key ( $key_resource ) ;
		
		
		//\f\pre( $WSResult);

        if ( $ok == 1 )
        {
            $save[ 1 ][ 'bankid' ]  = 'mabna' ;
            $save[ 1 ][ 'orderid' ] = $__CRN;
            \f\ttt::dal ( 'core.setting.bank.savePay',$save ) ;

            return array ( 'result'  => 'success', 'message' => 'در حال اتصال به درگاه بانک...', 'params'  => array ( 'authority' => $WSResult[ "return" ][ "token" ], 'bank'      => 'mabna' ), 'func'      => 'goToBank' ) ;
        }
        elseif ( $ok == 0 )
        {
            return array ( 'result'  => 'error', 'message' => 'خطا در اتصال به درگاه بانک!' ) ;
        }
        else
        {
            return array ( 'result'  => 'error', 'message' => 'خطا در اتصال به درگاه بانک!' ) ;
        }
    }

    public function checkMabna ()
    {
        $params   = $this->request->getAssocParams () ;
        $settings = $this->getMabnaBankSetting () ;

       // $__AMT           = ! empty ( $params[ 'AMOUNT' ] ) ? $params[ 'AMOUNT' ] : 0 ;
        $__CRN           = $params[ 'CRN' ];      // seller code
        $__MID           = $settings[ 'merchantID' ] ;   // merchant ID
        $__TID           = $settings[ 'terminalID' ] ;         // terminal ID
        $__PUBLIC_KEY    = $settings[ 'publicKey' ] ;
        $__PRIVATE_KEY   = $settings[ 'privateKey' ] ;
        //$__REFADD        = "http://abzar-online.com/e-payment/verify.php" ;   //referral Address
        $__REFRENCE_SOAP = "https://mabna.shaparak.ir/TransactionReference/TransactionReference?wsdl" ;

        //$row = \f\ttt::dal ( 'core.setting.bank.getInfoPay', $params ) ;


        require_once( \f\ifm::app ()->baseDir . "/ifm/lib/nusoap.php" ) ;

        $client = new nusoap_client ( $__REFRENCE_SOAP, 'wsdl' ) ;

        $error = $client->getError () ;
        print_r ( $error ) ;


        $pub_key = $__PUBLIC_KEY ;


        $key_resource = openssl_get_publickey ( $pub_key ) ;

// Digital receipts buy
        openssl_public_encrypt ( $_POST[ "TRN" ], $crypttext, $key_resource ) ;
        $TRN = base64_encode ( $crypttext ) ;

// CRN
        openssl_public_encrypt ( $__CRN, $crypttext, $key_resource ) ;
        $CRN = base64_encode ( $crypttext ) ;

// MID
        openssl_public_encrypt ( $__MID, $crypttext, $key_resource ) ;
        $MID = base64_encode ( $crypttext ) ;

// Sign data
        $source    = $__MID . $params[ "TRN" ] . $__CRN ;
        $key       = $__PRIVATE_KEY ;
        $priv_key  = openssl_pkey_get_private ( $key ) ;
        $signature = '' ;
        if ( ! openssl_sign ( $source, $signature, $priv_key, OPENSSL_ALGO_SHA1 ) )
        {
            
        }
        

        $inputArray = array (
            "SaleConf_req" => array (
                "MID"       => $MID,
                "CRN"       => $CRN,
                "TRN"       => $TRN,
                "SIGNATURE" => base64_encode ( $signature )
            )
                ) ;

        $WSResult = $client->call ( "sendConfirmation", $inputArray ) ;
		
        $error    = $client->getError () ;

//echo "<HR>signature:<BR>";
        $signature = base64_decode ( $WSResult[ "return" ][ "SIGNATURE" ] ) ;
        $data      = $WSResult[ "return" ][ "RESCODE" ] . $WSResult[ "return" ][ "REPETETIVE" ] . $WSResult[ "return" ][ "AMOUNT" ] . $WSResult[ "return" ][ "DATE" ] . $WSResult[ "return" ][ "TIME" ] . $WSResult[ "return" ][ "TRN" ] . $WSResult[ "return" ][ "STAN" ] ;

// state whether signature is okay or not
        $ok = openssl_verify ( $data, $signature, $key_resource ) ;

        if ( ! empty ( $WSResult[ 'return' ][ 'RESCODE' ] ) )
        {

            // success
            if ( ($WSResult[ 'return' ][ 'RESCODE' ] == '00') && ($WSResult[ 'return' ][ 'successful' ] == true) )
            {
                return array ( 'result'  => 'success', 'message' => $WSResult[ 'return' ][ 'TRN' ] ) ;


                // cancel
            }
            elseif ( $WSResult[ 'return' ][ 'RESCODE' ] == '200' )
            {
                return array ( 'result'  => 'error', 'message' => 'cancel' ) ;
            }
            elseif ( $WSResult[ 'return' ][ 'RESCODE' ] == '107' )
            {

                return array ( 'result'  => 'error', 'message' => 'cancel' ) ;

                // other problem
            }
            elseif ( $WSResult[ 'return' ][ 'description' ] != "" )
            {
                return array ( 'result'  => 'error', 'message' => 'errorPay' ) ;
            }
        }
        else
        {

            return array ( 'result'  => 'error', 'message' => 'invalidPay' ) ;
        }

    }

}
