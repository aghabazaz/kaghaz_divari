<?php

class personnelMapper extends \f\dal
{

    public $sqlEngine ;
    private $dataTable ;
    private $personnel_tbl = 'cms_team_personnel' ;

    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
        $this->dataTable = \f\dalFactory::make ( 'core.dataTable' ) ;
    }

    public function personnelList ()
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
                'db' => 't1.date_register',
                'dt' => 2,
            ),
            array (
                'db' => 't1.status',
                'dt' => 3,
            ),
                ) ;
        $ownerId          = \f\ttt::service ( 'core.auth.getUserOwner' ) ;

        $whereJoin = array (
            "t1.owner_id=" . $ownerId ) ;

        $result = array (
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->personnel_tbl . ' AS t1',
            'primaryKey'      => $this->personnel_tbl . '.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins          = array (),
            'whereJoin'       => $whereJoin
                ) ;
        $out    = $this->dataTable->getDataTable ( $result ) ;
        return $out ;
    }

    public function personnelSave ()
    {
        $params                    = $this->request->getAssocParams () ;
        $params[ 'owner_id' ]      = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;
        $params[ 'picture' ]       = $params[ 'picture' ] ? $params[ 'picture' ] : NULL ;
        $params[ 'date_register' ] = time () ;
        //\f\pre($params);

        $result = $this->sqlEngine->save ( $this->personnel_tbl, $params
                ) ;

        return $result ;
    }

    public function personnelSaveEdit ()
    {
        $params = $this->request->getAssocParams () ;
        //\f\pre($params);

        $id                    = $params[ 'id' ] ;
        unset ( $params[ 'id' ] ) ;
        $params[ 'picture' ]   = $params[ 'picture' ] ? $params[ 'picture' ] : NULL ;

        $result = $this->sqlEngine->save ( $this->personnel_tbl,
                                           $params,
                                           array (
            'id=?',
            array (
                $id )
                )
                ) ;
        return $result ;
    }

    public function personnelDelete ()
    {
        $param = $this->request->getAssocParams () ;
        $id    = $param[ 'id' ] ;
        $this->sqlEngine->remove ( $this->personnel_tbl,
                                   array (
            'id=?',
            array (
                $id ) ) ) ;

        return array (
            'result' => 'success',
            'func'   => 'remove' ) ;
    }

    public function personnelStatus ()
    {
        $param  = $this->request->getAssocParams () ;
        $id     = $param[ 'id' ] ;
        $status = $param[ 'status' ] == 'enabled' ? 'disabled' : 'enabled' ;

        $this->sqlEngine->save ( $this->personnel_tbl,
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

    public function getPersonnelById ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ()
                ->From ( $this->personnel_tbl . ' AS t1' )
                ->Where ( 't1.id=?', $param[ 'id' ] )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function getPersonnelByOwnerId ()
    {
        $ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;

        if ( ! $ownerId )
        {
            $ownerId = \f\ttt::dal ( 'core.auth.getOwnerFront' ) ;
        }

        $this->sqlEngine->Select ()
                ->From ( $this->personnel_tbl . ' AS t1' )
                ->Where ( 't1.owner_id=?', $ownerId )
                ->andWhere ( 'status=?', 'enabled' )
                ->OrderBy ( 'title ASC' )
                ->Run () ;
        return $this->sqlEngine->getRows () ;
    }
    public function getPersonnelByParam ()
    {
        $param  = $this->request->getAssocParams () ;
        $ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;

        if ( ! $ownerId )
        {
            $ownerId = \f\ttt::dal ( 'core.auth.getOwnerFront' ) ;
        }

        $this->sqlEngine->Select ()
                ->From ( $this->personnel_tbl . ' AS t1' )
                ->Where ( 't1.owner_id=?', $ownerId );
                if($param['status'])
                {
                    $this->sqlEngine->andWhere('status=?',$param['status']);
                }
                
                $this->sqlEngine->OrderBy ( 'id DESC' );
                if($param['limit'])
                {
                    $this->sqlEngine->Limit($param['limit']);
                }
                $this->sqlEngine->Run () ;
        return $this->sqlEngine->getRows () ;
    }
    
    public function personnelSpecial ()
    {
        $param  = $this->request->getAssocParams () ;
        $id     = $param[ 'id' ] ;
        $status = $param[ 'status' ] == 'enabled' ? 'disabled' : 'enabled' ;

        $this->sqlEngine->save ( $this->personnel_tbl,
                                 array (
            'special' => $status
                ),
                                 array (
            'id=?',
            array (
                $id ) ) ) ;

        return array (
            'result' => 'success',
            'status' => $status,
            'id'     => $id,
            'func'   => 'special' ) ;
    }
    

}
