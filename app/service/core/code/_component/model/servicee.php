<?php

class servicee
{

    /**
     * The methods in the black list does not controll by core.code component.
     * 
     * @var array 
     */
    private $methodBlackList ;

    /**
     * Contains documented services in the database
     * 
     * @var array documented services 
     */
    private $services ;

    /**
     * Contains documented apps in the database
     * 
     * @var array 
     */
    private $appList ;

    /**
     * Scans component and returns its methods and docblock information.
     * 
     * @var componentScanner
     */
    private $componentScanner ;

    /**
     *
     * @var directoryScanner
     */
    private $dirScanner ;

    public function __construct()
    {

        $this->methodBlackList = array (
            '__construct',
            '__destruct',
            '__autoload'
                ) ;
    }

    public function getServiceListTree($appList, $services)
    {
        $this->services         = $services ;
        $this->appList          = $appList ;
        $this->dirScanner       = new directoryScanner ;
        $this->componentScanner = new componentScanner('document') ;
        $serviceDir             = \f\ifm::app()->serviceDir . \f\DS ;

        /* @var $directoryScanner directoryScanner */
        $serviceDirStructure = $this->dirScanner->scanRecursive($serviceDir) ;

        $projectTree = array () ;
        $this->extractProjectTree($serviceDirStructure, $serviceDir,
                                  $projectTree, '') ;
        return $projectTree ;
    }

    private function getAppDocument($path)
    {
        foreach ( $this->appList as $app )
        {
            if ( $app[ 'path' ] == $path )
            {
                return $app ;
            }
        }
    }

    private function extractProjectTree($serviceDirStructure, $currentRoute, &$projectTree, $currentPath)
    {
        foreach ( $serviceDirStructure as $dirName => $structure )
        {
            $path = $currentPath . ( ! empty($currentPath) ? '.' : '') . $dirName ;

            $tempRoute = $currentRoute . $dirName . \f\DS ;

            if ( isset($structure[ '_component' ]) )
            {
                /** extract metadata, documentation, services of the component * */
                $componentDirStructure   = $structure[ '_component' ] ;
                $projectTree[ $dirName ] = $this->extractAppComponent($componentDirStructure) ;
            }

            if ( $dirName != '_component' )
            {
                $this->extractProjectTree($structure, $tempRoute,
                                          $projectTree[ $dirName ], $path) ;
            }
        }
    }

    private function getComponentCatalog($componentRoute, $componentClassName, $path)
    {
        $pathToComponentFile = $componentRoute . '_component' . \f\DS . $componentClassName . '.php' ;

        $servicesArray = array () ;
        $metaDatas     = array () ;
        if ( file_exists($pathToComponentFile) )
        {
            if ( ! class_exists($componentClassName, false) )
            {
                include $pathToComponentFile ;
            }
            if ( class_exists($componentClassName, false) )
            {
                $reflection    = new \ReflectionClass($componentClassName) ;
                $metaDatas     = $this->getComponentMetadata($reflection) ;
                $servicesArray = $this->getComponentServices($reflection, $path) ;
            }
        }
        $componentCatalog = array () ;
        if ( ! empty($metaDatas) )
        {
            $componentCatalog[ 'metadatas' ] = $metaDatas ;
        }

        if ( ! empty($servicesArray) )
        {
            $componentCatalog[ 'services' ] = $servicesArray ;
        }

        return $componentCatalog ;
    }

    private function getServiceDocument($path)
    {
        foreach ( $this->services as $service )
        {
            if ( $service[ 'path' ] == $path )
            {
                return $service ;
            }
        }
    }

    private function getComponentServices(\ReflectionClass $reflection, $path)
    {
        $servicesArray = array () ;
        foreach ( $reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $methodObj )
        {
            if ( $methodObj->class == $reflection->getName() and ! in_array($methodObj->name,
                                                                            $this->methodBlackList) )
            {
                $service           = array () ;
                $service[ 'name' ] = $methodObj->name ;
                $service[ 'info' ] = $this->getServiceDocument($path . '.' . $methodObj->name) ;
                $servicesArray[]   = $service ;
            }
        }
        return $servicesArray ;
    }

    private function getComponentMetadata(\ReflectionClass $reflection)
    {

        if ( ! class_exists('\phpDocumentor\Reflection\DocBlock', false) )
        {
            include 'phpDocumentor' . \f\DS . 'DocBlock.php' ;
        }

        $phpdoc = new \phpDocumentor\Reflection\DocBlock($reflection) ;

        $tags      = $phpdoc->getTags() ;
        $tagsArray = array () ;
        foreach ( $tags as $tag )
        {
            $tagsArray[ $tag->getName() ] = $tag->getDescription() ;
        }
        return $tagsArray ;
    }

    private function getAllServices()
    {
        # cache paths here 

        $services = \f\ttt::dal('core.code.getServiceRoutes') ;
        $routes   = array () ;
        foreach ( $services as $service )
        {
            $routes[ $service[ 'path' ] ] = true ;
        }
        return $routes ;
    }

    public function translateServiceRequest($routeParts)
    {

        $serviceRoutes = $this->getAllServices() ;

        $notTranslatedRouteParts = $routeParts ;

        /** create probable routes * */
        $candidateRoutes = array () ;
        $routePartsCount = count($routeParts) ;
        for ( $i = 0 ; $i <= $routePartsCount - 1 ; $i ++ )
        {
            $candidateRoutes[] = implode('.', $routeParts) ;
            $routeParts        = array_splice($routeParts, 0,
                                              count($routeParts) - 1) ;
        }

        $route = '' ;
        foreach ( $candidateRoutes as $candidateRoute )
        {
            if ( isset($serviceRoutes[ $candidateRoute ]) )
            {
                $route = $serviceRoutes[ $candidateRoute ] ? $candidateRoute : false ;
                break ;
            }
        }

        if ( $route === false )
        {
            return array (
                'access' => 'false'
                    ) ;
        }
        if ( empty($route) )
        {
            return false ;
        }
        $notTranslatedRoute = implode('.', $notTranslatedRouteParts) ;
        $params             = '' ;
        if ( strlen($route) < strlen($notTranslatedRoute) )
        {
            $params = str_replace($route . '.', '', $notTranslatedRoute) ;
        }

        return array (
            'requestType'    => 'service',
            'requestCatalog' => $route,
            'requestParams'  => explode('.', $params),
            'access'         => true,
                ) ;
    }

}
