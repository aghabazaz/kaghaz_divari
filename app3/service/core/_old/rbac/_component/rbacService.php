<?php

/**
 * 
 * The RBAC manages authorizations to hole applications parts. All external
 * request control by the rbac.
 * 
 * @author mina hajian <mehdian.y@gmail.com>
 * @package core.rbac
 * @category component
 * 
 */
final class rbacService extends \f\service
{

    private $permission ;

    private function registerPermission()
    {
        
        /* @var $permission rbac */
        if ( ! class_exists('permission') )
        {
            require_once __DIR__ . \f\DS . 'model' . \f\DS . 'permission.php' ;
        }
        $this->permission = new permission ;
    }

    public function getPermissions()
    {
        return \f\ttt::dal('core.rbac.getPermissions',
                           $this->request->getAssocParams()) ;
    }

    public function getAllPermission()
    {
        return \f\ttt::dal('core.rbac.getAllPermission') ;
    }

    public function getMethodPermission()
    {
        return \f\ttt::dal('core.rbac.getMethodPermission',
                           $this->request->getAssocParams()) ;
    }

    public function getLogics()
    {
        return \f\ttt::dal('core.rbac.getLogics',
                           $this->request->getAssocParams()) ;
    }

    public function getAllLogics()
    {
        return \f\ttt::dal('core.rbac.getAllLogics') ;
    }

    public function getAllEnableLogics()
    {
        return \f\ttt::dal('core.rbac.getAllEnableLogics') ;
    }

    public function getLogic()
    {
        return \f\ttt::dal('core.rbac.getLogic',
                           array ( 'id' => $this->request->getParam('id') )) ;
    }

    public function getAction()
    {
        return \f\ttt::dal('core.rbac.getAction',
                           array ( 'actionid' => $this->request->getParam('actionid') )) ;
    }

    public function getPermissionActionFilter()
    {
        return \f\ttt::dal('core.rbac.getPermissionActionFilter',
                           array ( 'permissionId' => $this->request->getParam('permissionId') )) ;
    }

    public function permissionSave()
    {

        if ( ! $this->permission )
        {
            $this->registerPermission() ;
        }

        $params = $this->request->getAssocParams() ;
        $out    = $this->permission->permission_Save($params) ;
        return $out ;
    }

    public function permissionLogicParamSave()
    {
        if ( ! $this->permission )
        {
            $this->registerPermission() ;
        }
        $params     = $this->request->getAssocParams() ;
        $validParam = $this->validParam($params[ 'setting' ]) ;
        if ( ! is_array($valid) )
        {
            if ( $params[ 'pl_id' ] )
            {

                $this->saveParamLogic($params[ 'setting' ], $params[ 'pl_id' ] , $params[ 'core_plogicid' ]) ;
                $out = array ( 'success', \f\ifm::t('successSave') ) ;
            }
            else
            {

                $pl_id  = false ;
                $result = $this->permission->savePermissionLogic($params[ 'core_plogicid' ],
                                                                 $params[ 'order' ],
                                                                 $params[ 'core_permissionid' ],
                                                                 $pl_id) ;
                if ( $result )
                {
                    $pl_id = $result ;
                    $this->saveParamLogic($params[ 'setting' ], $pl_id, $params[ 'core_plogicid' ]) ;
                    $out   = array ( 'success', \f\ifm::t('successSave') ) ;
                }
            }
        }
        else
        {
            $out = array ( 'error', $validParam ) ;
        }
        return $out ;
    }

    private function saveParamLogic($setting, $pl_id, $logicid)
    {

        foreach ( $setting as $key => $value )
        {
            $data[ 'keyValues' ][ $key ] = $value ;
        }
        $data[ 'params' ] = array ( 'PL_ID' => $pl_id, 'logicid' => $logicid ) ;

        \f\ttt::service('core.setting.saveKeyGroup', $data) ;
    }

