<?php

class menuView extends \f\view
{

    public function renderGrid ()
    {

        return $this->render ( 'menusectionList', array (
                ) ) ;
    }

    public function renderMenuSectionAdd ( $id = '' )
    {

        if ( $id )
        {
            $row = \f\ttt::service ( 'cms.menu.getMenuSectionById',
                                     array (
                        'id' => $id ) ) ;
        }

        return $this->render ( 'menusectionAdd',
                               array (
                    'row' => $row,
                ) ) ;
    }

    public function renderMenuSectionGrid ( $requestDataTble )
    {

        /** Get group list * */
        $this->registerGadgets ( array ( 'dateG' => 'date' ) ) ;


        $menusectionList = \f\ttt::service ( 'cms.menu.menusectionList',
                                             array (
                    'dataTableParams' => $requestDataTble ) ) ;

        foreach ( $menusectionList[ 'data' ] as $key => $value )
        {

            $tdContent = $this->createActionButtons ( $value, 'menusection' ) ;
            $field     = array (
                array (
                    'style' => array (
                        'border'    => 'none',
                    ),
                    'formatter' => "<div class='simple-checkbox'><input id='f" . $value[ 'id' ] . "' type='checkbox' class='checkBox'/><label for='f" . $value[ 'id' ] . "'></label></div>"
                ),
                array (
                    'htmlOptions' => array (
                        'id'    => 'bgparent',
                    ),
                    'style' => array (
                        'border'    => 'none',
                        'color'     => 'red !important'
                    ),
                    'formatter' => $value[ 'title' ]
                ),
                array (
                    'htmlOptions' => array (
                        'id'    => 'bgparent',
                    ),
                    'style' => array (
                        'border'    => 'none',
                        'color'     => 'red !important'
                    ),
                    'formatter' => $value[ 'name' ]
                ),
                array (
                    'htmlOptions' => array (
                        'class' => 'act',
                    ),
                    'style' => array (
                        'border'    => 'none'
                    ), //onclick='widgetHelper.remove(\"" . $value[ 'id' ] . "\",\"c\",\"core.user.remove\" )'
                    'formatter' => $tdContent,
                ),
                    ) ;
            // tr make
            // data-on-confirm='hi'
            $row[ ]     = array (
                'htmlOptions' => array (
                    'id'    => '',
                    'class' => 'c' . $value[ 'id' ],
                ),
                'style' => array (
                    'background'    => 'red !important'
                ),
                'td'            => $field
                    ) ;
        }
        $row[ 'total' ] = $menusectionList[ 'total' ] ;
        $row[ 'draw' ]  = $menusectionList[ 'draw' ] ;
        /* @var $table \f\w\table */
        $table          = \f\widgetFactory::make ( 'table' ) ;

        $userListRow = $table->renderRow ( $row ) ;
        return $userListRow ;
    }

    private function createActionButtons ( $data, $section )
    {
        if ( $section == 'menusection' )
        {
            $typecharticone = array (
                'type' => 'custom',
                'href' => \f\ifm::app ()->baseUrl . "cms/menu/menutitle/" . $data[ 'id' ],
                'icon' => 'fa fa-plus'
                    ) ;
        }
        else
        {
            $typecharticone = '' ;
        }
        $buttonsParam   = array (
            array (
                'type' => 'edit',
                'href' => \f\ifm::app ()->baseUrl . "cms/menu/" . $section . "Edit/" . $data[ 'id' ]
            ),
            array (
                'type'           => 'status',
                'confirm'        => TRUE,
                'id'             => 's' . $data[ 'id' ],
                'status'         => $data[ 'status' ],
                'action'         => 'cms.menu.' . $section . 'Status',
                'clientCallBack' => 'toggleEnable',
                'params'         => array (
                    'id'     => $data[ 'id' ],
                    'status' => "\"{$data[ 'status' ]}\""
                ),
            ),
            array (
                'type'           => 'delete',
                'confirm'        => true,
                'action'         => 'cms.menu.' . $section . 'Delete',
                'clientCallback' => 'remove',
                'params'         => array (
                    'id'       => $data[ 'id' ],
                    'selector' => "\"#f{$data[ 'id' ]}\""
                )
            ),
            $typecharticone,
                ) ;
        return \f\html::gridButton ( $buttonsParam ) ;
    }

