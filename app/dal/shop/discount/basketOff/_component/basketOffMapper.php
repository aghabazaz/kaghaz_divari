<?php

class basketOffMapper extends \f\dal
{

    public $sqlEngine ;
    private $dataTable ;
    private $discount_tbl = 'shop_discount_basket' ;

    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
        $this->dataTable = \f\dalFactory::make ( 'core.dataTable' ) ;
    }

    public function basketOffList ()
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
                'db' => 't1.date_credit',
                'dt' => 2,
            ),
            array (
                'db' => 't1.status',
                'dt' => 3,
            ),
        ) ;

        $whereJoin = array (
            1 ) ;

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

    public function basketOffSave ()
    {
        $params               = $this->request->getAssocParams () ;
        //$params[ 'status' ]   = 'enabled' ;
        //$params[ 'amount' ]   = str_replace ( ',', '', $params[ 'amount' ] ) ;
        unset ( $params[ 'id' ] ) ;
        $result               = $this->sqlEngine->save ( $this->discount_tbl,
                                                         $params
                ) ;
        return $result ;
    }

    public function basketOffSaveEdit ()
    {
        $params             = $this->request->getAssocParams () ;
        $id                 = $params[ 'id' ] ;
        unset ( $params[ 'id' ] ) ;
        $result             = $this->sqlEngine->save ( $this->discount_tbl,
                                                       $params,
                                                       array (
            'id=?',
            array (
                $id ) ) ) ;
        return $result ;
    }

    public function basketOffDelete ()
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

    public function basketOffStatus ()
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

    public function getBasketOffId ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ()
                ->From ( $this->discount_tbl . ' AS t1' )
                ->Where ( 't1.id=?', $param[ 'id' ] )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

}
