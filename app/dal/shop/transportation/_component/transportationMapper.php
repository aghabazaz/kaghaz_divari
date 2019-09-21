<?php

class transportationMapper extends \f\dal
{

    public $sqlEngine ;
    private $dataTable ;
    private $transportation_tbl = 'shop_transportation' ;

    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
        $this->dataTable = \f\dalFactory::make ( 'core.dataTable' ) ;
    }

    public function transportationList ()
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
                'db' => 't1.cost',
                'dt' => 3,
            ),
            array (
                'db' => 't1.description',
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
            'tableName'       => $this->transportation_tbl . ' AS t1',
            'primaryKey'      =>  't1.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins          = array (),
            'whereJoin'       => $whereJoin
                ) ;
        $out    = $this->dataTable->getDataTable ( $result ) ;
        return $out ;
    }

    public function transportationSave ()
    {
        $params               = $this->request->getAssocParams () ;
        $params[ 'owner_id' ] = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;
        $params[ 'status' ]   = 'enabled' ;
        $params[ 'cost' ]     = str_replace ( ',', '', $params[ 'cost' ] ) ;
        unset ( $params[ 'id' ] ) ;
        $result               = $this->sqlEngine->save ( $this->transportation_tbl,
                                                         $params
                ) ;
        return $result ;
    }

    public function transportationSaveEdit ()
    {
        $params           = $this->request->getAssocParams () ;
        $id               = $params[ 'id' ] ;
        unset ( $params[ 'id' ] ) ;
        $params[ 'cost' ] = str_replace ( ',', '', $params[ 'cost' ] ) ;
        $result           = $this->sqlEngine->save ( $this->transportation_tbl,
                                                     $params
                ,
                                                     array (
            'id=?',
            array (
                $id ) ) ) ;

        return $result ;
    }

    public function transportationDelete ()
    {
        $param = $this->request->getAssocParams () ;
        $id    = $param[ 'id' ] ;
        $this->sqlEngine->remove ( $this->transportation_tbl,
                                   array (
            'id=?',
            array (
                $id ) ) ) ;

        return array (
            'result' => 'success',
            'func'   => 'remove' ) ;
    }

    public function transportationStatus ()
    {
        $param  = $this->request->getAssocParams () ;
        $id     = $param[ 'id' ] ;
        $status = $param[ 'status' ] == 'enabled' ? 'disabled' : 'enabled' ;

        $this->sqlEngine->save ( $this->transportation_tbl,
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

    public function getTransportationById ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ()
                ->From ( $this->transportation_tbl . ' AS t1' )
                ->Where ( 't1.id=?', $param[ 'id' ] )
                ->Run () ;
        //\f\pr($param);
        //\f\pre($this->sqlEngine->last_query());
        return $this->sqlEngine->getRow () ;
    }

    public function getTransportationByParam ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ()
                ->From ( $this->transportation_tbl . ' AS t1' )
                ->Where ( 1 ) ;
        if ( $param[ 'status' ] )
        {
            $this->sqlEngine->andWhere ( 't1.status=?', $param[ 'status' ] ) ;
        }
        $this->sqlEngine->Run () ;
        return $this->sqlEngine->getRows () ;
    }

}
