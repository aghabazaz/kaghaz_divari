<?php

/**
 * @author Yuness Mehdian <mehdian.y@gmail.com>
 * @package core.auth
 * @category component
 */
class authController extends \f\controller
{

    /**
     *
     * @var authView
     */
    private $view ;

    public function __construct()
    {
        include 'authView.php' ;
        $this->view = new authView ;
        parent::__construct() ;
    }

    public function index()
    {
        
    }

    public function login()
    {
		
		

        # render login form
        if ( ! $this->request->getParam('username') )
        {
            if ( \f\ttt::service('core.auth.alreadyLogin') )
            {
                $this->redirect() ;
            }
            $this->setLayout('backend.login') ;
            return $this->render($this->view->loginForm()) ;
        }
        else # login
        {
			

            $this->request->addAssocParam(array (
                'domainName' => \f\ifm::app()->domain
            )) ;
			//\f\pre($this->request);

            $checkPermissionResult = \f\ttt::service('core.auth.login',
                                                     $this->request) ;

          //\f\pre($checkPermissionResult);
            # if login success
            //\f\pre($checkPermissionResult);
            if ( $checkPermissionResult )
            {
                
                $this->redirect() ;
            }
            else
            {
                $this->setLayout('backend.login') ;
                return $this->render($this->view->loginForm(true)) ;
            }
        }
    }

    public function logout()
    {
        $loginSource = \f\ifm::app()->loginSource() ;
        \f\ttt::service('core.auth.logout') ;
        if ( $loginSource === 'newPortal' )
        {
            header("Location: " . \f\ifm::app()->siteUrl . 'administrator/login') ;
        }
        else
        {
            header("Location: " . \f\ifm::app()->siteUrl . 'cms') ;
        }
    }

    private function checkSingleApplication()
    {
        $this->registerGadgets(array (
            'sessionG' => 'session'
        )) ;

        $actions = ($this->sessionG->read('actions')) ;

        $apps = array () ;
        foreach ( $actions as $path => $action )
        {
            $pathParts = explode('.', $path) ;

            if ( ! isset($apps[ $pathParts[ 0 ] ]) )
            {
                $apps[ $pathParts[ 0 ] ] = true ;
            }
        }

        if ( count($apps) === 2 )
        {
            $this->sessionG->write('singleApp', true) ;
            next($apps) ;
            $appName = key($apps) ;
            return $appName . '.' . 'index' ;
        }

        return false ;
    }

    private function redirect()
    {

        $dashboardUrl  = \f\ifm::app()->siteUrl . 'administrator' ;
        if ( $singleAppPath = $this->checkSingleApplication() )
        {
            
            $singAppDashboardUrl = str_replace('.', '/', $singleAppPath) ;

            $dashboardUrl = \f\ifm::app()->baseUrl . $singAppDashboardUrl ;
        }


        header("location: $dashboardUrl") ;
    }

    public function authStatsFilter()
    {
        
    }

}