    public function logicSave()
    {
        $params = $this->request->getAssocParams() ;
        $valid  = $this->validLogic($params) ;

        if ( ! is_array($valid) )
        {

            $result = \f\ttt::dal('core.rbac.saveLogic', $params) ;

            if ( $result )
            {
                $out = array ( 'success', \f\ifm::t('successSave') ) ;
            }
            else
            {
                $out = array ( 'error', \f\ifm::t('errorDB') ) ;
            }
        }
        else
        {
            $out = array ( 'error', $valid ) ;
        }
        return $out ;
    }

    public function getPermission()
    {
        return \f\ttt::dal('core.rbac.getPermission',
                           array ( 'id' => $this->request->getParam('id') )) ;
    }

    public function getPermissionUI()
    {
        return \f\ttt::dal('core.rbac.getPermissionUI',
                           array ( 'id' => $this->request->getParam('id') )) ;
    }

    public function getPermissionApp()
    {
        return \f\ttt::dal('core.rbac.getPermissionApp',
                           array ( 'id' => $this->request->getParam('id') )) ;
    }

    public function getPermissionAction()
    {
        return \f\ttt::dal('core.rbac.getPermissionAction',
                           array ( 'id' => $this->request->getParam('id') )) ;
    }

    public function getFilterPermissionAction()
    {
        return \f\ttt::dal('core.rbac.getFilterPermissionAction',
                           array ( 'id' => $this->request->getParam('id'), 'actionid' => $this->request->getParam('actionid') )) ;
    }

    public function getPermissionService()
    {
        return \f\ttt::dal('core.rbac.getPermissionService',
                           array ( 'id' => $this->request->getParam('id') )) ;
    }

    public function getPermissionLogics()
    {
        return \f\ttt::dal('core.rbac.getPermissionLogics',
                           array ( 'permissionid' => $this->request->getParam('permissionid') )) ;
    }

    public function permissionRemove()
    {
        $result = \f\ttt::dal('core.rbac.permissionRemove',
                              array ( 'id' => $this->request->getParam('id') )) ;
        if ( $result )
        {
            return array (
                'func' => 'remove'
                    ) ;
        }
        return false ;
    }

    function logicRemove()
    {
        $result = \f\ttt::dal('core.rbac.logicRemove',
                              array ( 'id' => $this->request->getParam('id') )) ;
        if ( $result )
        {
            return array (
                'func' => 'remove'
                    ) ;
        }
        return false ;
    }

    public function getMyServices()
    {
        $services = \f\ttt::dal('core.code.getServiceRoutes') ;
        $routes   = array () ;
        foreach ( $services as $service )
        {
            $routes[ $service[ 'path' ] ] = true ;
        }
        return $routes ;
    }

    public function getMyActions()
    {
        $actions = \f\ttt::dal('core.code.getBackendRoutes') ;
        $routes  = array () ;
        foreach ( $actions as $action )
        {
            $routes[ $action[ 'path' ] ] = true ;
        }
        return $routes ;
    }

    private function validParam($params)
    {
        /* @var $validator \f\g\validator */
        $validator   = \f\gadgetFactory::make('validator') ;
        $paramGroupV = array (
            'defult'  => array (
            ),
            'objects' => array (
                array (
                    'rule'   => array (
                        array (
                            'name' => 'checkEmpty'
                        )
                    ),
                    'object' => array ( $params[ 'value' ] )
                )
            ),
            'objects' => array (
                array (
                    'rule'   => array (
                        array (
                            'name' => 'checkEmpty'
                        )
                    ),
                    'object' => array ( $params[ 'time' ] )
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

    private function validLogic($params)
    {
        /* @var $validator \f\g\validator */
        $validator   = \f\gadgetFactory::make('validator') ;
        $paramGroupV = array (
            'defult'  => array (
            ),
            'objects' => array (
                array (
                    'rule'   => array (
                        array (
                            'name' => 'checkEmpty'
                        )
                    ),
                    'object' => array ( $params[ 'title' ] )
                )
            ),
            'objects' => array (
                array (
                    'rule'   => array (
                        array (
                            'name' => 'checkEmpty'
                        )
                    ),
                    'object' => array ( $params[ 'name' ] )
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
