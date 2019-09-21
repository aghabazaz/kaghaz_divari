<?php

class smsTempView extends \f\view
{

    public function renderSmsTempList ()
    {
        return $this->render ( 'smsTempList', array (
                ) ) ;
    }

    public function renderSmsTempGrid ( $requestDataTble )
    {

        /** Get group list * */
        $this->registerGadgets ( array (
            'dateG' => 'date' ) ) ;

        //$this->dateG->

        $smsTempList = \f\ttt::service ( 'newsletter.templateSend.tempList',
                                           array (
                    'dataTableParams' => $requestDataTble,
                                               'type' => 'sms') ) ;
        foreach ( $smsTempList[ 'data' ] as $key => $value )
        {

            $tdsmsTemp = $this->createActionButtons ( $value, 'smsTemp' ) ;

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
                    'formatter'   => '<div style="text-align:right">' . $value[ 'title' ] . '</div>'
                ),
                array (
                    'htmlOptions' => array (
                        'id' => 'bgparent',
                    ),
                    'style'       => array (
                        'border' => 'none',
                        'color'  => 'red !important'
                    ),
                    'formatter'   => $value[ 'category' ]
                ),
                array (
                    'htmlOptions' => array (
                        'class' => 'act',
                    ),
                    'style'       => array (
                        'border' => 'none'
                    ),
                    'formatter'   => $tdsmsTemp,
                ),
                    ) ;

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
        $row[ 'total' ] = $smsTempList[ 'total' ] ;
        $row[ 'draw' ]  = $smsTempList[ 'draw' ] ;
        /* @var $table \f\w\table */
        $table          = \f\widgetFactory::make ( 'table' ) ;

        $userListRow = $table->renderRow ( $row ) ;
        return $userListRow ;
    }

    private function createActionButtons ( $data, $smsTemp )
    {
        $buttonsParam = array (
            array (
                'type' => 'edit',
                'href' => \f\ifm::app ()->baseUrl . "newsletter.templateSend/smsTemp/" . $smsTemp . "Edit/" . $data[ 'id' ]
            ),
            array (
                'type'           => 'status',
                'confirm'        => TRUE,
                'id'             => 's' . $data[ 'id' ],
                'status'         => $data[ 'status' ],
                'action'         => 'newsletter.templateSend.smsTemp.' . $smsTemp . 'Status',
                'clientCallBack' => 'toggleEnable',
                'params'         => array (
                    'id'     => $data[ 'id' ],
                    'status' => "\"{$data[ 'status' ]}\""
                ),
            ),
            array (
                'type'           => 'delete',
                'confirm'        => true,
                'action'         => 'newsletter.templateSend.smsTemp.' . $smsTemp . 'Delete',
                'clientCallback' => 'remove',
                'params'         => array (
                    'id'       => $data[ 'id' ],
                    'selector' => "\"#f{$data[ 'id' ]}\""
                )
            ),
                ) ;
        return \f\html::gridButton ( $buttonsParam ) ;
    }

    public function renderSmsTempAdd ( $id = '' )
    {
        if ( $id )
        {
            $row = \f\ttt::service ( 'newsletter.templateSend.getTempById',
                                     array (
                        'id' => $id ) ) ;
        }

        $category = \f\ttt::service ( 'newsletter.templateSend.getCategoryAll' ) ;
        foreach ( $category AS $data )
        {
            $categoryArr[ $data[ 'id' ] ] = $data[ 'title' ] ;
        }
        //\f\pre ( $categoryArr ) ;
        return $this->render ( 'smsTempAdd',
                               array (
                    'row'      => $row,
                    'category' => $categoryArr,
                    'id'       => $id,
                ) ) ;
    }

}
