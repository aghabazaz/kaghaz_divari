<?php

class rbacView extends \f\view
{

    /** Verified * */
    public function rbacDashboard()
    {
        /* @var $dashboardWidget \f\w\dashboard */
        $dashboardWidget = \f\widgetFactory::make('dashboard') ;

        $baseUrl   = \f\ifm::app()->baseUrl . 'core/rbac/' ;
        $uploadUrl = \f\ifm::app()->uploadUrl . 'icons/ui/' ;
        $items     = array (
            array ( 'url'    => $baseUrl . 'permissions', 'title'  => \f\ifm::t('permissions'),
                'target' => '_self', 'icon'   => $uploadUrl . 'core.rbac.access.png' ),
            array ( 'url'    => $baseUrl . 'roles', 'title'  => \f\ifm::t('roles'),
                'target' => '_self',
                'icon'   => $uploadUrl . 'core.rbac.role.png' ),
                ) ;
        return $dashboardWidget->renderGrid($items) ;
    }

    /** Verified * */
    public function renderPermissionListHEAD($param = '')
    {
        return $this->render('permissionList',
                             array (
                    'param' => $param,
                )) ;
    }

    /** Verified * */
    function renderPermissionRecords($requestDataTble)
    {
        /** Get permission list * */
        $list  = \f\ttt::service('core.rbac.getPermissions',
                                 array ( 'dataTableParams' => $requestDataTble )) ;
//\f\pre($list);
        /* @var $table \f\w\table */
        $table = \f\widgetFactory::make('table') ;

        $row = $this->setPermission($list[ 'data' ]) ;

        $row[ 'total' ] = $list[ 'total' ] ;
        $row[ 'draw' ]  = $list[ 'draw' ] ;

        $listRow = $table->renderRow($row) ;
        return $listRow ;
    }

    /** Verified * */
    function renderNewPermission()
    {

        $hasFilterActions = \f\ttt::service('core.code.getActionsByFilterType',
                                            array (
                    'filterType' => 'hasFilter'
                )) ;
        //\f\pr($hasFilterActions);
        return $this->render('permissionAdd',
                             array (
                    'has_filters' => $hasFilterActions,
                )) ;
    }

    /** Verified * */
    function renderEditPermission($permissionId)
    {

        $permissionInfo = \f\ttt::service('core.rbac.permission.getPermissionInfo',
                                          array (
                    'permId' => $permissionId
                )) ;

        return $this->render('permissionEdit',
                             array (
                    'permInfo' => $permissionInfo
                )) ;
    }

    private function setPermission($list)
    {
        $formWidget = \f\widgetFactory::make('form') ;
        $row        = array () ;
        foreach ( $list as $value )
        {
            $checkbox = $formWidget->checkbox(array (
                'htmlOptions' => array (
                    'id' => 'c' . $value[ 'id' ]
                ),
                'choices'     => array ( '' => 'required' ),
                    )) ;

            $actions = $this->createActions($value) ;
            $field   = array (
                array (
                    'style'     => array (
                        'border' => 'none',
                    ),
                    'formatter' => $checkbox
                ),
                array (
                    'htmlOptions' => array (
                        'id' => 'bgparent',
                    ),
                    'style'       => array (
                        'border' => 'none'
                    ),
                    'formatter'   => $value[ 'title' ]
                ),
//                array (
//                    'htmlOptions' => array (
//                        'class' => 'tdsearch',
//                    ),
//                    'style' => array (
//                        'border'    => 'none'
//                    ),
//                    'formatter' => $value[ 'level' ]
//                ),
                array (
                    'htmlOptions' => array (
                        'class' => 'act',
                    ),
                    'style'       => array (
                        'border' => 'none'
                    ), //onclick='widgetHelper.remove(\"" . $value[ 'id' ] . "\",\"c\",\"core.user.remove\" )'
                    'formatter'   => $actions,
                )
                    ) ;
            // tr make
            // data-on-confirm='hi'
            $row[]   = array (
                'htmlOptions' => array (
                    'id'    => '',
                    'class' => 'c' . $value[ 'id' ],
                ),
                'td'          => $field
                    ) ;
        }
        return $row ;
    }

    private function createActions($permission)
    {

        $buttonsParam = array (
            array (
                'type'           => 'delete',
                'confirm'        => true,
                'action'         => 'core.rbac.removePermission',
                'clientCallback' => 'remove',
                'params'         => array (
                    'id'       => $permission[ 'id' ],
                    'selector' => "\"#c{$permission[ 'id' ]}\""
                )
            ),
            array (
                'type' => 'edit',
                'href' => \f\ifm::app()->baseUrl . "core/rbac/permissionEdit/{$permission[ 'id' ]}",
            )
                ) ;
        return \f\html::gridButton($buttonsParam) ;
    }

    public function renderMethodFilters($param)
    {

        $filters = \f\ttt::service('core.rbac.filter.getFiltersMethod',
                                   array ( 'filter_maker_id' => $param[ 'filter_maker_id' ] )) ;


        if ( $param[ 'rp_id' ] )
        {
            $row = \f\ttt::service('core.rbac.role.getRolePermissionActionFilter',
                                   array ( 'rp_id' => $param[ 'rp_id' ], 'actionid' => $param[ 'actionID' ] )) ;
            if ( $row[ 'core_filterid' ] )
            {
                $filterid = $row[ 'core_filterid' ] ;
                $rpaf_id  = $row[ 'id' ] ;
            }
        }
        else if ( $param[ 'up_id' ] )
        {
            $row = \f\ttt::service('core.rbac.users.getUserPermissionActionFilter',
                                   array ( 'up_id' => $param[ 'up_id' ], 'actionid' => $param[ 'actionID' ] )) ;
            if ( $row[ 'core_filterid' ] )
            {
                $filterid = $row[ 'core_filterid' ] ;
                $upaf_id  = $row[ 'id' ] ;
            }
        }
        else
        {
            if ( ! $param[ 'filterid' ] )
            {
                $row      = \f\ttt::service('core.rbac.getFilterPermissionAction',
                                            array ( 'id' => $param[ 'pr_id' ], 'actionid' => $param[ 'actionID' ] )) ;
                $filterid = $row[ 'core_filterid' ] ;
            }
            else
            {
                $filterid = $param[ 'filterid' ] ;
            }
        }

        return $this->render('methodFilters',
                             array ( 'filters'      => $filters, 'filter_maker' => $param[ 'filter_maker_id' ]
                    , 'actionid'     => $param[ 'actionID' ], 'filterid'     => $filterid
                    , 'path'         => $param[ 'path' ], 'filterDiv'    => $param[ 'filterDiv' ],
                    'pr_id'        => $param[ 'pr_id' ]
                    , 'rpaf_id'      => $rpaf_id, 'rp_id'        => $param[ 'rp_id' ],
                    'upaf_id'      => $upaf_id, 'up_id'        => $param[ 'up_id' ] )) ;
    }

}
