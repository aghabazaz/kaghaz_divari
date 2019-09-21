<?php

class departmentMapper extends \f\dal
{

    public $sqlEngine ;
    private $dataTable ;
    private $department_tbl = 'cms_team_department' ;

    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
        $this->dataTable = \f\dalFactory::make ( 'core.dataTable' ) ;
    }

    public function departmentList ()
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
            'tableName'       => $this->department_tbl . ' AS t1',
            'primaryKey'      => $this->department_tbl . '.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins          = array (),
            'whereJoin'       => $whereJoin
                ) ;
        $out    = $this->dataTable->getDataTable ( $result ) ;
        return $out ;
    }

    public function departmentSave ()
    {
        $params                    = $this->request->getAssocParams () ;
        $params[ 'owner_id' ]      = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;
        $params[ 'picture' ]       = $params[ 'picture' ] ? $params[ 'picture' ] : NULL ;
        $params[ 'parent_id' ]     = $params[ 'parent_id' ] ? $params[ 'parent_id' ] : NULL ;
        $params[ 'date_register' ] = time () ;
        //\f\pre($params);

        $result = $this->sqlEngine->save ( $this->department_tbl,
                                           array (
            'owner_id'      => $params[ 'owner_id' ],
            'title'         => $params[ 'title' ],
            'parent_id'     => $params[ 'parent_id' ],
            'content'       => $params[ 'content' ],
            'picture'       => $params[ 'picture' ],
            'date_register' => $params[ 'date_register' ]
                )
                ) ;


        return $result ;
    }

    public function departmentSaveEdit ()
    {
        $params = $this->request->getAssocParams () ;
        //\f\pre($params);

        $id                    = $params[ 'id' ] ;
        unset ( $params[ 'id' ] ) ;
        $params[ 'picture' ]   = $params[ 'picture' ] ? $params[ 'picture' ] : NULL ;
        $params[ 'parent_id' ] = $params[ 'parent_id' ] ? $params[ 'parent_id' ] : NULL ;

        $result = $this->sqlEngine->save ( $this->department_tbl,
                                           array (
            'title'     => $params[ 'title' ],
            'parent_id' => $params[ 'parent_id' ],
            'content'   => $params[ 'content' ],
            'picture'   => $params[ 'picture' ],
                ),
                                           array (
            'id=?',
            array (
                $id )
                )
                ) ;
        return $result ;
    }

    public function departmentDelete ()
    {
        $param = $this->request->getAssocParams () ;
        $id    = $param[ 'id' ] ;
        $this->sqlEngine->remove ( $this->department_tbl,
                                   array (
            'id=?',
            array (
                $id ) ) ) ;

        return array (
            'result' => 'success',
            'func'   => 'remove' ) ;
    }

    public function departmentStatus ()
    {
        $param  = $this->request->getAssocParams () ;
        $id     = $param[ 'id' ] ;
        $status = $param[ 'status' ] == 'enabled' ? 'disabled' : 'enabled' ;

        $this->sqlEngine->save ( $this->department_tbl,
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

    public function getDepartmentById ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ()
                ->From ( $this->department_tbl . ' AS t1' )
                ->Where ( 't1.id=?', $param[ 'id' ] )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function getDepartmentByOwnerId ()
    {
        $ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;

        if ( ! $ownerId )
        {
            $ownerId = \f\ttt::dal ( 'core.auth.getOwnerFront' ) ;
        }

        $this->sqlEngine->Select ()
                ->From ( $this->department_tbl . ' AS t1' )
                ->Where ( 't1.owner_id=?', $ownerId )
                ->andWhere ( 'status=?', 'enabled' )
                ->OrderBy ( 'title ASC' )
                ->Run () ;
        return $this->sqlEngine->getRows () ;
    }

}
