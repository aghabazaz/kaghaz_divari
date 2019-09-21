<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \payment
 * @payment component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class paymentService extends \f\service
{

    /**
     *
     * @var shortcutMapper 
     */
    private $mapper ;

    public function __construct ()
    {
        $this->mapper = \f\dalFactory::make ( 'payment' ) ;
    }

    public function paymentSave ()
    {
        $params = $this->request->getAssocParams () ;
        if ( $params[ 'id' ] )
        {
            $result = \f\ttt::dal ( 'payment.paymentSaveEdit', $params ) ;
            $msg    = \f\ifm::t ( 'paymentBackURLSuccess' ) ;
            $reset  = FALSE ;
        }
        else
        {
            $result = \f\ttt::dal ( 'payment.paymentSave', $params ) ;
            $msg    = \f\ifm::t ( 'paymentSendURL' ) ;
            $reset  = TRUE ;
        }


        if ( $result )
        {
            $data = array (
                'result'  => 'success',
                'message' => $msg,
                'reset'   => $reset ) ;
        }
        else
        {
            $data = array (
                'result'  => 'error',
                'message' => \f\ifm::t ( 'dbError' ) ) ;
        }

        return $data ;
    }

    public function saveTransactionAndTurns ()
    {
        $row = \f\ttt::dal ( 'payment.saveTransactionAndTurns',
                             $this->request->getAssocParams () ) ;

//        if ( $row[ 'type' ] == 'docBooking' )
//        {
//            $this->sendSmsDocBooking ( $row ) ;
//            $this->sendEmailDocBooking ( $row ) ;
//        }
//        if ( $row[ 'type' ] == 'hallBooking' )
//        {
//            $this->sendSmsHallBooking ( $row ) ;
//            $this->sendEmailHallBooking ( $row ) ;
//        }
    }

}
