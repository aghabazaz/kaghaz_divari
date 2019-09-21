<?php

class paymentView extends \f\view
{

    public function __construct ()
    {
        
    }

    public function renderGetDebtPayFormBlock ()
    {
        return $this->render ( 'debtPayBlock', array () ) ;
    }

    public function renderCallBackBankDetail ( $params, $bank )
    {
        //\f\pr ( $params ) ;

        if ( $bank == 'mellat' )
        {

            $refId = $params[ 'SaleReferenceId' ] ;

            if ( $params[ 'ResCode' ] == 17 )
            {
                //for cancel trans
//                $status = 'cancel' ;
//                \f\ttt::service ( 'booking.removeTransactionAndTurns',
//                                  array (
//                    'orderId' => $params[ 'SaleOrderId' ]
//                ) ) ;
            }
            else
            {
                $result = \f\ttt::service ( 'core.setting.bank.mellat.verifyMellat',
                                            array (
                            'orderId'    => $params[ 'SaleOrderId' ],
                            'refrenceId' => $refId
                        ) ) ;

                //echo $result;

                if ( $result == "0" )
                {
                    $result = \f\ttt::service ( 'core.setting.bank.mellat.settleMellat',
                                                array (
                                'orderId'    => $params[ 'SaleOrderId' ],
                                'refrenceId' => $refId
                            ) ) ;

                    //echo $result;
                    //success => update tbl pay_bank set orderid and refreceid
                    \f\ttt::service ( 'booking.saveTransactionAndTurns',
                                      array (
                        'orderId'    => $params[ 'SaleOrderId' ],
                        'refrenceId' => $refId
                    ) ) ;
                    $status = 'pay' ;
                }
                else
                {
                    $status = 'errorPay' ;
                    $refId  = $params[ 'SaleReferenceId' ] ;
                }
            }
        }
        
        
        return $this->render ( 'callBack',
                               array (
                    'status' => $status,
                    'refId'  => $refId
                ) ) ;        
    }

}
