<?php

class ui
{

    private $methodBlackList ;
    private $actions ;
    private $UIList ;

    public function __construct()
    {
        $this->methodBlackList = array (
            '__construct',
            '__destruct',
            '__autoload'
                ) ;
    }

    public function getUIListTree()
    {
        $this->actions = \f\ttt::service('core.code.getAllActions') ;
        $this->UIList  = \f\ttt::service('core.code.getAllUIList') ;

        $uiDir = \f\ifm::app()->uiDir . \f\DS . 'backend' . \f\DS ;

        $uiDirStructure = $this->getDirStructureRecursive(new DirectoryIterator($uiDir)) ;
        $projectTree    = array () ;
        $this->extractProjectTree($uiDirStructure, $uiDir, $projectTree, '') ;
        return $projectTree ;
    }

    private function getDirStructureRecursive(DirectoryIterator $dir)
    {
        $data = array () ;
        foreach ( $dir as $node )
        {
            if ( $node->isDir() && ! $node->isDot() )
            {
                $data[ $node->getFilename() ] = $this->getDirStructureRecursive(new DirectoryIterator($node->getPathname())) ;
            }
            else if ( $node->isFile() )
            {
                $data[] = $node->getFilename() ;
            }
        }
        return $data ;
    }

    private function extractProjectTree($uiDirStructure, $currentRoute, &$projectTree, $currentPath)
    {

        foreach ( $uiDirStructure as $dirName => $structure )
        {

            $path = $currentPath . ( ! empty($currentPath) ? '.' : '') . $dirName ;

            $tempRoute = $currentRoute . $dirName . \f\DS ;

            if ( isset($structure[ '_component' ]) )
            {

                $component = $structure[ '_component' ] ;
                //&& $component[ 0 ] == "{$dirName}Controller.php"
                if ( count($component)  )
                {
                    $componentCatalog = $this->getComponentCatalog($tempRoute,
                                                                   "{$dirName}Controller",
                                                                   $path) ;
                    $info             = $this->getUIDocument($path) ;

                    if ( empty($info) )
                    {
                        $info[ 'name' ]  = $dirName ;
                        $info[ 'title' ] = $dirName ;
                    }
                    $componentCatalog[ 'info' ] = $info ;

                    $projectTree[ $dirName ][ 'catalog' ] = $componentCatalog ;
                }
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

        $actionsArray = array () ;
        $metaDatas    = array () ;
        if ( file_exists($pathToComponentFile) )
        {
            if ( ! class_exists($componentClassName, false) )
            {
                include $pathToComponentFile ;
            }
            if ( class_exists($componentClassName, false) )
            {
                $reflection   = new \ReflectionClass($componentClassName) ;
                $metaDatas    = $this->getComponentMetadata($reflection) ;
                $actionsArray = $this->getComponentActions($reflection, $path) ;
            }
        }
        $componentCatalog = array () ;


        if ( ! empty($metaDatas) )
        {
            $componentCatalog[ 'metadatas' ] = $metaDatas ;
        }

        if ( ! empty($actionsArray) )
        {
            $componentCatalog[ 'actions' ] = $actionsArray ;
        }

        return $componentCatalog ;
    }

    private function getActionDocument($path)
    {
        if ( ! empty($this->actions) )
        {
            foreach ( $this->actions as $action )
            {
                if ( $action[ 'path' ] === $path )
                {
                    return $action ;
                }
            }
        }
        return array () ;
    }

    private function getUIDocument($path)
    {
        if ( ! empty($this->v) )
        {
            foreach ( $this->UIList as $UI )
            {
                if ( $UI[ 'path' ] == $path )
                {
                    return $UI ;
                }
            }
        }
    }

    private function getComponentActions(\ReflectionClass $reflection, $path)
    {
        $actionsArray = array () ;
        foreach ( $reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $methodObj )
        {
            if ( $methodObj->class == $reflection->getName() and ! in_array($methodObj->name,
                                                                            $this->methodBlackList) )
            {
                $action           = array () ;
                $action[ 'name' ] = $methodObj->name ;
                $action[ 'info' ] = $this->getActionDocument($path . '.' . $methodObj->name) ;
                $actionsArray[]   = $action ;
            }
        }
        return $actionsArray ;
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

    public function getMainModulesList()
    {
        return \f\ttt::dal('core.code.getAppList') ;
    }

    private function getAllActions()
    {
# cache paths here 

        $actions = \f\ttt::dal('core.code.getBackendRoutes') ;
        $routes  = array () ;
        foreach ( $actions as $action )
        {
            $routes[ $action[ 'path' ] ] = true ;
        }
        return $routes ;
    }

    public function translateBackendRequest($routeParts)
    {
		
        $backendRoutes = $this->getAllActions() ;
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
            if ( isset($backendRoutes[ $candidateRoute ]) )
            {
                $route = $backendRoutes[ $candidateRoute ] ? $candidateRoute : false ;
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
            'requestType'    => 'ui.backend',
            'requestCatalog' => $route,
            'requestParams'  => explode('.', $params),
            'access'         => true,
                ) ;
    }

    private function extractFrontendControllersTree()
    {
        $uiDir = \f\ifm::app()->uiDir . \f\DS . 'frontend' . \f\DS ;
        
        //echo $uiDir;

        $uiDirStructure = $this->getDirStructureRecursive(new DirectoryIterator($uiDir)) ;
        
        
        $projectTree    = array () ;
        $this->extractProjectTree($uiDirStructure, $uiDir, $projectTree, '') ;
        return $projectTree ;
    }

    public function translateFrontendRequest($routeParts)
    {
        
        $websiteInfo = \f\ttt::service('core.website.run.getDomainInfo',
                                       array (
                    'domainName' => \f\ifm::app()->domain
                )) ;

        if ($websiteInfo === 'Domain Was Not Found'){
            return false;
        }
        
        $frontendPaths = \f\ttt::dal('core.code.ui.getCachedFrontendPaths') ;
        
        //\f\pr($frontendPaths);

        if ( empty($frontendPaths) )
        {
            $projectTree = $this->extractFrontendControllersTree() ;
            //\f\pr($projectTree);
            $currentPath = '' ;
            $this->flattenFrontEndProjectTree($frontendPaths, $projectTree,
                                              $currentPath) ;

            \f\ttt::dal('core.code.ui.cacheFrontendPaths',
                        array (
                'paths' => $frontendPaths
            )) ;
        }
        //\f\pr($frontendPaths);
        # check url in aliases (only first part of url can be alias)

        $maybeAlias = $routeParts[ 0 ] ;
        //\f\pr($routeParts);
        $wasAlias   = false ;
        foreach ( $websiteInfo[ 'urlAliases' ] as $aliasKey => $aliasDetails )
        {
            if ( $maybeAlias === $aliasKey )
            {
                //\f\pr('yes');
                $realPath   = $aliasDetails[ 'target' ] ;
                $customPage = isset($aliasDetails[ 'page' ]) ? $aliasDetails[ 'page' ] : NULL ;
                $wasAlias   = true ;
                break ;
            }
        }

        if ( $wasAlias )
        {
            array_shift($routeParts) ;
            $routeParts = array_merge(explode('/', $realPath), $routeParts) ;
        }

        $tempRouteParts = $routeParts ;
        $params         = array () ;
        //\f\pr($frontendPaths);
        for ( $i = count($routeParts) ; $i > 1 ; $i -- )
        {
            $candidatePath = implode('.', $tempRouteParts) ;
            if ( ! isset($frontendPaths[ $candidatePath ]) )
            {
                array_unshift($params, end($tempRouteParts)) ;
                array_pop($tempRouteParts) ;
                $candidatePath = '' ;
                continue ;
            }
            else
            {
                break ;
            }
        }
        //\f\pr($candidatePath);


        if ( empty($candidatePath) )
        {
            //\f\pr('okkk');
            $requestCatalog = $routeParts[ 0 ] ;

            array_shift($routeParts) ;
            $translateResult = array (
                'requestType'    => 'page',
                'requestCatalog' => $requestCatalog,
                'requestParams'  => $routeParts,
                'templateName'   => $websiteInfo[ 'templateName' ],
                'domainStatus'   => $websiteInfo[ 'domainStatus' ],
                'access'         => true,
                    ) ;
        }
        else
        {
            $translateResult           = array (
                'requestType'    => 'ui.frontend',
                'requestCatalog' => $candidatePath,
                'requestParams'  => $params,
                'templateName'   => $websiteInfo[ 'templateName' ],
                'domainStatus'   => $websiteInfo[ 'domainStatus' ],
                'access'         => true,
                    ) ;
            $translateResult[ 'page' ] = ! empty($customPage) ? $customPage : 'page' ;
        }
        //\f\pr($translateResult);

        return $translateResult ;
    }

    public function flattenFrontEndProjectTree(&$flattenProjectTree, $projectTree, &$currentPath)
    {
        foreach ( $projectTree as $componentName => $componentTree )
        {
            $currentPathTemp = $currentPath ;
            if ( $componentName !== 'catalog' )
            {
                $currentPathTemp .= $componentName . '.' ;
                $this->flattenFrontEndProjectTree($flattenProjectTree,
                                                  $componentTree,
                                                  $currentPathTemp) ;
            }
            else
            {
                $actions = $componentTree[ 'actions' ] ;
                foreach ( $actions as $action )
                {
                    $flattenProjectTree[ $currentPath . $action[ 'name' ] ] = 1 ;
                }
            }
        }
    }

}
