<?php

class permission
{

    public function permission_Save ( $params )
    {

        //  $params  = $this->request->getAssocParams () ;

        $data[ 'id' ]    = $params[ 'id' ] ;
        $data[ 'title' ] = $params[ 'title' ] ;
        //$data[ 'level' ] = $params[ 'level' ] ;
        // $data[ 'core_actionid' ] = $params[ 'core_actionid' ] ;
        $valid           = $this->validation ( $data ) ;

        if ( ! is_array ( $valid ) )
        {
            $result = \f\ttt::dal ( 'core.rbac.savePermission', $data ) ;

            $pr_id = ( $data[ 'id' ] ) ? $data[ 'id' ] : $result ;
//            if ( $result &&  $data[ 'level' ]=='method')
//            {
            if ( $data[ 'id' ] )
            {
                $this->removeFunc ( $pr_id ) ;
                // save logic permission
                if ( $params[ 'logic' ] )
                {
                    for ( $i = 0 ; $i < count ( $params[ 'logic' ] ) ; $i ++  )
                    {
                        $lid   = $params[ 'logic' ][ $i ] ;
                        $pl_id = ($params[ 'pl_id' ][ $lid ]) ? $params[ 'pl_id' ][ $lid ] : false ;

                        $pl[ ] = $pl_id ;

                        $result = $this->savePermissionLogic ( $params[ 'logic' ][ $i ],
                                                               $params[ 'order' ][ $lid ],
                                                               $pr_id, $pl_id ) ;
                    }
                    $this->removePermissionLogic ( $pr_id, $pl ) ;
                }
            }

            // get filters
            for ( $j = 0 ; $j < count ( $params[ 'action_filterid' ] ) ; $j ++  )
            {
                $action_filter = $params[ 'action_filterid' ][ $j ] ;
                $arr           = explode ( '-', $action_filter ) ;
                $actionid[ ]   = $arr[ 0 ] ;
                $filterid[ ]   = $arr[ 1 ] ;
            }
//\f\pr($actionid);
            for ( $i = 0 ; $i < count ( $params[ 'type' ] ) ; $i ++  )
            {
               
                $type  = $params[ 'type' ][ $i ] ;
                $types = explode ( '.', $type ) ;
                if ( $types[ 0 ] == 'method' )
                {
                    //if ( $actionid )
                    //{
                        
                        if ( is_array($actionid) ){
                            $key = array_search ( $params[ 'm_id' ][ $i ], $actionid ) ;
                            $core_filterid = (in_array ( $params[ 'm_id' ][ $i ],
                                                     $actionid )) ? $filterid[ $key ] : 0 ;
                        }
                        else{
                            $core_filterid = 0;
                        }
                        

                        $result = $this->saveMethode ( $types[ 1 ],
                                                       $params[ 'm_id' ][ $i ],
                                                       $pr_id, $core_filterid ) ;
                   // }
                }
                else
                {
                    $result = $this->saveComponent ( $types[ 1 ],
                                                     $params[ 'm_id' ][ $i ],
                                                     $pr_id ) ;
                }
            }

            // }

            if ( $result )
            {
                $out = array ( 'success', \f\ifm::t ( 'successSave' ) ) ;
            }
            else
            {
                $out = array ( 'error', \f\ifm::t ( 'errorDB' ) ) ;
            }
        }
        else
        {
            $out = array ( 'error', $valid ) ;
        }
        return $out ;
    }

    private function removePermissionLogic ( $pr_id, $pl )
    {

        $res = \f\ttt::dal ( 'core.rbac.getPermissionLogicRemoved',
                             array ( 'pr_id' => $pr_id, 'pl_id' => $pl ) ) ;

        foreach ( $res as $data )
        {
            $res = \f\ttt::dal ( 'core.rbac.removePermissionLogic',
                                 array ( 'pl_id' => $data[ 'id' ] ) ) ;

            $arr[ 'params' ] = array ( 'PL_ID' => $data[ 'id' ] ) ;


            \f\ttt::service ( 'core.setting.deleteKeyGroup', $arr ) ;
        }
    }

    public function savePermissionLogic ( $logic, $order, $pr_id, $pl_id )
    {

        $pl_id = ( $pl_id ) ? $pl_id : '' ;

        $data[ 'id' ]                = $pl_id ;
        $data[ 'core_permissionid' ] = $pr_id ;
        $data[ 'core_plogicid' ]     = $logic ;
        $data[ 'pl_order' ]          = $order ;

        $result = \f\ttt::dal ( 'core.rbac.savePermissionLogic', $data ) ;
        return $result ;
    }

    private function saveMethode ( $type, $m_id, $pr_id, $filterid )
    {
        $data[ 'core_permissionid' ] = $pr_id ;
        $data[ 'type' ]              = $type ;


        if ( $type == 'ui' )
        {
            //    $row = \f\ttt::dal ( 'core.code.getAction', array('path' => $path) ) ;
            $data[ 'core_actionid' ] = $m_id ;
            $data[ 'core_filterid' ] = $filterid ;
            
            $result                  = \f\ttt::dal ( 'core.rbac.saveMethodePermission',
                                                     $data ) ;
           
        }
        else
        {
            //    $row = \f\ttt::dal ( 'core.code.getService', array('path' => $path) ) ;
            $data[ 'core_serviceid' ] = $m_id ;
            $result                   = \f\ttt::dal ( 'core.rbac.saveMethodePermission',
                                                      $data ) ;
        }
        return $result ;
    }

    private function removeFunc ( $pr_id )
    {

        $res = \f\ttt::dal ( 'core.rbac.removeMethod',
                             array ( 'pr_id' => $pr_id, 'type'  => 'ui' ) ) ;
        $res    = \f\ttt::dal ( 'core.rbac.removeMethod',
                                array ( 'pr_id' => $pr_id, 'type'  => 'service' ) ) ;

        $res = \f\ttt::dal ( 'core.rbac.removeComponent',
                             array ( 'pr_id' => $pr_id, 'type'  => 'ui' ) ) ;
        $res    = \f\ttt::dal ( 'core.rbac.removeComponent',
                                array ( 'pr_id' => $pr_id, 'type'  => 'service' ) ) ;
//        $res    = \f\ttt::dal ( 'core.rbac.removePermissionLogic',
//                                array ( 'pr_id' => $pr_id ) ) ;


        return $res ;
    }

    private function saveComponent ( $type, $m_id, $pr_id )
    {
        $data[ 'core_permissionid' ] = $pr_id ;
        $data[ 'type' ]              = $type ;
        if ( $type == 'ui' )
        {
            //  $row = \f\ttt::dal ( 'core.code.getUI', array('path' => $path) ) ;
            $data[ 'core_uiid' ] = $m_id ;

            $result = \f\ttt::dal ( 'core.rbac.saveComponentPermission', $data ) ;
        }
        else
        {
            //      $row = \f\ttt::dal ( 'core.code.getApp', array('path' => $path) ) ;
            $data[ 'core_appid' ] = $m_id ;
            $result               = \f\ttt::dal ( 'core.rbac.saveComponentPermission',
                                                  $data ) ;
        }
        return $result ;
    }

    private function validation ( $params )
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
                    'object' => array ( $params[ 'title' ] )
                )
            )
//            ,'objects' => array (
//                array (
//                    'rule' => array (
//                        array (
//                            'name'   => 'checkEmpty'
//                        )
//                    ),
//                    'object' => array ( $params[ 'level' ] )
//                )
//            )
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

