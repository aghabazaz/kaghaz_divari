<?php

class productView extends \f\view
{

    public function __construct ()
    {
        
    }

    public function renderConcessionProduct ( $params )
    {
        if ( $params[ 0 ] == 'page' )
        {
            $page = $params[ 1 ] ;
        }
        $numPerPage = 2 ;
        if ( ! $page )
        {
            $page = 1 ;
        }
        $this->registerGadgets ( array (
            'dateG' => 'date' ) ) ;
        $todayDate       = $this->dateG->today () ;
        $array           = \f\ttt::service ( 'shop.product.getAmazingProducts',
                                             array (
                    'today'      => $todayDate,
                    'numPerPage' => $numPerPage,
                    'page'       => $page
                ) ) ;
        $sRow[ 'title' ] = 'تخفیفی ها' ;
        //\f\pre($array);
        $row             = $array[ 0 ] ;
        $num             = $array[ 1 ] ;
        $content         = $this->render ( 'product',
                                           array (
            'ConcessionProduct' => $row,
            'num'               => $num,
            'num_page'          => $numPerPage,
            'page'              => $page,
            'sRow'              => $sRow,
                ) ) ;
        return array (
            $content,
            $sRow ) ;
    }

    public function renderBrandsProduct ( $param )
    {
        if ( $param[ 2 ] == 'page' )
        {
            $page = $param[ 3 ] ;
        }
        $numPerPage = 10 ;

        if ( ! $page )
        {
            $page = 1 ;
        }

        $sRow[ 'title' ] = 'محصولات انتخابی' ;

        $brandId = $param[ '1' ] ;
        $array   = \f\ttt::service ( 'shop.product.getProductByBrandId',
                                     array (
                    'status'     => 'enabled',
                    'page'       => $page,
                    'numPerPage' => $numPerPage,
                    'id'         => $brandId
                        ), true ) ;

        $getBrand = \f\ttt::service ( 'shop.brand.getBrandById',
                                      array (
                    'status' => 'enabled',
                    'id'     => $brandId
                        ), true ) ;


        //\f\pre($getBrand);
        $row = $array[ 0 ] ;
        $num = $array[ 1 ] ;

        //\f\pr($numPerPage);
        $content = $this->render ( 'selectiveProduct',
                                   array (
            'row'      => $row,
            'num_page' => $numPerPage,
            'num'      => $num,
            'page'     => $page,
            'brand'    => $getBrand,
                ) ) ;

        return array (
            $content,
            $sRow ) ;
    }

    public function renderGiftsProduct ( $param )
    {
        //\f\pre($param);
        if ( $param[ 1 ] == 'page' )
        {
            $page = $param[ 2 ] ;
        }
        $numPerPage = 10 ;

        if ( ! $page )
        {
            $page = 1 ;
        }
        $sRow[ 'title' ] = 'هدایای تبلیغاتی' ;

        $array = \f\ttt::service ( 'shop.product.getGiftsProduct',
                                   array (
                    'status'     => 'enabled',
                    'page'       => $page,
                    'numPerPage' => $numPerPage,
                        ), true ) ;
        //\f\pre($array);
        //\f\pre($getBrand);
        $row = $array[ 0 ] ;
        $num = $array[ 1 ] ;

        //\f\pr($numPerPage);
        $content = $this->render ( 'giftsProduct',
                                   array (
            'row'      => $row,
            'num_page' => $numPerPage,
            'num'      => $num,
            'page'     => $page,
            'brand'    => $getBrand,
                ) ) ;

        return array (
            $content,
            $sRow ) ;
    }

