<?php

class role2Mapper extends \f\dal
{

    public function __construct()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
    }

    public function saveNewRole()
    {
        $params = $this->request->getAssocParams() ;

        $roleId = $this->sqlEngine->save('core_role',
                                         array (
            'title'    => $params[ 'title' ],
            'owner_id' => $params[ 'ownerId' ]
                )) ;

        return $roleId ;
    }

    public function updateRole()
    {
        $params = $this->request->getAssocParams() ;

        $this->sqlEngine->save('core_role',
                               array (
            'title' => $params[ 'title' ],
                ),
                               array (
            'id = ?', array ( $params[ 'roleId' ] )
        )) ;
    }

    public function deleteRPExclusions()
    {
        $params = $this->request->getAssocParams() ;
        $this->sqlEngine->Delete('core_role_permission-action_exclude')
                ->Where('core_role_permissionid = ?', $params[ 'rpId' ])
                ->Run() ;
    }

    public function deleteRolePerms()
    {
        $params = $this->request->getAssocParams() ;
        $this->sqlEngine->Delete('core_role_permission')
                ->Where('core_roleid = ?', $params[ 'roleId' ])
                ->Run() ;
    }

    public function saveRolePerm()
    {
        $params = $this->request->getAssocParams() ;

        $rpId = $this->sqlEngine->save('core_role_permission',
                                       array (
            'core_roleid'       => $params[ 'roleId' ],
            'core_permissionid' => $params[ 'permissionId' ]
                )) ;

        return $rpId ;
    }

    public function saveExclusions()
    {
        $params = $this->request->getAssocParams() ;

        $query = "INSERT INTO core_role_permission_action_exclude(core_actionid, core_role_permissionid) VALUES" ;
        $c     = count($params[ 'actionsToExclude' ]) ;
        foreach ( $params[ 'actionsToExclude' ] as $k => $actionId )
        {
            $query .= "(" . $actionId . ", " . $params[ 'rpId' ] . ")" ;
            if ( $k < $c - 1 )
            {
                $query .= ', ' ;
            }
        }

        $this->sqlEngine->query($query)->Run() ;
    }

    public function getRoleInfo()
    {
        $params = $this->request->getAssocParams() ;
        $this->sqlEngine->Select('title')
                ->From('core_role')
                ->Where('id = ?', $params[ 'roleId' ])
                ->Run() ;
        return $this->sqlEngine->getRow() ;
    }

    public function getRolePerms()
    {
        $params = $this->request->getAssocParams() ;

        $this->sqlEngine->Select('id as rpId, core_permissionid as permId')
                ->From('core_role_permission')
                ->Where('core_roleid = ?', $params[ 'roleId' ])
                ->Run() ;

        return $this->sqlEngine->getRows() ;
    }

    public function getRPExclusions()
    {
        $params = $this->request->getAssocParams() ;

        $this->sqlEngine->Select('core_actionid as actionId')
                ->From('core_role_permission_action_exclude')
                ->Where('core_role_permissionid = ?', $params[ 'rpId' ])
                ->Run() ;

        return $this->sqlEngine->getRows() ;
    }

    public function getUserRoles()
    {
        $params = $this->request->getAssocParams() ;
        $this->sqlEngine->Select('R.id as roleId, R.title as roleTitle')
                ->From('core_user_role as UR')
                ->joinTable('core_role as R')
                ->On('UR.core_roleid = R.id')
                ->Where('UR.core_userid = ?', $params[ 'userId' ])
                ->Run() ;

        return $this->sqlEngine->getRows() ;
    }

    public function getAllRoles()
    {
        $params = $this->request->getAssocParams() ;
//        \f\pr($params) ;
        $this->sqlEngine->Select('id as roleId, title as roleTitle')
                ->From('core_role')
                ->Where('owner_id = ?', $params[ 'ownerId' ])
                ->orWhere('owner_id = ?', $params[ 'userId' ])
                ->Run() ;
//        \f\pre($this->sqlEngine->last_query()) ;
        return $this->sqlEngine->getRows() ;
    }

}
