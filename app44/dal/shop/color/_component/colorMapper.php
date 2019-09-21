<?php

class colorMapper extends \f\dal
{

    public $sqlEngine ;
    private $dataTable ;
    private $color_tbl = 'shop_color' ;

    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
        $this->dataTable = \f\dalFactory::make ( 'core.dataTable' ) ;
    }

    public function colorList ()
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
                'dt' => 3,
            ),
            array (
                'db' => 't1.owner_id',
                'dt' => 4,
            ),
            array (
                'db' => 't1.status',
                'dt' => 5,
            ),
                ) ;
        $ownerId          = \f\ttt::service ( 'core.auth.getUserOwner' ) ;

        $whereJoin = array (
            "t1.owner_id=" . $ownerId ) ;

        $result = array (
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->color_tbl . ' AS t1',
            'primaryKey'      =>  't1.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins          = array (),
            'whereJoin'       => $whereJoin
                ) ;
        $out    = $this->dataTable->getDataTable ( $result ) ;
        return $out ;
    }

    public function colorSave ()
    {
        $params               = $this->request->getAssocParams () ;
        $params[ 'owner_id' ] = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;
        $params[ 'status' ]   = 'enabled' ;
        unset ( $params[ 'id' ] ) ;
//        \f\pre ( $params ) ;
        $result               = $this->sqlEngine->save ( $this->color_tbl,
                                                         $params
                ) ;
        return $result ;
    }

    public function colorSaveEdit ()
    {
        $params = $this->request->getAssocParams () ;
        $id     = $params[ 'id' ] ;
        unset ( $params[ 'id' ] ) ;
        $result = $this->sqlEngine->save ( $this->color_tbl,
                                           $params
                ,
                                           array (
            'id=?',
            array (
                $id ) ) ) ;
        return $result ;
    }

    public function colorDelete ()
    {
        $param = $this->request->getAssocParams () ;
        $id    = $param[ 'id' ] ;
        $this->sqlEngine->remove ( $this->color_tbl,
                                   array (
            'id=?',
            array (
                $id ) ) ) ;

        return array (
            'result' => 'success',
            'func'   => 'remove' ) ;
    }

    public function colorStatus ()
    {
        $param  = $this->request->getAssocParams () ;
        $id     = $param[ 'id' ] ;
        $status = $param[ 'status' ] == 'enabled' ? 'disabled' : 'enabled' ;

        $this->sqlEngine->save ( $this->color_tbl,
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

    public function getColorById ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ()
                ->From ( $this->color_tbl . ' AS t1' )
                ->Where ( 't1.id=?', $param[ 'id' ] )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function getColorByOwnerId ()
    {
        $ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;

        if ( ! $ownerId )
        {
            $ownerId = \f\ttt::dal ( 'core.auth.getOwnerFront' ) ;
        }

        $this->sqlEngine->Select ()
                ->From ( $this->color_tbl . ' AS t1' )
                ->Where ( 't1.owner_id=?', $ownerId )
                ->andWhere ( 'status=?', 'enabled' )
                ->OrderBy ( 'title ASC' )
                ->Run () ;
        return $this->sqlEngine->getRows () ;
    }

    public function getColorsByParam ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ()
                ->From ( $this->color_tbl . ' AS t1' )
                ->Where ( 'status=?', 'enabled' )
                ->OrderBy ( 'title ASC' )
                ->Run () ;
//\f\pre($this->sqlEngine->last_query() ());
        return $this->sqlEngine->getRows () ;
    }


    public function getColorsGuranteeByProductId ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ( 't1.color_id AS color_id,t2.title AS color_title,t2.code AS color_code,MIN(t1.price) AS price' )
                ->From ( 'shop_product_price AS t1' )
                ->leftJoin ( $this->color_tbl . ' AS t2' )
                ->On ( 't1.color_id=t2.id' )
                ->leftJoin ( 'shop_guarantee AS t3' )
                ->On ( 't3.id=t1.guarantee_id' )
                ->Where ( "t1.shop_product_id=?", $param[ 'product_id' ] )
                ->andWhere ( 't1.stock>0 AND t1.price>0' ) ;
        $this->sqlEngine->GroupBy ( 't1.color_id' ) ;
        $this->sqlEngine->OrderBy ( 'price ASC' ) ;
        $this->sqlEngine->Run () ;
        return $this->sqlEngine->getRows () ;
    }
     public function getColorsGuranteeByProductIdWidthoutPrice ()
    {
        // \f\pre('');
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ( 't1.color_id AS color_id,t2.title AS color_title,t2.code AS color_code' )
                ->From ( 'shop_product_price AS t1' )
                ->leftJoin ( $this->color_tbl . ' AS t2' )
                ->On ( 't1.color_id=t2.id' )
                ->leftJoin ( 'shop_guarantee AS t3' )
                ->On ( 't3.id=t1.guarantee_id' )
                ->Where ( "t1.shop_product_id=?", $param[ 'product_id' ] )
                ->andWhere ( 't1.stock>0 and t1.color_id<>0' ) ;
        $this->sqlEngine->GroupBy ( 't1.color_id' ) ;
        $this->sqlEngine->OrderBy ( 'price ASC' ) ;
        $this->sqlEngine->Run () ;

        return $this->sqlEngine->getRows () ;
    }

}
