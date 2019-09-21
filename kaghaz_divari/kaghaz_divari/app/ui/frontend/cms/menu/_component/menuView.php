<?php

class menuView extends \f\view
{

    public function renderMenuFrontend ($params)
    {
        $menu = \f\ttt::service ( 'cms.menu.renderMenuFrontend',

            array (

                'name'     => $params[ 'name' ]

            ) ) ;
        $sort_menu = array ( ) ;
        $sort = $this->sort_menu ( $menu, 0, $sort_menu ) ;
        return $this->render ( $params[ 'name' ],
            array (

                'row' => $sort_menu,
            ) ) ;
    }
    public function renderMenuFrontendOld ($params)
    {
        $menu = \f\ttt::service ( 'cms.menu.renderMenuFrontend',

            array (

                'name'     => $params[ 'name' ]

            ) ) ;
        $sort_menu = array ( ) ;

        $sort = $this->sort_menu ( $menu, 0, $sort_menu ) ;
        return $this->render ( $params[ 'name' ],
            array (

                'row' => $sort_menu,
            ) ) ;
    }


    public function sort_menu ( $menu, $parentId, &$sort )
    {
        foreach ( $menu AS $data )
        {
            if ( $data[ 'parent_id' ] == $parentId )
            {
                $sort[ $data[ 'id' ] ][ 'data' ] = $data ;
                $this->sort_menu ( $menu, $data[ 'id' ],
                                   $sort[ $data[ 'id' ] ][ 'child' ] ) ;
            }
        }
        return $sort ;
    }

    public function renderTopFooterMenu ( $params )
    {
        $menu      = \f\ttt::service ( 'cms.menu.renderTopFooterMenu',
                                       array (
                    'name' => $params[ 'name' ]
                ) ) ;
        $sort_menu = array () ;
        $this->sort_menu ( $menu, 0, $sort_menu ) ;
        return $this->render ( $params[ 'name' ],
                               array (
                    'row' => $sort_menu,
                ) ) ;
    }
    public function renderBottomFooterMenu ( $params )
    {
        $menu      = \f\ttt::service ( 'cms.menu.renderBottomFooterMenu',
                                       array (
                    'name' => $params[ 'name' ]
                ) ) ;
        $sort_menu = array () ;
        $this->sort_menu ( $menu, 0, $sort_menu ) ;
        return $this->render ( $params[ 'name' ],
                               array (
                    'row' => $sort_menu,
                ) ) ;
    }
    public function renderGetMenuDetail ( $params )
    {
        $id  = $params[ 0 ] ;
        $row = \f\ttt::service ( 'cms.menu.getMenuById',
                                 array (
                    'id' => $id
                ) ) ;
        $content = $this->render ( 'detailMenu',
                                   array (
            'row' => $row,
                ) ) ;
        return array (
            $content,
            $row ) ;
    }

}

?>