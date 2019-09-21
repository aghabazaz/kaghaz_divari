<?php

class orderMapper extends \f\dal
{

    public  $sqlEngine;
    private $dataTable;
    private $orderItem_tbl = 'shop_order_items';
    private $member_tbl    = 'member';
    private $order_tbl     = 'shop_orders';
    private $shop_order_discount_code_tbl     = 'shop_order_discount_code';
    private $product_price_tbl = 'shop_product_price';
    private $product_tbl       = 'shop_product';
    private $shop_category_tbl = 'shop_category';
    private $shop_color_tbl    = 'shop_color';
    private $order_return_tbl  = 'order_return';


    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine;
        $this->dataTable = \f\dalFactory::make( 'core.dataTable' );
    }

    public function orderListAccounting ()
    {
        $pr               = $this->request->getAssocParams();
        $requestDataTable = $pr['dataTableParams'];

        $columns = [
            [
                'db' => 't1.id', //column name selected
                'dt' => 0, //column num
            ],
            [
                'db' => 't1.id',
                'dt' => 1,
            ],
            [
                'db' => 't2.name',
                'dt' => 2,
            ],
            [
                'db' => 't1.date_pay',
                'dt' => 3,
            ],
            [
                'db' => 't1.price_pay',
                'dt' => 4,
            ],
            [
                'db' => 't2.type_user',
                'dt' => 5,
            ],
            [
                'db' => 't1.pos_option',
                'dt' => 6,
            ],
            [
                'db' => 't1.status',
                'dt' => 7,
            ],
        ];

        $whereJoin = [
            ' t1.user_id = t2.id  AND( t1.status="cashOn" OR t1.status="payed" OR t1.status="credit" OR t1.status="accountingNo")' ];


        $result = [
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->order_tbl . ' AS t1',
            'primaryKey'      => $this->order_tbl . 't1.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins = [
                'member AS t2' ],
            'whereJoin'       => $whereJoin
        ];
        $out    = $this->dataTable->getDataTable( $result );

        return $out;
    }

    public function getListBuyers ()
    {
        $param    = $this->request->getAssocParams();
        $noStatus = 'cart,unpayed,accountingNo,accountingNo,returned';
        $this->sqlEngine->Select( 't2.id,t2.name' )
            ->From( $this->order_tbl . ' AS t1' )
            ->Join( $this->member_tbl . ' AS t2' )
            ->Where( 't1.user_id=t2.id' )
            ->andWhere( 't1.status NOT IN ("' . $noStatus . '")' )
            ->GroupBy( 't2.id' )
            ->Run();
        return $this->sqlEngine->getRows();
    }

    public function orderListStockOrders ()
    {
        $pr               = $this->request->getAssocParams();
        $requestDataTable = $pr['dataTableParams'];

        $columns = [
            [
                'db' => 't1.id', //column name selected
                'dt' => 0, //column num
            ],
            [
                'db' => 't1.id',
                'dt' => 1,
            ],
            [
                'db' => 't2.name',
                'dt' => 2,
            ],
            [
                'db' => 't1.date_pay',
                'dt' => 3,
            ],
            [
                'db' => 't1.price_pay',
                'dt' => 4,
            ],
            [
                'db' => 't1.pos_option',
                'dt' => 5,
            ],
            [
                'db' => 't1.status',
                'dt' => 6,
            ],
        ];

        $whereJoin = [
            ' t1.user_id = t2.id  AND( t1.status="inventoryNo" OR t1.status="accountingOk")' ];

        $result = [
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->order_tbl . ' AS t1',
            'primaryKey'      => $this->order_tbl . 't1.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins = [
                'member AS t2' ],
            'whereJoin'       => $whereJoin
        ];
        $out    = $this->dataTable->getDataTable( $result );
        return $out;
    }

    public function orderListSendDeliver ()
    {
        $pr               = $this->request->getAssocParams();
        $requestDataTable = $pr['dataTableParams'];

        $columns = [
            [
                'db' => 't1.id', //column name selected
                'dt' => 0, //column num
            ],
            [
                'db' => 't1.id',
                'dt' => 1,
            ],
            [
                'db' => 't2.name',
                'dt' => 2,
            ],
            [
                'db' => 't1.date_pay',
                'dt' => 3,
            ],
            [
                'db' => 't1.price_pay',
                'dt' => 4,
            ],
            [
                'db' => 't1.status',
                'dt' => 5,
            ],
        ];

        $whereJoin = [
            ' t1.user_id = t2.id  AND( t1.status="inventoryOk" OR t1.status="sending" OR t1.status="delivery" OR t1.status="returned")' ];

        $result = [
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->order_tbl . ' AS t1',
            'primaryKey'      => $this->order_tbl . 't1.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins = [
                'member AS t2' ],
            'whereJoin'       => $whereJoin
        ];
        $out    = $this->dataTable->getDataTable( $result );
        return $out;
    }

    public function orderListSold ()
    {
        $pr               = $this->request->getAssocParams();
        $requestDataTable = $pr['dataTableParams'];

        $columns = [
            [
                'db' => 't1.id', //column name selected
                'dt' => 0, //column num
            ],
            [
                'db' => 't1.id',
                'dt' => 1,
            ],
            [
                'db' => 't2.name',
                'dt' => 2,
            ],
            [
                'db' => 't1.date_pay',
                'dt' => 3,
            ],
            [
                'db' => 't1.price_pay',
                'dt' => 4,
            ],
        ];

        $whereJoin = [
            ' t1.user_id = t2.id  AND(t1.status="delivery") AND NOT t1.price_pay = 0' ];

        $result = [
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->order_tbl . ' AS t1',
            'primaryKey'      => $this->order_tbl . 't1.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins = [
                'member AS t2' ],
            'whereJoin'       => $whereJoin
        ];
        $out    = $this->dataTable->getDataTable( $result );
        return $out;
    }

    public function orderListReturned ()
    {
        $pr               = $this->request->getAssocParams();
        $requestDataTable = $pr['dataTableParams'];

        $columns = [
            [
                'db' => 't1.id', //column name selected
                'dt' => 0, //column num
            ],
            [
                'db' => 't1.id',
                'dt' => 1,
            ],
            [
                'db' => 't2.name',
                'dt' => 2,
            ],
            [
                'db' => 't1.date_pay',
                'dt' => 3,
            ],
            [
                'db' => 't1.price_pay',
                'dt' => 4,
            ],
        ];

        $whereJoin = [
            ' t1.user_id = t2.id  AND(t1.status="returned")' ];

        $result = [
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->order_tbl . ' AS t1',
            'primaryKey'      => $this->order_tbl . 't1.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins = [
                'member AS t2' ],
            'whereJoin'       => $whereJoin
        ];
        $out    = $this->dataTable->getDataTable( $result );
        return $out;
    }

    public function orderSave ()
    {
        $params                  = $this->request->getAssocParams();
        $params['date_register'] = time();

        $result = $this->sqlEngine->save( $this->order_tbl,
            $params );


        return $result;
    }

    public function reportsSave ()
    {
        $params = $this->request->getAssocParams();

        $this->registerGadgets( [
            'dateG' => 'date' ] );

        if ( $params['date_start'] )
        {
            $params['date_start'] = $this->dateG->dateTotime( $params['date_start'],2 );
        }
        if ( $params['date_end'] )
        {
            $params['date_end'] = $this->dateG->dateTotime( $params['date_end'],2 );
        }
        if ( $params['buyerListArr'] )
        {
            $userId = implode( ',',$params['buyerListArr'] );
        }
        if ( $params['brand'] )
        {
            $brand = implode( ',',$params['brand'] );
        }
        if ( $params['category'] )
        {
            $category = $params['category'];
        }
        $this->sqlEngine->Select( '*' )
            ->From( $this->order_tbl . ' AS t1' );
        $this->sqlEngine->Join( $this->member_tbl . ' AS t2' );
        $this->sqlEngine->Join( $this->orderItem_tbl . ' AS t3' );
        $this->sqlEngine->Join( $this->product_price_tbl . ' AS t4' );
        $this->sqlEngine->Join( $this->product_tbl . ' AS t5' );
        $this->sqlEngine->Join( $this->shop_category_tbl . ' AS t6' );


        $this->sqlEngine->Where( 't1.user_id=t2.id' );
        $this->sqlEngine->andWhere( 't3.order_id=t1.id' );
        $this->sqlEngine->andWhere( 't3.product_price_id=t4.id' );
        $this->sqlEngine->andWhere( 't4.shop_product_id=t5.id' );
        $this->sqlEngine->andWhere( 't5.shop_category_id=t6.id' );
        if ( $userId )
        {
            $this->sqlEngine->andWhere( 't1.user_id IN (' . $userId . ')' );
        }

        if ( $brand )
        {
            $this->sqlEngine->andWhere( 't5.shop_brand_id IN (' . $brand . ')' );
        }
        if ( $category )
        {
            $this->sqlEngine->andWhere( 't6.id=?',$category );
        }
        if ( $params['date_start'] )
        {
            $this->sqlEngine->andWhere( 't1.date_register>=?',$params['date_start'] );
        }
        if ( $params['date_end'] )
        {
            $this->sqlEngine->andWhere( 't1.date_register<=?',$params['date_end'] );
        }
        $this->sqlEngine->Run();
        return $this->sqlEngine->getRows();
    }

    public function statisticalReportsSave ()
    {
        $pr               = $this->request->getAssocParams();
        $this->registerGadgets( [
            'dateG' => 'date' ] );
        if($pr['type']=='ajax'){
            $pr['date_start']=str_replace(" ","/",$pr['date_start']);
            $pr['date_end']=str_replace(" ","/",$pr['date_end']);
            $pr['date_start']=$this->dateG->dateTotime( $pr['date_start'],2 );
            $pr['date_end']=$this->dateG->dateTotime( $pr['date_end'],2 );
            if($pr['user_id']!=''){
                $user=' AND (t1.user_id IN (' . $pr['user_id'] . ') )';

            }else{
                $user='';
            }
        }else{
            $user=' ';

        }
        $requestDataTable = $pr['dataTableParams'];

        $columns = [
            [
                'db' => 't3.order_id', //column name selected
                'dt' => 0, //column num
            ],
            [
                'db' => 't2.username',
                'dt' => 1,
            ],
            [
                'db' => 't2.name',
                'dt' => 2,
            ],
            [
                'db' => 't1.date_pay',
                'dt' => 3,
            ],
            [
                'db' => 't1.price_pay',
                'dt' => 4,
            ],
            [
                'db' => 't1.type',
                'dt' => 5,
            ],
        ];

        $whereJoin = [
            't1.user_id = t2.id And t3.order_id=t1.id AND t3.product_price_id=t4.id AND t4.shop_product_id=t5.id AND t5.shop_category_id=t6.id AND t1.date_pay>="'.$pr['date_start'].'" AND t1.date_pay<="'.$pr['date_end'].'" '.$user ];

        $result = [
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->order_tbl . ' AS t1',
            'primaryKey'      => $this->order_tbl . 't1.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins = [
                'member AS t2',
                'shop_order_items AS t3',
                'shop_product_price AS t4',
                'shop_product AS t5',
                'shop_category AS t6'
                ],
            'whereJoin'       => $whereJoin
        ];
        $out    = $this->dataTable->getDataTable( $result );
        return $out;
    }

    public function orderSaveEdit ()
    {
        $params = $this->request->getAssocParams();
        $id     = $params['id'];
        $mobile=$params['mobile'];
        unset ( $params['id'] );
        unset( $params['mobileDevice'] );
        unset( $params['address'] );
        unset( $params['mobile'] );

        $result = $this->sqlEngine->save( $this->order_tbl,$params,
            [
                'id=?',
                [
                    $id ] ]
        );
        if($result>0 and $params['status']=='sending'){
            $msg    = " مشتری گرامی سفارش شما تایید و در حال ارسال می باشد.";
            $result = \f\ttt::service( 'core.setting.sms.sendSingleSms',
                [
                    'receiver' => $mobile,
                    'txt'      => $msg
                ] );
        }
        if($result>0 and $params['status']=='delivery'){
            $msg    = "مشتری گرامی ضمن تشکر از اعتماد شما برای بهبود کیفیت خدمات پیشنهاد خود را با ما از طریق لینک زیر در میان بگذارید. ";
            $msg=$msg."\n";
            $msg=$msg.\f\ifm::app ()->siteUrl . 'contactUs';
            $result = \f\ttt::service( 'core.setting.sms.sendSingleSms',
                [
                    'receiver' => $mobile,
                    'txt'      => $msg
                ] );
        }
        return $result;
    }

    public function orderDelete ()
    {
        $param = $this->request->getAssocParams();
        $id    = $param['id'];
        $this->sqlEngine->remove( $this->order_tbl,
            [
                'id=?',
                [
                    $id ] ] );

        return [
            'result' => 'success',
            'func'   => 'remove' ];
    }

    public function orderStatus ()
    {
        $param  = $this->request->getAssocParams();
        $id     = $param['id'];
        $status = $param['status'] == 'enabled' ? 'disabled' : 'enabled';

        $this->sqlEngine->save( $this->order_tbl,
            [
                'status' => $status
            ],
            [
                'id=?',
                [
                    $id ] ] );

        return [
            'result' => 'success',
            'status' => $status,
            'id'     => $id,
            'func'   => 'status' ];
    }

    public function getOrderById ()
    {
        $param = $this->request->getAssocParams();
        $this->sqlEngine->Select()
            ->From( $this->order_tbl . ' AS t1' )
            ->Where( 't1.id=?',$param['id'] );

        if ( $param['status'] )
        {
            $this->sqlEngine->andWhere( 't1.status=?','enabled' );
        }
        $this->sqlEngine->Run();

        return $this->sqlEngine->getRow();
    }

    public function getBeforeOrderById ()
    {
        $param = $this->request->getAssocParams();
        //\f\pre($param);
        $this->sqlEngine->Select()
            ->From( $this->order_tbl . ' AS t1' )
            ->Where( 't1.user_id=?',$param['id'] )
            ->andWhere( 't1.status_pay=?','unpayed' )
            ->andWhere( 't1.type=?','credit' )
            ->OrderBy( 'date_pay ASC' )
            ->Run();
           return $this->sqlEngine->getRow();
    }

    public function getOrderByOwnerId ()
    {
        $ownerId = \f\ttt::dal( 'core.auth.getUserOwner' );

        if ( !$ownerId )
        {
            $ownerId = \f\ttt::dal( 'core.auth.getOwnerFront' );
        }

        $this->sqlEngine->Select()
            ->From( $this->order_tbl . ' AS t1' )
            ->Where( 't1.owner_id=?',$ownerId )
            ->andWhere( 'status=?','enabled' )
            ->OrderBy( 'title ASC' )
            ->Run();
        return $this->sqlEngine->getRows();
    }

    public function getOrderPriceByUserId ()
    {
        $param = $this->request->getAssocParams();
        $this->sqlEngine->Select('t1.price,t1.discount,t1.transportation_cost,t2.discount_price')
            ->From( $this->order_tbl . ' AS t1' )
            ->leftJoin ( $this->shop_order_discount_code_tbl . ' AS t2' )
            ->On( 't2.order_id=t1.id' )
            ->Where( 't1.user_id=?',$param['user_id'] )
            ->andWhere( 't1.status_pay=?','unpayed' )
            ->andWhere('t1.type=?','credit')
            ->Run();
        return $this->sqlEngine->getRows();


    }

    public function getOrderByParams ()
    {
        $param = $this->request->getAssocParams();
        if ( $param['selected'] )
        {
            $selected = $param['selected'];
        } else
        {
            $selected = "'*'";
        }
        $this->sqlEngine->Select( $selected )
            ->From( $this->order_tbl . ' AS t1' )
            //->leftJoin ( $this->product_price_tbl . ' AS t2' )
            //->On ( 't1.product_price_id=t2.id' )
            ->Where( 1 );
        if ( $param['user_id'] )
        {
            $this->sqlEngine->andWhere( 't1.user_id=?',$param['user_id'] );
        }
        if ( $param['status'] )
        {
            $this->sqlEngine->andWhere( 't1.status=?',$param['status'] );
        }
        //$this->sqlEngine->OrderBy ( 't1.id ASC ' ) ;
        $this->sqlEngine->Run();


        $row = $this->sqlEngine->getRows();
        //\f\pre($row);
        return $row;
    }

    public function checkOrderCartByUserId ()
    {
        $param = $this->request->getAssocParams();
        $this->sqlEngine->Select()
            ->From( $this->order_tbl . ' AS t1' )
            ->Where( 't1.user_id=?',$param['user_id'] );
        if ( $param['status'] )
        {
            $this->sqlEngine->andWhere( 't1.status=?',$param['status'] );
        }
        $this->sqlEngine->Run();
        return $this->sqlEngine->getRow();
    }

    public function getOrderByUserId ()
    {
        $param = $this->request->getAssocParams();
        //\f\pre($param);

        if ( !$param['selected'] )
        {
            $param['selected'] = "t1.id";
        }
        $this->sqlEngine->Select( $param['selected'] )
            ->From( $this->order_tbl . ' AS t1' )
            ->Where( 't1.user_id=?',$param['id'] );

        if ( $param['bankid'] )
        {
            $this->sqlEngine->andWhere( 't1.bankid=?',$param['bankid'] );
        } else
        {
            $this->sqlEngine->andWhere( 't1.bankid IS NULL' );
        }
        if ( $param['orderid'] )
        {
            $this->sqlEngine->andWhere( 't1.orderid=?',$param['orderid'] );
        }
        if ( $param['status'] )
        {
            $this->sqlEngine->andWhere( 't1.status=?',$param['status'] );
        }
        if ( $param['status'] && $param['status2'] )
        {
            $this->sqlEngine->andWhere( 't1.status=?',$param['status'] );
            $this->sqlEngine->orWhere( 't1.status=?',$param['status2'] );
        }
        $this->sqlEngine->Run();

        return $this->sqlEngine->getRow();
    }

    public function getOrderByParam ()
    {
        $param = $this->request->getAssocParams();
        if ( $param['notStatus'] )
        {
            $selected = 't1.*,t2.cost,t2.title AS trans_title,t5.title,t5.picture,t5.id AS product_id,t3.order_id,t3.count,t3.product_price_id,t6.title AS guaranteeTitle,t7.title AS colorTitle';
        } else
        {
            $selected = 't1.*,t2.cost,t2.title AS trans_title';
        }
        $this->sqlEngine->Select( $selected )
            ->From( $this->order_tbl . ' AS t1' )
            ->leftJoin( 'shop_transportation AS t2' )
            ->On( 't1.transportation_id=t2.id' );
        if ( $param['notStatus'] )
        {
            $this->sqlEngine->leftJoin( 'shop_order_items AS t3' );
            $this->sqlEngine->On( 't1.id=t3.order_id' );
            $this->sqlEngine->leftJoin( 'shop_product_price AS t4' );
            $this->sqlEngine->On( 't3.product_price_id=t4.id' );
            $this->sqlEngine->leftJoin( 'shop_product AS t5' );
            $this->sqlEngine->On( 't4.shop_product_id=t5.id' );
            $this->sqlEngine->leftJoin( 'shop_guarantee AS t6' );
            $this->sqlEngine->On( 't4.guarantee_id=t6.id' );
            $this->sqlEngine->leftJoin( 'shop_color AS t7' );
            $this->sqlEngine->On( 't4.color_id=t7.id' );
        }
        $this->sqlEngine->Where( 1 );
        if ( $param['notStatus'] )
        {
            $this->sqlEngine->andWhere( 'NOT t1.status=?',
                $param['notStatus'] );
        }
        if ( $param['id'] )
        {
            $this->sqlEngine->andWhere( 't1.id=?',$param['id'] );
        }
        if ( $param['user_id'] )
        {
            $this->sqlEngine->andWhere( 't1.user_id=?',$param['user_id'] );
        }
        if ( $param['status'] )
        {
            $this->sqlEngine->andWhere( 't1.status=?',$param['status'] );
        }
        $this->sqlEngine->OrderBy( 't1.id DESC' )->Run();
        $row = $this->sqlEngine->getRows();

        return $row;
    }

    public function getOrderDateClearing ()
    {
        $param = $this->request->getAssocParams();
        $this->sqlEngine->Select('t1.*')
                    ->from($this->order_tbl.' AS t1')
                    ->where('t1.user_id=?',$param['user_id'])
                    ->andWhere('t1.status_pay=?','unpayed')
                    ->andWhere('t1.type=?','credit')
                    ->OrderBy('t1.date_pay ASC')
                    ->Run();

        $row = $this->sqlEngine->getRow();
        return $row;
    }

    public function getNewOrderByParams ()
    {
        $param = $this->request->getAssocParams();
        $dateNow=time();
        $this->registerGadgets ( array ( 'dateG' => 'date' ) ) ;
        $dateNow=$this->dateG->dateTime ($dateNow,2 );
        if ( $param['notStatus'] )
        {
            $selected = 't1.*,t2.cost,t2.title AS trans_title,t5.title,t5.picture,t5.id AS product_id,t3.order_id,t3.count,t3.product_price_id,t4.stock,t6.title AS guaranteeTitle,t7.title AS colorTitle,
            IF(STRCMP(t10.type_user,"seller")=0,
            t4.price
            ,t4.user_price) AS newPrice,
            IF(STRCMP(t10.type_user,"seller")=0,
(
IF((t9.price IS Null OR t9.price<=0), 
IF((t4.discount IS NULL OR t4.discount<=0),
IF((t8.discount IS NULL),0,IF(STRCMP(t8.type_discount,"percent")=0,(t4.price*(t8.discount/100)),t8.discount)),
IF(STRCMP(t4.type_discount,"percent")=0,(t4.price*(t4.discount/100)),t4.discount))
,IF(STRCMP(t9.discount_type,"percent")=0,(t4.price*(t9.price/100)),t9.price))
)
,
(
IF((t9.price IS Null OR t9.price<=0), 
IF((t4.discount IS NULL OR t4.discount<=0),
IF((t8.discount IS NULL),0,IF(STRCMP(t8.type_discount,"percent")=0,(t4.user_price*(t8.discount/100)),t8.discount)),
IF(STRCMP(t4.type_discount,"percent")=0,(t4.user_price*(t4.discount/100)),t4.discount))
,IF(STRCMP(t9.discount_type,"percent")=0,(t4.user_price*(t9.price/100)),t9.price))
)
) AS discountEnd';
        } else
        {
            $selected = 't1.*,t2.cost,t2.title AS trans_title';
        }
        $this->sqlEngine->Select( $selected )
            ->From( $this->order_tbl . ' AS t1' )
            ->leftJoin( 'shop_transportation AS t2' )
            ->On( 't1.transportation_id=t2.id' );
        if ( $param['notStatus'] )
        {
            $this->sqlEngine->leftJoin( 'shop_order_items AS t3' );
            $this->sqlEngine->On( 't1.id=t3.order_id' );
            $this->sqlEngine->leftJoin( 'shop_product_price AS t4' );
            $this->sqlEngine->On( 't3.product_price_id=t4.id' );
            $this->sqlEngine->leftJoin( 'shop_product AS t5' );
            $this->sqlEngine->On( 't4.shop_product_id=t5.id' );
            $this->sqlEngine->leftJoin( 'shop_guarantee AS t6' );
            $this->sqlEngine->On( 't4.guarantee_id=t6.id' );
            $this->sqlEngine->leftJoin( 'shop_color AS t7' );
            $this->sqlEngine->On( 't4.color_id=t7.id' );
            $this->sqlEngine->leftJoin( 'shop_brand AS t8' );
            $this->sqlEngine->On( 't8.id=t5.shop_brand_id ' );
            $this->sqlEngine->leftJoin( 'shop_amazing AS t9' );
            $this->sqlEngine->On('t9.shop_product_id=t5.id AND (t9.date_start<= "'.$dateNow.'" AND t9.date_end>="'.$dateNow.'")' );
            $this->sqlEngine->leftJoin( 'member AS t10' );
            $this->sqlEngine->On( 't10.id=t1.user_id' );
        }
        $this->sqlEngine->Where( 1 );
        if ( $param['notStatus'] )
        {
            $this->sqlEngine->andWhere( 'NOT t1.status=?',
                $param['notStatus'] );
        }
        if ( $param['id'] )
        {
            $this->sqlEngine->andWhere( 't1.id=?',$param['id'] );
        }
        if ( $param['user_id'] )
        {
            $this->sqlEngine->andWhere( 't1.user_id=?',$param['user_id'] );
        }
        if ( $param['status'] )
        {
            $this->sqlEngine->andWhere( 't1.status=?',$param['status'] );
        }
        $this->sqlEngine->OrderBy( 't1.id DESC' )->Run();
        $row = $this->sqlEngine->getRows();
        return $row;
    }

    public function saveTransaction ()
    {
        $params = $this->request->getAssocParams();

        $this->sqlEngine->Select()
            ->From( $this->order_tbl )
            ->Where( 'orderid=?',$params['orderId'] )
            ->Run();
        $row = $this->sqlEngine->getRow();

        $this->sqlEngine->save( $this->order_tbl,
            [
                'status'     => 'payed',
                'refrenceid' => $params['refrenceId']
            ],
            [
                'orderid=?',
                [
                    $params['orderId'] ] ] );

        return $row;
    }

    public function saveTransactionWallet(){
        $params = $this->request->getAssocParams();

        $row=$this->sqlEngine->save( $this->order_tbl,
            [
                'status'     => $params['status'],
                'refrenceid' => $params['refrenceId'],
                'type'=>$params['type'],
                'price'=>$params['pricePay'],
                'price_pay'=>$params['pricePay'],
                'date_register'=>time(),
                'date_pay'=>time()
            ] );

        return $row;
    }

    public function getInfoPay ()
    {
        $params = $this->request->getAssocParams();

        $this->sqlEngine->Select()
            ->From( $params['tbl'] )
            ->Where( 'orderid=?',$params['Authority'] )
            ->Run();

        return $this->sqlEngine->getRow();
    }

    public function returnOrderSave ( $param )
    {
        $param  = $this->request->getAssocParams();
        $result = $this->sqlEngine->save( $this->order_return_tbl,
            [
                'return_count' => $param['return_number'],
                'return_cause' => $param['return_cause'],
                'user_id'      => $param['user_id'],
                'order_id'     => $param['order_id'],
                'product_id'   => $param['return_product_id'],
                'price_id'     => $param['return_price_id'],
                'date'     => time(),
            ] );
        return $result;
    }

    public function checkReturnRequest ()
    {
        $param = $this->request->getAssocParams();
        $this->sqlEngine->Select('SUM(return_count)')
            ->From( $this->order_return_tbl )
            ->Where( 'order_id=?',$param['order_id'] )
            ->andWhere('product_id=?',$param['return_product_id'])
            ->andWhere('price_id=?',$param['return_price_id'])
            ->andWhere('user_id=?',$param['user_id'])
            ->Run();
        return $this->sqlEngine->getRow();
    }

    public function getOrderDiscountCode ()
    {
        $params = $this->request->getAssocParams();
        $this->sqlEngine->Select()
            ->From( 'shop_order_discount_code' )
            ->Where( 'user_id=?',$params['user_id'] )
            ->OrderBy( 'id DESC' )
            ->Run();
        $row = $this->sqlEngine->getRows();
        $dId = $oId = $odId = 0;
        foreach ( $row AS $data )
        {
            if ( $data['discount_id'] == $params['discount_id'] )
            {
                $dId++;
            }
            if ( $data['order_id'] == $params['order_id'] )
            {
                $oId++;
            }
            if ( ( $data['order_id'] == $params['order_id'] ) && ( $data['discount_id'] == $params['discount_id'] ) )
            {
                $odId++;
            }
        }
        return [
            $dId,
            $oId,
            $odId ];
    }

    public function getSumDiscountCodePrice ()
    {
        $params = $this->request->getAssocParams();

        $this->sqlEngine->Select( 'SUM(discount_price) AS sum_discount' )
            ->From( 'shop_order_discount_code' )
            ->Where( 'order_id=?',$params['orderId'] )
            ->Run();

        $row = $this->sqlEngine->getRow();

        return $row['sum_discount'];
    }

    public function removeExpireCart ()
    {
        $param = $this->request->getAssocParams();

        $cartTimeCredit = $param['cartTimeCredit'] * 60 * 60;

        $expireTime = time() - $cartTimeCredit;

        $result = $this->sqlEngine->remove( $this->order_tbl,
            [
                'date_register<? AND status=?',
                [
                    $expireTime,
                    'cart' ]
            ] );

        return $result;
    }

    public function getCreditSettlementList(){
        $pr               = $this->request->getAssocParams();
        $requestDataTable = $pr['dataTableParams'];

        $columns = [
            [
                'db' => 't2.id', //column name selected
                'dt' => 0, //column num
            ],
            [
                'db' => 't2.name',
                'dt' => 1,
            ],
            [
                'db' => 't2.status',
                'dt' => 3,
            ],
        ];

        $whereJoin = [
            ' t1.user_id = t2.id  AND (t1.status_pay="unpayed" AND t1.type="credit" )' ];

        $result = [
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->order_tbl . ' AS t1',
            'primaryKey'      => $this->order_tbl . 't1.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins = [
                'member AS t2' ],
            'whereJoin'       => $whereJoin,
            'groupBy'=>'t2.id'
        ];
        $out    = $this->dataTable->getDataTable( $result );
        return $out;
    }

    public function getCreditSettlementByUserId(){
        $param = $this->request->getAssocParams();

        $this->sqlEngine->Select('t1.user_id,t1.id AS orderID,t1.transportation_cost,t1.date_pay,member.name,member.mobile,member.phone,member.address,member.wallet_credit,shop_transportation.title AS titleTrans,sum(shop_order_items.price) AS endPrice,sum(IF(STRCMP(shop_order_items.type_discount,"percent")=0,shop_order_items.price*(shop_order_items.discount_price/100),shop_order_items.discount_price)) AS endDiscountPrice,sum(shop_order_items.discount_price) AS discountCode,city.cityName,state.title AS stateTitle,member.day_settlement')
            ->From( $this->order_tbl.' AS t1' )
            ->innerJoin('member')
            ->on('member.id=t1.user_id')
            ->innerJoin('shop_transportation')
            ->on('shop_transportation.id=t1.transportation_id')
            ->innerJoin('shop_order_items')
            ->on('shop_order_items.order_id=t1.id')
            ->leftJoin('shop_order_discount_code')
            ->on('shop_order_discount_code.order_id=t1.id')
            ->innerJoin('city')
            ->on('city.id=member.city_id')
            ->innerJoin('state')
            ->on('state.id=member.state_id')
            ->Where( 't1.status_pay=?','unpayed' )
            ->andWhere('t1.type=?','credit')
            ->andWhere('t1.user_id=?',$param['id'])
            ->groupBY('t1.id')
            ->orderBy('date_pay  ASC')
            ->Run();
        $rows=$this->sqlEngine->getRows();

        return array($rows);
    }

    public function creditSettlement(){
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ('t1.wallet_credit')
            ->From ( $this->member_tbl . ' AS t1' )
            ->Where ( 't1.id=?', $param[ 'id' ] )
            ->Run () ;
        $credit=$this->sqlEngine->getRow ();

        if($credit['wallet_credit']<0){
            $this->sqlEngine->save( $this->member_tbl,
                [
                    'wallet_credit'     => 0,
                ],
                [
                    'id=?',
                    [
                        $param['id'] ] ] );
            $result=$this->sqlEngine->save( $this->order_tbl,
                [
                    'status_pay'     => 'payed',
                ],
                [
                    'status_pay=?',
                    [
                        'unpayed' ],
                    'type=?',
                    [
                        'credit'
                    ]

                    ] );
        }
        if($result){
            $data = [
                'result'  => 'success',
                'status'  => 'credit',
                'message' => 'پرداخت با موفقیت صورت گرفت.' ];
        }else{
            $data = [
                'result'  => 'error',
                'status'  => 'credit',
                'message' => 'پرداخت با موفقیت انجام نشد.' ];
        }

        return $data ;
    }

    public function mostSellRepBaseOnCat(){

        $pr               = $this->request->getAssocParams();
        $requestDataTable = $pr['dataTableParams'];

        $columns = [
            [
                'db' => 't5.shop_category_id AS id', //column name selected
                'dt' => 0, //column num
            ],
            [
                'db' => 'SUM(t4.stock) AS stock',
                'dt' => 1,
            ],
            [
                'db' => 'SUM(t3.count) AS count_pro',
                'dt' => 2,
            ],
            [
                'db' => 't9.title',
                'dt' => 3,
            ],
        ];

        $whereJoin = [
            ' t1.id=t3.order_id  AND t3.product_price_id=t4.id AND t4.shop_product_id=t5.id AND t9.id=t5.shop_category_id AND (t1.status_pay="payed"  OR (t1.status_pay="unpayed" AND t1.type="credit"))' ];

        $result = [
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->order_tbl . ' AS t1',
            'primaryKey'      => $this->order_tbl . 't1.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins = [
                'shop_order_items AS t3','shop_product_price AS t4','shop_product AS t5','shop_category AS t9' ],
            'whereJoin'       => $whereJoin,
            'groupBy'=>'t9.id',
            'orderBy'=>'count_pro DESC'
        ];
        $out    = $this->dataTable->getDataTable( $result );
        return $out;
    }

    public function mostSellRepBaseOnBrand(){
        $pr               = $this->request->getAssocParams();
        $requestDataTable = $pr['dataTableParams'];

        $columns = [
            [
                'db' => 't5.shop_brand_id AS id', //column name selected
                'dt' => 0, //column num
            ],
            [
                'db' => 'SUM(t4.stock) AS stock',
                'dt' => 1,
            ],
            [
                'db' => 'SUM(t3.count) AS count_pro',
                'dt' => 2,
            ],
            [
                'db' => 't9.title_fa',
                'dt' => 3,
            ],
        ];

        $whereJoin = [
            't1.id=t3.order_id  AND t3.product_price_id=t4.id  AND t4.shop_product_id=t5.id AND t9.id=t5.shop_brand_id  AND (t1.status_pay="payed"  or (t1.status_pay="unpayed" AND t1.type="credit"))' ];

        $result = [
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->order_tbl . ' AS t1',
            'primaryKey'      => $this->order_tbl . 't1.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins = [
                'shop_order_items AS t3','shop_product_price AS t4','shop_product AS t5','shop_brand AS t9' ],
            'whereJoin'       => $whereJoin,
            'groupBy'=>'t9.id',
            'orderBy'=>'count_pro DESC'
        ];
        $out    = $this->dataTable->getDataTable( $result );
        return $out;
    }
    public function addCustomOrderToOrderItem(){
        $param  = $this->request->getAssocParams();
      //  $param['dynamic']='on';
        $price=($param['price']==''?Null:$param['price']);
        $size=$param['width'].'*'.$param['height'];
        $size=($size==''?Null:$size);
        $material_id=($param['material']==''?Null:$param['material']);
        $product_pic=($param['image']==''?Null:$param['image']);
        $logoPic=($param['logo']==''?Null:$param['logo']);
        $description=($param['description']==''?Null:$param['description']);
        $date_register=time();
       /* \f\pr($param);
        \f\pr('price:'.$price);
        \f\pr('size:'.$size);
        \f\pr('material:'.$material_id);
        \f\pr('product_id:'.$product_pic);
        \f\pr('logoPic:'.$logoPic);
        \f\pr('description:'.$description);
        \f\pr('date_register:'.$date_register);*/
        $result = $this->sqlEngine->save( $this->orderItem_tbl,
            [
                'price' =>$price,
                'size'          =>$size,
                //'height' => $param['height'],
                'material_id'   => $material_id,
                'product_pic'   => $product_pic,
                'logo_picture'  => $logoPic,
                'description'   => $description,
                'date_register' => time(),
                'dynamic'       => 'on',
                'order_id'      => $param['order_id'],
                'custom_request'=> 'yes'
            ] );
        return $result;
    }
}
