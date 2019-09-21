<?php

class usersMapper extends \f\dal
{

    private $dataTable ;
    private $tb_core_user ;
    private $tb_user_permission ;
    private $tb_permission_action ;
    private $tb_up_actionFilter ;
    private $tb_up_actionExclude ;
    private $tb_up_logic ;
    private $tb_core_action ;
    private $tb_user_role ;
    private $tb_urp_exclude ;
    private $tb_ura_exclude ;
    private $tb_urp_logic ;
    private $tb_ura_filter ;
    
    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
        $this->dataTable = \f\dalFactory::make ( 'core.dataTable' ) ;

        $this->tb_core_user         = 'core_user' ;
        $this->tb_user_permission   = 'core_user_permission' ;
        $this->tb_permission_action = 'core_permission_action' ;
        $this->tb_up_actionFilter   = 'core_user_permission_action_filter' ;
        $this->tb_up_actionExclude  = 'core_user_permission_action_exclude' ;
        $this->tb_up_logic          = 'core_user_permission_plogic' ;
        $this->tb_core_action       = 'core_action' ;
        $this->tb_user_role         = 'core_user_role' ;
        $this->tb_urp_exclude       = 'core_user_role_permission_exclude' ;
        $this->tb_ura_exclude       = 'core_user_role_action_exclude' ;
        $this->tb_urp_logic       = 'core_user_role_permission_plogic' ;
        $this->tb_ura_filter       = 'core_user_role_action_filter' ;
    }

    public function saveUserPermission ()
    {
        $params = $this->request->getAssocParams () ;

        $editId = $params[ 'id' ] ;
        unset ( $params[ 'id' ] ) ;

        if ( ! $editId )
        {
            $result = $this->sqlEngine->save ( $this->tb_user_permission,
                                               $params ) ;
        }
        else
        {

            $result = $this->sqlEngine->save ( $this->tb_user_permission,
                                               $params,
                                               array (
                'id=?', array ( $editId )
                    ) ) ;
        }
        return $result ;
    }

    public function saveUserRole ()
    {
        $params = $this->request->getAssocParams () ;

        $editId = $params[ 'id' ] ;
        unset ( $params[ 'id' ] ) ;

        if ( ! $editId )
        {
            $result = $this->sqlEngine->save ( $this->tb_user_role, $params ) ;
        }
        else
        {

            $result = $this->sqlEngine->save ( $this->tb_user_role, $params,
                                               array (
                'id=?', array ( $editId )
                    ) ) ;
        }
        return $result ;
    }

    public function getUserPermissionViaAction ()
    {
        
        $actionid = $this->request->getParam ( 'actionid' ) ;
        $userid = $this->request->getParam ( 'userid' ) ;
        
        $this->sqlEngine->Select ( 't1.*' )
                ->From ( $this->tb_user_permission . ' AS t1' )
                ->innerJoin ( $this->tb_permission_action . ' AS t2' )
                ->On ( "t1.core_permissionid = t2.core_permissionid " )
                ->Where ( " t2.core_actionid =?", $actionid )
                ->andWhere ( " t1.core_userid =?", $userid )
                ->Run () ;

        return $this->sqlEngine->getRows () ;
    }

    public function getUserPermission ()
    {
        $userid = $this->request->getParam ( 'userid' ) ;
        $this->sqlEngine->Select ( 't1.*' )
                ->From ( $this->tb_user_permission . ' AS t1' )
                ->Where ( " t1.core_userid =?", $userid )
                ->Run () ;

        return $this->sqlEngine->getRows () ;
    }

    public function getUserRoles ()
    {
        $userid = $this->request->getParam ( 'userid' ) ;
        $this->sqlEngine->Select ( 't1.*' )
                ->From ( $this->tb_user_role . ' AS t1' )
                ->Where ( " t1.core_userid =?", $userid )
                ->Run () ;

        return $this->sqlEngine->getRows () ;
    }
    
    public function getUserRole(){
        $userid = $this->request->getParam ( 'userid' ) ;
        $roleid = $this->request->getParam ( 'roleid' ) ;
        
        $this->sqlEngine->Select ( 't1.*' )
                ->From ( $this->tb_user_role . ' AS t1' )
                ->Where ( " t1.core_userid =?", $userid )
                ->andWhere ( " t1.core_roleid =?", $roleid )
                ->Run () ;

        return $this->sqlEngine->getRow () ;
    }

    public function getUserPermissionLogics ()
    {
        $up_id = $this->request->getParam ( 'up_id' ) ;
        $this->sqlEngine->Select ( 't1.*' )
                ->From ( $this->tb_up_logic . ' AS t1' )
                ->Where ( " t1.core_user_permissionid =?", $up_id )
                ->Run () ;

        return $this->sqlEngine->getRows () ;
    }
    
    public function getURPLogics ()
    {
        $ur_id = $this->request->getParam ( 'ur_id' ) ;
        $this->sqlEngine->Select ( 't1.*' )
                ->From ( $this->tb_urp_logic . ' AS t1' )
                ->Where ( " t1.core_user_roleid =?", $ur_id )
                ->Run () ;

        return $this->sqlEngine->getRows () ;
    }

    public function getUserPermissionActionExcludes ()
    {
        $up_id = $this->request->getParam ( 'up_id' ) ;
        $this->sqlEngine->Select ( 't1.*, t2.path' )
                ->From ( $this->tb_up_actionExclude . ' AS t1' )
                ->innerJoin ( $this->tb_core_action . ' AS t2' )
                ->On ( "t1.core_actionid = t2.id " )
                ->Where ( " t1.core_user_permissionid =?", $up_id )
                ->Run () ;

        return $this->sqlEngine->getRows () ;
    }
    
    public function getURActionExcludes ()
    {
        $ur_id = $this->request->getParam ( 'ur_id' ) ;
        $this->sqlEngine->Select ( 't1.*, t2.path' )
                ->From ( $this->tb_ura_exclude . ' AS t1' )
                ->innerJoin ( $this->tb_core_action . ' AS t2' )
                ->On ( "t1.core_actionid = t2.id " )
                ->Where ( " t1.core_user_roleid =?", $ur_id )
                ->Run () ;

        return $this->sqlEngine->getRows () ;
    }
    
    public function getURPExcludes ()
    {
        $ur_id = $this->request->getParam ( 'ur_id' ) ;
        $this->sqlEngine->Select ( 't1.*, t2.path' )
                ->From ( $this->tb_urp_exclude . ' AS t1' )
                ->innerJoin ( 'core_permission AS t2' )
                ->On ( "t1.core_permissionid = t2.id " )
                ->Where ( " t1.core_user_roleid =?", $ur_id )
                ->Run () ;

        return $this->sqlEngine->getRows () ;
    }

    public function getUserPermissionActionFilter ()
    {
        $up_id    = $this->request->getParam ( 'up_id' ) ;
        $actionid = $this->request->getParam ( 'actionid' ) ;

        $this->sqlEngine->Select ( 't1.*' )
                ->From ( $this->tb_up_actionFilter . ' AS t1' )
                ->Where ( " t1.core_user_permissionid =?", $up_id )
                ->andWhere ( " t1.core_actionid =?", $actionid )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function getUserActionFilters ()
    {
        $up_id = $this->request->getParam ( 'up_id' ) ;

        $this->sqlEngine->Select ( 't1.*, t2.path' )
                ->From ( $this->tb_up_actionFilter . ' AS t1' )
                ->innerJoin ( 'core_action AS t2' )
                ->On ( "t1.core_actionid = t2.id " )
                ->Where ( " t1.core_user_permissionid =?", $up_id )
                ->Run () ;

        return $this->sqlEngine->getRows () ;
    }
    
    public function getURActionFilters ()
    {
        $ur_id = $this->request->getParam ( 'ur_id' ) ;

        $this->sqlEngine->Select ( 't1.*, t2.path' )
                ->From ( $this->tb_ura_filter . ' AS t1' )
                ->innerJoin ( 'core_action AS t2' )
                ->On ( "t1.core_actionid = t2.id " )
                ->Where ( " t1.core_user_roleid =?", $ur_id )
                ->Run () ;

        return $this->sqlEngine->getRows () ;
    }
    
    public function getURActionFilter (){
        $ur_id = $this->request->getParam ( 'ur_id' ) ;
        $actionid = $this->request->getParam ( 'actionid' ) ;
        
        $this->sqlEngine->Select ( 't1.*, t2.path' )
                ->From ( $this->tb_ura_filter . ' AS t1' )
                ->innerJoin ( 'core_action AS t2' )
                ->On ( "t1.core_actionid = t2.id " )
                ->Where ( " t1.core_user_roleid =?", $ur_id )
                ->andWhere ( " t1.core_actionid =?", $actionid )
                ->Run () ;

        return $this->sqlEngine->getRow () ;
    }

    public function saveUserPermissionActionFilter ()
    {
        $params = $this->request->getAssocParams () ;

        $editId = $params[ 'id' ] ;
        unset ( $params[ 'id' ] ) ;

        if ( ! $editId )
        {

            $result = $this->sqlEngine->save ( $this->tb_up_actionFilter,
                                               $params ) ;
        }
        else
        {

            $result = $this->sqlEngine->save ( $this->tb_up_actionFilter,
                                               $params,
                                               array (
                'id=?', array ( $editId )
                    ) ) ;
        }
        return $result ;
    }
    
    public function saveURActionFilter ()
    {
        $params = $this->request->getAssocParams () ;

        $editId = $params[ 'id' ] ;
        unset ( $params[ 'id' ] ) ;

        if ( ! $editId )
        {

            $result = $this->sqlEngine->save ( $this->tb_ura_filter,
                                               $params ) ;
        }
        else
        {

            $result = $this->sqlEngine->save ( $this->tb_ura_filter,
                                               $params,
                                               array (
                'id=?', array ( $editId )
                    ) ) ;
        }
        return $result ;
    }

    public function saveUserActionExclude ()
    {
        $params = $this->request->getAssocParams () ;
        $result = $this->sqlEngine->save ( $this->tb_up_actionExclude, $params ) ;
        return $result ;
    }
    
    public function saveURActionExclude ()
    {
        $params = $this->request->getAssocParams () ;
        $result = $this->sqlEngine->save ( $this->tb_ura_exclude, $params ) ;
        return $result ;
    }

    public function saveURPExclude ()
    {
        $params = $this->request->getAssocParams () ;
        $result = $this->sqlEngine->save ( $this->tb_urp_exclude, $params ) ;
        return $result ;
    }

    public function saveUserPermissionLogic ()
    {
        $params = $this->request->getAssocParams () ;

        $editId = $params[ 'id' ] ;
        unset ( $params[ 'id' ] ) ;

        if ( ! $editId )
        {
            $result = $this->sqlEngine->save ( $this->tb_up_logic, $params ) ;
        }
        else
        {
            $result = $this->sqlEngine->save ( $this->tb_up_logic, $params,
                                               array (
                'id=?', array ( $editId )
                    ) ) ;
        }
        
        return $result ;
    }
    
    public function saveURPLogic(){
        $params = $this->request->getAssocParams () ;
        
        $editId = $params[ 'id' ] ;
        unset ( $params[ 'id' ] ) ;

        if ( ! $editId )
        {
            $result = $this->sqlEngine->save ( $this->tb_urp_logic, $params ) ;
        }
        else
        {
            $result = $this->sqlEngine->save ( $this->tb_urp_logic, $params,
                                               array (
                'id=?', array ( $editId )
                    ) ) ;
        }
        
        return $result ;
    }

    public function getUser ()
    {
        $id = $this->request->getParam ( 'id' ) ;
        $this->sqlEngine->Select ( 't1.*' )
                ->From ( $this->tb_core_user . ' AS t1' )
                ->Where ( " t1.id =?", $id )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function removeUserActionExclude ()
    {
        $result = $this->sqlEngine->remove ( $this->tb_up_actionExclude,
                                             array ( 'core_user_permissionid=?', array ( $this->request->getParam ( 'up_id' ) ) ) ) ;

        return true ;
    }
    
    public function removeURAFilter()
    {
        $result = $this->sqlEngine->remove ( $this->tb_ura_filter,
                                             array ( 'core_user_roleid=? and core_actionid=?', array ( $this->request->getParam ( 'ur_id' ), $this->request->getParam ( 'actionid' ) ) ) ) ;

        return true ;
    }
    
    public function removeUPAFilter ()
    {
        
        $result = $this->sqlEngine->remove ( $this->tb_up_actionFilter,
                                             array ( 'core_user_permissionid=? and core_actionid=?', array ( $this->request->getParam ( 'up_id' ), $this->request->getParam ( 'actionid' ) ) ) ) ;

        return true ;
    }

    public function removeUserPermissionLogic ()
    {
        $result = $this->sqlEngine->remove ( $this->tb_up_logic,
                                             array ( 'id=?', array ( $this->request->getParam ( 'upl_id' ) ) ) ) ;

        return true ;
    }
    
    public function removeURPLogic () {
        $result = $this->sqlEngine->remove ( $this->tb_urp_logic,
                                             array ( 'id=?', array ( $this->request->getParam ( 'urpl_id' ) ) ) ) ;

        return true ;
    }

    public function getUserPermissionLogicRemoved ()
    {
        $up_id = $this->request->getParam ( 'up_id' ) ;
        $upl   = $this->request->getParam ( 'upl' ) ;
        $where = '' ;
        $i     = 0 ;
        foreach ( $upl as $val )
        {
            $and = ($i == 0) ? '' : 'and' ;
            $where .= " $and t1.id!= $val" ;
            $i ++ ;
        }
        $this->sqlEngine->Select ()
                ->From ( $this->tb_up_logic . ' AS t1' )
                ->Where ( " t1.core_user_permissionid = '" . $up_id . "' " )
                ->andWhere ( $where )
                ->Run () ;

        return $this->sqlEngine->getRows () ;
    }
    
    public function getURPLogicRemoved ()
    {
        $ur_id = $this->request->getParam ( 'ur_id' ) ;
        $urpl   = $this->request->getParam ( 'urpl' ) ;
        $where = '' ;
        $i     = 0 ;
        foreach ( $urpl as $val )
        {
            $and = ($i == 0) ? '' : 'and' ;
            $where .= " $and t1.id!= $val" ;
            $i ++ ;
        }
        $this->sqlEngine->Select ()
                ->From ( $this->tb_urp_logic . ' AS t1' )
                ->Where ( " t1.core_user_roleid = '" . $ur_id . "' " )
                ->andWhere ( $where )
                ->Run () ;

        return $this->sqlEngine->getRows () ;
    }

    public function userExcludeRemove ()
    {
        $result = $this->sqlEngine->remove ( $this->tb_up_actionExclude,
                                             array ( 'core_user_permissionid=?', array ( $this->request->getParam ( 'up_id' ) ) ) ) ;

        return true ;
    }

    public function removeURPExclude ()
    {
        $result = $this->sqlEngine->remove ( $this->tb_urp_exclude,
                                             array ( 'core_user_roleid=?', array ( $this->request->getParam ( 'ur_id' ) ) ) ) ;

        return true ;
    }
    
    public function removeUR_actionExclude () {
        $result = $this->sqlEngine->remove ( $this->tb_ura_exclude,
                                             array ( 'core_user_roleid=?', array ( $this->request->getParam ( 'ur_id' ) ) ) ) ;

        return true ;
    }

    public function userRemove ()
    {
        $result = $this->sqlEngine->remove ( $this->tb_core_user,
                                             array ( 'id =?', array ( $this->request->getParam ( 'id' ) ) ) ) ;

        return true ;
    }

}
