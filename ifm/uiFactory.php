<?php

namespace f ;

class uiFactory extends componentFactory
{

    public static function make($componentCatalog, $request = NULL)
    {
        //\f\pr($componentCatalog);
        if ( empty($request) )
        {
            $request = new request ;
        }

        return self::get('ui', $componentCatalog, $request) ;
    }

}
