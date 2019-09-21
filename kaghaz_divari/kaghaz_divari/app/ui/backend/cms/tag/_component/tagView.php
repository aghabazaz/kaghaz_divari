<?php

class tagView extends \f\view
{

    public function renderGrid()
    {
        
         return $this->render ( 'tagList', array (
                ) ) ;
    }
    public function renderTagAdd ( $id = '' )
    {
       
        if ( $id )
        {
            $row = \f\ttt::service ( 'cms.tag.getTagById',
                                     array (
                        'id' => $id ) ) ;
        }

        return $this->render ( 'tagAdd',
                               array (
                    'row' => $row
                ) ) ;
    }
    
    public function renderTagGrid ( $requestDataTble )
    {

        /** Get group list * */
        $this->registerGadgets(array('dateG'=>'date'));
       
        
        $tagList = \f\ttt::service ( 'cms.tag.tagList',
                                       array (
                    'dataTableParams' => $requestDataTble ) ) ;

        foreach ( $tagList[ 'data' ] as $key => $value )
        {

            $tdContent = $this->createActionButtons ( $value, 'tag' ) ;


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
                        'class' => 'tdsearch',
                    ),
                    'style' => array (
                        'border'    => 'none'
                    ),
                    'formatter' =>  $this->dateG->dateTime($value[ 'date_register' ],2)
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
        $row[ 'total' ] = $tagList[ 'total' ] ;
        $row[ 'draw' ]  = $tagList[ 'draw' ] ;
        /* @var $table \f\w\table */
        $table          = \f\widgetFactory::make ( 'table' ) ;

        $userListRow = $table->renderRow ( $row ) ;
        return $userListRow ;
    }

    private function createActionButtons ( $data, $section )
    {
        $buttonsParam = array (
//            array (
//                'type' => 'list',
//                'href'=>'#'
//                //'href' => \f\ifm::app ()->baseUrl . "crm/inventory/product/" . $section . "Detail/" . $data[ 'id' ]
//            ),
            array (
                'type' => 'edit',
                'href' => \f\ifm::app ()->baseUrl . "cms/tag/" . $section . "Edit/" . $data[ 'id' ]
            ),
            array (
                'type'           => 'status',
                'confirm'        => TRUE,
                'id'             => 's' . $data[ 'id' ],
                'status'         => $data[ 'status' ],
                'action'         => 'cms.tag.' . $section . 'Status',
                'clientCallBack' => 'toggleEnable',
                'params'         => array (
                    'id'     => $data[ 'id' ],
                    'status' => "\"{$data[ 'status' ]}\""
                ),
            ),
            array (
                'type'           => 'delete',
                'confirm'        => true,
                'action'         => 'cms.tag.' . $section . 'Delete',
                'clientCallback' => 'remove',
                'params'         => array (
                    'id'       => $data[ 'id' ],
                    'selector' => "\"#f{$data[ 'id' ]}\""
                )
            ),
                ) ;
        return \f\html::gridButton ( $buttonsParam ) ;
    }


}
