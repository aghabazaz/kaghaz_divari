<?php

class personnelView extends \f\view
{

    public function renderpersonnelList ()
    {
        return $this->render ( 'personnelList', array (
                ) ) ;
    }

    public function renderpersonnelGrid ( $requestDataTble )
    {

        /** Get group list * */
        $this->registerGadgets ( array (
            'dateG' => 'date' ) ) ;

        //$this->dateG->


        $personnelList = \f\ttt::service ( 'cms.team.personnel.personnelList',
                                       array (
                    'dataTableParams' => $requestDataTble ) ) ;

        foreach ( $personnelList[ 'data' ] as $key => $value )
        {

            $tdpersonnel = $this->createActionButtons ( $value, 'personnel' ) ;


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
                    'formatter'   => '<div style="text-align:right">' . $value[ 'name' ] . '</div>'
                ),
                array (
                    'htmlOptions' => array (
                        'class' => 'tdsearch',
                    ),
                    'style'       => array (
                        'border' => 'none'
                    ),
                    'formatter'   => $this->dateG->dateTime ( $value[ 'date_register' ],
                                                              2 ) . ' ساعت : ' . date ( 'H:i',
                                                                                        $value[ 'date_register' ] )
                ),
                array (
                    'htmlOptions' => array (
                        'class' => 'act',
                    ),
                    'style'       => array (
                        'border' => 'none'
                    ),
                    'formatter'   => $tdpersonnel,
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
        $row[ 'total' ] = $personnelList[ 'total' ] ;
        $row[ 'draw' ]  = $personnelList[ 'draw' ] ;
        /* @var $table \f\w\table */
        $table          = \f\widgetFactory::make ( 'table' ) ;

        $userListRow = $table->renderRow ( $row ) ;
        return $userListRow ;
    }

    private function createActionButtons ( $data, $personnel )
    {
        $buttonsParam = array (
            array (
                'type' => 'edit',
                'href' => \f\ifm::app ()->baseUrl . "cms/team/personnel/" . $personnel . "Edit/" . $data[ 'id' ]
            ),
            array (
                'type'           => 'status',
                'confirm'        => TRUE,
                'id'             => 's' . $data[ 'id' ],
                'status'         => $data[ 'status' ],
                'action'         => 'cms.team.personnel.' . $personnel . 'Status',
                'clientCallBack' => 'toggleEnable',
                'params'         => array (
                    'id'     => $data[ 'id' ],
                    'status' => "\"{$data[ 'status' ]}\""
                ),
            ),
            array (
                'type'           => 'delete',
                'confirm'        => true,
                'action'         => 'cms.team.personnel.' . $personnel . 'Delete',
                'clientCallback' => 'remove',
                'params'         => array (
                    'id'       => $data[ 'id' ],
                    'selector' => "\"#f{$data[ 'id' ]}\""
                )
            )
                ) ;
        return \f\html::gridButton ( $buttonsParam ) ;
    }

    public function renderpersonnelAdd ( $id = '' )
    {
        if ( $id )
        {
            $row = \f\ttt::service ( 'cms.team.personnel.getPersonnelById',
                                     array (
                        'id' => $id ) ) ;
        }


        $category = \f\ttt::service ( 'cms.team.department.getDepartmentByOwnerId' ) ;
        foreach ( $category AS $data )
        {
            $categoryArr[ $data[ 'id' ] ] = $data[ 'title' ] ;
        }


        return $this->render ( 'personnelAdd',
                               array (
                    'row'      => $row,
                    'category' => $categoryArr,
                    'id'       => $id
                ) ) ;
    }

   

}
