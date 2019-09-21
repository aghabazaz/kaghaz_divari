<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 *
 * @package \member\member
 * @items component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class memberService extends \f\service
{

    /**
     *
     * @var shortcutMapper
     */
    private $mapper ;

    public function __construct ()
    {
        $this->mapper = \f\dalFactory::make ( 'member' ) ;
    }

    public function getMemberById ()
    {
        return \f\ttt::dal ( 'member.getMemberById',
                             $this->request->getAssocParams () ) ;
    }

    public function getMemberByOwnerId ()
    {
        return \f\ttt::dal ( 'member.getMemberByOwnerId',
                             $this->request->getAssocParams () ) ;
    }

    public function memberListList ()
    {
        return \f\ttt::dal ( 'member.memberListList',
                             $this->request->getAssocParams () ) ;
    }

    public function memberListSave ()
    {
        $params = $this->request->getAssocParams () ;
       // \f\pre($params);
        if ( $params[ 'id' ] )
        {
            if($params['addInfo'])
            {
                $params[ 'birthday' ] = $params[ 'birthDay-year' ] . '/' . $params[ 'birthDay-month' ] . '/' . $params[ 'birthDay-day' ] ;
                $params[ 'card' ]     = $params[ 'card1' ] . $params[ 'card2' ] . $params[ 'card3' ] . $params[ 'card4' ] ;

                $result = \f\ttt::dal ( 'member.memberListAddInfoSaveEdit', $params ) ;
                $msg    = \f\ifm::t ( 'memberListSaveEdit' ) ;
                $reset  = FALSE ;

            }else{

                $params[ 'birthday' ] = $params[ 'birthDay-year' ] . '/' . $params[ 'birthDay-month' ] . '/' . $params[ 'birthDay-day' ] ;
                $result = \f\ttt::dal ( 'member.memberListSaveEdit', $params ) ;
                $msg    = \f\ifm::t ( 'memberListSaveEdit' ) ;
                $reset  = FALSE ;
            }
        }
        else
        {
            $checkUsernameLogin = \f\ttt::dal ( 'member.memberCheckUsername',
                                                $params ) ;
            if ( ! empty ( $checkUsernameLogin ) )
            {
                return array (
                    'result'  => 'error',
                    'message' => \f\ifm::t ( 'repeatUserError' ) ) ;
            }
            $result = \f\ttt::dal ( 'member.memberListSave', $params ) ;
            $msg    = \f\ifm::t ( 'memberListSave' ) ;
            $reset  = TRUE ;
        }
        if ( $result )
        {
            $data = array (
                'result'  => 'success',
                'message' => $msg,
                'reset'   => $reset,
                'id'      => $result ) ;
        }
        else
        {
            $data = array (
                'result'  => 'error',
                'message' => \f\ifm::t ( 'dbError' ) ) ;
        }

        //\f\pre($data);
        return $data ;
    }

    public function memberListDelete ()
    {
        return \f\ttt::dal ( 'member.memberListDelete',
                             $this->request->getAssocParams () ) ;
    }

    public function memberListStatus ()
    {
        return \f\ttt::dal ( 'member.memberListStatus',
                             $this->request->getAssocParams () ) ;
    }

    public function getMemberListList ()
    {
        return \f\ttt::dal ( 'member.getMemberListList',
                             $this->request->getAssocParams () ) ;
    }

    public function memberListDetails ()
    {

        $param = $this->request->getAssocParams () ;

        $row = \f\ttt::dal ( 'member.getMemberById', $param ) ;
        return $row ;
    }

    public function checkLogin ()
    {
        $params             = $this->request->getAssocParams () ;
        $checkUsernameLogin = \f\ttt::dal ( 'member.memberCheckUsername',
                                            $params ) ;
        if ( ! empty ( $checkUsernameLogin ) )
        {
            if ( $checkUsernameLogin[ 'status' ] == 'enabled' )
            {
                $checkPasswordLogin = \f\ttt::dal ( 'member.checkPasswordLogin',
                                                    $params ) ;
                $password           = md5 ( sha1 ( md5 ( $params[ 'password' ] ) ) ) ;
                $salt1              = substr ( $checkPasswordLogin[ 'password' ],
                                               0, 9 ) ;
                $salt2              = substr ( $checkPasswordLogin[ 'password' ],
                                               -(5) ) ;
                $password           = $salt1 . $password . $salt2 ;

                if ( $password == $checkPasswordLogin[ 'password' ] )
                {
                    $checkPasswordLogin[ 'user_id' ] = $checkPasswordLogin[ 'id' ] ;
                    $checkPasswordLogin[ 'name' ]    = $checkPasswordLogin[ 'name' ] ;
                    $checkPasswordLogin[ 'email' ]   = $checkPasswordLogin[ 'email' ] ;
                    unset ( $checkPasswordLogin[ 'password' ] ) ;

                    $countOrders                         = \f\ttt::service ( 'shop.orderItem.countOrdersUnpayd',
                                                                             array (
                                'user_id' => $checkPasswordLogin[ 'user_id' ]
                            ) ) ;
                    $checkPasswordLogin[ 'order_count' ] = $countOrders ;

                    $countLike=f\ttt::dal ( 'shop.product.getFavoriteProductByUseId',
                        array (
                            'user_id' => $checkPasswordLogin[ 'user_id' ]
                        ) ) ;
                    $checkPasswordLogin[ 'like_count' ] = count($countLike) ;
                    $this->auth ( $checkPasswordLogin ) ;
//                    \f\ttt::dal ( 'ent24.member.saveLog',
//                                  array (
//                        'ent24_userid' => $checkPasswordLogin[ 'id' ],
//                        'action'       => 'login',
//                        'param'        => '',
//                        'ip'           => $_SERVER[ 'REMOTE_ADDR' ],
//                        'date'         => time ()
//                    ) ) ;

                    if ( $params[ 'remember' ] == 1 )
                    {
                        $hash = sha1 ( md5 ( ($params[ 'email' ] . rand ( 9999,
                                                                          999999999999 ) ) ) ) ;
                        if ( isset ( $_COOKIE[ 'email' ] ) )
                        {
                            $_COOKIE[ 'userName' ] = $hash ;
                        }
                        else
                        {
                            setcookie ( "userName", $hash,
                                        strtotime ( '+14 days' ), "/" ) ;
                        }
                        \f\ttt::dal ( 'member.saveRememberCode',
                                      array (
                            'id'       => $checkPasswordLogin[ 'id' ],
                            'remember' => $hash
                        ) ) ;
                        $reset = TRUE ;
                    }

                    $data = array (
                        'result'  => 'success',
                        'message' => \f\ifm::t ( 'okLogin' ),
                        'reset'   => $reset ) ;
                }
                else
                {
                    //\f\pre('aaa');
                    $data = array (
                        'result'  => 'error',
                        'message' => \f\ifm::t ( 'badPassword' ) ) ;
                }
            }
            else
            {
                $data = array (
                    'result'  => 'error',
                    'message' => \f\ifm::t ( 'blockUsername' ) ) ;
            }
        }
        else
        {
          //  \f\pre('aaa');
            $data = array (
                'result'  => 'error',
                'message' => \f\ifm::t ( 'noUsername' ) ) ;
        }
        return $data ;
    }

    public function auth ( $param )
    {
        $_SESSION = $param ;
    }

    public function changePassword ()
    {
        $params = $this->request->getAssocParams () ;

        if ( $params[ 'newPassword' ] == $params[ 'newPasswordRepeat' ] )
        {

            $result = ( \f\ttt::dal ( 'member.changePassword', $params ) ) ;

            if ( ! empty ( $result ))
            {
                $password = md5 ( sha1 ( md5 ( $params[ 'oldPassword' ] ) ) ) ;
                $salt1    = substr ( $result[ 'password' ], 0, 9 ) ;
                $salt2    = substr ( $result[ 'password' ], -(5) ) ;
                $password = $salt1 . $password . $salt2 ; //\f\pre($password.'*****'.$result[ 'password' ]);
                if ( $password == $result[ 'password' ] )
                {
                    $resultt = ( \f\ttt::dal ( 'member.editPassword', $params ) ) ;
                    if ( ! empty ( $resultt ) )
                    {
                        $data = array (
                            'result'  => 'success',
                            'message' => \f\ifm::t ( 'okChangePass' ),
                            'reset'   => TRUE ) ;
                    }
                    else
                    {
                        $data = array (
                            'result'  => 'error',
                            'message' => \f\ifm::t ( 'dbError' ) ) ;
                    }
                }
                else
                {
                    $data = array (
                        'result'  => 'error',
                        'message' => \f\ifm::t ( 'oldPassError' ) ) ;
                }
            }
            else
            {
                $data = array (
                    'result'  => 'error',
                    'message' => \f\ifm::t ( 'userNameError' ) ) ;
            }
        }
        else
        {
            $data = array (
                'result'  => 'error',
                'message' => \f\ifm::t ( 'newPassError' ) ) ;
        }
        return $data ;
    }

    public function registerActiveSave ()
    {
        $params = $this->request->getAssocParams () ;

        $checkActiveCode = \f\ttt::dal ( 'member.memberCheckActiveCode', $params ) ;
        if ( empty ( $checkActiveCode ) )
        {
            return array (
                'result'  => 'error',
                'message' => \f\ifm::t ( 'activeCodeNot' ) ) ;
        }

        $result = \f\ttt::dal ( 'member.memberListStatus', $checkActiveCode ) ;
        $msg    = \f\ifm::t ( 'activeCode' ) ;
        $reset  = TRUE ;

        if ( $result )
        {
            $data = array (
                'result'       => 'success',
                'message'      => $msg,
                'reset'        => $reset,
                'user_session' => $checkActiveCode ) ;
        }
        else
        {
            $data = array (
                'result'  => 'error',
                'message' => \f\ifm::t ( 'dbError' ) ) ;
        }

        return $data ;
    }

//    public function additionalInfoSave ()
//    {
//        $params = $this->request->getAssocParams () ;
//
//        $result = \f\ttt::dal ( 'member.memberListSaveEdit', $params ) ;
//        $msg    = \f\ifm::t ( 'additionalInfoSave' ) ;
//        $reset  = TRUE ;
//
//        if ( $result )
//        {
//            $data = array (
//                'result'  => 'success',
//                'message' => $msg,
//                    ) ;
//        }
//        else
//        {
//            $data = array (
//                'result'  => 'error',
//                'message' => \f\ifm::t ( 'dbError' ) ) ;
//        }
//
//        return $data ;
//    }



    public function getMembersByParam ()
    {
        return \f\ttt::dal ( 'member.getMembersByParam',
                             $this->request->getAssocParams () ) ;
    }

}
