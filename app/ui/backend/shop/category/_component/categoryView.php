<?php

class categoryView extends \f\view
{

    public function renderGrid ()
    {

        return $this->render ( 'categoryList', array (
                ) ) ;
    }

    public function renderCatGrid ()
    {
        $menu      = \f\ttt::service ( 'shop.category.getCategoryByOwnerId' ) ;
        $sort_menu = "
            <table class='display' cellspacing='0' width='100%' id='categoryTable'> 
            <thead>
                <tr style='background:#EEEEEE'>
                 <th style='width:3%'></th>
                  <th style='width:43%'>" . \f\ifm::t ( 'title' ) . "</th>
                  <th style='width:22%'>" . \f\ifm::t ( 'title_en' ) . "</th>
                  <th style='width:15%'>" . \f\ifm::t ( 'parent' ) . "</th>
                  <th style='width:16%'>" . \f\ifm::t ( '' ) . "</th>
                </tr>
                </thead>
                <tbody>
        " ;

        $this->sort_menu ( $menu, 0, \f\ifm::t ( 'mainCategory' ), 0, '000',
                                                 $sort_menu ) ;

        $sort_menu .= "</tbody></table>" ;

        return $this->render ( 'categoryList_1',
                               array (
                    'row' => $sort_menu
                ) ) ;
    }

    public function sort_menu ( $menu, $parentId, $parentTitle, $padding,
                                $color, &$sort )
    {
        foreach ( $menu AS $data )
        {
            if ( $data[ 'parent_id' ] == $parentId )
            {
                $sort      .= "
                    <tr id='f" . $data[ 'id' ] . "'>
                        <td><div class='simple-checkbox'><input id='ff" . $data[ 'id' ] . "' type='checkbox' class='checkBox'/><label for='ff" . $data[ 'id' ] . "'></label></div></td>
                        <td style='padding-right:" . $padding . "px;color:#" . $color . "'>" . $data[ 'title' ] . "</td> 
                        <td>" . $data[ 'title_en' ] . "</td>                         
                        <td>" . $parentTitle . "</td> 
                             
                " ;
                $tdContent = $this->createActionButtons ( $data, 'category' ) ;
                $sort      .= "
                        <td>" . $tdContent . "</td>
                     </tr>
                " ;
                //$color+=444;

                $this->sort_menu ( $menu, $data[ 'id' ], $data[ 'title' ],
                                   $padding + 20, $color + 444, $sort ) ;
            }
        }
        return $sort ;
    }

    public function renderCategoryAdd ( $id = '' )
    {

        if ( $id )
        {
            $row = \f\ttt::service ( 'shop.category.getCategoryById',
                                     array (
                        'id' => $id ) ) ;

            $parameter = \f\ttt::service ( 'shop.category.getFeatureByCatId',
                                           array (
                        'id' => $id
                    ) ) ;
        }
        $ratingOptions = \f\ttt::service ( 'shop.category.getRatingOptions' ) ;
        foreach ( $ratingOptions AS $data )
        {
            $ratingArr[ $data[ 'id' ] ] = $data[ 'title' ] ;
        }
        $category     = \f\ttt::service ( 'shop.category.getCategoryByOwnerId' ) ;
        $sort[ NULL ] = \f\ifm::t ( 'mainCategory' ) ;
        $this->sort_category ( $category, NULL, $sort ) ;

        $feature = \f\ttt::service ( 'shop.feature.getFeatureByOwnerId' ) ;

        $fArr[NULL] = '-- انتخاب کنید --' ;
        foreach ( $feature AS $data )
        {
            $fArr[ $data[ 'id' ] ] = $data[ 'title_long' ] ;
        }
        //\f\pre($row);
        return $this->render ( 'categoryAdd',
                               array (
                    'row'       => $row,
                    'sort'      => $sort,
                    'feature'   => $fArr,
                    'parameter' => $parameter,
                    'rating'    => $ratingArr
                ) ) ;
    }

    public function sort_category ( $category, $parentId, &$sort )
    {
        foreach ( $category AS $data )
        {
            if ( $data[ 'parent_id' ] == $parentId )
            {
                $sort[ $data[ 'id' ] ] = $data[ 'title' ] ;
                $this->sort_category ( $category, $data[ 'id' ], $sort ) ;
            }
        }
        return $sort ;
    }

