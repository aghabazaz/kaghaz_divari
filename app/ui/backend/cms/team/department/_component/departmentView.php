<?php

class departmentView extends \f\view
{

    public function renderGrid ()
    {

        return $this->render ( 'departmentList', array (
                ) ) ;
    }

    public function renderDepartmentAdd ( $id = '' )
    {

        if ( $id )
        {
            $row = \f\ttt::service ( 'cms.team.department.getDepartmentById',
                                     array (
                        'id' => $id ) ) ;

            
        }

        $department     = \f\ttt::service ( 'cms.team.department.getDepartmentByOwnerId' ) ;
        $sort[ NULL ] = \f\ifm::t ( 'mainDepartment' ) ;
        $this->sort_department ( $department, NULL, $sort ) ;

        return $this->render ( 'departmentAdd',
                               array (
                    'row'       => $row,
                    'sort'      => $sort,
                ) ) ;
    }

    public function sort_department ( $department, $parentId, &$sort )
    {
        foreach ( $department AS $data )
        {
            if ( $data[ 'parent_id' ] == $parentId )
            {
                $sort[ $data[ 'id' ] ] = $data[ 'title' ] ;
                $this->sort_department ( $department, $data[ 'id' ], $sort ) ;
            }
        }
        return $sort ;
    }

    public function renderDepartmentGrid ( $requestDataTble )
    {

        /** Get group list * */
        $this->registerGadgets ( array (
            'dateG' => 'date' ) ) ;


        $departmentList = \f\ttt::service ( 'cms.team.department.departmentList',
                                          array (
                    'dataTableParams' => $requestDataTble ) ) ;
        foreach ( $departmentList[ 'data' ] as $key => $value )
        {

            $tdContent = $this->createActionButtons ( $value, 'department' ) ;

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
                    'formatter'   => $value[ 'title' ]
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
        $row[ 'total' ] = $departmentList[ 'total' ] ;
        $row[ 'draw' ]  = $departmentList[ 'draw' ] ;
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
                'href' => \f\ifm::app ()->baseUrl . "cms.team/department/" . $section . "Edit/" . $data[ 'id' ]
            ),
            array (
                'type'           => 'status',
                'confirm'        => TRUE,
                'id'             => 's' . $data[ 'id' ],
                'status'         => $data[ 'status' ],
                'action'         => 'cms.team.department.' . $section . 'Status',
                'clientCallBack' => 'toggleEnable',
                'params'         => array (
                    'id'     => $data[ 'id' ],
                    'status' => "\"{$data[ 'status' ]}\""
                ),
            ),
            array (
                'type'           => 'delete',
                'confirm'        => true,
                'action'         => 'cms.team.department.' . $section . 'Delete',
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
