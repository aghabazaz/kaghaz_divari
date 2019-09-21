<?php

class orderView extends \f\view
{

    public function __construct ()
    {

    }

    public function renderGetCart ()
    {
        if ( $_SESSION[ 'user_id' ] )
        {
            $row             = \f\ttt::service ( 'shop.orderItem.getOrderItemByParamsCart',
                                                 array (
                        'user_id' => $_SESSION[ 'user_id' ],
                        'status'  => 'cart',
                        'gift'=>'no'
                    ) ) ;
            $sRow[ 'title' ] = 'سبد خرید' ;
        }
        else
        {
            header ( 'Location: ' . \f\ifm::app ()->siteUrl . 'login' ) ;
        }

        $content = $this->render ( 'cart',
                                   array (
            'row'  => $row,
            'sRow' => $sRow,
                ) ) ;

        return array (
            $content,
            $sRow ) ;
    }

    public function renderGetShipping ()
    {
        if ( $_SESSION[ 'user_id' ] )
        {
            $member          = \f\ttt::service ( 'member.getMembersByParam',
                                                 array (
                        'id' => $_SESSION[ 'user_id' ],
                    ) ) ;
            $transportations = \f\ttt::service ( 'shop.transportation.getTransportationByParam',
                                                 array (
                        'status' => 'enabled',
                    ) ) ;
            $orderId         = \f\ttt::service ( 'shop.order.getOrderByUserId',
                                                 array (
                        'id'       => $_SESSION[ 'user_id' ],
                        'status'   => 'cart',
                        'selected' => 't1.id,t1.transportation_id'
                    ) ) ;
            $sRow[ 'title' ] = 'اطلاعات ارسال سفارش' ;
        }
        else
        {
            header ( 'Location: ' . \f\ifm::app ()->siteUrl . 'login' ) ;
        }
        $content = $this->render ( 'shipping',
                                   array (
            'member'     => $member,
            'transports' => $transportations,
            'orderId'    => $orderId[ 'id' ],
            'transId'    => $orderId[ 'transportation_id' ],
                ) ) ;

        return array (
            $content,
            $sRow ) ;
    }

    public function renderGetReview ()
    {
        //\f\pre($_SESSION);
        if ( $_SESSION[ 'user_id' ] )
        {
            $orderItem = \f\ttt::service ( 'shop.orderItem.getOrderItemByParams',
                                           array (
                        'user_id' => $_SESSION[ 'user_id' ],
                        'status'  => 'cart',
                        'order_id'=>$_SESSION['order_id']
                    ) ) ;

            $orderItemGroupProductId = \f\ttt::dal ( 'shop.orderItem.getOrderItemByParamsGroupByProIdForGifts',
                array (
                    'user_id' => $_SESSION[ 'user_id' ],
                    'status'  => 'cart',
                    'order_id'=>$_SESSION['order_id']
                ) ) ;
            foreach ($orderItemGroupProductId as $item) {
                $stockProductGift = \f\ttt::dal('shop.product.getStockOfGift', $item);
                $productGifts=\f\ttt::dal('shop.orderItem.getGiftsOrders', $item);
                if ($item['active_gift_section']=='enabled' and $stockProductGift['stockGift']>=$item['m_free'] and empty($productGifts) and $item['n_buy']<=$item['sumCount']) {
                    //save to shop_order_item va kam kardan stock
                    \f\ttt::dal('shop.orderItem.orderItemGiftSave',array(
                        'order_id'=>$item['order_id'],
                        'product_price_id'=>$item['shop_product_gift_id'],
                        'count'=>$item['m_free'],
                        'date_register'=>time(),
                        'price'=>0,
                        'discount_price'=>0,
                        'discount_type'=>NULL,
                        'shop_product_id'=>$item['shop_product_id'],
                        'gift'=>'yes',
                        'type_discount'=>NULL,
                        'discount_price'=>NULL,
                        'parent'=>$item['shop_product_id'],
                        'stock'=>($stockProductGift['stockGift']-$item['m_free'])
                    ));
                }else if(!empty($productGifts) and $item['n_buy']>$item['count']){
                    \f\ttt::dal('shop.orderItem.orderItemGiftDelete',array(
                        'order_id'=>$item['order_id'],
                        'product_price_id'=>$item['shop_product_gift_id'],
                        'stock'=>($stockProductGift['stockGift']+$item['m_free']),
                        'parent_pro'=>$item['shop_product_id'],
                        'parent_order'=>$item['order_id'],

                    ));
                }
            }
            $member = \f\ttt::service ( 'member.getMembersByParam',
                                        array (
                        'id' => $_SESSION[ 'user_id' ],
                    ) ) ;

            $orderItem = \f\ttt::service ( 'shop.orderItem.getOrderItemByParams',
                array (
                    'user_id' => $_SESSION[ 'user_id' ],
                    'status'  => 'cart',
                ) ) ;
            $rowOrderItem             = \f\ttt::dal ( 'shop.orderItem.getOrderItemByParamsReview',
                array (
                    'user_id' => $_SESSION[ 'user_id' ],
                    'status'  => 'cart',
                    // 'gift'=>'no'
                ) ) ;

            //\f\pre($rowOrderItem);
            $orderTransport = \f\ttt::service ( 'shop.order.getOrderByParam',
                                                array (
                        'user_id' => $_SESSION[ 'user_id' ],
                        'id'      => $orderItem[ 0 ][ 'order_id' ]
                    ) ) ;
        }
        else
        {
            header ( 'Location: ' . \f\ifm::app ()->siteUrl . 'login' ) ;
        }
        $sRow[ 'title' ] = 'بازبینی سفارش' ;

        //\f\pre($orderTransport);
        $content = $this->render ( 'review',
                                   array (
            'row'            => $rowOrderItem,
            'sRow'           => $sRow,
            'member'         => $member[ 0 ],
            'orderTransport' => $orderTransport[ 0 ]
                ) ) ;

        return array (
            $content,
            $sRow ) ;
    }

