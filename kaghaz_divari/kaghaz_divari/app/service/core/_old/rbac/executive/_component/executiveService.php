<?php

/**
 * 
 * This sub component does following tasks :
 * 1- Cache permissions 
 * 2- Check access to run the method or not
 * 3- Get filter of the method
 * 4- Get and cache permission logics 
 * 
 * @author Yuness Mehdian <mehdian.@gmail.com>
 * @package core.rbac.executive
 * @category component
 * 
 */
class executiveService extends \f\service
{

    public function checkPermission()
    {
        $path = $this->request->getParam('path') ;

        $cachedPermissions = \f\ttt::dal('core.rbac.executive.getCachedPermissions') ;

        if ( isset($cachedPermissions[ 'actions' ][ $path ]) )
        {
            if ( $cachedPermissions[ 'actions' ][ $path ][ 'status' ] == 'disabled' )
            {
                return false ;
            }
            $permissionId = $cachedPermissions[ 'actions' ][ $path ][ 'permissionId' ] ;
            $logicsResult = true ;
            if ( isset($cachedPermissions[ 'permissions' ][ $permissionId ]) )
            {
                $logics       = $cachedPermissions[ 'permissions' ][ $permissionId ] ;
                $logicsResult = $this->runLogics($logics) ;
            }
            if ( $logicsResult )
            {
                return $cachedPermissions[ 'actions' ][ $path ][ 'filterSettings' ] ;
            }
        }
        return 1 ; # permission denied
    }

    public function cachePermissions()
    {
        
        $userId = $this->request->getParam('userId') ;
       
        $a=\f\ttt::dal('core.rbac.executive.cacheMyPermissions',
                    array (
            'userId' => $userId
        )) ;

        return true ;
    }
    

    private function runLogics($logics)
    {
        $result      = true ;
        $serviceRoot = \f\ifm::app()->serviceDir ;

        $logicsRoot = $serviceRoot . \f\DS . str_replace('.', \f\DS,
                                                         'core.rbac._component.model.logic.') ;

        foreach ( $logics as $logicFileName => $logic )
        {

            if ( $logic[ 'status' ] == 'disabled' )
            {
                continue ;
            }
            $logicClassName = substr($logicFileName, 0,
                                     strpos($logicFileName, '.')) ;

            if ( file_exists($logicsRoot . $logicFileName) && ! class_exists($logicClassName) )
            {
                include $logicsRoot . $logicFileName ;
            }
            $result = true ;
            if ( class_exists($logicClassName) )
            {
                $logicObj = new $logicClassName ;
                $result   = $result && $logicObj->run($logic[ 'settings' ]) ;
            }
        }
        return $result ;
    }
    
    public function getMyAction()
    {
        
        $userId = $this->request->getParam('userId') ;
       
        $action=\f\ttt::dal('core.rbac.executive.getMyAction',
                    array (
            'userId' => $userId
        )) ;

        return $action ;
    }

}
