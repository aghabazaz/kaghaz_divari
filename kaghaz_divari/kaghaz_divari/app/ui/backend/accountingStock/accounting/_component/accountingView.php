<?php

class accountingView extends \f\view
{

    public function renderGrid ()
    {
        return $this->render ( 'accountingList', array (
                ) ) ;
    }

    public function renderAccountingDetail ( $id = '' )
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

            $member = \f\ttt::service ( 'member.getMemberById',
                                        array (
                        'id' => $order[ 'user_id' ],
                    ) ) ;

            $cardArr = str_split ( $member[ 'card' ], 4 ) ;
            //$cardArr = array_reverse ( $cardArr ) ; // just for backend _ rtl
            $card    = implode ( "-", $cardArr ) ;

            $discountCodePrice = \f\ttt::service ( 'shop.order.getSumDiscountCodePrice',
                                                   array (
                        'orderId' => $order[ 'id' ]
                    ) ) ;

            //\f\pr($discountCodePrice);
        }


        return $this->render ( 'accountingDetail',
                               array (
                    'order'             => $order,
                    'orderItem'         => $orderItem,
                    'member'            => $member,
                    'card'              => $card,
                    'discountCodePrice' => $discountCodePrice
                ) ) ;
    }

    public function renderAccountingGrid ( $requestDataTble )
    {
        /** Get group list * */
        $this->registerGadgets ( array (
            'dateG' => 'date' ) ) ;
        $accountingList = \f\ttt::service ( 'shop.order.orderListAccounting',
                                            array (
                    'dataTableParams' => $requestDataTble ) ) ;
//\f\pre($accountingList);
        foreach ( $accountingList[ 'data' ] as $key => $value )
        {
            $tdContent = $this->createActionButtons ( $value, 'accounting' ) ;
            if ( $value[ 'status' ] == 'payed' )
            {
                $status = 'پرداخت شده' ;
            }else if($value['status']=='credit'){
                $status='اعتباری';
            }
            else
            {
                if($value['pos_option']=='noPos'){
                $status = 'پ. در محل نقدی' ;
                }else{
                    $status = 'پ. در محل کارت خوان' ;
                }
            }
            if($value[ 'type_user' ] == 'seller'){
                $value['type_user']='فروشنده';
            }else{
                $value['type_user']='کاربر عادی';
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
                    'formatter'   => $status
                ),
                array (
                    'htmlOptions' => array (
                        'id' => 'bgparent',
                    ),
                    'style'       => array (
                        'border' => 'none',
                    ),
                    'formatter'   =>  $value[ 'type_user' ]
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
        $row[ 'total' ] = $accountingList[ 'total' ] ;
        $row[ 'draw' ]  = $accountingList[ 'draw' ] ;
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
                'href' => \f\ifm::app ()->baseUrl . "accountingStock/accounting/accountingDetail/" . $data[ 'id' ]
            ),
            array (
                'type'           => 'delete',
                'confirm'        => true,
                'action'         => 'accountingStock.accounting.' . $section . 'Delete',
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