    public function renderGetPayment ( $param = '' )
    {
        if ( $_SESSION[ 'user_id' ] )
        {
            $id = $param[ 0 ] ;

            if ( $id )
            {
                $orderId['id'] = $id ;
            }
            else
            {
                $orderId = \f\ttt::service ( 'shop.order.getOrderByUserId',
                                             array (
                            'id'     => $_SESSION[ 'user_id' ],
                            'status' => 'cart'
                        ) ) ;
            }



            $orderTransporEndPrice = \f\ttt::service ( 'shop.order.getOrderByParam',
                                                       array (
                        'user_id' => $_SESSION[ 'user_id' ],
                        'id'      => $orderId[ 'id' ]
                    ) ) ;

                $orderDiscountCode = \f\ttt::service ( 'shop.discount.getDiscountOrder',
                                                       array (
                            'order_id' => $orderId[ 'id' ]
                        ) ) ;
            $sRow[ 'title' ] = 'انتخاب شیوه پرداخت' ;
        }
        else
        {
            header ( 'Location: ' . \f\ifm::app ()->siteUrl . 'login' ) ;
        }
        $getInfo = \f\ttt::service( 'member.getMemberById',
            [
                'id' => $_SESSION['user_id']
            ] );

     //   \f\pre($orderTransporEndPrice[0]);
        $content = $this->render ( 'payment',
                                   array (
            'prices'            => $orderTransporEndPrice[ 0 ],
            'orderId'           => $orderId[ 'id' ],
            'sRow'              => $sRow,
            'userInfo'          => $getInfo,
            'orderDiscountCode' => $orderDiscountCode,
                ) ) ;

        return array (
            $content,
            $sRow ) ;
    }

