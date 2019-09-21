<?php

class measurementMapper extends \f\dal
{

    public $sqlEngine ;
    private $dataTable ;
    private $measurement_tbl = 'shop_measurement' ;

    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
        $this->dataTable = \f\dalFactory::make ( 'core.dataTable' ) ;
    }

    public function measurementList ()
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
                'db' => 't1.status',
                'dt' => 2,
            ),
        ) ;

        $whereJoin = array (
            1 ) ;

        $result = array (
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->measurement_tbl . ' AS t1',
            'primaryKey'      =>  't1.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins          = array (),
            'whereJoin'       => $whereJoin
                ) ;
        $out    = $this->dataTable->getDataTable ( $result ) ;
        return $out ;
    }

    public function measurementSave ()
    {
        $params               = $this->request->getAssocParams () ;
        unset ( $params[ 'id' ] ) ;
        $result               = $this->sqlEngine->save ( $this->measurement_tbl,
                                                         $params
                ) ;
        return $result ;
    }

    public function measurementSaveEdit ()
    {
        $params             = $this->request->getAssocParams () ;
        $id                 = $params[ 'id' ] ;
        unset ( $params[ 'id' ] ) ;
        $result             = $this->sqlEngine->save ( $this->measurement_tbl,
                                                       $params,
                                                       array (
            'id=?',
            array (
                $id ) ) ) ;
        return $result ;
    }

    public function measurementDelete ()
    {
        $param = $this->request->getAssocParams () ;
        $id    = $param[ 'id' ] ;
        $this->sqlEngine->remove ( $this->measurement_tbl,
                                   array (
            'id=?',
            array (
                $id ) ) ) ;

        return array (
            'result' => 'success',
            'func'   => 'remove' ) ;
    }

    public function measurementStatus ()
    {
        $param  = $this->request->getAssocParams () ;
        $id     = $param[ 'id' ] ;
        $status = $param[ 'status' ] == 'enabled' ? 'disabled' : 'enabled' ;

        $this->sqlEngine->save ( $this->measurement_tbl,
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

    public function getMeasurementId ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ()
                ->From ( $this->measurement_tbl . ' AS t1' )
                ->Where ( 't1.id=?', $param[ 'id' ] )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

}
