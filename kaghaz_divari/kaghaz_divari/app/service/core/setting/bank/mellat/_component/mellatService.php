<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \chartex\core\mellatBankCenter
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class mellatService extends \f\service
{

    public function mellatBankSettingSave ()
    {
        $param = $this->request->getAssocParams () ;



        \f\ttt::service ( 'core.setting.saveKeyGroup',
                          array (
            'keyValues' => $param,
            'params'    => array (
                'userId'      => \f\ttt::dal ( 'core.auth.getUserOwner' ),
                'componentId' => 'mellatBankSetting' ) ) ) ;

        $data = array (
            'result'  => 'success',
            'message' => \f\ifm::t ( 'saveSettings' ) ) ;

        return $data ;
    }

    public function getMellatBankSetting ()
    {
	$ownerId=\f\ttt::dal ( 'core.auth.getUserOwner' );
        
        if(!$ownerId)
        {
            $ownerId=\f\ttt::dal ( 'core.auth.getOwnerFront' );
        }
		
        return \f\ttt::service ( 'core.setting.getKeyGroup',
                                 array (
                    'keys' => array ( ),
                    'params' => array (
                        'userId'      => $ownerId,
                        'componentId' => 'mellatBankSetting' ) ) ) ;
    }

    public function mellatPay ()
    {
        $params   = $this->request->getAssocParams () ;
        $settings = $this->getMellatBankSetting () ;

        $price       = $params[ 'price' ] ;
        $callbackUrl = $params[ 'callbackUrl' ] ;
        $save        = (is_array ( $params[ 'save' ] )) ? $params[ 'save' ] : array ( ) ;

        require_once( \f\ifm::app ()->baseDir . "/ifm/lib/nusoap.php" ) ;

        $client    = new nusoap_client ( 'https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl' ) ;
        $namespace = 'http://interfaces.core.sw.bps.com/' ;

        $terminalId   = $settings[ 'terminalID' ] ;
        $userName     = $settings[ 'userName' ] ;
        $userPassword = $settings[ 'passWord' ] ;
        $orderId      = rand ( 0, 1000 ) + date ( Hms ) ;
        $amount       = $price ;

        $localDate      = date ( Ymd ) ;
        $localTime      = date ( Hms ) ;
        $additionalData = "" ;

        $callBackUrl = $callbackUrl ;

        $payerId = 0 ;
        $err = $client->getError () ;
        if ( $err )
        {
            echo '<h2>Constructor error</h2><pre>' . $err . '</pre>' ;
            die () ;
        }

        $parameters = array (
            'terminalId'     => $terminalId,
            'userName'       => $userName,
            'userPassword'   => $userPassword,
            'orderId'        => $orderId,
            'amount'         => $amount,
            'localDate'      => $localDate,
            'localTime'      => $localTime,
            'additionalData' => $additionalData,
            'callBackUrl'    => $callBackUrl,
            'payerId'        => $payerId
        ) ;
        $result          = $client->call ( 'bpPayRequest', $parameters,
            $namespace ) ;
        // Check for a fault
        if ( $client->fault )
        {
            return array('result'=>'error','message' => 'خطا در اتصال به درگاه بانک!');

        }
        else
        {
            // Check for errors
            $resultStr = $result ;
            $err       = $client->getError () ;
            if ( $err )
            {
                return array('result'=>'error','message' => 'خطا در اتصال به درگاه بانک!');
            }
            else
            {
                $res = explode ( ',', $resultStr ) ;

                $ResCode = $res[ 0 ] ;

                $save[ 1 ][ 'bankid' ]  = 'mellat' ;
                $save[ 1 ][ 'orderid' ] = $orderId ;
                if ( $ResCode == "0" && $result )
                {
                    $result = \f\ttt::dal ( 'core.setting.bank.savePay', $save ) ;

                    return array ( 'result'  => 'success', 'message' => 'در حال اتصال به درگاه بانک ملت ...', 'params'  => array ( 'authority' => $res[ 1 ], 'bank'      => 'mellat' ), 'func'      => 'goToBank' ) ;
                }
                else
                {
                    return array ( 'result'  => 'error', 'message' => 'خطا در اتصال به درگاه بانک!' ) ;

                }
            }// end Display the result
        }// end Check for errors
    }

    public function verifyMellat ()
    {
        $params   = $this->request->getAssocParams () ;
        $settings = $this->getMellatBankSetting () ;
        require_once( \f\ifm::app ()->baseDir . "/ifm/lib/nusoap.php" ) ;
        $client    = new nusoap_client ( 'https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl' ) ;
        $namespace = 'http://interfaces.core.sw.bps.com/' ;

        $terminalId   = $settings[ 'terminalID' ] ;
        $userName     = $settings[ 'userName' ] ;
        $userPassword = $settings[ 'passWord' ] ;

        $orderId               = $params[ 'orderId' ] ;
        $verifySaleOrderId     = $params[ 'orderId' ] ;
        $verifySaleReferenceId = $params[ 'refrenceId' ] ;


        $err = $client->getError () ;
        if ( $err )
        {
            echo '<h2>Constructor error</h2><pre>' . $err . '</pre>' ;
            die () ;
        }

        $parameters = array (
            'terminalId'      => $terminalId,
            'userName'        => $userName,
            'userPassword'    => $userPassword,
            'orderId'         => $orderId,
            'saleOrderId'     => $verifySaleOrderId,
            'saleReferenceId' => $verifySaleReferenceId ) ;

        // Call the SOAP method
        $result = $client->call ( 'bpVerifyRequest', $parameters, $namespace ) ;

        // Check for a fault
        if ( $client->fault )
        {
            echo '<h2>Fault</h2><pre>' ;
            print_r ( $result ) ;
            echo '</pre>' ;
            die () ;
        }
        else
        {
            $resultStr = $result ;
            $err = $client->getError () ;
            if ( $err )
            {
                // Display the error
                echo '<h2>Error</h2><pre>' . $err . '</pre>' ;
                die () ;
            }
            else
            {
                return $resultStr ;
                //echo "<script>alert('Verify Response is : " . $resultStr . "');</script>" ;
                //echo "Verify Response is : " . $resultStr ;
            }// end Display the result
        }// end Check for errors
    }

    public function settleMellat ()
    {
        $params   = $this->request->getAssocParams () ;
        $settings = $this->getMellatBankSetting () ;

        require_once( \f\ifm::app ()->baseDir . "/ifm/lib/nusoap.php" ) ;

        $client    = new nusoap_client ( 'https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl' ) ;
        $namespace = 'http://interfaces.core.sw.bps.com/' ;

        $terminalId   = $settings[ 'terminalID' ] ;
        $userName     = $settings[ 'userName' ] ;
        $userPassword = $settings[ 'passWord' ] ;

        $orderId               = $params[ 'orderId' ] ;
        $settleSaleOrderId     = $params[ 'orderId' ] ;
        $settleSaleReferenceId = $params[ 'refrenceId' ] ;


        $err = $client->getError () ;
        if ( $err )
        {
            echo '<h2>Constructor error</h2><pre>' . $err . '</pre>' ;
            die () ;
        }

        $parameters = array (
            'terminalId'      => $terminalId,
            'userName'        => $userName,
            'userPassword'    => $userPassword,
            'orderId'         => $orderId,
            'saleOrderId'     => $settleSaleOrderId,
            'saleReferenceId' => $settleSaleReferenceId ) ;



        // Call the SOAP method
        $result = $client->call ( 'bpSettleRequest', $parameters, $namespace ) ;

        // Check for a fault
        if ( $client->fault )
        {
            echo '<h2>Fault</h2><pre>' ;
            print_r ( $result ) ;
            echo '</pre>' ;
            die () ;
        }
        else
        {

            $resultStr = $result ;

            $err = $client->getError () ;
            if ( $err )
            {
                // Display the error
                echo '<h2>Error</h2><pre>' . $err . '</pre>' ;
                die () ;
            }
            else
            {
                return $resultStr ;
                //echo "<script>alert('Verify Response is : " . $resultStr . "');</script>" ;
                //echo "Verify Response is : " . $resultStr ;
            }// end Display the result
        }// end Check for errors
    }

    public function reversalMellat ()
    {
        $params   = $this->request->getAssocParams () ;
        $settings = $this->getMellatBankSetting () ;

        require_once( \f\ifm::app ()->baseDir . "/ifm/lib/nusoap.php" ) ;

        $client    = new nusoap_client ( 'https://bpm.shaparak.ir/pgwchannel/services/pgw?wsdl' ) ;
        $namespace = 'http://interfaces.core.sw.bps.com/' ;

        $terminalId   = $settings[ 'terminalID' ] ;
        $userName     = $settings[ 'userName' ] ;
        $userPassword = $settings[ 'passWord' ] ;

        $orderId               = $params[ 'orderId' ] ;
        $reversalSaleOrderId     = $params[ 'orderId' ] ;
        $reversalSaleReferenceId = $params[ 'refrenceId' ] ;


        $err = $client->getError () ;
        if ( $err )
        {
            echo '<h2>Constructor error</h2><pre>' . $err . '</pre>' ;
            die () ;
        }
        $parameters = array (
            'terminalId'      => $terminalId,
            'userName'        => $userName,
            'userPassword'    => $userPassword,
            'orderId'         => $orderId,
            'saleOrderId'     => $reversalSaleOrderId,
            'saleReferenceId' => $reversalSaleReferenceId ) ;

        // Call the SOAP method
        $result = $client->call ( 'bpReversalRequest', $parameters, $namespace ) ;

        // Check for a fault
        if ( $client->fault )
        {
            echo '<h2>Fault</h2><pre>' ;
            print_r ( $result ) ;
            echo '</pre>' ;
            die () ;
        }
        else
        {
            $resultStr = $result ;

            $err = $client->getError () ;
            if ( $err )
            {
                // Display the error
                echo '<h2>Error</h2><pre>' . $err . '</pre>' ;
                die () ;
            }
            else
            {
                return $resultStr;
            }// end Display the result
        }// end Check
    }

}
