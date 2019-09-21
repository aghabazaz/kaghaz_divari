<?php

class wholesalerMapper extends \f\dal
{

    public $sqlEngine ;
    private $dataTable ;
    private $wholesaler_tbl = 'member' ;

    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
        $this->dataTable = \f\dalFactory::make ( 'core.dataTable' ) ;
    }

    public function wholesalerList ()
    {
        $pr               = $this->request->getAssocParams () ;
        $requestDataTable = $pr[ 'dataTableParams' ] ;
        $columns          = array (
            array (
                'db' => 't1.id', //column name selected
                'dt' => 0, //column num
            ),
            array (
                'db' => 't1.name',
                'dt' => 1,
            ),
            array (
                'db' => 't1.phone',
                'dt' => 2,
            ),
            array (
                'db' => 't1.mobile',
                'dt' => 3,
            ),
            array (
                'db' => 't1.shop_name',
                'dt' => 4,
            ),
            array (
                'db' => 't1.address',
                'dt' => 5,
            ),
            array (
                'db' => 't1.wholesaler_set',
                'dt' => 6,
            ),
                ) ;
        $whereJoin = array (
            "t1.wholesaler_set = 'enabled'") ;

        $result = array (
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->wholesaler_tbl . ' AS t1',
            'primaryKey'      =>  't1.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins          = array (),
            'whereJoin'       => $whereJoin
                ) ;
        $out    = $this->dataTable->getDataTable ( $result ) ;
        return $out ;
    }

    public function wholesalerSave ()
    {
        $params                  = $this->request->getAssocParams () ;
        $params[ 'owner_id' ]    = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;
        $params[ 'picture' ]       = $params[ 'picture' ] ? $params[ 'picture' ] : NULL ;
        $params[ 'date_register' ] = time () ;
        //\f\pre($params);

        $result = $this->sqlEngine->save ( $this->wholesaler_tbl, $params
                ) ;
        return $result ;
    }

    public function wholesalerSaveEdit ()
    {
        $params            = $this->request->getAssocParams () ;
        $id                = $params[ 'id' ] ;
        unset ( $params[ 'id' ] ) ;
        $params[ 'picture' ] = $params[ 'picture' ] ? $params[ 'picture' ] : NULL ;

        $result = $this->sqlEngine->save ( $this->wholesaler_tbl,
                                           $params
                ,
                                           array (
            'id=?',
            array (
                $id ) ) ) ;
        return $result ;
    }

    public function wholesalerDelete ()
    {
        $param = $this->request->getAssocParams () ;
        $id    = $param[ 'id' ] ;
        $this->sqlEngine->remove ( $this->wholesaler_tbl,
                                   array (
            'id=?',
            array (
                $id ) ) ) ;

        return array (
            'result' => 'success',
            'func'   => 'remove' ) ;
    }

    public function WholesalerStatus ()
    {
        $param  = $this->request->getAssocParams () ;
        $id     = $param[ 'id' ] ;
        $wholesaler_status = $param[ 'status' ] == 'enabled' ? 'disabled' : 'enabled' ;
        $this->sqlEngine->save ( $this->wholesaler_tbl,
                                 array (
            'wholesaler_set' => $wholesaler_status
                ),
                                 array (
            'id=?',
            array (
                $id ) ) ) ;

        return array (
            'result' => 'success',
            'status' => $wholesaler_status,
            'id'     => $id,
            'func'   => 'status' ) ;
    }

    public function getWholesalerById ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ()
                ->From ( $this->wholesaler_tbl . ' AS t1' )
                ->Where ( 't1.id=?', $param[ 'id' ] )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function getWholesalerByOwnerId ()
    {
        $ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;

        if ( ! $ownerId )
        {
            $ownerId = \f\ttt::dal ( 'core.auth.getOwnerFront' ) ;
        }

        $this->sqlEngine->Select ()
                ->From ( $this->wholesaler_tbl . ' AS t1' )
                ->Where ( 't1.owner_id=?', $ownerId )
                ->andWhere ( 'status=?', 'enabled' )
                ->OrderBy ('title ASC')
                ->Run () ;
        return $this->sqlEngine->getRows () ;
    }

}
