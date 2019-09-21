<?php

/**
 * 
 * This sub component does following tasks :
 * handle role of permission service
 * 
 * @author mina hajian <mn.hajian@gmail.com>
 * @package core.rbac.role
 * @category component
 * 
 */
class roleService extends \f\service
{

    public function getRoles()
    {
        $userId  = \f\ifm::app()->getUserInfo('id') ;
        $ownerId = \f\ifm::app()->getUserInfo('owner_id') ;
        return \f\ttt::dal('core.rbac.role2.getAllRoles',
                           array (
                    'userId'  => $userId,
                    'ownerId' => $ownerId
                )) ;
    }

    public function getAllRoles()
    {
        return \f\ttt::dal('core.rbac.role.getAllRoles') ;
    }

    public function getRole()
    {
        return \f\ttt::dal('core.rbac.role.getRole',
                           array ( 'id' => $this->request->getParam('id') )) ;
    }

    public function getRolePermission()
    {
        return \f\ttt::dal('core.rbac.role.getRolePermission',
                           array ( 'roleid' => $this->request->getParam('roleId') )) ;
    }

    public function getRolePermissionLogics()
    {

        return \f\ttt::dal('core.rbac.role.getRolePermissionLogics',
                           array ( 'rp_id' => $this->request->getParam('rp_id') )) ;
    }

    public function getRolePermissionActionExcludes()
    {
        return \f\ttt::dal('core.rbac.role.getRolePermissionActionExcludes',
                           array ( 'rp_id' => $this->request->getParam('rp_id') )) ;
    }

    public function getRolePermissionActionFilter()
    {
        return \f\ttt::dal('core.rbac.role.getRolePermissionActionFilter',
                           array ( 'rp_id'    => $this->request->getParam('rp_id'),
                    'actionid' => $this->request->getParam('actionid') )) ;
    }

    public function getRoleActionFilters()
    {
        return \f\ttt::dal('core.rbac.role.getRoleActionFilters',
                           array ( 'rp_id' => $this->request->getParam('rp_id') )) ;
    }

    public function roleSave()
    {
        $params = $this->request->getAssocParams() ;

        $data[ 'id' ]    = $params[ 'id' ] ;
        $data[ 'title' ] = $params[ 'title' ] ;
        $valid           = $this->validRole($data) ;

        if ( ! is_array($valid) )
        {
            $result  = \f\ttt::dal('core.rbac.role.saveRole', $data) ;
            $roleId  = ( $data[ 'id' ] ) ? $data[ 'id' ] : $result ;
            $setting = array () ;
            for ( $i = 0 ; $i < count($params[ 'permissionId' ]) ; $i ++ )
            {
                $p_id  = $params[ 'permissionId' ][ $i ] ;
                // save role permission
                $rp_id = $this->saveRolePermission($params, $roleId, $p_id) ;

                $rpidArr[] = $rp_id ;


                if ( $params[ 'rp_id' ][ $p_id ] )
                {
                    $this->removeFunc($rp_id) ;
                }
                //save action exclude
                if ( $params[ "m_id_ex" ][ $p_id ] )
                {
                    for ( $j = 0 ; $j < count($params[ "m_id_ex" ][ $p_id ]) ; $j ++ )
                    {

                        $result = $this->saveRoleActionExclude($params[ "m_id_ex" ][ $p_id ][ $j ],
                                                               $rp_id) ;
                    }
                }

                //save rolePermissionLogic
                if ( $params[ "logic" ][ $p_id ] )
                {
                    $setting = $this->saveRoleLogic($params, $rp_id, $p_id,
                                                    $roleId, $setting) ;
                }

                if ( $params[ "logic_hid" ][ $p_id ] )
                {
                    for ( $k = 0 ; $k < count($params[ "logic_hid" ][ $p_id ]) ; $k ++ )
                    {
                        $lid = $params[ "logic_hid" ][ $p_id ][ $k ] ;

                        $rpl_id = false ;
                        if ( $lid )
                        {
                            $result = $this->saveRolePermissionLogic($lid,
                                                                     $rp_id,
                                                                     $params[ "order_hid" ][ $p_id ][ $lid ],
                                                                     $rpl_id) ;
                        }

                        $rpl_id             = $result ;
                        $paramL[ 'params' ] = array ( 'rlogicid' => $lid, 'roleid' => $roleId ) ;
                        $res1               = \f\ttt::service('core.setting.getKeyGroupPart',
                                                              $paramL) ;
                        if ( $res1 )
                        {
                            $setting[ 'setting' ][ $rp_id ][ $lid ] = \f\ttt::service('core.setting.getKeyGroupPart',
                                                                                      $paramL) ;

                            $setting[ 'rpl_id' ][ $rp_id ][ $lid ] = $rpl_id ;
                        }
                    }
                }
            }

            if ( $result )
            {
                if ( $params[ 'action_filterid' ] )
                {
                    if ( count($rpidArr) > 1 )
                    {
                        $item[ 'conflict' ] = $this->checkConflict($params,
                                                                   $rpidArr,
                                                                   $roleId) ;
                    }
                    else
                    {
                        $item[ 'conflict' ] = false ;
                    }
                }
                if ( $setting )
                {
                    $item[ 'logicSetting' ] = $this->checkConflictLogic($setting) ;
                }
                else
                {
                    $item[ 'logicSetting' ] = false ;
                }

                $item[ 'roleid' ] = $roleId ;

                if ( ! $item[ 'conflict' ] && ! $item[ 'logicSetting' ] )
                {
                    $out = array ( 'success', \f\ifm::t('successSave') ) ;
                }
                else
                {
                    $out = array ( 'func' => 'renderConfilict', 'params' => $item ) ;
                }
            }
            else
            {
                $out = array ( 'error', \f\ifm::t('errorDB') ) ;
            }
        }
        else
        {
            $out = array ( 'error', $valid ) ;
        }
        return $out ;
    }

