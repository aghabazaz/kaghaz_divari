<?php

class permissionCacheable
{
# Permission -> User

    public function makeUPLCacheable($uplPermissions)
    {
        $uplCacheabe = array () ;
        foreach ( $uplPermissions as $uplPermission )
        {
            if ( ! isset($uplCacheabe[ $uplPermission[ 'permissionId' ] ]) )
            {
                $uplCacheabe[ $uplPermission[ 'permissionId' ] ] = array () ;
            }

# get granted permission->user logic settings

            $uplLogicIsNotSetInCacheable = ! isset($uplCacheabe[ $uplPermission[ 'permissionId' ] ][ $uplPermission[ 'UPL_logicName' ] ]) ;

            $uplLogicIsNotEmpty = ! empty($uplPermission[ 'UPL_logicName' ]) ;

            if ( $uplLogicIsNotSetInCacheable && $uplLogicIsNotEmpty )
            {
                $settings = \f\ttt::dal('core.setting.getKeyGroup',
                                        array (
                            'params' => array (
                                'UPL_ID' => $uplPermission[ 'UPL_id' ]
                            )
                        )) ;

                $logicInfo            = array (
                    'settings' => $settings,
                    'status'   => $uplPermission[ 'UPL_logicStatus' ]
                        ) ;
                $logicInfo[ 'type' ]  = 'UPL' ;
                $logicInfo[ 'uplId' ] = $uplPermission[ 'UPL_id' ] ;

                $uplCacheabe[ $uplPermission[ 'permissionId' ] ][ $uplPermission[ 'UPL_logicName' ] ] = $logicInfo ;
            }

# get default permission logic settings

            $dplLogicIsNotSetInCacheable = ! isset($uplCacheabe[ $uplPermission[ 'permissionId' ] ][ $uplPermission[ 'DPL_logicName' ] ]) ;

            $dplIsNotEmpty     = ! empty($uplPermission[ 'DPL_logicName' ]) ;
            $dplIsNotSameToUPL = $uplPermission[ 'UPL_logicName' ] !== $uplPermission[ 'DPL_logicName' ] ;

            if ( $dplLogicIsNotSetInCacheable && $dplIsNotSameToUPL && $dplIsNotEmpty )
            {
                $settings  = \f\ttt::dal('core.setting.getKeyGroup',
                                         array (
                            'params' => array (
                                'PL_ID' => $uplPermission[ 'DPL_id' ]
                            )
                        )) ;
                $logicInfo = array (
                    'settings' => $settings,
                    'status'   => $uplPermission[ 'DPL_logicStatus' ]
                        ) ;

                $logicInfo[ 'type' ]  = 'DPL' ;
                $logicInfo[ 'dplId' ] = $uplPermission[ 'DPL_id' ] ;

                $uplCacheabe[ $uplPermission[ 'permissionId' ] ][ $uplPermission[ 'DPL_logicName' ] ] = $logicInfo ;
            }
        }

        return $uplCacheabe ;
    }

# Role -> User

    public function makeURPLCacheable($urplPermissions)
    {

        $urplCacheabe = array () ;
        foreach ( $urplPermissions as $urplPermission )
        {
            if ( ! isset($urplCacheabe[ $urplPermission[ 'permissionId' ] ]) )
            {
                $urplCacheabe[ $urplPermission[ 'permissionId' ] ] = array () ;
            }

# get granted permission->user logic settings

            $urplLogicIsNotSetInCacheable = ! isset($urplCacheabe[ $urplPermission[ 'permissionId' ] ][ $urplPermission[ 'URPL_logicName' ] ]) ;

            $urplLogicIsNotEmpty = ! empty($urplPermission[ 'URPL_logicName' ]) ;

            if ( $urplLogicIsNotSetInCacheable && $urplLogicIsNotEmpty )
            {
                $settings = \f\ttt::dal('core.setting.getKeyGroup',
                                        array (
                            'params' => array (
                                'URPL_ID' => $urplPermission[ 'URPL_id' ]
                            )
                        )) ;

                $logicInfo             = array (
                    'settings' => $settings,
                    'status'   => $urplPermission[ 'URPL_logicStatus' ]
                        ) ;
                $logicInfo[ 'type' ]   = 'URPL' ;
                $logicInfo[ 'urplId' ] = $urplPermission[ 'URPL_id' ] ;

                $urplCacheabe[ $urplPermission[ 'permissionId' ] ][ $urplPermission[ 'URPL_logicName' ] ] = $logicInfo ;
            }

# get default permission logic settings

            $dplLogicIsNotSetInCacheable = ! isset($urplCacheabe[ $urplPermission[ 'permissionId' ] ][ $urplPermission[ 'DPL_logicName' ] ]) ;

            $dplIsNotEmpty      = ! empty($urplPermission[ 'DPL_logicName' ]) ;
            $dplIsNotSameToURPL = $urplPermission[ 'URPL_logicName' ] !== $urplPermission[ 'DPL_logicName' ] ;

            if ( $dplLogicIsNotSetInCacheable && $dplIsNotSameToURPL && $dplIsNotEmpty )
            {
                $settings  = \f\ttt::dal('core.setting.getKeyGroup',
                                         array (
                            'params' => array (
                                'PL_ID' => $urplPermission[ 'DPL_id' ]
                            )
                        )) ;
                $logicInfo = array (
                    'settings' => $settings,
                    'status'   => $urplPermission[ 'DPL_logicStatus' ]
                        ) ;

                $logicInfo[ 'type' ]  = 'DPL' ;
                $logicInfo[ 'dplId' ] = $urplPermission[ 'DPL_id' ] ;

                $urplCacheabe[ $urplPermission[ 'permissionId' ] ][ $urplPermission[ 'DPL_logicName' ] ] = $logicInfo ;
            }
        }

        return $urplCacheabe ;
    }

# Permission -> Role

