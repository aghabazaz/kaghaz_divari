<?php

class measurementView extends \f\view
{

    public function renderGrid ()
    {
        return $this->render ( 'measurementList' ) ;
    }

    public function renderMeasurementGrid ( $requestDataTble )
    {
        /** Get group list * */
        $this->registerGadgets(array('dateG'=>'date'));

        $measurementList = \f\ttt::service ( 'shop.measurement.measurementList',
            array (
                'dataTableParams' => $requestDataTble) ) ;

        $this->registerGadgets(array(
            'dateG' => 'date'));

        foreach ( $measurementList[ 'data' ] as $key => $value )
        {
            $tdContent = $this->createActionButtons ( $value, 'measurement' ) ;
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
        $row[ 'total' ] = $measurementList[ 'total' ] ;
        $row[ 'draw' ]  = $measurementList[ 'draw' ] ;
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
                'href' => \f\ifm::app ()->baseUrl . "shop/measurement/" . $content . "Edit/" . $data[ 'id' ]
            ),
            array (
                'type'           => 'status',
                'confirm'        => TRUE,
                'id'             => 's' . $data[ 'id' ],
                'status'         => $data[ 'status' ],
                'action'         => 'shop.measurement.' . $content . 'Status',
                'clientCallBack' => 'toggleEnable',
                'params'         => array (
                    'id'     => $data[ 'id' ],
                    'status' => "\"{$data[ 'status' ]}\""
                ),
            ),
            array (
                'type'           => 'delete',
                'confirm'        => true,
                'action'         => 'shop.measurement.' . $content . 'Delete',
                'clientCallback' => 'remove',
                'params'         => array (
                    'id'       => $data[ 'id' ],
                    'selector' => "\"#f{$data[ 'id' ]}\""
                )
            )
                ) ;
        return \f\html::gridButton ( $buttonsParam ) ;
    }

    public function renderMeasurementAdd ( $id = '' )
    {
        if ( $id )
        {
            $row = \f\ttt::service ( 'shop.measurement.getMeasurementId',
                                     array (
                        'id' => $id ) ) ;
        }

        return $this->render ( 'measurementAdd',
                               array (
                    'row' => $row,
                ) ) ;
    }

}
