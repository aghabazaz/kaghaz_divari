<?php

class treeView extends \f\component
{

    private $treeType ;

    public function __construct()
    {
        require __DIR__ . \f\DS . 'config.php' ;
        $this->extractVars($iconsUrl) ;
    }

    private function extractVars($vars)
    {

        foreach ( $vars as $key => $value )
        {
            $this->$key = $value ;
        }
    }

    public function iconicLiOpen($urlToIcon, $title, $data = array ())
    {

        $data[ 'data-jstree' ]   = '{"icon" : "' . $urlToIcon . '"}' ;
        $params[ 'htmlOptions' ] = $data ;
        $params[ 'style' ]       = array ( 'float' => 'right' ) ;


        return \f\html::markupBegin('li', $params) . $title ;
    }

    public function getTreeRecursive($componentsArray, $tiers, $mode = 'select', $treeID = false, $noId = false)
    {

        $trid = ($treeID) ? $treeID : 'jstree' ;
        if ( $noId )
        {
            $trid = '' ;
        }
        $treeMarkup = "<div class='jstree' id='" . $trid . "'><ul>" ;

        /* generate Sevices Tree Markup */
        if ( isset($tiers[ 'service' ]) )
        {
            $this->treeType = 'service' ;

            $treeMarkup .= $this->iconicLiOpen($this->urlToDesignIcon,
                                               'رابط برنامه نویسی') ;

            $treeMarkup .= "<ul>" ;
            $this->generateTreeMarkup($componentsArray[ 'service' ], $treeMarkup) ;
            $treeMarkup .= "</ul></li>" ;
        }

        /* generate UI Tree Markup */
        if ( isset($tiers[ 'ui' ]) )
        {
            $this->treeType = 'ui' ;
            $treeMarkup .= $this->iconicLiOpen($this->urlToDesignIcon,
                                               'رابط کاربری') ;

            $treeMarkup .= "<ul>" ;
            $this->generateTreeMarkup($componentsArray[ 'ui' ], $treeMarkup) ;
            $treeMarkup .= "</ul></li>" ;
        }

        $treeMarkup .= "</ul></div>" ;

        return $treeMarkup ;
    }

    private function openComponentLi($componentName, $hierarchi)
    {

        $liTitle = $componentName ;
        $data    = array () ;
        if ( isset($hierarchi[ '_component' ]) )
        {
            if ( isset($hierarchi[ '_component' ][ 'doc' ][ 'database' ]) )
            {
                $databaseDoc = $hierarchi[ '_component' ][ 'doc' ][ 'database' ] ;
            }
            else
            {
                $databaseDoc = $hierarchi[ '_component' ][ 'doc' ][ 'docBlock' ] ;
            }
            $liTitle = $databaseDoc[ 'title' ] ;
            $data    = array (
                'data-path' => $databaseDoc[ 'path' ],
                'data-type' => "component." . $this->treeType
                    ) ;
            if ( isset($databaseDoc[ 'id' ]) )
            {
                $data[ 'data-id' ] = $databaseDoc[ 'id' ] ;
            }
        }
        $componentType = '' ;
        if ( isset($hierarchi[ '_component' ][ 'doc' ][ 'docBlock' ][ 'category' ]) )
        {
            $componentType = $hierarchi[ '_component' ][ 'doc' ][ 'docBlock' ][ 'category' ] ;
        }


        switch ( $this->treeType )
        {
            case 'service':
                switch ( $componentType )
                {
                    case 'module' :
                        $urlToIcon = $this->urlToModuleIcon ;
                        break ;
                    case 'plugin' :
                        $urlToIcon = $this->urlToPluginIcon ;
                        break ;
                    case 'component':
                        $urlToIcon = $this->urlToComponentIcon ;
                        break ;
                    default :
                        $urlToIcon = $this->urlToComponentIcon ;
                }
                break ;
            case 'ui':
                $urlToIcon = $this->urlToUiIcon ;
                break ;
        }


        return $this->iconicLiOpen($urlToIcon, $liTitle, $data) ;
    }

