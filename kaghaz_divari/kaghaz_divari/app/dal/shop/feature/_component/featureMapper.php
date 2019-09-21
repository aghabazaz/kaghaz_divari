<?php

class featureMapper extends \f\dal
{

    public $sqlEngine ;
    private $dataTable ;
    private $feature_tbl      = 'shop_feature' ;
    private $feature_item_tbl = 'shop_feature_item' ;

    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
        $this->dataTable = \f\dalFactory::make ( 'core.dataTable' ) ;
    }

    public function featureList ()
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
                'db' => 't1.title_long',
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
            'tableName'       => $this->feature_tbl . ' AS t1',
            'primaryKey'      => 't1.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins          = array (),
            'whereJoin'       => $whereJoin
                ) ;
        $out    = $this->dataTable->getDataTable ( $result ) ;
        return $out ;
    }

    public function featureSave ()
    {
        $params               = $this->request->getAssocParams () ;
         //\f\pre($params);
        $params[ 'owner_id' ] = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;

        $result = $this->sqlEngine->save ( $this->feature_tbl,
                                           array (
            'title'         => $params[ 'title' ],
            'title_long'    => $params[ 'title_long' ],
            'owner_id'      => $params[ 'owner_id' ],
            'date_register' => time ()
                )
                ) ;

       
        for ( $i = 0 ; $i < count ( $params[ 'titleParam' ] ) ; $i ++ )
        {
            $id = $params[ 'idParam' ][ $i ] ;

            $this->sqlEngine->save ( $this->feature_item_tbl,
                                         array (
                    'shop_feature_id' => $result,
                    'shop_wiki_id'    => $params[ 'titleParam' ][ $i ],
                    'type'            => $params[ 'type' ][ $i ],
                    'options'         => json_encode ( $params[ 'option' . $id ] ),
                    'required'        => $params[ 'required'. $id ]?1:0,                         
                    'priority'        => $i + 1
                        )
                ) ;
        }
        return $result ;
    }

    public function featureSaveEdit ()
    {
        $params = $this->request->getAssocParams () ;
        
        //\f\pre($params);
        $id     = $params[ 'id' ] ;
        $result = $this->sqlEngine->save ( $this->feature_tbl,
                                           array (
            'title'      => $params[ 'title' ],
            'title_long' => $params[ 'title_long' ],
                ),
                                           array (
            'id=?',
            array (
                $id ) )
                ) ;
        $this->sqlEngine->Select ( 'id' )
                ->From ( $this->feature_item_tbl . ' AS t1' )
                ->Where ( 't1.shop_feature_id=?', $id )
                ->Run () ;

        $row = $this->sqlEngine->getRows () ;
        foreach ( $row AS $data )
        {
            $curParam[] = $data[ 'id' ] ;
        }
        //\f\pre($params);
        for ( $i = 0 ; $i < count ( $params[ 'titleParam' ] ) ; $i ++ )
        {

            $pid = $params[ 'idParam' ][ $i ] ;
            $mainId=  substr($pid, 1);
            if ( in_array ( $mainId, $curParam ) )
            {
                $this->sqlEngine->save ( $this->feature_item_tbl,
                                         array (
                    'shop_feature_id' => $id,
                    'shop_wiki_id'    => $params[ 'titleParam' ][ $i ],
                    'type'            => $params[ 'type' ][ $i ],
                    'options'         => json_encode ( $params[ 'option' . $pid ] ),
                    'required'        => $params[ 'required'. $pid ]?1:0,
                    'priority'        => $i + 1
                        ),
                                                       array (
                    'id=?',
                    array (
                        $mainId )
                        )
                ) ;
                unset ( $curParam[ array_search ( $mainId, $curParam ) ] ) ;
            }
            else
            {
                $this->sqlEngine->save ( $this->feature_item_tbl,
                                         array (
                    'shop_feature_id' => $id,
                    'shop_wiki_id'    => $params[ 'titleParam' ][ $i ],
                    'type'            => $params[ 'type' ][ $i ],
                    'options'         => json_encode ( $params[ 'option' . $pid ] ),
                    'required'        => $params[ 'required'. $pid ]?1:0,                         
                    'priority'        => $i + 1
                        )
                ) ;
            }
        }
        $curParamStr = implode ( ',', $curParam ) ;

        $this->sqlEngine->remove ( $this->feature_item_tbl,
                                   array (
            "id IN ($curParamStr)"
        ) ) ;
        return $result ;
    }

    public function featureDelete ()
    {
        $param = $this->request->getAssocParams () ;
        $id    = $param[ 'id' ] ;
        $this->sqlEngine->remove ( $this->feature_tbl,
                                   array (
            'id=?',
            array (
                $id ) ) ) ;

        return array (
            'result' => 'success',
            'func'   => 'remove' ) ;
    }

    public function featureStatus ()
    {
        $param  = $this->request->getAssocParams () ;
        $id     = $param[ 'id' ] ;
        $status = $param[ 'status' ] == 'enabled' ? 'disabled' : 'enabled' ;

        $this->sqlEngine->save ( $this->feature_tbl,
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

    public function getFeatureById ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ()
                ->From ( $this->feature_tbl . ' AS t1' )
                ->Where ( 't1.id=?', $param[ 'id' ] )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function getParameterById ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ()
                ->From ( $this->feature_item_tbl . ' AS t1' )
                ->Where ( 't1.shop_feature_id=?', $param[ 'id' ] )
                ->OrderBy ( 'priority ASC' )
                ->Run () ;

        return $this->sqlEngine->getRows () ;
    }

    public function getFeatureByOwnerId ()
    {
        $ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;

        if ( ! $ownerId )
        {
            $ownerId = \f\ttt::dal ( 'core.auth.getOwnerFront' ) ;
        }

        $this->sqlEngine->Select ()
                ->From ( $this->feature_tbl . ' AS t1' )
                ->Where ( 't1.owner_id=?', $ownerId )
                ->andWhere ( 'status=?', 'enabled' )
                ->OrderBy ( 'title ASC' )
                ->Run () ;
        return $this->sqlEngine->getRows () ;
    }

}
