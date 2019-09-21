<?php

class stateMapper extends \f\dal
{

    public $sqlEngine ;
    private $dataTable ;
    private $state_tbl = 'state' ;

    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
        $this->dataTable = \f\dalFactory::make ( 'core.dataTable' ) ;
    }

    public function stateList ()
    {
        $pr               = $this->request->getAssocParams () ;
        $requestDataTable = $pr[ 'dataTableParams' ] ;
       
        

        $columns = array (
            array (
                'db' => $this->state_tbl . '.id', //column name selected
                'dt' => 0, //column num
            ),
            array (
                'db' => $this->state_tbl . '.title',
                'dt' => 1,
            ),
            
           
            array (
                'db' => $this->state_tbl . '.status',
                'dt' => 2,
            ),
            
                ) ;


        $whereJoin = array ('id>0') ;
        



        $result = array (
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->state_tbl,
            'primaryKey'      => $this->state_tbl . '.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins          = array (),
            'whereJoin'       => $whereJoin
                ) ;

        $out = $this->dataTable->getDataTable ( $result ) ;
        return $out ;
    }

    public function stateSave ()
    {
        $params = $this->request->getAssocParams () ;

        $ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;
        $userId  = \f\ttt::dal ( 'core.auth.getUserId' ) ;

        $result = $this->sqlEngine->save ( $this->state_tbl,
                                           array (
            'title'                => $params[ 'title' ],
           
                ) ) ;

        return $result ;
    }

    public function stateSaveEdit ()
    {
        $params  = $this->request->getAssocParams () ;
       
        $result = $this->sqlEngine->save ( $this->state_tbl,
                                           array (
              'title'                => $params[ 'title' ],
                ),
                                           array (
            'id=?',
            array (
                $params[ 'id' ] ) ) ) ;

        return $result ;
    }

    public function stateDelete ()
    {
        $param = $this->request->getAssocParams () ;
        $id    = $param[ 'id' ] ;
        $this->sqlEngine->remove ( $this->state_tbl,
                                   array (
            'id=?',
            array (
                $id ) ) ) ;

        return array (
            'result' => 'success',
            'func'   => 'remove' ) ;
    }

    public function stateStatus ()
    {
        $param  = $this->request->getAssocParams () ;
        $id     = $param[ 'id' ] ;
        $status = $param[ 'status' ] == 'enabled' ? 'disabled' : 'enabled' ;

        $this->sqlEngine->save ( $this->state_tbl,
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

    public function getStateById ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ()
                ->From ( $this->state_tbl )
                ->Where ( 'id=?', $param[ 'id' ] )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function getStateList ()
    {
        $param = $this->request->getAssocParams () ;
        //\f\pr($param);
        $this->sqlEngine->Select ()
                ->From ( $this->state_tbl );
        if($param['status'])
        {
            $this->sqlEngine->Where ( 'status=?', $param['status'] );
        }
        $this->sqlEngine ->Run () ;
        return $this->sqlEngine->getRows () ;
    }

}
