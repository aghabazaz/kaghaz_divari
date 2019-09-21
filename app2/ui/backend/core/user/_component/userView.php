<?php

class userView extends \f\view
{

    public function userDashboard ()
    {
        /* @var $dashboardWidget \f\w\dashboard */
        $dashboardWidget = \f\widgetFactory::make ( 'dashboard' ) ;
        $baseUrl         = \f\ifm::app ()->baseUrl . 'core/user/' ;
        $uploadUrl       = \f\ifm::app ()->uploadUrl . 'icons/ui/user/' ;
        $items           = array (
            array (
                'url'    => $baseUrl . 'siteUser',
                'title'  => \f\ifm::t ( 'siteUser' ),
                'target' => '_self',
                'icon'   => $uploadUrl . 'site.user.png' ),
//            array ( 'url'    => $baseUrl . 'colleagueUser', 'title'  => \f\ifm::t('colleagueUser'),
//                'target' => '_self', 'icon'   => $uploadUrl . 'colleague.user.png' ),
//            array ( 'url'    => $baseUrl . 'memberUser', 'title'  => \f\ifm::t('memberUser'),
//                'target' => '_self', 'icon'   => $uploadUrl . 'member.user.png' ),
            array (
                'url'    => $baseUrl . 'changePassword',
                'title'  => \f\ifm::t ( 'changePassword' ),
                'target' => '_self',
                'icon'   => $uploadUrl . 'change.password.png' ),
                ) ;

        $userType = \f\ifm::app ()->getUserType () ;
        if ( $userType === 'superadmin' || $userType === 'siteAdmin' )
        {
            $a = array (
                'url'    => $baseUrl . 'mainUser',
                'title'  => \f\ifm::t ( 'mainUser' ),
                'target' => '_self',
                'icon'   => $uploadUrl . 'main.user.png' ) ;
            array_unshift ( $items, $a ) ;
        }

        return $dashboardWidget->renderGrid ( $items ) ;
    }

    public function renderUserList ( $param = '' )
    {

        return $this->render ( 'userList',
                               array (
                    'param' => $param,
                ) ) ;
    }

    public function renderUserGrid ( $requestDataTble, $param = '' )
    {
        /** Get users list * */
        $userList = \f\ttt::service ( 'core.user.getUsers',
                                      array (
                    'dataTableParams' => $requestDataTble,
                    'param'           => $param ) ) ;


        //\f\pre($userList);

        /* @var $table \f\w\table */
        $table = \f\widgetFactory::make ( 'table' ) ;

        $row = $this->setMainUser ( $userList, $param ) ;

        $row[ 'total' ] = $userList[ 'total' ] ;
        $row[ 'draw' ]  = $userList[ 'draw' ] ;

        $userListRow = $table->renderRow ( $row ) ;
        return $userListRow ;
    }

    private function setMainUser ( $userList, $param )
    {
        $row = array () ;
        foreach ( $userList[ 'data' ] as $value )
        {
            $actions    = $this->createActionButtons ( $value, $param ) ;
            $fieldNames = array (
                'name'  => 'name',
                'phone' => 'phone',
                'email' => 'email'
                    ) ;
            if ( $value[ 'personality' ] === 'legal' )
            {
                $fieldNames = array (
                    'name'  => 'l_name',
                    'phone' => 'l_phone',
                    'email' => 'l_email'
                        ) ;
            }
            $field = array (
                array (
                    'style'     => array (
                        'border' => 'none',
                    ),
                    'formatter' => "<input id='c" . $value[ 'id' ] . "' type='checkbox' class='checkBox'/>",
                ),
                array (
                    'htmlOptions' => array (
                        'id' => 'bgparent',
                    ),
                    'style'       => array (
                        'border' => 'none',
                        'color'  => 'red !important',
                    ),
                    'formatter'   => $value[ $fieldNames[ 'name' ] ],
                ),
                array (
                    'htmlOptions' => array (
                        'class' => 'tdsearch',
                    ),
                    'style'       => array (
                        'border' => 'none',
                    ),
                    'formatter'   => $value[ $fieldNames[ 'phone' ] ],
                ),
                array (
                    'htmlOptions' => array (
                        'class' => 'tdsearch',
                    ),
                    'style'       => array (
                        'border' => 'none',
                    ),
                    'formatter'   => $value[ $fieldNames[ 'email' ] ],
                ),
                array (
                    'htmlOptions' => array (
                        'class' => 'act',
                    ),
                    'style'       => array (
                        'border' => 'none',
                    ),
                    'formatter'   => $actions
                ),
                    ) ;
            // tr make
            // data-on-confirm='hi'
            $row[] = array (
                'htmlOptions' => array (
                    'id'    => '',
                    'class' => 'c' . $value[ 'id' ],
                ),
                'style'       => array (
                    'background' => 'red !important',
                ),
                'td'          => $field,
                    ) ;
        }
        return $row ;
    }

