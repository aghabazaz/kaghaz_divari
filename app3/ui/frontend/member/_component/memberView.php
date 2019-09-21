<?php

class memberView extends \f\view
{

    public function __construct ()
    {

    }

    public function renderProfile ( $id )
    {
        $row = \f\ttt::service( 'member.getMemberById',
            [
                'id' => $id ] );
        //\f\pr($row);
        return $this->render( 'profileEdit',
            [
                'row' => $row,
            ] );
    }

    public function renderGetMemberRegForm ()
    {
        return $this->render( 'memberRegister'
        );
    }

    public function renderGetAdditionalInfoForm ()
    {

        $getInfo = \f\ttt::service( 'member.getMemberById',
            [
                'id' => $_SESSION['user_id']
            ] );
        // \f\pre($getInfo);
        $birthday = explode( '/',$getInfo['birthday'] );
        $cardArr  = str_split( $getInfo['card'],4 );
        //$birthdayArr = str_split ( '/',$getInfo[ 'birthday' ] ) ;
        //$birthdayArr = preg_split("///", $getInfo[ 'birthday' ]);
        //\f\pre($birthdayArr);
        $state = \f\ttt::service( 'cms.place.state.getStateList' );
        return $this->render( 'additionalinfo',
            [
                'state'    => $state,
                'row'      => $getInfo,
                'card'     => $cardArr,
                'birthday' => $birthday,
            ]
        );
    }

    public function renderChangePassword ()
    {
        return $this->render( 'changePassword'
        );
    }

    public function renderDashboard ( $id )
    {
//        $count = \f\ttt::service ( 'message.messageUnreadCount',
//                                 array (
//                    'id' => $id ) ) ;
        //\f\pr($row);
        return $this->render( 'dashboard',
            [
                //'count' => $count,
            ] );
    }

    public function renderRegisterActiveForm ()
    {
        return $this->render( 'registerActive'
        );
    }

    public function getOrdersdetail ( $params )
    {
        $getOrdersdetail = \f\ttt::dal( 'shop.order.getNewOrderByParams',
            [
                'user_id'   => $params['user_id'],
                'notStatus' => 'cart',
                'id'        => $params['order_id'],
            ] );



        return $this->render( 'detailOrderModal',
            [
                'row'          => $getOrdersdetail,
            ] );
    }

    public function renderGetFavoriteProduct ( $params )
    {
        $user_id               = $params['user_id'];
        $getFavoritProduct     = \f\ttt::dal( 'shop.product.getFavoriteProductByUseId',[ 'user_id' => $user_id ] );
        $productsId            = array_column( $getFavoritProduct,'product_id' );
        $productSpecifications = \f\ttt::dal( 'shop.product.getFavoriteProductById',[ 'productsId' => $productsId ] );
        return $this->render( 'favoritSectionAccountPage',
            [
                'row' => $productSpecifications,
            ] );
    }

