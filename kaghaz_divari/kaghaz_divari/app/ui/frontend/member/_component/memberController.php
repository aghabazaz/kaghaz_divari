<?php

class memberController extends \f\controller
{

    /**
     *
     * @var discountView
     */
    private $view;

    public function __construct ( $params )
    {
        require_once 'memberView.php';
        $this->view = new memberView;
        parent::__construct( $params );
    }

    public function reCharge(){

        $params = $this->request->getAssocParams();

        $bank              = $params['bank'];
        $price=$params['walletIncreaseValue'];

        if(empty($price)){
          //  \f\pre('hi');
            return $this->response( [
                'result'  => 'error',
                'message' => 'لطفا مبلغ مورد نظر خود را وارد نمایید.'
            ] );
        }
        $result = \f\ttt::service( 'core.setting.bank.mellat.mellatPay',
            [
                'price'       => $price,
                'callbackUrl' => \f\ifm::app()->siteUrl . 'account/mellat/'.$price ,
                'save'        => [
                    'shop_orders',
                    [
                        //'order_id'      => $params[ 'id' ],
                        //'user_id'       => $_SESSION[ 'user_id' ],
                        'date_pay'  => time(),
                        'status'    => 'wallet',
                        'type' => 'wallet',
                    ],
                    [
                        'id=?',
                        [
                            $params['id'] ],
                    ]
                ]
            ] );
        if($result['result']=='success'){

        }
        return $this->response( [
            'result'  => $result,
            'status'  => $result['status'],
            'message' => $result['message']
        ] );
    }
    public function getMemberRegForm ()
    {
        $params  = $this->request->getAssocParams();
        $content = $this->view->renderGetMemberRegForm( $params );
        $array = [
            'content'     => $content,
            'websiteInfo' => $params['websiteInfo'],
            'title'       => ' ورود شماره همراه ',
        ];
        return $this->render( $array );
    }

    public function getAdditionalInfoForm ()
    {


        $params  = $this->request->getAssocParams();
        $content = $this->view->renderGetAdditionalInfoForm( $params );

        $array = [
            'content'     => $content,
            'websiteInfo' => $params['websiteInfo'],
            'title'       => 'تکمیل اطلاعات کاربری',
        ];

        return $this->render( $array );
    }

    public function convert2english ( $string )
    {
        $newNumbers = range( 0,9 );
        // 1. Persian HTML decimal
        $persianDecimal = [ '&#1776;','&#1777;','&#1778;','&#1779;','&#1780;','&#1781;','&#1782;','&#1783;','&#1784;','&#1785;' ];
        // 2. Arabic HTML decimal
        $arabicDecimal = [ '&#1632;','&#1633;','&#1634;','&#1635;','&#1636;','&#1637;','&#1638;','&#1639;','&#1640;','&#1641;' ];
        // 3. Arabic Numeric
        $arabic = [ '٠','١','٢','٣','٤','٥','٦','٧','٨','٩' ];
        // 4. Persian Numeric
        $persian = [ '۰','۱','۲','۳','۴','۵','۶','۷','۸','۹' ];

        $string = str_replace( $persianDecimal,$newNumbers,$string );
        $string = str_replace( $arabicDecimal,$newNumbers,$string );
        $string = str_replace( $arabic,$newNumbers,$string );
        return str_replace( $persian,$newNumbers,$string );
    }

    public function sendActiveCode ( $data )
    {
        $msg    = "  کد فعال سازی حساب کاربری شما در سیک مارکت: " . $data['activeCode'];
        $result = \f\ttt::service( 'core.setting.sms.sendSingleSms',
            [
                'receiver' => $this->convert2english( $data['mobileNumber'] ),
                'txt'      => $msg
            ] );
        return $result;
    }

    public function sendNewPass ( $data )
    {
       // \f\pre($data);
        $msg    = $data['name'] . " عزیز کلمه عبور شما در سیک مارکت به  :   " . $data['newPass'] . "  تغییر یافت ";
        $result = \f\ttt::service( 'core.setting.sms.sendSingleSms',
            [
                'receiver' => $this->convert2english( $data['mobileNumber'] ),
                'txt'      => $msg
            ] );
        return $result;
    }

