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

        if ( isset($loginInfo[ 'owner_id' ]) )
        {
            return $loginInfo[ 'owner_id' ] ;
        }
        else if ( isset($loginInfo[ 'legacyOwnerId' ]) )
        {
            return $loginInfo[ 'legacyOwnerId' ] ;
        }
        else
        {
            return $this->getOwnerFront();
        }
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

        if ( $this->sessionG->exists('auth') )
        {
            return $this->sessionG->read('auth') ;
        }
        return false ;
    }

    /** Legacy Support * */
    public function getLegacyLoginRecord()
    {
        $params = $this->request->getAssocParams() ;

        $this->sqlEngine->Select()
                ->From('core_legacy_login_info')
                ->Where('session_id = ?', $params[ 'sessionId' ])
                ->Run() ;

        $legacyLoginInfo = $this->sqlEngine->getRow() ;

        return $legacyLoginInfo ;
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

    public function getDomainOwner()
    {

        $this->sqlEngine->Select('U.id as userId, U.owner_id as ownerId')
                ->From('core_domain as D')
                ->joinTable('core_website as W')
                ->On('D.core_websiteid = W.id')
                ->joinTable('core_user as U')
                ->On('W.core_userid = U.id')
                ->Where('D.domain = ?', \f\DOMAIN)
                ->Run() ;

        return $this->sqlEngine->getRow() ;
    }

    public function getSiteOwnerByUserName()
    {
        $params = $this->request->getAssocParams() ;

        $siteOwnerId = $params[ 'siteOwnerId' ] ;
        $username    = $params[ 'username' ] ;

        $this->sqlEngine->Select()
                ->From('core_user')
                ->Where('id = ' . $siteOwnerId)
                ->andWhere('username = "' . $username . '"')
                ->Run() ;

        return $this->sqlEngine->getRow() ;
    }

    public function getSiteAdminByUserName()
    {
        $params = $this->request->getAssocParams() ;

        $siteOwnerOwnerId = $params[ 'siteOwnerOwnerId' ] ;
        $username         = $params[ 'username' ] ;

        $this->sqlEngine->Select()
                ->From('core_user')
                ->Where('id = ' . $siteOwnerOwnerId)
                ->andWhere('username = "' . $username . '"')
                ->Run() ;

        return $this->sqlEngine->getRow() ;
    }

    public function getSiteUserByUserName()
    {
        $params = $this->request->getAssocParams() ;

        $siteOwnerId = $params[ 'siteOwnerId' ] ;
        $username    = $params[ 'username' ] ;

        $this->sqlEngine->Select()
                ->From('core_user')
                ->Where('owner_id = ' . $siteOwnerId)
                ->andWhere('username = "' . $username . '"')
                ->Run() ;

        return $this->sqlEngine->getRow() ;
    }

//    public function queryUserByUAO() // username and owner
//    {
//        $username = $this->request->getParam('username') ;
//        $ownerId  = $this->request->getParam('ownerId') ;
//
//        $this->sqlEngine->Select()
//                ->From('core_user')
//                ->Where('username = ?', $username)
//                ->andWhere('owner_id = ?', $ownerId)
//                ->Run() ;
//
//        $userInfo = $this->sqlEngine->getRow() ;
//
//        return empty($userInfo) ? false : $userInfo ;
//    }

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

    public function queryUserById()
    {
        $userId = $this->request->getParam('userId') ;

        $this->sqlEngine->Select()
                ->From('core_user')
                ->Where('id = ?', $userId)
                ->Run() ;

        $userInfo = $this->sqlEngine->getRow() ;

        return empty($userInfo) ? false : $userInfo ;
    }

    public function clearLoginInfo()
    {
        $this->registerGadgets(array (
            'sessionG' => 'session'
        )) ;

        /* Legacy support */
        if ( $this->sessionG->exists('sessionId') )
        {
            $sessionId = $this->sessionG->read('sessionId') ;
            $this->sqlEngine->Delete('core_legacy_login_info')
                    ->Where('session_id = ?', $sessionId)
                    ->Run() ;

            setcookie("userName", '', time() - 3600, "/") ;
        }

        $this->sessionG->destroy() ;
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

    /** Legacy support * */
    public function delExpiredLegacySessions()
    {
        $now = time() ;
        $this->sqlEngine->Delete('core_legacy_login_info')
                ->Where('session_expire < ' . $now)
                ->Run() ;
    }
    public function getOwnerFront()
    {
        $this->sqlEngine->Select('W.core_userid as ownerId')
                ->From('core_domain as D')
                ->joinTable('core_website as W')
                ->On('D.core_websiteid = W.id')
                //->joinTable('core_user as U')
                //->On('W.core_userid = U.id')
                ->Where('D.domain = ?', \f\DOMAIN)
                ->Run() ;

        $row=$this->sqlEngine->getRow() ;
        
        return $row['ownerId'];
    }
    
    public function getSiteId()
    {
        $this->sqlEngine->Select('core_websiteid AS siteId')
                ->From('core_domain as D')
                ->Where('D.domain = ?', \f\DOMAIN)
                ->Run() ;

        $row=$this->sqlEngine->getRow() ;
        
        return $row['siteId'];
    }

}
