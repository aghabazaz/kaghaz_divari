<?php

class role2Service extends \f\service
{


    public function saveRole()
    {
        $params = $this->request->getAssocParams() ;

        if ( \f\ifm::app()->getUserType() === 'superadmin' )
        {
            $ownerId = \f\ifm::app()->getUserInfo('id') ;
        }
        else
        {
            $ownerId = \f\ifm::app()->getUserInfo('owner_id') ;
        }

        $roleId = \f\ttt::dal('core.rbac.role2.saveNewRole',
                              array (
                    'title'   => $params[ 'roleTitle' ],
                    'ownerId' => $ownerId
                )) ;

        foreach ( $params[ 'perms' ] as $permId => $actionsToExclude )
        {
            $rpId = \f\ttt::dal('core.rbac.role2.saveRolePerm',
                                array (
                        'roleId'       => $roleId,
                        'permissionId' => $permId
                    )) ;

            \f\ttt::dal('core.rbac.role2.saveExclusions',
                        array (
                'rpId'             => $rpId,
                'actionsToExclude' => $actionsToExclude
            )) ;
        }
    }

    public function getRoleInfo()
    {
        $params = $this->request->getAssocParams() ;

        $output = array () ;

        $roleInfo = \f\ttt::dal('core.rbac.role2.getRoleInfo',
                                array (
                    'roleId' => $params[ 'roleId' ]
                )) ;

        $output[ 'title' ]  = $roleInfo[ 'title' ] ;
        $output[ 'roleId' ] = $params[ 'roleId' ] ;

        $rolePerms = \f\ttt::dal('core.rbac.role2.getRolePerms',
                                 array (
                    'roleId' => $params[ 'roleId' ]
                )) ;

        $output[ 'perms' ] = array () ;
        foreach ( $rolePerms as $rolePerm )
        {
            $rpExclusions = \f\ttt::dal('core.rbac.role2.getRPExclusions',
                                        array (
                        'rpId' => $rolePerm[ 'rpId' ]
                    )) ;

            $exActions = array();
            foreach ( $rpExclusions as $rpExclusion )
            {
                $exActions[] = $rpExclusion[ 'actionId' ] ;
            }

            $output[ 'perms' ][ $rolePerm[ 'permId' ] ] = $exActions ;
        }
        
//\f\pre($output);

        return $output ;
    }

    public function updateRole()
    {
        $params = $this->request->getAssocParams() ;

        if ( \f\ifm::app()->getUserType() === 'superadmin' )
        {
            $ownerId = \f\ifm::app()->getUserInfo('id') ;
        }
        else
        {
            $ownerId = \f\ifm::app()->getUserInfo('ownerId') ;
        }

        $roleId = $params[ 'roleId' ] ;

        \f\ttt::dal('core.rbac.role2.updateRole',
                    array (
            'title'  => $params[ 'roleTitle' ],
            'roleId' => $roleId
        )) ;

        $rolePerms = \f\ttt::dal('core.rbac.role2.getRolePerms',
                                 array (
                    'roleId' => $roleId
                )) ;

        foreach ( $rolePerms as $rolePerm )
        {
            \f\ttt::dal('core.rbac.role2.deleteRPExclusions',
                        array (
                'rpId' => $rolePerm[ 'rpId' ]
            )) ;
        }

        \f\ttt::dal('core.rbac.role2.deleteRolePerms',
                    array (
            'roleId' => $roleId
        )) ;


        foreach ( $params[ 'perms' ] as $permId => $actionsToExclude )
        {
            $rpId = \f\ttt::dal('core.rbac.role2.saveRolePerm',
                                array (
                        'roleId'       => $roleId,
                        'permissionId' => $permId
                    )) ;

            \f\ttt::dal('core.rbac.role2.saveExclusions',
                        array (
                'rpId'             => $rpId,
                'actionsToExclude' => $actionsToExclude
            )) ;
        }
    }

}
