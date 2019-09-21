<?php

class customProductRequestMapper extends \f\dal
{

    public $sqlEngine ;
    private $dataTable ;
    private $customProductRequest_tbl = 'shop_custom_request' ;

    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
        $this->dataTable = \f\dalFactory::make ( 'core.dataTable' ) ;
    }

    public function customProductRequestList ()
    {
        $pr               = $this->request->getAssocParams () ;
        $requestDataTable = $pr[ 'dataTableParams' ] ;
        $columns          = array (
            array (
                'db' => 'id', //column name selected
                'dt' => 0, //column num
            ),
            array (
                'db' => 'name_family',
                'dt' => 1,
            ),
            array (
                'db' => 'call_number',
                'dt' => 2,
            ),
            array (
                'db' => 'date_register',
                'dt' => 3,
            ),
            array (
                'db' => 'status',
                'dt' => 4,
            ),
        ) ;
      //  $ownerId          = \f\ttt::service ( 'core.auth.getUserOwner' ) ;

        $whereJoin = array (1) ;

        $result = array (
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->customProductRequest_tbl . ' AS t1',
            'primaryKey'      =>  't1.id',
            'columnsArray'    => $columns,
            /*'tableJoinName'   => $tbjoins = [
                'shop_product' ],*/
            'whereJoin'       => $whereJoin,
           // 'whereJoin'       => $whereJoin
                ) ;
        $out    = $this->dataTable->getDataTable ( $result ) ;
        //\f\pre($out);
        return $out ;
    }

    public function customProductRequestSave ()
    {
        $params                  = $this->request->getAssocParams () ;
        $params[ 'owner_id' ]    = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;
        $params[ 'pic' ]       = $params[ 'pic' ] ? $params[ 'pic' ] : NULL ;
        $params[ 'date_register' ] = time () ;

        $result = $this->sqlEngine->save ( $this->customProductRequest_tbl, $params
                ) ;
        return $result ;
    }

    public function customProductRequestSaveEdit ()
    {
        $params            = $this->request->getAssocParams () ;
        $id                = $params[ 'id' ] ;
        unset ( $params[ 'id' ] ) ;
        $params[ 'pic' ] = $params[ 'pic' ] ? $params[ 'pic' ] : NULL ;
        $result = $this->sqlEngine->save ( $this->customProductRequest_tbl,
                                           $params
                ,
                                           array (
            'id=?',
            array (
                $id ) ) ) ;

        return $result ;
    }

    public function customProductRequestDelete ()
    {
        $param = $this->request->getAssocParams () ;
        $id    = $param[ 'id' ] ;
        $this->sqlEngine->remove ( $this->customProductRequest_tbl,
                                   array (
            'id=?',
            array (
                $id ) ) ) ;

        return array (
            'result' => 'success',
            'func'   => 'remove' ) ;
    }

    public function customProductRequestStatus ()
    {
        $param  = $this->request->getAssocParams () ;
        $id     = $param[ 'id' ] ;
        $status = $param[ 'status' ] == 'enabled' ? 'disabled' : 'enabled' ;

        $this->sqlEngine->save ( $this->customProductRequest_tbl,
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

    public function getCustomProductRequestById ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ()
                ->From ( $this->customProductRequest_tbl . ' AS t1' )
                ->Where ( 't1.id=?', $param[ 'id' ] )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function getCustomProductRequestByOwnerId ()
    {
        $ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;

        if ( ! $ownerId )
        {
            $ownerId = \f\ttt::dal ( 'core.auth.getOwnerFront' ) ;
        }

        $this->sqlEngine->Select ()
                ->From ( $this->customProductRequest_tbl . ' AS t1' )
                ->Where ( 't1.owner_id=?', $ownerId )
                ->andWhere ( 'status=?', 'enabled' )
                ->OrderBy ('title ASC')
                ->Run () ;
        return $this->sqlEngine->getRows () ;
    }

    public function sendCustomProductRequest(){
        $param  = $this->request->getAssocParams () ;
        //\f\pr($param);
        $result=$this->sqlEngine->save ( $this->customProductRequest_tbl,$param  ) ;
       // \f\pr($param);
        //\f\pre($this->sqlEngine->last_query());
       // \f\pre($result);
        return array (
            'result' => 'success',
            'message'=>\f\ifm::t ( 'successSendMsg' ) ) ;
    }

    public function submitCustomReq(){
        $params   = $this->request->getAssocParams () ;
        //\f\pre($params);
        $params[ 'date_register' ] = time () ;
        preg_match("/[^\/]+$/", $params['pic'], $matches);
        $picNum = $matches[0];
        $result = $this->sqlEngine->save($this->customProductRequest_tbl,
            array(
                'name_family' => $params['nameFamily'],
                'call_number' => $params['callNumber'],
                'email' => $params['email'],
                'width' => $params['width'],
                'height' => $params['height'],
                'pic'=>$params['pic'],
                'product_id'=>$params['product_id'],
                'date_register'=>$params[ 'date_register' ],
                'description'=>$params['description']
            )
        );
      // \f\pr($params);
     //  \f\pre($this->sqlEngine->last_query());
        return $result;
    }
}
