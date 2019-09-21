<?php

namespace f ;

class dalFactory extends componentFactory
{

    public static function make($componentCatalog, $request = NULL)
    {
        if ( empty($request) )
        {
            $request = new request ;
        }
        return self::get('dal', $componentCatalog, $request) ;
    }

}
