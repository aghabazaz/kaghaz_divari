<?php

class templateSendMapper extends \f\dal
{

    public $sqlEngine ;
    private $dataTable ;
    private $temp_tbl     = 'newsletter_templates' ;
    private $category_tbl = 'newsletter_templates_cat' ;

    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
        $this->dataTable = \f\dalFactory::make ( 'core.dataTable' ) ;
    }

    public function tempList ()
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
                'db' => 't2.title AS category',
                'dt' => 2,
            ),
            array (
                'db' => 't1.status',
                'dt' => 3,
            ),
                ) ;
        $ownerId          = \f\ttt::service ( 'core.auth.getUserOwner' ) ;
        if ( ! $ownerId )
        {
            $ownerId = \f\ttt::dal ( 'core.auth.getOwnerFront' ) ;
        }
        $whereJoin = array (
            "t1.owner_id=" . $ownerId . " AND t1.cat_id=t2.id AND t1.type='" . $pr[ 'type' ] . "'" ) ;

        $result = array (
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->temp_tbl . ' AS t1',
            'primaryKey'      => 't1.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins          = array (
        $this->category_tbl . ' AS t2' ),
            'whereJoin'       => $whereJoin
                ) ;
        //\f\pre($result);
        $out    = $this->dataTable->getDataTable ( $result ) ;
        return $out ;
    }

    public function tempSave ()
    {
        $params               = $this->request->getAssocParams () ;
        $params[ 'owner_id' ] = \f\ttt::service ( 'core.auth.getUserOwner' ) ;
        if ( ! $params[ 'owner_id' ] )
        {
            $params[ 'owner_id' ] = \f\ttt::dal ( 'core.auth.getOwnerFront' ) ;
        }
        $params[ 'date_register' ] = time () ;
        $result                    = $this->sqlEngine->save ( $this->temp_tbl,
                                                              $params
                ) ;
        return $result ;
    }

    public function tempSaveEdit ()
    {
        $params = $this->request->getAssocParams () ;
        $id     = $params[ 'id' ] ;
        unset ( $params[ 'id' ] ) ;

        //\f\pre($params);
        $result = $this->sqlEngine->save ( $this->temp_tbl, $params,
                                           array (
            'id=?',
            array (
                $id )
                )
                ) ;
        return $result ;
    }

    public function tempDelete ()
    {
        $param = $this->request->getAssocParams () ;
        $id    = $param[ 'id' ] ;
        $this->sqlEngine->remove ( $this->temp_tbl,
                                   array (
            'id=?',
            array (
                $id ) ) ) ;

        return array (
            'result' => 'success',
            'func'   => 'remove' ) ;
    }

    public function tempStatus ()
    {
        $param  = $this->request->getAssocParams () ;
        $id     = $param[ 'id' ] ;
        $status = $param[ 'status' ] == 'enabled' ? 'disabled' : 'enabled' ;

        $this->sqlEngine->save ( $this->temp_tbl,
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

    public function getTempById ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ()
                ->From ( $this->temp_tbl . ' AS t1' )
                ->Where ( 't1.id=?', $param[ 'id' ] )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function getTempByOwnerId ()
    {
        $ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;

        if ( ! $ownerId )
        {
            $ownerId = \f\ttt::dal ( 'core.auth.getOwnerFront' ) ;
        }

        $this->sqlEngine->Select ()
                ->From ( $this->temp_tbl . ' AS t1' )
                ->Where ( 't1.owner_id=?', $ownerId )
                ->andWhere ( 'status=?', 'enabled' )
                ->OrderBy ( 'title ASC' )
                ->Run () ;
        return $this->sqlEngine->getRows () ;
    }

    public function getCategoryAll ()
    {
        $this->sqlEngine->Select ()
                ->From ( $this->category_tbl )
                ->Run () ;
        return $this->sqlEngine->getRows () ;
    }

    public function getTemplateLast ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ( 't1.id,t1.title,t1.template' )
                ->From ( $this->temp_tbl . ' AS t1' )
                ->leftJoin ( $this->category_tbl . ' AS t2' )
                ->On ( 't1.cat_id=t2.id' )
                ->Where ( 't1.status=?', 'enabled' )
                ->andWhere ( 't2.title_en=?', $param[ 'template_cat' ] ) ;
        if ( $param[ 'type' ] == 'email' )
        {
            $this->sqlEngine->andWhere ( 't1.type=?', 'email' ) ;
        }
        else
        {
            $this->sqlEngine->andWhere ( 't1.type=?', 'sms' ) ;
        }
        $this->sqlEngine->Run () ;

        return $this->sqlEngine->getRow () ;
    }

}
