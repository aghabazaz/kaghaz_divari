<?php

class user2Mapper extends \f\dal
{

    public function __construct()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
    }

    public function delUserRoles()
    {
        $params = $this->request->getAssocParams() ;
        
        $this->sqlEngine->Delete('core_user_role')
                ->Where('core_userid = ?', $params[ 'userId' ])
                ->Run() ;
    }

    public function delUserPerms()
    {
        $params = $this->request->getAssocParams() ;
        $this->sqlEngine->Delete('core_user_permission')
                ->Where('core_userid = ?', $params[ 'userId' ])
                ->Run() ;
    }

    public function saveUserRoles()
    {
        $params = $this->request->getAssocParams() ;

        $query = 'INSERT INTO core_user_role (core_userid, core_roleid) VALUES' ;

        $c = count($params[ 'roles' ]) ;
        foreach ( $params[ 'roles' ] as $i => $roleId )
        {
            $query .= '(' . $params[ 'userId' ] . ', ' . $roleId . ')' ;
            if ( $i < $c - 1 )
            {
                $query .= ',' ;
            }
        }

        $this->sqlEngine->query($query)->Run() ;
    }

    public function saveUserPerms()
    {
        $params = $this->request->getAssocParams() ;

        $query = 'INSERT INTO core_user_permission (core_userid, core_permissionid) VALUES' ;

        $c = count($params[ 'perms' ]) ;
        foreach ( $params[ 'perms' ] as $i => $permId )
        {
            $query .= '(' . $params[ 'userId' ] . ', ' . $permId . ')' ;
            if ( $i < $c - 1 )
            {
                $query .= ',' ;
            }
        }

        $this->sqlEngine->query($query)->Run() ;
    }

}
