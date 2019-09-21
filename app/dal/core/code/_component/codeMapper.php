<?php

class codeMapper extends \f\dal
{

    /**
     *
     * @var \f\sqlStorageEngine 
     */
    //  private $sqlEngine ;
    private $core_app ;
    private $core_ui ;
    private $core_service ;
    private $core_action ;
    private $action_param ;
    private $service_param ;

    public function __construct()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;

        $this->core_app      = 'core_app' ;
        $this->core_ui       = 'core_ui' ;
        $this->core_service  = 'core_service' ;
        $this->core_action   = 'core_action' ;
        $this->action_param  = 'core_action_param' ;
        $this->service_param = 'core_service_param' ;
    }

    public function getLegacyModulesList()
    {
        $this->sqlEngine->Select()
                ->From('cms_plugins')
                ->Where('status = 1 && type = 1')
                ->Run() ;

        return $this->sqlEngine->getRows() ;
    }

    public function getServiceRoutes()
    {
        $this->sqlEngine->Select()
                ->From('core_service')
                ->Run() ;
        return $this->sqlEngine->getRows() ;
    }

    public function getBackendRoutes()
    {
        $this->sqlEngine->Select()
                ->From('core_action')
                ->Run() ;
        return $this->sqlEngine->getRows() ;
    }

    public function getSubUI()
    {
        $parent = $this->request->getParam('parent') ;

        $this->sqlEngine->Select()->From('core_ui') ;
        if ( empty($parent) )
        {
            $this->sqlEngine->Where("path NOT LIKE '%.%'") ;
        }
        else
        {
            $this->sqlEngine->Where("path LIKE '$parent.%' and path NOT LIKE '$parent.%.%' ") ;
        }

        $this->sqlEngine->OrderBy('display_order') ;
        $this->sqlEngine->Run() ;

        return $this->sqlEngine->getRows() ;
    }

    public function getSubApp()
    {
        $parent = $this->request->getParam('parent') ;

        $this->sqlEngine->Select()->From('core_app') ;
        if ( empty($parent) )
        {
            $this->sqlEngine->Where("path NOT LIKE '%.%'") ;
        }
        else
        {
            $this->sqlEngine->Where("path LIKE '$parent.%'") ;
        }

        $this->sqlEngine->Run() ;

        return $this->sqlEngine->getRows() ;
    }

    public function getAction()
    {
        $this->sqlEngine->Select()
                ->From('core_action')
                ->Where("path = ?", $this->request->getParam('path'))
                ->Run() ;
        return $this->sqlEngine->getRow() ;
    }

    public function getActionParams()
    {
        $this->sqlEngine->Select()
                ->From('core_action_param')
                ->Where("core_actionid = ?",
                        $this->request->getParam('actionId'))
                ->Run() ;
        return $this->sqlEngine->getRows() ;
    }

    public function getApp()
    {
        $this->sqlEngine->Select()
                ->From('core_app')
                ->Where("path = ?", $this->request->getParam('path'))
                ->Run() ;
        return $this->sqlEngine->getRow() ;
    }

    public function getAppParent()
    {
        $this->sqlEngine->Select('id,name')
                ->From('core_app')
                ->Where("name = ?", $this->request->getParam('name'))
                ->Run() ;
        return $this->sqlEngine->getRow() ;
    }

    public function getService()
    {
        $this->sqlEngine->Select()
                ->From('core_service')
                ->Where("path = ?", $this->request->getParam('path'))
                ->Run() ;
        return $this->sqlEngine->getRow() ;
    }

    public function getServiceParams()
    {
        $this->sqlEngine->Select()
                ->From('core_service_param')
                ->Where("core_serviceid = ?",
                        $this->request->getParam('seviceId'))
                ->Run() ;
        return $this->sqlEngine->getRows() ;
    }

    public function getUI()
    {
        $this->sqlEngine->Select()
                ->From('core_ui')
                ->Where("path = ?", $this->request->getParam('path'))
                ->Run() ;
        return $this->sqlEngine->getRow() ;
    }

    public function getParentUI()
    {
        $this->sqlEngine->Select('id,name')
                ->From('core_ui')
                ->Where("name = ?", $this->request->getParam('name'))
                ->Run() ;
        return $this->sqlEngine->getRow() ;
    }

    public function getMultiUI()
    {
        $inList  = "" ;
        $parents = $this->request->getParam('parents') ;
        $section = '' ;
        foreach ( $parents as $key => $parent )
        {
            $inList .= "'$section$parent'" . ($key < count($parents) - 1 ? ',' : '') ;
            $section.=$parent . '.' ;
        }
        //\f\pr($inList);
        $this->sqlEngine->Select()
                ->From('core_ui')
                ->Where("path in ($inList)")
                ->OrderBy('id')
                ->Run() ;

        return $this->sqlEngine->getRows() ;
    }

    //--------------------------------------------------------------------------
    public function getAllServices()
    {
        $this->sqlEngine->Select()
                ->From('core_service')
                ->OrderBy('id')
                ->Run() ;

        return $this->sqlEngine->getRows() ;
    }

    //--------------------------------------------------------------------------
    public function getAllActions()
    {
        $params = $this->request->getAssocParams() ;

        $this->sqlEngine->Select()
                ->From('core_action') ;

        if ( isset($params[ 'dontReturnFilters' ]) )
        {
            $this->sqlEngine->Where(' filter_type != "filter" ') ;
        }

        $this->sqlEngine->OrderBy('id')
                ->Run() ;

        return $this->sqlEngine->getRows() ;
    }

    public function getfilterActions()
    {
        $core_uiid = $this->request->getParam('core_uiid') ;

        $this->sqlEngine->Select()
                ->From($this->core_action)
                ->Where('filter_type =?', 'filter')
                ->andWhere('core_uiid =?', $core_uiid)
                ->OrderBy('id')
                ->Run() ;

        return $this->sqlEngine->getRows() ;
    }

    /**
     * Returns all actions by type
     * @return array
     */
    public function getActionByFilterType()
    {
        $filter_type = $this->request->getParam('filter_type') ;

        $this->sqlEngine->Select()
                ->From('core_action')
                ->Where('filter_type = ?', $filter_type)
                ->OrderBy('id')
                ->Run() ;

        return $this->sqlEngine->getRows() ;
    }

    function getAppList()
    {
        $this->sqlEngine->Select()
                ->From('core_app')
                ->Where("parent_id IS NULL")
                ->OrderBy('display_order')
                ->Run() ;

        return $this->sqlEngine->getRows() ;
    }

    function getUIByParent()
    {
        $target = $this->request->getParam('target') ;
        $where  = '' ;
        switch ( $target )
        {
            case 'all':
                $where = '' ;
                break ;
            case 'byLevel':
                $level = $this->request->getParam('level') ;

                $pattern = '' ;
                while ( $level -- )
                {
                    $pattern .= "%." ;
                }
                if ( $this->request->getParam('level') > 0 )
                {
                    $pattern .= '%' ;
                    $where = "path LIKE '$pattern'" ;
                }
                else
                {
                    $where = "path NOT LIKE '%.%'" ;
                }
                break ;
        }
        $this->sqlEngine->Select()
                ->From('core_ui') ;
        if ( ! empty($where) )
        {
            $this->sqlEngine->where($where) ;
        }
        $this->sqlEngine->OrderBy('display_order')->Run() ;
//        return $this->sqlEngine->last_query();
        return $this->sqlEngine->getRows() ;
    }

    function getAllApps()
    {
        $this->sqlEngine->Select()
                ->From('core_app')
                ->OrderBy('id')
                ->Run() ;
        return $this->sqlEngine->getRows() ;
    }

    function getAllUI()
    {
        $this->sqlEngine->Select()
                ->From('core_ui')
                ->OrderBy('id')
                ->Run() ;
        return $this->sqlEngine->getRows() ;
    }

    //--------------------------------------------------------------------------
    function appSave()
    {
        $params = $this->request->getAssocParams() ;
        $editId = $params[ 'id' ] ;
        unset($params[ 'id' ]) ;
        //   $repeat = $this->sqlEngine->check_unique ( array ( 'table' => $this->data_table, 'check' => array ( 'username' => $params[ 'username' ] ) ) ) ;
        if ( ! $editId )
        {


            $result = $this->sqlEngine->save($this->core_app, $params) ;
        }
        else
        {

            $result = $this->sqlEngine->save($this->core_app, $params,
                                             array (
                'id=?', array ( $editId )
                    )) ;
        }

        return $result ;
    }

    //--------------------------------------------------------------------------
    function uiSave()
    {
        $params = $this->request->getAssocParams() ;
        $editId = $params[ 'id' ] ;
        unset($params[ 'id' ]) ;
        //   $repeat = $this->sqlEngine->check_unique ( array ( 'table' => $this->data_table, 'check' => array ( 'username' => $params[ 'username' ] ) ) ) ;
        if ( ! $editId )
        {

            $result = $this->sqlEngine->save($this->core_ui, $params) ;
        }
        else
        {
            $result = $this->sqlEngine->save($this->core_ui, $params,
                                             array (
                'id=?', array ( $editId )
                    )) ;
        }

        return $result ;
    }

    //--------------------------------------------------------------------------
    function srviceSave()
    {
        $params = $this->request->getAssocParams() ;

        $editId = $params[ 'id' ] ;
        unset($params[ 'id' ]) ;
        //   $repeat = $this->sqlEngine->check_unique ( array ( 'table' => $this->data_table, 'check' => array ( 'username' => $params[ 'username' ] ) ) ) ;
        if ( ! $editId )
        {

            $result = $this->sqlEngine->save($this->core_service, $params) ;
        }
        else
        {
            $result = $this->sqlEngine->save($this->core_service, $params,
                                             array (
                'id=?', array ( $editId )
                    )) ;
        }

        return ( ! $editId) ? $result : $editId ;
    }

    //--------------------------------------------------------------------------
    function actionSave()
    {
        $params = $this->request->getAssocParams() ;
        $editId = $params[ 'id' ] ;
        unset($params[ 'id' ]) ;
        //   $repeat = $this->sqlEngine->check_unique ( array ( 'table' => $this->data_table, 'check' => array ( 'username' => $params[ 'username' ] ) ) ) ;
        if ( ! $editId )
        {

            $result = $this->sqlEngine->save($this->core_action, $params) ;
        }
        else
        {
            $result = $this->sqlEngine->save($this->core_action, $params,
                                             array (
                'id=?', array ( $editId )
                    )) ;
        }
        return ( ! $editId) ? $result : $editId ;
    }

    //--------------------------------------------------------------------------
    function serviceParamSave()
    {
        $params = $this->request->getAssocParams() ;
        $editId = $params[ 'id' ] ;
        unset($params[ 'id' ]) ;
        //   $repeat = $this->sqlEngine->check_unique ( array ( 'table' => $this->data_table, 'check' => array ( 'username' => $params[ 'username' ] ) ) ) ;
        if ( ! $editId )
        {

            $result = $this->sqlEngine->save($this->service_param, $params) ;
        }
        else
        {
            $result = $this->sqlEngine->save($this->service_param, $params,
                                             array (
                'id=?', array ( $editId )
                    )) ;
        }
        return $result ;
    }

    //-------------------------------------------------------------------------
    function actionParamSave()
    {
        $params = $this->request->getAssocParams() ;

        $editId = $params[ 'id' ] ;
        unset($params[ 'id' ]) ;
        //   $repeat = $this->sqlEngine->check_unique ( array ( 'table' => $this->data_table, 'check' => array ( 'username' => $params[ 'username' ] ) ) ) ;
        if ( ! $editId )
        {

            $result = $this->sqlEngine->save($this->action_param, $params) ;
        }
        else
        {

            $result = $this->sqlEngine->save($this->action_param, $params,
                                             array (
                'id=?', array ( $editId )
                    )) ;
        }
        return $result ;
    }

    //--------------------------------------------------------------------------

    public function removeMethodDocument()
    {
        $params = $this->request->getAssocParams() ;

        $id   = $params[ 'id' ] ;
        $type = $params[ 'type' ] ;


        $tb = ($type == 'ui') ? $this->core_action : $this->core_service ;

        $result = $this->sqlEngine->remove($tb, array ( 'id=?', array ( $id ) )) ;

        return true ;
    }

    //--------------------------------------------------------------------------
    public function removeComponentDocument()
    {
        $params = $this->request->getAssocParams() ;

        $id   = $params[ 'id' ] ;
        $type = $params[ 'type' ] ;


        if ( $type == 'ui' )
        {
            $result = $this->sqlEngine->remove($this->core_action,
                                               array ( 'core_uiid=?', array ( $id ) )) ;
            $this->sqlEngine->remove($this->core_ui,
                                     array ( 'id=?', array ( $id ) )) ;
        }
        else
        {
            $result = $this->sqlEngine->remove($this->core_service,
                                               array ( 'core_appid=?', array ( $id ) )) ;

            $this->sqlEngine->remove($this->core_app,
                                     array ( 'id=?', array ( $id ) )) ;
        }
        return true ;
    }

}
