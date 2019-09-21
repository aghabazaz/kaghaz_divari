<?php

class orderController extends \f\controller
{

    /**
     *
     * @var orderView
     */
    private $view;

    public function __construct ( $params )
    {
        include_once 'orderView.php';
        $this->view = new orderView;
        parent::__construct( $params );
    }

    public function cartList ()
    {
        //$params = $this->request->getNonAssocParams () ;
        $params = $this->request->getAssocParams();

        $array = $this->view->renderGetCart( $params );
        return $this->render( [
            'content'     => $array[0],
            'websiteInfo' => $params['websiteInfo'],
            'title'       => $array[1]['title'],
        ] );
    }

    public function shippingList ()
    {
        //$params = $this->request->getNonAssocParams () ;
        $params = $this->request->getAssocParams();

        $array = $this->view->renderGetShipping( $params );
        return $this->render( [
            'content'     => $array[0],
            'websiteInfo' => $params['websiteInfo'],
            'title'       => $array[1]['title'],
        ] );
    }

    public function reviewList ()
    {
        $params = $this->request->getAssocParams();

        $array = $this->view->renderGetReview( $params );
        return $this->render( [
            'content'     => $array[0],
            'websiteInfo' => $params['websiteInfo'],
            'title'       => $array[1]['title'],
        ] );
    }

    public function paymentList ()
    {
        $param  = $this->request->getNonAssocParams();
        $params = $this->request->getAssocParams();
        $array  = $this->view->renderGetPayment( $param );
        return $this->render( [
            'content'     => $array[0],
            'websiteInfo' => $params['websiteInfo'],
            'title'       => $array[1]['title'],
        ] );
    }

    public function checkoutList ()
    {
        $params = $this->request->getAssocParams();
        $pr     = $this->request->getNonAssocParams();
        if ( $pr[0] )
        {
            $payType  = $pr[0];
            $order_id = $pr[1];
        }
        $mobile = ( $pr[1] == 'app' ) ? TRUE : FALSE;
        $array = $this->view->renderGetCheckout( $params,$pr[0],$payType,$order_id );
        return $this->render( [
            'content'     => $array[0],
            'websiteInfo' => $params['websiteInfo'],
            'title'       => $array[1]['title'],
            'type'        => $pr[1],
            'mobile'      => $mobile,
        ] );
    }

    public function updatePriceAndCount ()
    {
        $params = $this->request->getAssocParams();

        \f\ttt::service( 'shop.orderItem.addOrderItemCountAndMulPrice',
            [
                'id'        => $params['orderItem_id'],
                'count'     => $params['count'],
                'countPlus' => '0',
            ] );

        return $this->response( [
            'orderItem_id' => $params['orderItem_id']
        ] );

    }

    public function orderItemDelete ()
    {
        $params = $this->request->getAssocParams();

       // \f\pre($params);
        $result = \f\ttt::service( 'shop.orderItem.orderItemDelete',$params );

        $_SESSION['order_count']--;
        return $this->response( [
            'result' => $result
        ] );
    }

    public function calculatOrderEndPrice ()
    {
        $params = $this->request->getAssocParams();
        $result = \f\ttt::service( 'shop.order.calculatOrderEndPrice',$params );
        return $this->response( [
            'result' => $result
        ] );
    }

    public function sendIdTransAndGoToReview ()
    {
        $params = $this->request->getAssocParams () ;
        //\f\pre($params);
        if ( !$params[ 'transportation_id' ] )
        {
            //  \f\pre('hi');
            return $this->response ( array (
                'result' => 'error'
            ) ) ;
        }
        $result = \f\ttt::service ( 'shop.order.sendIdTransAndGoToReview',
            $params ) ;
        //  \f\pre($result);
        return $this->response ( array (
            'result' => $result
        ) ) ;
    }


    public function checkAndSubmitOffCode ()
    {
        $params           = $this->request->getAssocParams();
        $params['userId'] = $_SESSION['user_id'];
        $result           = \f\ttt::service( 'shop.discount.checkAndSubmitOffCode',$params );

        if ( $result['data'] )
        {
            $results = $result['data'];
        } else
        {
            $results = $result;
        }
        return $this->response( [
            'result' => $results
        ] );
    }

