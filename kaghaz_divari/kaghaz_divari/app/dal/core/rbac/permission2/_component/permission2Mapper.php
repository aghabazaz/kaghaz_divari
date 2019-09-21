<?php

class permission2Mapper extends \f\dal
{

    public function __construct()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
    }

    public function saveNewPermission()
    {
        $params = $this->request->getAssocParams() ;

        $newPermId = $this->sqlEngine->save('core_permission',
                                            array (
            'title'    => $params[ 'title' ],
            'owner_id' => $params[ 'ownerId' ]
                )) ;

        return $newPermId ;
    }

    public function updatePermission()
    {
        $params = $this->request->getAssocParams() ;
        $this->sqlEngine->save('core_permission',
                               array (
            'title' => $params[ 'title' ]
                ),
                               array (
            'id = ?', array ( $params[ 'permId' ] )
        )) ;
    }

    public function deletePermActions()
    {
        $params = $this->request->getAssocParams() ;

        $this->sqlEngine->Delete('core_permission_action')
                ->Where('core_permissionid = ?', $params[ 'permId' ])
                ->Run() ;
    }

    public function savePermAction()
    {
        $params = $this->request->getAssocParams() ;

        $query = 'INSERT INTO core_permission_action(core_permissionid, core_actionid)
            VALUES 
            ' ;

        $c = count($params[ 'actions' ]) ;
        foreach ( $params[ 'actions' ] as $key => $actionId )
        {
            $query .= "('" . $params[ 'permId' ] . "', '" . $actionId . "')" ;
            if ( $key + 1 < $c )
            {
                $query.= ', ' ;
            }
        }
        $this->sqlEngine->query($query)->Run() ;
    }

    public function savePermUI()
    {
        $params = $this->request->getAssocParams() ;

        $query = 'INSERT INTO core_permission_ui(core_permissionid, core_uiid)
            VALUES 
            ' ;

        $c = count($params[ 'ui' ]) ;
        foreach ( $params[ 'ui' ] as $key => $uiId )
        {
            $query .= "('" . $params[ 'permId' ] . "', '" . $uiId . "')" ;
            if ( $key + 1 < $c )
            {
                $query.= ', ' ;
            }
        }

        $this->sqlEngine->query($query)->Run() ;
    }

    public function getPermissionInfo()
    {
        $params = $this->request->getAssocParams() ;

        $this->sqlEngine->Select('id, title')
                ->From('core_permission')
                ->Where('id = ?', $params[ 'permId' ])
                ->Run() ;

        return $this->sqlEngine->getRow() ;
    }

    public function getPermissionActions()
    {
        $params = $this->request->getAssocParams() ;

        $this->sqlEngine->Select('PA.core_actionid as action_id, PA.core_filterid as filter_id, A.path')
                ->From('core_permission_action as PA')
                ->joinTable('core_action as A')
                ->On('PA.core_actionid = A.id')
                ->Where('core_permissionid = ?', $params[ 'permId' ])
                ->Run() ;
        return $this->sqlEngine->getRows() ;
    }

    public function getMyPermissions()
    {
        $userId  = \f\ifm::app()->getUserInfo('id') ;
        $ownerId = \f\ifm::app()->getUserInfo('owner_id') ;

        $this->sqlEngine->Select('id, title')
                ->From('core_permission')
                ->Where('owner_id = ?', $userId)
                ->orWhere('owner_id = ?', $ownerId)
                ->Run() ;

        return $this->sqlEngine->getRows() ;
    }

    public function getPermissionActions2()
    {
        $params = $this->request->getAssocParams() ;

        $this->sqlEngine->Select('core_actionid as actionId')
                ->From('core_permission_action')
                ->Where('core_permissionid = ?', $params[ 'permId' ])
                ->Run() ;

        return $this->sqlEngine->getRows() ;
    }

    public function getUserPermissions()
    {
        $params = $this->request->getAssocParams() ;
        $this->sqlEngine->Select('P.id as permId, P.title as permTitle')
                ->From('core_user_permission as UP')
                ->joinTable('core_permission as P')
                ->On('UP.core_permissionid = P.id')
                ->Where('core_userid = ?', $params[ 'userId' ])
                ->Run() ;
        return $this->sqlEngine->getRows() ;
    }

    public function getAllPermissions()
    {
        $params = $this->request->getAssocParams() ;

        $this->sqlEngine->Select('id as permId, title as permTitle')
                ->From('core_permission')
                ->Where('owner_id = ?', $params[ 'ownerId' ])
                ->orWhere('owner_id = ?', $params[ 'userId' ])
                ->Run() ;

        return $this->sqlEngine->getRows() ;
    }

}
