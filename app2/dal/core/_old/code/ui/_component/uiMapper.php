<?php

class uiMapper extends \f\dal
{

    public function __construct()
    {
        $this->cacheEngine = new \f\cacheStorageEngine ;
    }

    public function getCachedFrontendPaths()
    {
        return array () ; # always refresh cache
        if ( $this->cacheEngine->exists('frontendPaths') )
        {
            return $this->cacheEngine->fetch('frontendPaths') ;
        }
        else
        {
            return array () ;
        }
    }

    public function cacheFrontendPaths()
    {
        $params = $this->request->getParam('paths') ;
        $this->cacheEngine->store('frontendPaths', $params[ 'paths' ]) ;
    }

}