    private function checkConflictLogic($param)
    {

        foreach ( $param[ 'setting' ] as $rp )
        {
            foreach ( $rp as $k => $arr )
            {

                foreach ( $arr as $key => $val )
                {

                    if ( count($val) > 1 )
                    {

                        for ( $i = 0 ; $i < count($val) ; $i ++ )
                        {

                            if ( ($val[ $i + 1 ]) && ($val[ $i ] != $val[ $i + 1 ]) )
                            {
                                return $param ;
                            }
                        }
                    }
                }
            }
        }

        return false ;
    }

    private function saveRolePermission($params, $roleId, $p_id)
    {

        $arr[ 'id' ]                = $params[ 'rp_id' ][ $p_id ] ;
        $arr[ 'core_roleid' ]       = $roleId ;
        $arr[ 'core_permissionid' ] = $p_id ;
//\f\pr($arr);
        $result                     = \f\ttt::dal('core.rbac.role.saveRolePermission',
                                                  $arr) ;

        $rp_id = ( $arr[ 'id' ] ) ? $arr[ 'id' ] : $result ;
        return $rp_id ;
    }

    private function saveRoleLogic($params, $rp_id, $p_id, $roleId, $setting)
    {
        for ( $k = 0 ; $k < count($params[ "logic" ][ $p_id ]) ; $k ++ )
        {
            $lid = $params[ "logic" ][ $p_id ][ $k ] ;

            $rpl_id = ($params[ 'rpl_id' ][ $p_id ][ $lid ]) ? $params[ 'rpl_id' ][ $p_id ][ $lid ] : false ;

            $rpl[]              = $rpl_id ;
            $result             = $this->saveRolePermissionLogic($lid, $rp_id,
                                                                 $params[ "order" ][ $p_id ][ $lid ],
                                                                 $rpl_id) ;
            $rpl_id             = ($rpl_id) ? $rpl_id : $result ;
            $paramL[ 'params' ] = array ( 'rlogicid' => $lid, 'roleid' => $roleId ) ;

            $res = \f\ttt::service('core.setting.getKeyGroupPart', $paramL) ;

            if ( $res )
            {
                $setting[ 'setting' ][ $rp_id ][ $lid ] = $res ;
                $setting[ 'rpl_id' ][ $rp_id ][ $lid ]  = $rpl_id ;
            }
        }
        $this->removeRolePermissionLogic($rp_id, $rpl) ;

        return $setting ;
    }