    public function lastCheckOrderPrice ( $id )
    {
        $row = \f\ttt::service( 'shop.orderItem.getOrderItemByParams',
            [
                'order_id' => $id,
                'gift'     => 'no'
            ] );
        //\f\pre($row);
        $this->registerGadgets( [
            'dateG' => 'date' ] );
        $today = $this->dateG->today();
        $flag  = TRUE;
        foreach ( $row AS $data )
        {

            //\f\pr($data);
            /* \f\pr('data:',$data);
             if($data['type_discount']=='percent'){
                 $data['discount_price']=($data['price']*($data['discount_price']/100))*$data['count'];
             }
             \f\pr($data);*/
            $checkStock = \f\ttt::service( 'shop.product.checkStockByPriceId',
                [
                    'lastCheck' => TRUE,
                    'priceId'   => $data['product_price_id']
                ] );

            $getInfo = \f\ttt::service( 'member.getMemberById',
                [
                    'id' => $_SESSION['user_id']
                ] );
            if ( $getInfo['type_user'] == 'seller' )
            {
                $checkStock['price'] = $checkStock['price'];

            } elseif ( $getInfo['type_user'] == 'normUser' )
            {

                $checkStock['price'] = $checkStock['user_price'];
            }
            //\f\pre($checkStock);
            /*  if($checkStock['type_discount']=='percent'){
                  $checkStock['discount']=($checkStock['price']*($checkStock['discount']/100))*$checkStock['count'];
              }else{
                  $checkStock['discount']=$checkStock['discount']*$checkStock['count'];
              }
              \f\pr($checkStock);*/
            $checkAmazing = \f\ttt::service( 'shop.amazing.checkAmazingByProductId',
                [
                    'id'    => $data['product_id'],
                    'today' => $today
                ] );

            $checkCategoryDiscount = \f\ttt::dal( 'shop.product.getDiscountForProductGroup',
                [
                    'id' => $data['product_id'],
                ] );
            //\f\pre($checkCategoryDiscount);

            foreach ( $checkCategoryDiscount as $data2 )
            {
                if ( $data2['type_discount'] == 'percent' )
                {
                    $checkCategoryDiscount[0]['id']            = $data2['id'];
                    $checkCategoryDiscount[0]['discount']      = $checkStock['price'] * ( $data2['discount'] / 100 );
                    $checkCategoryDiscount[0]['type_discount'] = 'price';

                }
                break;
            }


            if ( $checkAmazing == NULL and $data['discount_type'] != 'brand' )
            {
                $checkStock['discount_type'] = 'default';

            } else if ( $checkCategoryDiscount[0]['discount'] > 0 )
            {
                $checkStock['discount_type'] = 'brand';
                $checkStock['discount']      = $checkCategoryDiscount[0]['discount'];
            } else
            {
                $checkStock['discount_type'] = 'amazing';
                $checkStock['discount']      = $checkAmazing['amazing_price'];
            }
            if ( $data['price'] == $checkStock['price'] && $data['discount_price'] == $checkStock['discount'] && $data['discount_type'] == $checkStock['discount_type'] )
            {
                //no action
            } else
            {
                $flag = FALSE;
            }

            //   \f\pr($checkStock[ 'stock' ]);
            //\f\pre($flag);
            if ( $checkStock['stock'] < $data['count'] )
            {
                $count = $checkStock['stock'];
                $flag  = FALSE;
            } else
            {
                $count = $data['count'];
            }

            \f\ttt::service( 'shop.orderItem.updateOrderItemPrice',
                [
                    'price'          => $checkStock['price'],
                    'discount_price' => $checkStock['discount'],
                    'discount_type'  => $checkStock['discount_type'],
                    'count'          => $count,
                    'id'             => $data['orderItem_id']
                ] );
        }

        if ( !$flag )
        {
            \f\ttt::service( 'shop.order.calculatOrderEndPrice',
                [
                    'order_id' => $id
                ] );
        } else
        {
            foreach ( $row AS $data )
            {
                \f\ttt::dal( 'shop.product.minesPlusProductStock',
                    [
                        'id'          => $data['product_price_id'],
                        'changeModel' => '-',
                        'count'       => $data['count']
                    ] );
            }
        }

        //\f\pre ( $flag ) ;

        return $flag;
    }

