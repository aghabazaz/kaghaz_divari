<?php

class requestView extends \f\view
{

    public function renderGrid()
    {
        return $this->render ( 'requestList', array (
                ) ) ;
    }
    public function renderRequestGrid ( $requestDataTble )
    {
        
        /** Get group list * */
        $this->registerGadgets(array('dateG'=>'date'));
       
        
        $requestList = \f\ttt::service ( 'news.advertisement.requestList',
                                       array (
                    'dataTableParams' => $requestDataTble ) ) ;
        
        //\f\pr('pppp');

        foreach ( $requestList[ 'data' ] as $key => $value )
        {

            $tdContent = $this->createActionButtons ( $value, 'request' ) ;


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
                'type'           => 'delete',
                'confirm'        => true,
                'action'         => 'news.advertisement.request.' . $section . 'Delete',
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
