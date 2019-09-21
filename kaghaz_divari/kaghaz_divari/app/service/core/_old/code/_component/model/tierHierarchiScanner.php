<?php

/**
 * Scans directory structure for components.
 * For every component lists its actions and documentation if exists.
 * 
 */
class tierHierarchiScanner extends \f\component
{

    /**
     * Contains information about tiers directory
     * 
     * @var array 
     */
    private $tiersInfo ;

    /**
     * The methods in the black list does not controll by core.code component.
     * 
     * @var array 
     */
    private $methodBlackList ;

    /**
     *
     * Contains documentation of the component found in the database.
     * 
     * @var array
     */
    private $componentsDoc ;

    /**
     *
     * Contains documentation of the methods found in the database.
     * 
     * @var array
     */
    private $methodsDoc ;

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

    /**
     * 
     * service or ui
     * 
     * @var string
     */
    private $tierName ;

    public function __construct ()
    {
        require __DIR__ . \f\DS . 'config.php' ;

        $this->methodBlackList = $methodsBlackList ;
        $this->tiersInfo       = $tiersInfo ;

        $this->dirScanner       = new directoryScanner ;
        $this->componentScanner = new componentScanner ;
    }

    public function scanTierRecursive ( $tierName, $documentation )
    {
        $pathToTierRoot      = $this->tiersInfo[ $tierName ][ 'root' ] ;
        $this->componentsDoc = $documentation[ 'componentsDoc' ] ;
        $this->methodsDoc    = $documentation[ 'methodsDoc' ] ;

        $this->tierName = $tierName ;

        //\f\pr($this->tiersInfo);
        $tierDirectoryStructure = $this->dirScanner->scanDirRecursive ( $pathToTierRoot ) ;
        
        $projectStatus = array () ;
        $this->combine ( $tierDirectoryStructure, $pathToTierRoot,
                         $projectStatus, '' ) ;

        if($tierName=='ui')
        {
            //\f\pr ($tierDirectoryStructure);
        }                 
        return $projectStatus ;
    }

    private function combine ( $tierDirectoryStructure, $currentRoute,
                               &$projectStatus, $currentPath )
    {
        if ( is_array ( $tierDirectoryStructure ) )
        {
            foreach ( $tierDirectoryStructure as $dirName => $structure )
            {
                $path = $currentPath . ( ! empty ( $currentPath ) ? '.' : '') . $dirName ;

                $tempRoute = $currentRoute . $dirName . \f\DS ;

                if ( isset ( $structure[ '_component' ] ) )
                {
                    //\f\pr($structure['_component']) ;
                    /** extract metadata, documentation, methods of the component * */
                    $componentDirStructure                     = $structure[ '_component' ] ;
                    $scanParams                                = array (
                        'tierName'              => $this->tierName,
                        'componentName'         => $dirName,
                        'componentDirStructure' => $componentDirStructure,
                        'componentsDoc'         => $this->componentsDoc,
                        'methodsDoc'            => $this->methodsDoc,
                        'methodBlackList'       => $this->methodBlackList,
                        'path'                  => $path,
                        'tempRoute'             => $tempRoute
                            ) ;
                    //\f\pr($scanParams);
                    $projectStatus[ $dirName ][ '_component' ] = $this->componentScanner->scanComponent ( $scanParams ) ;
                }

                if ( $dirName != '_component' )
                {
                    $this->combine ( $structure, $tempRoute,
                                     $projectStatus[ $dirName ], $path ) ;
                }
            }
        }
    }

}
