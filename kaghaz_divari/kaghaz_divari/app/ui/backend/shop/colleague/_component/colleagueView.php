<?php

class colleagueView extends \f\view
{

    public function renderGrid ()
    {

        return $this->render ( 'colleagueList', array (
                ) ) ;
    }

    public function renderColleagueAdd ( $id = '' )
    {

        if ( $id )
        {
            $row = \f\ttt::service ( 'shop.colleague.getColleagueById',
                                     array (
                        'id' => $id ) ) ;
        }
        return $this->render ( 'colleagueAdd',
                               array (
                    'row' => $row,
                ) ) ;
    }

    public function renderColleagueGrid ( $requestDataTble )
    {

        /** Get group list * */
        $this->registerGadgets ( array ( 'dateG' => 'date' ) ) ;


        $colleagueList = \f\ttt::service ( 'shop.colleague.colleagueList',
                                           array (
                    'dataTableParams' => $requestDataTble ) ) ;
        foreach ( $colleagueList[ 'data' ] as $key => $value )
        {

            $tdContent = $this->createActionButtons ( $value, 'colleague' ) ;

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
                    'formatter' => $value[ 'shop_name' ]
                ),
                array (
                    'htmlOptions' => array (
                        'id'    => 'bgparent',
                    ),
                    'style' => array (
                        'border'    => 'none',
                        'color'     => 'red !important'
                    ),
                    'formatter' => $value[ 'address' ]
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
        $row[ 'total' ] = $colleagueList[ 'total' ] ;
        $row[ 'draw' ]  = $colleagueList[ 'draw' ] ;
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
                'href' => \f\ifm::app ()->baseUrl . "shop/colleague/" . $section . "Edit/" . $data[ 'id' ]
            ),
            array (
                'type'           => 'status',
                'confirm'        => TRUE,
                'id'             => 's' . $data[ 'id' ],
                'status'         => $data[ 'colleague_set' ],
                'action'         => 'shop.colleague.' . $section . 'Statusis',
                'clientCallBack' => 'toggleEnable',
                'params'         => array (
                    'id'     => $data[ 'id' ],
                    'status' => "\"{$data[ 'colleague_set' ]}\""
                ),
            ),
                ) ;
        return \f\html::gridButton ( $buttonsParam ) ;
    }

}