    public function pay ()
    {
        $params = $this->request->getAssocParams();
        $check  = 1;
        //\f\pre($params);
        if ( $check )
        {
            if ( !$params['payWay'] )
            {
                return $this->response( [
                    'result'     => 'error',
                    'message'    => 'لطفا یک روش پرداخت را انتخاب کنید.',
                    'pleaseTick' => TRUE
                ] );
            }

            if ( $params['payWay'] == 'onlinePay' && !$params['bank'] )
            {
                return $this->response( [
                    'result'     => 'error',
                    'message'    => 'لطفا یک درگاه بانک را انتخاب کنید.',
                    'pleaseTick' => TRUE
                ] );
            }

            if ( $params['payWay'] == 'onlinePay' )
            {
                $bank              = $params['bank'];
                $prices            = \f\ttt::service( 'shop.order.getOrderByParam',
                    [
                        'user_id' => $_SESSION['user_id'],
                        'id'      => $params['id']
                    ] );
                $discountCodePrice = \f\ttt::service( 'shop.order.getSumDiscountCodePrice',
                    [
                        'orderId' => $params['id']
                    ] );

                //to rial *10
                $price = ( ( ( $prices[0]['price'] - $prices[0]['discount'] ) - $discountCodePrice ) + $prices[0]['transportation_cost'] );

                $result = \f\ttt::service( 'core.setting.bank.' . $bank . '.' . $bank . 'Pay',
                    [
                        'price'       => $price,
                        'callbackUrl' => \f\ifm::app()->siteUrl . 'checkout/' . $bank . '/',
                        'save'        => [
                            'shop_orders',
                            [
                                //'order_id'      => $params[ 'id' ],
                                //'user_id'       => $_SESSION[ 'user_id' ],
                                'date_pay'  => time(),
                                'status'    => 'unpayed',
                                'price_pay' => $price,
                                'type'      => 'online'
                            ],
                            [
                                'id=?',
                                [
                                    $params['id'] ],
                            ]
                        ]
                    ] );

                //}
            } else if ( $params['payWay'] == 'placePay' or $params['payWay']=='placePayPos')
            {
                if($params['payWay']=='placePayPos') {
                    //pay at place
                    $result = \f\ttt::service('shop.order.orderSave',
                        [
                            'id' => $params['id'],
                            'date_pay' => time(),
                            'status' => 'cashOn',
                            'type' => 'cashOn',
                            'pos_option'=>'pos'
                        ]);
                }else{
                  //  \f\pre('2');
                    //pay at place
                    $result = \f\ttt::service('shop.order.orderSave',
                        [
                            'id' => $params['id'],
                            'date_pay' => time(),
                            'status' => 'cashOn',
                            'type' => 'cashOn',
                            'pos_option'=>'noPos'
                        ]);
                }
            } else if ( $params['payWay'] == 'creditPay' )
            {
                //pay at credit\f\pre
                $result = \f\ttt::service( 'shop.order.creditOrderSave',
                    [
                        'id'       => $params['id'],
                        'date_pay' => time(),
                        'status'   => 'credit',
                        'type'=>'credit',

                    ] );
                if($result['result']=='error'){
                    return $this->response( [
                        'result'     => 'error',
                        'message'    =>$result['message'],
                        'pleaseTick' => TRUE
                    ] );
                }
            }
            $_SESSION['order_count'] = 0;
            if ( $result['result'] == 'error' )
            {
                $pleaseTick = TRUE;
            }else{
                $pleaseTick = False;
            }

            return $this->response( [
                'result'  => $result,
                'status'  => $result['status'],
                'message' => $result['message'],
                'pleaseTick' => $pleaseTick

            ] );
        } else
        {
            return $this->response( [
                'result'  => 'error',
                'message' => 'قیمت یا تعداد سفارش شما با اطلاعات سایت مطابقت ندارد. لطفا سبد خرید را مجددا بررسی فرمایید.'
            ] );
        }
    }

    public function removeDiscountCode ()
    {
        $params           = $this->request->getAssocParams();
        $params['userId'] = $_SESSION['user_id'];

        return $this->response( \f\ttt::service( 'shop.discount.removeDiscountOrder',
            $params ) );
    }
    public function basketOfOrder(){

        $params           = $this->request->getAssocParams();
      //\f\pre($params);
        $params['userId'] = $_SESSION['user_id'];
        return $this->renderPartial($this->view->renderGetBasketSidebar($params));
    }

}
