<?php

/** page is optional * */
$urlAliases = array (
    'contactUs'        => array (
        'target' => 'cms/getContact',
        'page'   => 'pageContent'
    ),
    'about'          => array (
        'target' => 'cms/getAbout',
        'page'   => 'pageContent'
    ),
    'menuDetail'     => array (
        'target' => 'cms/menu/getMenuDetail',
        'page'   => 'pageContent'
    ),
    'content'        => array (
        'target' => 'cms/contentList',
        'page'   => 'pageContent'
    ),
    'contentDetail'  => array (
        'target' => 'cms/getContentDetail',
        'page'   => 'pageContent'
    ),
    'productDetail'  => array (
        'target' => 'shop/product/getProductDetail',
        'page'   => 'pageContentDetailsProduct'
    ),
    'rate'  => array (
        'target' => 'shop/product/rateForm',
        'page'   => 'pageContent'
    ),
    'product'        => array (
        'target' => 'shop/product/productIndex',
        'page'   => 'pageContentProduct'
    ),
    'productOld'        => array (
        'target' => 'shop/product/productIndexOld',
        'page'   => 'pageContent'
    ),
    'tag'            => array (
        'target' => 'cms/tagList',
        'page'   => 'pageContent'
    ),
    'newsDetail'     => array (
        'target' => 'cms/news/getNewsDetail',
        'page'   => 'pageContent'
    ),
    'news'           => array (
        'target' => 'cms/news/newsListDetail',
        'page'   => 'pageContent'
    ),
    'register'       => array (
        'target' => 'member/getMemberRegForm',
        'page'   => 'pageContent'
    ),
    'registerActive' => array (
        'target' => 'member/getRegisterActiveForm',
        'page'   => 'pageContent'
    ),
    'additionalinfo' => array (
        'target' => 'member/getAdditionalInfoForm',
        'page'   => 'pageContent'
    ),
'completeInfo'=>array (
    'target' => 'member/getCompleteInfoForm',
    'page'   => 'pageContent'
),
//    'account'        => array (
//        'target' => 'member/getAccountPanel',
//        'page'   => 'accountPanel'
//    ),
    'login'          => array (
        'target' => 'member/getLoginForm',
        'page'   => 'pageContent'
    ),
    'forgetPass'          => array (
        'target' => 'member/forgetPassForm',
        'page'   => 'pageContent'
    ),
//    'compare'        => array (
//        'target' => 'shop/product/getProductCompare',
//        'page'   => 'pageContent'
//    ),
    'cart'           => array (
        'target' => 'shop/order/cartList',
        'page'   => 'pageContent'
    ),
    'shipping'       => array (
        'target' => 'shop/order/shippingList',
        'page'   => 'pageContent'
    ),
    'review'         => array (
        'target' => 'shop/order/reviewList',
        'page'   => 'pageContent'
    ),
    'payment'        => array (
        'target' => 'shop/order/paymentList',
        'page'   => 'pageContent'
    ),
    'checkout'       => array (
        'target' => 'shop/order/checkoutList',
        'page'   => 'pageContent'
    ),
    'account'        => array (
        'target' => 'member/accountIndex',
        'page'   => 'pageContent'
    ),
    'passwordChange' => array (
        'target' => 'member/getFormPasswordChange',
        'page'   => 'pageContent'
    ),
    'confirmationForm'       => array (
        'target' => 'member/getConfirmationForm',
        'page'   => 'pageContent'
    ),
    'factorDetail'       => array (
        'target' => 'member/getFactorDetail',
        'page'   => 'pageContent'
    ),
    'galleryPictures'=>array(
        'target'=>'cms/picture/getPictureList',
        'page'=>'pageContent'
    ),
    'customRequest'=>array(
        'target'=>'shop/product/customRequest',
        'page'=>'pageContent'
    ),

) ;
