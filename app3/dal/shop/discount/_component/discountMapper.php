<?php

class discountMapper extends \f\dal
{

    public $sqlEngine ;
    private $dataTable ;
    private $discount_tbl = 'shop_discount_code' ;

    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
        $this->dataTable = \f\dalFactory::make ( 'core.dataTable' ) ;
    }

    public function discountList ()
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
                'db' => 't1.code',
                'dt' => 2,
            ),
            array (
                'db' => 't1.type',
                'dt' => 3,
            ),
            array (
                'db' => 't1.amount ',
                'dt' => 4,
            ),
            array (
                'db' => 't1.owner_id',
                'dt' => 5,
            ),
            array (
                'db' => 't1.status',
                'dt' => 6,
            ),
                ) ;
        $ownerId          = \f\ttt::service ( 'core.auth.getUserOwner' ) ;

        $whereJoin = array (
            "t1.owner_id=" . $ownerId ) ;

        $result = array (
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->discount_tbl . ' AS t1',
            'primaryKey'      =>  't1.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins          = array (),
            'whereJoin'       => $whereJoin
                ) ;
        $out    = $this->dataTable->getDataTable ( $result ) ;
        return $out ;
    }

    public function discountSave ()
    {
        $params               = $this->request->getAssocParams () ;
        $params[ 'owner_id' ] = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;
        $params[ 'status' ]   = 'enabled' ;
        $params[ 'amount' ]   = str_replace ( ',', '', $params[ 'amount' ] ) ;
        unset ( $params[ 'id' ] ) ;
        $result               = $this->sqlEngine->save ( $this->discount_tbl,
                                                         $params
                ) ;
        return $result ;
    }

    public function discountSaveEdit ()
    {
        $params             = $this->request->getAssocParams () ;
        $id                 = $params[ 'id' ] ;
        unset ( $params[ 'id' ] ) ;
        $params[ 'amount' ] = str_replace ( ',', '', $params[ 'amount' ] ) ;
        $result             = $this->sqlEngine->save ( $this->discount_tbl,
                                                       $params
                ,
                                                       array (
            'id=?',
            array (
                $id ) ) ) ;
        return $result ;
    }

    public function discountDelete ()
    {
        $param = $this->request->getAssocParams () ;
        $id    = $param[ 'id' ] ;
        $this->sqlEngine->remove ( $this->discount_tbl,
                                   array (
            'id=?',
            array (
                $id ) ) ) ;

        return array (
            'result' => 'success',
            'func'   => 'remove' ) ;
    }

    public function discountStatus ()
    {
        $param  = $this->request->getAssocParams () ;
        $id     = $param[ 'id' ] ;
        $status = $param[ 'status' ] == 'enabled' ? 'disabled' : 'enabled' ;

        $this->sqlEngine->save ( $this->discount_tbl,
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

    public function getDiscountById ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ()
                ->From ( $this->discount_tbl . ' AS t1' )
                ->Where ( 't1.id=?', $param[ 'id' ] )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function checkAndSubmitOffCode ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ( 't1.*' )
                ->From ( $this->discount_tbl . ' AS t1' )
                ->Where ( 't1.credit_code=?', $param[ 'code' ] )
                ->andWhere ( "t1.date_credit>='" . $param[ 'today' ] . "'" )
                ->andWhere ( "t1.status = 'enabled' " )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function minesNumberById ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Update ( $this->discount_tbl )
                ->setField ( 'number=number-1' )
                ->Where ( 'id=?', $param[ 'id' ] )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function saveDiscountOrder ()
    {
        $param = $this->request->getAssocParams () ;
        $result = $this->sqlEngine->save ( 'shop_order_discount_code', $param ) ;
        return $result ;
    }

    public function removeDiscountOrder ()
    {
        $param = $this->request->getAssocParams () ;

        //\f\pre($param);

        $this->sqlEngine->Select ()
                ->From ( 'shop_order_discount_code' )
                ->Where ( 'id=?', $param[ 'id' ] )
                ->andWhere ( 'order_id=?', $param[ 'orderId' ] )
                ->andWhere ( 'user_id=?', $param[ 'userId' ] )
                ->Run () ;

        $row = $this->sqlEngine->getRow () ;

        if ( ! empty ( $row ) )
        {
            $this->sqlEngine->Select ()
                    ->From ( 'shop_orders' )
                    ->Where ( 'id=?', $param[ 'orderId' ] )
                    ->andWhere ( 'status=?', 'cart' )
                    ->Run () ;

            $oRow = $this->sqlEngine->Run () ;

            if ( ! empty ( $row ) )
            {
                $result = $this->sqlEngine->remove ( 'shop_order_discount_code',
                                                     array (
                    'id=?',
                    array (
                        $param[ 'id' ] )
                        ) ) ;

                if ( $result )
                {
                    $this->sqlEngine->Update ( $this->discount_tbl )
                            ->setField ( 'number=number+1' )
                            ->Where ( 'id=?', $row[ 'discount_id' ] )
                            ->Run () ;
                    
                    $data=array('result'=>'success','message'=>'حذف کد تخفیف با موفقیت انجام شد.');
                }
                else
                {
                    $data=array('result'=>'error','message'=>'اشکال در ارتباط با سرور! دوباره تلاش کنید.');
                }
            }
            else
            {
                $data=array('result'=>'error','message'=>'اشکال در ارتباط با سرور! دوباره تلاش کنید.');
            }
        }
        else
        {
            $data=array('result'=>'error','message'=>'اشکال در ارتباط با سرور! دوباره تلاش کنید.');
        }



        return $data ;
    }

    public function getDiscountOrder ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ( 't1.*,t2.title,t2.credit_code' )
                ->From ( 'shop_order_discount_code AS t1' )
                ->Join ( $this->discount_tbl . ' AS t2' )
                ->Where ( 't1.order_id=?', $param[ 'order_id' ] )
                ->andWhere ( 't1.discount_id=t2.id' )
                ->OrderBy ( 't1.id DESC' )
                ->Run () ;

       // \f\pre($this->sqlEngine->getRows ());
        return $this->sqlEngine->getRows () ;
    }

}
