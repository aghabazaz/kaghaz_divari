<?php

class roleMapper extends \f\dal
{

    private $dataTable ;
    private $tb_core_role ;
    private $tb_role_permission ;
    private $tb_permission_action ;
    private $tb_rp_actionFilter ;
    private $tb_rp_actionExclude ;
    private $tb_rp_logic ;
    private $tb_core_action ;

    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
        $this->dataTable = \f\dalFactory::make ( 'core.dataTable' ) ;

        $this->tb_core_role         = 'core_role' ;
        $this->tb_role_permission   = 'core_role_permission' ;
        $this->tb_permission_action = 'core_permission_action' ;
        $this->tb_rp_actionFilter   = 'core_role_permission_action_filter' ;
        $this->tb_rp_actionExclude  = 'core_role_permission_action_exclude' ;
        $this->tb_rp_logic          = 'core_role_permission_plogic' ;
        $this->tb_core_action       = 'core_action' ;
    }

    public function getRoles ()
    {
        $param            = $this->request->getAssocParams () ;
        $requestDataTable = $param[ 'dataTableParams' ] ; //$this->request->getParam( 'dataTableParams' ) ;

        $columns = array (
            array (
                'db' => 'id', //column name selected
                'dt' => 0, //column num
            ),
            array (
                'db' => 'title',
                'dt' => 1,
            )
                ) ;

        $dtOption = array (
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->tb_core_role,
            'primaryKey'      => $this->tb_core_role . '.id',
            'columnsArray'    => $columns ) ;

        $out = $this->dataTable->getDataTable ( $dtOption ) ;


        return $out ;
    }
    
    public function getAllRoles(){
        $this->sqlEngine->Select ( 't1.*' )
                ->From ( $this->tb_core_role . ' AS t1' )
                ->Run () ;

        return $this->sqlEngine->getRows () ;
    }

    public function saveRole ()
    {
        $params = $this->request->getAssocParams () ;
        $editId = $params[ 'id' ] ;
        unset ( $params[ 'id' ] ) ;

        if ( ! $editId )
        {
            $result = $this->sqlEngine->save ( $this->tb_core_role, $params ) ;
        }
        else
        {

            $result = $this->sqlEngine->save ( $this->tb_core_role, $params,
                                               array (
                'id=?', array ( $editId )
                    ) ) ;
        }
        return $result ;
    }

    public function saveRolePermission ()
    {
        $params = $this->request->getAssocParams () ;

        $editId = $params[ 'id' ] ;
        unset ( $params[ 'id' ] ) ;

        if ( ! $editId )
        {
            $result = $this->sqlEngine->save ( $this->tb_role_permission,
                                               $params ) ;
        }
        else
        {

            $result = $this->sqlEngine->save ( $this->tb_role_permission,
                                               $params,
                                               array (
                'id=?', array ( $editId )
                    ) ) ;
        }
        return $result ;
    }

    public function getRolePermissionViaAction ()
    {
        $actionid = $this->request->getParam ( 'actionid' ) ;
        $roleid = $this->request->getParam ( 'roleid' ) ;
        
        $this->sqlEngine->Select ( 't1.*' )
                ->From ( $this->tb_role_permission . ' AS t1' )
                ->innerJoin ( $this->tb_permission_action . ' AS t2' )
                ->On ( "t1.core_permissionid = t2.core_permissionid " )
                ->Where ( "t2.core_actionid =?", $actionid )
                ->andWhere ( "t1.core_roleid =?", $roleid )
                ->Run () ;

        return $this->sqlEngine->getRows () ;
    }

    public function getRolePermission ()
    {
        $roleid = $this->request->getParam ( 'roleid' ) ;
        $this->sqlEngine->Select ( 't1.*' )
                ->From ( $this->tb_role_permission . ' AS t1' )
                ->Where ( " t1.core_roleid =?", $roleid )
                ->Run () ;

        return $this->sqlEngine->getRows () ;
    }
    
    public function getRPermission(){
        $roleid = $this->request->getParam ( 'roleid' ) ;
        $prid = $this->request->getParam ( 'prid' ) ;
        
        $this->sqlEngine->Select ( 't1.*' )
                ->From ( $this->tb_role_permission . ' AS t1' )
                ->Where ( " t1.core_roleid =?", $roleid )
                ->andWhere ( " t1.core_permissionid =?", $prid )
                ->Run () ;

        return $this->sqlEngine->getRow () ;
    }

    public function getRolePermissionLogics ()
    {
        $rp_id = $this->request->getParam ( 'rp_id' ) ;
        $this->sqlEngine->Select ( 't1.*' )
                ->From ( $this->tb_rp_logic . ' AS t1' )
                ->Where ( " t1.core_role_permissionid =?", $rp_id )
                ->Run () ;

        return $this->sqlEngine->getRows () ;
    }

    public function getRolePermissionActionExcludes ()
    {

        $rp_id = $this->request->getParam ( 'rp_id' ) ;
        $this->sqlEngine->Select ( 't1.*, t2.path' )
                ->From ( $this->tb_rp_actionExclude . ' AS t1' )
                ->innerJoin ( $this->tb_core_action . ' AS t2' )
                ->On ( "t1.core_actionid = t2.id " )
                ->Where ( " t1.core_role_permissionid =?", $rp_id )
                ->Run () ;

        return $this->sqlEngine->getRows () ;
    }

    public function getRolePermissionActionFilter ()
    {
        $rp_id    = $this->request->getParam ( 'rp_id' ) ;
        $actionid = $this->request->getParam ( 'actionid' ) ;

        $this->sqlEngine->Select ( 't1.*' )
                ->From ( $this->tb_rp_actionFilter . ' AS t1' )
                ->Where ( " t1.core_role_permissionid =?", $rp_id )
                ->andWhere ( " t1.core_actionid =?", $actionid )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function getRoleActionFilters ()
    {
        $rp_id = $this->request->getParam ( 'rp_id' ) ;

        $this->sqlEngine->Select ( 't1.*, t2.path' )
                ->From ( $this->tb_rp_actionFilter . ' AS t1' )
                ->innerJoin ( 'core_action AS t2' )
                ->On ( "t1.core_actionid = t2.id " )
                ->Where ( " t1.core_role_permissionid =?", $rp_id )
                ->Run () ;

        return $this->sqlEngine->getRows () ;
    }

    public function saveRolePermissionActionFilter ()
    {
        $params = $this->request->getAssocParams () ;

        $editId = $params[ 'id' ] ;
        unset ( $params[ 'id' ] ) ;

        if ( ! $editId )
        {
           
            $result = $this->sqlEngine->save ( $this->tb_rp_actionFilter,
                                               $params ) ;
        }
        else
        {

            $result = $this->sqlEngine->save ( $this->tb_rp_actionFilter,
                                               $params,
                                               array (
                'id=?', array ( $editId )
                    ) ) ;
        }
        return $result ;
    }

    public function saveRoleActionExclude ()
    {
        $params = $this->request->getAssocParams () ;
        $result = $this->sqlEngine->save ( $this->tb_rp_actionExclude, $params ) ;
        return $result ;
    }

    public function saveRolePermissionLogic ()
    {
        $params = $this->request->getAssocParams () ;

        $editId = $params[ 'id' ] ;
        unset ( $params[ 'id' ] ) ;

        if ( ! $editId )
        {
            $result = $this->sqlEngine->save ( $this->tb_rp_logic, $params ) ;
        }
        else
        {
//            \f\pr($editId);
//\f\pr($params);
            $result = $this->sqlEngine->save ( $this->tb_rp_logic, $params,
                                               array (
                'id=?', array ( $editId )
                    ) ) ;
        }
      //  \f\pr($this->sqlEngine->last_query ());
        return $result ;
    }

    public function getRole ()
    {
        $id = $this->request->getParam ( 'id' ) ;
        $this->sqlEngine->Select ( 't1.*' )
                ->From ( $this->tb_core_role . ' AS t1' )
                ->Where ( " t1.id =?", $id )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function removeRoleActionExclude ()
    {
        $result = $this->sqlEngine->remove ( $this->tb_rp_actionExclude,
                                             array ( 'core_role_permissionid=?', array ( $this->request->getParam ( 'rp_id' ) ) ) ) ;

        return true ;
    }

    public function removeRolePermissionLogic ()
    {
        $result = $this->sqlEngine->remove ( $this->tb_rp_logic,
                                             array ( 'id=?', array ( $this->request->getParam ( 'rpl_id' ) ) ) ) ;

        return true ;
    }

    public function getRolePermissionLogicRemoved ()
    {
        $rp_id = $this->request->getParam ( 'rp_id' ) ;
        $rpl   = $this->request->getParam ( 'rpl' ) ;
        $where = '' ;
        $i     = 0 ;
        foreach ( $rpl as $val )
        {
            $and = ($i == 0) ? '' : 'and' ;
            $where .= " $and t1.id!= $val" ;
            $i ++ ;
        }
        $this->sqlEngine->Select ()
                ->From ( $this->tb_rp_logic . ' AS t1' )
                ->Where ( " t1.	core_role_permissionid = '" . $rp_id . "' " )
                ->andWhere ( $where )
                ->Run () ;

        return $this->sqlEngine->getRows () ;
    }
    
    public function roleExcludeRemove(){
        $result = $this->sqlEngine->remove ( $this->tb_rp_actionExclude,
                                             array ( 'core_role_permissionid=?', array ( $this->request->getParam ( 'rp_id' ) ) ) ) ;

        return true ;
    }
    
    public function roleRemove(){
        $result = $this->sqlEngine->remove ( $this->tb_core_role,
                                             array ( 'id =?', array ( $this->request->getParam ( 'id' ) ) ) ) ;

        return true ;
    }
    
    public function removeRPAFilter()
    {
        $result = $this->sqlEngine->remove ( $this->tb_rp_actionFilter,
                                             array ( 'core_role_permissionid =? and core_actionid =?', array ( $this->request->getParam ( 'rp_id' ), $this->request->getParam ( 'actionid' ) ) ) ) ;

        return true ;
    }

}