    public function makeRPLCacheable($rplPermissions)
    {
        $rplCacheabe = array () ;
        foreach ( $rplPermissions as $rplPermission )
        {
            if ( ! isset($rplCacheabe[ $rplPermission[ 'permissionId' ] ]) )
            {
                $rplCacheabe[ $rplPermission[ 'permissionId' ] ] = array () ;
            }

# get granted permission->user logic settings

            $rplLogicIsNotSetInCacheable = ! isset($rplCacheabe[ $rplPermission[ 'permissionId' ] ][ $rplPermission[ 'RPL_logicName' ] ]) ;

            $rplLogicIsNotEmpty = ! empty($rplPermission[ 'RPL_logicName' ]) ;

            if ( $rplLogicIsNotSetInCacheable && $rplLogicIsNotEmpty )
            {
                $settings = \f\ttt::dal('core.setting.getKeyGroup',
                                        array (
                            'params' => array (
                                'RPL_ID' => $rplPermission[ 'RPL_id' ]
                            )
                        )) ;

                $logicInfo            = array (
                    'settings' => $settings,
                    'status'   => $rplPermission[ 'RPL_logicStatus' ]
                        ) ;
                $logicInfo[ 'type' ]  = 'RPL' ;
                $logicInfo[ 'uplId' ] = $rplPermission[ 'RPL_id' ] ;

                $rplCacheabe[ $rplPermission[ 'permissionId' ] ][ $rplPermission[ 'RPL_logicName' ] ] = $logicInfo ;
            }

# get default permission logic settings

            $dplLogicIsNotSetInCacheable = ! isset($rplCacheabe[ $rplPermission[ 'permissionId' ] ][ $rplPermission[ 'DPL_logicName' ] ]) ;

            $dplIsNotEmpty     = ! empty($rplPermission[ 'DPL_logicName' ]) ;
            $dplIsNotSameToUPL = $rplPermission[ 'RPL_logicName' ] !== $rplPermission[ 'DPL_logicName' ] ;

            if ( $dplLogicIsNotSetInCacheable && $dplIsNotSameToUPL && $dplIsNotEmpty )
            {
                $settings  = \f\ttt::dal('core.setting.getKeyGroup',
                                         array (
                            'params' => array (
                                'PL_ID' => $rplPermission[ 'DPL_id' ]
                            )
                        )) ;
                $logicInfo = array (
                    'settings' => $settings,
                    'status'   => $rplPermission[ 'DPL_logicStatus' ]
                        ) ;

                $logicInfo[ 'type' ]  = 'DPL' ;
                $logicInfo[ 'dplId' ] = $rplPermission[ 'DPL_id' ] ;

                $rplCacheabe[ $rplPermission[ 'permissionId' ] ][ $rplPermission[ 'DPL_logicName' ] ] = $logicInfo ;
            }
        }

        return $rplCacheabe ;
    }

    public function mergeLogics($upl, $urpl, $rpl)
    {
        $mergedLogics = $upl ;

        # merge urpl
        foreach ( $urpl as $permissionId => $mergingLogics )
        {
            $permissionAlreadyMerged = isset($mergedLogics[ $permissionId ]) ;
            if ( ! $permissionAlreadyMerged )
            {
                # merge hole permission logics
                $mergedLogics[ $permissionId ] = $mergingLogics ;
            }
            else
            {
                # merge logics of the permission one by one (and check priprity)
                foreach ( $mergingLogics as $logicName => $mergingLogic )
                {
                    $logicAlreadyMerged = isset($mergedLogics[ $permissionId ][ $logicName ]) ;
                    if ( ! $logicAlreadyMerged )
                    {
                        $mergedLogics[ $permissionId ][ $logicName ] = $mergingLogic ;
                    }
                    else
                    {
                        # check priority
                        $mergedLogicIsDPL = $mergedLogics[ $permissionId ][ $logicName ][ 'type' ] == 'DPL' ;
                        if ( $mergedLogicIsDPL )
                        {
                            $mergedLogics[ $permissionId ][ $logicName ] = $mergingLogic ;
                        }
                    }
                }
            }
        }

        # merge urpl
        foreach ( $rpl as $permissionId => $mergingLogics )
        {
            $permissionAlreadyMerged = isset($mergedLogics[ $permissionId ]) ;
            if ( ! $permissionAlreadyMerged )
            {
                # merge hole permission logics
                $mergedLogics[ $permissionId ] = $mergingLogics ;
            }
            else
            {
                # merge logics of the permission one by one (and check priprity)
                foreach ( $mergingLogics as $logicName => $mergingLogic )
                {
                    $logicAlreadyMerged = isset($mergedLogics[ $permissionId ][ $logicName ]) ;
                    if ( ! $logicAlreadyMerged )
                    {
                        $mergedLogics[ $permissionId ][ $logicName ] = $mergingLogic ;
                    }
                    else
                    {
                        # check priority
                        $mergedLogicIsDPL = $mergedLogics[ $permissionId ][ $logicName ][ 'type' ] == 'DPL' ;
                        if ( $mergedLogicIsDPL )
                        {
                            $mergedLogics[ $permissionId ][ $logicName ] = $mergingLogic ;
                        }
                    }
                }
            }
        }
        return $mergedLogics ;
    }

}
