<?php

class customProductRequestView extends \f\view
{

    public function renderGrid ()
    {

        return $this->render ( 'customProductRequestList', array (
                ) ) ;
    }

    public function renderCustomProductRequestAdd ( $id = '' )
    {

        if ( $id )
        {
            $row = \f\ttt::service ( 'shop.customProductRequest.getCustomProductRequestById',
                                     array (
                        'id' => $id ) ) ;
            $this->registerGadgets ( array ( 'dateG' => 'date' ) ) ;
            $row['date_register']=$this->dateG->dateTime ($row['date_register'],2 );
        }

        $products = \f\ttt::dal ( 'shop.product.getProductList') ;
        foreach ( $products AS $data2 )
        {
            $productsArray[ $data2[ 'id' ] ] = $data2[ 'title' ] ;
        }

        return $this->render ( 'customProductRequestAdd',
                               array (
                    'row' => $row,'product'=>$productsArray
                ) ) ;
    }

    public function renderCustomProductRequestGrid ( $requestDataTble )
    {

        /** Get group list * */
       $this->registerGadgets ( array ( 'dateG' => 'date' ) ) ;
        $customProductRequestList = \f\ttt::service ( 'shop.customProductRequest.customProductRequestList',
                                           array ('dataTableParams' => $requestDataTble ) ) ;
        foreach ( $customProductRequestList[ 'data' ] as $key => $value )
        {
            $tdContent = $this->createActionButtons ( $value, 'customProductRequest' ) ;

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
                    'formatter' => $value[ 'name_family' ]
                ),
                array (
                    'htmlOptions' => array (
                        'id'    => 'bgparent',
                    ),
                    'style' => array (
                        'border'    => 'none',
                        'color'     => 'red !important'
                    ),
                    'formatter' => $value[ 'call_number' ]
                ),
                array (
                    'htmlOptions' => array (
                        'id'    => 'bgparent',
                    ),
                    'style' => array (
                        'border'    => 'none',
                        'color'     => 'red !important'
                    ),
                    'formatter' => $this->dateG->dateTime ($value['date_register'],2 )
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
        $row[ 'total' ] = $customProductRequestList[ 'total' ] ;
        $row[ 'draw' ]  = $customProductRequestList[ 'draw' ] ;
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
                'href' => \f\ifm::app ()->baseUrl . "shop/customProductRequest/" . $section . "Edit/" . $data[ 'id' ]
            ),
            array (
                'type'           => 'status',
                'confirm'        => TRUE,
                'id'             => 's' . $data[ 'id' ],
                'status'         => $data[ 'status' ],
                'action'         => 'shop.customProductRequest.' . $section . 'Status',
                'clientCallBack' => 'toggleEnable',
                'params'         => array (
                    'id'     => $data[ 'id' ],
                    'status' => "\"{$data[ 'status' ]}\""
                ),
            ),
            array (
                'type'           => 'delete',
                'confirm'        => true,
                'action'         => 'shop.customProductRequest.' . $section . 'Delete',
                'clientCallback' => 'remove',
                'params'         => array (
                    'id'       => $data[ 'id' ],
                    'selector' => "\"#f{$data[ 'id' ]}\""
                )
            )
                ) ;
        return \f\html::gridButton ( $buttonsParam ) ;
    }

}
