<?php

class wikiMapper extends \f\dal
{

    public $sqlEngine ;
    private $dataTable ;
    private $wiki_tbl = 'shop_wiki' ;

    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
        $this->dataTable = \f\dalFactory::make ( 'core.dataTable' ) ;
    }

    public function wikiList ()
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
        $ownerId          = \f\ttt::service ( 'core.auth.getUserOwner' ) ;

        $whereJoin = array (
            "t1.owner_id=" . $ownerId ) ;

        $result = array (
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->wiki_tbl . ' AS t1',
            'primaryKey'      =>  't1.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins          = array (),
            'whereJoin'       => $whereJoin
                ) ;
        $out    = $this->dataTable->getDataTable ( $result ) ;
        return $out ;
    }

    public function wikiSave ()
    {
        $params                  = $this->request->getAssocParams () ;
        $params[ 'owner_id' ]    = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;
        $params[ 'picture' ]       = $params[ 'picture' ] ? $params[ 'picture' ] : NULL ;
        $params[ 'date_register' ] = time () ;
        //\f\pre($params);

        $result = $this->sqlEngine->save ( $this->wiki_tbl, $params
                ) ;
        return $result ;
    }

    public function wikiSaveEdit ()
    {
        $params            = $this->request->getAssocParams () ;
        $id                = $params[ 'id' ] ;
        unset ( $params[ 'id' ] ) ;
        $params[ 'picture' ] = $params[ 'picture' ] ? $params[ 'picture' ] : NULL ;

        $result = $this->sqlEngine->save ( $this->wiki_tbl,
                                           $params
                ,
                                           array (
            'id=?',
            array (
                $id ) ) ) ;
        return $result ;
    }

    public function wikiDelete ()
    {
        $param = $this->request->getAssocParams () ;
        $id    = $param[ 'id' ] ;
        $this->sqlEngine->remove ( $this->wiki_tbl,
                                   array (
            'id=?',
            array (
                $id ) ) ) ;

        return array (
            'result' => 'success',
            'func'   => 'remove' ) ;
    }

    public function wikiStatus ()
    {
        $param  = $this->request->getAssocParams () ;
        $id     = $param[ 'id' ] ;
        $status = $param[ 'status' ] == 'enabled' ? 'disabled' : 'enabled' ;

        $this->sqlEngine->save ( $this->wiki_tbl,
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

    public function getWikiById ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ()
                ->From ( $this->wiki_tbl . ' AS t1' )
                ->Where ( 't1.id=?', $param[ 'id' ] )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function getWikiByOwnerId ()
    {
        $ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;

        if ( ! $ownerId )
        {
            $ownerId = \f\ttt::dal ( 'core.auth.getOwnerFront' ) ;
        }

        $this->sqlEngine->Select ()
                ->From ( $this->wiki_tbl . ' AS t1' )
                ->Where ( 't1.owner_id=?', $ownerId )
                ->andWhere ( 'status=?', 'enabled' )
                ->OrderBy ('title ASC')
                ->Run () ;
        return $this->sqlEngine->getRows () ;
    }

}