    public function renderGetCheckout ( $params, $bank = '',$payType,$order_id )
    {
        $orderId[ 'id' ]=$_SESSION[ 'order_id' ];
        if ( $_SESSION[ 'user_id' ] )
        {
            $member = \f\ttt::service ( 'member.getMembersByParam',
                                        array (
                        'id' => $_SESSION[ 'user_id' ],
                    ) ) ;
            if ( $bank != NULL && !$payType)
            {
                $order = \f\ttt::service ( 'shop.order.getOrderByUserId',
                                           array (
                            'selected' => 't1.*',
                            'id'       => $_SESSION[ 'user_id' ],
                            'orderid'  => $params[ 'SaleOrderId' ],
                            'bankid'   => 'mellat',
                            'status'   => 'unpayed',
                            'status2'  => 'payed',
                        ) ) ;
                if ( $order )
                {
                    $orderTransport = \f\ttt::service ( 'shop.order.getOrderByParam',
                                                        array (
                                'user_id' => $_SESSION[ 'user_id' ],
                                'id'      => $orderId[ 'id' ]
                            ) ) ;
                    if ( $bank == 'mellat' )
                    {
                        $refId = $params[ 'SaleReferenceId' ] ;

                        if ( $params[ 'ResCode' ] == 17 )
                        {
                            $status = 'cancel' ;
                            //after 2day must be delete records status  = unpayd
                        }
                        else
                        {
                            $result = \f\ttt::service ( 'core.setting.bank.mellat.verifyMellat',
                                                        array (
                                        'orderId'    => $params[ 'SaleOrderId' ],
                                        'refrenceId' => $refId
                                    ) ) ;
                            //if succesufull
                            if ( $result == "0" )
                            {
                                $result = \f\ttt::service ( 'core.setting.bank.mellat.settleMellat',
                                                            array (
                                            'orderId'    => $params[ 'SaleOrderId' ],
                                            'refrenceId' => $refId
                                        ) ) ;

                                //echo $result;
                                \f\ttt::service ( 'shop.order.saveTransaction',
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
                }
                else
                {
                    header ( 'Location: ' . \f\ifm::app ()->siteUrl ) ;
                }
            }
            //else run when placePay selected
            else
            {
                //follow order number id +1000000 for recpect customers
                $orderTransport = \f\ttt::service ( 'shop.order.getOrderByParam',
                                                    array (
                            'user_id' => $_SESSION[ 'user_id' ],
                            'id'      => $orderId[ 'id' ],
                          //  'status'  => $bank,
                        ) ) ;
                $orderTransport[ 0 ][ 'orderNumber' ] = $orderTransport[ 0 ][ 'id' ] + 100000 ;

                $discountCodePrice = \f\ttt::service ( 'shop.order.getSumDiscountCodePrice',
                                                       array (
                            'orderId' => $orderTransport[ 0 ][ 'id' ]
                        ) ) ;
                if ($bank == 'mellat') {
                    $refId = $params['SaleReferenceId'];

                    if ($params['ResCode'] == 17) {
                        //\f\pr('cancel');
                        $status = 'cancel';
                        //after 2day must be delete records status  = unpayd
                    } else {
                        $result1 = \f\ttt::service('core.setting.bank.mellat.verifyMellat',
                            array(
                                'orderId' => $params['SaleOrderId'],
                                'refrenceId' => $refId
                            ));

                        //if succesufull
                        if ($result1 == "0" or $result1=='415') {
                            $result = \f\ttt::service('core.setting.bank.mellat.settleMellat',
                                array(
                                    'orderId' => $params['SaleOrderId'],
                                    'refrenceId' => $refId
                                ));

                            if($result1=="0") {
                                \f\ttt::service('shop.order.saveTransaction',
                                    array(
                                        'orderId' => $params['SaleOrderId'],
                                        'refrenceId' => $refId
                                    ));
                            }
                            $status = 'pay';
                        } else {
                            $status = 'errorPay';
                            $refId = $params['SaleReferenceId'];
                        }
                    }
                }

                //\f\pre ( $orderTransport ) ;
                if ( $orderTransport )
                {
                    if ( $orderTransport[0]['type'] == 'cashOn' )
                    {
                        $status = "cashOn";
                    } elseif($orderTransport[0]['type'] == 'credit')
                    {
                        $status = "credit";
                    }
                }
                else
                {
                    header ( 'Location: ' . \f\ifm::app ()->siteUrl ) ;
                }
            }
        }
        else
        {
            header ( 'Location: ' . \f\ifm::app ()->siteUrl . 'login' ) ;
        }

        //\f\pre($status);
        $sRow[ 'title' ] = 'وضعیت پرداخت' ;
        $content         = $this->render ( 'checkout',
                                           array (
            'sRow'              => $sRow,
            'status'            => $status,
            'refId'             => $refId,
            'order'             => $orderTransport[ 0 ],
            'member'            => $member[ 0 ],
            'orderTransport'    => $orderTransport[ 0 ],
            'discountCodePrice' => $discountCodePrice,
                ) ) ;

        return array (
            $content,
            $sRow ) ;
    }
    public function renderGetBasketSidebar(){
        if ( $_SESSION[ 'user_id' ] )
        {
            $basketRow             = \f\ttt::service ( 'shop.orderItem.getOrderItemByParamsCart',
                array (
                    'user_id' => $_SESSION[ 'user_id' ],
                    'status'  => 'cart',
                    'gift'=>'no'
                ) ) ;
            $sRow[ 'title' ] = 'سبد خرید' ;
        }
        //\f\pre($basketRow);
        return $this->render('basketSidebar',
            array(
               // 'amazingProducts' => $amazingProducts['0'],
                'basketBuy' => $basketRow,
            ));
    }

}
