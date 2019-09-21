<?php

namespace f ;

class componentFactory
{

    public static function get($type, $componentCatalog, $request, $constructorParams = NULL)
    {

        /** Gathering path to component parts to gether :) */
        $a = ifm::app()->repoDir ;
        $b = DS . str_replace('.', DS, $type) ;
        $c = DS . str_replace('.', DS, $componentCatalog) ;

        $componentNameParts = explode('.', $componentCatalog) ;

        $componentName = end($componentNameParts) ;

        switch ( $type )
        {
            case 'dal':
                $componentClassName = "{$componentName}Mapper" ;
                break ;
            case 'service':
                $componentClassName = "{$componentName}Service" ;
                break ;
            case 'ui.backend':
            case 'ui.frontend':
                $componentClassName = "{$componentName}Controller" ;
                break ;
        }

        $pathToComponent = $a . $b . $c . DS . '_component' . DS . "$componentClassName.php" ;
        
        //\f\pr($pathToComponent);

        $component = false ;
        if ( file_exists($pathToComponent) )
        {
            if ( ! class_exists($componentClassName) )
            {
                include $pathToComponent ;
            }

            if ( empty($constructorParams) )
            {
                /* @var \f\controller $component  */
                $component = new $componentClassName(array (
                    'componentType' => $type,
                        )) ;
            }
            else
            {
                $constructorParams[ 'componentType' ] = $type ;

                /* @var \f\controller $component  */
                $component = new $componentClassName($constructorParams) ;
            }

            $component->setRequest($request) ;
        }
        else
        {
            throw new publicException("Component was not found in ($pathToComponent) !") ;
        }
        return $component ;
    }

}