    public function sendReturnProductMassage ( $data )
    {

        $msg    = "گزارش مرجوعی کالا \r\n" .
            "   شماره فاکتور  : " . $data['orderId'] . "\r\n" .
            "   تعداد مرجوعی  : " . $data['returnNumber'];
        $result = \f\ttt::service( 'core.setting.sms.sendSingleSms',
            [
                'receiver' => $this->convert2english( $data['mobileNumber'] ),
                'txt'      => $msg
            ] );
        return $result;
    }

    public function memberSave ()
    {
        $params     = $this->request->getAssocParams();
        if ( $params['agreementCheck']!='on' or !isset($params['agreementCheck']))
        {
            return $this->response( [
                'result'  => 'error',
                'message' => \f\ifm::t( 'agreementCheckNot' ) ] );
        }
        $validPhone = $this->is_valid_phone( $params['mobile'] );
        if ( !$params['mobile'] or !$params['password'] or !$params['repeatPassword'])
        {
            return $this->response( [
                'result'  => 'error',
                'message' => \f\ifm::t( 'requiredField' ) ] );
        }
        if ( $validPhone == 'false' )
        {
            return $this->response( [
                'result'  => 'error',
                'message' => \f\ifm::t( 'mobileNotValid' ) ] );
        }
        if ( $params['password']!=$params['repeatPassword'] )
        {
            return $this->response( [
                'result'  => 'error',
                'message' => \f\ifm::t( 'noMatchPassword' ) ] );
        }
        $params['code']     = rand( 10,1000000 );
        $check_rep_cell_num = \f\ttt::dal( 'member.checkMobileNumber',$params );
        if ( $check_rep_cell_num['status_reg'] == 'complete' )
        {
            return $this->response( [
                'result'  => 'error',
                'message' => \f\ifm::t( 'userIsRepetition' ) ] );
        } else
        {
            if ( !empty( $check_rep_cell_num ) )
            {
                $params['type'] = 'update';
                \f\ttt::dal( 'member.memberMobileSave',$params );
                $check_res = [
                    'result'  => 'success',
                    'message' => \f\ifm::t( 'sendConfirmationCodeSuccess' ) ];
            } else
            {
                $params['type'] = 'insert';
                \f\ttt::dal( 'member.memberMobileSave',$params );
                $check_res = [
                    'result'  => 'success',
                    'message' => \f\ifm::t( 'sendConfirmationCodeSuccess' ) ];
            }
        }

        if ( $check_res['result'] == 'success' )
        {
            $_SESSION['mobile'] = $params['mobile'];
            $mobileNum          = [ 'mobileNumber' => $params['mobile'],'activeCode' => $params['code'] ];
            $resultSendSMS      = $this->sendActiveCode( $mobileNum );
            if ( $resultSendSMS > 0 )
            {
                $check_res['url'] = \f\ifm::app()->siteUrl . 'confirmationForm/';
            }
        } else
        {
            return $this->response( [
                'result'  => 'error',
                'message' => \f\ifm::t( 'mobileNotValid' ) ] );
        }
        return $this->response( $check_res );
    }

    public function retrievePass ()
    {
        $params = $this->request->getAssocParams();
        //\f\pre($params);
        if ( !$params['username'] )
        {
            return $this->response( [
                'result'  => 'error',
                'message' => \f\ifm::t( 'entredUsername' ) ] );
        }
        $mobileUser = \f\ttt::dal( 'member.getUserInfoByUsername',$params );
        //\f\pre($mobileUser);
        if ( !$mobileUser )
        {
            return $this->response( [
                'result'  => 'error',
                'message' => \f\ifm::t( 'notFoundUser' ) ] );
        } else
        {
            $params['code']         = rand( 10,1000000 );
            $mobileNum              = [ 'mobileNumber' => $mobileUser['mobile'],'name' => $mobileUser['name'],'newPass' => $params['code'] ];
            $params ['newPassword'] = $params['code'];
            $params['user_id']      = $mobileUser['id'];
            $result                 = ( \f\ttt::dal( 'member.editPassword',$params ) );
            $resultSendSMS          = $this->sendNewPass( $mobileNum );
            if ( !empty ( $result ) )
            {
                $check_res['url'] = \f\ifm::app()->siteUrl . 'login/';
                return $this->response( [
                    'result'  => 'success',
                    'message' => \f\ifm::t( 'sendPassToMobile' ),
                    'url'     => $check_res['url'] ] );
            } else
            {
                return $this->response( [
                    'result'  => 'error',
                    'message' => \f\ifm::t( 'dbError' ) ] );
            }
        }
    }

