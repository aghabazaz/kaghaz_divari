<?php

class creditSettlementView extends \f\view
{

    public function renderGrid ()
    {
        return $this->render ( 'creditSettlementList', array (
                ) ) ;
    }

    public function renderReturnedCreditSettlementDetail ( $id = '' )
    {
        //\f\pre('sdf');
        if ( $id )
        {
            $order     = \f\ttt::dal ( 'shop.order.getCreditSettlementByUserId',
                array (
                    'id' => $id
                ) ) ;

           $this->registerGadgets(array(
                'dateG' => 'date'));
           $dateSettlement=$order[0][0]['date_pay']+$order[0][0]['day_settlement']*(24*60*60);
           $endDateSettlement= $this->dateG->dateTime ($dateSettlement,2 ) ;
            //\f\pre($order);
            //\f\pre($order[0]);
          /*  foreach ($order as $data){
                $array[$i]['dateFactor']=$data['date_pay'];
                $array[$i]['factorNum']=$data['']
            }*/
            //\f\pre($order);
           /* $orderItem = \f\ttt::service ( 'shop.orderItem.getReturnedProOfOrderItemByParams',
                array (
                    'order_id' => $order[ 0 ][ 'id' ],
                ) ) ;
           //$newArray=array_column($orderItem, 'price_id');
            $arr = array();

            foreach($orderItem as $key => $item)
            {

                $arr[$item['price_id']][$item['orderReturnId']] = $item;
            }

            $member    = \f\ttt::service ( 'member.getMembersByParam',
                array (
                    'id' => $order[ 0 ][ 'user_id' ],
                ) ) ;
            $discountCodePrice = \f\ttt::service ( 'shop.order.getSumDiscountCodePrice',
                array (
                    'orderId' => $order[ 0 ][ 'id' ]
                ) ) ;*/
           // \f\pre($order);
        }


        return $this->render ( 'creditSettlementDetail',
                               array (
                                   'order'             => $order,
                                  'dateSettlement'         => $endDateSettlement,
                                  /*  'member'            => $member[ 0 ],
                                   'orderTransport'    => $orderTransport[ 0 ],
                                   'discountCodePrice' => $discountCodePrice*/
                ) ) ;
    }

    public function renderCreditSettlementGrid( $requestDataTble )
    {
        /** Get group list * */
        $this->registerGadgets ( array (
            'dateG' => 'date' ) ) ;
        $creditSettlementList = \f\ttt::service ( 'shop.order.getCreditSettlementList',
                                             array (
                    'dataTableParams' => $requestDataTble ) ) ;

        foreach ( $creditSettlementList[ 'data' ] as $key => $value )
        {
            $tdContent = $this->createActionButtons ( $value, 'creditSettlement' ) ;

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
                )
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
        $row[ 'total' ] = $creditSettlementList[ 'total' ] ;
        $row[ 'draw' ]  = $creditSettlementList[ 'draw' ] ;
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
                'href' => \f\ifm::app ()->baseUrl . "member/creditSettlement/returnedCreditSettlementDetails/" . $data[ 'id' ]
            ),

                ) ;
        return \f\html::gridButton ( $buttonsParam ) ;
    }



  /*  public function renderSetInputPrice ( $params )
    {
        return $this->render ( 'content', $params ) ;
    }*/

}