    private function createActionButtons ( $list, $param )
    {
        $deleteButton = array (
                    'type'           => 'delete',
                    'confirm'        => true,
                    'action'         => 'core.user.remove',
                    'clientCallback' => 'remove',
                    'params'         => array (
                        'id'       => $list[ 'id' ],
                        'selector' => "\"#c{$list[ 'id' ]}\""
                    ),
                ) ;

        $editButton = array (
            'id'   => 'edit' . $list[ 'id' ],
            'type' => 'edit',
            'href' => \f\ifm::app ()->baseUrl . 'core/user/userEdit/' . $list[ 'id' ] . '/' . $param
                ) ;


        $addPermissionButton = array (
            'type'         => 'custom',
            'title'        => 'اختصاص دسترسی به کاربر',
            'icon'         => 'fa fa-key fa-lg',
            'id'           => "ps_" . $list[ 'id' ],
            'clientAction' => array (
                'display' => 'dialog',
                'params'  => array (
                    'targetRoute'    => "core.user.assignPermission",
                    'triggerElement' => "ps_" . $list[ 'id' ],
                    'dialogTitle'    => 'اختصاص دسترسی به کاربر',
                    'ajaxParams'     => array (
                        'userId' => $list[ 'id' ]
                    )
                )
            )
                ) ;

        $toggleEnableButton = array (
            'type'           => 'status',
            'status'         => $list[ 'status' ],
            'confirm'        => true,
            'id'             => 's' . $list[ 'id' ],
            'action'         => 'core.user.active',
            'clientCallBack' => 'toggleEnable',
            'params'         => array (
                'id'     => $list[ 'id' ],
                'status' => "\"{$list[ 'status' ]}\""
            ),
                ) ;

        $buttonsParam = array (
            $editButton,
            $addPermissionButton,
            $toggleEnableButton,
            $deleteButton,
                ) ;

        return \f\html::gridButton ( $buttonsParam ) ;
    }

    private function setSiteUser ( $userList )
    {
        $row = array () ;
        foreach ( $userList[ 'data' ] as $key => $value )
        {
            $img               = $value[ 'status' ] = 'enable' ? 'tick-circle.gif' : 'minus-circle.gif' ;
            $field             = array (
                array (
                    'style'     => array (
                        'border' => 'none',
                    ),
                    'formatter' => "<input type='checkbox' class='checkBox'/>",
                ),
                array (
                    'htmlOptions' => array (
                        'id' => 'bgparent',
                    ),
                    'style'       => array (
                        'border' => 'none',
                        'color'  => 'red !important',
                    ),
                    'formatter'   => $value[ 'first_name' ],
                ),
                array (
                    'htmlOptions' => array (
                        'class' => 'tdsearch',
                    ),
                    'style'       => array (
                        'border' => 'none',
                    ),
                    'formatter'   => $value[ 'last_name' ],
                ),
                array (
                    'htmlOptions' => array (
                        'class' => 'act',
                    ),
                    'style'       => array (
                        'border' => 'none',
                    ),
                    'formatter'   => "<a href='" . \f\ifm::app ()->baseUrl . 'core/user/userEdit/' . $value[ 'id' ] . "'><img src='" . \f\ifm::app ()->uploadUrl . "icons/ui/table/user_edit.png'  width='16' height='16' alt='edit' style='margin-left:5px'/></a>
                                      <a href='javascript:void(0)' onclick='widgetHelper.remove('" . $value[ 'id' ] . "','')'><img src='" . \f\ifm::app ()->uploadUrl . "icons/ui/table/trash.png'  width='16' height='16' alt='delete' /></a>
                                      <a href='javascript:void(0)' id='ac-" . $value[ 'id' ] . "' class='activeUser' onclick='active_user(" . $value[ 'id' ] . ");' ><img src='" . \f\ifm::app ()->uploadUrl . "icons/ui/table/" . $img . " ?>'  width='16' height='16' alt='edit' style='margin-left:5px'/></a>",
                ),
                    ) ;
            // tr make
            $row[]             = array (
                'htmlOptions' => array (
                    'id'    => 'c_' . $value[ 'id' ],
                    'class' => 'odd',
                ),
                'style'       => array (
                    'border' => 'none',
                ),
                'td'          => $field,
                    ) ;
        }
        return $row ;
    }

