<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \chartex\crm\marketing\slide
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class discountService extends \f\service
{

    /**
     *
     * @var shortcutMapper 
     */
    private $mapper ;

    public function __construct ()
    {
        $this->mapper = \f\dalFactory::make ( 'shop.discount' ) ;
    }

    public function discountList ()
    {
        return \f\ttt::dal ( 'shop.discount.discountList',
                             $this->request->getAssocParams () ) ;
    }

    public function discountSave ()
    {
        $params = $this->request->getAssocParams () ;
        if ( $params[ 'id' ] )
        {
            $result = \f\ttt::dal ( 'shop.discount.discountSaveEdit', $params ) ;
            $msg    = \f\ifm::t ( 'discountSaveEdit' ) ;
            $reset  = FALSE ;
        }
        else
        {
            $result = \f\ttt::dal ( 'shop.discount.discountSave', $params ) ;
            $msg    = \f\ifm::t ( 'discountSave' ) ;
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

    public function discountDelete ()
    {
        return \f\ttt::dal ( 'shop.discount.discountDelete',
                             $this->request->getAssocParams () ) ;
    }

    public function discountStatus ()
    {
        return \f\ttt::dal ( 'shop.discount.discountStatus',
                             $this->request->getAssocParams () ) ;
    }

    public function getDiscountById ()
    {
        return \f\ttt::dal ( 'shop.discount.getDiscountById',
                             $this->request->getAssocParams () ) ;
    }

    public function checkAndSubmitOffCode ()
    {
        $params = $this->request->getAssocParams () ;
        $this->registerGadgets ( array (
            'dateG' => 'date' ) ) ;
        $params[ 'today' ] = $this->dateG->today () ;
        $result = \f\ttt::dal ( 'shop.discount.checkAndSubmitOffCode', $params ) ;

        if ( $result )
        {
            $orderDiscountCode = \f\ttt::service ( 'shop.order.getOrderDiscountCode',
                                                   array (
                        'user_id'     => $params[ 'userId' ],
                        'order_id'    => $params[ 'orderId' ],
                        'discount_id' => $result[ 'id' ],
                    ) ) ;


             if ( ($result[ 'type_use' ] == 'oneUsePerOrder' && $orderDiscountCode[ 2 ] < 1) || ($result[ 'type_use' ] == 'unlimit') || ($result[ 'type_use' ] == 'oneUse' && $orderDiscountCode[ 0 ] < 1) )
                {
                    $priceProduct       = str_replace( ',','',$params['productPrice'] );

                    if ( $result[ 'type_discount' ] == 'percent' )
                    {
                        $discount_price = ($priceProduct * $result[ 'price' ]) / 100 ;
                        $endPrice       = $priceProduct - $discount_price ;
                    }
                    else if ( $result[ 'type_discount' ] == 'fixed' )
                    {
                        $discount_price = ($result[ 'price' ]) ;
                        $endPrice       = ($priceProduct - $discount_price) ;
                    }

                    //\f\pre($discount_price);

//                    \f\ttt::dal ( 'shop.order.orderSaveEdit',
//                                  array (
//                        'id'             => $params[ 'orderId' ],
//                        'discount_id'    => $result[ 'id' ],
//                        'discount_price' => $discount_price,
//                    ) ) ;

                    \f\ttt::dal ( 'shop.discount.saveDiscountOrder',
                                  array (
                        'user_id'        => $params[ 'userId' ],
                        'order_id'       => $params[ 'orderId' ],
                        'discount_id'    => $result[ 'id' ],
                        'discount_price' => $discount_price,
                    ) ) ;

                 $data = [
                     'data' => [ 'endPrice' => $endPrice ] ];
                }
                else
                {
                    $data = array (
                        'result'  => 'error',
                        'message' => 'محدودیت استفاده از این کد تخفیف برای شما به پایان رسیده است.' ) ;
                }
        }
        else
        {
            $data = array (
                'result'  => 'error',
                'message' => 'کد تخفیف وارد شده نامعتبر است.' ) ;
        }
        return $data ;
    }

    public function minesNumberById ()
    {
        return \f\ttt::dal ( 'shop.discount.minesNumberById',
                             $this->request->getAssocParams () ) ;
    }
    public function removeDiscountOrder ()
    {
        
        return \f\ttt::dal ( 'shop.discount.removeDiscountOrder',
                             $this->request->getAssocParams () ) ;
    }
    public function getDiscountOrder ()
    {
        return \f\ttt::dal ( 'shop.discount.getDiscountOrder',
                             $this->request->getAssocParams () ) ;
    }

}
