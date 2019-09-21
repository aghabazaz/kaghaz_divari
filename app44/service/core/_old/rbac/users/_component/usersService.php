<?php

/**
 * 
 * This sub component does following tasks :
 * handle user of permission service
 * 
 * @author mina hajian <mn.hajian@gmail.com>
 * @package core.rbac.user
 * @category component
 * 
 */
class usersService extends \f\service
{

    public function getUserPermission ()
    {

        return \f\ttt::dal ( 'core.rbac.users.getUserPermission',
                             array ( 'userid' => $this->request->getParam ( 'userid' ) ) ) ;
    }

    public function getUserRoles ()
    {
        return \f\ttt::dal ( 'core.rbac.users.getUserRoles',
                             array ( 'userid' => $this->request->getParam ( 'userid' ) ) ) ;
    }

    public function getUserPermissionLogics ()
    {

        return \f\ttt::dal ( 'core.rbac.users.getUserPermissionLogics',
                             array ( 'up_id' => $this->request->getParam ( 'up_id' ) ) ) ;
    }

    public function getURPLogics ()
    {
        return \f\ttt::dal ( 'core.rbac.users.getURPLogics',
                             array ( 'ur_id' => $this->request->getParam ( 'ur_id' ) ) ) ;
    }

    public function getUserPermissionActionExcludes ()
    {
        return \f\ttt::dal ( 'core.rbac.users.getUserPermissionActionExcludes',
                             array ( 'up_id' => $this->request->getParam ( 'up_id' ) ) ) ;
    }

    public function getURActionExcludes ()
    {
        return \f\ttt::dal ( 'core.rbac.users.getURActionExcludes',
                             array ( 'ur_id' => $this->request->getParam ( 'ur_id' ) ) ) ;
    }

    public function getURPExcludes ()
    {
        return \f\ttt::dal ( 'core.rbac.users.getURPExcludes',
                             array ( 'ur_id' => $this->request->getParam ( 'ur_id' ) ) ) ;
    }

    public function getUserPermissionActionFilter ()
    {
        return \f\ttt::dal ( 'core.rbac.users.getUserPermissionActionFilter',
                             array ( 'up_id'    => $this->request->getParam ( 'up_id' ), 'actionid' => $this->request->getParam ( 'actionid' ) ) ) ;
    }

    public function getUserActionFilters ()
    {
        return \f\ttt::dal ( 'core.rbac.users.getUserActionFilters',
                             array ( 'up_id' => $this->request->getParam ( 'up_id' ) ) ) ;
    }

    public function getURActionFilters ()
    {
        return \f\ttt::dal ( 'core.rbac.users.getURActionFilters',
                             array ( 'ur_id' => $this->request->getParam ( 'ur_id' ) ) ) ;
    }

    public function getURActionFilter ()
    {
        return \f\ttt::dal ( 'core.rbac.users.getURActionFilter',
                             array ( 'ur_id'    => $this->request->getParam ( 'ur_id' ), 'actionid' => $this->request->getParam ( 'actionid' ) ) ) ;
    }

