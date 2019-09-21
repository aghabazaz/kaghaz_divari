<?php

class componentScanner extends \f\component
{

    private function extractParams($scanParams)
    {
        foreach ( $scanParams as $key => $scanParam )
        {
            $this->$key = $scanParam ;
        }
    }

    public function scanComponent($scanParams)
    {

        $this->extractParams($scanParams) ;
        unset($scanParams) ;

        $componentClassName = "{$this->componentName}" . ucfirst($this->tierName == 'ui' ? 'Controller' : 'Service') ;
        //echo $componentClassName;
        
        $componentStatus    = array () ;
        if ( count($this->componentDirStructure) && is_array($this->componentDirStructure) && in_array("{$componentClassName}.php",$this->componentDirStructure) )
        {

            $componentStatus[ 'doc' ][ 'database' ] = $this->getDoc($this->componentsDoc,
                                                                    $this->path,
                                                                    $this->componentName) ;
            $dockBlockAndMethods                    = $this->getDockBlockAndMethods($componentClassName) ;

            if ( isset($dockBlockAndMethods[ 'docBlock' ]) )
            {
                $componentStatus[ 'doc' ][ 'docBlock' ] = $dockBlockAndMethods[ 'docBlock' ] ;
            }
            if ( isset($dockBlockAndMethods[ 'methods' ]) )
            {
                $componentStatus[ 'methods' ] = $dockBlockAndMethods[ 'methods' ] ;
            }
        }
        else
        {
            $componentStatus[ 'doc' ][ 'docBlock' ] = array (
                'name'  => $this->componentName,
                'title' => $this->componentName,
                'path'  => $this->path
                    ) ;
        }
        
        
        return $componentStatus ;
    }

    private function getDoc($docList, $path, $name = '')
    {
        foreach ( $docList as $doc )
        {
            if ( $doc[ 'path' ] == $path )
            {
                return $doc ;
            }
        }
        return array (
            'name'  => $name,
            'title' => $name,
            'path'  => $path
                ) ;
    }

    private function getDockBlockAndMethods($componentClassName)
    {
        $pathToComponentFile = $this->tempRoute . '_component' . \f\DS . $componentClassName . '.php' ;

        $methodsArray = array () ;
        $dockBlocks   = array () ;
        if ( file_exists($pathToComponentFile) )
        {
            if ( ! class_exists($componentClassName, false) )
            {
                include $pathToComponentFile ;
            }
            if ( class_exists($componentClassName, false) )
            {
                $reflection   = new \ReflectionClass($componentClassName) ;
                $dockBlocks   = $this->getComponentDockBlock($reflection) ;
                $methodsArray = $this->getComponentMethods($reflection) ;
            }
        }

        $dockBlockAndMethods = array () ;
        if ( ! empty($dockBlocks) )
        {
            $dockBlockAndMethods[ 'docBlock' ] = $dockBlocks ;
        }
        if ( ! empty($methodsArray) )
        {
            $dockBlockAndMethods[ 'methods' ] = $methodsArray ;
        }

        return $dockBlockAndMethods ;
    }

    private function getComponentMethods(\ReflectionClass $reflection)
    {
        $methodsArray = array () ;
        foreach ( $reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $methodObj )
        {
            if ( $methodObj->class == $reflection->getName() && ! in_array($methodObj->name,
                                                                           $this->methodBlackList) )
            {
                $methodsArray[] = $this->getDoc($this->methodsDoc,
                                                $this->path . '.' . $methodObj->name,
                                                $methodObj->name) ;
            }
        }
        return $methodsArray ;
    }

    private function getComponentDockBlock(\ReflectionClass $reflection)
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

}
