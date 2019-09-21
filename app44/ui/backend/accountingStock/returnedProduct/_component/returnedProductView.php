<?php

class returnedProductView extends \f\view
{

    public function renderGrid ()
    {
        return $this->render ( 'returnedProductList', array (
                ) ) ;
    }

    public function renderReturnedProductDetail ( $id = '' )
    {
        if ( $id )
        {
            $order     = \f\ttt::service ( 'shop.order.getOrderByParam',
                array (
                    'id' => $id
                ) ) ;
            $orderItem = \f\ttt::service ( 'shop.orderItem.getReturnedProOfOrderItemByParams',
                array (
                    'order_id' => $order[ 0 ][ 'id' ],
                ) ) ;
           //$newArray=array_column($orderItem, 'price_id');
            $arr = array();

            foreach($orderItem as $key => $item)
            {

                $arr[$item['price_id']][$item['orderReturnId']] = $item;
            }
          //  \f\pre($arr);
          //\f\pre($newArray);
           /*
          //\f\pre($order);

        /*    $orderItem = \f\ttt::dal( 'shop.order.getOrderByParam',
           array(
                'notStatus' => 'cart',
                'id' =>$id,
                'getReturn' => 'True'
           )) ;*/
         //  \f\pre($orderItem);
            $member    = \f\ttt::service ( 'member.getMembersByParam',
                array (
                    'id' => $order[ 0 ][ 'user_id' ],
                ) ) ;
            $discountCodePrice = \f\ttt::service ( 'shop.order.getSumDiscountCodePrice',
                array (
                    'orderId' => $order[ 0 ][ 'id' ]
                ) ) ;
        }


        return $this->render ( 'returnedProductDetail',
                               array (
                                   'order'             => $order[ 0 ],
                                   'orderItem'         => $arr,
                                   'member'            => $member[ 0 ],
                                   'orderTransport'    => $orderTransport[ 0 ],
                                   'discountCodePrice' => $discountCodePrice
                ) ) ;
    }

    public function renderReturnedProductGrid ( $requestDataTble )
    {
        /** Get group list * */
        $this->registerGadgets ( array (
            'dateG' => 'date' ) ) ;
        $sendDeliverList = \f\ttt::service ( 'shop.returnedProduct.returnedProductList',
                                             array (
                    'dataTableParams' => $requestDataTble ) ) ;

        foreach ( $sendDeliverList[ 'data' ] as $key => $value )
        {
            $tdContent = $this->createActionButtons ( $value, 'returnedProduct' ) ;

            $field = array (
                array (
                    'style'     => array (
                        'border' => 'none',
                    ),
                    'formatter' => "<div class='simple-checkbox'><input id='f" . $value[ 'id' ] . "' type='checkbox' class='checkBox'/><label for='f" . $value[ 'id' ] . "'></label></div>"
                ),
                array (
                    'htmlOptions' => array (
                        'id' => 'bgparent',
                    ),
                    'style'       => array (
                        'border' => 'none',
                    ),
                    'formatter'   => $value[ 'order_id' ] + 100000
                ),
                array (
                    'htmlOptions' => array (
                        'id' => 'bgparent',
                    ),
                    'style'       => array (
                        'border' => 'none',
                    ),
                    'formatter'   => $value[ 'name' ]
                ),
                array (
                    'htmlOptions' => array (
                        'class' => 'act',
                    ),
                    'style'       => array (
                        'border' => 'none'
                    ), //onclick='widgetHelper.remove(\"" . $value[ 'id' ] . "\",\"c\",\"core.user.remove\" )'
                    'formatter'   => $tdContent,
                ),
                    ) ;
            // tr make
            // data-on-confirm='hi'
            $row[] = array (
                'htmlOptions' => array (
                    'id'    => '',
                    'class' => 'c' . $value[ 'id' ],
                ),
                'style'       => array (
                    'background' => 'red !important'
                ),
                'td'          => $field
                    ) ;
        }
        $row[ 'total' ] = $sendDeliverList[ 'total' ] ;
        $row[ 'draw' ]  = $sendDeliverList[ 'draw' ] ;
        /* @var $table \f\w\table */
        $table          = \f\widgetFactory::make ( 'table' ) ;

        $userListRow = $table->renderRow ( $row ) ;
        return $userListRow ;
    }

    private function createActionButtons ( $data, $section )
    {
        $buttonsParam = array (
            array (
                'type' => 'details',
                'href' => \f\ifm::app ()->baseUrl . "accountingStock/returnedProduct/returnedProductDetail/" . $data[ 'order_id' ]
            ),

                ) ;
        return \f\html::gridButton ( $buttonsParam ) ;
    }

    public function renderSetInputPrice ( $params )
    {
        return $this->render ( 'content', $params ) ;
    }

}