    private function generateDocBlockMarkup($doc)
    {
        if ( ! isset($doc[ 'docBlock' ]) )
        {
            return '' ;
        }
        $docBlock = $doc[ 'docBlock' ] ;
        if ( empty($docBlock) )
        {
            return '' ;
        }
        $docBlockMarkup = '' ;

        ########################### docBlock LI ##############################
        $docBlockMarkup .= $this->iconicLiOpen($this->urlToInformationIcon,
                                               \f\ifm::t('Info')) ;
        $docBlockMarkup .= '</ul>' ;

        ########################### docBlock items ###########################

        if ( isset($docBlock[ 'author' ]) )
        {
            $author = \f\ifm::t('Author') . ' : ' ;
            $author .= "<b>" . $docBlock[ 'author' ] . "</b>" ;
            $docBlockMarkup .= $this->iconicLiOpen($this->urlToTriangleIcon,
                                                   $author) ;
        }

        if ( isset($docBlock[ 'package' ]) )
        {
            $package = \f\ifm::t('Package') . ' : ' ;
            $package = \f\ifm::t('Package') . ' : <b>' . $docBlock[ 'package' ] . '</b>' ;
            $docBlockMarkup .= $this->iconicLiOpen($this->urlToTriangleIcon,
                                                   $package) ;
        }

        if ( isset($docBlock[ 'category' ]) )
        {
            $category = \f\ifm::t('Category') . ' : ' ;
            $category = \f\ifm::t('Category') . ' : <b>' . $docBlock[ 'category' ] . '</b>' ;
            $docBlockMarkup .= $this->iconicLiOpen($this->urlToTriangleIcon,
                                                   $category) ;
        }
        ########################### / docBlock LI ############################
        $docBlockMarkup .= \f\html::markupEndGroup(array ( 'ul', 'li' )) ;
    }

    private function generateMethodsMarkup($_component)
    {

        if ( ! isset($_component[ 'methods' ]) )
        {
            return '' ;
        }

        $methods = $_component[ 'methods' ] ;
        if ( empty($methods) )
        {
            return '' ;
        }

        $methodsMarkup = '' ;
        switch ( $this->treeType )
        {
            case 'service':
                $urlToMethodsIcon = $this->urlToServiceIcon ;
                $urlToMethodIcon  = $this->urlToRectangleIcon ;
                $methodsTitle     = 'سرویس ها' ;
                break ;

            case 'ui':
                $urlToMethodsIcon = $this->urlToActionIcon ;
                $urlToMethodIcon  = $this->urlToTriangleIcon ;
                $methodsTitle     = 'عملیات' ;
                break ;
        }

        $methodsMarkup .= $this->iconicLiOpen($urlToMethodsIcon, $methodsTitle) ;
        $methodsMarkup .= '<ul>' ;

        foreach ( $methods as $method )
        {
            $methodTitle = $method[ 'title' ] ;
            $data        = array (
                'data-path' => $method[ 'path' ],
                'data-type' => "method." . $this->treeType
                    ) ;
            if ( isset($method[ 'id' ]) )
            {
                $data[ 'data-id' ] = $method[ 'id' ] ;
            }
            $methodsMarkup .= $this->iconicLiOpen($urlToMethodIcon,
                                                  $methodTitle, $data) ;
            $methodsMarkup .= '</li>' ;
        }
        $methodsMarkup .= "</ul></li>" ;

        return $methodsMarkup ;
    }

    private function generateTreeMarkup($componentsArray, &$treeMarkup)
    {

        foreach ( $componentsArray as $componentName => $hierarchi )
        {
            $treeMarkup .= $this->openComponentLi($componentName, $hierarchi) ;

            $treeMarkup .= '<ul>' ;

            if ( isset($hierarchi[ '_component' ]) )
            {
                $treeMarkup .= $this->generateDocBlockMarkup($hierarchi[ '_component' ][ 'doc' ]) ;
                $treeMarkup .= $this->generateMethodsMarkup($hierarchi[ '_component' ]) ;

                unset($hierarchi[ '_component' ]) ;
            }
            if ( count($hierarchi) )
            {

                $this->generateTreeMarkup($hierarchi, $treeMarkup) ;
            }
            $treeMarkup .= '</ul>' ;

            $treeMarkup .= '</li>' ;
        }
    }

}
