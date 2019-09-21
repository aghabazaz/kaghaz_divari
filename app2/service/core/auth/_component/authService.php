<?php

/**
 * Login and check permission to run requested action by user
 * 
 * @author Yuness Mehdian <mehdian.y@gmail.com>
 * @package core.auth
 * @category component
 */
class authService extends \f\service
{

    /**
     *
     * @var \f\g\coding 
     */
    protected $codingG ;

    public function __construct($params)
    {
        parent::__construct($params) ;
        $this->registerGadgets(array (
            'sessionG' => 'session',
            'codingG'  => 'coding'
        )) ;
    }

    public function getUserOwner()
    {
        return \f\ttt::dal('core.auth.getUserOwner') ;
    }

    public function getAgencyId()
    {
        return \f\ttt::dal('core.auth.getAgencyId') ;
    }

    public function getUserId()
    {
        return \f\ttt::dal('core.auth.getUserId') ;
    }

    public function checkAdmin()
    {
        return \f\ttt::dal('core.auth.checkAdmin') ;
    }

    public function getUsername()
    {
        $loginInfo = \f\ttt::dal('core.auth.getLoginInfo') ;

        if ( $loginInfo !== false )
        {
            return $loginInfo[ 'username' ] ;
        }

        return false ;
    }

    public function registerLegacyOwnerId()
    {
        $params = $this->request->getAssocParams() ;

        $auth = array () ;

        if ( $this->sessionG->exists('auth') )
        {
            $auth = $this->sessionG->read('auth') ;
        }

        $userInfo = \f\ttt::dal('core.auth.queryUserByUsername',
                                array (
                    'username' => $params[ 'agencyId' ]
                )) ;

        $auth[ 'legacyOwnerId' ] = $userInfo[ 'id' ] ;

        $this->sessionG->write('auth', $auth) ;
    }

    private function checkUnusedTime()
    {
        return 'stay' ;
        $loginInfo = \f\ttt::dal('core.auth.getLoginInfo') ;

        if ( empty($loginInfo) )
        {
            return false ;
        }

        if ( $loginInfo[ 'loginTo' ] === 'legacyCMS' )
        {
            $loginTime = \f\ttt::dal('core.auth.getLegacyLoginTime') ;
        }
        else
        {
            $loginTime = $loginInfo[ 'loginTime' ] ;
        }

        if ( (time() - $loginTime) / 60 >= 30 )
        {
            return 'out' ;
        }
        \f\ttt::dal('core.auth.updateUnusedTime') ;

        return 'stay' ;
    }

    /** Legacy support * */
    private function checkLegacyLogoutTimer($legacyLoginInfo)
    {
        if ( (intval($legacyLoginInfo[ 'sessionExpireTime' ])) <= time() )
        {
            return 'timed_out' ;
        }
        return 'stay' ;
    }

    /** Legacy Support * */
    private function doLegacyLogin($sessionId)
    {

        /** Get legacy login Record * */
        \f\ttt::dal('core.auth.delExpiredLegacySessions') ;

        $legacyLoginRecord = \f\ttt::dal('core.auth.getLegacyLoginRecord',
                                         array (
                    'sessionId' => $sessionId
                )) ;

        if ( empty($legacyLoginRecord) )
        {
            return false ;
        }

        $legacyLoginInfo = array (
            'agencyId'          => $legacyLoginRecord[ 'agency_id' ],
            'username'          => $legacyLoginRecord[ 'username' ],
            'sessionExpireTime' => $legacyLoginRecord[ 'session_expire' ]
                ) ;

//        /** Check legacy logout timer * */
//        if ( $this->checkLegacyLogoutTimer($legacyLoginInfo) === 'timed_out' )
//        {
//            $this->logout() ;
//            return false ;
//        }

        /** Login user * */
        $loginInfo = \f\ttt::dal('core.auth.queryUserByUsername',
                                 array (
                    'username' => $legacyLoginInfo[ 'username' ]
                )) ;

        if ( empty($loginInfo) )
        {
            return false ;
        }

        $loginInfo[ 'legacyUsername' ]    = $legacyLoginInfo[ 'username' ] ;
        $loginInfo[ 'agencyId' ]          = $legacyLoginInfo[ 'agencyId' ] ;
        $loginInfo[ 'sessionExpireTime' ] = $legacyLoginInfo[ 'sessionExpireTime' ] ;
        $loginInfo[ 'sessionId' ]         = $sessionId ;

        $this->loginOccured($loginInfo, false, true) ;
        return true ;
    }

