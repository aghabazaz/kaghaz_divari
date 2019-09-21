<?php

class linkcategoryMapper extends \f\dal
{

    public $sqlEngine ;
    private $dataTable ;
    private $linkCategory_tbl = 'cms_link_category' ;

    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
        $this->dataTable = \f\dalFactory::make ( 'core.dataTable' ) ;
    }

    public function linkcategoryList ()
    {
        $pr               = $this->request->getAssocParams () ;
        $requestDataTable = $pr[ 'dataTableParams' ] ;

        $columns = array (
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
            array (
                'db' => 't1.owner_id',
                'dt' => 3,
            ),
                ) ;

        $whereJoin = array ( 't1.id>0' ) ;

        $result = array (
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->linkCategory_tbl . ' AS t1',
            'primaryKey'      => 't1.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins          = array ( ),
            'whereJoin' => $whereJoin,
            'joinType'  => '',
            'onJoin'    => ''
                ) ;
        $out        = $this->dataTable->getDataTable ( $result ) ;
        return $out ;
    }

    public function linkcategoryDelete ()
    {

        $param = $this->request->getAssocParams () ;
        $id    = $param[ 'id' ] ;
        $this->sqlEngine->remove ( $this->linkCategory_tbl,
                                   array (
            'id=?',
            array (
                $id ) ) ) ;

        return array (
            'result' => 'success',
            'func'   => 'remove' ) ;
    }

    public function linkcategoryStatus ()
    {
        $param  = $this->request->getAssocParams () ;
        $id     = $param[ 'id' ] ;
        $status = $param[ 'status' ] == 'enabled' ? 'disabled' : 'enabled' ;

        $this->sqlEngine->save ( $this->linkCategory_tbl,
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

    public function linkcategorySave ()
    {
        $params               = $this->request->getAssocParams () ;
        $params[ 'owner_id' ] = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;
        $params[ 'status' ]   = 'enabled' ;
        unset ( $params[ 'id' ] ) ;
        $result               = $this->sqlEngine->save ( $this->linkCategory_tbl,
                                                         $params
                ) ;
        return $result ;
    }

    public function linkcategorySaveEdit ()
    {
        $params = $this->request->getAssocParams () ;
        $id     = $params[ 'id' ] ;
        unset ( $params[ 'id' ] ) ;

        $result = $this->sqlEngine->save ( $this->linkCategory_tbl, $params,
                                           array (
            'id=?',
            array (
                $id ) ) ) ;

        return $result ;
    }

    public function getLinkCategoryById ()
    {
        $param = $this->request->getAssocParams () ;

        $this->sqlEngine->Select ()
                ->From ( $this->linkCategory_tbl . ' AS t1' )
                ->Where ( 't1.id=?', $param[ 'id' ] )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

}