    private function removeRolePermissionLogic($rp_id, $rpl)
    {

        $res = \f\ttt::dal('core.rbac.role.getRolePermissionLogicRemoved',
                           array ( 'rp_id' => $rp_id, 'rpl' => $rpl )) ;

        foreach ( $res as $data )
        {
            $res = \f\ttt::dal('core.rbac.role.removeRolePermissionLogic',
                               array ( 'rpl_id' => $data[ 'id' ] )) ;

            $arr[ 'params' ] = array ( 'RPL_ID' => $data[ 'id' ] ) ;


            \f\ttt::service('core.setting.deleteKeyGroup', $arr) ;
        }
    }

    private function removeFunc($rp_id)
    {
        $res = \f\ttt::dal('core.rbac.role.removeRoleActionExclude',
                           array ( 'rp_id' => $rp_id )) ;
        return $res ;
    }

    private function checkConflict($params, $rpidArr, $roleId)
    {

        $filters     = $params[ 'action_filterid' ] ;
        $rpaf_id     = $params[ 'rpaf_id' ] ;
        $filter_prid = $params[ 'filter_prid' ] ;

        $action = array () ;
        $conf   = 'not_conf' ;
        if ( $filters )
        {

            foreach ( $filters as $val )
            {
                $arr = explode('-', $val) ;

                $data[ $arr[ 0 ] ][] = $arr[ 1 ] ;

                if ( count($data[ $arr[ 0 ] ]) > 1 && ! in_array($arr[ 0 ],
                                                                 $action) )
                {
                    $action[] = $arr[ 0 ] ;
                }
                $actArr[]    = $arr[ 0 ] ;
                $filterArr[] = $arr[ 1 ] ;
            }
            $i = 0 ;

            foreach ( $data as $arr )
            {

                if ( count($data[ $actArr[ $i ] ]) == 1 )
                {
                    $newActions[] = $actArr[ $i ] ;
                    $filter[]     = $filterArr[ $i ] ;
                    $rpafArr[]    = $rpaf_id[ $i ] ;
                    unset($filter_prid[ $i ]) ;
                }
                else
                {
                    if ( $arr[ $i + 1 ] && ($arr[ $i ] != $arr[ $i + 1 ]) )
                    {
                        $conf = 'conf' ;
                    }
                }
                $i ++ ;
            }
        }

        if ( $newActions )
        {
            $res = $this->saveRoleFilter($newActions, $filter, $rpafArr,
                                         $rpidArr) ;
        }

//\f\pr($action);
        if ( $conf == 'conf' && is_array($params[ 'permissionId' ]) )
        {

            $param[ 'filterConflict' ] = $data ;
            $param[ 'filterAction' ]   = $action ;
            $param[ 'rpaf_id' ]        = $rpaf_id ;
            $param[ 'rpidArr' ]        = $rpidArr ;
            $param[ 'roleId' ]         = $roleId ;
            $param[ 'prArr' ]          = $filter_prid ;
            return $param ;
        }
        else
        {
            $res = $this->saveRoleFilter($action, $data, $rpaf_id, $rpidArr) ;
            return false ;
        }
    }

    private function saveRoleActionExclude($m_ex, $rp_id)
    {
        $data[ 'core_actionid' ]          = $m_ex ;
        $data[ 'core_role_permissionid' ] = $rp_id ;

        $result = \f\ttt::dal('core.rbac.role.saveRoleActionExclude', $data) ;
        return $result ;
    }

    private function saveRolePermissionLogic($logicid, $rp_id, $order, $rpl_id)
    {
        $rpl_id = ( $rpl_id ) ? $rpl_id : '' ;

        $data[ 'id' ]                     = $rpl_id ;
        $data[ 'core_plogicid' ]          = $logicid ;
        $data[ 'core_role_permissionid' ] = $rp_id ;
        $data[ 'rpl_order' ]              = $order ;

        $result = \f\ttt::dal('core.rbac.role.saveRolePermissionLogic', $data) ;
        return $result ;
    }

