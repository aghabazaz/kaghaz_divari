<?php

class shopView extends \f\view
{

    public function __construct ()
    {
        
    }

    public function renderGetProduct ( $params )
    {
        $params[ 'status' ] = 'enabled' ;

        $row = \f\ttt::service ( 'shop.product.getProductByParam', $params ) ;
        return $this->render ( 'specialProduct',
                               array (
                    'row'    => $row,
                    'params' => $params
                        )
                ) ;
    }

    public function renderGetSearchForm ( $param )
    {
        //\f\pr ( $param ) ;
        $category = \f\ttt::service ( 'shop.category.getCategoryByOwnerId' ) ;
        $this->sort_category ( $category, NULL, $sort, '' ) ;

        $country = \f\ttt::service ( 'cms.place.country.getCountryList',
                                     array (
                    'status' => 'enabled'
                ) ) ;

        $baseInfo = $this->parse_array ( \f\ttt::service ( 'shop.baseInfo.getBaseInfoByOwner' ) ) ;



        return $this->render ( 'search',
                               array (
                    'category' => $sort,
                    'country'  => $country,
                    'baseInfo' => $baseInfo,
                    'param'    => $param,
                        )
                ) ;
    }

    public function parse_array ( $array )
    {
        foreach ( $array AS $data )
        {
            $parse_array[ $data[ 'group_id' ] ][ 'title' ][ $data[ 'id' ] ] = $data[ 'title' ] ;
        }

        return $parse_array ;
    }

    public function sort_category ( $category, $parentId, &$sort, $strId )
    {
        foreach ( $category AS $data )
        {
            if ( $data[ 'parent_id' ] == $parentId )
            {
                if ( $strId )
                {
                    $id = $strId . ',' . $data[ 'id' ] ;
                }
                else
                {
                    $id = $data[ 'id' ] ;
                }

                $sort[ $data[ 'id' ] ][ 'id' ]     = $data[ 'id' ] ;
                $sort[ $data[ 'id' ] ][ 'title' ]  = $data[ 'title' ] ;
                $sort[ $data[ 'id' ] ][ 'parent' ] = $id ;
                $this->sort_category ( $category, $data[ 'id' ], $sort, $id ) ;
            }
        }
        return $sort ;
    }

    public function renderGetSpecialAdvert ( $params )
    {
        $params[ 'special' ] = 'enabled' ;
        $params[ 'status' ]  = 'enabled' ;
        $row                 = \f\ttt::service ( 'shop.advert.items.getItemsByParam',
                                                 $params ) ;
        //\f\pr('okk');
        return $this->render ( 'specialAdvert',
                               array (
                    'row' => $row
                        )
                ) ;
    }

    public function renderGetSearchResult ( $params )
    {
        $params[ 'status' ] = 'enabled' ;
        //\f\pr($params);
        $row                = \f\ttt::service ( 'shop.product.getProductSearch',
                                                $params ) ;
        //\f\pr($row);
        return $this->render ( 'searchProduct',
                               array (
                    'row'    => $row,
                    'params' => $params
                        )
                ) ;
    }

    public function renderGetBrandList ( $param )
    {
        $shopSetting = \f\ttt::service ( 'shop.shopSetting.getSettings' ) ;
        $giftPhoto   = $shopSetting[ 'picture' ] ;
        $row         = \f\ttt::service ( 'shop.brand.getBrandListFront',  array (
            'status' => 'enabled'
        ), true) ;
        //\f\pre($row);
        return $this->render ( 'brandList',
                               array (
                    'row'       => $row,
                    'giftPhoto' => $giftPhoto,
                ) ) ;
    }

    public function renderGetSidebarFilter ( $params )
    {

        //$this->sort_category ( $category, NULL, $sort, '' ) ;

        $country = \f\ttt::service ( 'cms.place.country.getCountryList',
                                     array (
                    'status' => 'enabled'
                ) ) ;

        $catId = $params[ 'catId' ] ;

        if ( ! $catId )
        {
            $category = \f\ttt::service ( 'shop.category.getCategoryByOwnerId' ) ;
            foreach ( $category AS $data )
            {
                $catArr[ $data[ 'id' ] ] = $data[ 'title' ] ;
            }
        }


        $baseInfo = $this->parse_array ( \f\ttt::service ( 'shop.baseInfo.getBaseInfoByOwner' ) ) ;



        return $this->render ( 'sidebar',
                               array (
                    'category' => $catArr,
                    'country'  => $country,
                    'baseInfo' => $baseInfo,
                    'catId'    => $catId
                        )
                ) ;
    }

}
