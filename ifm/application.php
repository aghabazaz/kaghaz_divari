<?php

namespace f ;

/**
 * Abstract application.
 */
class application extends component
{

    private $runningModuleType ;
    private $userInfo ;
    private $loginSource ;

    public function __construct($config = NULL)
    {
        $this->configure($config) ;
    }

    public function setRunningModule($type)
    {
        $this->runningModuleType = $type ;
    }

    public function getRunningModuleType()
    {
        return $this->runningModuleType ;
    }

    /**
     * Configures the application created. 
     * @param array Configuration array to config application by.
     */
    public function configure($config)
    {
        $configArray = array () ;
        if ( ! is_array($config) )
        {
            if ( file_exists($config) )
            {
                $configArray = require_once($config) ;
            }
        }
        else
        {
            $configArray = $config ;
        }

        if ( is_array($configArray) && count($configArray) )
        {
            foreach ( $configArray as $key => $value )
            {
                $this->$key = $value ;
            }
        }
    }

    public function run()
    {
        return frontController::run() ;
    }

    /**
     * Terminate the application.
     * This method replaces PHP's exit() function. 
     * Any code can run here when the application terminates.
     * 
     * @param mixed $status 0 = normal exit, <>0 = anormal exit
     */
    public function end($status = 0)
    {
        pre($status) ;
    }

    public function loginSource($source = '')
    {
        if ( empty($source) )
        {
            if ( empty($this->loginSource) )
            {
                return $this->loginSource = $this->getUserInfo('loginTo') ;
            }
            return $this->loginSource ;
        }
        $this->loginSource = $source ;
    }

    public function getUserInfo($key = '')
    {
        if ( empty($this->userInfo) )
        {
            $this->userInfo = \f\ttt::service('core.auth.getEnteredUserInfo') ;
        }

        if ( empty($key) )
        {
            return $this->userInfo ;
        }

        return $this->userInfo[ $key ] ;
    }

    public function getUserType()
    {
        if ( empty($this->userInfo) )
        {
            $this->userInfo = \f\ttt::service('core.auth.getEnteredUserInfo') ;
        }

        return $this->userInfo[ 'userType' ] ;
        ;
    }

}