    public function renderUserAdd ( $param = '' )
    {
        /** Get country list * */
        /* @var $country userService */
        $countryGet = \f\ttt::service ( 'core.user.getCountry' ) ;

        /** Get job group list * */
        /* @var $jobGroup userService */
        $jobGroup = \f\ttt::service ( 'core.user.getJobGroup' ) ;

        foreach ( $jobGroup as $resultJob )
        {
            $job[ $resultJob[ 'id' ] ] = $resultJob[ 'title' ] ;
        }
        foreach ( $countryGet as $resultCountry )
        {
            $country[ $resultCountry[ 'code' ] ] = $resultCountry[ 'name' ] ;
        }

        return $this->render ( 'userAdd',
                               array (
                    'country' => $country,
                    'job'     => $job,
                    'param'   => $param,
                ) ) ;
    }

    public function renderUserEdit ( $param )
    {
        /** Get country list * */
        /* @var $country userService */

        $id = $param[ 0 ] ;

        $countryGet = \f\ttt::service ( 'core.user.getCountry' ) ;

        /** Get job group list * */
        /* @var $jobGroup userService */
        $jobGroup = \f\ttt::service ( 'core.user.getJobGroup' ) ;

        $row = \f\ttt::service ( 'core.user.getUserInfo',
                                 array (
                    'id' => $id ) ) ;
        foreach ( $jobGroup as $resultJob )
        {
            $job[ $resultJob[ 'id' ] ] = $resultJob[ 'title' ] ;
        }
        foreach ( $countryGet as $resultCountry )
        {
            $country[ $resultCountry[ 'code' ] ] = $resultCountry[ 'name' ] ;
        }

        return $this->render ( 'userAdd',
                               array (
                    'row'     => $row,
                    'country' => $country,
                    'job'     => $job,
                    'param'   => $param[ 1 ],
                ) ) ;
    }

    public function renderChangePassword ( $id = '69' )
    {
        $row = \f\ttt::service ( 'core.user.changePasswordInfo',
                                 array (
                    'id' => $id ) ) ;
        return $this->render ( 'changePassword',
                               array (
                    'row' => $row,
                ) ) ;
    }

    public function renderAssignPermission ( $userid )
    {

        $row = \f\ttt::service ( 'core.user.getUserInfo',
                                 array (
                    'id' => $userid ) ) ;

        /** Get permission list * */
        $permission = \f\ttt::service ( 'core.rbac.getAllPermission' ) ;

        $user_permission = \f\ttt::service ( 'core.rbac.users.getUserPermission',
                                             array (
                    'userid' => $userid ) ) ;

        return $this->render ( 'assignPermission',
                               array (
                    'userid'          => $userid,
                    'row'             => $row,
                    'permission'      => $permission,
                    'user_permission' => $user_permission
                ) ) ;
    }

    public function renderPermissionsList ( $userId )
    {
        $userAssigns = \f\ttt::service ( 'core.rbac.permission.getUserAssigns',
                                         array (
                    'userId' => $userId
                ) ) ;

        return $this->render ( 'assignPermission2',
                               array (
                    'perms'  => $userAssigns[ 'perms' ],
                    'roles'  => $userAssigns[ 'roles' ],
                    'userId' => $userId
                ) ) ;
    }

}
