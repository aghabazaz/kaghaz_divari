<?php

class discountCodeView extends \f\view
{

    public function renderGrid ()
    {
        return $this->render ( 'discountCodeList' ) ;
    }

    public function renderDiscountCodeGrid ( $requestDataTble )
    {

        /** Get group list * */
        $this->registerGadgets(array('dateG'=>'date'));

        $memberListList = \f\ttt::service ( 'shop.discount.discountCode.discountCodeList',
            array (
                'dataTableParams' => $requestDataTble,
                ) ) ;

        $this->registerGadgets(array(
            'dateG' => 'date'));

        foreach ( $memberListList[ 'data' ] as $key => $value )
        {

            $tdContent = $this->createActionButtons ( $value, 'discountCode' ) ;


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
                        'id'    => 'bgparent',
                    ),
                    'style' => array (
                        'border'    => 'none',
                        'color'     => 'red !important'
                    ),
                    'formatter' => $value[ 'credit_code' ]
                ),
                array (
                    'htmlOptions' => array (
                        'id'    => 'bgparent',
                    ),
                    'style' => array (
                        'border'    => 'none',
                        'color'     => 'red !important'
                    ),
                    'formatter' => $value[ 'date_credit' ]
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
                'href' => \f\ifm::app ()->baseUrl . "shop/discount/discountCode/" . $content . "Edit/" . $data[ 'id' ]
            ),
            array (
                'type'           => 'status',
                'confirm'        => TRUE,
                'id'             => 's' . $data[ 'id' ],
                'status'         => $data[ 'status' ],
                'action'         => 'shop.discount.discountCode.' . $content . 'Status',
                'clientCallBack' => 'toggleEnable',
                'params'         => array (
                    'id'     => $data[ 'id' ],
                    'status' => "\"{$data[ 'status' ]}\""
                ),
            ),
            array (
                'type'           => 'delete',
                'confirm'        => true,
                'action'         => 'shop.discount.discountCode.' . $content . 'Delete',
                'clientCallback' => 'remove',
                'params'         => array (
                    'id'       => $data[ 'id' ],
                    'selector' => "\"#f{$data[ 'id' ]}\""
                )
            )
                ) ;
        return \f\html::gridButton ( $buttonsParam ) ;
    }

    public function renderDiscountCodeAdd ( $id = '' )
    {
        if ( $id )
        {
            $row = \f\ttt::service ( 'shop.discount.discountCode.getDiscountCodeId',
                                     array (
                        'id' => $id ) ) ;
        }
        $type_use[ 'oneUse' ]  = 'هر کاربر فقط یک بار از کد استفاده کند' ;
        $type_use[ 'oneUsePerOrder' ] = 'هر کاربر برای یک سفارش فقط یک بار از کد استفاده کند' ;
        $type_use[ 'unlimit' ] = 'هر کاربر بدون محدودیت می تواند از کد استفاده استفاده کند.' ;

        return $this->render ( 'discountCodeAdd',
                               array (
                    'row' => $row,
                    'type_use' => $type_use,
                ) ) ;
    }

}