    public function sendConfirmationCode ()
    {
        $params         = $this->request->getAssocParams();
        $params['type'] = 'update';
        $params['code'] = rand( 10,1000000 );
        \f\ttt::dal( 'member.memberMobileSave',$params );
        $mobileNum = [ 'mobileNumber' => $params['mobile'],'activeCode' => $params['code'] ];
        $resultSMS = $this->sendActiveCode( $mobileNum );
        if ( $resultSMS > 0 )
        {
            $returnSMS = [
                'result' => 'success',
                'msg'    => 'کد تایید با موفقیت ارسال شد.'
            ];
        } else
        {
            $returnSMS = [
                'result' => 'success',
                'msg'    => 'کد تایید با موفقیت ارسال شد.'
            ];
        }
        return $returnSMS;
    }

    public function getCompleteInfoForm ()
    {
        $params  = $this->request->getAssocParams();
        $content = $this->view->renderGetCompleteInfoForm( $params );

        $array = [
            'content'     => $content,
            'websiteInfo' => $params['websiteInfo'],
            'title'       => ' تکمیل ثبت نام ',
        ];

        return $this->render( $array );
    }

    public function saveCompleteInfo ()
    {
        $params = $this->request->getAssocParams();
        if ( !$params['name'] || !$params['password'] || !$params['username'] )
        {
            return $this->response( [
                'result'  => 'error',
                'message' => 'پر کردن تمامی فیلدهای ستاره دار در این مرحله اجباری است' ] );

        }
        $saveCompleteInfo = \f\ttt::dal( 'member.saveCompleteInfo',$params );
        return $this->response( $saveCompleteInfo );

        /* if($check_confirmation_code['active_code']==$params['confirmationCode']){
             $check_res=array (
                 'result'  => 'success',
                 'message' => \f\ifm::t ( 'confirmationCodeSuccess' ) );
             $check_res['url'] = \f\ifm::app()->siteUrl . 'additionalinfo/';
         }else{
             $check_res=array (
                 'result'  => 'error',
                 'message' => \f\ifm::t ( 'confirmationCodeError' ) );
             // $check_res['url'] = \f\ifm::app()->siteUrl . 'confirmationForm/';
         }*/

        //  return $this->response($check_res);
    }

    public function getConfirmationForm ()
    {
        $params  = $this->request->getAssocParams();
        $content = $this->view->renderGetConfirmationForm( $params );

        $array = [
            'content'     => $content,
            'websiteInfo' => $params['websiteInfo'],
            'title'       => ' تایید کد ',
        ];

        return $this->render( $array );
    }

    public function getFactorDetail ()
    {
        $params             = $this->request->getAssocParams();
        $params['factorId'] = $this->request->getNonAssocParams();
        $content            = $this->view->renderGetFactorDetail( $params );
        $array              = [
            'content'     => $content,
            'websiteInfo' => $params['websiteInfo'],
            'title'       => ' جزئیات فاکتور ',
        ];

        return $this->render( $array );
    }

    public function confirmationOperate ()
    {
        $params                  = $this->request->getAssocParams();
        $check_confirmation_code = \f\ttt::dal( 'member.checkMobileNumberForConfCode',[ 'mobile' => $_SESSION['mobile'] ] );

        if ( $check_confirmation_code['active_code'] == $params['confirmationCode'] )
        {
            \f\ttt::dal( 'member.saveAsCompleteMember',array());
            $check_res        = [
                'result'  => 'success',
                'message' => \f\ifm::t( 'confirmationCodeSuccess' ) ];

            $check_res['url'] = \f\ifm::app()->siteUrl . 'account/';
        } else
        {
            $check_res = [
                'result'  => 'error',
                'message' => \f\ifm::t( 'confirmationCodeError' ) ];
        }
        return $this->response( $check_res );
    }