    public function renderGetAccountIndex ($params,$bank='',$price='')
    {

       // \f\pre($price);
        if ($bank == 'mellat') {
            $refId = $params['SaleReferenceId'];
            if ($params['ResCode'] == 17) {
                //\f\pr('cancel');
                $status = 'cancel';
                //after 2day must be delete records status  = unpayd
            } else {
                $result1 = \f\ttt::service('core.setting.bank.mellat.verifyMellat',
                    array(
                        'orderId' => $params['SaleOrderId'],
                        'refrenceId' => $refId
                    ));

                //\f\pre($result);
                //if succesufull
                if ($result1 == "0" or $result1=="415") {
                    $result = \f\ttt::service('core.setting.bank.mellat.settleMellat',
                        array(
                            'orderId' => $params['SaleOrderId'],
                            'refrenceId' => $refId
                        ));

                    //echo $result;
                    if($result1 == "0") {
                        \f\ttt::dal('shop.order.saveTransactionWallet',
                            array(
                                //'orderId' => $params['SaleOrderId'],
                                'refrenceId' => $refId,
                                'status'=>'wallet',
                                'type'=>'wallet',
                                'pricePay'=>$price
                            ));
                        $date1   = \f\ttt::dal( 'member.saveWallet',
                            [
                                'price'=>$price,
                                'user_id' => $_SESSION['user_id'],
                            ] );
                    }
                } else {
                    $status = 'errorPay';
                    $refId = $params['SaleReferenceId'];
                }
            }
        }
        $getInfo = \f\ttt::service( 'member.getMemberById',
            [
                'id' => $_SESSION['user_id']
            ] );

        $orders  = \f\ttt::service( 'shop.order.getOrderByParam',
            [
                'user_id'   => $_SESSION['user_id'],
                'notStatus' => 'cart',
            ] );
        /*
        if ( $bank == 'mellat' )
        {
            $refId = $params[ 'SaleReferenceId' ] ;

            if ( $params[ 'ResCode' ] == 17 )
            {
                //\f\pr('cancel');
                $status = 'cancel' ;
                //after 2day must be delete records status  = unpayd
            }
            else
            {
                $result = \f\ttt::service ( 'core.setting.bank.mellat.verifyMellat',
                    array (
                        'orderId'    => $params[ 'SaleOrderId' ],
                        'refrenceId' => $refId
                    ) ) ;

                //if succesufull
                if ( $result == "0" )
                {
                    $result = \f\ttt::service ( 'core.setting.bank.mellat.settleMellat',
                        array (
                            'orderId'    => $params[ 'SaleOrderId' ],
                            'refrenceId' => $refId
                        ) ) ;

                    //echo $result;
                    \f\ttt::service ( 'shop.order.saveTransaction',
                        array (
                            'orderId'    => $params[ 'SaleOrderId' ],
                            'refrenceId' => $refId
                        ) ) ;

                    $status = 'pay' ;
                }
                else
                {
                    $status = 'errorPay' ;
                    $refId  = $params[ 'SaleReferenceId' ] ;
                }
            }
        }
       */
        $date1   = \f\ttt::dal( 'shop.order.getOrderDateClearing',
            [
                'user_id' => $_SESSION['user_id'],
            ] );
        $cardArr = str_split( $getInfo['card'],4 );
        $card    = implode( "-",$cardArr );

        $sRow['title'] = 'پروفایل کاربر - ' . $_SESSION['name'];

        $params['user_id'] = $_SESSION['user_id'];
        $check_seller      = \f\ttt::dal( 'member.getSellerByUserId',$params );
        if ( $check_seller['id'] )
        {
            $upgradeRequestStatus = 'set';
        } else
        {
            $check_requset        = \f\ttt::dal( 'member.memberUpgrade.getRequestByUserId',$params );
            $upgradeRequestStatus = $check_requset['id'] ? 'suspended' : 'noSet';
        }
        $content = $this->render( 'account',
            [
                'row'            => $getInfo,
                'sRow'           => $sRow,
                'card'           => $card,
                'orders'         => $orders,
                'upgradeRequest' => $upgradeRequestStatus,
                'dateCredit'     => $date1['date_pay']
            ] );

        return [
            $content,
            $sRow ];
    }

    public function renderGetFormPasswordChange ()
    {
        $sRow['title'] = 'تغییر کلمه عبور';
        $content       = $this->render( 'passwordChange',
            [
            ] );

        return [
            $content,
            $sRow ];
    }

    public function renderGetLoginForm ()
    {
        $sRow['title'] = 'ورود کاربران';
        $content       = $this->render( 'memberLogin',
            [
            ] );

        return [
            $content,
            $sRow ];
    }

    public function renderGetForgetPassForm ()
    {

        $sRow['title'] = ' فراموشی رمز عبور ';
        $content       = $this->render( 'forgetPassForm',
            [
            ] );

        return [
            $content,
            $sRow ];
    }

    public function renderGetConfirmationForm ()
    {
        //\f\pre($_SESSION);
        return $this->render( 'confirmationForm'
        );
    }

    public function renderGetFactorDetail ( $param )
    {
        $getOrdersdetail = \f\ttt::service( 'shop.order.getOrderByParam',
            [
                'user_id'   => $_SESSION['user_id'],
                'notStatus' => 'cart',
                'id'        => $param['factorId'][0]
            ] );
        return $this->render( 'factorDetail',[ 'orderDetail' => $getOrdersdetail ]
        );
    }

    public function renderGetCompleteInfoForm ()
    {
        return $this->render( 'completeInfoForm'
        );
    }
}