    public function permissionUserSave ()
    {
        $params = $this->request->getAssocParams () ;

        $userId  = $params[ 'userid' ] ;
        $setting = array ( ) ;
        if ( count ( $params[ 'permissionId' ] ) > 0 )
        {
            for ( $i = 0 ; $i < count ( $params[ 'permissionId' ] ) ; $i ++  )
            {
                $p_id  = $params[ 'permissionId' ][ $i ] ;
                // save user permission
                $up_id = $this->saveUserPermission ( $params, $userId, $p_id ) ;

                $upidArr[ ] = $up_id ;


                if ( $params[ 'up_id' ][ $p_id ] )
                {
                    $this->removeFunc ( $up_id ) ;
                }
                //save action exclude
                if ( $params[ "m_id_ex" ][ $p_id ] )
                {
                    for ( $j = 0 ; $j < count ( $params[ "m_id_ex" ][ $p_id ] ) ; $j ++  )
                    {

                        $result = $this->saveUserActionExclude ( $params[ "m_id_ex" ][ $p_id ][ $j ],
                                                                 $up_id ) ;
                    }
                }
                //save userPermissionLogic
                if ( $params[ "logic" ][ $p_id ] )
                {
                    $setting = $this->saveUserLogic ( $params, $up_id, $p_id,
                                                      $userId, $setting ) ;
                }
                if ( $params[ "logic_hid" ][ $p_id ] )
                {
                    for ( $k = 0 ; $k < count ( $params[ "logic_hid" ][ $p_id ] ) ; $k ++  )
                    {
                        $lid = $params[ "logic_hid" ][ $p_id ][ $k ] ;

                        $upl_id = false ;
                        if ( $lid )
                        {
                            $result             = $this->saveUserPermissionLogic ( $lid,
                                                                                   $up_id,
                                                                                   $params[ "order_hid" ][ $p_id ][ $lid ],
                                                                                   $upl_id ) ;
                        }
                        $upl_id             = $result ;
                        $paramL[ 'params' ] = array ( 'logicid' => $lid ) ;

                        $res1 = \f\ttt::service ( 'core.setting.getKeyGroupPart',
                                                  $paramL ) ;
                        if ( $res1 )
                        {
                            $setting[ 'setting' ][ $up_id ][ $lid ] = $res1 ;
                            $setting[ 'upl_id' ][ $up_id ][ $lid ]  = $upl_id ;
                        }
                    }
                }
            }

            if ( $up_id )
            {
                if ( $params[ 'action_filterid' ] )
                {
                    if ( count ( $upidArr ) > 1 )
                    {
                        $item[ 'conflict' ] = $this->checkConflict ( $params,
                                                                     $upidArr,$userId ) ;
                    }
                    else
                    {
                        $item[ 'conflict' ] = false ;
                    }
                }

                if ( ! empty ( $setting ) )
                {
                    $item[ 'logicSetting' ] = $this->checkConflictLogic ( $setting ) ;
                }
                else
                {
                    $item[ 'logicSetting' ] = false ;
                }

                $item[ 'userid' ] = $userId ;

                if ( ! $item[ 'conflict' ] && ! $item[ 'logicSetting' ] )
                {
                    $out = array ( 'success', \f\ifm::t ( 'successSave' ) ) ;
                }
                else
                {
                    $out = array ( 'func'   => 'renderConfilict', 'params' => $item ) ;
                }
            }
            else
            {
                $out = array ( 'error', \f\ifm::t ( 'errorDB' ) ) ;
            }
        }
        else
        {
            $out = array ( 'error', \f\ifm::t ( 'requiredPermission' ) ) ;
        }


        return $out ;
    }

    public function userRoleSave ()
    {
        $params = $this->request->getAssocParams () ;
        $userId = $params[ 'userid' ] ;

        if ( count ( $params[ 'roleId' ] ) > 0 )
        {
            for ( $i = 0 ; $i < count ( $params[ 'roleId' ] ) ; $i ++  )
            {
                $roleid = $params[ 'roleId' ][ $i ] ;

                // save user Role
                $ur_id = $this->saveUserRole ( $params[ 'ur_id' ][ $roleid ],
                                               $userId, $roleid ) ;

                $uridArr[ ] = $ur_id ;

                if ( $params[ 'ur_id' ][ $roleid ] )
                {
                    $this->removeURPExclude ( ur_id ) ;
                }

                //save permission exclude
                if ( $params[ "pr_id_ex" ][ $roleid ] )
                {
                    for ( $j = 0 ; $j < count ( $params[ "pr_id_ex" ][ $roleid ] ) ; $j ++  )
                    {

                        $result = $this->saveURPExclude ( $params[ "pr_id_ex" ][ $roleid ][ $j ],
                                                          $ur_id ) ;
                    }
                }

                $setting = $this->saveURPFunc ( $params, $roleid, $ur_id,
                                                $userId ) ;
            }

            if ( $ur_id )
            {

                if ( $params[ 'action_filterid' ] )
                {


                    $item[ 'conflict' ] = $this->checkConflictFilterUR ( $params,
                                                                         $uridArr,
                                                                         $userId ) ;
                }

                if ( ! empty ( $setting ) )
                {
                    $item[ 'logicSetting' ] = $this->checkConflictLogic ( $setting ) ;
                }
                else
                {
                    $item[ 'logicSetting' ] = false ;
                }

                $item[ 'userid' ] = $userId ;

                if ( ! $item[ 'conflict' ] && ! $item[ 'logicSetting' ] )
                {
                    $out = array ( 'success', \f\ifm::t ( 'successSave' ) ) ;
                }
                else
                {
                    $out = array ( 'func'   => 'renderConfilict', 'params' => $item ) ;
                }
            }
            else
            {
                $out = array ( 'error', \f\ifm::t ( 'errorDB' ) ) ;
            }
        }
        else
        {
            $out = array ( 'error', \f\ifm::t ( 'requiredRole' ) ) ;
        }


        return $out ;
    }

