<?php

namespace f ;

class gadgetFactory
{

    /**
     * Creates an instance of given widget and returns it
     * @param string $widgetName
     * @param array $params to be passed to constructor
     * @return CWidget|boolean the widget if it is found else false
     */
    public static function make($gadgetName, $params = array ())
    {
        
        $pathToGadget    = ROOT . DS . 'ifm' . DS . 'gadgets' . DS . "$gadgetName.php" ;
        $gadgetClassName = __NAMESPACE__ . "\\g\\{$gadgetName}" ;
        //\f\pr('ok');
        if ( file_exists($pathToGadget) )
        {
            require_once $pathToGadget ;
            if ( ! empty($params) )
            {
                $gadget = new $gadgetClassName($params) ;
            }
            else
            {
                $gadget = new $gadgetClassName ;
            }
            return $gadget ;
        }
        throw new publicException("Gadget '$gadgetName' was not found in path '$pathToGadget'") ;
    }

}