    function is_valid_phone ( $phone )
    {
        if ( preg_match( "/^09[0-9]{9}$/",$phone ) )
        {
            return "true";
        } else
        {
            return "false";
        }
    } // end function is_valid_phone

    public function getAccountPanel ()
    {
        $params        = $this->request->getAssocParams();
        $nonAssocParam = $this->request->getNonAssocParams();

        $pr     = $this->request->getNonAssocParams();
        $menu         = $nonAssocParam[0];
        $params['id'] = $_SESSION['user_id'];
        if ( !isset ( $_SESSION['user_id'] ) )
        {
            header( 'Location:' . \f\ifm::app()->siteUrl . 'login/' );
        }
        if ( !isset ( $_SESSION['picture'] ) )
        {
            $_SESSION['picture'] = 801;
        }
        $method = $nonAssocParam[1];
        if ( !$method )
        {
            $method = 'index';
        }
        if ( !$menu )
        {
            $content = $this->view->renderDashboard( $params['id'] );
        } else if ( $menu == 'profile' )
        {
            $content = $this->view->renderProfile( $params['id'] );
        } else if ( $menu == 'password' )
        {
            $content = $this->view->renderChangePassword();
        } else
        {
            if ( $menu == 'advert' )
            {
                $content = \f\ttt::block( 'shop.advert.' . $method,
                    $nonAssocParam
                );
            } else if ( $menu == 'product' )
            {
                $content = \f\ttt::block( 'shop.product.' . $method,
                    $nonAssocParam
                );
            } else
            {
                $content = \f\ttt::block( $menu . '.' . $method,$nonAssocParam
                );
            }
        }

        $array = [
            'content'     => $content,
            'websiteInfo' => $params['websiteInfo'],
            'title'       => 'پنل کاربری',
        ];

        return $this->render( $array );
    }

    public function logout ()
    {

        //setcookie ( "userName", '', strtotime ( '-3 days' ), "/" ) ;
        unset ( $_SESSION['user_id'] );
        unset ( $_SESSION['email'] );
        unset ( $_SESSION['order_count'] );
        unset ( $_SESSION['like_count'] );
        //session_destroy () ;
        header( 'Location:' . \f\ifm::app()->siteUrl . 'login' );
    }

    public function account ()
    {
        header( 'Location:' . \f\ifm::app()->siteUrl . 'account' );
    }

    public function getLoginForm ()
    {
        $params = $this->request->getAssocParams();
        $array  = $this->view->renderGetLoginForm( $params );
        return $this->render( [
            'content'     => $array[0],
            'websiteInfo' => $params['websiteInfo'],
            'title'       => $array[1]['title'],
        ] );
    }

    public function forgetPassForm ()
    {
        //\f\pre('sdf');
        $params = $this->request->getAssocParams();
        $array  = $this->view->renderGetForgetPassForm( $params );
        return $this->render( [
            'content'     => $array[0],
            'websiteInfo' => $params['websiteInfo'],
            'title'       => $array[1]['title'],
        ] );
    }

    public function checkLogin ()
    {
        $params = $this->request->getAssocParams();

        $check_res = \f\ttt::service( 'member.checkLogin',$params );
        if ( $check_res['result'] == 'success' )
        {
            $check_res['url'] = \f\ifm::app()->siteUrl . 'account';
        }

        return $this->response( $check_res );
    }

    public function memberEdit ()
    {
        $params            = $this->request->getAssocParams();
        $params['user_id'] = $_SESSION['user_id'];
        $check_res         = \f\ttt::service( 'member.memberListSave',
            $params );
        if ( $check_res['result'] == 'success' )
        {
            $this->auth( [
                'email'   => $params['email'],
                'name'    => $params['name'],
                'user_id' => $params['user_id'],
                'picture' => $params['picture'],
                'status'  => 'enabled',
            ] );
        }
        return $this->response( $check_res );
    }