    public function renderCategoryGrid ( $requestDataTble )
    {

        /** Get group list * */
        $this->registerGadgets ( array (
            'dateG' => 'date' ) ) ;


        $categoryList = \f\ttt::service ( 'shop.category.categoryList',
                                          array (
                    'dataTableParams' => $requestDataTble ) ) ;
        foreach ( $categoryList[ 'data' ] as $key => $value )
        {

            $tdContent = $this->createActionButtons ( $value, 'category' ) ;

            $field = array (
                array (
                    'style'     => array (
                        'border' => 'none',
                    ),
                    'formatter' => "<div class='simple-checkbox'><input id='f" . $value[ 'id' ] . "' type='checkbox' class='checkBox'/><label for='f" . $value[ 'id' ] . "'></label></div>"
                ),
                array (
                    'htmlOptions' => array (
                        'id' => 'bgparent',
                    ),
                    'style'       => array (
                        'border' => 'none',
                        'color'  => 'red !important'
                    ),
                    'formatter'   => $value[ 'title' ]
                ),
                array (
                    'htmlOptions' => array (
                        'class' => 'act',
                    ),
                    'style'       => array (
                        'border' => 'none'
                    ), //onclick='widgetHelper.remove(\"" . $value[ 'id' ] . "\",\"c\",\"core.user.remove\" )'
                    'formatter'   => $tdContent,
                ),

                    ) ;
            // tr make
            // data-on-confirm='hi'
            $row[] = array (
                'htmlOptions' => array (
                    'id'    => '',
                    'class' => 'c' . $value[ 'id' ],
                ),
                'style'       => array (
                    'background' => 'red !important'
                ),
                'td'          => $field
                    ) ;
        }
        $row[ 'total' ] = $categoryList[ 'total' ] ;
        $row[ 'draw' ]  = $categoryList[ 'draw' ] ;
        /* @var $table \f\w\table */
        $table          = \f\widgetFactory::make ( 'table' ) ;

        $userListRow = $table->renderRow ( $row ) ;
        return $userListRow ;
    }

    private function createActionButtons ( $data, $section )
    {
        $buttonsParam = array (
            array (
                'type' => 'edit',
                'href' => \f\ifm::app ()->baseUrl . "shop/category/" . $section . "Edit/" . $data[ 'id' ]
            ),
            array (
                'type'           => 'status',
                'confirm'        => TRUE,
                'id'             => 's' . $data[ 'id' ],
                'status'         => $data[ 'status' ],
                'action'         => 'shop.category.' . $section . 'Status',
                'clientCallBack' => 'toggleEnable',
                'params'         => array (
                    'id'     => $data[ 'id' ],
                    'status' => "\"{$data[ 'status' ]}\""
                ),
            ),
            array (
                'type'           => 'delete',
                'confirm'        => true,
                'action'         => 'shop.category.' . $section . 'Delete',
                'clientCallback' => 'remove',
                'params'         => array (
                    'id'       => $data[ 'id' ],
                    'selector' => "\"#f{$data[ 'id' ]}\""
                )
            ),
            array (
                'type'           => 'special',
                'confirm'        => TRUE,
                'id'             => 'sp' . $data[ 'id' ],
                'status'         => $data[ 'special' ],
                'action'         => 'shop.category.' . $section . 'Special',
                'clientCallBack' => 'toggleEnable',
                'params'         => array (
                    'id'     => $data[ 'id' ],
                    'status' => "\"{$data[ 'special' ]}\""
                )
            ),
            array (
                'type'         => 'custom',
                'title'        => 'سئو و بهینه سازی سایت',
                'icon'         => 'fa fa-paw fa-lg',
                'id'           => "ps_" . $data[ 'id' ],
                'clientAction' => array (
                    'display' => 'dialog',
                    'params'  => array (
                        'targetRoute'    => "core.seo.editParameterDialog",
                        'triggerElement' => "ps_" . $data[ 'id' ],
                        'dialogTitle'    => 'سئو و بهینه سازی سایت',
                        'ajaxParams'     => array (
                            'component_id' => 'categoryItems',
                            'item_id'      => $data[ 'id' ]
                        )
                    )
                )
            )
                ) ;
        return \f\html::gridButton ( $buttonsParam ) ;
    }

}