    public function renderMenuTitleGrid ( $id = '' )
    {
        $menu = \f\ttt::service ( 'cms.menu.renderMenuBackend',
                                  array (
                    'id'       => $id
                ) ) ;

        $sort_menu = "
            <table class='display' cellspacing='0' width='100%' id='menuTable'>
            <input type='hidden' value=" . $id . " />
            <thead>
                <tr style='background:#EEEEEE'>
                  <th style='width:25%'>" . \f\ifm::t ( 'title_menu' ) . "</th>
                  <th style='width:25%'>" . \f\ifm::t ( 'parentTitle' ) . "</th>
                  <th style='width:35%'>" . \f\ifm::t ( 'Link_menu' ) . "</th>
                  <th style='width:5%'>" . \f\ifm::t ( 'priority' ) . "</th>
                  <th style='width:10%'>" . \f\ifm::t ( '' ) . "</th>
                </tr>
                </thead>
                <tbody>
        " ;
         $this->sort_menu ( $menu, 0, \f\ifm::t ( 'main' ), 5, '000', $sort_menu ) ;

        $sort_menu.="</tbody></table>" ;
        return $this->render ( 'menuList',
                               array (
                    'row'        => $sort_menu,
                    'section_id' => $id
                ) ) ;
    }


    public function sort_menu ( $menu, $parentId, $parentTitle, $padding,
                                $color, &$sort )
    {
        foreach ( $menu AS $data )
        {
            if ( $data[ 'parent_id' ] == $parentId )
            {
                $link=$data['link']?$data['link']:\f\ifm::app ()->siteUrl.'menuDetail/'.$data['id'];
                $sort.="
                    <tr id='f" . $data[ 'id' ] . "'>
                        <td style='padding-right:" . $padding . "px;color:#" . $color . "'>" . $data[ 'title' ] . "</td> 
                        <td>" . $parentTitle . "</td> 
                        <td><a href='".$link."' target='_blank' style='font:11px Tahoma'>".$link."</a></td>      
                        <td class='priup'>
                        <a class='priorityup'  href='javascript:void(0)'><i class='fa fa-arrow-up' style='color:green;'></i><input class='priority' type='hidden' value='" . $data[ 'priority' ] . "' /></a>
                                              
                        <a class='prioritydown' href='javascript:void(0)'><i class='fa fa-arrow-down' style='color:red;'></i><input class='priority' type='hidden' value='" . $data[ 'priority' ] . "' /></a>
                        </td>
                " ;
                $tdContent = $this->createActionButtons ( $data, 'menu' ) ;
                $sort.="
                        <td>" . $tdContent . "</td>
                     </tr>
                " ;
                //$color+=444;

                $this->sort_menu ( $menu, $data[ 'id' ], $data[ 'title' ],
                                   $padding + 30, $color + 444, $sort ) ;
            }
        }
        return $sort ;
    }


    public function sort_menu_option ( $menu, $parentId, &$sort, $row )
    {
        foreach ( $menu AS $data )
        {
            if ( $data[ 'parent_id' ] == $parentId )
            {

                if ( $row[ 'parentTitle' ] == $data[ 'id' ] )
                {
                    $sort.="
                        <option value=" . $data[ 'id' ] . " selected>" . $data[ 'title' ] . "</option>
                    " ;
                }
                else
                {
                    $sort.="
                        <option value=" . $data[ 'id' ] . ">" . $data[ 'title' ] . "</option>
                    " ;
                }
                $this->sort_menu_option ( $menu, $data[ 'id' ], $sort, $row ) ;
            }
        }
        return $sort ;
    }

    
    public function renderMenuAdd ( $id = '' )
    {
        $menu = \f\ttt::service ( 'cms.menu.renderMenuBackend',
                                  array (
                                      'id'       => $id
                ) ) ;
        $sort_menu = "
            <div class='col-sm-10'>
            <label class='col-sm-3 control-label' for='parent_id'>" . \f\ifm::t ( 'titleState' ) . "</label>
                <div class='col-sm-9'>
             <select id='parent_id' name='parent_id'>
             <option value='0'>منوی اصلی</option>

        " ;
                $this->sort_menu_option ( $menu, 0, $sort_menu, $row ) ;
        $sort_menu.="</select></div><div class='clear'></div></div> " ;
        
        return $this->render ( 'menuAdd',
                               array (
                    'section_id' => $id,
                    'state'      => $sort_menu
                ) ) ;
    }

    public function renderMenuEdit ( $id = '' )
    {

            $row = \f\ttt::service ( 'cms.menu.getMenuById',
                                     array (
                        'id' => $id ) ) ;

        $menu = \f\ttt::service ( 'cms.menu.renderMenuBackend',
                                  array (
                                      'id'       => $row['section_id']
                ) ) ;
        $sort_menu = "
            <div class='col-sm-10'>
            <label class='col-sm-3 control-label' for='parent_id'>" . \f\ifm::t ( 'titleState' ) . "</label>
                <div class='col-sm-9'>
             <select id='parent_id' name='parent_id'>
             <option value='0'>منوی اصلی</option>

        " ;
                        $this->sort_menu_option ( $menu, 0, $sort_menu, $row ) ;
        $sort_menu.="</select></div><div class='clear'></div></div> " ;
        return $this->render ( 'menuAdd',
                               array (
                    'row'   => $row,
                    'section_id' => $row['section_id'],
                    'state'      => $sort_menu
                ) ) ;
    }
    
}
