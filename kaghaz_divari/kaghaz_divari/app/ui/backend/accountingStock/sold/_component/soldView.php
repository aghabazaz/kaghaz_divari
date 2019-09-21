<?php

class soldView extends \f\view
{

    public function renderGrid ()
    {
        return $this->render ( 'orderList', array (
                ) ) ;
    }

    public function renderSoldDetail ( $id = '' )
    {
        if ( $id )
        {
            $order = \f\ttt::service ( 'shop.order.getOrderById',
                                       array (
                        'id' => $id,
                    ) ) ;

            $orderItem = \f\ttt::service ( 'shop.orderItem.getOrderItemByParams',
                                           array (
                        'order_id' => $order[ 'id' ],
                    ) ) ;

            $member            = \f\ttt::service ( 'member.getMembersByParam',
                                                   array (
                        'id' => $order[ 'user_id' ],
                    ) ) ;
            $discountCodePrice = \f\ttt::service ( 'shop.order.getSumDiscountCodePrice',
                                                   array (
                        'orderId' => $order[ 'id' ]
                    ) ) ;
        }


        return $this->render ( 'orderDetail',
                               array (
                    'order'             => $order,
                    'orderItem'         => $orderItem,
                    'member'            => $member[ 0 ],
                    'discountCodePrice' => $discountCodePrice
                ) ) ;
    }

    public function renderSoldGrid ( $requestDataTble )
    {
        /** Get group list * */
        $this->registerGadgets ( array (
            'dateG' => 'date' ) ) ;
        $soldList = \f\ttt::service ( 'shop.order.orderListSold',
                                      array (
                    'dataTableParams' => $requestDataTble ) ) ;

        foreach ( $soldList[ 'data' ] as $key => $value )
        {
            $tdContent = $this->createActionButtons ( $value, 'sold' ) ;
//            if ( $value[ 'price_pay' ] == 0 )
//            {
//                $status = 'پ. در محل' ;
//            }
//            else
//            {
//                $status = 'پرداخت شده' ;
//            }

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
//                array (
//                    'htmlOptions' => array (
//                        'id' => 'bgparent',
//                    ),
//                    'style'       => array (
//                        'border' => 'none',
//                    ),
//                    'formatter'   => $status
//                ),
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
        $row[ 'total' ] = $soldList[ 'total' ] ;
        $row[ 'draw' ]  = $soldList[ 'draw' ] ;
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
           
                'href' => \f\ifm::app ()->baseUrl . "accountingStock/sold/soldDetail/" . $data[ 'id' ]
            ),
            array (
                'type'           => 'delete',
                'confirm'        => true,
                'action'         => 'accountingStock.sold.' . $section . 'Delete',
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
