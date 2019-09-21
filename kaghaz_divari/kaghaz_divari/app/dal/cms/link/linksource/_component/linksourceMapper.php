<?php

class linksourceMapper extends \f\dal
{

    public $sqlEngine ;
    private $dataTable ;
    private $link_tbl          = 'cms_link' ;
    private $link_category_tbl = 'cms_link_category' ;

    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
        $this->dataTable = \f\dalFactory::make ( 'core.dataTable' ) ;
    }

    public function getCategoryList ()
    {
        $this->sqlEngine->Select ()
                ->From ( $this->link_category_tbl )
                ->Where ( "status='enabled'" )
                ->Run () ;
        return $this->sqlEngine->getRows () ;
    }

    public function linksourceList ()
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
                'db' => 't1.link',
                'dt' => 2,
            ),
            array (
                'db' => 't2.title AS categoryTitle',
                'dt' => 3,
            ),
            array (
                'db' => 't1.status',
                'dt' => 4,
            ),
            array (
                'db' => 't1.owner_id',
                'dt' => 5,
            ),
                ) ;

        $whereJoin = array ( 't1.id>0' ) ;
        $result = array (
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->link_tbl . ' AS t1',
            'primaryKey'      => 't1.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => array ( $this->link_category_tbl . ' AS t2' ),
            'whereJoin' => $whereJoin,
            'joinType'  => 'left',
            'onJoin'    => 't1.category_id = t2.id'
                ) ;

        $out = $this->dataTable->getDataTable ( $result ) ;
        return $out ;
    }

    public function getLinkSourceById ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ( 't1.*,t2.title AS categoryTitle' )
                ->From ( $this->link_tbl . ' AS t1' )
                ->leftJoin ( 'cms_link_category AS t2' )
                ->On ( 't1.category_id=t2.id' )
                ->Where ( 't1.id=?', $param[ 'id' ] )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function linksourceSave ()
    {
        $params               = $this->request->getAssocParams () ;
        $params[ 'owner_id' ] = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;
        $params[ 'status' ]   = 'enabled' ;
        unset ( $params[ 'id' ] ) ;
        $result               = $this->sqlEngine->save ( $this->link_tbl,
                                                         $params
                ) ;
        return $result ;
    }

    public function linksourceSaveEdit ()
    {
        $params = $this->request->getAssocParams () ;
        $id     = $params[ 'id' ] ;
        unset ( $params[ 'id' ] ) ;
        $result = $this->sqlEngine->save ( $this->link_tbl, $params,
                                           array (
            'id=?',
            array (
                $id ) ) ) ;
        return $result ;
    }

    public function linksourceDelete ()
    {
        $param = $this->request->getAssocParams () ;
        $id    = $param[ 'id' ] ;
        $this->sqlEngine->remove ( $this->link_tbl,
                                   array (
            'id=?',
            array (
                $id ) ) ) ;

        return array (
            'result' => 'success',
            'func'   => 'remove' ) ;
    }

    public function linksourceStatus ()
    {
        $param  = $this->request->getAssocParams () ;
        $id     = $param[ 'id' ] ;
        $status = $param[ 'status' ] == 'enabled' ? 'disabled' : 'enabled' ;

        $this->sqlEngine->save ( $this->link_tbl,
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

}
