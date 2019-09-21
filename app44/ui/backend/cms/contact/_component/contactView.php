<?php

class contactView extends \f\view
{

    public function renderGrid ()
    {

        return $this->render ( 'contactList', array (
                ) ) ;
    }

    public function renderContactGrid ( $requestDataTble )
    {

        /** Get group list * */
        $this->registerGadgets ( array ( 'dateG' => 'date' ) ) ;


        $contactList = \f\ttt::service ( 'cms.contact.contactList',
                                         array (
                    'dataTableParams' => $requestDataTble ) ) ;

        foreach ( $contactList[ 'data' ] as $key => $value )
        {

            $tdContent = $this->createActionButtons ( $value, 'contact' ) ;


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
                    'formatter' => '<div style="text-align:right;">' . $value[ 'name' ] . '</div>'
                ),
                array (
                    'htmlOptions' => array (
                        'id'    => 'bgparent',
                    ),
                    'style' => array (
                        'border'    => 'none',
                        'color'     => 'red !important'
                    ),
                    'formatter' => '<div style="text-align:right;font:12px tahoma">' . $value[ 'email' ] . '</div>'
                ),
                array (
                    'htmlOptions' => array (
                        'id'    => 'bgparent',
                    ),
                    'style' => array (
                        'border'    => 'none',
                        'color'     => 'red !important'
                    ),
                    'formatter' => '<div style="text-align:right">' . nl2br ( $value[ 'message' ] ) . '</div>'
                ),
                array (
                    'htmlOptions' => array (
                        'class' => 'tdsearch',
                    ),
                    'style' => array (
                        'border'    => 'none'
                    ),
                    'formatter' => $this->dateG->dateTime ( $value[ 'date_register' ],
                                                            2 ) . '<br>' . date ( 'H:i',
                                                                                  $value[ 'date_register' ] )
                ),
                array (
                    'htmlOptions' => array (
                        'class' => 'act',
                    ),
                    'style' => array (
                        'border'    => 'none'
                    ), //onclick='widgetHelper.remove(\"" . $value[ 'id' ] . "\",\"c\",\"core.user.remove\" )'
                    'formatter' => $tdContent . $this->answerBtn ($value),
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
        $row[ 'total' ] = $contactList[ 'total' ] ;
        $row[ 'draw' ]  = $contactList[ 'draw' ] ;
        /* @var $table \f\w\table */
        $table          = \f\widgetFactory::make ( 'table' ) ;

        $userListRow = $table->renderRow ( $row ) ;
        return $userListRow ;
    }

    private function createActionButtons ( $data, $section )
    {
        $buttonsParam = array (
            array (
                'type'           => 'delete',
                'confirm'        => true,
                'action'         => 'cms.contact.' . $section . 'Delete',
                'clientCallback' => 'remove',
                'params'         => array (
                    'id'       => $data[ 'id' ],
                    'selector' => "\"#f{$data[ 'id' ]}\""
                )
            ),
                ) ;
        return \f\html::gridButton ( $buttonsParam ) ;
    }

    private function answerBtn ($data)
    {
        //\f\pr($data);
        $btn = \f\html::readyMarkup ( 'a', '<i class="fa fa-edit fa-lg "></i> ',
                                      array (
                    'htmlOptions' => array (
                        'id'     => 'taskBtn' . $data[ 'id' ]
                    ),
                    'action' => array (
                        'display' => 'dialog',
                        'params'  => array (
                            'targetRoute'    => "cms.contact.answerToComment",
                            'triggerElement' => 'taskBtn' . $data[ 'id' ], //chanage
                            'dialogTitle'    => \f\ifm::t ( "answer" ),
                            'ajaxParams'     => array (
                                'id'        => $data[ 'id' ],
                                'email' => $data[ 'email' ],
                                'name' => $data[ 'name' ],
                                'message' => $data[ 'message' ]
                            )
                        ) ),
                    'style'     => array (
                        'cursor' => 'pointer' )
                        ), TRUE ) ;

        return $btn ;
    }
    
    public function renderAnswerToComment($params)
    {
        return $this->render('answerForm', $params);
    }

}