    private function saveRoleFilter($actions, $filters, $rpaf_id, $rpidArr)
    {

        for ( $i = 0 ; $i < count($actions) ; $i ++ )
        {
            $data[ 'id' ]            = $rpaf_id[ $i ] ;
            $data[ 'core_filterid' ] = $filters[ $i ] ;
            $data[ 'core_actionid' ] = $actions[ $i ] ;
            if ( ! $data[ 'id' ] )
            {
                $rp = \f\ttt::dal('core.rbac.role.getRolePermissionViaAction',
                                  array ( 'actionid' => $actions[ $i ] )) ;

                foreach ( $rp as $row )
                {
                    if ( in_array($row[ 'id' ], $rpidArr) )
                    {
                        $data[ 'core_role_permissionid' ] = $row[ 'id' ] ;
                        $result                           = \f\ttt::dal('core.rbac.role.saveRolePermissionActionFilter',
                                                                        $data) ;
                    }
                }
            }
            else
            {
                $result = \f\ttt::dal('core.rbac.role.saveRolePermissionActionFilter',
                                      $data) ;
            }
        }
    }

    public function saveConfilictFilterRole()
    {
        $params = $this->request->getAssocParams() ;

        for ( $i = 0 ; $i < count($params[ 'c_actionid' ]) ; $i ++ )
        {
            //  $data[ 'id' ]            = $params[ 'c_rpaf_id' ][ $i ] ;
            $data[ 'core_filterid' ] = $params[ 'c_filterid' ][ $i ] ;
            $data[ 'core_actionid' ] = $params[ 'c_actionid' ][ $i ] ;

            $rp = \f\ttt::dal('core.rbac.role.getRolePermissionViaAction',
                              array ( 'actionid' => $params[ 'c_actionid' ][ $i ],
                        'roleid'   => $params[ 'c_roleid' ] )) ;

            foreach ( $rp as $row )
            {

                if ( in_array($row[ 'core_permissionid' ], $params[ 'c_prid' ]) )
                {
                    $data[ 'core_role_permissionid' ] = $row[ 'id' ] ;
                    \f\ttt::dal('core.rbac.role.removeRPAFilter',
                                array ( 'rp_id' => $row[ 'id' ], 'actionid' => $data[ 'core_actionid' ] )) ;

                    $data[ 'id' ] = '' ;

                    $result = \f\ttt::dal('core.rbac.role.saveRolePermissionActionFilter',
                                          $data) ;
                }
            }
        }

        if ( $result )
        {
            return array ( 'success', \f\ifm::t('successSave') ) ;
        }
        else
        {
            return array ( 'error', \f\ifm::t('errorDB') ) ;
        }
    }

    public function saveConfilictLogicSetting()
    {
        $params = $this->request->getAssocParams() ;
        //$out = false;
        foreach ( $params[ 'logicid' ] as $logicid )
        {
            foreach ( $params[ 'rpl_id' ][ $logicid ] as $rpl )
            {
                $item[ 'params' ] = array ( 'RPL_ID' => $rpl ) ;
                \f\ttt::service('core.setting.deleteKeyGroup', $item) ;

                $this->saveRoleParamLogic($params[ 'setting' ][ $logicid ],
                                          $rpl, $params[ 'roleid' ], $logicid) ;
                $out = array ( 'success', \f\ifm::t('successSave') ) ;
            }
        }


        return $out ;
    }

