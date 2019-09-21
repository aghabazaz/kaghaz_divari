<?php

/**
 * @author hajian <mn.hajian@gmail.com>
 * @package core.rbac
 * @category component
 */
class usersController extends \f\controller
{

    public function permissionUserSave()
    {
        $params     = $this->request->getAssocParams() ;
        $saveResult = \f\ttt::service('core.rbac.users.permissionUserSave',
                                      $params) ;
        return $this->response($saveResult) ;
    }

}