    public function renderGetProductDetail ( $params )
    {
        $id              = $params[ 0 ] ;
        \f\ttt::service ( 'shop.product.setProductVisit',
                          array (
            'id' => $id
                )
        ) ;
        $row             = \f\ttt::service ( 'shop.product.getProductById',
                                             array (
                    'id' => $id
                ) ) ;
        $this->registerGadgets ( array (
            'dateG' => 'date' ) ) ;
        $today           = $this->dateG->today () ;
        $amazingId       = \f\ttt::service ( 'shop.amazing.checkAmazingByProductId',
                                             array (
                    'id'    => $row[ 'id' ],
                    'today' => $today,
                ) ) ;
        //\f\pre($amazingId);
        $catId           = \f\ttt::service ( 'shop.category.getCategoryByParam',
                                             array (
                    'selects' => 'id,title,parent_id,title_en',
                    'id'      => $row[ 'shop_category_id' ]
                ) ) ;
        //get parent Category
        $parentsCat      = $this->sortByCatId ( $catId, $sort_category ) ;
        $keys            = array_keys ( $parentsCat ) ;
        $values          = array_values ( $parentsCat ) ;
        $reverseArrValue = array_reverse ( $values ) ;
        $reverseArrKey   = array_reverse ( $keys ) ;
        $sort_path_cat   = array_combine ( $reverseArrKey, $reverseArrValue ) ;
        //\f\pre($sort_path_cat);

        $brandId = \f\ttt::service ( 'shop.brand.getBrandByParam',
                                     array (
                    'selects' => 'id,title_fa,title_en',
                    'id'      => $row[ 'shop_brand_id' ]
                ) ) ;
        //\f\pre($brandId);
        //get Features product by cat_id and id product
        $wiki    = \f\ttt::service ( 'shop.wiki.getWikiByOwnerId' ) ;
        foreach ( $wiki AS $data )
        {
            $wikiArr[ $data[ 'id' ] ] = $data[ 'title' ] ;
        }
        $pFeature = \f\ttt::service ( 'shop.product.getFeatureByProductId',
                                      array (
                    'id' => $row[ 'id' ]
                ) ) ;
        foreach ( $pFeature AS $data )
        {
            $pfValue[ $data[ 'shop_feature_item_id' ] ] = json_decode ( $data[ 'value' ],
                                                                        TRUE ) ;
        }
        //send last cat 
        foreach ( $sort_path_cat AS $data )
        {
            $features[] = \f\ttt::service ( 'shop.product.getFeatureByCatId',
                                            array (
                        'id' => $data[ 'id' ]
                    ) ) ;
//            $feature .= $this->render ( 'feature',
//                                        array (
//                'row'   => $row,
//                'wiki'  => $wikiArr,
//                'value' => $pfValue
//                    ) ) ;
        }
        //\f\pre ( $features ) ;
        $colors = \f\ttt::service ( 'shop.color.getColorsGuranteeByProductId',
                                    array (
                    'product_id' => $row[ 'id' ],
                ) ) ;


        $picture = \f\ttt::service ( 'core.fileManager.getList',
                                     array (
                    'path' => 'shop.product.' . $id,
                ) ) ;
        foreach ( $picture[ 'list' ] AS $data )
        {
            $picArr[ $data[ 'id' ] ][ 'title' ] = $data[ 'title' ] ;
            $picArr[ $data[ 'id' ] ][ 'path' ]  = $this->filePath ( $data[ 'path' ] ) ;
        }
        //\f\pre($picArr);
        $ratingOptions = \f\ttt::service ( 'shop.ratingOptions.getRatingOptionsById',
                                           array (
                    'id' => $id
                ) ) ;
        //\f\pre($ratingOptions);
        $ratingValue   = json_decode ( $ratingOptions[ 'rating_options' ] ) ;
        $ratingTitle   = \f\ttt::service ( 'shop.ratingOptions.getRatingTitleById',
                                           array (
                    'ratingValue' => $ratingValue
                ) ) ;
        foreach ( $ratingTitle AS $data )
        {
            $arrRatingTitle[ $data[ 'id' ] ] = $data[ 'title' ] ;
        }
        $ratingValues = \f\ttt::service ( 'shop.ratingOptions.getAVGRatingByProductId',
                                          array (
                    'product_id' => $id
                ) ) ;
        foreach ( $ratingValues AS $data )
        {
            $arrRatingValue[ $data[ 'option_id' ] ] = round ( $data[ 'rate_avg' ],
                                                              1 ) ;
        }

//        $productComments = \f\ttt::service ( 'shop.comment.getCommentByProductId',
//                                             array (
//                    'product_id' => $id,
//                    'status'     => 'enabled',
//                    'multi'      => 'true'
//                ) ) ;
//        $i               = 0 ;
//        foreach ( $productComments AS $data )
//        {
//            foreach ( $productComments AS $data2 )
//            {
//                $arrComment[ $data[ $i ][ 'id' ] ]          = $data[ $i ] ;
//                $arrComment[ $data[ $i ][ 'id' ] ][ 'tip' ] = $productComments[ 1 ][ $i ] ;
//
//                foreach ( $arrComment[ $data[ $i ][ 'id' ] ][ 'tip' ] as $data3 )
//                {
//                    if ( $data3[ 'type' ] == 'weakness' )
//                    {
//                        $arrComment[ $data[ $i ][ 'id' ] ][ 'weakness' ][ $data3[ 'id' ] ] = $data3[ 'title' ] ;
//                    }
//                    else
//                    {
//                        $arrComment[ $data[ $i ][ 'id' ] ][ 'strenght' ][ $data3[ 'id' ] ] = $data3[ 'title' ] ;
//                    }
//                }
//                unset ( $arrComment[ $data[ $i ][ 'id' ] ][ 'tip' ] ) ;
//                $arrComment[ $data[ $i ][ 'id' ] ][ 'rating' ] = $productComments[ 2 ][ $i ] ;
//                foreach ( $arrComment[ $data[ $i ][ 'id' ] ][ 'rating' ] AS $data4 )
//                {
//                    $arrComment[ $data[ $i ][ 'id' ] ][ 'rate' ][ $data4[ 'option_id' ] ] = round ( $data4[ 'rate_avg' ],
//                                                                                                    1 ) ;
//                }
//                unset ( $arrComment[ $data[ $i ][ 'id' ] ][ 'rating' ] ) ;
//                $i ++ ;
//            }
//        }
        //\f\pre ( $arrComment ) ;
        $content = $this->render ( 'detailProduct',
                                   array (
            'row'            => $row,
            'picture'        => $picArr,
            'category'       => $catId,
            'brand'          => $brandId,
            'sortCat'        => $sort_path_cat,
            'colors'         => $colors,
            'feature'        => $features,
            'wiki'           => $wikiArr,
            'value'          => $pfValue,
            'amazing'        => $amazingId,
            'ratingTitle'    => $arrRatingTitle,
            'arrRatingValue' => $arrRatingValue,
            'comments'       => $arrComment,
                ) ) ;

        return array (
            $content,
            $row,
            array () ) ;
    }

