<?php

/**
 * Database
 */
class rbacMapper extends \f\dal
{

    //  private $sqlEngine ;
    private $dataTable ;
    private $tb_permission ;
    private $tb_permission_service ;
    private $tb_permission_action ;
    private $tb_permission_app ;
    private $tb_permission_ui ;
    private $core_plogic ;
    // private $tb_core_role ;
    // private $tb_role_permission ;
    private $tb_core_action ;
    private $tb_core_filter ;
    private $tb_permission_plogic ;

    /**
     *
     * @var dataTable 
     */
    public function __construct()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
        $this->dataTable = \f\dalFactory::make('core.dataTable') ;

        $this->tb_permission         = 'core_permission' ;
        $this->tb_permission_service = 'core_permission_service' ;
        $this->tb_permission_action  = 'core_permission_action' ;
        $this->tb_permission_app     = 'core_permission_app' ;
        $this->tb_permission_ui      = 'core_permission_ui' ;
        $this->core_plogic           = 'core_plogic' ;
        // $this->tb_core_role          = 'core_role' ;
        // $this->tb_role_permission    = 'core_role_permission' ;
        $this->tb_core_action        = 'core_action' ;
        $this->tb_core_filter        = 'core_filter' ;
        $this->tb_permission_plogic  = 'core_permission_plogic' ;
    }

    public function getPermissions()
    {

        $param = $this->request->getAssocParams() ;
        
        $ownerId = \f\ifm::app()->getUserInfo('owner_id') ;
        $userId  = \f\ifm::app()->getUserInfo('id') ;
      
        $this->sqlEngine->Select('id, title')
                ->From('core_permission')
                ->Where('owner_id = ' . $ownerId . ' or owner_id = ' . $userId)
                ->Run() ;
        
        $out['data'] = $this->sqlEngine->getRows() ;
        $out['total'] = count($out['data']);
        $out['draw'] = $out['total'];
        return $out;

    }

    public function getfilterMakers()
    {
        $param            = $this->request->getAssocParams() ;
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
            'tableName'       => $this->tb_core_action,
            'primaryKey'      => $this->tb_core_action . '.id',
            "whereJoin"       => array ( $this->tb_core_action . ".filter_type='filter'" ),
            'columnsArray'    => $columns ) ;

        $out = $this->dataTable->getDataTable($dtOption) ;


        return $out ;
    }

    public function getFilters()
    {
        $param            = $this->request->getAssocParams() ;
        $requestDataTable = $param[ 'dataTableParams' ] ;
        $actionid         = $param[ 'actionid' ] ;

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
            'tableName'       => $this->tb_core_filter,
            'primaryKey'      => $this->tb_core_filter . '.id',
            "whereJoin"       => array ( $this->tb_core_filter . ".core_actionid= $actionid " ),
            'columnsArray'    => $columns ) ;

        $out = $this->dataTable->getDataTable($dtOption) ;


        return $out ;
    }

    public function getfilterMaker()
    {

        $actionId = $this->request->getParam('actionId') ;
        $this->sqlEngine->Select()
                ->From($this->tb_core_action . ' AS t1')
                ->Where(" t1.id = ?", $actionId)
                ->Run() ;
        return $this->sqlEngine->getRow() ;
    }

    public function getFilter()
    {
        $id = $this->request->getParam('id') ;
        $this->sqlEngine->Select()
                ->From($this->tb_core_filter . ' AS t1')
                ->Where(" t1.id = ?", $id)
                ->Run() ;
        return $this->sqlEngine->getRow() ;
    }

    public function getLogics()
    {
        $param            = $this->request->getAssocParams() ;
        $requestDataTable = $param[ 'dataTableParams' ] ; //$this->request->getParam( 'dataTableParams' ) ;

        $columns = array (
            array (
                'db' => 'id', //column name selected
                'dt' => 0, //column num
            ),
            array (
                'db' => 'title',
                'dt' => 1,
            ),
            array (
                'db' => 'name',
                'dt' => 2,
            )
                ) ;

        $dtOption = array (
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->core_plogic,
            'primaryKey'      => $this->core_plogic . '.id',
            'columnsArray'    => $columns ) ;

        $out = $this->dataTable->getDataTable($dtOption) ;


        return $out ;
    }

    public function getAllLogics()
    {
        $this->sqlEngine->Select()
                ->From($this->core_plogic)
                ->OrderBy('id')
                ->Run() ;

        return $this->sqlEngine->getRows() ;
    }

    public function getAllEnableLogics()
    {
        $this->sqlEngine->Select()
                ->From($this->core_plogic)
                ->Where('status =?', 'enabled')
                ->OrderBy('id')
                ->Run() ;

        return $this->sqlEngine->getRows() ;
    }

    public function savePermission()
    {
        $params = $this->request->getAssocParams() ;

        $editId = $params[ 'id' ] ;
        unset($params[ 'id' ]) ;

        $enterdUserInfo = \f\ttt::dal('core.auth.getLoginInfo') ;

        $ownerId = $enterdUserInfo[ 'id' ] ;
//        $userId  = $enterdUserInfo[ 'id' ] ;

        $params[ 'owner_id' ] = $ownerId ;

        //   $repeat = $this->sqlEngine->check_unique ( array ( 'table' => $this->data_table, 'check' => array ( 'username' => $params[ 'username' ] ) ) ) ;
        if ( ! $editId )
        {
            $result = $this->sqlEngine->save($this->tb_permission, $params) ;
        }
        else
        {

            $result = $this->sqlEngine->save($this->tb_permission, $params,
                                             array (
                'id=?', array ( $editId )
                    )) ;
        }
        return $result ;
    }

    public function saveFilter()
    {
        $params = $this->request->getAssocParams() ;

        $editId = $params[ 'id' ] ;
        unset($params[ 'id' ]) ;

        if ( ! $editId )
        {
            $result = $this->sqlEngine->save($this->tb_core_filter, $params) ;
        }
        else
        {

            $result = $this->sqlEngine->save($this->tb_core_filter, $params,
                                             array (
                'id=?', array ( $editId )
                    )) ;
        }
        return $result ;
    }

    public function saveLogic()
    {
        $params = $this->request->getAssocParams() ;
        $editId = $params[ 'id' ] ;
        unset($params[ 'id' ]) ;

        if ( ! $editId )
        {
            $result = $this->sqlEngine->save($this->core_plogic, $params) ;
        }
        else
        {

            $result = $this->sqlEngine->save($this->core_plogic, $params,
                                             array (
                'id=?', array ( $editId )
                    )) ;
        }
        return $result ;
    }

    public function savePermissionLogic()
    {
        $params = $this->request->getAssocParams() ;
        $editId = $params[ 'id' ] ;

        unset($params[ 'id' ]) ;

        if ( ! $editId )
        {
            $result = $this->sqlEngine->save($this->tb_permission_plogic,
                                             $params) ;
        }
        else
        {

            $result = $this->sqlEngine->save($this->tb_permission_plogic,
                                             $params,
                                             array (
                'id=?', array ( $editId )
                    )) ;
        }
        return $result ;
    }

    public function saveMethodePermission()
    {
        $params = $this->request->getAssocParams() ;
        $type   = $params[ 'type' ] ;
        unset($params[ 'type' ]) ;

        $table = ($type == 'service') ? $this->tb_permission_service : $this->tb_permission_action ;

        //$repeat   = $this->sqlEngine->check_unique ( array ( 'table' => $table, 'check' => $params ) ) ;
        // if(!$repeat){
        $result = $this->sqlEngine->save($table, $params) ;
//        }
//        else{
//            $result = false;
//        }

        return $result ;
    }

    public function removeMethod()
    {

        $params = $this->request->getAssocParams() ;
        $type   = $params[ 'type' ] ;


        $table = ($type == 'service') ? $this->tb_permission_service : $this->tb_permission_action ;
        $this->sqlEngine->remove($table,
                                 array ( 'core_permissionid=?', array ( $params[ 'pr_id' ] ) )) ;
    }

    public function removeComponent()
    {

        $params = $this->request->getAssocParams() ;
        $type   = $params[ 'type' ] ;


        $table = ($type == 'service') ? $this->tb_permission_app : $this->tb_permission_ui ;
        $this->sqlEngine->remove($table,
                                 array ( 'core_permissionid=?', array ( $params[ 'pr_id' ] ) )) ;
    }

    public function saveComponentPermission()
    {
        $params = $this->request->getAssocParams() ;
        $type   = $params[ 'type' ] ;
        unset($params[ 'type' ]) ;

        $table = ($type == 'service') ? $this->tb_permission_app : $this->tb_permission_ui ;

        $result = $this->sqlEngine->save($table, $params) ;
        return $result ;
    }

    public function getPermission()
    {
        $id = $this->request->getParam('id') ;

        $this->sqlEngine->Select()
                ->From($this->tb_permission . ' AS t1')
                ->Where(" t1.id = '" . $id . "' ")
                ->Run() ;
        return $this->sqlEngine->getRow() ;
    }

    public function getAllPermission()
    {

        $this->sqlEngine->Select()
                ->From($this->tb_permission . ' AS t1')
                ->Run() ;
        return $this->sqlEngine->getRows() ;
    }

    public function getPermissionActionFilter()
    {

        $permissionId = $this->request->getParam('permissionId') ;
        $this->sqlEngine->Select('t1.*, t2.path')
                ->From($this->tb_permission_action . ' AS t1')
                ->innerJoin('core_action AS t2')
                ->On("t1.core_actionid = t2.id ")
                ->Where(" t1.core_filterid != 0")
                ->andWhere(" t1.core_permissionid =?", $permissionId)
                ->Run() ;
        return $this->sqlEngine->getRows() ;
    }

    public function getLogic()
    {
        $id = $this->request->getParam('id') ;
        $this->sqlEngine->Select()
                ->From($this->core_plogic . ' AS t1')
                ->Where(" t1.id = '" . $id . "' ")
                ->Run() ;
        return $this->sqlEngine->getRow() ;
    }

    public function getPermissionLogics()
    {
        $permissionid = $this->request->getParam('permissionid') ;
        $this->sqlEngine->Select()
                ->From($this->tb_permission_plogic . ' AS t1')
                ->Where(" t1.core_permissionid = '" . $permissionid . "' ")
                ->Run() ;
        return $this->sqlEngine->getRows() ;
    }

    public function getPermissionUI()
    {
        $id = $this->request->getParam('id') ;
        $this->sqlEngine->Select('t1.*, t2.path')
                ->From($this->tb_permission_ui . ' AS t1')
                ->innerJoin('core_ui AS t2')
                ->On("t1.core_uiid = t2.id ")
                ->Where(" t1.core_permissionid = '" . $id . "' ")
                ->Run() ;
        return $this->sqlEngine->getRows() ;
    }

    public function getPermissionApp()
    {
        $id = $this->request->getParam('id') ;
        $this->sqlEngine->Select('t1.*, t2.path')
                ->From($this->tb_permission_app . ' AS t1')
                ->innerJoin('core_app AS t2')
                ->On("t1.core_appid = t2.id ")
                ->Where(" t1.core_permissionid = '" . $id . "' ")
                ->Run() ;
        return $this->sqlEngine->getRows() ;
    }

    public function getAction()
    {
        $id = $this->request->getParam('actionid') ;
        $this->sqlEngine->Select('t1.*')
                ->From('core_action AS t1')
                ->Where(" t1.id = '" . $id . "' ")
                ->Run() ;
        return $this->sqlEngine->getRow() ;
    }

    public function getPermissionAction()
    {
        $id = $this->request->getParam('id') ;
        $this->sqlEngine->Select('t1.*, t2.path')
                ->From($this->tb_permission_action . ' AS t1')
                ->innerJoin('core_action AS t2')
                ->On("t1.core_actionid = t2.id ")
                ->Where(" t1.core_permissionid = '" . $id . "' ")
                ->Run() ;

        return $this->sqlEngine->getRows() ;
    }

    public function getFilterPermissionAction()
    {
        $id       = $this->request->getParam('id') ;
        $actionid = $this->request->getParam('actionid') ;
        $this->sqlEngine->Select('t1.*, t2.path')
                ->From($this->tb_permission_action . ' AS t1')
                ->innerJoin('core_action AS t2')
                ->On("t1.core_actionid = t2.id ")
                ->Where(" t1.core_permissionid =?", $id)
                ->andWhere(" t1.core_actionid =?", $actionid)
                ->Run() ;

        return $this->sqlEngine->getRow() ;
    }

    public function getPermissionService()
    {
        $id = $this->request->getParam('id') ;
        $this->sqlEngine->Select('t1.*, t2.path')
                ->From($this->tb_permission_service . ' AS t1')
                ->innerJoin('core_service AS t2')
                ->On("t1.core_serviceid = t2.id ")
                ->Where(" t1.core_permissionid = '" . $id . "' ")
                ->Run() ;
        return $this->sqlEngine->getRows() ;
    }

    public function permissionRemove()
    {

        $result = $this->sqlEngine->remove($this->tb_permission,
                                           array ( 'id=?', array ( $this->request->getParam('id') ) )) ;

        return true ;
    }

    public function logicRemove()
    {
        $result = $this->sqlEngine->remove($this->core_plogic,
                                           array ( 'id=?', array ( $this->request->getParam('id') ) )) ;

        return true ;
    }

    public function filterRemove()
    {
        $result = $this->sqlEngine->remove($this->tb_core_filter,
                                           array ( 'id=?', array ( $this->request->getParam('id') ) )) ;

        return true ;
    }

    public function getPermissionLogicRemoved()
    {
        $pr_id = $this->request->getParam('pr_id') ;
        $pl_id = $this->request->getParam('pl_id') ;
        $where = '' ;
        $i     = 0 ;
        foreach ( $pl_id as $val )
        {
            $and = ($i == 0) ? '' : 'and' ;
            $where .= " $and t1.id!= $val" ;
            $i ++ ;
        }
        $this->sqlEngine->Select()
                ->From($this->tb_permission_plogic . ' AS t1')
                ->Where(" t1.core_permissionid = '" . $pr_id . "' ")
                ->andWhere($where)
                ->Run() ;

        return $this->sqlEngine->getRows() ;
    }

    public function removePermissionLogic()
    {

        $result = $this->sqlEngine->remove($this->tb_permission_plogic,
                                           array ( 'id=?', array ( $this->request->getParam('pl_id') ) )) ;

        return true ;
    }

    public function getFiltersMethod()
    {
        $filter_maker_id = $this->request->getParam('filter_maker_id') ;
        $this->sqlEngine->Select('t1.*')
                ->From($this->tb_core_filter . ' AS t1')
                ->Where(" t1.core_actionid =?", $filter_maker_id)
                ->Run() ;
        return $this->sqlEngine->getRows() ;
    }

}