    public function RolePermissionLogicParamSave()
    {

        $params     = $this->request->getAssocParams() ;
        $validParam = $this->validParam($params[ 'setting' ]) ;
        if ( ! is_array($valid) )
        {
            $paramL[ 'params' ] = array ( 'rlogicid' => $params[ 'core_plogicid' ],
                'roleid'   => $params[ 'roleid' ] ) ;

            $res = \f\ttt::service('core.setting.getKeyGroupPart', $paramL) ;

            $ret = 'no_conf' ;
            if ( $res )
            {

                $lid     = $params[ 'core_plogicid' ] ;
                $rp_id   = $params[ 'core_permissionid' ] ;
                $setting = $res ;

                foreach ( $setting as $key => $arr )
                {
                    foreach ( $arr as $val )
                    {
                        if ( $params[ 'setting' ][ $key ] != $val )
                        {

                            $ret = 'conf' ;
                            break ;
                        }
                    }
                }
            }

            if ( $ret == 'no_conf' )
            {
                if ( $params[ 'pl_id' ] )
                {

                    $this->saveRoleParamLogic($params[ 'setting' ],
                                              $params[ 'pl_id' ],
                                              $params[ 'roleid' ],
                                              $params[ 'core_plogicid' ]) ;
                    $out = array ( 'success', \f\ifm::t('successSave') ) ;
                }
                else
                {

                    $rpl_id = false ;
                    $result = $this->saveRolePermissionLogic($params[ 'core_plogicid' ],
                                                             $params[ 'core_permissionid' ],
                                                             $params[ 'order' ],
                                                             $rpl_id) ;
                    if ( $result )
                    {
                        $rpl_id = $result ;
                        $this->saveRoleParamLogic($params[ 'setting' ], $rpl_id,
                                                  $params[ 'roleid' ],
                                                  $params[ 'core_plogicid' ]) ;
                        $out    = array ( 'success', \f\ifm::t('successSave') ) ;
                    }
                }
            }
            else
            {
                $out = array ( 'error', \f\ifm::t('confilictLogicMsg') ) ;
            }
        }
        else
        {
            $out = array ( 'error', $validParam ) ;
        }
        return $out ;
    }

    private function saveRoleParamLogic($setting, $rpl_id, $roleid, $logicid)
    {

        foreach ( $setting as $key => $value )
        {
            $data[ 'keyValues' ][ $key ] = $value ;
        }

        $data[ 'params' ] = array ( 'RPL_ID' => $rpl_id, 'roleid' => $roleid, 'rlogicid' => $logicid ) ;

        \f\ttt::service('core.setting.saveKeyGroup', $data) ;
    }

    public function removeRole()
    {
        $roleid = $this->request->getParam('id') ;
        $rp     = \f\ttt::dal('core.rbac.role.getRolePermission',
                              array ( 'roleid' => $roleid )) ;

        if ( $rp )
        {
            foreach ( $rp as $row )
            {
                $result = \f\ttt::dal('core.rbac.role.roleExcludeRemove',
                                      array ( 'rp_id' => $row[ 'id' ] )) ;
            }
        }


        $result = \f\ttt::dal('core.rbac.role.roleRemove',
                              array ( 'id' => $roleid )) ;

        if ( $result )
        {
            return array (
                'func' => 'remove'
                    ) ;
        }

        return false ;
    }

    private function validParam($params)
    {
        /* @var $validator \f\g\validator */
        $validator   = \f\gadgetFactory::make('validator') ;
        $paramGroupV = array (
            'defult'  => array (
            ),
            'objects' => array (
                array (
                    'rule'   => array (
                        array (
                            'name' => 'checkEmpty'
                        )
                    ),
                    'object' => array ( $params[ 'value' ] )
                )
            ),
            'objects' => array (
                array (
                    'rule'   => array (
                        array (
                            'name' => 'checkEmpty'
                        )
                    ),
                    'object' => array ( $params[ 'time' ] )
                )
            )
                ) ;
        if ( $validator->group($paramGroupV) === false )
        {
            return $validator->getMessage() ;
        }
        else
        {
            return true ;
        }
    }

    private function validRole($params)
    {
        /* @var $validator \f\g\validator */
        $validator   = \f\gadgetFactory::make('validator') ;
        $paramGroupV = array (
            'defult'  => array (
            ),
            'objects' => array (
                array (
                    'rule'   => array (
                        array (
                            'name' => 'checkEmpty'
                        )
                    ),
                    'object' => array ( $params[ 'title' ] )
                )
            )
                ) ;
        if ( $validator->group($paramGroupV) === false )
        {
            return $validator->getMessage() ;
        }
        else
        {
            return true ;
        }
    }

}
