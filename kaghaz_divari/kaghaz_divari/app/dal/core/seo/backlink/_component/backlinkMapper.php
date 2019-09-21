<?php

class backlinkMapper extends \f\dal
{

    public $sqlEngine ;
    private $dataTable ;
    private $backlink_tbl        = 'visit_backlink' ;


    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
        $this->dataTable = \f\dalFactory::make ( 'core.dataTable' ) ;
    }
    public function backlinkList ()
    {
        $pr               = $this->request->getAssocParams () ;
        $requestDataTable = $pr[ 'dataTableParams' ] ;
        $columns = array (
            array (
                'db' => $this->backlink_tbl . '.id', //column name selected
                'dt' => 0, //column num
            ),
            array (
                'db' => $this->backlink_tbl . '.name',
                'dt' => 1,
            ),
            array (
                'db' => $this->backlink_tbl . '.domain',
                'dt' => 2,
            ),
            array (
                'db' => 'SUM('.$this->backlink_tbl . '.num_visit) AS num_visit',
                'dt' => 3,
            ),
            array (
                'db' => $this->backlink_tbl . '.alexa_world_rank',
                'dt' => 4,
            ),
            array (
                'db' => $this->backlink_tbl . '.alexa_country_rank',
                'dt' => 5,
            ),
            array (
                'db' => $this->backlink_tbl . '.alexa_country_code',
                'dt' => 6,
            )
                ) ;
        
        $whereJoin = array (
            1 ) ;
        $result = array (
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->backlink_tbl,
            'primaryKey'      => $this->backlink_tbl . '.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins          = array (),
            'whereJoin'       => $whereJoin,
            'groupBy'=>$this->backlink_tbl . '.name'
                ) ;

        $out = $this->dataTable->getDataTable ( $result ) ;
        return $out ;
    }
    public function backlinkDelete ()
    {
        $param = $this->request->getAssocParams () ;
        $id    = $param[ 'id' ] ;
        $this->sqlEngine->remove ( $this->backlink_tbl,
                                   array (
            'name=?',
            array (
                $id ) ) ) ;

        return array (
            'result' => 'success',
            'func'   => 'remove' ) ;
    }
    public function getBacklinkById ()
    {
        $params= $this->request->getAssocParams();
        
        $this->sqlEngine->Select()
                ->From($this->backlink_tbl)
                ->Where('name=?',$params['id'])
                ->OrderBy('num_visit DESC')
                ->Run();
        
        return $this->sqlEngine->getRows ();
    }
    public function saveBacklinkInfo ()
    {
        $params = $this->request->getAssocParams () ;
        //\f\pr($params);
        $result = $this->sqlEngine->save ( $this->backlink_tbl,
                                        $params,
                                           array (
            'id=?',
            array (
                $params[ 'id' ] )
                ) ) ;

        return $result ;
    }

  
}
