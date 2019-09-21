<?php

class langService extends \f\service
{

    public function getLangCodes()
    {
        
    }
    
    
    public function getAllActiveLang()
    {
        return \f\ttt::dal ( 'core.lang.activeLang' ) ;
    }

}
