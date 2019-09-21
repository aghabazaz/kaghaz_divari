<?php

namespace f\g ;

class session
{

    public function setSessionId($sessionId)
    {
        session_id($sessionId) ;
    }

    public function sessionStart()
    {
        $sessionId = session_id() ;
        if ( empty($sessionId) )
        {
            session_start() ;
        }
    }

    public function destroy()
    {
        session_destroy() ;
    }

    public function read($key)
    {
        $this->sessionStart() ;
        if ( isset($_SESSION[ $key ]) )
        {
            return $_SESSION[ $key ] ;
        }
        return false ;
    }

    public function write($key, $value)
    {
        $this->sessionStart() ;
        $_SESSION[ $key ] = $value ;
        return true ;
    }

    public function delete($key)
    {
        $this->sessionStart() ;
        if ( isset($_SESSION[ $key ]) )
        {
            unset($_SESSION[ $key ]) ;
        }
        return true ;
    }

    /**
     * Check if there a key exists in the session or not.
     * 
     * @param string $key the key to search in session
     * @return boolean
     * 
     */
    public function exists($key)
    {
        $this->sessionStart() ;
        if ( isset($_SESSION[ $key ]) )
        {
            return true ;
        }
        return false ;
    }

}
