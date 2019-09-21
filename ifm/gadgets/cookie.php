<?php

namespace f\g ;

class cookie
{


    public function read($key)
    {
        
        $cookie=$_COOKIE[$key];
        
        if ( isset($cookie) )
        {
            
            return $cookie ;
        }
        
        return false ;
    }

    public function write($key, $value,$expire='',$path='/')
    {
        if(!$expire)
        {
            $expire=time()+(3600*24);
        }   
       
        $result=setcookie($key, $value, $expire, $path);
        return $result ;
    }

    public function delete($key)
    {
       
        $result=setcookie($key,'', time ()-10,'/');
        return $result ;
    }

}
