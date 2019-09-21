<?php

class userOperateRepView extends \f\view
{

    public function renderGrid ()
    {
        $buyerList = \f\ttt::service ( 'shop.order.getListBuyers' ) ;
        foreach ( $buyerList AS $value )
        {
            $buyerListArr[$value['id']] = $value['name'];
        }
       // \f\pre($buyerListArr);
        return $this->render ( 'userOperateList' ,array (
        'buyerList' => $buyerListArr,
    ) ) ;
    }

    public function renderUserOperateGrid ( $requestDataTble )
    {
        /** Get group list * */
        $this->registerGadgets ( array (
            'dateG' => 'date'
        ) ) ;
        /* @var $dateG \f\g\date */
        //  $dateG  = \f\gadgetFactory::make ( 'date' ) ;
        $today=time() ;
        $userOperateList = \f\ttt::dal ( 'shop.order.statisticalReportsSave',
            array (
                'dataTableParams' => $requestDataTble,
                'date_start' => $today-(24*60*60),
                'date_end'=>$today,
            ) ) ;


        //\f\pre($userOperateList);
        // \f\pre($userOperateList);
        foreach ( $userOperateList['data'] as $key => $value )
        {
            $tdContent = $this->createActionButtons ( $value, 'normUsers' ) ;

            if($value[ 'type' ]=='online'){
                $typePay='پرداخت آنلاین';
            }else if($value['type']=='credit'){
                $typePay='اعتباری';
            }else{
                $typePay='پرداخت در محل';
            }
            $field = array (
                array (
                    'style' => array (
                        'border'    => 'none',
                    ),
                    'formatter' => "<div class='simple-checkbox'><input id='f" . $value[ 'order_id' ] . "' type='checkbox' class='checkBox'/><label for='f" . $value[ 'order_id' ] . "'></label></div>"
                ),
                array (
                    'htmlOptions' => array (
                        'id'    => 'bgparent',
                    ),
                    'style' => array (
                        'border'    => 'none',
                        'color'     => 'red !important'
                    ),
                    'formatter' => $value[ 'username' ]
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
                        'class' => 'tdsearch',
                    ),
                    'style'       => array (
                        'border' => 'none'
                    ),
                    'formatter'   => $this->dateG->dateTime ( $value[ 'date_pay' ],
                            2 ) . ' ' . date ( 'H:i',
                            $value[ 'date_pay' ] )
                ),
                array (
                    'htmlOptions' => array (
                        'id'    => 'bgparent',
                    ),
                    'style' => array (
                        'border'    => 'none',
                        'color'     => 'red !important'
                    ),
                    'formatter' => $typePay
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
        $row[ 'total' ] = $userOperateList[ 'total' ] ;
        $row[ 'draw' ]  = $userOperateList[ 'draw' ] ;
        /* @var $table \f\w\table */
        $table          = \f\widgetFactory::make ( 'table' ) ;

        $userListRow = $table->renderRow ( $row ) ;
        return $userListRow ;
    }

    public function renderUserOperateGrid2 ( $requestDataTble,$params )
    {
        /** Get group list * */
        $this->registerGadgets ( array (
            'dateG' => 'date'
        ) ) ;
        //\f\pre($requestDataTble);
        /* @var $dateG \f\g\date */
        $userOperateList = \f\ttt::dal ( 'shop.order.statisticalReportsSave',
            array (
                'dataTableParams' => $requestDataTble,
                'date_start' =>$params[0] ,
                'date_end'=>$params[1],
                'user_id'=>$params[2],
                'type'=>'ajax'
            ) ) ;

     //  \f\pre($userOperateList['data']);
        foreach ( $userOperateList['data'] as $key => $value )
        {
            $tdContent = $this->createActionButtons ( $value, 'normUsers' ) ;

            if($value[ 'type' ]=='online'){
                $typePay='پرداخت آنلاین';
            }else if($value['type']=='credit'){
                $typePay='اعتباری';
            }else{
                $typePay='پرداخت در محل';
            }
            $field = array (
                array (
                    'style' => array (
                        'border'    => 'none',
                    ),
                    'formatter' => "<div class='simple-checkbox'><input id='f" . $value[ 'order_id' ] . "' type='checkbox' class='checkBox'/><label for='f" . $value[ 'order_id' ] . "'></label></div>"
                ),
                array (
                    'htmlOptions' => array (
                        'id'    => 'bgparent',
                    ),
                    'style' => array (
                        'border'    => 'none',
                        'color'     => 'red !important'
                    ),
                    'formatter' => $value[ 'username' ]
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
                        'class' => 'tdsearch',
                    ),
                    'style'       => array (
                        'border' => 'none'
                    ),
                    'formatter'   => $this->dateG->dateTime ( $value[ 'date_pay' ],
                            2 ) . ' ' . date ( 'H:i',
                            $value[ 'date_pay' ] )
                ),
                array (
                    'htmlOptions' => array (
                        'id'    => 'bgparent',
                    ),
                    'style' => array (
                        'border'    => 'none',
                        'color'     => 'red !important'
                    ),
                    'formatter' => $typePay
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
        $row[ 'total' ] = $userOperateList[ 'total' ] ;
        $row[ 'draw' ]  = $userOperateList[ 'draw' ] ;
        /* @var $table \f\w\table */
        $table          = \f\widgetFactory::make ( 'table' ) ;


       // \f\pre($row);
       // \f\pre($table);
        $userListRow = $table->renderRow ( $row ) ;
        return $userListRow ;
    }


    private function createActionButtons ( $data, $content )
    {
        $buttonsParam = array (
            array (
                'type' => 'edit',
                'href' => \f\ifm::app ()->baseUrl . "member/memberList/normUsers/" . $content . "Edit/" . $data[ 'id' ]
            ),
            array (
                'type'           => 'status',
                'confirm'        => TRUE,
                'id'             => 's' . $data[ 'id' ],
                'status'         => $data[ 'status' ],
                'action'         => 'member.memberList.normUsers.' . $content . 'Status',
                'clientCallBack' => 'toggleEnable',
                'params'         => array (
                    'id'     => $data[ 'id' ],
                    'status' => "\"{$data[ 'status' ]}\""
                ),
            ),
            array (
                'type'           => 'delete',
                'confirm'        => true,
                'action'         => 'member.memberList.normUsers.' . $content . 'Delete',
                'clientCallback' => 'remove',
                'params'         => array (
                    'id'       => $data[ 'id' ],
                    'selector' => "\"#f{$data[ 'id' ]}\""
                )
            )
                ) ;
        return \f\html::gridButton ( $buttonsParam ) ;
    }

    public function renderNormUsersAdd ( $id = '' )
    {
        if ( $id )
        {
            $row = \f\ttt::service ( 'member.getMemberById',
                                     array (
                        'id' => $id ) ) ;
          //  \f\pre($row);
        }

        return $this->render ( 'normUsersAdd',
                               array (
                    'row' => $row,
                ) ) ;
    }

}