    public function auth ( $param )
    {
        //session_start () ;
        $_SESSION = $param;
    }

    public function changePassword ()
    {
        $params = $this->request->getAssocParams();
        //\f\pre($_SESSION);
        $params['user_id'] = $_SESSION['user_id'];
        //\f\pre($params);
        return $this->response( \f\ttt::service( 'member.changePassword',
            $params ) );
    }

    public function getRegisterActiveForm ()
    {
        $params  = $this->request->getAssocParams();
        $content = $this->view->renderRegisterActiveForm( $params );

        $array = [
            'content'     => $content,
            'websiteInfo' => $params['websiteInfo'],
            'title'       => 'تایید ثبت نام',
        ];
        return $this->render( $array );
    }

    public function registerActiveSave ()
    {
        $params = $this->request->getAssocParams();

        $check_res = \f\ttt::service( 'member.registerActiveSave',$params );
        if ( $check_res['result'] == 'success' )
        {
            $this->auth( [
                'user_id' => $check_res['user_session']['id'],
                'email'   => $check_res['user_session']['email'],
                'name'    => $check_res['user_session']['name'],
                'status'  => 'enabled',
            ] );
//            \f\ttt::service ( 'core.fileManager.createFolder',
//                              array (
//                'path'  => 'member.profile',
//                'name'  => $check_res[ 'user_id' ],
//                'title' => $params[ 'name' ],
//            ) ) ;
            $check_res['url'] = \f\ifm::app()->siteUrl . 'additionalinfo/';
        }
        return $this->response( $check_res );
    }

    public function getBeforeReturnProduct ()
    {
        $params               = $this->request->getAssocParams();
        $check_return_product = \f\ttt::dal( 'shop.order.checkReturnRequest',$params );
        $coutn                = $check_return_product['SUM(return_count)'];
        return $this->response( [ 'count' => $coutn ] );
    }

    public function getCopyOrderDetail ()
    {
        $params = $this->request->getAssocParams();
        return $this->response( [ 'content' => $this->view->getOrdersdetail( $params ) ] );
    }

    public function returnProductSave ()
    {
        $params               = $this->request->getAssocParams();
        $check_return_product = \f\ttt::dal( 'shop.order.checkReturnRequest',$params );
        if ( $check_return_product )
        {
            $max_return = $params['allowed_return_product_count'] - $check_return_product['SUM(return_count)'];
        } else
        {
            $max_return = $params['allowed_return_product_count'];
        }
        if ( $max_return <= 0 )
        {
            return $this->response( [
                'result'  => 'error',
                'message' => \f\ifm::t( 'before_order_returned' ) ] );

        } elseif ( $params['return_number'] > 0 and $params['return_number'] <= $max_return ){
            $saveReturn = \f\ttt::dal( 'shop.order.returnOrderSave',$params );
            if ( $saveReturn )
            {
                $shopSetting = \f\ttt::service( 'shop.shopSetting.getSettings' );
                $getInfo     = \f\ttt::service( 'member.getMemberById',
                    [
                        'id' => $_SESSION['user_id']
                    ] );
                for ( $i = 0; $i <= count( $shopSetting['mobileNumber'] ); $i++ )
                {
                    $mobileNum = [
                        'mobileNumber' => $shopSetting['mobileNumber'][$i],
                        'orderId'      => $params['order_id'] + 100000,
                        'returnNumber' => $params['return_number'],
                    ];
                    $resultSMS = $this->sendReturnProductMassage( $mobileNum );
                }
                return $this->response( [
                    'result'  => 'success',
                    'message' => \f\ifm::t( 'order_return_set' ) ] );
            } else
            {
                return $this->response( [
                    'result'  => 'error',
                    'message' => \f\ifm::t( 'order_return_noSet' ) ] );
            }
        } else
        {
            return $this->response( [
                'result'  => 'error',
                'message' => ( 'تنها برای تعداد' . \f\ifm::faDigit( $max_return ) . ' عدداز این محصول امکان مرجوع شدن وجود دارد  .  ' ) ] );
        }
    }

