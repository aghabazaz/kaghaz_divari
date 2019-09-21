<?php

namespace f ;

class cacheStorageEngine
{

    private $cacheSystem ;
    private $memcache ;
    private $session;

    public function __construct()
    {
        $this->cacheSystem = 'SESSION' ; //Config::get("cache") ;
        if ( $this->cacheSystem == 'Memcached' )
        {
            $this->memcache = new \Memcache() ;
            $this->memcache->connect('localhost', 11211) ;
        }
        if($this->cacheSystem == 'SESSION')
        {
            $this->session=  \f\gadgetFactory::make('session');
        }
    }

    public function fetch($key)
    {
    	//echo $key;
        if ( $this->cacheSystem == 'APC' )
        {
            return apc_fetch($key) ;
        }

        if ( $this->cacheSystem == 'Memcached' )
        {
            return $this->memcache->get($key) ;
        }
        if($this->cacheSystem == 'SESSION')
        {
            return $this->session->read($key);
        }
    }

    //--------------------------------------------------------------------------
    public function store($key, $data, $ttl = 86400)
    {
    	//echo $key;
        if ( $this->cacheSystem == 'APC' )
        {
            apc_store($key, $data, $ttl) ;
        }
        if ( $this->cacheSystem == 'Memcached' )
        {
            $this->memcache->set($key, $data, 0, $ttl) ;
        }
        if($this->cacheSystem == 'SESSION')
        {
            return $this->session->write($key,$data);
        }
    }

    //--------------------------------------------------------------------------
    public function delete($key)
    {
        if ( $this->cacheSystem == 'APC' )
        {
            apc_delete($key) ;
        }
        if ( $this->cacheSystem == 'Memcached' )
        {
            $this->memcache->delete($key) ;
        }
        if($this->cacheSystem == 'SESSION')
        {
            return $this->session->delete($key);
        }
    }

    //--------------------------------------------------------------------------
    public function clear()
    {
        if ( $this->cacheSystem == 'APC' )
        {
            apc_clear_cache('user') ;
        }
        if ( $this->cacheSystem == 'Memcached' )
        {
            $this->memcache->flush() ;
        }
    }

    /**
     * 
     * @param mixed $key a key name staring or an array of keys strings
     * @return bool
     */
    public function exists($key)
    {
        if ( $this->cacheSystem == 'APC' )
        {
            return apc_exists($key) ;
        }
        if($this->cacheSystem == 'SESSION')
        {
            return $this->session->exists($key);
        }
        
        
    }

    //--------------------------------------------------------------------------
    protected function compressed($compressed)
    {
        return $compressed == false ? 0 : MEMCACHE_COMPRESSED ;
    }

}
