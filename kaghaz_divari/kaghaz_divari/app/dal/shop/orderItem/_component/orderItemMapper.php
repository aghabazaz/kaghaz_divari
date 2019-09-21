<?php

class orderItemMapper extends \f\dal
{

    public $sqlEngine ;
    private $dataTable ;
    private $orderItem_tbl     = 'shop_order_items' ;
    private $order_tbl         = 'shop_orders' ;
//    private $product_product_tbl          = 'shop_product_gift' ;
    private $product_price_tbl = 'shop_product_price' ;

    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
        $this->dataTable = \f\dalFactory::make ( 'core.dataTable' ) ;
    }

    public function orderItemList ()
    {
        $pr               = $this->request->getAssocParams () ;
        $requestDataTable = $pr[ 'dataTableParams' ] ;
        $columns          = array (
            array (
                'db' => 't1.id', //column name selected
                'dt' => 0, //column num
            ),
            array (
                'db' => 't1.title',
                'dt' => 1,
            ),
            array (
                'db' => 't2.title AS catTitle',
                'dt' => 2,
            ),
            array (
                'db' => 't1.status',
                'dt' => 3,
            ),
            array (
                'db' => 't1.special',
                'dt' => 4,
            ),
                ) ;
        $ownerId          = \f\ttt::service ( 'core.auth.getUserOwner' ) ;

        $whereJoin = array (
            "t1.owner_id=" . $ownerId . ' AND t1.shop_category_id=t2.id' ) ;

        $result = array (
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->orderItem_tbl . ' AS t1',
            'primaryKey'      => $this->orderItem_tbl . '.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins          = array (
        'shop_category AS t2' ),
            'whereJoin'       => $whereJoin
                ) ;
        $out    = $this->dataTable->getDataTable ( $result ) ;
        return $out ;
    }

    public function orderItemSave ()
    {
        $params = $this->request->getAssocParams () ;
        $result = $this->sqlEngine->save ( $this->orderItem_tbl, $params ) ;
        return $result ;
    }

    public function orderItemSaveEdit ()
    {
        $params = $this->request->getAssocParams () ;
        $id     = $params[ 'id' ] ;

        $result = $this->sqlEngine->save ( $this->orderItem_tbl, $params,
                                           array (
            'id=?',
            array (
                $id ) )
                ) ;

        return $result ;
    }

    public function orderItemDelete ()
    {
        $param = $this->request->getAssocParams () ;
        $id    = $param[ 'id' ] ;

        $this->sqlEngine->Select ()
            ->From ( $this->orderItem_tbl . ' AS t1' )
            ->Where ( 't1.id=?', $param[ 'id' ] )
            ->Run () ;
        $row=$this->sqlEngine->getRow () ;

        $k=$this->sqlEngine->remove($this->orderItem_tbl,
            array (
                'id=? OR (order_id=? AND  gift="yes")',
                array (
                    $id ,$row['order_id'] ) ) );
        return array (
            'result' => 'success',
            'func'   => 'remove' ) ;
    }

    public function orderItemStatus ()
    {
        $param  = $this->request->getAssocParams () ;
        $id     = $param[ 'id' ] ;
        $status = $param[ 'status' ] == 'enabled' ? 'disabled' : 'enabled' ;

        $this->sqlEngine->save ( $this->orderItem_tbl,
                                 array (
            'status' => $status
                ),
                                 array (
            'id=?',
            array (
                $id ) ) ) ;

        return array (
            'result' => 'success',
            'status' => $status,
            'id'     => $id,
            'func'   => 'status' ) ;
    }

    public function getOrderItemById ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ()
                ->From ( $this->orderItem_tbl . ' AS t1' )
                ->Where ( 't1.id=?', $param[ 'id' ] ) ;
        if ( $param[ 'status' ] )
        {
            $this->sqlEngine->andWhere ( 't1.status=?', 'enabled' ) ;
        }

        $this->sqlEngine->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function getOrderItemGiftById(){
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ('t1.*,shop_product.shop_product_gift_id')
            ->From ( $this->orderItem_tbl . ' AS t1' )
            ->innerJoin('shop_product')
            ->On('shop_product.id=t1.parent_pro')
            ->Where ( 't1.order_id=?', $param['id'] )
            ->andWhere ( 't1.gift=?', 'yes' );
        $this->sqlEngine->Run () ;
        return $this->sqlEngine->getRows () ;
    }
    public function getOrderItemByOwnerId ()
    {
        $ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;

        if ( ! $ownerId )
        {
            $ownerId = \f\ttt::dal ( 'core.auth.getOwnerFront' ) ;
        }

        $this->sqlEngine->Select ()
                ->From ( $this->orderItem_tbl . ' AS t1' )
                ->Where ( 't1.owner_id=?', $ownerId )
                ->andWhere ( 'status=?', 'enabled' )
                ->OrderBy ( 'title ASC' )
                ->Run () ;
        return $this->sqlEngine->getRows () ;
    }

    public function getPriceByOrderItemById ()
    {
        $id      = $this->request->getParam ( 'id' ) ;
        $history = $this->request->getParam ( 'history' ) ;
        if ( $history )
        {
            $tbl = $this->orderItem_price_history_tbl ;
        }
        else
        {
            $tbl = $this->orderItem_price_tbl ;
        }
        $this->sqlEngine->Select ()
                ->From ( $tbl )
                ->Where ( 'shop_orderItem_id=?', $id ) ;
        if ( $history )
        {
            $this->sqlEngine->OrderBy ( 'id DESC' ) ;
        }
        $this->sqlEngine->Run () ;

        return $this->sqlEngine->getRows () ;
    }

    public function orderItemSpecial ()
    {
        $param  = $this->request->getAssocParams () ;
        $id     = $param[ 'id' ] ;
        $status = $param[ 'status' ] == 'enabled' ? 'disabled' : 'enabled' ;

        $this->sqlEngine->save ( $this->orderItem_tbl,
                                 array (
            'special' => $status
                ),
                                 array (
            'id=?',
            array (
                $id ) ) ) ;

        return array (
            'result' => 'success',
            'status' => $status,
            'id'     => $id,
            'func'   => 'special' ) ;
    }

    public function getOrderItemsByAjaxSearch ()
    {

        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ( 't1.id,t1.title,t1.picture,t2.title AS cat_title' )
                ->From ( $this->orderItem_tbl . ' AS t1' )
                ->leftJoin ( 'shop_category AS t2' )
                ->On ( 't1.shop_category_id = t2.id' )
                ->Where ( 't1.status=?', 'enabled' )
                ->andWhere ( "t1.title LIKE '%" . $param[ 'keyword' ] . "%'" )
                ->orWhere ( "t1.sub_title LIKE '%" . $param[ 'keyword' ] . "%'" ) ;

        $this->sqlEngine->OrderBy ( 't1.id DESC' ) ;
        if ( $param[ 'limit' ] )
        {
            $this->sqlEngine->Limit ( $param[ 'limit' ] ) ;
        }
        $this->sqlEngine->Run () ;
        return $this->sqlEngine->getRows () ;
    }

    public function getOrderItemByParams ()
    {
        $param = $this->request->getAssocParams () ;
        $dateNow=time();
        $this->registerGadgets ( array ( 'dateG' => 'date' ) ) ;
        $dateNow=$this->dateG->dateTime ($dateNow,2 );
        //\f\pre($param);
        $this->sqlEngine->Select ( 't7.id AS order_id,t1.id AS orderItem_id,t1.id,t1.product_price_id,t1.count,t1.date_register,
 IF((t9.price IS Null OR t9.price<=0), 
        IF((t2.discount IS NULL OR t2.discount<=0),
        IF((t8.discount IS NULL),0,IF(STRCMP(t8.type_discount,"percent")=0,(t2.price*(t8.discount/100)),t8.discount)),
        IF(STRCMP(t2.type_discount,"percent")=0,(t2.price*(t2.discount/100)),t2.discount))
        ,IF(STRCMP(t9.discount_type,"percent")=0,(t2.price*(t9.price/100)),t9.price))
 AS discountEnd,t1.price,
       t1.discount_type,t2.user_price,t10.type_user,
  t1.type_discount,
t1.discount_price
           ,t1.gift,t2.stock,t3.id product_id,t3.title AS productTitle,t3.sub_title AS productTitleSub,t3.picture,t4.id AS color_id,t4.title AS colorTitle,t4.code AS colorCode,t5.title AS guranteeTitle,t3.m_free,t3.n_buy,t3.active_gift_section,t3.shop_product_gift_id' )
            ->From ( $this->orderItem_tbl . ' AS t1' )
            ->leftJoin ( $this->product_price_tbl . ' AS t2' )
            ->On ( 't1.product_price_id=t2.id' )
            ->leftJoin ( 'shop_product AS t3' )
            ->On ( 't2.shop_product_id=t3.id' )
            ->leftJoin ( 'shop_color AS t4' )
            ->On ( 't2.color_id=t4.id' )
            ->leftJoin ( 'shop_guarantee AS t5' )
            ->On ( 't2.guarantee_id=t5.id' )
            ->leftJoin ( $this->order_tbl . ' AS t7' )
            ->On ( 't7.id=t1.order_id' )
            ->leftJoin( 'member AS t10' )
            ->On( 't10.id=t7.user_id' )
            ->leftJoin( 'shop_amazing AS t9' )
            ->On( 't9.shop_product_id=t3.id  AND (t9.date_start<= "'.$dateNow.'" AND t9.date_end>="'.$dateNow.'")' )
            ->leftJoin( 'shop_brand AS t8' )
            ->On( 't8.id=t3.shop_brand_id ' )
            ->Where ( 1 ) ;
        if ( $param[ 'order_id' ] )
        {
            $this->sqlEngine->andWhere ( 't7.id=?', $param[ 'order_id' ] ) ;
        }
        if ( $param[ 'user_id' ] )
        {
            $this->sqlEngine->andWhere ( 't7.user_id=?', $param[ 'user_id' ] ) ;
        }
        if ( $param[ 'status' ] )
        {
            //get just orderItems which into cart from frontend
            $this->sqlEngine->andWhere ( 't3.status=?', 'enabled' ) ;
            $this->sqlEngine->andWhere ( 't7.status=?', $param[ 'status' ] ) ;
        }
        if($param['gift']=='no'){
            $this->sqlEngine->andWhere ( 't1.gift=?', 'no' ) ;
        }
        if ( $param[ 'status2' ] )
        {
            //or mod two status
            $this->sqlEngine->orWhere ( 't7.status=?', $param[ 'status' ] ) ;
        }
        $this->sqlEngine->Run () ;
        $row = $this->sqlEngine->getRows () ;
        return $row;
    }

    public function getOrderItemByParamsCart ()
    {
        $param = $this->request->getAssocParams () ;
        $dateNow=time();
        $this->registerGadgets ( array ( 'dateG' => 'date' ) ) ;
        $dateNow=$this->dateG->dateTime ($dateNow,2 );
        //\f\pre($param);
        $this->sqlEngine->Select ( 't7.id AS order_id,t2.type_discount,t1.id AS orderItem_id,t1.id,t1.product_price_id,t1.count,t1.date_register,
       IF(
    (t9.price IS Null OR t9.price<=0),
				IF(STRCMP(t2.type_discount,"percent")=0,(t2.price*(t2.discount/100)),t2.discount),
    			IF(STRCMP(t9.discount_type,"percent")=0,(t2.price*(t9.price/100)),t9.price)
    ) AS discountEnd,
        IF(
    (t9.price IS Null OR t9.price<=0),
				t2.discount,
    			t9.price)
     AS discount_price,
    IF(
    (t9.price IS Null OR t9.price<=0),
				IF(STRCMP(t2.type_discount,"percent")=0,"percent","fixed"),
    			IF(STRCMP(t9.discount_type,"percent")=0,"percent","fixed")
    ) AS type_discount,
      
     IF(
    (t9.price IS Null OR t9.price<=0),
    "default","amazing") AS discount_type,
          t2.price,
            t2.user_price,t10.type_user,t1.gift,t2.stock,t3.id product_id,t3.title AS productTitle,t3.sub_title AS productTitleSub,t3.picture,t4.id AS color_id,t4.title AS colorTitle,t4.code AS colorCode,t5.title AS guranteeTitle,t3.m_free,t3.n_buy,t3.active_gift_section,t3.shop_product_gift_id' )
            ->From ( $this->orderItem_tbl . ' AS t1' )
            ->leftJoin ( $this->product_price_tbl . ' AS t2' )
            ->On ( 't1.product_price_id=t2.id' )
            ->leftJoin ( 'shop_product AS t3' )
            ->On ( 't2.shop_product_id=t3.id' )
            ->leftJoin ( 'shop_color AS t4' )
            ->On ( 't2.color_id=t4.id' )
            ->leftJoin ( 'shop_guarantee AS t5' )
            ->On ( 't2.guarantee_id=t5.id' )
            ->leftJoin ( $this->order_tbl . ' AS t7' )
            ->On ( 't7.id=t1.order_id' )
            ->leftJoin( 'member AS t10' )
            ->On( 't10.id=t7.user_id' )
            ->leftJoin( 'shop_amazing AS t9' )
            ->On( 't9.shop_product_id=t3.id  AND (t9.date_start<= "'.$dateNow.'" AND t9.date_end>="'.$dateNow.'")' )
            ->Where ( 1 ) ;
        if ( $param[ 'order_id' ] )
        {
            $this->sqlEngine->andWhere ( 't7.id=?', $param[ 'order_id' ] ) ;
        }
        if ( $param[ 'user_id' ] )
        {
            $this->sqlEngine->andWhere ( 't7.user_id=?', $param[ 'user_id' ] ) ;
        }
        if ( $param[ 'status' ] )
        {
            //get just orderItems which into cart from frontend
            $this->sqlEngine->andWhere ( 't3.status=?', 'enabled' ) ;
            $this->sqlEngine->andWhere ( 't7.status=?', $param[ 'status' ] ) ;
        }
        if($param['gift']=='no'){
            $this->sqlEngine->andWhere ( 't1.gift=?', 'no' ) ;
        }
        if ( $param[ 'status2' ] )
        {
            //or mod two status
            $this->sqlEngine->orWhere ( 't7.status=?', $param[ 'status' ] ) ;
        }
        $this->sqlEngine->Run () ;
        $row = $this->sqlEngine->getRows () ;

      // \f\pre($row);
        if(!empty($row)) {
            foreach ($row as $data) {
                //if() {
                    $this->sqlEngine->save($this->orderItem_tbl,
                        array(
                            'price' => $data['price'],
                            'discount_price' => $data['discount_price'],
                            'discount_type' => $data['discount_type'],
                            'type_discount' => $data['type_discount']
                        ),
                        array(
                            'id=?',
                            array(
                                $data['orderItem_id']
                            ))
                    );
                //}
            }
        }

        return $row ;
    }



    public function getOrderItemByParamsReview ()
    {
        $param = $this->request->getAssocParams () ;
        $dateNow=time();
        $this->registerGadgets ( array ( 'dateG' => 'date' ) ) ;
        $dateNow=$this->dateG->dateTime($dateNow,2 );
        $this->sqlEngine->Select ( 't7.id AS order_id,
        t1.type_discount,t1.id AS orderItem_id,t1.id,t1.product_price_id,t1.count,t1.date_register,
    	IF(STRCMP(t1.type_discount,"percent")=0,(t2.price*(t1.discount_price/100)),t1.discount_price)  AS discountEnd,
          t2.price,
            t2.user_price,t10.type_user,t1.discount_type,t1.gift,t2.stock,t3.id product_id,t3.title AS productTitle,t3.sub_title AS productTitleSub,t3.picture,t4.id AS color_id,t4.title AS colorTitle,t4.code AS colorCode,t5.title AS guranteeTitle,t3.m_free,t3.n_buy,t3.active_gift_section,t3.shop_product_gift_id' )
            ->From ( $this->orderItem_tbl . ' AS t1' )
            ->leftJoin ( $this->product_price_tbl . ' AS t2' )
            ->On ( 't1.product_price_id=t2.id' )
            ->leftJoin ( 'shop_product AS t3' )
            ->On ( 't2.shop_product_id=t3.id' )
            ->leftJoin ( 'shop_color AS t4' )
            ->On ( 't2.color_id=t4.id' )
            ->leftJoin ( 'shop_guarantee AS t5' )
            ->On ( 't2.guarantee_id=t5.id' )
            ->leftJoin ( $this->order_tbl . ' AS t7' )
            ->On ( 't7.id=t1.order_id' )
            ->leftJoin( 'member AS t10' )
            ->On( 't10.id=t7.user_id' )
            ->leftJoin( 'shop_amazing AS t9' )
            ->On( 't9.shop_product_id=t3.id  AND (t9.date_start<= "'.$dateNow.'" AND t9.date_end>="'.$dateNow.'")' )
            ->Where ( 't7.status=?','cart' ) ;
        if ( $param[ 'order_id' ] )
        {
            $this->sqlEngine->andWhere ( 't7.id=?', $param[ 'order_id' ] ) ;
        }
        if ( $param[ 'user_id' ] )
        {
            $this->sqlEngine->andWhere ( 't7.user_id=?', $param[ 'user_id' ] ) ;
        }
        if ( $param[ 'status' ] )
        {
            //get just orderItems which into cart from frontend
            $this->sqlEngine->andWhere ( 't3.status=?', 'enabled' ) ;
            $this->sqlEngine->andWhere ( 't7.status=?', $param[ 'status' ] ) ;
        }
        if($param['gift']=='no'){
            $this->sqlEngine->andWhere ( 't1.gift=?', 'no' ) ;
        }
        if ( $param[ 'status2' ] )
        {
            //or mod two status
            $this->sqlEngine->orWhere ( 't7.status=?', $param[ 'status' ] ) ;
        }
        $this->sqlEngine->Run () ;
        $row = $this->sqlEngine->getRows () ;

        return $row ;
    }

    //ok
    public function getReturnedProOfOrderItemByParams ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ( 'DISTINCT shop_product.title AS productTitle,shop_product.sub_title AS productTitleSub,shop_color.title AS colorTitle,shop_guarantee.title AS guranteeTitle,shop_color.code AS colorCode,shop_product.picture,order_return.price_id,order_return.return_count,order_return.return_cause,order_return.date,order_return.id AS orderReturnId')
            ->From ( 'order_return' )
            ->innerJoin('shop_product')
            ->On('shop_product.id=order_return.product_id')
            ->innerJoin('shop_product_price')
            ->On('order_return.price_id=shop_product_price.id')
            ->innerJoin('shop_guarantee')
            ->On('shop_guarantee.id=shop_product_price.guarantee_id')
            ->innerJoin('shop_color')
            ->On('shop_color.id=shop_product_price.color_id')
            ->where('order_return.order_id=?',$param['order_id'])
            ->Run ();
        $row = $this->sqlEngine->getRows () ;
        return $row ;
    }

    public function checkOrderItemsOldPriceId ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ( 't1.id,t1.count' )
                ->From ( $this->orderItem_tbl . ' AS t1' )
                ->leftJoin ( $this->order_tbl . ' AS t2' )
                ->On ( 't2.id = t1.order_id' )
                ->Where ( "t1.product_price_id=?", $param[ 'priceId' ] )
                ->andWhere ( "t2.user_id=?", $param[ 'userId' ] )
                ->andWhere ( 't2.status=?', $param[ 'status' ] ) ;
        $this->sqlEngine->Run () ;
        return $this->sqlEngine->getRow () ;
    }
    public function getOrderItemByParamsGroupByProId(){
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ( 'DISTINCT shop_product_price.id,t1.return_cause,t1.return_count,t1.date,shop_guarantee.title AS titleGuarantee,shop_product.title AS titleProduct,shop_color.title AS titleColor,shop_product.sub_title' )
            ->From ( 'order_return AS t1' )
            ->innerJoin('shop_product_price')
            ->On('shop_product_price.id=t1.price_id')
            ->innerJoin('shop_guarantee')
            ->On('shop_guarantee.id=shop_product_price.guarantee_id')
            ->innerJoin('shop_color')
            ->On('shop_color.id=shop_product_price.color_id')
            ->innerJoin('shop_product')
            ->On('shop_product.id=shop_product_price.shop_product_id');
        if ( $param[ 'order_id' ] )
        {
            $this->sqlEngine->where ( 't1.order_id=?', $param[ 'order_id' ] ) ;
        }
        $this->sqlEngine->Run () ;
        $row = $this->sqlEngine->getRows () ;
        return $row ;
    }

    public function getOrderItemByParamsGroupByProIdForGifts(){
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ( 'DISTINCT t2.*,t3.*,sum(t2.count) AS sumCount,sum(t3.stock) as sumStock,t4.active_gift_section,t4.*  ' )
            ->From ( 'shop_orders AS t1 ' )
            ->innerJoin('shop_order_items AS t2')
            ->On('t2.order_id=t1.id')
            ->innerJoin('shop_product_price AS t3 ')
            ->On('t2.product_price_id=t3.id')
            ->innerJoin('shop_product AS t4')
            ->On('t4.id=t3.shop_product_id')
        ->where ( 't2.gift=?', 'no' );

        if ( $param[ 'order_id' ] )
        {
            $this->sqlEngine->andWhere ( 't1.id=?', $param[ 'order_id' ] ) ;
        }

        $this->sqlEngine->groupBy('t3.shop_product_id');
        $this->sqlEngine->Run () ;
        $row = $this->sqlEngine->getRows () ;
        return $row ;
    }
    public function addOrderItemCountAndMulPrice ()
    {
        $param = $this->request->getAssocParams () ;


        $this->sqlEngine->save ( $this->orderItem_tbl,
                                 array (
            'count' => $param[ 'count' ] + $param[ 'countPlus' ],
                ),
                                 array (
            'id=?',
            array (
                $param[ 'id' ]
            ) )
        ) ;
    }

    public function countOrdersUnpayd ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ( 't2.id' )
                ->From ( $this->order_tbl . ' AS t1' )
                ->leftJoin ( $this->orderItem_tbl . ' AS t2' )
                ->On ( 't1.id=t2.order_id' )
                ->Where ( 't1.user_id=?', $param[ 'user_id' ] )
                ->andWhere ( 't1.status=?', 'cart' )
                ->Run () ;
        return $this->sqlEngine->numRows () ;
    }
    
    public function updateOrderItemPrice()
    {
        $param = $this->request->getAssocParams () ;
        
        $result=$this->sqlEngine->save($this->orderItem_tbl, $param,array(
            'id=?',array($param['id'])
        ));
        
        return $result;
    }
    public function orderItemGiftSave(){
        $param = $this->request->getAssocParams();

        $result=$this->sqlEngine->save($this->orderItem_tbl, array(
            'order_id'=>$param['order_id'],
            'product_price_id'=>$param['product_price_id'],
            'count'=>$param['count'],
            'date_register'=>time(),
            'price'=>0,
            'discount_price'=>0,
            'gift'=>'yes',
            'parent_pro'=>$param['shop_product_id'],
            'parent_order'=>$param['order_id'],
        ));

        if($result>0) {
            $this->sqlEngine->save('shop_product_price',
                array('stock' => $param['stock']),
                array(
                    'id=?',
                    array(
                        $param['product_price_id']))
            );
        }

        return $result;
    }
    public function getGiftsOrders(){
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ()
            ->From ( $this->orderItem_tbl . ' AS t1' )
            ->where('t1.parent_pro=?',$param['shop_product_id'])
            ->andWhere('t1.parent_order=?',$param['order_id'])
            ->Run ();
        return $this->sqlEngine->getRows() ;
    }
    public function orderItemGiftDelete(){
        $param = $this->request->getAssocParams();
        $result=$this->sqlEngine->remove($this->orderItem_tbl,
            array (
                'parent_pro=? AND parent_order=?',
                array (
                    $param['parent_pro'],$param['parent_order'] ) ) );

        $this->sqlEngine->save('shop_product_price',
            array('stock'=>$param['stock']),
            array (
                'id=?',
                array (
                    $param['product_price_id'] ) )
        );
        return $result;
    }
    public function orderGiftUpdate(){
        $param = $this->request->getAssocParams();
        foreach ($param['orderItemGift'] as $data)
        {
            $this->sqlEngine->Select ()
                ->From (  'shop_product_price AS t1' )
                ->Where ( 't1.id=?', $data[ 'shop_product_gift_id' ] )
                ->Run () ;
            $rowf=$this->sqlEngine->getRow () ;
            $m=$rowf['stock']+$data['count'];
            $result = $this->sqlEngine->save('shop_product_price',
                array('stock' => $m),
                array(
                    'id=?',
                    array(
                        $data['shop_product_gift_id']))
            );
        }
        return $result;
    }

}
