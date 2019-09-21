<?php

class reportsView extends \f\view
{

    function renderReports ()
    {


        $brand    = \f\ttt::service ( 'shop.brand.getBrandByOwnerId' ) ;
        $category = \f\ttt::service ( 'shop.category.getCategoryByOwnerId' ) ;
        //\f\pre ( $category ) ;
        $this->sort_category ( $category, NULL, $sort, '' ) ;
        foreach ( $brand AS $data )
        {
            $brandArr[ $data[ 'id' ] ] = $data[ 'title_fa' ] ;
        }
        $buyerList = \f\ttt::service ( 'shop.order.getListBuyers' ) ;
        foreach ( $buyerList AS $value )
        {
            $buyerListArr[$value['id']] = $value['name'];
        }
        //\f\pre ( $buyerListArr ) ;
        return $this->render ( 'reports',
                               array (
                    'brand'    => $brandArr,
                    'category' => $sort,
                    'buyerListArr' => $buyerListArr,
                ) ) ;
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

}
