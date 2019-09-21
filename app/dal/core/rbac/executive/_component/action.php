<?php

class action extends \f\dal
{

    public function __construct()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
    }

    private function roleActionsQuery($userId, $permissionExclusionString, $actionExclusionString)
    {
        $this->sqlEngine->Select('a.*'
                        . ', rp.core_permissionid as permissionId'
                        . ', pa.core_filterid as filterId_p'
                        . ', null as filterId_upaf'
                        . ', f2.id as filterId_uraf'
                        . ', f3.id as filterId_rpaf')
                ->From('core_user_role as ur')
                ->joinTable('core_role_permission as rp')
                ->On('ur.core_roleid = rp.core_roleid')
                ->joinTable('core_permission_action as pa')
                ->On('rp.core_permissionid = pa.core_permissionid')
                ->joinTable('core_action as a')
                ->On('a.id = pa.core_actionid')
                ->leftJoin('core_user_role_action_filter as uraf')
                ->On('a.id = uraf.core_actionid')
                ->leftJoin('core_filter as f2')
                ->On('uraf.core_filterid = f2.id')
                ->leftJoin('core_role_permission_action_filter as rpaf')
                ->On('a.id = rpaf.core_actionid')
                ->leftJoin('core_filter as f3')
                ->On('rpaf.core_filterid = f3.id')
                ->Where("ur.core_userid = $userId") ;

        if ( $permissionExclusionString !== '()' )
        {
            $this->sqlEngine->andWhere("rp.core_permissionid not in $permissionExclusionString") ;
        }
        if ( $actionExclusionString !== '()' )
        {
            $this->sqlEngine->andWhere("a.id not in $actionExclusionString") ;
        }

        return $this->sqlEngine->getQuery() ;
    }

    private function permissionActionsQuery($userId, $actionExclusionString)
    {

        $this->sqlEngine->query("create TEMPORARY table if not exists temp_roleactions_$userId AS ($roleActionsQuery)")->Run() ;

        $this->sqlEngine->Select('a.*'
                        . ', up.core_permissionid as permissionId'
                        . ', pa.core_filterid as filterId_p'
                        . ', f1.id as filterId_upaf'
                        . ', null as filterId_uraf'
                        . ', null as filterId_rpaf')
                ->From('core_user_permission as up')
                ->joinTable('core_permission_action as pa')
                ->On('up.core_permissionid = pa.core_permissionid')
                ->joinTable('core_action as a')
                ->On('a.id = pa.core_actionid')
                ->leftJoin('core_user_permission_action_filter as upaf')
                ->On('a.id = upaf.core_actionid')
                ->leftJoin('core_filter as f1')
                ->On('upaf.core_filterid = f1.id')
                ->Where("up.core_userid = $userId") ;

        if ( $actionExclusionString !== '()' )
        {
            $this->sqlEngine->andWhere("a.id not in $actionExclusionString") ;
        }

        return $this->sqlEngine->getQuery() ;
    }

    public function getActionsWithFilters($userId)
    {

        $actionIds = $this->getConcatenatedExludeActionIds($userId) ;


        $aES           = "(" . implode(',', $actionIds) . ")" ; # actionExclusionString
        # user -> role permission exclusions
        $permissionIds = $this->getUserRolePermExlustions($userId) ; # perm id's
        $pES           = "(" . implode(',', $permissionIds) . ")" ; # permissionExclusionString

        $roleActionsQuery = $this->roleActionsQuery($userId, $pES, $aES) ;

        $permActionsQuery = $this->permissionActionsQuery($userId, $aES) ;

        $this->sqlEngine->query("CREATE TEMPORARY TABLE IF NOT EXISTS temp_myactions_$userId AS "
                . "( SELECT * FROM ( $roleActionsQuery UNION $permActionsQuery ) as t)")->Run() ;

        $this->sqlEngine->Select()
                ->From("temp_myactions_$userId as a")
                ->Run() ;

        $actions = $this->sqlEngine->getRows() ;

        $this->getFilterSettings($actions) ;

        return $this->makeActionsCachable($actions) ;
    }

    private function compareFilterPriority($left, $right)
    {
        $weightedPriorities = array (
            'URAF' => 2,
            'UPAF' => 2,
            'RPAF' => 1,
            'P'    => 0,
                ) ;

        if ( $weightedPriorities[ $left[ 'filterType' ] ] > $weightedPriorities[ $right[ 'filterType' ] ] )
        {
            return true ;
        }
        return false ;
    }

    private function makeActionsCachable($actions)
    {
        $cachableActions = array () ;
        foreach ( $actions as $action )
        {
            $targetAction = $action ;
            if ( isset($cachableActions[ $action[ 'path' ] ]) && $this->compareFilterPriority($cachableActions[ $action[ 'path' ] ],
                                                                                              $action) )
            {
                $targetAction = $cachableActions[ $action[ 'path' ] ] ;
            }
            $cachableActions[ $action[ 'path' ] ] = $targetAction ;
        }
        return $cachableActions ;
    }

    /**
     * Some actions can be excluded when assigning
     * a permission to a role. This function returns them
     */
    private function getConcatenatedExludeActionIds($userId)
    {
        # perm -> user actions exclusions
        $upae = $this->getPermToUserActionExclusions($userId) ; # action id's
        # role -> user actions exclusion        
        $urae = $this->getRoleToUserActionExclusions($userId) ; # action id's
        # perm -> user actions exclusions
        $rpae = $this->getPermToRoleActionExlusions($userId) ; # action id's

        $actionIds = $upae ;
        foreach ( $urae as $actionId )
        {
            $actionIds[] = $actionId ;
        }
        foreach ( $urae as $actionId )
        {
            $actionIds[] = $actionId ;
        }
        foreach ( $rpae as $actionId )
        {
            $actionIds[] = $actionId ;
        }

        return $actionIds ;
    }

    private function getFilterSettings(&$actions)
    {
        return ; # Temporary filter settings is disabled
        foreach ( $actions as $i => $action )
        {

            //order if and if else parts as filters priority
            if ( ! empty($action[ 'filterId_uraf' ]) )
            {
                $filterId   = $action[ 'filterId_uraf' ] ;
                $filterType = 'URAF' ;
            }
            else if ( ! empty($action[ 'filterId_rpaf' ]) )
            {
                $filterId   = $action[ 'filterId_rpaf' ] ;
                $filterType = 'RPAF' ;
            }
            else if ( ! empty($action[ 'filterId_upaf' ]) )
            {
                $filterId   = $action[ 'filterId_upaf' ] ;
                $filterType = 'UPAF' ;
            }
            else if ( ! empty($action[ 'filterId_p' ]) )
            {
                $filterId   = $action[ 'filterId_p' ] ;
                $filterType = 'P' ;
            }

            $actions[ $i ][ 'filterSettings' ] = \f\ttt::dal('core.setting.getKeyGroup',
                                                             array (
                        'params' => array (
                            'filterid'      => $filterId,
                            'core_actionid' => $action[ 'id' ]
                        )
                    )) ;

            $actions[ $i ][ 'filterType' ] = $filterType ;

            unset($actions[ $i ][ 'filterId_p' ]) ;
            unset($actions[ $i ][ 'filterId_upaf' ]) ;
            unset($actions[ $i ][ 'filterId_uraf' ]) ;
            unset($actions[ $i ][ 'filterId_rpaf' ]) ;
        }
    }

    private function getPermToRoleActionExlusions($userId)
    {

        $this->sqlEngine->Select('a.id as actionId')
                ->From('core_user_role as ur')
                ->joinTable('core_role_permission as rp')
                ->On('rp.core_roleid = ur.core_roleid')
                ->joinTable('core_role_permission_action_exclude as rpae')
                ->On('rp.id = rpae.core_role_permissionid')
                ->joinTable('core_action as a')
                ->On('rpae.core_actionid = a.id')
                ->Where('ur.core_userid = ?', $userId)
                ->Run() ;

        $rows = $this->sqlEngine->getRows() ;

        $actionIds = array () ;
        foreach ( $rows as $row )
        {
            $actionIds[] = $row[ 'actionId' ] ;
        }
        return $actionIds ;
    }

    private function getRoleToUserActionExclusions($userId)
    {
        $this->sqlEngine->Select('a.id as actionId')
                ->From('core_user_role as ur')
                ->joinTable('core_user_role_action_exclude as urae')
                ->On('ur.id = urae.core_user_roleid')
                ->joinTable('core_action as a')
                ->On('urae.core_actionid = a.id')
                ->Where('ur.core_userid = ?', $userId)
                ->Run() ;

        $rows = $this->sqlEngine->getRows() ;

        $actionIds = array () ;
        foreach ( $rows as $row )
        {
            $actionIds[] = $row[ 'actionId' ] ;
        }
        return $actionIds ;
    }

    private function getPermToUserActionExclusions($userId)
    {

        $this->sqlEngine->Select('a.id as actionId')
                ->From('core_user_permission as up')
                ->joinTable('core_user_permission_action_exclude as upae')
                ->On('up.id = upae.core_user_permissionid')
                ->joinTable('core_action as a')
                ->On('upae.core_actionid = a.id')
                ->Where('up.core_userid = ?', $userId)
                ->Run() ;

        $rows = $this->sqlEngine->getRows() ;

        $actionIds = array () ;
        foreach ( $rows as $row )
        {
            $actionIds[] = $row[ 'actionId' ] ;
        }
        return $actionIds ;
    }

    private function getUserRolePermExlustions($userId)
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

}
