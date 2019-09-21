<?php

class colleagueMapper extends \f\dal
{

    public $sqlEngine ;
    private $dataTable ;
    private $colleague_tbl = 'member' ;

    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
        $this->dataTable = \f\dalFactory::make ( 'core.dataTable' ) ;
    }

    public function colleagueList ()
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
                'db' => 't1.colleague_set',
                'dt' => 6,
            ),
                ) ;
        $whereJoin = array ( "t1.colleague_set = 'disabled' OR t1.colleague_set = 'enabled'") ;

        $result = array (
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->colleague_tbl . ' AS t1',
            'primaryKey'      =>  't1.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins          = array (),
            'whereJoin'       => $whereJoin
                ) ;
        $out    = $this->dataTable->getDataTable ( $result ) ;
        return $out ;
    }

    public function colleagueSave ()
    {
        $params                  = $this->request->getAssocParams () ;
        $params[ 'owner_id' ]    = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;
        $params[ 'picture' ]       = $params[ 'picture' ] ? $params[ 'picture' ] : NULL ;
        $params[ 'date_register' ] = time () ;
        //\f\pre($params);

        $result = $this->sqlEngine->save ( $this->colleague_tbl, $params
                ) ;
        return $result ;
    }

    public function colleagueSaveEdit ()
    {
        $params            = $this->request->getAssocParams () ;
        $id                = $params[ 'id' ] ;
        unset ( $params[ 'id' ] ) ;


        $result = $this->sqlEngine->save ( $this->colleague_tbl,
                                           $params
                ,
                                           array (
            'id=?',
            array (
                $id ) ) ) ;
        return $result ;
    }

    public function colleagueDelete ()
    {
        $param = $this->request->getAssocParams () ;
        $id    = $param[ 'id' ] ;
        $this->sqlEngine->remove ( $this->colleague_tbl,
                                   array (
            'id=?',
            array (
                $id ) ) ) ;

        return array (
            'result' => 'success',
            'func'   => 'remove' ) ;
    }

    public function colleagueStatus ()
    {
        $param  = $this->request->getAssocParams () ;
        $id     = $param[ 'id' ] ;
        $colleague_set = $param[ 'status' ] == 'enabled' ? 'disabled' : 'enabled' ;

        $this->sqlEngine->save ( $this->colleague_tbl,
                                 array (
            'colleague_set' => $colleague_set
                ),
                                 array (
            'id=?',
            array (
                $id ) ) ) ;

        return array (
            'result' => 'success',
            'status' => $colleague_set,
            'id'     => $id,
            'func'   => 'status' ) ;
    }

    public function getColleagueById ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ()
                ->From ( $this->colleague_tbl . ' AS t1' )
                ->Where ( 't1.id=?', $param[ 'id' ] )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function getColleagueByOwnerId ()
    {
        $ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;

        if ( ! $ownerId )
        {
            $ownerId = \f\ttt::dal ( 'core.auth.getOwnerFront' ) ;
        }

        $this->sqlEngine->Select ()
                ->From ( $this->colleague_tbl . ' AS t1' )
                ->Where ( 't1.owner_id=?', $ownerId )
                ->andWhere ( 'status=?', 'enabled' )
                ->OrderBy ('title ASC')
                ->Run () ;
        return $this->sqlEngine->getRows () ;
    }

}
