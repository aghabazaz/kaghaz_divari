<?php

class stateView extends \f\view
{
    public function renderGrid()
    {
        
         return $this->render ( 'stateList', array (
                ) ) ;
    }
    public function renderStateAdd ( $id = '' )
    {
       
        if ( $id )
        {
            $row = \f\ttt::service ( 'cms.place.state.getStateById',
                                     array (
                        'id' => $id ) ) ;
        }

        return $this->render ( 'stateAdd',
                               array (
                    'row' => $row
                ) ) ;
    }
    
    public function renderStateGrid ( $requestDataTble )
    {

        /** Get group list * */
        $this->registerGadgets(array('dateG'=>'date'));
       
        
        $stateList = \f\ttt::service ( 'cms.place.state.stateList',
                                       array (
                    'dataTableParams' => $requestDataTble ) ) ;

        foreach ( $stateList[ 'data' ] as $key => $value )
        {

            $tdContent = $this->createActionButtons ( $value, 'state' ) ;


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
        $row[ 'total' ] = $stateList[ 'total' ] ;
        $row[ 'draw' ]  = $stateList[ 'draw' ] ;
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
                'href' => \f\ifm::app ()->baseUrl . "cms.place/state/" . $section . "Edit/" . $data[ 'id' ]
            ),
            array (
                'type'           => 'status',
                'confirm'        => TRUE,
                'id'             => 's' . $data[ 'id' ],
                'status'         => $data[ 'status' ],
                'action'         => 'cms.place.state.' . $section . 'Status',
                'clientCallBack' => 'toggleEnable',
                'params'         => array (
                    'id'     => $data[ 'id' ],
                    'status' => "\"{$data[ 'status' ]}\""
                ),
            ),
            array (
                'type'           => 'delete',
                'confirm'        => true,
                'action'         => 'cms.place.state.' . $section . 'Delete',
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