    private function saveURPFunc ( $params, $roleid, $ur_id, $userId )
    {

        $setting = array ( ) ;
        if ( count ( $params[ 'permissionId' ][ $roleid ] ) > 0 )
        {
            for ( $i = 0 ; $i < count ( $params[ 'permissionId' ][ $roleid ] ) ; $i ++  )
            {
                $p_id = $params[ 'permissionId' ][ $roleid ][ $i ] ;
                if ( $params[ 'ur_id' ][ $roleid ] )
                {
                    $this->removeUR_actionExclude ( $ur_id ) ;
                }

                //save action exclude
                if ( $params[ "m_id_ex" ][ $p_id ] )
                {

                    for ( $j = 0 ; $j < count ( $params[ "m_id_ex" ][ $p_id ] ) ; $j ++  )
                    {

                        $result = $this->saveURActionExclude ( $params[ "m_id_ex" ][ $p_id ][ $j ],
                                                               $ur_id ) ;
                    }
                }

                //save user role PermissionLogic
                if ( $params[ "logic" ][ $p_id ] )
                {
                    $setting = $this->saveUserRoleLogic ( $params, $ur_id,
                                                          $p_id, $userId,
                                                          $setting ) ;
                }
            }
        }

        return $setting ;
    }

    private function saveURActionExclude ( $m_ex, $ur_id )
    {
        $data[ 'core_actionid' ]    = $m_ex ;
        $data[ 'core_user_roleid' ] = $ur_id ;

        $result = \f\ttt::dal ( 'core.rbac.users.saveURActionExclude', $data ) ;
        return $result ;
    }

    private function saveUserRole ( $id, $userId, $roleid )
    {
        $arr[ 'id' ]          = $id ;
        $arr[ 'core_userid' ] = $userId ;
        $arr[ 'core_roleid' ] = $roleid ;

        $result = \f\ttt::dal ( 'core.rbac.users.saveUserRole', $arr ) ;

        $ur_id = ( $arr[ 'id' ] ) ? $arr[ 'id' ] : $result ;
        return $ur_id ;
    }

    private function saveURPExclude ( $pr_id, $ur_id )
    {
        $data[ 'core_permissionid' ] = $pr_id ;
        $data[ 'core_user_roleid' ]  = $ur_id ;

        $result = \f\ttt::dal ( 'core.rbac.users.saveURPExclude', $data ) ;
        return $result ;
    }