    /* Legacy Support */

    private function getLegacySessionId()
    {
        $sessionId = $this->sessionG->read('sessionId') ;

        return $sessionId ;
    }

    public function checkPermission()
    {
        /* Legacy support */
        $sessionId = $this->getLegacySessionId() ;

        /* Verify authentication */
        if ( ! $this->alreadyLogin() && ! $this->doLegacyLogin($sessionId) )
        {
             //\f\pr( 'okk');
            return 'Authentication_Failed' ; /* Authentication Failed */
        }

        $params = $this->request->getAssocParams() ;

        /* Verify authorization */
        return \f\ttt::service('core.rbac.executive.checkPermission',
                               array (
                    'path' => $params[ 'path' ]
                )) ;
    }

    public function logout()
    {
        \f\ttt::dal('core.auth.logAuth',
                    array (
            'mode' => 'logout'
        )) ;

        \f\ttt::dal('core.auth.clearLoginInfo') ;
    }

    public function getEnteredUserInfo()
    {
        return \f\ttt::dal('core.auth.getLoginInfo') ;
    }

    public function alreadyLogin()
    {

        $loginInfo = \f\ttt::dal('core.auth.getLoginInfo') ;

        if ( ! empty($loginInfo) )
        {
            return true ;
        }
        return false ;
    }

    private function getUserInfo($username, $domainOwnerInfo)
    {

        $siteAdminInfo = \f\ttt::dal('core.auth.getSiteAdminByUserName',
                                     array (
                    'username'         => $username,
                    'siteOwnerOwnerId' => $domainOwnerInfo[ 'ownerId' ]
                )) ;

        if ( ! empty($siteAdminInfo) )
        {
            return $siteAdminInfo ;
        }

        $siteOwnerInfo = \f\ttt::dal('core.auth.getSiteOwnerByUserName',
                                     array (
                    'username'    => $username,
                    'siteOwnerId' => $domainOwnerInfo[ 'userId' ]
                )) ;

        if ( ! empty($siteOwnerInfo) )
        {
            return $siteOwnerInfo ;
        }

        $siteUserInfo = \f\ttt::dal('core.auth.getSiteUserByUserName',
                                    array (
                    'username'    => $username,
                    'siteOwnerId' => $domainOwnerInfo[ 'userId' ]
                )) ;

        if ( ! empty($siteUserInfo) )
        {
            return $siteUserInfo ;
        }

        $superadminInfo = \f\ttt::dal('core.user.getSuperadmin',
                                      array (
                    'username' => $username
                )) ;

        if ( ! empty($superadminInfo) )
        {
            return $superadminInfo ;
        }

        return false ;
    }