    public function buyAgainFactor ()
    {
        $params = $this->request->getAssocParams();
        $this->registerGadgets( [
            'dateG' => 'date' ] );
        for ( $i = 0; $i <= count( $params['productId'] ); $i++ )
        {
            $param['today']      = $this->dateG->today();
            $param['user_id']    = $_SESSION['user_id'];
            $param['priceId']    = $params['priceId'][$i];
            $param['product_id'] = $params['productId'][$i];
            $result              = \f\ttt::service( 'shop.order.orderSave',$param );
        }
        if ( $result )
        {

            $check_res['url'] = \f\ifm::app()->siteUrl . 'cart/';
            return $this->response( $check_res );


        } else
        {
            return $this->response( [
                'result'  => 'error',
                'message' => \f\ifm::t( 'orderNotRepaet' ) ] );
        }
    }

    public function getFavoriteProduct ()
    {
        $params = $this->request->getAssocParams();
        return $this->response( [ 'content' => $this->view->renderGetFavoriteProduct( $params ) ] );
    }

    public function deletFaveProduct ()
    {
        $params = $this->request->getAssocParams();
        $result = \f\ttt::dal( 'shop.product.deleteFaveProduct',$params );
        return $this->response( [ 'count' => $result ] );
    }


    public function additionalInfoSave ()
    {
        $params = $this->request->getAssocParams();
        //\f\pre($params);
        if ( !$params['name'] || !$params['phone'] || !$params['mobile'] || !$params['address'] )
        {
            return $this->response( [
                'result'  => 'error',
                'message' => \f\ifm::t( 'starInfoSet' ) ] );
        }
        $params['addInfo'] = 'True';
        $check_res         = \f\ttt::service( 'member.memberListSave',$params );
        //\f\pre($params['oldPageBack']);
        if ( $check_res['result'] == 'success' )
        {
            if ( $params['oldPageBack'] )
            {
                $check_res['url'] =  $params['oldPageBack'];
            } else
            {
                $check_res['url'] =  $params['oldPageBack'];
            }

        }
        return $this->response( $check_res );
    }

    public function UpgradeUserSave ()
    {
        $params = $this->request->getAssocParams();

        if ( !$params['shop_name'] || !$params['address'] )
        {
            return $this->response( [
                'result'  => 'error',
                'message' => \f\ifm::t( 'allInfoSet' ) ] );
        }
        $check_requset = \f\ttt::dal( 'member.memberUpgrade.getRequestByUserId',$params );
        if ( $check_requset['id'] )
        {
            return $this->response( [
                'result'  => 'error',
                'message' => \f\ifm::t( 'notSaveRequset' ) ] );
        } else
        {
            $requsetSave = \f\ttt::dal( 'member.memberUpgrade.memberUpgradeRequestSave',$params );
            if ( $requsetSave )
            {
                return $this->response( [
                    'result'  => 'success',
                    'message' => \f\ifm::t( 'SaveRequsetSuccess' ) ] );
            }
        }

    }


    public function getListCity ()
    {
        $param   = $this->request->getAssocParams();
        $group   = \f\ttt::service( 'cms.place.city.getCityList',
            [
                'id'     => $param['state_id'],
                'status' => 'enabled' ] );
        $content = '<option></option>';
        foreach ( $group AS $data )
        {
            $content .= '<option value="' . $data['id'] . '">' . $data['title'] . '</option>';
        }

        return $this->response( [
            'content' => $content ] );
    }

    public function accountIndex ()
    {
        $params = $this->request->getAssocParams();
        $param = $this->request->getNonAssocParams();
        $bank=$param[0];
        $price=$param[1];

        //\f\pre($param);
        $array = $this->view->renderGetAccountIndex( $params,$bank,$price );
        return $this->render( [
            'content'     => $array[0],
            'websiteInfo' => $params['websiteInfo'],
            'title'       => $array[1]['title'],
        ] );
    }

    public function getFormPasswordChange ()
    {
        $params = $this->request->getAssocParams();
        $array = $this->view->renderGetFormPasswordChange( $params );
        return $this->render( [
            'content'     => $array[0],
            'websiteInfo' => $params['websiteInfo'],
            'title'       => $array[1]['title'],
        ] );
    }

}
