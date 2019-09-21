<?php

class permissionService extends \f\service
{

    public function saveNewPermission()
    {
        $params = $this->request->getAssocParams() ;

        $userType = \f\ifm::app()->getUserType() ;
        
       

        if ( $userType === 'superadmin' || $userType === 'siteAdmin' )
        {
            $ownerId = \f\ifm::app()->getUserInfo('id') ;
        }
        else
        {
            $ownerId = \f\ttt::service('core.auth.getUserOwner') ;
        }
        
         //\f\pr($ownerId);

        $saveParams = array (
            'title'   => $params[ 'title' ],
            'ownerId' => $ownerId
                ) ;

        $permiId = \f\ttt::dal('core.rbac.permission2.saveNewPermission',
                               $saveParams) ;

        $this->savePermissionActions($params[ 'selectedCodes' ], $permiId) ;

        return array (
            'result' => 'success'
                ) ;
    }

    public function updatePermission()
    {
        $params = $this->request->getAssocParams() ;

        $saveParams = array (
            'title'  => $params[ 'title' ],
            'permId' => $params[ 'permId' ]
                ) ;

        \f\ttt::dal('core.rbac.permission2.updatePermission', $saveParams) ;

        \f\ttt::dal('core.rbac.permission2.deletePermActions',
                    array (
            'permId' => $params[ 'permId' ]
        )) ;

        $this->savePermissionActions($params[ 'selectedCodes' ],
                                     $params[ 'permId' ]) ;

        return array (
            'result' => 'success',
                ) ;
    }

    private function savePermissionActions($encodedActions, $permissionId)
    {
        $actions = json_decode($encodedActions) ;

        $action = array () ;

        foreach ( $actions as $selectedCode )
        {
            if ( empty($selectedCode->id) )
            {
                continue ;
            }

            if ( $selectedCode->type === 'method.ui' )
            {
                $action[] = $selectedCode->id ;
            }
        }

        \f\ttt::dal('core.rbac.permission2.savePermAction',
                    array (
            'actions' => $action,
            'permId'  => $permissionId
        )) ;
    }

    public function getPermissionInfo()
    {
        $params = $this->request->getAssocParams() ;

        $permissionInfo = \f\ttt::dal('core.rbac.permission2.getPermissionInfo',
                                      array (
                    'permId' => $params[ 'permId' ]
                )) ;

        $permissionActions = \f\ttt::dal('core.rbac.permission2.getPermissionActions',
                                         array (
                    'permId' => $params[ 'permId' ]
                )) ;

        $permissionInfo[ 'actions' ] = $permissionActions ;

        $permissionInfo[ 'ui' ] = $permissionUI ;

        return $permissionInfo ;
    }

    public function getPermissionActinos()
    {
        $params      = $this->request->getAssocParams() ;
        $permActions = \f\ttt::dal('core.rbac.permission2.getPermissionActions2',
                                   array (
                    'permId' => $params[ 'permId' ]
                )) ;
        return $permActions ;
    }

    public function getAllPermissions()
    {
        return \f\ttt::dal('core.rbac.permission2.getMyPermissions') ;
    }

    public function getMyPermissions()
    {
        return \f\ttt::dal('core.rbac.permission2.getMyPermissions') ;
    }

    public function getUserAssigns()
    {
        $params = $this->request->getAssocParams() ;

        $userRoles = \f\ttt::dal('core.rbac.role2.getUserRoles',
                                 array (
                    'userId' => $params[ 'userId' ]
                )) ;

        $UR = array () ;
        foreach ( $userRoles as $userRole )
        {
            $UR[ $userRole[ 'roleId' ] ] = array (
                'roleTilte' => $userRole[ 'roleTitle' ]
                    ) ;
        }

        $userPerms = \f\ttt::dal('core.rbac.permission2.getUserPermissions',
                                 array (
                    'userId' => $params[ 'userId' ]
                )) ;

        $UP = array () ;
        foreach ( $userPerms as $userPerm )
        {
            $UP[ $userPerm[ 'permId' ] ] = array (
                'permTilte' => $userPerm[ 'permTitle' ]
                    ) ;
        }

        $allPermissions = \f\ttt::dal('core.rbac.permission2.getAllPermissions',
                                      array (
                    'userId'  => \f\ifm::app()->getUserInfo('id'),
                    'ownerId' => \f\ifm::app()->getUserInfo('owner_id')
                )) ;
        $aP             = array () ;
        foreach ( $allPermissions as $perm )
        {
            $aP[ $perm[ 'permId' ] ] = array (
                'permTitle' => $perm[ 'permTitle' ],
                'checked'   => false
                    ) ;

            if ( isset($UP[ $perm[ 'permId' ] ]) )
            {
                $aP[ $perm[ 'permId' ] ][ 'checked' ] = true ;
            }
        }

        $allRoles = \f\ttt::dal('core.rbac.role2.getAllRoles',
                                array (
                    'userId'  => \f\ifm::app()->getUserInfo('id'),
                    'ownerId' => \f\ifm::app()->getUserInfo('owner_id')
                )) ;

        $aR = array () ;
        foreach ( $allRoles as $role )
        {
            $aR[ $role[ 'roleId' ] ] = array (
                'roleTitle' => $role[ 'roleTitle' ],
                'checked'   => false
                    ) ;

            if ( isset($UR[ $role[ 'roleId' ] ]) )
            {
                $aR[ $role[ 'roleId' ] ][ 'checked' ] = true ;
            }
        }


        return array (
            'perms' => $aP,
            'roles' => $aR
                ) ;
    }

}
