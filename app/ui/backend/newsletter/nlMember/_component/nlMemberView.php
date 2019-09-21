<?php

class nlMemberView extends \f\view
{

    public function rendernlMemberList ()
    {
        return $this->render ( 'nlMemberList', array (
                ) ) ;
    }

    public function rendernlMemberGrid ( $requestDataTble )
    {

        /** Get group list * */
        $this->registerGadgets ( array (
            'dateG' => 'date' ) ) ;

        //$this->dateG->


        $nlMemberList = \f\ttt::service ( 'newsletter.nlMemberList',
                                          array (
                    'dataTableParams' => $requestDataTble ) ) ;

        foreach ( $nlMemberList[ 'data' ] as $key => $value )
        {

            $tdnlMember = $this->createActionButtons ( $value, 'nlMember' ) ;


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
                    'formatter'   => $value[ 'email' ]
                ),

                array (
                    'htmlOptions' => array (
                        'class' => 'act',
                    ),
                    'style'       => array (
                        'border' => 'none'
                    ),
                    'formatter'   => $tdnlMember,
                ),
                    ) ;

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
        $row[ 'total' ] = $nlMemberList[ 'total' ] ;
        $row[ 'draw' ]  = $nlMemberList[ 'draw' ] ;
        /* @var $table \f\w\table */
        $table          = \f\widgetFactory::make ( 'table' ) ;

        $userListRow = $table->renderRow ( $row ) ;
        return $userListRow ;
    }

    private function createActionButtons ( $data, $nlMember )
    {
        $buttonsParam = array (
            array (
                'type' => 'edit',
                'href' => \f\ifm::app ()->baseUrl . "newsletter/nlMember/" . $nlMember . "Edit/" . $data[ 'id' ]
            ),
            array (
                'type'           => 'status',
                'confirm'        => TRUE,
                'id'             => 's' . $data[ 'id' ],
                'status'         => $data[ 'status' ],
                'action'         => 'newsletter.nlMember.' . $nlMember . 'Status',
                'clientCallBack' => 'toggleEnable',
                'params'         => array (
                    'id'     => $data[ 'id' ],
                    'status' => "\"{$data[ 'status' ]}\""
                ),
            ),
            array (
                'type'           => 'delete',
                'confirm'        => true,
                'action'         => 'newsletter.nlMember.' . $nlMember . 'Delete',
                'clientCallback' => 'remove',
                'params'         => array (
                    'id'       => $data[ 'id' ],
                    'selector' => "\"#f{$data[ 'id' ]}\""
                )
            ),
                ) ;
        return \f\html::gridButton ( $buttonsParam ) ;
    }

    public function rendernlMemberAdd ( $id = '' )
    {
        if ( $id )
        {
            $row = \f\ttt::service ( 'newsletter.getNlMemberById',
                                     array (
                        'id' => $id ) ) ;
        }

//        $category = \f\ttt::service ( 'shop.category.getCategoryByOwnerId' ) ;
//        $catMe    = \f\ttt::service ( 'newsletter.getCatNlMemberById',
//                                      array (
//                    'id' => $id ) ) ;
//        //\f\pre ( $catMe ) ;
//        foreach ( $catMe as $data )
//        {
//            $catMeArr[] = $data[ 'category' ] ;
//        }
//        //\f\pre ( $catMeArr ) ;
//        $this->sort_category ( $category, NULL, $sort, '' ) ;
        return $this->render ( 'nlMemberAdd',
                               array (
//                    'category' => $sort,
                    'row'      => $row,
//                    'catMe'    => $catMeArr,
                ) ) ;
    }

//    public function sort_category ( $category, $parentId, &$sort, $strId )
//    {
//        foreach ( $category AS $data )
//        {
//            if ( $data[ 'parent_id' ] == $parentId )
//            {
//                if ( $strId )
//                {
//                    $id = $strId . ',' . $data[ 'id' ] ;
//                }
//                else
//                {
//                    $id = $data[ 'id' ] ;
//                }
//
//                // $sort[ $data[ 'id' ] ][ 'id' ]     = $data[ 'id' ] ;
//                $sort[ $data[ 'id' ] ] = $data[ 'title' ] ;
//                //$sort[ $data[ 'id' ] ][ 'parent' ] = $id ;
//                $this->sort_category ( $category, $data[ 'id' ], $sort, $id ) ;
//            }
//        }
//        return $sort ;
//    }

}
