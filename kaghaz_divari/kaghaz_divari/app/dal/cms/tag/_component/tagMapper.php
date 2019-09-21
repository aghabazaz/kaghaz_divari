<?php

class tagMapper extends \f\dal
{

    public $sqlEngine ;
    private $dataTable ;
    private $tag_tbl = 'cms_tag' ;

    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
        $this->dataTable = \f\dalFactory::make ( 'core.dataTable' ) ;
    }

    public function tagList ()
    {
        $pr               = $this->request->getAssocParams () ;
        $requestDataTable = $pr[ 'dataTableParams' ] ;
       
        $ownerId          = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;
        $admin            = \f\ttt::service ( 'core.auth.isAdmin' ) ;
        $userId           = \f\ttt::dal ( 'core.auth.getUserId' ) ;

        $columns = array (
            array (
                'db' => $this->tag_tbl . '.id', //column name selected
                'dt' => 0, //column num
            ),
            array (
                'db' => $this->tag_tbl . '.title',
                'dt' => 1,
            ),
            array (
                'db' => $this->tag_tbl . '.date_register',
                'dt' => 2,
            ),
           
            array (
                'db' => $this->tag_tbl . '.status',
                'dt' => 3,
            ),
            
                ) ;


        $whereJoin = array (
            'owner_id = ' . $ownerId,
                ) ;
        if ( $ownerId != $userId && ! $admin )
        {

            $whereJoin = array (
                'owner_id = ' . $ownerId . ' OR created_by=' . $userId,
                    ) ;
        }



        $result = array (
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->tag_tbl,
            'primaryKey'      => $this->tag_tbl . '.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins          = array (),
            'whereJoin'       => $whereJoin
                ) ;

        $out = $this->dataTable->getDataTable ( $result ) ;
        return $out ;
    }

    public function tagSave ()
    {
        $params = $this->request->getAssocParams () ;

        $ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;
        $userId  = \f\ttt::dal ( 'core.auth.getUserId' ) ;

        $result = $this->sqlEngine->save ( $this->tag_tbl,
                                           array (
            'owner_id'             => $ownerId,
            'created_by'           => $userId,
            'title'                => $params[ 'title' ],
            'link'                => $params[ 'link' ],
            'date_register'        => time (),
                ) ) ;

        return $result ;
    }

    public function tagSaveEdit ()
    {
        $params  = $this->request->getAssocParams () ;
        $ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;
        $userId  = \f\ttt::dal ( 'core.auth.getUserId' ) ;


        $result = $this->sqlEngine->save ( $this->tag_tbl,
                                           array (
              'title'                => $params[ 'title' ],
              'link'                => $params[ 'link' ],
                ),
                                           array (
            'id=?',
            array (
                $params[ 'id' ] ) ) ) ;

        return $result ;
    }

    public function tagDelete ()
    {
        $param = $this->request->getAssocParams () ;
        $id    = $param[ 'id' ] ;
        $this->sqlEngine->remove ( $this->tag_tbl,
                                   array (
            'id=?',
            array (
                $id ) ) ) ;

        return array (
            'result' => 'success',
            'func'   => 'remove' ) ;
    }

    public function tagStatus ()
    {
        $param  = $this->request->getAssocParams () ;
        $id     = $param[ 'id' ] ;
        $status = $param[ 'status' ] == 'enabled' ? 'disabled' : 'enabled' ;

        $this->sqlEngine->save ( $this->tag_tbl,
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

    public function getTagById ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ()
                ->From ( $this->tag_tbl )
                ->Where ( 'id=?', $param[ 'id' ] )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function getTagByOwnerId ()
    {
        
        $ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;
        if(!$ownerId)
        {
            $ownerId = \f\ttt::dal ( 'core.auth.getOwnerFront' ) ;
        }
         
        $this->sqlEngine->Select ()
                ->From ( $this->tag_tbl )
                ->Where ( 'owner_id=?', $ownerId )
                ->andWhere ( 'status=?', 'enabled' )
                ->Run () ;
        return $this->sqlEngine->getRows () ;
    }

}
