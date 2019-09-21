<?php
class baseInfoMapper extends \f\dal
{
    public $sqlEngine ;
    private $dataTable ;
    private $baseInfo_tbl= 'shop_base_info' ;

    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
        $this->dataTable = \f\dalFactory::make ( 'core.dataTable' ) ;
    }
    public function baseInfoList ()
    {
        $pr               = $this->request->getAssocParams () ;
        $requestDataTable = $pr[ 'dataTableParams' ] ;
        $ownerId          = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;

        $columns = array (
            array (
                'db' => $this->baseInfo_tbl . '.id', //column name selected
                'dt' => 0, //column num
            ),
            array (
                'db' => $this->baseInfo_tbl . '.status',
                'dt' => 1,
            ),
            array (
                'db' => $this->baseInfo_tbl . '.title',
                'dt' => 2,
            ),
            array (
                'db' => $this->baseInfo_tbl . '.group_id',
                'dt' => 3,
            ),
                ) ;

        $result = array (
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->baseInfo_tbl,
            'primaryKey'      => $this->baseInfo_tbl . '.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins          = array ( ),
            'whereJoin' => $whereJoin  = array (
        'owner_id = ' . $ownerId,
            ),
                ) ;

        $out = $this->dataTable->getDataTable ( $result ) ;
        return $out ;
    }
    public function baseInfoSave()
    {
        $params = $this->request->getAssocParams () ;
        $ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;
        
        $result=$this->sqlEngine->save($this->baseInfo_tbl, array(
            'title'=>$params['title'],
            'owner_id'=>$ownerId,
            'group_id'=>$params['groupBaseInfo'],
            'params'=>'',
            'color'=>$params['color'],
            'icon'=>$params['icon']
            
        ));
        
        return $result;

        
    }
    public function baseInfoSaveEdit()
    {
        $params = $this->request->getAssocParams () ;
       
        
        $result=$this->sqlEngine->save($this->baseInfo_tbl, array(
            'title'=>$params['title'],
            'group_id'=>$params['groupBaseInfo'],
            'params'=>'',
            'color'=>$params['color'],
            'icon'=>$params['icon']
        ),array('id=?',array($params['id'])));
        
        return $result;
    }
    
    public function baseInfoDelete ()
    {
        $param = $this->request->getAssocParams () ;
        $id    = $param[ 'id' ] ;
        $this->sqlEngine->remove ( $this->baseInfo_tbl,
                                   array (
            'id=?',
            array (
                $id ) ) ) ;

        return array (
            'result' => 'success',
            'func'   => 'remove' ) ;
    }

    public function baseInfoStatus ()
    {
        $param  = $this->request->getAssocParams () ;
        $id     = $param[ 'id' ] ;
        $status = $param[ 'status' ] == 'enabled' ? 'disabled' : 'enabled' ;

        $this->sqlEngine->save ( $this->baseInfo_tbl,
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
    
    public function getBaseInfoById ()
    {
        $param  = $this->request->getAssocParams () ;
        $this->sqlEngine->Select()
                ->From($this->baseInfo_tbl)
                ->Where('id=?', $param['id'])
                ->Run();
        return $this->sqlEngine->getRow ();
         
    }
    
    public function getBaseInfoByOwner ()
    {
       $ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;
        $this->sqlEngine->Select()
                ->From($this->baseInfo_tbl)
                ->Where('owner_id=?', $ownerId)
                ->andWhere ( 'status=?','enabled')
                ->andWhere ( 'defaultTemp=?','No')
                ->Run();
        return $this->sqlEngine->getRows ();
    }

    
    
    

   

}