<?php

class basketOffView extends \f\view
{

    public function renderGrid ()
    {
        return $this->render ( 'basketOffList' ) ;
    }

    public function renderBasketOffGrid ( $requestDataTble )
    {
        /** Get group list * */
        $this->registerGadgets(array('dateG'=>'date'));

        $memberListList = \f\ttt::service ( 'shop.discount.basketOff.basketOffList',
            array (
                'dataTableParams' => $requestDataTble) ) ;

        $this->registerGadgets(array(
            'dateG' => 'date'));

        foreach ( $memberListList[ 'data' ] as $key => $value )
        {
            $tdContent = $this->createActionButtons ( $value, 'basketOff' ) ;
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
                    'style'       => array (
                        'border' => 'none'
                    ),
                    'formatter'   => $value[ 'date_credit' ]

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
        $row[ 'total' ] = $memberListList[ 'total' ] ;
        $row[ 'draw' ]  = $memberListList[ 'draw' ] ;
        /* @var $table \f\w\table */
        $table          = \f\widgetFactory::make ( 'table' ) ;

        $userListRow = $table->renderRow ( $row ) ;
        return $userListRow ;
    }

    private function createActionButtons ( $data, $content )
    {
        $buttonsParam = array (
            array (
                'type' => 'edit',
                'href' => \f\ifm::app ()->baseUrl . "shop/discount/basketOff/" . $content . "Edit/" . $data[ 'id' ]
            ),
            array (
                'type'           => 'status',
                'confirm'        => TRUE,
                'id'             => 's' . $data[ 'id' ],
                'status'         => $data[ 'status' ],
                'action'         => 'shop.discount.basketOff.' . $content . 'Status',
                'clientCallBack' => 'toggleEnable',
                'params'         => array (
                    'id'     => $data[ 'id' ],
                    'status' => "\"{$data[ 'status' ]}\""
                ),
            ),
            array (
                'type'           => 'delete',
                'confirm'        => true,
                'action'         => 'shop.discount.basketOff.' . $content . 'Delete',
                'clientCallback' => 'remove',
                'params'         => array (
                    'id'       => $data[ 'id' ],
                    'selector' => "\"#f{$data[ 'id' ]}\""
                )
            )
                ) ;
        return \f\html::gridButton ( $buttonsParam ) ;
    }

    public function renderBasketOffAdd ( $id = '' )
    {
        if ( $id )
        {
            $row = \f\ttt::service ( 'shop.discount.basketOff.getBasketOffId',
                                     array (
                        'id' => $id ) ) ;
        }

        return $this->render ( 'basketOffAdd',
                               array (
                    'row' => $row,
                ) ) ;
    }

}
