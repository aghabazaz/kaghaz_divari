<?php

/**
 * @author hajian <mn.hajian@gmail.com>
 * @package core.rbac
 * @category component
 */
class rbacController extends \f\controller
{

    /**
     *
     * @var rbacView
     */
    private $view ;
    private $roleView ;


    public function __construct()
    {
        require_once 'rbacView.php' ;
        require_once 'z_roleView.php' ;
        $this->view = new rbacView ;

        $this->roleView   = new roleView ;
        $this->cacheEngine = new \f\cacheStorageEngine ;
        
        parent::__construct() ;
        
        
    }

    /* used */

    public function index()
    {
        return $this->render(array (
                    'breadcrumb' => 'core.rbac.index',
                    'content'    => $this->view->rbacDashboard()
                )) ;
    }

    /* used */

    public function permissions()
    {
        if ( $this->request->getParam(0) === 'getRecords' )
        {
            $params = $this->request->getAssocParams() ;

            $permissionListMarkup = $this->view->renderPermissionRecords($params) ;

            return $this->response($permissionListMarkup) ;
        }
        else
        {
            $gridMarkup = $this->view->renderPermissionListHEAD('permissions') ;
            return $this->render(array (
                        'breadcrumb' => 'core.rbac.permissions',
                        'content'    => $gridMarkup
                    )) ;
        }
    }

    /* used */

    public function permissionAdd()
    {
        $params = $this->request->getAssocParams() ;

        if ( $this->request->getParam(0) === 'savePerm' )
        {
            $response = \f\ttt::service('core.rbac.permission.saveNewPermission',
                                        $params) ;
            if ( $response[ 'result' ] === 'success' )
            {
                $response[ 'message' ] = 'دسترسی با موفقیت ثبت شد.' ;
            }
            $this->cacheEngine->clear();
            return $this->response($response) ;
        }
        else
        {
            $newPermissionMarkup = $this->view->renderNewPermission() ;
            return $this->render(array (
                        'breadcrumb' => 'core.rbac.permissionAdd',
                        'content'    => $newPermissionMarkup
                    )) ;
        }
    }

    /* used */

    public function permissionEdit()
    {
        $params = $this->request->getAssocParams() ;

        if ( $this->request->getParam(0) === 'savePerm' )
        {

            $response = \f\ttt::service('core.rbac.permission.updatePermission',
                                        $params) ;

            if ( $response[ 'result' ] === 'success' )
            {
                $response[ 'message' ] = 'دسترسی با موفقیت بروزرسانی شد.' ;
            }
            $this->cacheEngine->clear();
            return $this->response($response) ;
        }
        else
        {
            $permissionId         = $this->request->getParam(0) ;
            $editPermissionMarkup = $this->view->renderEditPermission($permissionId) ;
            return $this->render(array (
                        'breadcrumb' => 'core.rbac.permissionEdit',
                        'content'    => $editPermissionMarkup
                    )) ;
        }
    }

    /* used */

    public function removePermission()
    {
        $params       = $this->request->getAssocParams() ;
        $removeResult = \f\ttt::service('core.rbac.permissionRemove', $params) ;
        return $this->response($removeResult) ;
    }

    /* used */

    public function roles()
    {
        $params = $this->request->getAssocParams() ;

        if ( $this->request->getParam(0) === 'getRecords' )
        {
            return $this->response($this->roleView->renderRoleGrid($params)) ;
        }
        else
        {
            return $this->render(array (
                        'breadcrumb' => 'core.rbac.roles',
                        'content'    => $this->roleView->rolesList()
                    )) ;
        }
    }

    /* used */

    public function roleAdd()
    {
        $params = $this->request->getAssocParams() ;

        if ( $this->request->getParam(0) === 'saveRole' )
        {
            unset($params[ 'saveRole' ]) ;

            $params[ 'perms' ] = json_decode($params[ 'perms' ], true) ;

            \f\ttt::service('core.rbac.role2.saveRole', $params) ;
            return $this->response(array (
                        'result'  => 'success',
                        'message' => 'نقش با موفقیت ایجاد شد.'
                    )) ;
        }
        else
        {
            $roleAddMarkup = $this->roleView->renderRoleAdd() ;
            return $this->render(array (
                        'breadcrumb' => 'core.rbac.roleAdd',
                        'content'    => $roleAddMarkup
                    )) ;
        }
    }

    /* used */

    public function roleEdit()
    {
        $params = $this->request->getAssocParams() ;

        if ( $this->request->getParam(0) === 'updateRole' )
        {
            $params[ 'perms' ] = json_decode($params[ 'perms' ], true) ;

            \f\ttt::service('core.rbac.role2.updateRole', $params) ;
            return $this->response(array (
                        'result'  => 'success',
                        'message' => 'نقش با موفقیت بروز رسانی شد.'
                    )) ;
        }
        else
        {
            $roleId = $this->request->getParam(0) ;

            $roleEditMarkup = $this->roleView->renderRoleEdit($roleId) ;
            return $this->render(array (
                        'breadcrumb' => 'core.rbac.roleEdit',
                        'content'    => $roleEditMarkup
                    )) ;
        }
    }

    /* used */

    public function getPermissionActions()
    {

        $params = $this->request->getAssocParams() ;

        $permActions = \f\ttt::service('core.rbac.permission.getPermissionActinos',
                                       array (
                    'permId' => $params[ 'permId' ]
                )) ;

        return $this->response($permActions) ;
    }

    /* used */

    public function removeRole()
    {
        return $this->response(\f\ttt::service('core.rbac.role.removeRole',
                                               $this->request->getAssocParams())) ;
    }

}