    public function filePath ( $path )
    {
        $path = \f\ifm::app ()->siteUrl . 'upload/' . (str_replace ( '-', '.',
                                                                     str_replace ( '.',
                                                                                   '/',
                                                                                   $path ) )) ;
        return $path ;
    }

    public function renderGetProduct ( $param )
    {
        $catId           = \f\ttt::service ( 'shop.category.getCategoryByParam',
                                             array (
                    'selects'  => 'id,title,parent_id,title_en',
                    'title_en' => $param[ 0 ]
                ) ) ;
        //get parent Category
        $parentsCat      = $this->sortByCatId ( $catId, $sort_category ) ;
        $keys            = array_keys ( $parentsCat ) ;
        $values          = array_values ( $parentsCat ) ;
        $reverseArrValue = array_reverse ( $values ) ;
        $reverseArrKey   = array_reverse ( $keys ) ;
        $sort_path_cat   = array_combine ( $reverseArrKey, $reverseArrValue ) ;
        //\f\pre($sort_path_cat);
        if ( $param[ 1 ] )
        {
            $brandId = \f\ttt::service ( 'shop.brand.getBrandByParam',
                                         array (
                        'selects'  => 'id,title_fa,title_en',
                        'title_en' => $param[ 1 ]
                    ) ) ;
        }
        $brands = \f\ttt::service ( 'shop.product.getBrandsByProductsCat',
                                    array (
                    'cat_id' => $catId[ 'id' ]
                ) ) ;
        //\f\pre ( $brands ) ;

        $colors = \f\ttt::service ( 'shop.color.getColorsByParam', array () ) ;
        //\f\pre ( $colors ) ;

        $priceMax = \f\ttt::service ( 'shop.product.getPriceMaxByCatId',
                                      array (
                    'cat_id' => $catId[ 'id' ]
                ) ) ;
        //\f\pre($priceMax);
        $priceMax = max ( $priceMax ) ;
        return $this->render ( 'product',
                               array (
                    'category' => $catId,
                    'brand'    => $brandId,
                    'sortCat'  => $sort_path_cat,
                    'brands'   => $brands,
                    'colors'   => $colors,
                    'priceMax' => implode ( ",", $priceMax )
                ) ) ;
    }

