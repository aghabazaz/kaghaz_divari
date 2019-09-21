<?php

namespace f ;

class serviceFactory extends componentFactory
{

    public static function make($componentCatalog, $request = NULL)
    {
        
        if ( empty($request) )
        {
            $request = new request ;
        }
        return self::get('service', $componentCatalog, $request) ;
    }

}
