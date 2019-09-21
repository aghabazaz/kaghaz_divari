<?php

class contentView extends \f\view
{

    public function renderContentList ()
    {
        return $this->render ( 'contentList', array (
                ) ) ;
    }

    public function renderContentGrid ( $requestDataTble )
    {

        /** Get group list * */
        $this->registerGadgets ( array ( 'dateG' => 'date' ) ) ;

        //$this->dateG->


        $contentList = \f\ttt::service ( 'cms.content.contentList',
                                         array (
                    'dataTableParams' => $requestDataTble ) ) ;

        foreach ( $contentList[ 'data' ] as $key => $value )
        {

            $tdContent = $this->createActionButtons ( $value, 'content' ) ;


            $field = array (
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
                    'formatter' => '<div style="text-align:right">' . $value[ 'title' ] . '</div>'
                ),
                array (
                    'htmlOptions' => array (
                        'id'    => 'bgparent',
                    ),
                    'style' => array (
                        'border'    => 'none',
                        'color'     => 'red !important'
                    ),
                    'formatter' => $value[ 'visit' ]
                ),
                array (
                    'htmlOptions' => array (
                        'class' => 'tdsearch',
                    ),
                    'style' => array (
                        'border'    => 'none'
                    ),
                    'formatter' => $this->dateG->dateTime ( $value[ 'date_register' ],
                                                            2 ) . ' ساعت : ' . date ( 'H:i',
                                                                                      $value[ 'date_register' ] )
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
        $row[ 'total' ] = $contentList[ 'total' ] ;
        $row[ 'draw' ]  = $contentList[ 'draw' ] ;
        /* @var $table \f\w\table */
        $table          = \f\widgetFactory::make ( 'table' ) ;

        $userListRow = $table->renderRow ( $row ) ;
        return $userListRow ;
    }

    private function createActionButtons ( $data, $content )
    {
        $buttonsParam = array (
//            array (
//                'type' => 'list',
//                'href'=>'#'
//                //'href' => \f\ifm::app ()->baseUrl . "crm/inventory/product/" . $content . "Detail/" . $data[ 'id' ]
//            ),
            array (
                'type' => 'edit',
                'href' => \f\ifm::app ()->baseUrl . "cms/content/" . $content . "Edit/" . $data[ 'id' ]
            ),
            array (
                'type'           => 'status',
                'confirm'        => TRUE,
                'id'             => 's' . $data[ 'id' ],
                'status'         => $data[ 'status' ],
                'action'         => 'cms.content.' . $content . 'Status',
                'clientCallBack' => 'toggleEnable',
                'params'         => array (
                    'id'     => $data[ 'id' ],
                    'status' => "\"{$data[ 'status' ]}\""
                ),
            ),
            array (
                'type'           => 'delete',
                'confirm'        => true,
                'action'         => 'cms.content.' . $content . 'Delete',
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
                'action'         => 'cms.content.' . $content . 'Special',
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
                    'component_id' => 'paperItems',
                    'item_id'      => $data[ 'id' ]
                )
            )
        )
    )
                ) ;
        return \f\html::gridButton ( $buttonsParam ) ;
    }

    public function renderContentAdd ( $id = '' )
    {
        if ( $id )
        {
            $row = \f\ttt::service ( 'cms.content.getContentById',
                                     array (
                        'id' => $id ) ) ;

            
        }

        $section = \f\ttt::service ( 'cms.section.getSectionByOwnerId' ) ;
        foreach ( $section AS $data )
        {
            if ( $data[ 'type' ] == 'state' )
            {
                $state[ $data[ 'id' ] ] = $data[ 'title' ] ;
            }
            else
            {
                $category[ $data[ 'id' ] ] = $data[ 'title' ] ;
            }
        }
        $tag                   = \f\ttt::service ( 'cms.tag.getTagByOwnerId' ) ;
        foreach ( $tag AS $data )
        {
            $tagArr[ $data[ 'id' ] ] = $data[ 'title' ] ;
        }
        $related = \f\ttt::service ( 'cms.content.getContentRelatedByOwnerId' ) ;
        foreach ( $related AS $data )
        {
            $relatedArr[ $data[ 'id' ] ] = $data[ 'title' ] ;
        }



        //\f\pr($section);

        return $this->render ( 'contentAdd',
                               array (
                    'row'      => $row,
                    'category' => $category,
                    'state'    => $state,
                    'tag'      => $tagArr,
                  
                    'related'  => $relatedArr,
                ) ) ;
    }

    public function renderElectorate ()
    {

        $row = \f\ttt::service ( 'cms.content.getElectorate' ) ;
        //\f\pre($row);
        return $this->render ( 'electorate',
                               array (
                    'row' => $row,
                ) ) ;
    }

}
