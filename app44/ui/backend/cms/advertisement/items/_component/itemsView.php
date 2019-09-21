<?php

class itemsView extends \f\view
{

    public function renderGrid()
    {
        return $this->render ( 'itemsList', array (
                ) ) ;
    }
    public function renderItemsGrid ( $requestDataTble )
    {
        
        /** Get group list * */
        $this->registerGadgets(array('dateG'=>'date'));
       
        
        $requestList = \f\ttt::service ( 'cms.advertisement.advertisementList',
                                       array (
                    'dataTableParams' => $requestDataTble ) ) ;
        
        //\f\pr('pppp');

        foreach ( $requestList[ 'data' ] as $key => $value )
        {

            $tdContent = $this->createActionButtons ( $value, 'items' ) ;


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
                    'formatter' => $value[ 'name' ]
                ),
                 array (
                    'htmlOptions' => array (
                        'id'    => 'bgparent',
                    ),
                    'style' => array (
                        'border'    => 'none',
                        'color'     => 'red !important'
                    ),
                    'formatter' => $value[ 'email' ]
                ),
                 array (
                    'htmlOptions' => array (
                        'id'    => 'bgparent',
                    ),
                    'style' => array (
                        'border'    => 'none',
                        'color'     => 'red !important'
                    ),
                    'formatter' => $value[ 'phone' ]
                ),
                 array (
                    'htmlOptions' => array (
                        'id'    => 'bgparent',
                    ),
                    'style' => array (
                        'border'    => 'none',
                        'color'     => 'red !important'
                    ),
                    'formatter' => $value[ 'plan' ]
                ),
                array (
                    'htmlOptions' => array (
                        'class' => 'tdsearch',
                    ),
                    'style' => array (
                        'border'    => 'none'
                    ),
                    'formatter' =>  $value[ 'date_credit' ]
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
        $row[ 'total' ] = $requestList[ 'total' ] ;
        $row[ 'draw' ]  = $requestList[ 'draw' ] ;
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
                'href' => \f\ifm::app ()->baseUrl . "cms/advertisement/items/" . $section . "Edit/" . $data[ 'id' ]
            ),
            array (
                'type'           => 'status',
                'confirm'        => TRUE,
                'id'             => 's' . $data[ 'id' ],
                'status'         => $data[ 'status' ],
                'action'         => 'cms.advertisement.items.' . $section . 'Status',
                'clientCallBack' => 'toggleEnable',
                'params'         => array (
                    'id'     => $data[ 'id' ],
                    'status' => "\"{$data[ 'status' ]}\""
                ),
            ),
            array (
                'type'           => 'delete',
                'confirm'        => true,
                'action'         => 'cms.advertisement.items.' . $section . 'Delete',
                'clientCallback' => 'remove',
                'params'         => array (
                    'id'       => $data[ 'id' ],
                    'selector' => "\"#f{$data[ 'id' ]}\""
                )
            
            ),
                ) ;
        return \f\html::gridButton ( $buttonsParam ) ;
    }

    public function renderItemsAdd ( $id = '' )
    {
       
        if ( $id )
        {
            $row = \f\ttt::service ( 'cms.advertisement.getAdvertisementById',
                                     array (
                        'id' => $id ) ) ;
        }

        return $this->render ( 'itemsAdd',
                               array (
                    'row' => $row
                ) ) ;
    }

}
