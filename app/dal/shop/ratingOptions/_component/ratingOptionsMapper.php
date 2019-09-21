<?php

class ratingOptionsMapper extends \f\dal
{

    public $sqlEngine ;
    private $dataTable ;
    private $ratingOptions_tbl         = 'shop_rating_options' ;
    private $ratingOptions_feature_tbl = 'shop_ratingOptions_feature' ;
    private $product_tbl               = 'shop_product' ;
    private $shop_brand                = 'shop_brand' ;
    private $category_tbl              = 'shop_category' ;
    private $shop_product_rate_tbl     = 'shop_product_rate ' ;

    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
        $this->dataTable = \f\dalFactory::make ( 'core.dataTable' ) ;
    }

    public function ratingOptionsList ()
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
        $result           = array (
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->ratingOptions_tbl . ' AS t1',
            'primaryKey'      =>  't1.id',
            'columnsArray'    => $columns
                ) ;
        $out              = $this->dataTable->getDataTable ( $result ) ;
        return $out ;
    }

    public function ratingOptionsSave ()
    {
        $params = $this->request->getAssocParams () ;
        $result = $this->sqlEngine->save ( $this->ratingOptions_tbl,
                                           array (
            'title' => $params[ 'title' ],
                )
                ) ;
        return $result ;
    }

    public function ratingOptionsSaveEdit ()
    {
        $params = $this->request->getAssocParams () ;

        $id = $params[ 'id' ] ;
        unset ( $params[ 'id' ] ) ;

        $result = $this->sqlEngine->save ( $this->ratingOptions_tbl,
                                           array (
            'title' => $params[ 'title' ],
                ),
                                           array (
            'id=?',
            array (
                $id )
                )
                ) ;

        return $result ;
    }

    public function saveRatingOptionsScore ()
    {
        $params = $this->request->getAssocParams () ;
        //\f\pre($params);
        for ( $i = 0 ; $i <= count ( $params[ 'option_id' ] ) ; $i ++ )
        {

            $result = $this->sqlEngine->save ( $this->shop_product_rate_tbl,
                                               array (
                'product_id' => $params[ 'product_id' ],
                'option_id'  => $params[ 'option_id' ][ $i ],
                'rate'       => $params[ 'rate' ][ $i ],
                'user_id'    => $params[ 'user_id' ]
                    )
                    ) ;
        }
        return $result ;
    }

    public function ratingOptionsDelete ()
    {
        $param = $this->request->getAssocParams () ;
        $id    = $param[ 'id' ] ;
        $this->sqlEngine->remove ( $this->ratingOptions_tbl,
                                   array (
            'id=?',
            array (
                $id ) ) ) ;

        return array (
            'result' => 'success',
            'func'   => 'remove' ) ;
    }

    public function ratingOptionsStatus ()
    {
        $param  = $this->request->getAssocParams () ;
        $id     = $param[ 'id' ] ;
        $status = $param[ 'status' ] == 'enabled' ? 'disabled' : 'enabled' ;

        $this->sqlEngine->save ( $this->ratingOptions_tbl,
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

    public function getRatingOptionsById ()
    {
        $param = $this->request->getAssocParams () ;
        //\f\pre($param);
        $this->sqlEngine->Select ( 't1.rating_options,t2.*' )
                ->From ( $this->category_tbl . ' AS t1' )
                ->Join ( $this->product_tbl . ' AS t2' )
                ->Where ( 't2.id=?', $param[ 'id' ] )
                ->andWhere ( 't2.shop_category_id = t1.id' ) ;
//        if ( $param[ 'user_id' ] )
//        {
//            $this->sqlEngine->andWhere ( 't1.user_id =?', $param[ 'user_id' ] ) ;
//        }
        $this->sqlEngine->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function getRatingTitleById ()
    {
        $param    = $this->request->getAssocParams () ;
        $prExclud = implode ( ',', $param[ 'ratingValue' ] ) ;
        $this->sqlEngine->Select ( 't1.title,t1.id' )
                ->From ( $this->ratingOptions_tbl . ' AS t1' )
                ->Where ( 't1.id IN (' . $prExclud . ')' )
                ->Run () ;
        return $this->sqlEngine->getRows () ;
    }

    public function getBrandByRatingOptions ()
    {
        $param = $this->request->getAssocParams () ;
        //\f\pre($param);
        $this->sqlEngine->Select ( 't3.id,t3.title_fa,t3.title_en' )
                ->From ( $this->product_tbl . ' AS t2' )
                ->Join ( $this->shop_brand . ' AS t3' )
                ->Where ( 't2.shop_ratingOptions_id=?', $param[ 'categotyId' ] )
                ->andWhere ( 't2.shop_brand_id = t3.id' )
                ->GroupBy ( 't3.id' )
                ->OrderBy ( 'title_fa ASC' )
                ->Run () ;
        //\f\pre($this->sqlEngine->getRows());
        return $this->sqlEngine->getRows () ;
    }

    public function getRatingOptionsByOwnerId ()
    {
        $ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;

        if ( ! $ownerId )
        {
            $ownerId = \f\ttt::dal ( 'core.auth.getOwnerFront' ) ;
        }

        $this->sqlEngine->Select ()
                ->From ( $this->ratingOptions_tbl . ' AS t1' )
                ->Where ( 't1.owner_id=?', $ownerId )
                ->andWhere ( 'status=?', 'enabled' )
                ->OrderBy ( 'title ASC' )
                ->Run () ;
        return $this->sqlEngine->getRows () ;
    }

    public function getFeatureByCatId ()
    {
        $params = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ()
                ->From ( $this->ratingOptions_feature_tbl . ' AS t1' )
                ->Where ( 't1.shop_rating_options_id=?', $params[ 'id' ] )
                ->OrderBy ( 'priority ASC' )
                ->Run () ;
        return $this->sqlEngine->getRows () ;
    }

    public function getProductCatsByAjaxSearch ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ( 'id,title' )
                ->From ( $this->ratingOptions_tbl )
                ->Where ( 'status=?', 'enabled' )
                ->andWhere ( "title LIKE '%" . $param[ 'keyword' ] . "%'" )
                ->orWhere ( "title_en LIKE '%" . $param[ 'keyword' ] . "%'" ) ;
        $this->sqlEngine->OrderBy ( 'id DESC' ) ;
        if ( $param[ 'limit' ] )
        {
            $this->sqlEngine->Limit ( $param[ 'limit' ] ) ;
        }
        $this->sqlEngine->Run () ;
        return $this->sqlEngine->getRows () ;
    }

    public function getRatingOptionsByParam ()
    {
        $param = $this->request->getAssocParams () ;
        //\f\pre($param);
        if ( $param[ 'selects' ] )
        {
            $select = $param[ 'selects' ] ;
        }
        else
        {
            $select = '*' ;
        }
        $this->sqlEngine->Select ( $select )
                ->From ( $this->ratingOptions_tbl . ' AS t1' )
                ->Where ( 1 ) ;
        if ( $param[ 'title_en' ] )
        {
            $this->sqlEngine->andWhere ( 't1.title_en=?', $param[ 'title_en' ] ) ;
        }
        if ( $param[ 'id' ] )
        {
            $this->sqlEngine->andWhere ( 't1.id=?', $param[ 'id' ] ) ;
        }
        $this->sqlEngine->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function getRatingOptionsByUserId ()
    {
        $params = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ()
                ->From ( $this->shop_product_rate_tbl . ' AS t1' )
                ->Where ( 't1.user_id=?', $params[ 'user_id' ] )
                ->andWhere ( 't1.product_id=?', $params[ 'product_id' ] )
                ->Run () ;
        return $this->sqlEngine->getRows () ;
    }

    public function getAVGRatingOptionByProductId ()
    {
        $params = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ( 'AVG(t1.rate) AS rate_avg' )
                ->From ( $this->shop_product_rate_tbl . ' AS t1' )
                ->Where ( 't1.product_id=?', $params[ 'product_id' ] )
                ->GroupBy ( 't1.product_id' )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function getAVGRatingByProductId ()
    {
        $params = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ( 't1.option_id,AVG(t1.rate) AS rate_avg' )
                ->From ( $this->shop_product_rate_tbl . ' AS t1' )
                ->Where ( 't1.product_id=?', $params[ 'product_id' ] )
                ->GroupBy ( 't1.product_id,t1.option_id' )
                ->Run () ;
        return $this->sqlEngine->getRows () ;
    }

    public function checkRatingOptionsByProductUserId ()
    {
        $params = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ( 't1.id' )
                ->From ( $this->shop_product_rate_tbl . ' AS t1' )
                ->Where ( 't1.product_id=?', $params[ 'product_id' ] )
                ->andWhere ( 't1.user_id=?', $params[ 'user_id' ] )
                ->Run () ;
        return $this->sqlEngine->getRows () ;
    }

}
