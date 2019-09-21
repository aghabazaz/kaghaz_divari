<?php

class commentView extends \f\view
{

    public function renderGrid ()
    {

        return $this->render ( 'commentList', array (
                ) ) ;
    }

    public function renderCommentDetail ( $id )
    {
        $infoComment    = \f\ttt::service ( 'shop.comment.getCommentById',
                                            array (
                    'id' => $id,
                ) ) ;
        $productComment = \f\ttt::service ( 'shop.comment.getCommentByProductId',
                                            array (
                    'user_id'    => $infoComment[ 'user_id' ],
                    'product_id' => $infoComment[ 'product_id' ],
                ) ) ;
        $ratingOptions = \f\ttt::service ( 'shop.ratingOptions.getRatingOptionsById',
                                           array (
                    'id'      => $infoComment[ 'product_id' ],
                ) ) ;

        $commentStatus = $productComment[ 0 ][ 'status' ] ;
        //\f\pre($commentStatus);
        foreach ( $productComment[ 1 ] as $data )
        {
            if ( $data[ 'type' ] == 'weakness' )
            {
                $arrTipWeak[ $data[ 'id' ] ] = $data[ 'title' ] ;
            }
            else
            {
                $arrTipStrength[ $data[ 'id' ] ] = $data[ 'title' ] ;
            }
        }
        //\f\pre($arrTipStrength);
        $ratingValue = json_decode ( $ratingOptions[ 'rating_options' ] ) ;
        $ratingTitle = \f\ttt::service ( 'shop.ratingOptions.getRatingTitleById',
                                         array (
                    'ratingValue' => $ratingValue
                ) ) ;
        $rateOld     = \f\ttt::service ( 'shop.ratingOptions.getRatingOptionsByUserId',
                                         array (
                    'user_id'    => $infoComment[ 'user_id' ],
                    'product_id' => $infoComment[ 'product_id' ],
                ) ) ;
        if ( $rateOld )
        {
            foreach ( $rateOld AS $data )
            {
                $arrRateOld[ $data[ 'option_id' ] ] = $data[ 'rate' ] ;
            }
        }

        return $this->render ( 'commentDetail',
                               array (
                    'ratingTitle'    => $ratingTitle,
                    'ratingOptions'  => $ratingOptions,
                    'rateOld'        => $arrRateOld,
                    'productComment' => $productComment[ 0 ],
                    'arrTipWeak'     => $arrTipWeak,
                    'arrTipStrength' => $arrTipStrength,
                    'commentStatus'  => $commentStatus,
                ) ) ;
    }

    public function renderCommentGrid ( $requestDataTble )
    {
        $this->registerGadgets ( array (
            'dateG' => 'date' ) ) ;
        $commentList = \f\ttt::service ( 'shop.comment.commentList', array (
                    'dataTableParams' => $requestDataTble ) ) ;


        foreach ( $commentList[ 'data' ] as $key => $value )
        {
            $tdContent = $this->createActionButtons ( $value, 'comment' ) ;

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
                        'color'  => 'red !important'
                    ),
                    'formatter'   => $value[ 'name' ]
                ),
                array (
                    'htmlOptions' => array (
                        'id' => 'bgparent',
                    ),
                    'style'       => array (
                        'border' => 'none',
                        'color'  => 'red !important'
                    ),
                    'formatter'   => $value[ 'title' ]
                ),
                array (
                    'htmlOptions' => array (
                        'id' => 'bgparent',
                    ),
                    'style'       => array (
                        'border' => 'none',
                        'color'  => 'red !important'
                    ),
                    'formatter'   => $value[ 'description' ]
                ),
                array (
                    'htmlOptions' => array (
                        'id' => 'bgparent',
                    ),
                    'style'       => array (
                        'border' => 'none',
                        'color'  => 'red !important'
                    ),
                    'formatter'   => $this->dateG->dateTime ( $value[ 'date_register' ],
                                                              2 ) . '--' . date ( 'H:i',
                                                                                  $value[ 'date_register' ] )
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
        $row[ 'total' ] = $commentList[ 'total' ] ;
        $row[ 'draw' ]  = $commentList[ 'draw' ] ;
        /* @var $table \f\w\table */
        $table          = \f\widgetFactory::make ( 'table' ) ;

        $userListRow = $table->renderRow ( $row ) ;
        return $userListRow ;
    }

    private function createActionButtons ( $data, $section )
    {
        $buttonsParam = array (
            array (
                'type' => 'custom',
                'icon' => 'fa fa-list-alt',
                'href' => \f\ifm::app ()->baseUrl . "shop/comment/commentDetail/" . $data[ 'id' ]
            ),
            array (
                'type'           => 'status',
                'confirm'        => TRUE,
                'id'             => 's' . $data[ 'id' ],
                'status'         => $data[ 'status' ],
                'action'         => 'shop.comment.' . $section . 'Status',
                'clientCallBack' => 'toggleEnable',
                'params'         => array (
                    'id'     => $data[ 'id' ],
                    'status' => "\"{$data[ 'status' ]}\""
                ),
            ),
            array (
                'type'           => 'delete',
                'confirm'        => true,
                'action'         => 'shop.comment.' . $section . 'Delete',
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
