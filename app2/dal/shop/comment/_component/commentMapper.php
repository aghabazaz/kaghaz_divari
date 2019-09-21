<?php

class commentMapper extends \f\dal
{

    public $sqlEngine ;
    private $dataTable ;
    private $comment_tbl              = 'shop_product_comment' ;
    private $shop_product_rate_tbl    = 'shop_product_rate ' ;
    private $shop_product_comment_tip = 'shop_product_comment_tip ' ;

    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
        $this->dataTable = \f\dalFactory::make ( 'core.dataTable' ) ;
    }

    public function commentSave ()
    {
        $params                    = $this->request->getAssocParams () ;
        $params[ 'date_register' ] = time () ;

        $result = $this->sqlEngine->save ( $this->comment_tbl,
                                           array (
            'title'         => $params[ 'title' ],
            'description'   => $params[ 'description' ],
            'user_id'       => $params[ 'user_id' ],
            'product_id'    => $params[ 'product_id' ],
            'date_register' => $params[ 'date_register' ],
                )
                ) ;
        $id     = $this->sqlEngine->last_id () ;
        $this->save_tip_param ( $params[ 'weakness' ], $id, 'weakness' ) ;
        $this->save_tip_param ( $params[ 'strength' ], $id, 'strength' ) ;
        return $result ;
    }

    public function commentSaveEdit ()
    {
        $params                    = $this->request->getAssocParams () ;
        $params[ 'date_register' ] = time () ;
        $id                        = $params[ 'id' ] ;
        $result                    = $this->sqlEngine->save ( $this->comment_tbl,
                                                              array (
            'title'         => $params[ 'title' ],
            'description'   => $params[ 'description' ],
            'date_register' => $params[ 'date_register' ],
                ),
                                                              array (
            'id=?',
            array (
                $id ) )
                ) ;

        $this->sqlEngine->remove ( $this->shop_product_comment_tip,
                                   array (
            'comment_id=?',
            array (
                $id ) ) ) ;
        $this->save_tip_param ( $params[ 'weakness' ], $id, 'weakness' ) ;
        $this->save_tip_param ( $params[ 'strength' ], $id, 'strength' ) ;
        return $result ;
    }

    public function save_tip_param ( $params, $id, $type )
    {
        if ( is_array ( $params ) )
        {
            for ( $i = 0 ; $i <= count ( $params ) ; $i ++ )
            {
                if ( $params[ $i ] != NULL )
                {
                    $this->sqlEngine->save ( $this->shop_product_comment_tip,
                                             array (
                        'comment_id' => $id,
                        'type'       => $type,
                        'title'      => $params[ $i ]
                            )
                    ) ;
                }
            }
        }
    }

    public function getCommentById ()
    {
        $params = $this->request->getAssocParams () ;

        $this->sqlEngine->Select ()
                ->From ( $this->comment_tbl . ' AS t1' )
                ->Where ( 't1.id=?', $params[ 'id' ] )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function getCommentByProductId ()
    {
        $params = $this->request->getAssocParams () ;

        $this->sqlEngine->Select ( 't1.*,t2.name' )
                ->From ( $this->comment_tbl . ' AS t1' )
                ->leftJoin ( 'member AS t2' )
                ->On ( 't1.user_id = t2.id' )
                ->Where ( 't1.product_id=?', $params[ 'product_id' ] ) ;
        if ( $params[ 'user_id' ] )
        {
            $this->sqlEngine->andWhere ( 't1.user_id=?', $params[ 'user_id' ] ) ;
        }
        if ( $params[ 'status' ] )
        {
            $this->sqlEngine->andWhere ( 't1.status=?', $params[ 'status' ] ) ;
        }

        $this->sqlEngine->Run () ;

        if ( $params[ 'multi' ] )
        {
            $row = $this->sqlEngine->getRows () ;
        }
        else
        {
            $row = $this->sqlEngine->getRow () ;
        }
        if ( ! $params[ 'multi' ] )
        {
            $this->sqlEngine->Select ( 't1.*' )
                    ->From ( $this->shop_product_comment_tip . ' AS t1' )
                    ->Where ( 't1.comment_id=?', $row[ 'id' ] )
                    ->Run () ;

            $row2 = $this->sqlEngine->getRows () ;
        }
        else
        {
            foreach ( $row AS $data )
            {
                $this->sqlEngine->Select ( 't1.*' )
                        ->From ( $this->shop_product_comment_tip . ' AS t1' )
                        ->Where ( 't1.comment_id=?', $data[ 'id' ] )
                        ->Run () ;

                $row2[] = $this->sqlEngine->getRows () ;

                $this->sqlEngine->Select ( 't1.option_id,AVG(t1.rate) AS rate_avg' )
                        ->From ( $this->shop_product_rate_tbl . ' AS t1' )
                        ->Where ( 't1.product_id=?', $data[ 'product_id' ] )
                        ->andWhere ( 't1.user_id=?', $data[ 'user_id' ] )
                        ->GroupBy ( 't1.option_id,t1.user_id' )
                        ->Run () ;
                $row3[] = $this->sqlEngine->getRows () ;
            }
        }

        //\f\pre($row2);
        return array (
            $row,
            $row2,
            $row3 ) ;
    }

    public function commentList ()
    {
        $pr               = $this->request->getAssocParams () ;
        $requestDataTable = $pr[ 'dataTableParams' ] ;
        $columns          = array (
            array (
                'db' => 't1.id', //column name selected
                'dt' => 0, //column num
            ),
            array (
                'db' => 't2.name',
                'dt' => 1,
            ),
            array (
                'db' => 't1.title',
                'dt' => 2,
            ),
            array (
                'db' => 't1.description',
                'dt' => 3,
            ),
            array (
                'db' => 't1.date_register',
                'dt' => 4,
            ),
            array (
                'db' => 't1.status',
                'dt' => 5,
            ),
                ) ;
        $whereJoin        = array (
            't1.user_id=t2.id ' ) ;
        $result           = array (
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->comment_tbl . ' AS t1',
            'primaryKey'      => 't1.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins          = array (
        'member AS t2' ),
            'whereJoin'       => $whereJoin,
                ) ;
        $out              = $this->dataTable->getDataTable ( $result ) ;
        return $out ;
    }

    public function commentDelete ()
    {
        $param = $this->request->getAssocParams () ;
        $id    = $param[ 'id' ] ;
        $this->sqlEngine->remove ( $this->comment_tbl,
                                   array (
            'id=?',
            array (
                $id ) ) ) ;

        return array (
            'result' => 'success',
            'func'   => 'remove' ) ;
    }

    public function commentStatus ()
    {
        $param  = $this->request->getAssocParams () ;
        $id     = $param[ 'id' ] ;
        $status = $param[ 'status' ] == 'enabled' ? 'disabled' : 'enabled' ;

        $this->sqlEngine->save ( $this->comment_tbl,
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

}
