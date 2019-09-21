<?php

namespace f ;

class component
{

    /**
     * @var array the property container
     */
    private $_m ;

    /**
     * The getter function for component properties,
     * The component can also have custom getTest method for test property.
     * @param string $name the property name
     * @return mixed
     * @throws Exception
     */
    public function __get($name)
    {
        $getter = 'get' . ucfirst($name) ;
        if ( method_exists($this, $getter) )
        {
            return $this->$getter() ;
        }
        elseif ( isset($this->_m[ $name ]) )
        {
            return $this->_m[ $name ] ;
        }

        throw new publicException("$name is not defined !") ;
    }

    /**
     * 
     * @param string $name the property name
     * @param mixed $value the property value
     * @return mixed the property value to chain use. <pre> $a = $this->test = 2; </pre>
     * @throws Exception
     */
    public function __set($name, $value)
    {
        $setter = 'set' . $name ;
        if ( method_exists($this, $setter) )
        {
            return $this->$setter($value) ;
        }
        else
        {
            $this->_m[ $name ] = $value ;
            return $value ;
        }

        throw new publicException("$name is not defined !") ;
    }

    protected function registerGadgets($gadgets)
    {
        //\f\pre('ok');
        foreach ( $gadgets as $var => $gadgetName )
        {
            $this->$var = \f\gadgetFactory::make($gadgetName) ;
        }
    }

    public function registerWidgets($widgets)
    {
        foreach ( $widgets as $var => $widgetName )
        {
            $this->$var = \f\widgetFactory::make($widgetName) ;
        }
    }

}
