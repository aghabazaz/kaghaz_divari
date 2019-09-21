<?php

namespace f ;

class html extends \f\component
{

    private static $clientActionObj = NULL ;

    private static function registerClientAction ()
    {
        if ( empty ( self::$clientActionObj ) )
        {
            require_once __DIR__ . \f\DS . 'widgets' . \f\DS . 'base' . \f\DS . 'clientAction.php' ;
            self::$clientActionObj = new \f\w\clientAction ;
        }
    }

    public static function markupBegin ( $tagName, $params = array () )
    {
        $attrMarkup = self::attr ( $params ) ;
        return "<$tagName $attrMarkup>" ;
    }

    public static function markupEnd ( $tagName )
    {
        return "</$tagName>" ;
    }

    public static function markupEndGroup ( $tagNames )
    {
        $markup = '' ;
        foreach ( $tagNames as $tagName )
        {
            $markup .= self::markupEnd ( $tagName ) ;
        }
        return $markup ;
    }

    public static function readyMarkup ( $tagName, $content = '',
                                         $params = array (), $hasClose = false )
    {
        $attrMarkup = self::attr ( $params ) ;

        $tagMarkup = "<$tagName $attrMarkup>" . ($hasClose ? "$content</$tagName>" : '') ;

        require_once __DIR__ . \f\DS . 'widgets' . \f\DS . 'base' . \f\DS . 'clientAction.php' ;

        $clientActionObj = new w\clientAction ;

        $tagMarkup .= $clientActionObj->addClientAction ( $params ) ;

        return $tagMarkup ;
    }

    private static function arrayToAttr ( $attrArray )
    {
        $attrMarkup = '' ;
        foreach ( $attrArray as $key => $value )
        {
            $attrMarkup .= " $key='$value' " ;
        }
        return $attrMarkup ;
    }

    private static function arrayToStyle ( $styleArray )
    {
        $styleMarkup = "style = '" ;
        foreach ( $styleArray as $key => $value )
        {
            $styleMarkup .= " $key : $value;" ;
        }
        return $styleMarkup . "'" ;
    }

    private static function attr ( $params )
    {
        $attrMarkup = '' ;
        if ( isset ( $params[ 'htmlOptions' ] ) )
        {
            $attrMarkup .= self::arrayToAttr ( $params[ 'htmlOptions' ] ) ;
        }
        if ( isset ( $params[ 'style' ] ) )
        {
            $attrMarkup .= ' ' . self::arrayToStyle ( $params[ 'style' ] ) ;
        }
        return $attrMarkup ;
    }

    public static function gridButton ( $params )
    {
        $markup = '' ;
        foreach ( $params as $param )
        {
            /* get params */
            $buttonParams = self::getButtonParams ( $param ) ;

            /* generate button */
            $markup .= self::generateGridButtonMarkup ( $param[ 'type' ],
                                                        $buttonParams ) ;
        }

        return $markup ;
    }

    private function getButtonParams ( $param )
    {
        $title          = isset ( $param[ 'title' ] ) ? $param[ 'title' ] : '' ;
        $target         = isset ( $param[ 'target' ] ) ? $param[ 'target' ] : '' ;
        $confirm        = isset ( $param[ 'confirm' ] ) && $param[ 'confirm' ] ? true : false ;
        $action         = $param[ 'action' ] ;
        $clientCallback = isset ( $param[ 'clientCallBack' ] ) ? $param[ 'clientCallBack' ] : 'null' ;
        $href           = isset ( $param[ 'href' ] ) ? $param[ 'href' ] : '' ;
        $paramsJsObj    = '' ;
        $id             = isset ( $param[ 'id' ] ) ? "id=\"{$param[ 'id' ]}\"" : '' ;
        $clientAction   = isset ( $param[ 'clientAction' ] ) ? $param[ 'clientAction' ] : '' ;
        $dataToggle     = isset ( $param[ 'data-toggle' ] ) ? $param[ 'data-toggle' ] : '' ;

        if ( isset ( $param[ 'params' ] ) )
        {
            $paramsJsObj = "{" ;
            $i           = 1 ;
            foreach ( $param[ 'params' ] as $k => $v )
            {
                $paramsJsObj .= "$k: $v" . ($i ++ < count ( $param[ 'params' ] ) ? ',' : '') ;
            }
            $paramsJsObj .= "}" ;
        }
        $status = isset ( $param[ 'status' ] ) ? $param[ 'status' ] : '' ;

        $param[ 'title' ]          = $title ;
        $param[ 'target' ]         = $target ;
        $param[ 'confirm' ]        = $confirm ;
        $param[ 'action' ]         = $action ;
        $param[ 'clientCallback' ] = $clientCallback ;
        $param[ 'href' ]           = $href ;
        $param[ 'paramsJsObj' ]    = $paramsJsObj ;
        $param[ 'id' ]             = $id ;
        $param[ 'clientAction' ]   = $clientAction ;
        $param[ 'status' ]         = $status ;
        $param[ 'dataToggle' ]     = $dataToggle ;
        return $param ;
    }

