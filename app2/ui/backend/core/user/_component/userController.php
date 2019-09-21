<?php

class userController extends \f\controller
{

    /**
     *
     * @var userView
     */
    private $view ;

    public function __construct()
    {
        require_once 'userView.php' ;
        $this->view = new userView ;
        parent::__construct() ;
    }

    public function index()
    {
        return $this->render(array (
                    'breadcrumb' => 'core.user.index',
                    'content'    => $this->view->userDashboard(),
                )) ;
    }

    public function mainUser()
    {
        return $this->render(array (
                    'breadcrumb' => 'core.user.mainUser',
                    'content'    => $this->view->renderUserList('mainUser'),
                )) ;
    }

    public function siteUser()
    {
        return $this->render(array (
                    'breadcrumb' => 'core.user.siteUser',
                    'content'    => $this->view->renderUserList('siteUser'),
                )) ;
    }

    public function colleagueUser()
    {
        return $this->render(array (
                    'breadcrumb' => 'core.user.colleagueUser',
                    'content'    => $this->view->renderUserList('colleagueUser'),
                )) ;
    }

    public function memberUser()
    {
        return $this->render(array (
                    'breadcrumb' => 'core.user.memberUser',
                    'content'    => $this->view->renderUserList('memberUser'),
                )) ;
    }

    public function userList()
    {
        $requestDataTble = $this->request->getAssocParams() ;
        $param           = $this->request->getParam(0) ;

        return $this->response($this->view->renderUserGrid($requestDataTble,
                                                           $param)) ;
    }

    public function userAdd()
    {
        return $this->render(array (
                    'breadcrumb' => 'core.user.userAdd',
                    'content'    => $this->view->renderUserAdd($this->request->getParam(0)),
                )) ;
    }

    public function cityList()
    {
        /** Get city list * */
        /* @var $city userService */
        $cityGet = \f\ttt::service('core.user.getCity',
                                   array ( 'country' => $this->request->getParam('country') )) ;
        $city    = array () ;
        if ( $cityGet )
        {
            foreach ( $cityGet as $resultCity )
            {
                $city[ $resultCity[ 'id' ] ] = $resultCity[ 'name' ] ;
            }
        }
        else
        {
            $city[] = '' ;
        }

        return $this->response($city) ;
    }

    public function userSave()
    {
        return $this->response(\f\ttt::service('core.user.userSave',
                                               $this->request->getAssocParams())) ;
    }

    public function userEdit()
    {
        return $this->render(array (
                    'breadcrumb' => 'core.user.userEdit',
                    'content'    => $this->view->renderUserEdit($this->request->getNonAssocParams ()),
                )) ;
    }

    public function changePassword()
    {
        return $this->render(array (
                    'breadcrumb' => 'core.user.changePassword',
                    'content'    => $this->view->renderChangePassword(),
                )) ;
    }

    public function saveChangePassword()
    {
        return $this->response(\f\ttt::service('core.user.saveChangePassword',
                                               $this->request->getAssocParams())) ;
    }

    public function remove()
    {
        //\f\pr(  $this->request->getAssocParams());
        return $this->response(\f\ttt::service('core.user.userRemove',
                                               $this->request->getAssocParams())) ;
    }

    public function active()
    {
        return $this->response(\f\ttt::service('core.user.userActive',
                                               $this->request->getAssocParams())) ;
    }

    public function assignPermissionUser()
    {
        $params        = $this->request->getAssocParams() ;
        $noAssocParams = $this->request->getNonAssocParams() ;

        return $this->renderPartial(array (
                    'breadcrumb' => 'core.user.assignPermissionUser',
                    'content'    => $this->view->renderAssignPermission($noAssocParams[ 0 ]),
                )) ;
    }

    public function assignPermission()
    {
        $params = $this->request->getAssocParams() ;

        if ( isset($params[ 'save' ]) )
        {
            \f\ttt::service('core.user.saveUserPerms', $params) ;
            return $this->response(array ( 'result' => 'success' )) ;
        }
        else
        {
            $permissionListMarkup = $this->view->renderPermissionsList($params[ 'userId' ]) ;

            return $this->response(array (
                        'content' => $permissionListMarkup
                    )) ;
        }
    }

}
