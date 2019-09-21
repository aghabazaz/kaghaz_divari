<?php

/**
 * This component detects modules/components/plugins from
 * project source code structure and manages them.
 * 
 * @author Yuness Mehdian <mehdian.y@gmail.com>
 * @package core.code
 * @category component
 */
class codeService extends \f\service
{
    /*
     * 
     * * *************** Application ******************
     * 
     */

    public function getAppListTree()
    {
        $services = $this->getAllServices() ;
        $appList  = $this->getAllAppsList() ;

        $serviceObj = new service ;
        return $serviceObj->getServiceListTree($appList, $services) ;
    }

    public function getAllAppsList()
    {
        return \f\ttt::dal('core.code.getAllApps') ;
    }

    public function getAllServices()
    {
        return \f\ttt::dal('core.code.getAllServices') ;
    }

    public function getAllUIList()
    {
        return \f\ttt::dal('core.code.getAllUI') ;
    }

    public function getMultiUI()
    {
        return \f\ttt::dal('core.code.getMultiUI',
                           array (
                    'parents' => $this->request->getParam('parents')
                )) ;
    }

    /*
     * 
     * * *************** User Interface ******************
     * 
     */

    public function getUIListTree()
    {
        $actions = $this->getAllActions() ;
        $UIList  = $this->getAllUIList() ;

        $uiObj = new ui() ;
        return $uiObj->getUIListTree($UIList, $actions) ;
    }

    public function getSubUI()
    {
        if ( ! $this->checkParams($this->request, array ( 'parent' )) )
        {
            return array (
                'result'  => 'failed',
                'message' => 'Check parameters !'
                    ) ;
        }

        return \f\ttt::dal('core.code.getSubUI',
                           array (
                    'parent' => $this->request->getParam('parent')
                )) ;
    }

    public function getAction()
    {

        return \f\ttt::dal('core.code.getAction',
                           array (
                    'path' => $this->request->getParam('path')
                )) ;
    }

    public function getActionParams()
    {

        return \f\ttt::dal('core.code.getActionParams',
                           array (
                    'actionId' => $this->request->getParam('actionId')
                )) ;
    }

    public function getApp()
    {
        return \f\ttt::dal('core.code.getApp',
                           array (
                    'path' => $this->request->getParam('path')
                )) ;
    }

    public function getAppParent()
    {

        \f\pr($this->request->getParam('paramName')) ;
        return \f\ttt::dal('core.code.getAppParent',
                           array (
                    'name' => $this->request->getParam('paramName')
                )) ;
    }

    public function getService()
    {
        return \f\ttt::dal('core.code.getService',
                           array (
                    'path' => $this->request->getParam('path')
                )) ;
    }

    public function getServiceParams()
    {
        return \f\ttt::dal('core.code.getServiceParams',
                           array (
                    'seviceId' => $this->request->getParam('seviceId')
                )) ;
    }

    public function getUI()
    {
        return \f\ttt::dal('core.code.getUI',
                           array (
                    'path' => $this->request->getParam('path')
                )) ;
    }

    public function getParentUI()
    {
        return \f\ttt::dal('core.code.getParentUI',
                           array (
                    'name' => $this->request->getParam('paramName')
                )) ;
    }

    public function getAllActions()
    {
        return \f\ttt::dal('core.code.getAllActions') ;
    }

    public function getfilterActions()
    {
        return \f\ttt::dal('core.code.getfilterActions',
                           array (
                    'core_uiid' => $this->request->getParam('core_uiid')
                )) ;
    }
    
    public function getAllfilterActions()
    {
      
        return \f\ttt::dal('core.code.getAllfilterActions',
                           array (
                    'filter_type' => $this->request->getParam('type')
                )) ;
    }

    /*
     * 
     * * *************** Legacy ******************
     * 
     */

    public function getAllLegacyList()
    {
        $legacyObj = new legacy ;
        return $legacyObj->getLegacyList() ;
    }

    public function getLegacyModulesList()
    {
        $legacyObj = new legacy ;
        return $legacyObj->getModulesList() ;
    }

    /*
     * 
     * * *************** Other ******************
     * 
     */

    public function getAllRunnableCodes()
    {
        $tierHierarchiScanner = new tierHierarchiScanner ;

        $serviceDocs = array (
            'componentsDoc' => $this->getAllAppsList(),
            'methodsDoc'    => $this->getAllServices()
                ) ;
        $UIDocs      = array (
            'componentsDoc' => $this->getAllUIList(),
            'methodsDoc'    => $this->getAllActions()
                ) ;

        $UICombined      = $tierHierarchiScanner->scanTierRecursive('ui',
                                                                    $UIDocs) ;
        $serviceCombined = $tierHierarchiScanner->scanTierRecursive('service',
                                                                    $serviceDocs) ;
        return array (
            'service' => $serviceCombined,
            'ui'      => $UICombined
                ) ;
    }

    public function getUIByParent()
    {
        return \f\ttt::dal('core.code.getUIByParent', $this->request) ;
    }

    public function getMainModulesList()
    {
        $uiObj = new ui ;
        return $uiObj->getMainModulesList() ;
    }

    public function translateRequest()
    {
        $urlParts = $this->request->getParam('urlParts') ;

        switch ( $this->request->getParam('requestType') )
        {
            case 'service':
                $serviceObj = new service ;
                return $serviceObj->translateServiceRequest($urlParts) ;
            case 'ui.backend':
                $uiObj      = new ui ;
                return $uiObj->translateBackendRequest($urlParts) ;
        }
    }

