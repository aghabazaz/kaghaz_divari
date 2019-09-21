<?php

class sendDeliverView extends \f\view
{

    public function renderGrid ()
    {
        return $this->render ( 'orderList', array (
                ) ) ;
    }

    public function renderSendDeliverDetail ( $id = '' )
    {
        if ( $id )
        {
            $order     = \f\ttt::service ( 'shop.order.getOrderByParam',
                                           array (
                        'id' => $id
                    ) ) ;
           // \f\pre($order);
            $orderItem = \f\ttt::service ( 'shop.orderItem.getOrderItemByParams',
                                           array (
                        'order_id' => $order[ 0 ][ 'id' ],
                    ) ) ;
            $member    = \f\ttt::service ( 'member.getMembersByParam',
                                           array (
                        'id' => $order[ 0 ][ 'user_id' ],
                    ) ) ;
            $discountCodePrice = \f\ttt::service ( 'shop.order.getSumDiscountCodePrice',
                                                   array (
                        'orderId' => $order[ 0 ][ 'id' ]
                    ) ) ;
        }


        return $this->render ( 'orderDetail',
                               array (
                    'order'             => $order[ 0 ],
                    'orderItem'         => $orderItem,
                    'member'            => $member[ 0 ],
                    'orderTransport'    => $orderTransport[ 0 ],
                    'discountCodePrice' => $discountCodePrice
                ) ) ;
    }

    public function renderSendDeliverGrid ( $requestDataTble )
    {
        /** Get group list * */
        $this->registerGadgets ( array (
            'dateG' => 'date' ) ) ;
        $sendDeliverList = \f\ttt::service ( 'shop.order.orderListSendDeliver',
                                             array (
                    'dataTableParams' => $requestDataTble ) ) ;

     //   \f\pre($sendDeliverList);
        foreach ( $sendDeliverList[ 'data' ] as $key => $value )
        {
            $tdContent = $this->createActionButtons ( $value, 'sendDeliver' ) ;

            switch ( $value[ 'status' ] )
            {
                case 'inventoryOk':
                    $status = \f\ifm::t ( 'inventoryOk' ) ;
                    $color  = '#ff8000' ;
                    break ;
                case 'sending':
                    $status = \f\ifm::t ( 'sending' ) ;
                    $color  = '#33ccff' ;
                    break ;
                case 'delivery':
                    $status = \f\ifm::t ( 'delivery' ) ;
                    $color  = '#009900' ;
                    break ;
                case 'returned':
                    $status = \f\ifm::t ( 'returned' ) ;
                    $color  = '#ff0000' ;
                    break ;
            }
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
                    'formatter'   => $value[ 'id' ] + 100000
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
                        'id' => 'bgparent',
                    ),
                    'style'       => array (
                        'border' => 'none',
                    ),
                    'formatter'   => $this->dateG->dateTime ( $value[ 'date_pay' ],
                                                              2 ) . ' ساعت: ' . date ( 'H:i',
                                                                                       $value[ 'date_pay' ] )
                ),
                array (
                    'htmlOptions' => array (
                        'id' => 'bgparent',
                    ),
                    'style'       => array (
                        'border' => 'none',
                    ),
                    'formatter'   => number_format ( $value[ 'price_pay' ] ) //.' تومان '
                ),
                array (
                    'htmlOptions' => array (
                        'id' => 'bgparent',
                    ),
                    'style'       => array (
                        'border' => 'none',
                    ),
                    'formatter'   => "<div style='background:$color;color:#FFF;display:inline-block;padding:3px'>$status</div>"
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
                'href' => \f\ifm::app ()->baseUrl . "accountingStock/sendDeliver/sendDeliverDetail/" . $data[ 'id' ]
            ),
            array (
                'type'           => 'delete',
                'confirm'        => true,
                'action'         => 'accountingStock.sendDeliver.' . $section . 'Delete',
                'clientCallback' => 'remove',
                'params'         => array (
                    'id'       => $data[ 'id' ],
                    'selector' => "\"#f{$data[ 'id' ]}\""
                )
            ),
                ) ;
        return \f\html::gridButton ( $buttonsParam ) ;
    }

    public function renderSetInputPrice ( $params )
    {
        return $this->render ( 'content', $params ) ;
    }

}