    public function login()
    {
        

        $params = $this->request->getAssocParams() ;
        
        //\f\pre($params);
        
        

        # Is it already login?
        if ( $this->alreadyLogin() )
        {
            return $this->state(3, false) ;
        }

        # search by username
        $domainOwnerInfo = \f\ttt::dal('core.auth.getDomainOwner') ;

        $userInfo = $this->getUserInfo($params[ 'username' ], $domainOwnerInfo) ;
        
        if ( ! $userInfo )
        {
            return $this->state(1, false) ;
        }

        // If user is not website owner
        $domainIsNotCorrect = $domainOwnerInfo[ 'userId' ] !== $userInfo[ 'id' ] ;

        // if user is not Website admin
        $domainIsNotCorrect = $domainIsNotCorrect && $domainOwnerInfo[ 'ownerId' ] !== $userInfo[ 'id' ] ;

        // If user is not defined in this website
        $domainIsNotCorrect = $domainIsNotCorrect && $domainOwnerInfo[ 'userId' ] !== $userInfo[ 'owner_id' ] ;

        $domainIsNotCorrect = $domainIsNotCorrect && ! empty($userInfo[ 'owner_id' ]) ;
         //l\f\pre('false');

        if ( empty($userInfo[ 'owner_id' ]) )
        {
            $userInfo[ 'isSuperadmin' ] = true ;
        }
        if ( $domainIsNotCorrect )
        {
            return $this->state(1, false) ;
        }

        if ( ! $this->request->getParam('autoLogin') )
        {

            $password               = $this->request->getParam('password') ;
            $enteredEncodedPassword = $this->codingG->encode($password) ;

            $realEncodedPassword = $userInfo[ 'password' ] ;

            $passwordsIsSame = $this->codingG->compareEncodedPasswords($enteredEncodedPassword,
                                                                       $realEncodedPassword) ;
            
        }
        else
        {
            $passwordsIsSame = true ;
        }
        
        if ( $passwordsIsSame )
        {
            $remember = $this->request->getParam('remember') ;

            $this->loginOccured($userInfo, $remember) ;
            
            return $userInfo ;
        }
       
        return false ;
    }

    /** Legacy Support * */
    private function loginOccured($userInfo, $remember, $legacyLogin = false)
    {

        /* Legacy support * */
        $sessionExpireTime = intval($userInfo[ 'sessionExpireTime' ]) ;

        if ( $remember || $sessionExpireTime > 0 )
        {
            $sessionExpireInSeconds = 1209600 ; /* Two weeks */
            if ( $sessionExpireTime > 0 )
            {
                $sessionExpireInSeconds = $sessionExpireTime - time() ;
            }
            $this->sessionG->setLifeTime($sessionExpireInSeconds) ;
        }

        if ( $legacyLogin )
        {
            /** Legacy Support * */
            $this->defineUserTypeAndOwnerLegacy($userInfo) ;
            $this->sessionG->setSessionId($userInfo[ 'sessionId' ]) ;
        }
        else
        {
            $this->defineUserTypeAndOwner($userInfo) ;
        }
        

        $userInfo[ 'loginTime' ] = time() ;

        $this->sessionG->write('auth', $userInfo) ;

        # log the Login
        \f\ttt::dal('core.auth.logAuth',
                    array (
            'mode' => 'login'
        )) ;

        # load and cache user permissions (RBAC)

        \f\ttt::service('core.rbac.executive.cachePermissions',
                        array (
            'userId' => $userInfo[ 'id' ],
            'all'    => $userInfo[ 'username' ] === 'superadmin'
        )) ;
    }