    public function sortByCatId ( $catId, &$sort )
    {
        $sort[ $catId[ 'id' ] ] = $catId ; //save last id
        $parent_id              = $catId[ 'parent_id' ] ;
        do
        {
            $category = \f\ttt::service ( 'shop.category.getCategoryByParam',
                                          array (
                        'selects' => 'id,title,parent_id,title_en',
                        'id'      => $parent_id
                    ) ) ;

            $sort[ $category[ 'id' ] ] = $category ;
            $parent_id                 = $category[ 'parent_id' ] ;
        }
        while ( ! empty ( $parent_id ) ) ;
        //\f\pre($sort);
        return $sort ;
    }

    public function renderCompare ( $param )
    {
        //\f\pre($_COOKIE['width']);
        $count      = count ( $param ) ;
        $strProduct = '' ;
        for ( $i = 0 ; $i < $count ; $i ++ )
        {
            $strProduct  .= $param[ $i ] . '/' ;
            $param[ $i ] = str_replace ( 'RP-', '', $param[ $i ] ) ;
        }
        //\f\pre($param);

        $row = \f\ttt::service ( 'shop.product.getCompareProductDetail',
                                 array (
                    'id' => implode ( ',', $param )
                ) ) ;

        foreach ( $row AS $data )
        {
            $arr[ $data[ 'id' ] ] = $data ;
        }
        for ( $i = 0 ; $i < $count ; $i ++ )
        {
            $sortArr[ $i ] = $arr[ $param[ $i ] ] ;
        }
        //\f\pre($sortArr);
        $catId      = \f\ttt::service ( 'shop.category.getCategoryByParam',
                                        array (
                    'selects' => 'id,title,parent_id,title_en',
                    'id'      => $row[ 0 ][ 'shop_category_id' ]
                ) ) ;
        $categotyId = $catId[ 'id' ] ;
        $brandList  = \f\ttt::service ( 'shop.category.getBrandByCategory',
                                        array (
                    'categotyId' => $categotyId
                ) ) ;



        $wiki = \f\ttt::service ( 'shop.wiki.getWikiByOwnerId' ) ;
        foreach ( $wiki AS $data )
        {
            $wikiArr[ $data[ 'id' ] ] = $data[ 'title' ] ;
        }

        foreach ( $row AS $data )
        {
            $pFeature[ $data[ 'id' ] ] = \f\ttt::service ( 'shop.product.getFeatureByProductId',
                                                           array (
                        'id' => $data[ 'id' ]
                    ) ) ;
        }
        //\f\pre($pFeature);

        foreach ( $pFeature AS $key => $data )
        {
            //\f\pr($data);
            foreach ( $data AS $subData )
            {
                $pfValue[ $key ][ $subData[ 'shop_feature_item_id' ] ] = json_decode ( $subData[ 'value' ],
                                                                                       TRUE ) ;
            }
        }
        //\f\pre($pfValue);
        $features = \f\ttt::service ( 'shop.product.getFeatureByCatId',
                                      array (
                    'id' => $catId[ 'id' ]
                ) ) ;
        //\f\pre($features);
        if ( $features == '' )
        {
            $features = '<div class="alert alert-warning"><i class="fa fa-warning"></i> هیچ مشخصات فنی برای محصول تعریف نشده است.</div>' ;
        }

        $num = $this->getNumByWidth () ;
        //\f\pre($row);
        return $this->render ( 'compare',
                               array (
                    'catId'      => $catId,
                    'brandList'  => $brandList,
                    'feature'    => $features,
                    'wiki'       => $wikiArr,
                    'value'      => $pfValue,
                    'row'        => $sortArr,
                    'count'      => $count,
                    'param'      => $param,
                    'strProduct' => $strProduct,
                    'num'        => $num
                ) ) ;
    }

