<?php

class linksourceView extends \f\view
{

    public function renderGrid ()
    {

        return $this->render ( 'linksourceList', array (
                ) ) ;
    }

    public function renderLinkSourceGrid ( $requestDataTble )
    {

        /** Get doctor list * */
        $this->registerGadgets ( array ( 'dateG' => 'date' ) ) ;


        $linksourceList = \f\ttt::service ( 'cms.link.linksource.linksourceList',
                                            array (
                    'dataTableParams' => $requestDataTble ) ) ;
        foreach ( $linksourceList[ 'data' ] as $key => $value )
        {

            $tdContent = $this->createActionButtons ( $value, 'linksource' ) ;


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
                    'formatter' => $value[ 'title' ]
                ),
                array (
                    'htmlOptions' => array (
                        'id'        => 'bgparent',
                    ),
                    'formatter' => $value[ 'link' ]
                ),
                array (
                    'htmlOptions' => array (
                        'id'        => 'bgparent',
                    ),
                    'formatter' => $value[ 'categoryTitle' ]
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
        $row[ 'total' ] = $linksourceList[ 'total' ] ;
        $row[ 'draw' ]  = $linksourceList[ 'draw' ] ;
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
                'href' => \f\ifm::app ()->baseUrl . "cms/link/linksource/" . $section . "Edit/" . $data[ 'id' ]
            ),
            array (
                'type'           => 'status',
                'confirm'        => TRUE,
                'id'             => 's' . $data[ 'id' ],
                'status'         => $data[ 'status' ],
                'action'         => 'cms.link.linksource.' . $section . 'Status',
                'clientCallBack' => 'toggleEnable',
                'params'         => array (
                    'id'     => $data[ 'id' ],
                    'status' => "\"{$data[ 'status' ]}\""
                ),
            ),
            array (
                'type'           => 'delete',
                'confirm'        => true,
                'action'         => 'cms.link.linksource.' . $section . 'Delete',
                'clientCallback' => 'remove',
                'params'         => array (
                    'id'       => $data[ 'id' ],
                    'selector' => "\"#f{$data[ 'id' ]}\""
                )
            ),
                ) ;
        return \f\html::gridButton ( $buttonsParam ) ;
    }

    public function renderLinkSourceAdd ( $id = '' )
    {

        if ( $id )
        {
            $row = \f\ttt::service ( 'cms.link.linksource.getLinkSourceById',
                                     array (
                        'id' => $id ) ) ;
        }

        $category = \f\ttt::service ( 'cms.link.linksource.getCategoryList' ) ;

        foreach ( $category AS $data )
        {
            $catArr[ $data[ 'id' ] ] = $data[ 'title' ] ;
        }

        return $this->render ( 'linksourceAdd',
                               array (
                    'row' => $row,
                    'category' => $catArr,
                ) ) ;
    }

}
