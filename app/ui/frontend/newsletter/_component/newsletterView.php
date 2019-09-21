<?php

class newsletterView extends \f\view
{

    public function __construct ()
    {
        
    }

    public function getNewsLetterBlock ()
    {
        $category = \f\ttt::service ( 'cms.product.category.getCategoryByOwnerId' ) ;
        $this->sort_category ( $category, NULL, $sort, '' ) ;
        return $this->render ( 'newsLetterBlock',
                               array (
                    'category' => $sort,//change $sort
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