    private function generateGridButtonMarkup ( $type, $param )
    {
        extract ( $param ) ;
        switch ( $type )
        {
            case 'details':
                if ( empty ( $title ) )
                {
                    $title = \f\ifm::t ( 'details' ) ;
                }
                $iconClass = 'fa fa-file-text-o fa-lg' ;
                break ;
            case 'list':
                if ( empty ( $title ) )
                {
                    $title = \f\ifm::t ( 'list' ) ;
                }
                $iconClass = 'fa fa-list-ul fa-lg' ;
                break ;

            case 'delete':
                if ( empty ( $title ) )
                {
                    //$title     = \f\ifm::t ( 'delete' ) ;
                }
                $iconClass = 'fa fa-trash-o fa-lg red' ;
                break ;

            case 'edit':
                if ( empty ( $title ) )
                {
                    $title = \f\ifm::t ( 'edit' ) ;
                }
                $iconClass = 'fa fa-edit fa-lg green' ;

                break ;
            case 'image':
                if ( empty ( $title ) )
                {
                    $title = \f\ifm::t ( 'image' ) ;
                }
                $iconClass = 'fa fa-picture-o fa-lg' ;

                break ;
            case 'info':
                if ( empty ( $title ) )
                {
                    $title = \f\ifm::t ( 'image' ) ;
                }
                $iconClass = 'fa fa-info-circle fa-lg' ;

                break ;
            case 'copy':
                
                $iconClass = 'fa fa-copy fa-lg' ;

                break ;
            case 'status':

                if ( empty ( $title ) )
                {
                    //$title = $param[ 'status' ] !== 'enabled' ? \f\ifm::t ( 'enabled' ) : \f\ifm::t ( 'disabled' ) ;
                }

                if ( $param[ 'status' ] === 'enabled' )
                {
                    $iconClass = 'fa fa-check-circle fa-lg' ;
                }
                else
                {
                    $iconClass = 'fa fa-minus-circle fa-lg' ;
                }
                break ;
            case 'special':

//                if ( empty ( $title ) )
//                {
//                    $title = $param[ 'status' ] !== 'enabled' ? \f\ifm::t ( 'enabled' ) : \f\ifm::t ( 'disabled' ) ;
//                }
                if ( $param[ 'status' ] === 'enabled' )
                {
                    $iconClass = 'fa fa-star fa-lg' ;
                }
                else
                {
                    $iconClass = 'fa fa-star-o fa-lg' ;
                }
                break ;
            case 'custom':
                $title     = $param[ 'title' ] ;
                $iconClass = $param[ 'icon' ] ;
        }
        $dataToggle            = $param[ 'dataToggle' ] ;
        $onConfirmActionMarkup = '' ;
        $confirmMarkup         = '' ;
        if ( $confirm )
        {
            $confirmMarkup         = "data-toggle='confirmation'" ;
            $onConfirmActionMarkup = "data-on-confirm='widgetHelper.tt(\"ui\", \"$action\", $paramsJsObj, \"$clientCallback\" );'" ;
        }

        if ( ! ($href) )
        {
            $href = "javascript:void(0)" ;
        }

        if ( ! isset ( $target ) )
        {
            $target = '__self' ;
        }
        $buttonMarkup = "<a target='$target' $id class='actionButton' data-placement='top'  $confirmMarkup $onConfirmActionMarkup title='$title' href='$href'>"
                . "<i style='font-size: 18px; 'class = '$iconClass' >&nbsp</i></a>&nbsp;" ;

        if ( ! empty ( $clientAction ) )
        {
            self::registerClientAction () ;
            $buttonMarkup .= self::$clientActionObj->addClientAction ( array (
                'action' => $clientAction
                    ) ) ;
        }
        return $buttonMarkup ;
    }

    public static function widget ( $widgetName, $params )
    {
        $widgetObj = \f\widgetFactory::make ( $widgetName ) ;
        return $widgetObj->render ( $params ) ;
    }

}
