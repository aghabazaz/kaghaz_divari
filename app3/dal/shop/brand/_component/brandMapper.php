<?php

class brandMapper extends \f\dal
{

    public $sqlEngine ;
    private $dataTable ;
    private $brand_tbl = 'shop_brand' ;

    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
        $this->dataTable = \f\dalFactory::make ( 'core.dataTable' ) ;
    }

    public function brandList ()
    {
        $pr               = $this->request->getAssocParams () ;
        $requestDataTable = $pr[ 'dataTableParams' ] ;
        $ownerId          = \f\ttt::service ( 'core.auth.getUserOwner' ) ;

        $columns   = array (
            array (
                'db' => 't1.id', //column name selected
                'dt' => 0, //column num
            ),
            array (
                'db' => 't1.title_fa',
                'dt' => 1,
            ),
            array (
                'db' => 't1.title_en',
                'dt' => 2,
            ),
            array (
                'db' => 't1.logo',
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
        $whereJoin = array (
            "t1.owner_id=" . $ownerId ) ;

        $result = array (
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->brand_tbl . ' AS t1',
            'primaryKey'      => 't1.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins          = array (),
            'whereJoin'       => $whereJoin
                ) ;
        $out    = $this->dataTable->getDataTable ( $result ) ;
        return $out ;
    }

    public function brandSave ()
    {
        $params               = $this->request->getAssocParams () ;
        $params[ 'owner_id' ] = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;
        $params[ 'status' ]   = 'enabled' ;
        unset ( $params[ 'id' ] ) ;
        $result               = $this->sqlEngine->save ( $this->brand_tbl,
                                                         $params
                ) ;
        return $result ;
    }

    public function brandSaveEdit ()
    {
        $params = $this->request->getAssocParams () ;
        $id     = $params[ 'id' ] ;
        unset ( $params[ 'id' ] ) ;
        $result = $this->sqlEngine->save ( $this->brand_tbl,
                                           $params
                ,
                                           array (
            'id=?',
            array (
                $id ) ) ) ;
        return $result ;
    }

    public function brandDelete ()
    {
        $param = $this->request->getAssocParams () ;
        $id    = $param[ 'id' ] ;
        $this->sqlEngine->remove ( $this->brand_tbl,
                                   array (
            'id=?',
            array (
                $id ) ) ) ;

        return array (
            'result' => 'success',
            'func'   => 'remove' ) ;
    }

    public function brandStatus ()
    {
        $param  = $this->request->getAssocParams () ;
        $id     = $param[ 'id' ] ;
        $status = $param[ 'status' ] == 'enabled' ? 'disabled' : 'enabled' ;

        $this->sqlEngine->save ( $this->brand_tbl,
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

    public function getBrandById ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ()
                ->From ( $this->brand_tbl . ' AS t1' )
            ->Where( 't1.id=?',$param['id'] );
        if ( $param['status'] )
        {
            $this->sqlEngine->andWhere( 't1.status=?',$param['status'] );
        }
        $this->sqlEngine->Run();
        return $this->sqlEngine->getRow();
    }
    public function getBrandListFront ()
    {
        $param = $this->request->getAssocParams () ;
        //\f\pre($param);
        $this->sqlEngine->Select ()
                ->From ( $this->brand_tbl . ' AS t1' )
                ->Where ( 't1.status=?', $param['status'] )
                ->OrderBy ( 'id DESC' )
                ->Run () ;
        return $this->sqlEngine->getRows () ;
    }

    public function getBrandByOwnerId ()
    {
        $ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;

        if ( ! $ownerId )
        {
            $ownerId = \f\ttt::dal ( 'core.auth.getOwnerFront' ) ;
        }

        $this->sqlEngine->Select ()
                ->From ( $this->brand_tbl . ' AS t1' )
                ->Where ( 't1.owner_id=?', $ownerId )
                ->andWhere ( 'status=?', 'enabled' )
                ->OrderBy ( 'title_fa ASC' )
                ->Run () ;
        return $this->sqlEngine->getRows () ;
    }

    public function getBrandsByAjaxSearch ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ( 'id,title_fa,title_en,logo' )
                ->From ( $this->brand_tbl )
                ->Where ( 'status=?', 'enabled' )
                ->andWhere ( "title_fa LIKE '%" . $param[ 'keyword' ] . "%'" )
                ->orWhere ( "title_en LIKE '%" . $param[ 'keyword' ] . "%'" ) ;
        $this->sqlEngine->OrderBy ( 'id DESC' ) ;
        if ( $param[ 'limit' ] )
        {
            $this->sqlEngine->Limit ( $param[ 'limit' ] ) ;
        }
        $this->sqlEngine->Run () ;
        return $this->sqlEngine->getRows () ;
    }

    public function getBrandByParam ()
    {
        $param = $this->request->getAssocParams () ;
        if ( $param[ 'selects' ] )
        {
            $select = $param[ 'selects' ] ;
        }
        else
        {
            $select = '*' ;
        }
        $this->sqlEngine->Select ( $select )
            ->From ( $this->brand_tbl . ' AS t1' )
            ->Where ( 1 ) ;
        if ( $param[ 'title_en' ] )
        {
            $this->sqlEngine->andWhere ( 't1.title_en=?', $param[ 'title_en' ] ) ;
        }
        if ( $param[ 'id' ] )
        {
            $this->sqlEngine->andWhere ( 't1.id=?', $param[ 'id' ] ) ;
        }
        $this->sqlEngine->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function checkBrandByProductId(){
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ( 't1.discount,t1.id AS brand_id,t1.type_discount' )
            ->From ( $this->brand_tbl . ' AS t1' )
            ->Where ( "t1.id=?", $param[ 'id' ] )
            ->andWhere ( "t1.status=?", 'enabled' ) ;
        $this->sqlEngine->Run () ;
      //  \f\pr($param);
       //\f\pre($this->sqlEngine->last_query());
        return $this->sqlEngine->getRow () ;
    }
}