    private function defineUserTypeAndOwnerLegacy(&$userInfo)
    {
        $userInfo[ 'loginTo' ] = 'legacyCMS' ;
        \f\ifm::app()->loginSource('legacyCMS') ;

        /** Check superadmin * */
        if ( $userInfo[ 'username' ] === 'superadmin' )
        {
            
            $userInfo[ 'superadmin' ] = true ;
            $userInfo[ 'userType' ]   = 'superadmin' ;
            $ownerRecord              = \f\ttt::dal('core.auth.queryUserByUsername',
                                                    array (
                        'username' => $userInfo[ 'agencyId' ]
                    )) ;
            $userInfo[ 'owner_id' ]   = $ownerRecord[ 'id' ] ;
            return $userInfo ;
        }

        /** Check site owner * */
        if ( $userInfo[ 'legacyUsername' ] === $userInfo[ 'agencyId' ] )
        {
            $userInfo[ 'siteOwner' ] = true ;
            $userInfo[ 'userType' ]  = 'siteOwner' ;
            $userInfo[ 'owner_id' ]  = $userInfo[ 'id' ] ;
            return $userInfo ;
        }

        /** Check site admin * */
        $ownerRecord = \f\ttt::dal('core.auth.queryUserByUsername',
                                   array (
                    'username' => $userInfo[ 'agencyId' ]
                )) ;

        if ( $ownerRecord[ 'owner_id' ] === $userInfo[ 'id' ] )
        {
            $userInfo[ 'siteAdmin' ] = true ;
            $userInfo[ 'userType' ]  = 'siteAdmin' ;
            $userInfo[ 'owner_id' ]  = $ownerRecord[ 'id' ] ;
            return $userInfo ;
        }

        /** Check backend user * */
        if ( $userInfo[ 'owner_id' ] === $ownerRecord[ 'id' ] )
        {
            $userInfo[ 'backendUser' ] = true ;
            $userInfo[ 'userType' ]    = 'backendUser' ;
            return $userInfo ;
        }

        return 'invalid_user' ;
    }

    private function defineUserTypeAndOwner(&$userInfo)
    {
        $userInfo[ 'loginTo' ] = 'newPortal' ;
        \f\ifm::app()->loginSource('newPortal') ;

        $domainOwnerId = $this->geDomainOwnerId() ; /* New system login */

        /** Check superadmin * */
        if ( $userInfo[ 'username' ] === 'superadmin' )
        {
            $userInfo[ 'superadmin' ] = true ;
            $userInfo[ 'userType' ]   = 'superadmin' ;
            $userInfo[ 'owner_id' ]   = $domainOwnerId ;
            return $userInfo ;
        }

        /** Check site owner * */
        if ( $userInfo[ 'id' ] === $domainOwnerId )
        {
            $userInfo[ 'siteOwner' ] = true ;
            $userInfo[ 'userType' ]  = 'siteOwner' ;
            $userInfo[ 'owner_id' ]  = $domainOwnerId ;
            return $userInfo ;
        }

        $domainOwnerRecord = \f\ttt::dal('core.auth.queryUserById',
                                         array (
                    'userId' => $domainOwnerId
                )) ;

        /** Check site admin * */
        if ( $userInfo[ 'id' ] === $domainOwnerRecord[ 'owner_id' ] )
        {
            $userInfo[ 'siteAdmin' ] = true ;
            $userInfo[ 'userType' ]  = 'siteAdmin' ;
            $userInfo[ 'owner_id' ]  = $domainOwnerId ;
            return $userInfo ;
        }

        /** Check site user * */
        if ( $userInfo[ 'owner_id' ] === $domainOwnerId )
        {
            $userInfo[ 'backendUser' ] = true ;
            $userInfo[ 'userType' ]    = 'backendUser' ;
            return $userInfo ;
        }

        return 'invalid_user' ;
    }

    private function geDomainOwnerId()
    {
        $domainInfo = \f\ttt::service('core.website.run.getDomainInfo',
                                      array (
                    'domainName' => \f\DOMAIN
                )) ;

        return $domainInfo[ 'websiteOwner' ] ;
    }

    public function notLoginRequiredPaths()
    {
       
        return array (
            'core.fileManager.loader',
            'core.auth.login',
            'core.auth.logout',
                ) ;
    }

    public function getSessionAuth()
    {
        return \f\ttt::dal('core.auth.getSessionAuth') ;
    }

    public function loginTo()
    {
        return \f\ttt::dal('core.auth.loginTo') ;
    }

    public function isAdmin()
    {

        $userInfo = \f\ttt::dal('core.auth.getLoginInfo') ;
        
        
        
        if($userInfo['userType']=='siteAdmin' || $userInfo['userType']=='siteOwner')
        {
            return 1;
        }
        else
        {
            return 0;
        }

        
    }

}
