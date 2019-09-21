<?php

class returnedProductMapper extends \f\dal
{

    public  $sqlEngine;
    private $dataTable;
    private $orderItem_tbl = 'shop_order_items';
    private $member_tbl    = 'member';
    private $order_tbl     = 'shop_orders';
//    private $product_product_tbl          = 'shop_product_gift' ;
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
                'db' => 't1.status',
                'dt' => 5,
            ],
        ];

        $whereJoin = [
            ' t1.user_id = t2.id  AND( t1.status="cashOn" OR t1.status="payed" OR t1.status="accountingNo")' ];

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
        //\f\pre($noStatus);
        $this->sqlEngine->Select( 't2.id,t2.name' )
            ->From( $this->order_tbl . ' AS t1' )
            ->Join( $this->member_tbl . ' AS t2' )
            ->Where( 't1.user_id=t2.id' )
            ->andWhere( 't1.status NOT IN ("' . $noStatus . '")' )
            ->GroupBy( 't2.id' )
            ->Run();
        //f\pre($this->sqlEngine->getRows());
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
                'db' => 't1.status',
                'dt' => 5,
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
    //ok
    public function returnedProductList()
    {
        $pr               = $this->request->getAssocParams();
        $requestDataTable = $pr['dataTableParams'];

        $columns = [
            [
                'db' => 't1.id', //column name selected
                'dt' => 0, //column num
            ],
            [
                'db' => 't1.order_id', //column name selected
                'dt' => 1, //column num
            ],
            [
                'db' => 'member.name', //column name selected
                'dt' => 2, //column num
            ],
        ];

        $whereJoin = [
            ' t1.user_id =member.id   ' ];

        $result = [
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->order_return_tbl . ' AS t1',
            'primaryKey'      => $this->order_return_tbl . 't1.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins = [
                'member' ],
            'whereJoin'       => $whereJoin,
            'groupBy'=>'t1.order_id'
        ];
        $out    = $this->dataTable->getDataTable( $result );
        return $out;
    }

    //ok
    public function getReturnedProductInfo(){

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
//            array (
//                'db' => 't1.status',
//                'dt' => 5,
//            ),
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
//            array (
//                'db' => 't1.status',
//                'dt' => 5,
//            ),
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
        //\f\pr($params);
//\f\pre($this->sqlEngine->last_query());
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

        //\f\pre($params);
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
        //\f\pre($category);
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
        //\f\pre ( $this->sqlEngine->getRows () ) ;
        return $this->sqlEngine->getRows();
    }

    public function orderSaveEdit ()
    {
        $params = $this->request->getAssocParams();
        $id     = $params['id'];

        unset ( $params['id'] );
        unset( $params['mobileDevice'] );
        $result = $this->sqlEngine->save( $this->order_tbl,$params,
            [
                'id=?',
                [
                    $id ] ]
        );
//\f\pre($this->sqlEngine->last_query());
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

        // \f\pre($this->sqlEngine->getRow());
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
        // \f\pr($param);
        // \f\pre($this->sqlEngine->last_query());
        $row = $this->sqlEngine->getRows();
        //\f\pre($row);
        return $row;
    }

//    public function removeTransaction ()
//    {
//        $params = $this->request->getAssocParams () ;
//        $this->sqlEngine->Select ()
//                ->From ( $this->order_tbl )
//                ->Where ( 'orderid=?', $params[ 'orderId' ] )
//                ->Run () ;
//
//        $row = $this->sqlEngine->getRow () ;
//
//        $this->sqlEngine->remove ( $this->order_tbl,
//                                   array (
//            'id=?',
//            array (
//                $row[ 'id' ] ) ) ) ;
//    }

    public function saveTransaction ()
    {
        $params = $this->request->getAssocParams();

        $this->sqlEngine->Select()
            ->From( $this->order_tbl )
            ->Where( 'orderid=?',$params['orderId'] )
            ->Run();
        $row = $this->sqlEngine->getRow();

        //\f\pr($row);

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
        //  \f\pr($params);
        //  \f\pre($this->sqlEngine->last_query());
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

        //\f\pre($params);

        $this->sqlEngine->Select( 'SUM(discount_price) AS sum_discount' )
            ->From( 'shop_order_discount_code' )
            ->Where( 'order_id=?',$params['orderId'] )
            ->Run();

        $row = $this->sqlEngine->getRow();

        //\f\pre($row);

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

}
