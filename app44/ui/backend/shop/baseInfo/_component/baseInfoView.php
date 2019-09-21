<?php

class baseInfoView extends \f\view
{

    private $baseInfoGroup ;

    public function __construct ()
    {
        $this->baseInfoGroup = array (
            'projectStatus'     => \f\ifm::t ( 'projectStatus' ),
            'projectVersionStatus'     => \f\ifm::t ( 'projectVersionStatus' ),
            'job'     => \f\ifm::t ( 'job' ),
            'priority'     => \f\ifm::t ( 'priority' ),
            'activityType' => \f\ifm::t ( 'activityType' ),
            'taskType' => \f\ifm::t ( 'taskType' ),
            'taskStatus' => \f\ifm::t ( 'taskStatus' ),
        ) ;
    }

    public function renderBaseInfoList ()
    {

        return $this->render ( 'baseInfoList', array () ) ;
    }

    public function renderBaseInfoGrid ( $requestDataTble )
    {

        /** Get group list * */
        $awardList = \f\ttt::service ( 'shop.baseInfo.baseInfoList',
                                       array (
                    'dataTableParams' => $requestDataTble ) ) ;

        foreach ( $awardList[ 'data' ] as $key => $value )
        {

            $tdContent = $this->createActionButtons ( $value, 'baseInfo' ) ;


            $field  = array (
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
                    'formatter'   => $value[ 'title' ]
                ),
                array (
                    'htmlOptions' => array (
                        'class' => 'tdsearch',
                    ),
                    'style'       => array (
                        'border' => 'none'
                    ),
                    'formatter'   => \f\ifm::t ( $value[ 'group_id' ] )
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
        $row[ 'total' ] = $awardList[ 'total' ] ;
        $row[ 'draw' ]  = $awardList[ 'draw' ] ;
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
                'href' => \f\ifm::app ()->baseUrl . "shop/baseInfo/" . $section . "Edit/" . $data[ 'id' ]
            ),
            array (
                'type'           => 'status',
                'confirm'        => TRUE,
                'id'             => 's' . $data[ 'id' ],
                'status'         => $data[ 'status' ],
                'action'         => 'shop.baseInfo.' . $section . 'Status',
                'clientCallBack' => 'toggleEnable',
                'params'         => array (
                    'id'     => $data[ 'id' ],
                    'status' => "\"{$data[ 'status' ]}\""
                ),
            ),
            array (
                'type'           => 'delete',
                'confirm'        => true,
                'action'         => 'shop.baseInfo.' . $section . 'Delete',
                'clientCallback' => 'remove',
                'params'         => array (
                    'id'       => $data[ 'id' ],
                    'selector' => "\"#f{$data[ 'id' ]}\""
                )
            ),
                ) ;
        return \f\html::gridButton ( $buttonsParam ) ;
    }

    public function renderBaseInfoAdd ( $id = '' )
    {

        if ( $id )
        {
            $row = \f\ttt::service ( 'shop.baseInfo.getBaseInfoById',
                                     array (
                        'id' => $id ) ) ;
        }

        return $this->render ( 'baseInfoAdd',
                               array (
                    'row'   => $row,
                    'group' => $this->baseInfoGroup
                ) ) ;
    }

}