    private function checkConflictLogic ( $param )
    {

        foreach ( $param[ 'setting' ] as $rp )
        {
            foreach ( $rp as $k => $arr )
            {

                foreach ( $arr as $key => $val )
                {

                    if ( count ( $val ) > 1 )
                    {

                        for ( $i = 0 ; $i < count ( $val ) ; $i ++  )
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

    private function saveUserPermission ( $params, $userId, $p_id )
    {

        $arr[ 'id' ]                = $params[ 'up_id' ][ $p_id ] ;
        $arr[ 'core_userid' ]       = $userId ;
        $arr[ 'core_permissionid' ] = $p_id ;
//\f\pr($arr);
        $result                     = \f\ttt::dal ( 'core.rbac.users.saveUserPermission',
                                                    $arr ) ;

        $up_id = ( $arr[ 'id' ] ) ? $arr[ 'id' ] : $result ;
        return $up_id ;
    }

    private function saveUserLogic ( $params, $up_id, $p_id, $userId, $setting )
    {
        for ( $k = 0 ; $k < count ( $params[ "logic" ][ $p_id ] ) ; $k ++  )
        {
            $lid = $params[ "logic" ][ $p_id ][ $k ] ;

            $upl_id = ($params[ 'upl_id' ][ $p_id ][ $lid ]) ? $params[ 'upl_id' ][ $p_id ][ $lid ] : false ;

            $upl[ ] = $upl_id ;
            $result = $this->saveUserPermissionLogic ( $lid, $up_id,
                                                       $params[ "order" ][ $p_id ][ $lid ],
                                                       $upl_id ) ;
            $upl_id = ($upl_id) ? $upl_id : $result ;

            $paramL[ 'params' ] = array ( 'ulogicid' => $lid, 'userid'   => $userId ) ;

            $res = \f\ttt::service ( 'core.setting.getKeyGroupPart', $paramL ) ;

            if ( $res )
            {
                $setting[ 'setting' ][ $up_id ][ $lid ] = $res ;

                $setting[ 'upl_id' ][ $up_id ][ $lid ] = $upl_id ;
            }
        }
        $this->removeUserPermissionLogic ( $up_id, $upl ) ;

        return $setting ;
    }

    private function saveUserRoleLogic ( $params, $ur_id, $p_id, $userId,
                                         $setting )
    {
        for ( $k = 0 ; $k < count ( $params[ "logic" ][ $p_id ] ) ; $k ++  )
        {
            $lid = $params[ "logic" ][ $p_id ][ $k ] ;

            $urpl_id = ($params[ 'urpl_id' ][ $p_id ][ $lid ]) ? $params[ 'urpl_id' ][ $p_id ][ $lid ] : false ;

            $urpl[ ] = $upl_id ;
            $result  = $this->saveURPLogic ( $lid, $ur_id, $p_id,
                                             $params[ "order" ][ $p_id ][ $lid ],
                                             $urpl_id ) ;
            $urpl_id = ($urpl_id) ? $urpl_id : $result ;

            $paramL[ 'params' ] = array ( 'urlogicid' => $lid, 'userid'    => $userId ) ;

            $res = \f\ttt::service ( 'core.setting.getKeyGroupPart', $paramL ) ;

            if ( $res )
            {
                $setting[ 'setting' ][ $ur_id ][ $lid ] = $res ;

                $setting[ 'urpl_id' ][ $ur_id ][ $lid ] = $urpl_id ;
            }
        }
        $this->removeURPLogic ( $ur_id, $urpl ) ;

        return $setting ;
    }

    private function removeUserPermissionLogic ( $up_id, $upl )
    {

        $res = \f\ttt::dal ( 'core.rbac.users.getUserPermissionLogicRemoved',
                             array ( 'up_id' => $up_id, 'upl'   => $upl ) ) ;

        foreach ( $res as $data )
        {
            $res = \f\ttt::dal ( 'core.rbac.users.removeUserPermissionLogic',
                                 array ( 'upl_id' => $data[ 'id' ] ) ) ;

            $arr[ 'params' ] = array ( 'UPL_ID' => $data[ 'id' ] ) ;


            \f\ttt::service ( 'core.setting.deleteKeyGroup', $arr ) ;
        }
    }

    private function removeURPLogic ( $ur_id, $urpl )
    {
        $res = \f\ttt::dal ( 'core.rbac.users.getURPLogicRemoved',
                             array ( 'ur_id' => $ur_id, 'urpl'  => $urpl ) ) ;

        foreach ( $res as $data )
        {
            $res = \f\ttt::dal ( 'core.rbac.users.removeURPLogic',
                                 array ( 'urpl_id' => $data[ 'id' ] ) ) ;

            $arr[ 'params' ] = array ( 'URPL_ID' => $data[ 'id' ] ) ;


            \f\ttt::service ( 'core.setting.deleteKeyGroup', $arr ) ;
        }
    }

    private function removeFunc ( $up_id )
    {
        $res = \f\ttt::dal ( 'core.rbac.users.removeUserActionExclude',
                             array ( 'up_id' => $up_id ) ) ;
        return $res ;
    }

    private function removeURPExclude ( $ur_id )
    {
        $res = \f\ttt::dal ( 'core.rbac.users.removeURPExclude',
                             array ( 'ur_id' => $ur_id ) ) ;
        return $res ;
    }

    private function removeUR_actionExclude ( $ur_id )
    {
        $res = \f\ttt::dal ( 'core.rbac.users.removeUR_actionExclude',
                             array ( 'ur_id' => $ur_id ) ) ;
        return $res ;
    }

    private function checkConflictFilterUR ( $params, $uridArr, $userId )
    {
        $filters       = $params[ 'action_filterid' ] ;
        $uraf_id       = $params[ 'uraf_id' ] ;
        $filter_roleid = $params[ 'filter_roleid' ] ;

        $action = array ( ) ;
        $conf = 'no_conf';
        if ( $filters )
        {
            foreach ( $filters as $val )
            {
                $arr = explode ( '-', $val ) ;

                $data[ $arr[ 0 ] ][ ] = $arr[ 1 ] ;

                if ( count ( $data[ $arr[ 0 ] ] ) > 1 && ! in_array ( $arr[ 0 ],
                                                                      $action ) )
                {
                    $action[ ]    = $arr[ 0 ] ;
                }
                $actArr[ ]    = $arr[ 0 ] ;
                $filterArr[ ] = $arr[ 1 ] ;
            }
            $i            = 0 ;

            foreach ( $data as $arr )
            {
               
                if ( count ( $data[ $actArr[ $i ] ] ) == 1 )
                {
                    $newActions[ ] = $actArr[ $i ] ;
                    $filter[ ]     = $filterArr[ $i ] ;
                    $urafArr[ ]    = $uraf_id[ $i ] ;
                    $roleidArr[ ]  = $filter_roleid[ $i ] ;
                    unset($filter_roleid[ $i ]);
                }
                else{
                    for($j=0; $j<count($arr); $j++){
                        if($arr[$j+1] && ($arr[$j] != $arr[$j+1])){
                            $conf = 'conf';
                            break;
                        }
                    }
                }
                
                $i ++ ;
            }
        }

        if ( $newActions )
        {
            $res = $this->saveURFilter ( $newActions, $filter, $urafArr,
                                         $uridArr, $roleidArr, $userId ) ;
        }

        if ( $conf == 'conf' && is_array ( $params[ 'permissionId' ] ) )
        {

            $param[ 'filterConflict' ] = $data ;
            $param[ 'filterAction' ]   = $action ;
            $param[ 'uraf_id' ]        = $uraf_id ;
            $param[ 'uridArr' ]        = $uridArr ;
            $param[ 'userid' ]         = $userId ;
            $param[ 'roleArr' ]        = $filter_roleid ;
            return $param ;
        }
        else
        {
            return false ;
        }
    }

    private function checkConflict ( $params, $upidArr, $userId )
    {

        $filters = $params[ 'action_filterid' ] ;
        $upaf_id = $params[ 'upaf_id' ] ;
        $filter_prid = $params[ 'filter_prid' ] ;
        
        $action = array ( ) ;
        $conf = 'no_conf';
        if ( $filters )
        {

            foreach ( $filters as $val )
            {
                $arr = explode ( '-', $val ) ;

                $data[ $arr[ 0 ] ][ ] = $arr[ 1 ] ;

                if ( count ( $data[ $arr[ 0 ] ] ) > 1 && ! in_array ( $arr[ 0 ],
                                                                      $action ) )
                {
                    $action[ ]    = $arr[ 0 ] ;
                }
                $actArr[ ]    = $arr[ 0 ] ;
                $filterArr[ ] = $arr[ 1 ] ;
            }
            $i            = 0 ;
            
            foreach ( $data as $arr )
            {
                
                if ( count ( $data[ $actArr[ $i ] ] ) == 1 )
                {
                    $newActions[ ] = $actArr[ $i ] ;
                    $filter[ ]     = $filterArr[ $i ] ;
                    $upafArr[ ]    = $upaf_id[ $i ] ;
                    $pridArr[ ]  = $filter_prid[ $i ] ;
                    unset($filter_prid[ $i ]);
                }
                else{
                    for($j=0; $j<count($arr); $j++){
                        if($arr[$j+1] && ($arr[$j] != $arr[$j+1])){
                            $conf = 'conf';
                            break;
                        }
                    }
                }
                $i ++ ;
            }
        }
//\f\pr($newActions);
        if ( $newActions )
        {
            $res = $this->saveUserFilter ( $newActions, $filter, $upafArr,
                                           $upidArr ) ;
        }
       
//\f\pr($action);
        if ( $conf == 'conf' && is_array ( $params[ 'permissionId' ] ) )
        {

            $param[ 'filterConflict' ] = $data ;
            $param[ 'filterAction' ]   = $action ;
            $param[ 'upaf_id' ]        = $upaf_id ;
            $param[ 'upidArr' ]        = $upidArr ;
            $param[ 'userid' ]         = $userId ;
            $param[ 'prArr' ]        = $filter_prid ;
            return $param ;
        }
        else
        {
            return false ;
        }
    }

    private function saveUserActionExclude ( $m_ex, $up_id )
    {
        $data[ 'core_actionid' ]          = $m_ex ;
        $data[ 'core_user_permissionid' ] = $up_id ;

        $result = \f\ttt::dal ( 'core.rbac.users.saveUserActionExclude', $data ) ;
        return $result ;
    }

    private function saveUserPermissionLogic ( $logicid, $up_id, $order, $upl_id )
    {
        $upl_id = ( $upl_id ) ? $upl_id : '' ;

        $data[ 'id' ]                     = $upl_id ;
        $data[ 'core_plogicid' ]          = $logicid ;
        $data[ 'core_user_permissionid' ] = $up_id ;
        $data[ 'upl_order' ]              = $order ;

        $result = \f\ttt::dal ( 'core.rbac.users.saveUserPermissionLogic', $data ) ;
        return $result ;
    }

    private function saveURPLogic ( $logicid, $ur_id, $p_id, $order, $urpl_id )
    {
        $urpl_id = ( $urpl_id ) ? $urpl_id : '' ;

        $data[ 'id' ]                = $urpl_id ;
        $data[ 'core_plogicid' ]     = $logicid ;
        $data[ 'core_permissionid' ] = $p_id ;
        $data[ 'core_user_roleid' ]  = $ur_id ;
        $data[ 'urpl_order' ]        = $order ;

        $result = \f\ttt::dal ( 'core.rbac.users.saveURPLogic', $data ) ;
        return $result ;
    }

    private function saveUserFilter ( $actions, $filters, $upaf_id, $upidArr )
    {

        for ( $i = 0 ; $i < count ( $actions ) ; $i ++  )
        {
            $data[ 'id' ]            = $upaf_id[ $i ] ;
            $data[ 'core_filterid' ] = $filters[ $i ] ;
            $data[ 'core_actionid' ] = $actions[ $i ] ;
            if ( ! $data[ 'id' ] )
            {
                $up = \f\ttt::dal ( 'core.rbac.users.getUserPermissionViaAction',
                                    array ( 'actionid' => $actions[ $i ] ) ) ;

                foreach ( $up as $row )
                {
                    if ( in_array ( $row[ 'id' ], $upidArr ) )
                    {
                        $data[ 'core_user_permissionid' ] = $row[ 'id' ] ;
                        $result                           = \f\ttt::dal ( 'core.rbac.users.saveUserPermissionActionFilter',
                                                                          $data ) ;
                    }
                }
            }
            else
            {
                $result = \f\ttt::dal ( 'core.rbac.users.saveUserPermissionActionFilter',
                                        $data ) ;
            }
        }
    }

    private function saveURFilter ( $actions, $filters, $uraf_id, $uridArr,
                                    $roleidArr, $userId )
    {
        for ( $i = 0 ; $i < count ( $actions ) ; $i ++  )
        {
            $data[ 'id' ]            = $uraf_id[ $i ] ;
            $data[ 'core_filterid' ] = $filters[ $i ] ;
            $data[ 'core_actionid' ] = $actions[ $i ] ;
            if ( ! $data[ 'id' ] )
            {
                $urRow = \f\ttt::dal ( 'core.rbac.users.getUserRole',
                                       array ( 'userid' => $userId, 'roleid' => $roleidArr[ $i ] ) ) ;

                $data[ 'core_user_roleid' ] = $urRow[ 'id' ] ;
                $result                     = \f\ttt::dal ( 'core.rbac.users.saveURActionFilter',
                                                            $data ) ;
            }
            else
            {
                $result = \f\ttt::dal ( 'core.rbac.users.saveURActionFilter',
                                        $data ) ;
            }
        }
    }

    public function saveConfilictFilterUser ()
    {
        $params = $this->request->getAssocParams () ;

        for ( $i = 0 ; $i < count ( $params[ 'c_actionid' ] ) ; $i ++  )
        {
            //$data[ 'id' ]            = $params[ 'c_upaf_id' ][ $i ] ;
            $data[ 'core_filterid' ] = $params[ 'c_filterid' ][ $i ] ;
            $data[ 'core_actionid' ] = $params[ 'c_actionid' ][ $i ] ;

            $up = \f\ttt::dal ( 'core.rbac.users.getUserPermissionViaAction',
                                array ( 'actionid' => $params[ 'c_actionid' ][ $i ], 'userid'   => $params[ 'c_userid' ] ) ) ;

            foreach ( $up as $row )
            {
                $j = 0;
                if ( in_array ( $row[ 'core_permissionid' ], $params[ 'c_prid' ] ) )
                {
                    $data[ 'core_user_permissionid' ] = $row[ 'id' ] ;
                    \f\ttt::dal ( 'core.rbac.users.removeUPAFilter',
                                    array ( 'up_id' => $row[ 'id' ], 'actionid' => $data[ 'core_actionid' ] ) ) ;
                    
                    $data[ 'id' ]            = '' ;
                  
                    $result = \f\ttt::dal ( 'core.rbac.users.saveUserPermissionActionFilter',
                                        $data ) ;
                }

            }
        }

        if ( $result )
        {
            return array ( 'success', \f\ifm::t ( 'successSave' ) ) ;
        }
        else
        {
            return array ( 'error', \f\ifm::t ( 'errorDB' ) ) ;
        }
    }

    public function saveConfilictFilterUR ()
    {
        $params = $this->request->getAssocParams () ;

        for ( $i = 0 ; $i < count ( $params[ 'c_actionid' ] ) ; $i ++  )
        {
            
            $data[ 'core_filterid' ] = $params[ 'c_filterid' ][ $i ] ;
            $data[ 'core_actionid' ] = $params[ 'c_actionid' ][ $i ] ;

            $urRows = \f\ttt::dal ( 'core.rbac.users.getUserRoles',
                                    array ( 'userid' => $params[ 'c_userid' ] ) ) ;

            foreach ( $urRows as $row )
            {
                $j = 0;
                if ( in_array ( $row[ 'core_roleid' ], $params[ 'c_roleid' ] ) )
                {
                    
                    $data[ 'core_user_roleid' ] = $row[ 'id' ] ;
                    \f\ttt::dal ( 'core.rbac.users.removeURAFilter',
                                    array ( 'ur_id' => $row[ 'id' ], 'actionid' => $data[ 'core_actionid' ] ) ) ;
                    
                    $data[ 'id' ]            = '' ;
                    $result = \f\ttt::dal ( 'core.rbac.users.saveURActionFilter',
                                            $data ) ;
                    $j++;
                }
            }
        }

        if ( $result )
        {
            return array ( 'success', \f\ifm::t ( 'successSave' ) ) ;
        }
        else
        {
            return array ( 'error', \f\ifm::t ( 'errorDB' ) ) ;
        }
    }

    public function saveUPConfilictLogicSetting ()
    {
        $params = $this->request->getAssocParams () ;
        //$out = false;
        foreach ( $params[ 'logicid' ] as $logicid )
        {
            foreach ( $params[ 'upl_id' ][ $logicid ] as $upl )
            {
                $item[ 'params' ] = array ( 'UPL_ID' => $upl ) ;
                \f\ttt::service ( 'core.setting.deleteKeyGroup', $item ) ;

                $this->saveUserParamLogic ( $params[ 'setting' ][ $logicid ],
                                            $upl, $params[ 'userid' ], $logicid ) ;
                $out = array ( 'success', \f\ifm::t ( 'successSave' ) ) ;
            }
        }


        return $out ;
    }

    public function saveURConfilictLogicSetting ()
    {
        $params = $this->request->getAssocParams () ;
        //$out = false;
        foreach ( $params[ 'logicid' ] as $logicid )
        {
            foreach ( $params[ 'urpl_id' ][ $logicid ] as $urpl )
            {
                $item[ 'params' ] = array ( 'URPL_ID' => $urpl ) ;
                \f\ttt::service ( 'core.setting.deleteKeyGroup', $item ) ;

                $this->saveURParamLogic ( $params[ 'setting' ][ $logicid ],
                                          $urpl, $params[ 'userid' ], $logicid ) ;
                $out = array ( 'success', \f\ifm::t ( 'successSave' ) ) ;
            }
        }


        return $out ;
    }

    public function URPLogicParamSave ()
    {
        $params     = $this->request->getAssocParams () ;
        
        $validParam = $this->validParam ( $params[ 'setting' ] ) ;
        if ( ! is_array ( $valid ) )
        {
            $paramL[ 'params' ] = array ( 'urlogicid' => $params[ 'core_plogicid' ], 'userid'    => $params[ 'userid' ] ) ;

            $res = \f\ttt::service ( 'core.setting.getKeyGroupPart', $paramL ) ;
            
            
            $ret     = 'no_conf' ;
            if ( $res )
            {
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
                if ( $params[ 'urpl_id' ] )
                {

                    $this->saveURParamLogic ( $params[ 'setting' ],
                                              $params[ 'urpl_id' ],
                                              $params[ 'userid' ],
                                              $params[ 'core_plogicid' ] ) ;
                    $out = array ( 'success', \f\ifm::t ( 'successSave' ) ) ;
                }
                else
                {

                    $urpl_id = false ;
                    $result  = $this->saveURPLogic ( $params[ 'core_plogicid' ],
                                                     $params[ 'ur_id' ],
                                                     $params[ 'pr_id' ],
                                                     $params[ 'order' ],
                                                     $urpl_id ) ;
                    if ( $result )
                    {
                        $urpl_id = $result ;
                        $this->saveURParamLogic ( $params[ 'setting' ],
                                                  $urpl_id, $params[ 'userid' ],
                                                  $params[ 'core_plogicid' ] ) ;
                        $out     = array ( 'success', \f\ifm::t ( 'successSave' ) ) ;
                    }
                }
            }
            else
            {
                $out = array ( 'error', \f\ifm::t ( 'confilictLogicMsg' ) ) ;
            }
        }
        else
        {
            $out = array ( 'error', $validParam ) ;
        }
        return $out ;
    }

    public function userPermissionLogicParamSave ()
    {

        $params     = $this->request->getAssocParams () ;
        $validParam = $this->validParam ( $params[ 'setting' ] ) ;
        if ( ! is_array ( $valid ) )
        {
            $paramL[ 'params' ] = array ( 'ulogicid' => $params[ 'core_plogicid' ], 'userid'   => $params[ 'userid' ] ) ;

            $res = \f\ttt::service ( 'core.setting.getKeyGroupPart', $paramL ) ;

            if ( $res )
            {
//                $lid     = $params[ 'core_plogicid' ] ;
//                $up_id   = $params[ 'core_permissionid' ] ;
                $setting = $res ;
                $ret     = 'no_conf' ;
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
                if ( $params[ 'upl_id' ] )
                {

                    $this->saveUserParamLogic ( $params[ 'setting' ],
                                                $params[ 'upl_id' ],
                                                $params[ 'userid' ],
                                                $params[ 'core_plogicid' ] ) ;
                    $out = array ( 'success', \f\ifm::t ( 'successSave' ) ) ;
                }
                else
                {

                    $upl_id = false ;
                    $result = $this->saveUserPermissionLogic ( $params[ 'core_plogicid' ],
                                                               $params[ 'up_id' ],
                                                               $params[ 'order' ],
                                                               $upl_id ) ;
                    if ( $result )
                    {
                        $upl_id = $result ;
                        $this->saveUserParamLogic ( $params[ 'setting' ],
                                                    $upl_id,
                                                    $params[ 'userid' ],
                                                    $params[ 'core_plogicid' ] ) ;
                        $out    = array ( 'success', \f\ifm::t ( 'successSave' ) ) ;
                    }
                }
            }
            else
            {
                $out = array ( 'error', \f\ifm::t ( 'confilictLogicMsg' ) ) ;
            }
        }
        else
        {
            $out = array ( 'error', $validParam ) ;
        }
        return $out ;
    }

    private function saveUserParamLogic ( $setting, $upl_id, $userid, $logicid )
    {
        foreach ( $setting as $key => $value )
        {
            $data[ 'keyValues' ][ $key ] = $value ;
        }

        $data[ 'params' ] = array ( 'UPL_ID'   => $upl_id, 'userid'   => $userid, 'ulogicid' => $logicid ) ;

        \f\ttt::service ( 'core.setting.saveKeyGroup', $data ) ;
    }

    private function saveURParamLogic ( $setting, $urpl_id, $userid, $logicid )
    {
        foreach ( $setting as $key => $value )
        {
            $data[ 'keyValues' ][ $key ] = $value ;
        }

        $data[ 'params' ] = array ( 'URPL_ID'   => $urpl_id, 'userid'    => $userid, 'urlogicid' => $logicid ) ;

        \f\ttt::service ( 'core.setting.saveKeyGroup', $data ) ;
    }

    private function validParam ( $params )
    {
        /* @var $validator \f\g\validator */
        $validator   = \f\gadgetFactory::make ( 'validator' ) ;
        $paramGroupV = array (
            'defult' => array (
            ),
            'objects' => array (
                array (
                    'rule' => array (
                        array (
                            'name'   => 'checkEmpty'
                        )
                    ),
                    'object' => array ( $params[ 'value' ] )
                )
            ),
            'objects' => array (
                array (
                    'rule' => array (
                        array (
                            'name'   => 'checkEmpty'
                        )
                    ),
                    'object' => array ( $params[ 'time' ] )
                )
            )
                ) ;
        if ( $validator->group ( $paramGroupV ) === false )
        {
            return $validator->getMessage () ;
        }
        else
        {
            return true ;
        }
    }

}

