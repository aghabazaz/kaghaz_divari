<?php

class legacy
{

    public function getLegacyList()
    {
        $legacyRoot         = substr(\f\ROOT, 0, strrpos(\f\ROOT, \f\DS)) ;
        $legacyDir          = $legacyRoot . \f\DS . 'app' . \f\DS . 'plugins' . \f\DS . 'controller' . \f\DS ;
        $legacyDirStructure = $this->getDirStructureRecursive(new DirectoryIterator($legacyDir)) ;
        $projectTree        = array () ;
        $this->extractProjectTree($legacyDirStructure, $legacyDir, $projectTree) ;
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

    private function extractProjectTree($legacyDirStructure, $legacyDir, &$projectTree)
    {
        foreach ( $legacyDirStructure as $fileName )
        {
            if ( strstr($fileName, '.php') )
            {
                $componentClassName                 = substr($fileName, 0,
                                                             strpos($fileName,
                                                                    ".php")) ;
                $projectTree[ $componentClassName ] = array () ;
            }
        }
    }

    public function getModulesList()
    {
        return $this->makeClickableItems(\f\ttt::dal('core.code.getLegacyModulesList')) ;
    }

    private function makeClickableItems($modulesList)
    {
        $clickableItems = array () ;
        foreach ( $modulesList as $module )
        {
            $clickableItem             = array () ;
            $clickableItem[ 'title' ]  = $module[ 'title_fa' ] ;
            $clickableItem[ 'target' ] = '_parent' ;
            switch ( $module[ 'type' ] )
            {
                case '1':
                    $clickableItem[ 'url' ]  = \f\ifm::app()->legacyBaseUrl . "cms/content/plugin/" . $module[ 'url' ] ;
                    $clickableItem[ 'icon' ] = \f\ifm::app()->legacyBaseUrl . "uploads/plugins/" . $module[ 'icon' ] ;
                    break ;
                case '2':
                    $clickableItem[ 'url' ]  = \f\ifm::app()->legacyBaseUrl . "cms/content/content/" . $module[ 'url' ] ;
                    $clickableItem[ 'icon' ] = \f\ifm::app()->legacyBaseUrl . "uploads/content/icon/" . $module[ 'icon' ] ;
                    break ;
            }
            $clickableItems[] = $clickableItem ;
        }
        return $clickableItems ;
    }

}
