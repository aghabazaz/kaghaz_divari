<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \chartex\core\zarinpalBankCenter
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class zarinpalService extends \f\service
{

    public function zarinpalBankSettingSave ()
    {
        $param = $this->request->getAssocParams () ;

        \f\ttt::service ( 'core.setting.saveKeyGroup',
                          array (
            'keyValues' => $param,
            'params'    => array (
                'userId'      => \f\ttt::dal ( 'core.auth.getUserOwner' ),
                'componentId' => 'zarinpalBankSetting' ) ) ) ;

        $data = array (
            'result'  => 'success',
            'message' => \f\ifm::t ( 'saveSettings' ) ) ;

        return $data ;
    }

    public function getZarinpalBankSetting ()
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
                        'componentId' => 'zarinpalBankSetting' ) ) ) ;
    }

    public function zarinpalPay ()
    {

        $params = $this->request->getAssocParams () ;


        $settings = $this->getZarinpalBankSetting () ;


		//\f\pr($params);
        $price       = $params[ 'price' ] ;
        $callbackUrl = $params[ 'callbackUrl' ] ;
        $save        = (is_array ( $params[ 'save' ] )) ? $params[ 'save' ] : array ( ) ;

        require_once( \f\ifm::app ()->baseDir . "/ifm/lib/nusoap.php" ) ;

        $MerchantID               = $settings[ 'merchantID' ] ;  //Required
        $Amount                   = $price / 10 ; //Amount will be based on Toman  - Required
        $Description              = $save[1][ 'comment' ] ;  // Required
        $Email                    = '' ; // Optional
        $Mobile                   = '' ; // Optional
        $CallbackURL              = $callbackUrl ;  // Required
        // URL also Can be https://ir.zarinpal.com/pg/services/WebGate/wsdl
        $client                   = new nusoap_client ( 'https://de.zarinpal.com/pg/services/WebGate/wsdl', 'wsdl' ) ;
        $client->soap_defencoding = 'UTF-8' ;
		
		
		$parameter=array (
                'MerchantID'  => $MerchantID,
                'Amount'      => $Amount,
                'Description' => $Description,
                'Email'       => $Email,
                'Mobile'      => $Mobile,
                'CallbackURL' => $CallbackURL
            );
			
		//\f\pr($parameter);
			
        $result                   = $client->call ( 'PaymentRequest',
                                                    array (
            $parameter
                )
                ) ;

		//\f\pr($result);		
        //Redirect to URL You can do it also by creating a form
        if ( $result[ 'Status' ] == 100 )
        {
            $save[ 1 ][ 'orderid' ] = $result[ 'Authority' ] ;


            $res = \f\ttt::dal ( 'core.setting.bank.savePay', $save ) ;
            if ( $res )
            {
                return array ( 'result' => 'success', 'params' => array ( 'authority' => $result[ 'Authority' ],'bank'=>'zarinpal' ), 'func'      => 'goToBank' ) ;
            }
			else
			{
				return array ( 'result'  => 'errordb', 'message' => \f\ifm::t ( 'errorPay' ) ) ;
			}
        }
        else
        {
            return array ( 'result'  => 'error', 'message' => \f\ifm::t ( 'errorPay' ) ) ;
        }
    }

    public function checkZarinpal ()
    {
        $params   = $this->request->getAssocParams () ;
        $settings = $this->getZarinpalBankSetting () ;
        $row = \f\ttt::dal ( 'bank.getInfoPay', $params ) ;


        require_once( \f\ifm::app ()->baseDir . "/ifm/lib/nusoap.php" ) ;

        $MerchantID = $settings[ 'merchantID' ] ;  //Required
        $Amount     = $row[ 'price' ] / 10 ; //Amount will be based on Toman
        $Authority  = $params[ 'Authority' ] ;

        if ( $params[ 'Status' ] == 'OK' )
        {
            // URL also Can be https://ir.zarinpal.com/pg/services/WebGate/wsdl
            $client                   = new nusoap_client ( 'https://de.zarinpal.com/pg/services/WebGate/wsdl', 'wsdl' ) ;
            $client->soap_defencoding = 'UTF-8' ;
            $result                   = $client->call ( 'PaymentVerification',
                                                        array (
                array (
                    'MerchantID' => $MerchantID,
                    'Authority'  => $Authority,
                    'Amount'     => $Amount
                )
                    )
                    ) ;

            if ( $result[ 'Status' ] == 100 )
            {
                $arr = array ( 'refrence_code' => $result[ 'RefID' ], 'status' => 'ok_pay' ) ;
                //echo 'Transation success. RefID:'. $result['RefID'];
            }
            else
            {
                $arr = array ( 'refrence_code' => $result[ 'Status' ],'status' => 'bad_pay' ) ;
            }
        }
        else
        {
            $arr = array ( 'result' => $result, 'status' => 'cancel' ) ;
        }

        //\f\ttt::dal ( 'core.setting.bank.savePay', $save ) ;

        return $arr ;
    }

}
