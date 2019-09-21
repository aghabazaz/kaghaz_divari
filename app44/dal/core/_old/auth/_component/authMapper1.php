<?php

class authMapper extends \f\dal
{

    /**
     *
     * @var \f\g\date
     */
    private $d ;

    public function __construct()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
    }

    public function getUserId()
    {
        $this->registerGadgets(array (
            'd'        => 'date',
            'sessionG' => 'session',
        )) ;

        $loginInfo = $this->sessionG->read('auth') ;

        return $loginInfo[ 'id' ] ;
    }

    public function getUserOwner()
    {

        $this->registerGadgets(array ( 'sessionG' => 'session' )) ;

        $loginInfo = $this->sessionG->read('auth') ;

        return $loginInfo[ 'owner_id' ] ;
    }

    public function updateUnusedTime()
    {
        $this->registerGadgets(array (
            'sessionG' => 'session',
        )) ;

        $auth = $this->sessionG->read('auth') ;

        $auth[ 'loginTime' ] = time() ;
        $this->sessionG->write('loginTime', time()) ;
        $this->sessionG->write('auth', $auth) ;
    }

    public function getLegacyLoginTime()
    {
        $this->registerGadgets(array (
            'sessionG' => 'session',
        )) ;

        return $this->sessionG->read('loginTime') ;
    }

    public function checkAdmin()
    {
        $this->registerGadgets(array (
            'sessionG' => 'session',
        )) ;

        $loginInfo = $this->sessionG->read('auth') ;

        return $loginInfo[ 'admin' ] ;
    }

    private function getUserByUSERNAME($username)
    {
        $this->sqlEngine->Select()
                ->From('core_user')
                ->Where('username = ?', $username)
                ->Run() ;

        return $this->sqlEngine->getRow() ;
    }

    public function registerAgencyId()
    {

        $this->registerGadgets(array ( 'sessionG' => 'session' )) ;

        $agencyId = $this->request->getParam('agencyId') ;

        $user = $this->getUserByUSERNAME($agencyId) ;

        $loginInfo = array (
            'owner_id' => $user[ 'id' ],
            'agencyId' => $this->request->getParam('agencyId')
                ) ;

        $this->sessionG->write('auth', $loginInfo) ;
    }

    public function getUsername()
    {
        $loginInfo = $this->getLoginInfo() ;
        return $loginInfo[ 'username' ] ;
    }

    /**
     * Old system support
     * @return string
     */
    public function getAgencyId()
    {
        $loginInfo = $this->getLoginInfo() ;
        return $loginInfo[ 'agencyId' ] ;
    }

    public function getLoginInfo()
    {

        $this->registerGadgets(array (
            'sessionG' => 'session'
        )) ;

        $this->sessionG->sessionStart() ;

        $sessionId = $this->request->getParam('sessionId') ;

        if ( $sessionId )
        {
            $this->sessionG->setSessionId($sessionId) ;
        }

        if ( $this->sessionG->exists('auth') )
        {
            return $this->sessionG->read('auth') ;
        }
        return false ;
    }

    public function setSessionLifeTime()
    {
        $seconds = $this->request->getParam('seconds') ;
        session_set_cookie_params($seconds, "/") ;
    }

    public function getOldLoginInfo()
    {
        $this->registerGadgets(array (
            'sessionG' => 'session'
        )) ;

        $sessionId = $this->request->getParam('sessionId') ;

        if ( ! $sessionId )
        {
            $sessionId = $this->sessionG->read('sessionId') ;
        }

        if ( ! $sessionId )
        {
            return false ;
        }

        $this->sqlEngine->Select()
                ->From('core_legacy_login_info')
                ->Where('session_id = ?', $sessionId)
                ->Run() ;

        $legacyLoginInfo = $this->sqlEngine->getRow() ;

        return array (
            'agencyId'          => $legacyLoginInfo[ 'agency_id' ],
            'username'          => $legacyLoginInfo[ 'username' ],
            'sessionExpireTime' => $legacyLoginInfo[ 'session_expire' ]
                ) ;
    }

    public function logAuth()
    {
        $mode = $this->request->getParam('mode') ;

        $loginInfo = $this->getLoginInfo() ;

        $this->registerGadgets(array (
            'sessionG' => 'session'
        )) ;

        switch ( $mode )
        {
            case 'login':
                $this->sqlEngine->save('core_auth_log',
                                       array (
                    'login_time'  => date('Y-m-d g:i:s'),
                    'core_userid' => $loginInfo[ 'id' ],
                    'user_agent'  => $_SERVER[ 'HTTP_USER_AGENT' ],
                    'ip'          => $_SERVER[ 'REMOTE_ADDR' ],
                    'status'      => 'login'
                )) ;
                $loginInfo[ 'auth_log_id' ] = $this->sqlEngine->last_id() ;
                $this->sessionG->write('auth', $loginInfo) ;
                break ;

            case 'logout':
                $authLogId = $loginInfo[ 'auth_log_id' ] ;
                $this->sqlEngine->save('core_auth_log',
                                       array (
                    'logout_time' => date('Y-m-d g:i:s'),
                    'status'      => 'logout'
                        ), array ( 'id = ?', array ( $authLogId ) )) ;
                break ;
        }
    }

    public function queryUserByUsername()
    {
        $username = $this->request->getParam('username') ;

        $this->sqlEngine->Select()
                ->From('core_user')
                ->Where('username = ?', $username)
                ->Run() ;

        $userInfo = $this->sqlEngine->getRow() ;

        return empty($userInfo) ? false : $userInfo ;
    }

    public function clearLoginInfoFromSession()
    {
        $authInfo = array () ;
        $this->registerGadgets(array ( 'sessionG' => 'session' )) ;
        if ( $this->sessionG->exists('auth') )
        {
            $authInfo = $this->sessionG->read('auth') ;
            $this->sessionG->delete('auth') ;
        }

        if ( $this->sessionG->exists('sessionId') )
        {
            # Logout legacy system
            $sessionId = $this->sessionG->read('sessionId') ;
            $this->sqlEngine->Delete('core_legacy_login_info')
                    ->Where('session_id = ?', $sessionId)
                    ->Run() ;

            setcookie("userName", '', time() - 3600, "/") ;
        }
        $this->sessionG->destroy() ;
        return $authInfo ;
    }

    public function storeLoginInfoInSession()
    {

        $this->registerGadgets(array ( 'sessionG' => 'session' )) ;

        $loginInfo = $this->request->getParam('loginInfo') ;

        if ( isset($_COOKIE[ 'username' ]) )
        {
            $_COOKIE[ 'username' ] = $loginInfo[ 'username' ] ;
        }
        else
        {
            setcookie("username", $loginInfo[ 'username' ],
                      strtotime('+14 days'), "/") ;
        }

        $this->sessionG->write('auth', $loginInfo) ;
    }

    public function getUserById()
    {
        $userId = $this->request->getParam('userId') ;

        $this->sqlEngine->Select()
                ->From('core_user')
                ->Where('id = ?', $userId)
                ->Run() ;

        return $this->sqlEngine->getRow() ;
    }

    public function getSessionAuth()
    {
        $this->registerGadgets(array ( 'sessionG' => 'session' )) ;

        return $this->sessionG->read('auth') ;
    }

    public function loginTo()
    {
        $this->registerGadgets(array ( 'sessionG' => 'session' )) ;

        $authInfo = $this->sessionG->read('auth') ;

        return $authInfo[ 'loginTo' ] ;
    }

}
