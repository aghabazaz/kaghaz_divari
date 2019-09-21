<?php

namespace f ;

class widgetFactory
{

    /**
     * Creates an instance of given widget and returns it
     * @param string $widgetName
     * @param array $params to be passed to constructor
     * @return CWidget|boolean the widget if it is found else false
     */
    public static function make($widgetName, $params = array ())
    {
        $pathToWidget    = ROOT . DS . 'ifm' . DS . 'widgets' . DS . "$widgetName.php" ;
        $widgetClassName = __NAMESPACE__ . "\\w\\{$widgetName}" ;
        if ( file_exists($pathToWidget) )
        {
            require_once $pathToWidget ;
            if ( ! empty($params) )
            {
                $widget = new $widgetClassName($params) ;
            }
            else
            {
                $widget = new $widgetClassName ;
            }
            return $widget ;
        }
        throw new publicException("Widget '$widgetName' was not found in path '$pathToWidget'") ;
    }

}