    public function getNumByWidth ()
    {
        $width = $_COOKIE[ 'width' ] ;
        if ( $width <= 768 )
        {
            return 2 ;
        }
        else if ( $width <= 990 )
        {
            return 3 ;
        }
        else
        {
            return 4 ;
        }
    }

    public function getProductByParam ( $params )
    {
        //\f\pr ( $param ) ;
        if ( $params[ 'mode' ] == 'desktop' )
        {
            $numPerPage = 20 ;
        }
        else
        {
            $numPerPage = 10 ;
        }

        $min               = ($params[ 'page' ] - 1) * $numPerPage ;
        $params[ 'limit' ] = "$min,$numPerPage" ;
        $array             = \f\ttt::service ( 'shop.product.getProductByParams',
                                               $params ) ;
        //\f\pre($array);
        $row               = $array[ 0 ] ;
        $num               = $array[ 1 ] ;

        return $this->render ( 'productFrontList',
                               array (
                    'row'      => $row,
                    'num_page' => $numPerPage,
                    'num'      => $num,
                    'page'     => $params[ 'page' ],
                    'mode'     => $params[ 'mode' ]
                ) ) ;
    }

    public function renderNewProducts ( $params )
    {

        $params[ 'special' ] = "enabled" ;
        $newProducts         = \f\ttt::service ( 'shop.product.getNewProduct',
                                                 $params ) ;
        //\f\pre($newProducts);
        return $this->render ( 'newSpecial',
                               array (
                    'newProducts' => $newProducts
                ) ) ;
    }

    public function renderGetProductBestselling ( $params )
    {
        $bestsellingSetting = \f\ttt::service ( 'shop.shopSetting.getSettings',
                                                array (
                    'params' => array (
                    //'bestselling' => 'bestselling'
                    )
                ) ) ;
        //\f\pre($bestsellingSetting['bestselling']);
        if ( $bestsellingSetting[ 'bestselling' ] == 'automatically' )
        {
            $bestsellingProducts = \f\ttt::service ( 'shop.product.getProductBestselling',
                                                     $params ) ;
        }
        else
        {
            $bestsellingProducts = \f\ttt::service ( 'shop.product.getBestsellingManually',
                                                     $params ) ;
        }

        //\f\pre($bestsellingProducts);
        return $this->render ( 'newSpecial',
                               array (
                    'newProducts' => $bestsellingProducts
                ) ) ;
    }