    /**
     * 
     * ******************** Internal usage **************************
     * 
     */
    public function __construct()
    {
        spl_autoload_register(array ( 'codeService', '__autoload' )) ;
    }

    public function __destruct()
    {
        spl_autoload_unregister('autoload') ;
    }

    private function __autoload($className)
    {
        $pathToClassFile = __DIR__ . \f\DS . 'model' . \f\DS . $className . '.php' ;
        if ( file_exists($pathToClassFile) )
        {
            require_once $pathToClassFile ;
        }
    }

    /**
     * 
     * ********************save**************************
     * 
     */
    function documentSave()
    {
        $params = $this->request->getAssocParams() ;

        // $act = (!$params['id']) ? 'add' : 'edit';
        //  $valid  = $this->validation ( $params ) ;
        $type = explode(".", $params[ 'typeComp' ]) ;


        if ( $type[ 0 ] == 'method' )
        {
            $result = $this->saveMethodDoc($params, $type[ 1 ]) ;
        }
        else
        {
            $result = $this->saveComponentDoc($params, $type[ 1 ]) ;
        }
        if ( $result )
        {
            $out = array ( 'success', \f\ifm::t('successSave') ) ;
        }
        else
        {
            $out = array ( 'error', \f\ifm::t('errorDB') ) ;
        }

        return $out ;
    }

    //--------------------------------------------------------------------------
    private function saveMethodDoc($params, $type)
    {

        $data[ 'id' ]          = $params[ 'id' ] ;
        $data[ 'title' ]       = $params[ 'title' ] ;
        $data[ 'name' ]        = $params[ 'name' ] ;
        $data[ 'type' ]        = $params[ 'type' ] ;
        $data[ 'status' ]      = $params[ 'status' ] ;
        $data[ 'path' ]        = $params[ 'path' ] ;
        $data[ 'description' ] = $params[ 'description' ] ;
        if ( $type == 'service' )
        {
            $data[ 'core_appid' ] = $params[ 'parent_id' ] ;

            $result = \f\ttt::dal('core.code.srviceSave', $data) ;
        }
        else
        {
            $data[ 'core_uiid' ]       = $params[ 'parent_id' ] ;
            $data[ 'filter_maker_id' ] = $params[ 'filter_maker_id' ] ;
            $data[ 'filter_type' ]     = $params[ 'filter_type' ] ;
            $result                    = \f\ttt::dal('core.code.actionSave',
                                                     $data) ;
        }
        $parentid = $result ;
        if ( $result )
        {
            for ( $i = 0 ; $i < count($params[ 'p_name' ]) ; $i ++ )
            {
                if ( $params[ 'p_name' ][ $i ] )
                {
                    $data_p[ 'id' ]            = $params[ 'p_id' ][ $i ] ;
                    $data_p[ 'title' ]         = $params[ 'p_title' ][ $i ] ;
                    $data_p[ 'name' ]          = $params[ 'p_name' ][ $i ] ;
                    $data_p[ 'type' ]          = $params[ 'p_type' . $i ][ 0 ] ;
                    $required                  = $params[ 'required' . $i ][ 0 ] ;
                    $required                  = ($required) ? $required : 'notRequired' ;
                    $data_p[ 'required' ]      = $required ;
                    $data_p[ 'description' ]   = $params[ 'p_description' ][ $i ] ;
                    $data_p[ 'default_value' ] = $params[ 'defaultValue' ][ $i ] ;

                    if ( $type == 'service' )
                    {
                        $data_p[ 'core_serviceid' ] = $parentid ;
                        $result                     = \f\ttt::dal('core.code.serviceParamSave',
                                                                  $data_p) ;
                    }
                    else
                    {
                        $data_p[ 'core_actionid' ] = $parentid ;
                        // \f\pr($data_p);
                        $result                    = \f\ttt::dal('core.code.actionParamSave',
                                                                 $data_p) ;
                    }
                }
            }
        }
        return $result ;
    }

    //--------------------------------------------------------------------------
    private function saveComponentDoc($params, $type)
    {

        $data[ 'id' ]            = $params[ 'id' ] ;
        $data[ 'title' ]         = $params[ 'title' ] ;
        $data[ 'name' ]          = $params[ 'name' ] ;
        $data[ 'type' ]          = $params[ 'type' ] ;
        $data[ 'display_order' ] = ($params[ 'display_order' ])  ? $params[ 'display_order' ] : 0 ;
        $data[ 'status' ]        = $params[ 'status' ] ;
        $data[ 'path' ]          = $params[ 'path' ] ;
        $data[ 'description' ]   = $params[ 'description' ] ;
        $data[ 'parent_id' ]     = $params[ 'parent_id' ] ;

        if ( $type == 'service' ){
            $data[ 'icon' ] = ($params[ 'icon' ])  ? $params[ 'icon' ] : '' ;
            
            return \f\ttt::dal('core.code.appSave', $data) ;
        }       
        else{
            $data[ 'icon_id' ]       = ($params[ 'icon_id' ])  ? $params[ 'icon_id' ] : 0 ;
            return \f\ttt::dal('core.code.uiSave', $data) ;
        } 
    }

    //---------------------------------------------------------------------------
    private function validation($params)
    {
        /* @var $validator \f\g\validator */
        $validator   = \f\gadgetFactory::make('validator') ;
        $paramGroupV = array (
            'defult' => array (
                array (
                    'rule' => 'checkEmpty'
                )
            )
                ) ;
        if ( $validator->group($paramGroupV) === false )
        {
            return $validator->getMessage() ;
        }
        else
        {
            return true ;
        }
    }

}
