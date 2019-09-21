<?php

class roleView extends \f\view
{

    function rolesList()
    {

        return $this->render('rolesList') ;
    }

    function renderRoleGrid()
    {
        /** Get role list * */
        $list = \f\ttt::service('core.rbac.role.getRoles') ;

        /* @var $table \f\w\table */
        $table = \f\widgetFactory::make('table') ;

        $row = $this->setRole($list) ;

        $row[ 'total' ] = count($list) ;
        $row[ 'draw' ]  = 1 ;

        $listRow = $table->renderRow($row) ;
        return $listRow ;
    }

    function renderRoleAdd()
    {
        /** Get permission list * */
        $permissions = \f\ttt::service('core.rbac.getAllPermission') ;

        return $this->render('roleAdd',
                             array (
                    'permissions' => $permissions
                )) ;
    }

    function renderRoleEdit($roleId)
    {
        $roleInfo = \f\ttt::service('core.rbac.role2.getRoleInfo',
                                    array (
                    'roleId' => $roleId
                )) ;

        /** Get permission list * */
        $permissions = \f\ttt::service('core.rbac.getAllPermission') ;

        return $this->render('roleEdit',
                             array (
                    'roleInfo'    => $roleInfo,
                    'permissions' => $permissions
                )) ;
    }

    private function setRole($list)
    {
        $formWidget = \f\widgetFactory::make('form') ;
        $row        = array () ;
        if ( empty($list) )
        {
            return '' ;
        }
        foreach ( $list as $value )
        {
            $checkbox = $formWidget->checkbox(array (
                'htmlOptions' => array (
                    'id' => 'c' . $value[ 'roleId' ]
                ),
                'choices'     => array ( '' => 'required' ),
                    )) ;

            $actions = $this->createRoleBtn($value) ;
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
                    'formatter'   => $value[ 'roleTitle' ]
                ),
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
                    'class' => 'c' . $value[ 'roleId' ],
                ),
                'td'          => $field
                    ) ;
        }
        return $row ;
    }

    private function createRoleBtn($val)
    {

        $buttonsParam = array (
            array (
                'type'           => 'delete',
                'confirm'        => true,
                'action'         => 'core.rbac.removeRole',
                'clientCallback' => 'remove',
                'params'         => array (
                    'id'       => $val[ 'roleId' ],
                    'selector' => "\"#c{$val[ 'roleId' ]}\""
                )
            ),
            array (
                'type' => 'edit',
                'href' => \f\ifm::app()->baseUrl . "core/rbac/roleEdit/{$val[ 'roleId' ]}",
            )
                ) ;
        return \f\html::gridButton($buttonsParam) ;
    }

    public function renderRolePermission($param)
    {

        $has_filters = \f\ttt::service('core.code.getAllfilterActions',
                                       array ( 'type' => 'hasFilter' )) ;

        $row_ui = \f\ttt::service('core.rbac.getPermissionUI',
                                  array ( 'id' => $param[ 'permissionid' ] )) ;

        $row_action = \f\ttt::service('core.rbac.getPermissionAction',
                                      array ( 'id' => $param[ 'permissionid' ] )) ;


        if ( $param[ 'rp_id' ] )
        {
            $row_roleActionFilter = \f\ttt::service('core.rbac.role.getRoleActionFilters',
                                                    array ( 'rp_id' => $param[ 'rp_id' ] )) ;
            $row_actionExclude    = \f\ttt::service('core.rbac.role.getRolePermissionActionExcludes',
                                                    array ( 'rp_id' => $param[ 'rp_id' ] )) ;
        }
        else
        {
            $row_actionFilter = \f\ttt::service('core.rbac.getPermissionActionFilter',
                                                array ( 'permissionId' => $param[ 'permissionid' ] )) ;
        }



        return $this->render('pemissionMethods',
                             array ( 'permissionId'         => $param[ 'permissionid' ],
                    'row_ui'               => $row_ui, 'row_action'           => $row_action,
                    'has_filters'          => $has_filters,
                    'row_actionFilter'     => $row_actionFilter, 'row_actionExclude'    => $row_actionExclude,
                    'row_roleActionFilter' => $row_roleActionFilter )) ;
    }

    public function renderRolePermissionLogic($param)
    {
        $logic           = \f\ttt::service('core.rbac.getAllEnableLogics') ;
        $logicPermission = \f\ttt::service('core.rbac.getPermissionLogics',
                                           array ( 'permissionid' => $param[ 'permissionid' ] )) ;
        //$role_pr_logic = array();
        if ( $param[ 'rp_id' ] )
        {

            $role_pr_logic = \f\ttt::service('core.rbac.role.getRolePermissionLogics',
                                             array ( 'rp_id' => $param[ 'rp_id' ] )) ;
        }

        return $this->render('logicRole',
                             array ( 'permissionId'    => $param[ 'permissionid' ],
                    'act'             => $param[ 'act' ], 'logic'           => $logic,
                    'logicPermission' => $logicPermission,
                    'role_pr_logic'   => $role_pr_logic, 'rp_id'           => $param[ 'rp_id' ],
                    'roleid'          => $param[ 'roleid' ] )) ;
    }

    public function renderConfilict($param)
    {

        $actionName = array () ;
        foreach ( $param[ 'filterAction' ] as $action )
        {
            $filterMaker        = \f\ttt::service('core.rbac.filter.getfilterMaker',
                                                  array ( 'actionId' => $action )) ;
            //  if(!in_array ( $filterMaker[ 'title' ], $actionName )){
            $actionName[]       = $filterMaker[ 'title' ] ;
            // }
            $actionArr[]        = $action ;
            $filters[ $action ] = \f\ttt::service('core.rbac.filter.getFiltersMethod',
                                                  array ( 'filter_maker_id' => $filterMaker[ 'filter_maker_id' ] )) ;
        }

        return $this->render('confilictFilters',
                             array ( 'filters'    => $filters, 'actionName' => $actionName,
                    'actionArr'  => $actionArr, 'rpaf_id'    => $param[ 'rpaf_id' ],
                    'upaf_id'    => $param[ 'upaf_id' ], 'uraf_id'    => $param[ 'uraf_id' ]
                    , 'userid'     => $param[ 'userid' ], 'roleArr'    => $param[ 'roleArr' ],
                    'param'      => $param )) ;
    }

    public function renderConfilictLogicSetting($param)
    {

        $params = $param[ 'param' ] ;

        $rpl = array () ;

        if ( $params[ 'rpl_id' ] )
        {
            $plArr = $params[ 'rpl_id' ] ;
            $url   = 'core/rbac/saveConfilictLogicSetting' ;
        }

        if ( $params[ 'upl_id' ] )
        {
            $plArr = $params[ 'upl_id' ] ;
            $url   = 'core/rbac/users/saveUPConfilictLogicSetting' ;
        }

        if ( $params[ 'urpl_id' ] )
        {
            $plArr = $params[ 'urpl_id' ] ;
            $url   = 'core/rbac/users/saveURConfilictLogicSetting' ;
        }

        foreach ( $plArr as $rp )
        {
            $j = 0 ;
            foreach ( $rp as $k1 => $v1 )
            {
                //    \f\pr($k1 .'-'. $v1);
                //  if($k1 && $j < count($rp)-1){

                $rpl[ $k1 ][] = $v1 ;
                //  }
                $j ++ ;
            }
        }
        $i      = 0 ;
        $rpl_id = array () ;


        foreach ( $rpl as $k1 => $arr1 )
        {

            if ( count($arr1) > 1 )
            {
                foreach ( $arr1 as $v )
                {
                    $rpl_id[ $k1 ][] = $v ;
                }
            }
            $i ++ ;
        }

        $keys    = array () ;
        $logicid = array () ;
        foreach ( $params[ 'setting' ] as $rp )
        {
            foreach ( $rp as $k => $arr )
            {
                $i = 0 ;
                foreach ( $arr as $key => $val )
                {
                    if ( count($val) > 1 )
                    {
                        $lid              = $k ;
                        $logic            = \f\ttt::service('core.rbac.getLogic',
                                                            array ( 'id' => $k )) ;
                        $ltitle           = $logic[ 'title' ] ;
                        //   if( in_array ( $key, $keys[ $k ] )){
                        $keys[ $k ][ $i ] = $key ;
                        //  }
                    }
                    $i ++ ;
                }
                if ( $lid && ! in_array($lid, $logicid) )
                {
                    $logicid[]    = $lid ;
                    $logicTitle[] = $ltitle ;
                }
            }
        }

        return $this->render('confilictLogicSetting',
                             array ( 'logicid'    => $logicid, 'logicTitle' => $logicTitle,
                    'keys'       => $keys, 'roleid'     => $param[ 'roleid' ],
                    'rpl_id'     => $rpl_id, 'userid'     => $param[ 'userid' ],
                    'url'        => $param[ 'url' ], 'type'       => $param[ 'type' ] )) ;
    }

}
