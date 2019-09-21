<?php

class wholesalerView extends \f\view
{

    public function renderGrid ()
    {

        return $this->render ( 'wholesalerList', array (
                ) ) ;
    }

    public function renderWholesalerAdd ( $id = '' )
    {

        if ( $id )
        {
            $row = \f\ttt::service ( 'shop.wholesaler.getWholesalerById',
                                     array (
                        'id' => $id ) ) ;
        }

        return $this->render ( 'wholesalerAdd',
                               array (
                    'row' => $row,
                ) ) ;
    }

    public function renderWholesalerGrid ( $requestDataTble )
    {

        /** Get group list * */
        $this->registerGadgets ( array ( 'dateG' => 'date' ) ) ;


        $wholesalerList = \f\ttt::service ( 'shop.wholesaler.wholesalerList',
                                           array (
                    'dataTableParams' => $requestDataTble ) ) ;
        foreach ( $wholesalerList[ 'data' ] as $key => $value )
        {

            $tdContent = $this->createActionButtons ( $value, 'wholesaler' ) ;

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
                    'formatter' => $value[ 'mobile' ]
                ),
                array (
                    'htmlOptions' => array (
                        'id'    => 'bgparent',
                    ),
                    'style' => array (
                        'border'    => 'none',
                        'color'     => 'red !important'
                    ),
                    'formatter' => $value[ 'shop_name' ]
                ),
                array (
                    'htmlOptions' => array (
                        'id'    => 'bgparent',
                    ),
                    'style' => array (
                        'border'    => 'none',
                        'color'     => 'red !important'
                    ),
                    'formatter' => $value[ 'address' ]
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
        $row[ 'total' ] = $wholesalerList[ 'total' ] ;
        $row[ 'draw' ]  = $wholesalerList[ 'draw' ] ;
        /* @var $table \f\w\table */
        $table          = \f\widgetFactory::make ( 'table' ) ;

        $userListRow = $table->renderRow ( $row ) ;
        return $userListRow ;
    }

    private function createActionButtons ( $data, $section )
    {
        $buttonsParam = array (
            array (
                'type'           => 'status',
                'confirm'        => TRUE,
                'id'             => 's' . $data[ 'id' ],
                'status'         => $data[ 'wholesaler_set' ],
                'action'         => 'shop.wholesaler.' . $section . 'Status',
                'clientCallBack' => 'toggleEnable',
                'params'         => array (
                    'id'     => $data[ 'id' ],
                    'status' => "\"{$data[ 'wholesaler_set' ]}\""
                ),
            ),
                ) ;
        return \f\html::gridButton ( $buttonsParam ) ;
    }

}
