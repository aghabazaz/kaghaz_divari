<?php

class cityMapper extends \f\dal
{

    public $sqlEngine ;
    private $dataTable ;
    private $city_tbl = 'state_city' ;
    private $state_tbl = 'state' ;

    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
        $this->dataTable = \f\dalFactory::make ( 'core.dataTable' ) ;
    }

    public function cityList ()
    {
        $pr               = $this->request->getAssocParams () ;
        $requestDataTable = $pr[ 'dataTableParams' ] ;
       
        

        $columns = array (
            array (
                'db' => $this->city_tbl . '.id', //column name selected
                'dt' => 0, //column num
            ),
            array (
                'db' => $this->city_tbl . '.title',
                'dt' => 1,
            ),
            array (
                'db' => $this->state_tbl . '.title AS stTitle',
                'dt' => 2,
            ),
           
            array (
                'db' => $this->city_tbl . '.status',
                'dt' => 3,
            ),
            
                ) ;


        $whereJoin = array ($this->city_tbl.'.state_id='.$this->state_tbl.'.id') ;
        



        $result = array (
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->city_tbl,
            'primaryKey'      => $this->city_tbl . '.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins          = array ($this->state_tbl),
            'whereJoin'       => $whereJoin
                ) ;

        $out = $this->dataTable->getDataTable ( $result ) ;
        return $out ;
    }

    public function citySave ()
    {
        $params = $this->request->getAssocParams () ;

        $ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;
        $userId  = \f\ttt::dal ( 'core.auth.getUserId' ) ;

        $result = $this->sqlEngine->save ( $this->city_tbl,
                                           array (
            'title'                => $params[ 'title' ],
            'state_id'                => $params[ 'state' ]                                  
           
                ) ) ;

        return $result ;
    }

    public function citySaveEdit ()
    {
        $params  = $this->request->getAssocParams () ;
       
        $result = $this->sqlEngine->save ( $this->city_tbl,
                                           array (
              'title'                => $params[ 'title' ],
              'state_id'                => $params[ 'state' ]                                 
                ),
                                           array (
            'id=?',
            array (
                $params[ 'id' ] ) ) ) ;

        return $result ;
    }

    public function cityDelete ()
    {
        $param = $this->request->getAssocParams () ;
        $id    = $param[ 'id' ] ;
        $this->sqlEngine->remove ( $this->city_tbl,
                                   array (
            'id=?',
            array (
                $id ) ) ) ;

        return array (
            'result' => 'success',
            'func'   => 'remove' ) ;
    }

    public function cityStatus ()
    {
        $param  = $this->request->getAssocParams () ;
        $id     = $param[ 'id' ] ;
        $status = $param[ 'status' ] == 'enabled' ? 'disabled' : 'enabled' ;

        $this->sqlEngine->save ( $this->city_tbl,
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

    public function getCityById ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ()
                ->From ( $this->city_tbl )
                ->Where ( 'id=?', $param[ 'id' ] )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function getCityList ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ()
                ->From ( $this->city_tbl );
        if($param['status'])
        {
            $this->sqlEngine->Where ( 'status=?', 'enabled' );
        }
        if($param['id'])
        {
            if($param['status'])
            {
                $this->sqlEngine->andWhere ( 'state_id=?', $param['id'] );
            }
            else
            {
                $this->sqlEngine->Where ( 'state_id=?', $param['id'] );
            }
            
        }
                
        $this->sqlEngine->Run () ;
        return $this->sqlEngine->getRows () ;
    }

}
