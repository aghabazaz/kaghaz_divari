<?php

class mostSellRepView extends \f\view
{

    public function renderGrid ()
    {
        return $this->render ( 'sellersList' ) ;
    }

    public function mostSellRepIndex(){

        //\f\pre('sfd');
        return $this->render( 'mostSellRep',
            [
              //  'mostSellCat'=>$mostSellRepCat
            ]
        );
    }

    public function renderMostSellRepCatList($requestDataTble){
        $this->registerGadgets(array('dateG'=>'date'));

        $mostSellRepBaseOnCatList = \f\ttt::dal ( 'shop.order.mostSellRepBaseOnCat',
            array (
                'dataTableParams' => $requestDataTble,
            ) ) ;

      //  \f\pre($mostSellRepBaseOnCatList);

        $this->registerGadgets(array(
            'dateG' => 'date'));

        foreach ( $mostSellRepBaseOnCatList[ 'data' ] as $key => $value )
        {
          //  $tdContent = $this->createActionButtons ( $value, 'memberUpgrade' ) ;

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
                    'formatter' => $value[ 'stock' ]
                ),
                array (
                    'htmlOptions' => array (
                        'id'    => 'bgparent',
                    ),
                    'style' => array (
                        'border'    => 'none',
                        'color'     => 'red !important'
                    ),
                    'formatter' => $value[ 'count_pro' ]
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
        $row[ 'total' ] = $mostSellRepBaseOnCatList[ 'total' ] ;
        $row[ 'draw' ]  = $mostSellRepBaseOnCatList[ 'draw' ] ;
        /* @var $table \f\w\table */
        $table          = \f\widgetFactory::make ( 'table' ) ;


        $userListRow = $table->renderRow ( $row ) ;
        return $userListRow ;
    }

    public function renderMostSellRepBrandList($requestDataTble){
        $this->registerGadgets(array('dateG'=>'date'));

        $mostSellRepBaseOnBrandList = \f\ttt::dal ( 'shop.order.mostSellRepBaseOnBrand',
            array (
                'dataTableParams' => $requestDataTble,
            ) ) ;

        //  \f\pre($mostSellRepBaseOnCatList);

        $this->registerGadgets(array(
            'dateG' => 'date'));

        foreach ( $mostSellRepBaseOnBrandList[ 'data' ] as $key => $value )
        {
            //  $tdContent = $this->createActionButtons ( $value, 'memberUpgrade' ) ;

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
                    'formatter' => $value[ 'title_fa' ]
                ),
                array (
                    'htmlOptions' => array (
                        'id'    => 'bgparent',
                    ),
                    'style' => array (
                        'border'    => 'none',
                        'color'     => 'red !important'
                    ),
                    'formatter' => $value[ 'stock' ]
                ),
                array (
                    'htmlOptions' => array (
                        'id'    => 'bgparent',
                    ),
                    'style' => array (
                        'border'    => 'none',
                        'color'     => 'red !important'
                    ),
                    'formatter' => $value[ 'count_pro' ]
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
        $row[ 'total' ] = $mostSellRepBaseOnBrandList[ 'total' ] ;
        $row[ 'draw' ]  = $mostSellRepBaseOnBrandList[ 'draw' ] ;
        /* @var $table \f\w\table */
        $table          = \f\widgetFactory::make ( 'table' ) ;


        $userListRow = $table->renderRow ( $row ) ;
        return $userListRow ;
    }

    public function renderMostSellRepProductList(){

    }

    public function renderSellersGrid ( $requestDataTble )
    {

        /** Get group list * */
        $this->registerGadgets(array('dateG'=>'date'));


        $memberListList = \f\ttt::service ( 'member.memberListList',
            array (
                'dataTableParams' => $requestDataTble,
                'type_user'=>'seller') ) ;

        $this->registerGadgets(array(
            'dateG' => 'date'));

        foreach ( $memberListList[ 'data' ] as $key => $value )
        {

            $tdContent = $this->createActionButtons ( $value, 'sellers' ) ;


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
                    'formatter' => $value[ 'email' ]
                ),
                array (
                    'htmlOptions' => array (
                        'class' => 'tdsearch',
                    ),
                    'style'       => array (
                        'border' => 'none'
                    ),
                    'formatter'   => $this->dateG->dateTime ( $value[ 'date_register' ],
                            2 ) . ' ' . date ( 'H:i',
                            $value[ 'date_register' ] )
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
                'href' => \f\ifm::app ()->baseUrl . "member/memberList/sellers/" . $content . "Edit/" . $data[ 'id' ]
            ),
            array (
                'type'           => 'status',
                'confirm'        => TRUE,
                'id'             => 's' . $data[ 'id' ],
                'status'         => $data[ 'status' ],
                'action'         => 'member.memberList.sellers.' . $content . 'Status',
                'clientCallBack' => 'toggleEnable',
                'params'         => array (
                    'id'     => $data[ 'id' ],
                    'status' => "\"{$data[ 'status' ]}\""
                ),
            ),
            array (
                'type'           => 'delete',
                'confirm'        => true,
                'action'         => 'member.memberList.sellers.' . $content . 'Delete',
                'clientCallback' => 'remove',
                'params'         => array (
                    'id'       => $data[ 'id' ],
                    'selector' => "\"#f{$data[ 'id' ]}\""
                )
            )
        ) ;
        return \f\html::gridButton ( $buttonsParam ) ;
    }

    public function renderSellersAdd ( $id = '' )
    {
        if ( $id )
        {
            $row = \f\ttt::service ( 'member.getMemberById',
                array (
                    'id' => $id ) ) ;
            //  \f\pre($row);
        }

        return $this->render ( 'sellersAdd',
            array (
                'row' => $row,
            ) ) ;
    }


}
