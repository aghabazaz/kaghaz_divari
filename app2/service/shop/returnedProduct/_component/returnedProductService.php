<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 *
 * @package \shop\order
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class returnedProductService extends \f\service
{

    /**
     *
     * @var shortcutMapper
     */
    private $mapper;

    public function __construct ()
    {
        $this->mapper = \f\dalFactory::make( 'shop.returnedProduct' );
    }



    //ok
    public function returnedProductList ()
    {
        return \f\ttt::dal( 'shop.returnedProduct.returnedProductList',
            $this->request->getAssocParams() );
    }


    public function getReturnedProductInfo(){
        return \f\ttt::dal( 'shop.returnedProduct.getReturnedProductInfo',
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

            //\f\pre($row);

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
        //\f\pre($params);
        if ( $params['id'] )
        {
            if ( !empty ( $params['price_pay'] ) )
            {
                $params['price_pay'] = str_replace( ',','',
                    $params['price_pay'] );
            }

            $result = \f\ttt::dal( 'shop.order.orderSaveEdit',$params );
            $msg    = \f\ifm::t( 'orderSaveEdit' );
            if ( $result )
            {
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
            } else
            {
                $params['selected'] = 't1.id';
                $orderId            = \f\ttt::dal( 'shop.order.getOrderByParams',
                    $params );
                $orderId            = $orderId[0]['id'];
            }
            $checkStock = \f\ttt::service( 'shop.product.checkStockByPriceId',
                $params );
            //check if time amazing then price- amazing else - discount
            $params['id'] = $params['product_id'];
            $checkAmazing = \f\ttt::service( 'shop.amazing.checkAmazingByProductId',
                $params );

            //get brand product
            $getBrandId=\f\ttt::dal('shop.product.getProductBrand',$params);
            //\f\pre($getBrandId);
            $checkBrand = \f\ttt::service( 'shop.brand.checkBrandByProductId',
               array('id'=>$getBrandId['shop_brand_id'])  );

      //    \f\pre($checkBrand);

            if ( $checkAmazing == NULL )
            {
                $params['discount_type']  = 'default';
                $params['discount_price'] = $checkStock['discount'];
                if($params['discount_price']==0 && $checkBrand!=NULL){
                    $params['discount_price'] =$checkBrand['discount'];
                    $checkStock['type_discount'] =$checkBrand['type_discount'];//percent or fixed
                    $params['discount_type']  = 'brand';
                }
            } else
            {
                $params['discount_type']  = 'amazing';//amazing or brand or default
                $checkStock['type_discount']=$checkAmazing['discount_type'];//percent or fixed
                $params['discount_price'] = $checkAmazing['amazing_price'];
            }

         //   \f\pr($checkStock);
          //  \f\pre($params);

           //
            // \f\pr($checkStock);
            if ( $checkStock != NULL )
            {
                //check orders old which into cart
                $result = \f\ttt::dal( 'shop.orderItem.checkOrderItemsOldPriceId',
                    [
                        'priceId' => $checkStock['id'],
                        'userId'  => $params['user_id'],
                        'status'  => 'cart'
                    ] );

                if ( is_array( $result ) != NULL )
                {
                    //add count to old order into cart
                    \f\ttt::dal( 'shop.orderItem.addOrderItemCountAndMulPrice',
                        [
                            'id'        => $result['id'],
                            'count'     => $result['count'],
                            //'price'     => $checkStock[ 'price' ],
                            'countPlus' => '1',
                        ] );
                } else
                {
                    if ( empty($_SESSION['user_id']) or $_SESSION['type_user']=='normUser'  )
                    {
                        $prices = $checkStock['user_price'];
                    }
                    if ($_SESSION['type_user']=='seller' )
                    {
                        $prices = $checkStock['price'];
                    }
                  /*  if ( $_SESSION['user_id'] && $_SESSION['wholesaler_set'] == 'enabled' )
                    {
                        $prices = $checkStock['majorPrice'];
                    }*/

                 // \f\pr('dsfsd');
                    //new order
                    //if($params['gift']) then save gifts... after design gift
                    $params                  = [
                        'order_id'         => $orderId,
                        'product_price_id' => $checkStock['id'],
                        'date_register'    => time(),
                        'discount_type'    => $params['discount_type'],
                        'discount_price'   => $params['discount_price'],
                        'price'            => $prices,
                        'status'           => 'enabled',
                        'type_discount'    => $checkStock['type_discount']
                    ];
                    $result                  = \f\ttt::dal( 'shop.orderItem.orderItemSave',
                        $params );
                    $_SESSION['order_count'] += 1;
                }
                /*
                  if ( $result )
                  {
                  //stock --
                  \f\ttt::service ( 'shop.product.minesPlusProductStock',
                  array (
                  'id'          => $checkStock[ 'id' ],
                  'changeModel' => '-',
                  'count'       => '1'
                  ) ) ;
                  }
                 * */
            } else
            {
                $data = [
                    'result'  => 'error',
                    'message' => 'notStock' ];
            }
        }

        return $data;
    }

    public function orderDelete ()
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

    public function orderStatus ()
    {
        return \f\ttt::dal( 'shop.order.orderStatus',
            $this->request->getAssocParams() );
    }

    public function getOrderById ()
    {
        return \f\ttt::dal( 'shop.order.getOrderById',
            $this->request->getAssocParams() );
    }

    public function getOrderByOwnerId ()
    {
        return \f\ttt::dal( 'shop.order.getOrderByOwnerId',
            $this->request->getAssocParams() );
    }

    public function getPriceByOrderById ()
    {
        return \f\ttt::dal( 'shop.order.getPriceByOrderById',
            $this->request->getAssocParams() );
    }

    public function getOrderByParams ()
    {
        return \f\ttt::dal( 'shop.order.getOrderByParams',
            $this->request->getAssocParams() );
    }

    public function getOrderByParam ()
    {
        return \f\ttt::dal( 'shop.order.getOrderByParam',
            $this->request->getAssocParams() );
    }


    public function calculatOrderEndPrice ()
    {
        $params = $this->request->getAssocParams();
        //\f\pre($params);
        $row = \f\ttt::dal( 'shop.orderItem.getOrderItemByParams',$params );

        //\f\pre($row);
        foreach ( $row AS $data )
        {
            if ( $data['count'] != 0 )
            {
                $allPrice = $allPrice + ( $data['count'] * $data['price'] );


                if($data['type_discount']=='percent'){
                    $allOff   = $allOff + ( $data['count'] * ($data['price']*($data['discount_price']/100)) );
                }else{
                    $allOff   = $allOff + ( $data['count'] * $data['discount_price'] );
                }

            } else
            {
                \f\ttt::service( 'shop.orderItem.orderItemDelete',
                    [
                        'orderItem_id' => $data['id'],
                        'order_id'     => $data['order_id']
                    ] );
            }
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

    public function sendIdTransAndGoToReview ()
    {
        $param = $this->request->getAssocParams();
//\f\pre($param);
        $trans_price = \f\ttt::service( 'shop.transportation.getTransportationById',
            [
                'id' => $param['transportation_id'],
            ] );

        //\f\pre($param);
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


        return $data;
    }

    public function getOrderByUserId ()
    {
        return \f\ttt::dal( 'shop.order.getOrderByUserId',
            $this->request->getAssocParams() );
    }

//    public function removeTransaction ()
//    {
//        return \f\ttt::dal ( 'shop.order.removeTransaction',
//                             $this->request->getAssocParams () ) ;
//    }

    public function saveTransaction ()
    {
        return \f\ttt::dal( 'shop.order.saveTransaction',
            $this->request->getAssocParams() );
    }

    public function getOrderDiscountCode ()
    {
        return \f\ttt::dal( 'shop.order.getOrderDiscountCode',
            $this->request->getAssocParams() );
    }

    public function getSumDiscountCodePrice ()
    {
        return \f\ttt::dal( 'shop.order.getSumDiscountCodePrice',
            $this->request->getAssocParams() );
    }

    public function removeExpireCart ()
    {
        $setting = \f\ttt::service( 'shop.shopSetting.getSettings' );
        return \f\ttt::dal( 'shop.order.removeExpireCart',$setting );
    }

}
