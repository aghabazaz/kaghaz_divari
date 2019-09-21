<?php

namespace f ;

/**
 * The ttt class provides a simple communication between 3 tiers.
 * At now all 3 layers exists in a same machine and communications are as simply
 * as creating an object from target class in target tier(folder).
 * 
 * All internal and external requests should serve by this gateway.
 */
class ttt
{

    public static function block($blockRoute, $params = array ())
    {
        //\f\pr($params);
	error_reporting(E_ALL);
        return self::ui('ui.frontend.' . $blockRoute, $params) ;
    }
    public static function uiBackend($blockRoute, $params = array ())
    {
        return self::ui('ui.backend.' . $blockRoute, $params) ;
    }

    /**
     * Serve the request from presentation tier.
     */
    public static function ui($actionCatalog, $request = NULL)
    {
        
        list($componentType, $componentCatalog, $actionName) = self::breakRequest($actionCatalog) ;

        if ( empty($request) )
        {
            $request = new request ;
        }
        if ( is_array($request) )
        {
            $requestArray = $request ;
            $request      = new request ;

            if ( self::isAssoc($requestArray) )
            {
                $request->addAssocParam($requestArray) ;
            }
            else
            {
                $request->addNonAssocParam($requestArray) ;
            }
        }
        $constructorParams = NULL ;
        
        if ( $componentType === 'ui.frontend' )
        {
            $constructorParams[ 'templateName' ] = $request->getParam('templateName') ;
            $constructorParams[ 'pageName' ]     = $request->getParam('pageName') ;
            $constructorParams[ 'domainStatus' ] = $request->getParam('domainStatus') ;
            $request->deleteParam('templateName') ;
            $request->deleteParam('pageName') ;
            $request->deleteParam('domainStatus') ;
        }

        $methodFilter = $request->getParam('methodFilter') ;

        $request->deleteParam('methodFilter') ;

        $uiObject = componentFactory::get($componentType, $componentCatalog,
                                          $request, $constructorParams) ;

        $uiObject->methodFilter = $methodFilter ;
        //\f\pre($constructorParams);
        if ( method_exists($uiObject, $actionName) )
        {
            $componentTypeDS   = str_replace('.', DS, $componentType) ;
            $componentRouteDS  = str_replace('.', DS, $componentCatalog) ;
            $componentRouteURL = str_replace('.', '/', $componentCatalog) ;
            $componentTypeURL  = str_replace('.', '/', $componentType) ;

            if ( ifm::app()->getRunningModuleType() !== 'page' )
            {
                $triggerComponentDir = \f\ifm::app()->componentBaseDir ;
                $triggerComponentUrl = \f\ifm::app()->componentBaseDir ;
            }

            \f\ifm::app()->componentBaseUrl = 'http://' . ifm::app()->domain . "/app/$componentTypeURL/" . $componentRouteURL . '/_component/' ;
            \f\ifm::app()->componentBaseDir = ifm::app()->repoDir . DS . $componentTypeDS . DS . $componentRouteDS . DS . '_component' ;

            $actionResult = $uiObject->$actionName() ;

            if ( ifm::app()->getRunningModuleType() !== 'page' )
            {
                \f\ifm::app()->componentBaseDir = $triggerComponentDir ;
                \f\ifm::app()->componentBaseUrl = $triggerComponentUrl ;
            }
            //\f\pr(ifm::app()->getRunningModuleType());
            //\f\pre(self::renderUIResult($actionResult));
            return self::renderUIResult($actionResult) ;
        }
    }

    private static function renderUIResult($actionResult)
    {
        //\f\pr($actionResult);
        
        switch ( $actionResult->getType() )
        {
            
            case 'layouted':
            case 'partial':
                return $actionResult->getData() ;
            case 'json':
                $json=json_encode($actionResult->getData());
                header("Content-length:".strlen($json));
                return  $json;
        }
    }

    /**
     * Serve the request from service tier.
     */
   public static function service($serviceCatalog, $params = array ())
    {

        list($componentCatalog, $serviceName) = self::breakRequest($serviceCatalog) ;

        if ( ! is_array($params) )
        {
            $request = $params ;
        }
        else
        {
            $request = new request ;
            if ( self::isAssoc($params) ) /** Internal request * */
            {
                
                $request->addAssocParam($params) ;
            }
            else /** web service request * */
            {
                $request->addNonAssocParam($params) ;
            }
        }

        $constructorParams = array (
            'route'  => $componentCatalog,
            'method' => $serviceName
                ) ;

        /* @var $serviceObject \f\service */
        $serviceObject = componentFactory::get('service', $componentCatalog,
                                               $request, $constructorParams) ;
        //\f\pre($serviceObject->$serviceName());
        if ( method_exists($serviceObject, $serviceName) )
        {
            return $serviceObject->$serviceName() ;
        }
        throw new publicException("Service '$serviceName' was not found in '$componentCatalog'.") ;
    }

    /**
     * Serve the request from data access tier.
     */
    public static function dal($dalCatalog, $params = array ())
    {

        list($componentCatalog, $mapperMethod) = self::breakRequest($dalCatalog) ;
        if ( ! is_array($params) )
        {
            $request = $params ;
        }
        else
        {
            $request = new request ;
            $request->addAssocParam($params) ;
        }

        $mapperObject = componentFactory::get('dal', $componentCatalog, $request) ;

        if ( method_exists($mapperObject, $mapperMethod) )
        {
            return $mapperObject->$mapperMethod() ;
        }
        throw new publicException("Mapper method '$mapperMethod' was not found in '$componentCatalog'.") ;
    }

    /**
     * Explodes component Route and action/service/mapper's method name.
     * 
     * @param type $requestCatalog
     * @return array [componentRoute, action/service/mapper's method name]
     */
    private static function breakRequest($requestCatalog)
    {
        $requestCatalogParts = explode('.', $requestCatalog) ;
        $actionName          = end($requestCatalogParts) ;
        unset($requestCatalogParts[ count($requestCatalogParts) - 1 ]) ;

        if ( $requestCatalogParts[ 0 ] == 'ui' )
        {
            $componentType    = $requestCatalogParts[ 0 ] . '.' . $requestCatalogParts[ 1 ] ;
            unset($requestCatalogParts[ 0 ]) ;
            unset($requestCatalogParts[ 1 ]) ;
            $componentCatalog = implode('.', $requestCatalogParts) ;
            return array ( $componentType, $componentCatalog, $actionName ) ;
        }
        $componentCatalog = implode('.', $requestCatalogParts) ;
        return array ( $componentCatalog, $actionName ) ;
    }

    private static function isAssoc($arr)
    {
        return array_keys($arr) !== range(0, count($arr) - 1) ;
    }

}