    public function renderRateForm ( $params )
    {
        $ratingOptions  = \f\ttt::service ( 'shop.ratingOptions.getRatingOptionsById',
                                            array (
                    'id' => $params,
                ) ) ;
        $productComment = \f\ttt::service ( 'shop.comment.getCommentByProductId',
                                            array (
                    'user_id'    => $_SESSION[ 'user_id' ],
                    'product_id' => $params,
                ) ) ;
        $commentStatus  = $productComment[ 0 ][ 'status' ] ;
        //\f\pre($commentStatus);
        foreach ( $productComment[ 1 ] as $data )
        {
            if ( $data[ 'type' ] == 'weakness' )
            {
                $arrTipWeak[ $data[ 'id' ] ] = $data[ 'title' ] ;
            }
            else
            {
                $arrTipStrength[ $data[ 'id' ] ] = $data[ 'title' ] ;
            }
        }
        //\f\pre($arrTipStrength);
        $ratingValue = json_decode ( $ratingOptions[ 'rating_options' ] ) ;
        $ratingTitle = \f\ttt::service ( 'shop.ratingOptions.getRatingTitleById',
                                         array (
                    'ratingValue' => $ratingValue
                ) ) ;
        //\f\pre($ratingTitle);
        $rateOld     = \f\ttt::service ( 'shop.ratingOptions.getRatingOptionsByUserId',
                                         array (
                    'user_id'    => $_SESSION[ 'user_id' ],
                    'product_id' => $params,
                ) ) ;
        if ( $rateOld )
        {
            foreach ( $rateOld AS $data )
            {
                $arrRateOld[ $data[ 'option_id' ] ] = $data[ 'rate' ] ;
            }
        }
        //\f\pre ( $arrRateOld ) ;

        return $this->render ( 'rate',
                               array (
                    'ratingTitle'    => $ratingTitle,
                    'ratingOptions'  => $ratingOptions,
                    'rateOld'        => $arrRateOld,
                    'productComment' => $productComment[ 0 ],
                    'arrTipWeak'     => $arrTipWeak,
                    'arrTipStrength' => $arrTipStrength,
                    'commentStatus'  => $commentStatus,
                ) ) ;
    }

    public function renderAmazingSlide ( $param )
    {

        $this->registerGadgets ( array (
            'dateG' => 'date' ) ) ;
        $todayDate       = $this->dateG->today () ;
        $amazingProducts = \f\ttt::service ( 'shop.product.getAmazingProducts',
                                             array (
                    'today' => $todayDate,
                    'limit' => $param[ 'limit' ] ) ) ;

        return $this->render ( 'amazingProducts',
                               array (
                    'amazingProducts' => $amazingProducts[ '0' ]
                ) ) ;
    }

    public function getNewOneProduct ( $params )
    {

        $params[ 'status' ] = "enabled" ;
        $newOneProduct      = \f\ttt::service ( 'shop.product.getNewOneProduct',
                                                $params ) ;
        //\f\pre($newProducts);
        return $this->render ( 'newMobile',
                               array (
                    'newProducts' => $newOneProduct,
                    'title'       => $params[ 'title' ]
                ) ) ;
    }

    public function getRelatedProduct ( $params )
    {

        $params[ 'status' ] = "enabled" ;
        $newOneProduct      = \f\ttt::service ( 'shop.product.getRelatedProductById',
                                                $params ) ;
        return $this->render ( 'relatedProduct',
                               array (
                    'newProducts' => $newOneProduct,
                ) ) ;
    }

    public function renderGetGuranteesByColorId ( $params )
    {
        $gurantees = \f\ttt::service ( 'shop.product.getGuranteesByColorId',
                                       $params ) ;
        if ( $gurantees != NULL )
        {
            $content  = '' ;
            $selected = "selected='selected'" ;
            foreach ( $gurantees AS $data )
            {
                $content  .= '<option value="' . $data[ "gurantee_id" ] . '" ' . $selected . '>' . $data[ "gurantee_title" ] . '</option>' ;
                $selected = '' ;
            }
            foreach ( $gurantees AS $data )
            {
                $guranteesArr[ $data[ 'gurantee_id' ] ]              = $data[ 'price' ] ;
                $guranteesArr[ 'id' ][ $data[ 'gurantee_id' ] ]      = $data[ 'discount' ] ;
                $guranteesArr[ 'idPrice' ][ $data[ 'gurantee_id' ] ] = $data[ 'id' ] ;
            }
        }
        else
        {
            $guranteesArr = 'NULL' ;
        }
        return array (
            'content'  => $content,
            'gurantee' => $guranteesArr,
                ) ;
    }

    public function renderSendAddToCart ( $params )
    {
        $this->registerGadgets ( array (
            'dateG' => 'date' ) ) ;
        $params[ 'today' ]   = $this->dateG->today () ;
        $params[ 'user_id' ] = $_SESSION[ 'user_id' ] ;
        $result              = \f\ttt::service ( 'shop.order.orderSave', $params ) ;


        if ( ! $result )
        {
            $result = 'NULL' ;
        }
        return array (
            'result' => $result
                ) ;
    }

}
