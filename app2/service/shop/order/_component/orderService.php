<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 *
 * @package \shop\order
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class orderService extends \f\service
{

    /**
     *
     * @var shortcutMapper
     */
    private $mapper;

    public function __construct ()
    {
        $this->mapper = \f\dalFactory::make( 'shop.order' );
    }

    public function orderListAccounting ()
    {
        return \f\ttt::dal( 'shop.order.orderListAccounting',
            $this->request->getAssocParams() );
    }

    public function orderListStockOrders ()
    {
        return \f\ttt::dal( 'shop.order.orderListStockOrders',
            $this->request->getAssocParams() );
    }

    public function orderListSendDeliver ()
    {
        return \f\ttt::dal( 'shop.order.orderListSendDeliver',
            $this->request->getAssocParams() );
    }

    public function reportsSave ()
    {
        $this->registerGadgets( [ 'dateG' => 'date' ] );

        $params = $this->request->getAssocParams();
        if ( $params['date_end'] || $params['date_start'] || $params['brand'][0] || $params['buyerListArr'][0] || $params['category'] )
        {
            $row = \f\ttt::dal( 'shop.order.reportsSave',
                $this->request->getAssocParams() );

            require_once \f\ROOT . \f\DS . 'ifm' . \f\DS . 'lib' . \f\DS . 'excel-export.php';

            $exporter = new ExportDataExcel ( 'file',
                'upload' . \f\DS . 'report.xls' );

            $exporter->initialize(); // starts streaming data to web browser
// pass addRow() an array and it converts it to Excel XML format and sends 
// it to the browser
            $exporter->addRow( [
                "عنوان محصول",
                "عنوان کامل",
                "نام خریدار",
                "تاریخ خرید" ] );

            foreach ( $row AS $data )
            {
                $exporter->addRow( [
                    $data['title'],
                    $data['sub_title'],
                    $data['name'],
                    $this->dateG->dateTime( $data['date_register'],2 ) ] );
            }


            $exporter->finalize(); // writes the footer, flushes remaining data to browser.

            $file = 'report.xls';

            header( "Content-type: application/vnd.ms-excel" );
            header( 'Content-disposition: attachment; filename=' . $file );
            header( 'Content-Length: ' . filesize( $file ) );

            $data = [
                'result'  => 'success',
                'message' => 'فایل اکسل با موفقیت ایجاد شد.',
                'func'    => 'creatLink' ];
        } else
        {
            $data = [
                'result'  => 'error',
                'message' => \f\ifm::t( 'importAlert' ) ];
        }

        return $data;
    }

    public function orderListSold ()
    {
        return \f\ttt::dal( 'shop.order.orderListSold',
            $this->request->getAssocParams() );
    }

    public function getListBuyers ()
    {
        return \f\ttt::dal( 'shop.order.getListBuyers',
            $this->request->getAssocParams() );
    }

    public function orderListReturned ()
    {
        return \f\ttt::dal( 'shop.order.orderListReturned',
            $this->request->getAssocParams() );
    }

    public function orderSave ()
    {
        $params = $this->request->getAssocParams();

        if ( $params['id'] )
        {
            if ( !empty ( $params['price_pay'] ) )
            {
                $params['price_pay'] = str_replace( ',','',
                    $params['price_pay'] );
            }
            $params['type']       = 'cashOn';
            $result = \f\ttt::dal( 'shop.order.orderSaveEdit',$params );
            $msg    = \f\ifm::t( 'orderSaveEdit' );
            if ( $result )
            {
                $data = [
                    'result'  => 'success',
                    'status'  => 'cashOn',
                    'message' => $msg ];
            } else
            {
                $data = [
                    'result'  => 'error',
                    'message' => \f\ifm::t( 'dbError' ) ];
            }
        } else
        {
            $params['status'] = 'cart';
            $checkOrderCart   = \f\ttt::dal( 'shop.order.checkOrderCartByUserId',
                $params );

            //check if not exsist cart old then insert new order cart else add to orderItem
            if ( $checkOrderCart == NULL )
            {
                $orderId = \f\ttt::dal( 'shop.order.orderSave',
                    [
                        'user_id' => $params['user_id'],
                        'status'  => $params['status'],
                    ] );
            }
            else
            {
                $params['selected'] = 't1.id';
                $orderId            = \f\ttt::dal( 'shop.order.getOrderByParams',$params);
                $orderId            = $orderId[0]['id'];
            }

            $checkStock = \f\ttt::service( 'shop.product.checkStockByPriceId', $params );


            //check if time amazing then price- amazing else - discount
            $params['id'] = $params['product_id'];
            $checkAmazing = \f\ttt::service('shop.amazing.checkAmazingByProductId',
                $params );
            //ge-t brand product
            $getBrandId = \f\ttt::dal( 'shop.product.getProductBrand',$params );
            $checkBrand = \f\ttt::service( 'shop.brand.checkBrandByProductId',
                [ 'id' => $getBrandId['shop_brand_id'] ] );

            if ( $checkAmazing == NULL )
            {
                $params['discount_type']  = 'default';
                $params['discount_price'] = $checkStock['discount'];
                if ( $params['discount_price'] == 0 && $checkBrand != NULL )
                {
                    $params['discount_price']    = $checkBrand['discount'];
                    $checkStock['type_discount'] = $checkBrand['type_discount'];//percent or fixed
                    $params['discount_type']     = 'brand';
                }
            } else
            {
                $params['discount_type']     = 'amazing';//amazing or brand or default
                $checkStock['type_discount'] = $checkAmazing['discount_type'];//percent or fixed
                $params['discount_price']    = $checkAmazing['amazing_price'];
            }

          // \f\pr($params);
            if ( $checkStock != NULL or $params['typeProduct']=='dynamic')
            {
                //check orders old which into cart
                $result = \f\ttt::dal( 'shop.orderItem.checkOrderItemsOldPriceId',
                    [
                        'priceId' => ($params['typeProduct']=='dynamic'?$params['product_price_id']:$checkStock['id']),
                        'userId'  => $params['user_id'],
                        'status'  => 'cart',
                        'typeProduct'=>$params['typeProduct'],
                        'order_item_id'=>$params['order_item_id']
                    ] );
                if($params['typeProduct']=='dynamic' && $params['order_item_id']==''){
                    //check repeat order item or no
                    $result=\f\ttt::dal( 'shop.orderItem.checkRepeatOrderItemDynamicProduct',
                        [
                            'grayscale'=>$params['grayscale'],
                            'mirror'=>$params['mirror'],
                            //'picName'=>$params['serialImage'],
                            'size'=>$params['width'].'*'.$params['height'],
                            'position_cut'=>$params['positionCut'],
                            'pic_name'=>$params['serialImage'],
                            'product_price_id'=>$params['product_price_id'],
                            'user_id'  => $params['user_id'],
                            'status'  => 'cart',
                        ] );
                }
                if ( is_array( $result ) != NULL )
                {
                    if($params['typeOpr']=='decrease') {
                        //add count to old order into cart
                        if($params['count']>0 or !isset($params['count'])){
                            $resultOrderItem=\f\ttt::dal('shop.orderItem.addOrderItemCountAndMulPrice',
                            [
                                'id' => $result['id'],
                                'count' => $result['count'],
                                //'price'     => $checkStock[ 'price' ],
                                'countPlus' => '-1',

                            ]);
                        }
                    }else{
                        if((($params['typeOpr']=='increase' or $params['typeOpr']=='addToCart') and ($params['count']<$checkStock['stock'] or $params['typeProduct']=='dynamic')) or !isset($params['typeOpr'])){
                            if($params['typeProduct']=='dynamic' && $params['order_item_id']==''){
                                $params['order_item_id']=$result['order_item_id'];
                            }
                            $resultOrderItem= \f\ttt::dal('shop.orderItem.addOrderItemCountAndMulPrice',
                                [
                                    'id' => $result['id'],
                                    'count' => $result['count'],
                                    //'price'     => $checkStock[ 'price' ],
                                    'countPlus' => '1',
                                    'order_item_id'=>$params['order_item_id'],
                                    'typeProduct'=>$params['typeProduct']
                                    //'dynamic_pro_id'=>$params['']
                                ]);

                        }else{
                            $data = [
                                'result'  => 'error',
                                'message' => 'notStock' ];
                        }
                    }
                } else
                {
                    //\f\pre($params);
                    if(!empty($params['product_price_id']) && ($params['data_type']=='static' or $params['typeProduct']=='static')) {
                        $productPriceInfo = \f\ttt::dal('shop.product.getProductPriceById',
                            [
                                'product_price_id' => $params['product_price_id'],
                            ]);
                        $params['price']=$productPriceInfo['price'];
                    }
                   // \f\pre($params);
                    $size=$params['width'].'*'.$params['height'];
                    $params                  = [
                        'order_id'         => $orderId,
                        'product_price_id' => $params['product_price_id'],
                        'date_register'    => time(),
                        'discount_type'    => $params['discount_type'],
                        'discount_price'   => $params['discount_price'],
                        'price'            => $params['price'],
                        'status'           => 'enabled',
                        'type_discount'    => $checkStock['type_discount'],
                        'size'             => $size,
                        'product_pic'      => $params['product_pic'],
                        'positionCut'=>$params['positionCut'],
                        'grayscale'=>$params['grayscale'],
                        'mirror'=>$params['mirror'],
                        'typeProduct'=>$params['typeProduct'],
                        'pic_name'=>$params['pic_name']
                    ];
                    $result   = \f\ttt::dal( 'shop.orderItem.orderItemSave',
                        $params );


                    $data = [
                        'order_item_id' => $result];
                    $_SESSION['order_count'] += 1;
                }
            } else
            {
                $data = [
                    'result'  => 'error',
                    'message' => 'notStock' ];
            }
        }

        return $data;
    }

    public function creditOrderSave ()
    {
        $params = $this->request->getAssocParams();
        if ( !empty ( $params['price_pay'] ) )
        {
            $params['price_pay'] = str_replace( ',','',
                $params['price_pay'] );
        }
        $getInfo               = \f\ttt::service( 'member.getMemberById',
            [
                'id' => $_SESSION['user_id']
            ] );
        $orderTransporEndPrice = \f\ttt::service( 'shop.order.getOrderByParam',
            [
                'user_id' => $_SESSION['user_id'],
                'id'      => $params['id']
            ] );
        $orderDiscountCode     = \f\ttt::service( 'shop.discount.getDiscountOrder',
            [
                'order_id' => $params['id']
            ] );
        $endPrice              = ( $orderTransporEndPrice[0]['price'] - $orderTransporEndPrice[0]['discount'] - $orderTransporEndPrice[0]['discount_price'] ) + ( $orderTransporEndPrice[0]['transportation_cost'] - $orderDiscountCode[0]['discount_price'] );

        $resultBuy = $this->checkLicenseBuy( [ 'endPrice' => $endPrice ],$getInfo,$params );

        if ( $resultBuy['result'] == 'success' )
        {
            $resultBuy['status'] = 'credit';
        }


        return $resultBuy;
    }

    public function checkLicenseBuy ( $endPrice,$user_info,$params )
    {
        $params['price_pay']=$endPrice['endPrice'];
        if ( $user_info['type_user'] == 'seller' )
        {
            if ( $endPrice['endPrice'] >= $user_info['minPurchase'] )
            {
                if ( $user_info['statusAccount'] == 'goodAccount' )
                {
                    if ( $endPrice['endPrice'] >= $user_info['creditPurchaseFloor'] OR $user_info['wallet_credit']>=$endPrice['endPrice'])
                    {
                        if ( $user_info['wallet_credit'] < 0 )
                        {
                            if ( $user_info['conditional_number'] > 0 )
                            {
                                $getCreditBuybefore = $this->getCreditOrdr( $user_info );
                                if ( $getCreditBuybefore == 'True' )
                                {
                                    $purchaseCeiling = $user_info['creditPurchaseCeiling'];
                                    if ( $purchaseCeiling > $endPrice['endPrice'] )
                                    {
                                        $orderBeforePrice = $this->getBeforeOrderPrice( $user_info );
                                        $endPriceCalc     = $orderBeforePrice + $endPrice['endPrice'];
                                        if ( $endPriceCalc <= $purchaseCeiling )
                                        {
                                            $checkWallet          = $user_info['wallet_credit'] - $endPrice['endPrice'];
                                            $params['status_pay'] = 'unpayed';
                                            $params['type']       = 'credit';
                                            $result               = \f\ttt::dal( 'shop.order.orderSaveEdit',$params );
                                            $msg                  = \f\ifm::t( 'orderSaveSuccess' );
                                            if ( $result )
                                            {
                                                \f\ttt::dal( 'member.walletMemberUpdate',[ 'priceSet' => $checkWallet,'member_info' => $user_info ] );
                                                if ( abs( $checkWallet ) == $user_info['creditPurchaseCeiling'] )
                                                {
                                                    \f\ttt::dal( 'member.deleteLicenseBuy',[ 'member_info' => $user_info ] );
                                                }
                                                $data = [
                                                    'result'  => 'success',
                                                    'message' => $msg ];
                                            } else
                                            {
                                                $data = [
                                                    'result'  => 'error',
                                                    'message' => \f\ifm::t( 'dbError' ) ];
                                            }

                                        } else
                                        {

                                            $data = [
                                                'result' => 'error',
                                                'message' => \f\ifm::t( 'orderMoreLimit' ) ];
                                        }


                                    } else
                                    {
                                        $data = [
                                            'result'  => 'error',
                                            'message' => '  حداکثر مبلغ مجاز خرید اعتباری ' . $user_info['creditPurchaseCeiling'] . ' ریال است ' ];
                                    }
                                } else
                                {
                                    $data = [
                                        'result'  => 'error',
                                        'message' => \f\ifm::t( 'dateOrderBeforeErorr' ) ];
                                }
                            } else
                            {
                                $data = [
                                    'result'  => 'error',
                                    'message' => \f\ifm::t( 'buyBlucked' ) ];
                            }
                        } else
                        {
                           // \f\pre('sdsdsdsd');
                            $purchaseCeiling = $user_info['creditPurchaseCeiling'];
                            if ( $purchaseCeiling >= $endPrice['endPrice'] - $user_info['wallet_credit'] )
                            {


                                $checkWallet = $user_info['wallet_credit'] - $endPrice['endPrice'];

                                if ( $checkWallet > 0 )
                                {
                                    $params['status_pay'] = 'payed';
                                } else
                                {
                                    $params['status_pay'] = 'unpayed';
                                }

                                $params['type'] = 'credit';
                                $result         = \f\ttt::dal( 'shop.order.orderSaveEdit',$params );
                                $msg            = \f\ifm::t( 'orderSaveSuccess' );
                                if ( $result )
                                {
                                    \f\ttt::dal( 'member.walletMemberUpdate',[ 'priceSet' => $checkWallet,'member_info' => $user_info ] );
                                    if ( abs( $checkWallet ) == $user_info['creditPurchaseCeiling'] )
                                    {
                                        \f\ttt::dal( 'member.deleteLicenseBuy',[ 'member_info' => $user_info ] );
                                    }
                                    $data = [
                                        'result'  => 'success',
                                        'message' => $msg ];
                                } else
                                {
                                    $data = [
                                        'result'  => 'error',
                                        'message' => \f\ifm::t( 'dbError' ) ];
                                }


                            } else
                            {
                                $data = [
                                    'result'  => 'error',
                                    'message' => '  حداکثر مبلغ مجاز خرید اعتباری ' . $user_info['creditPurchaseCeiling'] . 'است' ];
                            }

                        }

                    } else
                    {
                        $data = [
                            'result'  => 'error',
                            'message' => '  حداقل مبلغ  مجاز خرید اعتباری ' . $user_info['creditPurchaseFloor'] . 'است' ];
                    }
                } else
                {
                    $checkWallet = $user_info['wallet_credit'] - $endPrice['endPrice'];
                    if ( $checkWallet < 0 )
                    {
                        $data = [
                            'result'  => 'error',
                            'message' => 'موجودی کیف پول شما کافی نیست !' ];
                    } else
                    {
                        $params['status_pay'] = 'payed';
                        $params['type']       = 'credit';
                        $result               = \f\ttt::dal( 'shop.order.orderSaveEdit',$params );
                        $msg                  = \f\ifm::t( 'orderSaveSuccess' );
                        if ( $result )
                        {
                            \f\ttt::dal( 'member.walletMemberUpdate',[ 'priceSet' => $checkWallet,'member_info' => $user_info ] );
                            $data = [
                                'result'  => 'success',
                                'status'  => 'credit',
                                'message' => $msg ];
                        } else
                        {
                            $data = [
                                'result'  => 'error',
                                'message' => \f\ifm::t( 'dbError' ) ];
                        }
                    }

                }
            } else
            {
                $data = [
                    'result'  => 'error',
                    'message' => '  حداقل مبلغ خرید از سایت ' . $user_info['minPurchase'] . ' ریال است  ' ];
            }
        } elseif ( $user_info['type_user'] == 'normUser' )
        {
            $checkWallet = $user_info['wallet_credit'] - $endPrice['endPrice'];
            if ( $checkWallet <= 0 )
            {
                $data = [
                    'result'  => 'error',
                    'message' => 'موجودی کیف پول شما کافی نیست !' ];
            } else
            {
                $result = \f\ttt::dal( 'shop.order.orderSaveEdit',$params );
                $msg    = \f\ifm::t( 'orderSaveSuccess' );
                if ( $result )
                {
                    \f\ttt::dal( 'member.walletMemberUpdate',[ 'priceSet' => $checkWallet,'member_info' => $user_info ] );
                    $data = [
                        'result'  => 'success',
                        'status'  => 'credit',
                        'message' => $msg ];
                } else
                {
                    $data = [
                        'result'  => 'error',
                        'message' => \f\ifm::t( 'dbError' ) ];
                }
            }

        }

        return $data;
    }


    public    function getCreditOrdr ( $user_info )
    {
        $beforeOrder = \f\ttt::dal( 'shop.order.getBeforeOrderById',$user_info );
        $this->registerGadgets( [
            'dateG' => 'date' ] );
        $dateSet = $this->dateG->dateTime( $beforeOrder['date_register'],
            1 );

        $dateEnd = date( 'Y-m-d',strtotime( $dateSet . ' + ' . $user_info['day_settlement'] . ' days' ) );
        $dateNow = $this->dateG->dateTime( time(),
            1 );
        $dateEnd = str_replace( "-","/",$dateEnd );

        if ( $dateEnd >= $dateNow )
        {
            return 'True';
        } else
        {
            return 'False';
        }
    }

    public    function getBeforeOrderPrice ( $user_info )
    {


        $orders = \f\ttt::dal( 'shop.order.getOrderPriceByUserId',
            [
                'user_id' => $user_info['id']
            ] );
        foreach ( $orders AS $data )
        {
            $endPrice[] = ( ( $data['price'] - $data['discount'] ) + $data['transportation_cost'] ) - $data['discount_price'];
        }

        $revArr[]            = implode( ',',$endPrice );
        $sumBeforePriceOrder = array_sum( $endPrice );
        return $sumBeforePriceOrder;


    }

    public    function orderDelete ()
    {
        $params = $this->request->getAssocParams();
        //get order items
        $orderItems = \f\ttt::dal( 'shop.orderItem.getOrderItemByParams',
            [
                'order_id' => $params['id']
            ] );
        //in foreach stock now + count reserved
        foreach ( $orderItems AS $data )
        {
            \f\ttt::dal( 'shop.product.minesPlusProductStock',
                [
                    'id'          => $data['product_price_id'],
                    'changeModel' => '+',
                    'count'       => $data['count']
                ] );
        }
        return \f\ttt::dal( 'shop.order.orderDelete',
            $this->request->getAssocParams() );
    }

    public    function orderStatus ()
    {
        return \f\ttt::dal( 'shop.order.orderStatus',
            $this->request->getAssocParams() );
    }

    public    function getOrderById ()
    {
        return \f\ttt::dal( 'shop.order.getOrderById',
            $this->request->getAssocParams() );
    }

    public    function getOrderByOwnerId ()
    {
        return \f\ttt::dal( 'shop.order.getOrderByOwnerId',
            $this->request->getAssocParams() );
    }

    public    function getPriceByOrderById ()
    {
        return \f\ttt::dal( 'shop.order.getPriceByOrderById',
            $this->request->getAssocParams() );
    }

    public    function getOrderByParams ()
    {
        return \f\ttt::dal( 'shop.order.getOrderByParams',
            $this->request->getAssocParams() );
    }

    public    function getOrderByParam ()
    {
        return \f\ttt::dal( 'shop.order.getOrderByParam',
            $this->request->getAssocParams() );
    }


    public  function calculatOrderEndPrice ()
    {
        $params = $this->request->getAssocParams();
        $row = \f\ttt::dal( 'shop.orderItem.getOrderItemByParams',$params );
        //\f\pre($row);
        foreach ( $row AS $data )
        {
            if ( $data['count'] != 0 )
            {
                    $allPrice =$allPrice+( $data['count'] * $data['price'] );

                        $allOff = $allOff + ( $data['count'] * $data['discountEnd'] );
                   // }
            } else
            {
                \f\ttt::service( 'shop.orderItem.orderItemDelete',
                    [
                        'orderItem_id' => $data['id'],
                        'order_id'     => $data['order_id']
                    ] );
            }

         //   if($data['active_gift_section']=='enabled'){

         //   }

        }
        $result = \f\ttt::dal( 'shop.order.orderSaveEdit',
            [
                'id'       => $params['order_id'],
                'price'    => $allPrice,
                'discount' => $allOff,
            ] );
        if ( $result )
        {
            $data = [
                'result'  => 'success',
                'message' => 'saveSuccess' ];
        } else
        {
            $data = [
                'result'  => 'error',
                'message' => 'error' ];
        }
        return $data;
    }

    public  function sendIdTransAndGoToReview ()
    {
        $param = $this->request->getAssocParams();
       // \f\pre($param);
        $trans_price = \f\ttt::service( 'shop.transportation.getTransportationById',
            [
                'id' => $param['transportation_id'],
            ] );

        $param['transportation_cost'] = $trans_price['cost'];
        $result                       = \f\ttt::dal( 'shop.order.orderSaveEdit',
            $param );
        if ( $result )
        {
            $data = [
                'result'  => 'success',
                'message' => 'saveSuccess' ];
        } else
        {
            $data = [
                'result'  => 'error',
                'message' => 'error' ];
        }
        //\f\pre($data);


        return $data;
    }

    public   function getOrderByUserId ()
    {
        return \f\ttt::dal( 'shop.order.getOrderByUserId',
            $this->request->getAssocParams() );
    }

//    public function removeTransaction ()
//    {
//        return \f\ttt::dal ( 'shop.order.removeTransaction',
//                             $this->request->getAssocParams () ) ;
//    }

    public    function saveTransaction ()
    {
        return \f\ttt::dal( 'shop.order.saveTransaction',
            $this->request->getAssocParams() );
    }

    public    function getOrderDiscountCode ()
    {
        return \f\ttt::dal( 'shop.order.getOrderDiscountCode',
            $this->request->getAssocParams() );
    }

    public    function getSumDiscountCodePrice ()
    {
        return \f\ttt::dal( 'shop.order.getSumDiscountCodePrice',
            $this->request->getAssocParams() );
    }

    public    function removeExpireCart ()
    {
        $setting = \f\ttt::service( 'shop.shopSetting.getSettings' );
        return \f\ttt::dal( 'shop.order.removeExpireCart',$setting );
    }

    public    function getCreditSettlementList ()
    {
        return \f\ttt::dal( 'shop.order.getCreditSettlementList',
            $this->request->getAssocParams() );
    }

}
