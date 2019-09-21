<?php

class amazingMapper extends \f\dal
{

    public $sqlEngine ;
    private $dataTable ;
    private $amazing_tbl = 'shop_amazing' ;
    private $product_tbl = 'shop_product' ;

    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
        $this->dataTable = \f\dalFactory::make ( 'core.dataTable' ) ;
    }

    public function amazingList ()
    {
        $pr               = $this->request->getAssocParams () ;
        $requestDataTable = $pr[ 'dataTableParams' ] ;
        $columns          = array (
            array (
                'db' => 't1.id', //column name selected
                'dt' => 0, //column num
            ),
            array (
                'db' => 't2.title',
                'dt' => 1,
            ),
            array (
                'db' => 't1.date_start',
                'dt' => 3,
            ),
            array (
                'db' => 't1.date_end',
                'dt' => 4,
            ),
            array (
                'db' => 't1.status',
                'dt' => 5,
            ),
                ) ;
        $ownerId          = \f\ttt::service ( 'core.auth.getUserOwner' ) ;

        $whereJoin = array (
            "t1.owner_id=" . $ownerId . ' AND t1.shop_product_id=t2.id' ) ;

        $result = array (
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->amazing_tbl . ' AS t1',
            'primaryKey'      =>  't1.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins          = array (
        'shop_product AS t2' ),
            'whereJoin'       => $whereJoin
                ) ;
        $out    = $this->dataTable->getDataTable ( $result ) ;
        return $out ;
    }

    public function amazingSave ()
    {
        $params               = $this->request->getAssocParams () ;
        $params[ 'owner_id' ] = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;
        $params[ 'price' ]    = str_replace ( ',', '', $params[ 'price' ] ) ;
       //\f\pr($params);
        $result               = $this->sqlEngine->save ( $this->amazing_tbl,
            array(
            'shop_product_id'=>$params['shop_product_id'],
            'short'=>$params['short'],
                'date_start'=>$params['date_start'],
                'date_end'=>$params['date_end'],
                'price'=>$params['price'],
                'content'=>$params['content'],
                'owner_id'=>$params['owner_id'],
            )
                ) ;
       //\f\pre($this->sqlEngine->last_query());
        return $result ;
    }

    public function amazingSaveEdit ()
    {
        $params            = $this->request->getAssocParams () ;
        $id                = $params[ 'id' ] ;
        $params[ 'price' ] = str_replace ( ',', '', $params[ 'price' ] ) ;

        unset ( $params[ 'id' ] ) ;
        $result = $this->sqlEngine->save ( $this->amazing_tbl,
                                           $params
                ,
                                           array (
            'id=?',
            array (
                $id ) ) ) ;
        return $result ;
    }

    public function amazingDelete ()
    {
        $param = $this->request->getAssocParams () ;
        $id    = $param[ 'id' ] ;
        $this->sqlEngine->remove ( $this->amazing_tbl,
                                   array (
            'id=?',
            array (
                $id ) ) ) ;

        return array (
            'result' => 'success',
            'func'   => 'remove' ) ;
    }

    public function amazingStatus ()
    {
        $param  = $this->request->getAssocParams () ;
        $id     = $param[ 'id' ] ;
        $status = $param[ 'status' ] == 'enabled' ? 'disabled' : 'enabled' ;

        $this->sqlEngine->save ( $this->amazing_tbl,
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

    public function getAmazingById ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ()
                ->From ( $this->amazing_tbl . ' AS t1' )
                ->Where ( 't1.id=?', $param[ 'id' ] )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function getAmazingByOwnerId ()
    {
        $ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;

        if ( ! $ownerId )
        {
            $ownerId = \f\ttt::dal ( 'core.auth.getOwnerFront' ) ;
        }

        $this->sqlEngine-> Select ('t1.short,t1.date_start,t1.date_end,t1.price,t2.title')
                ->From ( $this->amazing_tbl . ' AS t1' )
                ->Join ( $this->product_tbl . ' AS t2' )
                ->Where ( 't1.shop_product_id = t2.id' )
                ->andWhere ( 't1.owner_id=?', $ownerId )
                ->andWhere ( 't1.status=?', 'enabled' )
                ->OrderBy ( 't1.id ASC' )
                ->Run () ;
//        return $this->sqlEngine->last_query () ;
        return $this->sqlEngine->getRows () ;
    }

    public function checkAmazingByProductId ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ( 't1.price AS amazing_price,t1.id AS amazing_id,t1.date_end,t1.discount_type' )
                ->From ( $this->amazing_tbl . ' AS t1' )
                ->Where ( "t1.shop_product_id=?", $param[ 'id' ] )
                ->andWhere ( "t1.date_start<=?", $param[ 'today' ] )
                ->andWhere ( "t1.date_end>=?", $param[ 'today' ] )
                ->andWhere ( "t1.status=?", 'enabled' ) ;
        $this->sqlEngine->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function getAllAmazingPro(){
        $this->registerGadgets ( array (
            'dateG' => 'date' ) ) ;
        $today = $this->dateG->today () ;
        $this->sqlEngine->Select ( '*' )
            ->From ( $this->amazing_tbl . ' AS t1' )
            ->Where ( "t1.date_start<=?", $today)
            ->andWhere ( "t1.date_end>=?", $today )
            ->andWhere ( "t1.status=?", 'enabled' ) ;
        $this->sqlEngine->Run () ;
        return $this->sqlEngine->getRows () ;
    }
}
