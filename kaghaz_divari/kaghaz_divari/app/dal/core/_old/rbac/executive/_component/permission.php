<?php

class permission extends \f\dal
{

    public function __construct()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
    }

    private function getUserRolePermExlusions($userId)
    {

        $this->sqlEngine->Select('urpe.core_permissionid as permissionId')
                ->From('core_user_role as ur')
                ->joinTable('core_user_role_permission_exclude as urpe')
                ->On('ur.id = urpe.core_user_roleid')
                ->Where('ur.core_userid = ?', $userId)
                ->Run() ;

        $rows = $this->sqlEngine->getRows() ;

        $permissionIds = array () ;
        foreach ( $rows as $row )
        {
            $permissionIds[] = $row[ 'permissionId' ] ;
        }
        return $permissionIds ;
    }

    private function getUPLPermissions($userId, $permissionExclusionString)
    {
        $uplQuery = "
            SELECT 
                    UP.core_permissionid AS permissionId,
                    UPL.id               AS UPL_id, 
                    UPL.core_plogicid    AS UPL_logicId,
                    PL.name              AS UPL_logicName,
                    PL.status            AS UPL_logicStatus,
                    DPL.id               AS DPL_id, 
                    DPL.core_plogicid    AS DPL_logicId,
                    PL2.name             AS DPL_logicName,
                    PL2.status           AS DPL_logicStatus
                FROM 
                    core_user_permission AS UP 
                LEFT JOIN 
                    core_user_permission_plogic AS UPL 
                        ON UP.id = UPL.core_user_permissionid " ;
        if ( $permissionExclusionString !== '()' )
        {
            $uplQuery .= "
               AND UP.core_permissionid NOT IN$permissionExclusionString  
        " ;
        }
        $uplQuery .= "LEFT JOIN
                    core_plogic AS PL
                        ON UPL.core_plogicid = PL.id 
                LEFT JOIN
                    core_permission_plogic as DPL
                        ON UP.core_permissionid = DPL.core_permissionid
                LEFT JOIN
                    core_plogic AS PL2
                        ON DPL.core_plogicid = PL2.id 
            WHERE UP.core_userid = $userId
        " ;
        $this->sqlEngine->query($uplQuery)->Run() ;

        return $this->sqlEngine->getRows() ;
    }

    private function getRPLPermissions($userId, $permissionExclusionString)
    {

        $rplQuery = "
            SELECT 
                    RP.core_permissionid AS permissionId,
                    RPL.id               AS RPL_id, 
                    RPL.core_plogicid    AS RPL_logicId,
                    PL.name              AS RPL_logicName,
                    PL.status            AS RPL_logicStatus,
                    DPL.id               AS DPL_id, 
                    DPL.core_plogicid    AS DPL_logicId,
                    PL2.name             AS DPL_logicName,
                    PL2.status           AS DPL_logicStatus
                FROM 
                        core_user_role AS UR 
                JOIN core_role_permission AS RP 
                        ON UR.core_roleid = RP.core_roleid " ;
        if ( $permissionExclusionString !== '()' )
        {
            $rplQuery .= "
               AND RP.core_permissionid NOT IN$permissionExclusionString  
        " ;
        }
        $rplQuery .= "LEFT JOIN 
                    core_role_permission_plogic AS RPL 
                        ON RP.id = RPL.core_role_permissionid
                LEFT JOIN
                    core_plogic AS PL
                        ON RPL.core_plogicid = PL.id 
                LEFT JOIN
                    core_permission_plogic as DPL
                        ON RP.core_permissionid = DPL.core_permissionid
                LEFT JOIN
                    core_plogic AS PL2
                        ON DPL.core_plogicid = PL2.id 
            WHERE UR.core_userid = $userId" ;

        $this->sqlEngine->query($rplQuery)->Run() ;

        return $this->sqlEngine->getRows() ;
    }

    private function getURPLPermission($userId, $permissionExclusionString)
    {
        $urplQuery = "
            SELECT 
                    RP.core_permissionid AS permissionId,

                    URPL.id              AS URPL_id, 
                    URPL.core_plogicid   AS URPL_logicId,
                    PL.name              AS URPL_logicName,
                    PL.status            AS URPL_logicStatus,

                    DPL.id               AS DPL_id, 
                    DPL.core_plogicid    AS DPL_logicId,
                    PL2.name             AS DPL_logicName,
                    PL2.status           AS DPL_logicStatus
                FROM 
                    core_user_role AS UR 
                JOIN core_role_permission AS RP 
                    ON UR.core_roleid = RP.core_roleid " ;
        if ( $permissionExclusionString !== '()' )
        {
            $urplQuery .= "
               AND RP.core_permissionid NOT IN$permissionExclusionString  
        " ;
        }
        $urplQuery .= " LEFT JOIN 
                    core_user_role_permission_plogic AS URPL 
                        ON UR.id = URPL.core_user_roleid AND RP.core_permissionid = URPL.core_permissionid
                LEFT JOIN
                    core_plogic AS PL
                        ON URPL.core_plogicid = PL.id 
                LEFT JOIN
                    core_permission_plogic as DPL
                        ON RP.core_permissionid = DPL.core_permissionid
                LEFT JOIN
                    core_plogic AS PL2
                        ON DPL.core_plogicid = PL2.id 
            WHERE UR.core_userid = $userId
        " ;

        $this->sqlEngine->query($urplQuery)->Run() ;

        return $this->sqlEngine->getRows() ;
    }

    public function getMyPermissions($userID)
    {
        
        $roleToUserPermissionExludeIds = $this->getUserRolePermExlusions($userID) ;

        # Permission Exclusion String
        $pES = "(" . implode(',', $roleToUserPermissionExludeIds) . ")" ;

        # get granted and default permission logics
        $uplPermissions  = $this->getUPLPermissions($userID, $pES) ;
        $urplPermissions = $this->getURPLPermission($userID, $pES) ;
        $rplPermissions  = $this->getRPLPermissions($userID, $pES) ;

        # get settings for every logic and make it cachable 
        # (make a fast and easy useable array)
        include __DIR__ . \f\DS . 'permissionCacheable.php' ;

        $permissionCacheableObj = new permissionCacheable ;

        $uplCacheable  = $permissionCacheableObj->makeUPLCacheable($uplPermissions) ;
        $urplCacheable = $permissionCacheableObj->makeURPLCacheable($urplPermissions) ;
        $rplCacheable  = $permissionCacheableObj->makeRPLCacheable($rplPermissions) ;

        return $permissionCacheableObj->mergeLogics($uplCacheable,
                                                    $urplCacheable,
                                                    $rplCacheable) ;
    }

}
