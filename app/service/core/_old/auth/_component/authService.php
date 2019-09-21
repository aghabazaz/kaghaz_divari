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

    public function registerAgencyId()
    {
        \f\ttt::dal('core.auth.registerAgencyId', $this->request) ;
    }

    private function checkUnusedTime()
    {
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

    public function checkPermission()
    {

        if ( $this->checkUnusedTime() === 'out' )
        {
            $this->logout() ;
            return 0 ;
        }

        # new system login check
        $OldLoginInfo = \f\ttt::dal('core.auth.getOldLoginInfo', $this->request) ;

        $loginInfo = empty($OldLoginInfo) ? \f\ttt::dal('core.auth.getLoginInfo',
                                                        $this->request) : false ;

        if ( $OldLoginInfo )
        {
            # Old login session check
            if ( (( int ) $OldLoginInfo[ 'sessionExpireTime' ]) <= time() && $loginInfo === false )
            {
                $this->logout() ;
                return 0 ; # not logged in
            }

            $userInfo = \f\ttt::dal('core.auth.queryUserByUsername',
                                    array (
                        'username' => $OldLoginInfo[ 'username' ]
                    )) ;

            $userInfo[ 'agencyId' ] = $OldLoginInfo[ 'agencyId' ] ;

            $userInfo[ 'sessionExpireTime' ] = $OldLoginInfo[ 'sessionExpireTime' ] ;

            if ( $userInfo[ 'agencyId' ] == $userInfo[ 'username' ] )
            {
                $userInfo[ 'owner_id' ] = $userInfo[ 'id' ] ;
            }

            $this->loginOccured($userInfo, false, true) ;
        }
        # not logged in - if No login information found in the system for this user
        else if ( $loginInfo === false )
        {
            return 0 ; # not logged in
        }

        # user is logged in, check permission to run 
        #   the method and get method's filter (is has)
        return \f\ttt::service('core.rbac.executive.checkPermission',
                               array (
                    'path' => $this->request->getParam('path')
                )) ;
    }

    public function logout()
    {
        \f\ttt::dal('core.auth.logAuth',
                    array (
            'mode' => 'logout'
        )) ;
        $loginInfo = \f\ttt::dal('core.auth.clearLoginInfoFromSession') ;
        return $loginInfo[ 'loginTo' ] ;
    }

    public function getEnteredUserInfo()
    {
        return \f\ttt::dal('core.auth.getLoginInfo') ;
    }

    public function alreadyLogin()
    {
        # old system login check
        $loginInfo    = \f\ttt::dal('core.auth.getLoginInfo') ;
        $OldLoginInfo = false ;

        if ( $loginInfo )
        {
            return true ;
        }

        $OldLoginInfo = \f\ttt::dal('core.auth.getOldLoginInfo', $this->request) ;

        # new system login check

        if ( $OldLoginInfo )
        {
            $userInfo = \f\ttt::dal('core.auth.queryUserByUsername',
                                    array (
                        'username' => $OldLoginInfo[ 'username' ]
                    )) ;

            $userInfo[ 'agencyId' ] = $OldLoginInfo[ 'agencyId' ] ;

            $this->loginOccured($userInfo, false) ;
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

        return false ;
    }

    public function login()
    {
        $params = $this->request->getAssocParams() ;
		
		
        # Is it already login?
        if ( $this->alreadyLogin() )
        {
            return $this->state(3, false) ;
        }
		
        # search by username
        $domainOwnerInfo = \f\ttt::dal('core.auth.getDomainOwner') ;
		
        $userInfo = $this->getUserInfo($params[ 'username' ], $domainOwnerInfo) ;
		
//        $userInfo = \f\ttt::dal('core.auth.queryUserByUsername',
//                                array (
//                    'username' => $params['username'],
//                )) ;

//        if ( \f\DOMAIN === 'mitmat.ir' )
//        {
//            \f\pr($domainOwnerInfo) ;
//            \f\pre($userInfo) ;
//        }


        if ( ! $userInfo )
        {
            return $this->state(1, false) ;
        }

        // If user is not website owner
        $domainIsNotCorrect = $domainOwnerInfo[ 'userId' ] !== $userInfo[ 'id' ] ;

        // if user is not Website admin
        $domainIsNotCorrect = $domainIsNotCorrect && $domainOwnerInfo[ 'ownerId' ] !== $userInfo[ 'id' ] ;

        // if user is not defined in this website
        $domainIsNotCorrect = $domainIsNotCorrect && $domainOwnerInfo[ 'userId' ] !== $userInfo[ 'owner_id' ] ;

        if ( $domainIsNotCorrect )
        {
            return $this->state(1, false) ;
        }

        if ( ! $this->request->getParam('autoLogin') )
        {
            # compare passwords
            $this->registerGadgets(array (
                'codingG' => 'coding'
            )) ;

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

    /**
     * Save login info in session 
     * Load and cache user permissions (send request to RBAC)
     * 
     * @param array $userInfo
     */
    private function loginOccured($userInfo, $remember, $oldSystemLogin = false)
    {
        # Prevent cache again
        $loginInfo = \f\ttt::dal('core.auth.getLoginInfo') ;

        if ( $loginInfo )
        {
            return ;
        }

        # change session lifetime
        if ( $remember === false && $userInfo[ 'sessionExpireTime' ] !== 0 )
        {
            $sessionExpireInSeconds = (( int ) $userInfo[ 'sessionExpireTime' ]) - time() ;
        }
        else if ( $remember === false && $userInfo[ 'sessionExpireTime' ] === 0 )
        {
            $sessionExpireInSeconds = 1209600 ; # 2 week
        }
        else if ( $remember )
        {
            $sessionExpireInSeconds = 1209600 ; # 2 Week
        }

        \f\ttt::dal('core.auth.setSessionLifeTime',
                    array (
            'seconds' => $sessionExpireInSeconds
        )) ;

        # Save login info into session
        # 
        # Differentiate between / Admin / Super Admin / Main User /
        # 
        # Super admin : owner == NULL
        # Admin       : owner == Super Admin
        # Main User   : owner == Admin

        $mainUserInfo = \f\ttt::dal('core.auth.queryUserByUsername',
                                    array (
                    'username' => $userInfo[ 'agencyId' ]
                )) ;

        if ( empty($userInfo[ 'owner_id' ]) )
        {
            // Super Admin
            $userInfo[ 'owner_id' ] = $mainUserInfo[ 'id' ] ;
            $userInfo[ 'admin' ]    = TRUE ;
        }
        else if ( $userInfo[ 'id' ] == $mainUserInfo[ 'owner_id' ] )
        {
            // Admin
            $userInfo[ 'owner_id' ] = $mainUserInfo[ 'id' ] ;
            $userInfo[ 'admin' ]    = TRUE ;
        }
        else
        {
            // Main user
            $userInfo[ 'admin' ] = FALSE ;
        }

        $userInfo[ 'loginTo' ] = 'legacyCMS' ;
        if ( ! $oldSystemLogin )
        {
            $userInfo[ 'loginTo' ] = 'newPortal' ;

            $userInfo[ 'owner_id' ] = $this->detectNewSystemOwner() ;
        }

        $userInfo[ 'loginTime' ] = time() ;
        \f\ttt::dal('core.auth.storeLoginInfoInSession',
                    array (
            'loginInfo' => $userInfo
        )) ;

        # log the Login
        \f\ttt::dal('core.auth.logAuth',
                    array (
            'mode' => 'login'
        )) ;

        # load and cache user permissions (RBAC)

        \f\ttt::service('core.rbac.executive.cachePermissions',
                        array (
            'userId' => $userInfo[ 'id' ]
        )) ;
    }

    private function detectNewSystemOwner()
    {
        $domainName = $this->request->getParam('domainName') ;

        $domainInfo = \f\ttt::service('core.website.run.getDomainInfo',
                                      array (
                    'domainName' => $domainName
                )) ;

//        $websiteOwnerInfo = \f\ttt::dal('core.auth.getUserById',
//                                        array (
//                    'userId' => $domainInfo[ 'websiteOwner' ]
//                )) ;

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

        return $userInfo[ 'admin' ] ;
    }

}
