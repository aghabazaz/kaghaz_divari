<?php
//\f\pre($_SESSION['order_count']);
if ( $menu != '404' )
{
   // \f\ttt::service( 'core.visit.setVisit',[],true );
}
$social = \f\ttt::service ( 'cms.socialnet.getSocialnetSetting') ;
?>
<!DOCTYPE html>
<html lang="fa-IR">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title><?= $title ?></title>
    <meta name="description" content="<?= $description ?>"/>
    <meta name="keywords" content="<?= $keywords ?>"/>
    <meta name="twitter:image:src" itemprop="image" property="og:image" content="<?= $pictureUrl ?>"/>
    <meta name="msapplication-TileImage" content="<?= \f\ifm::app()->fileBaseUrl . $websiteInfo['favicon'] ?>"/>
    <meta name="theme-color" content="#C8135E">

    <link rel="icon" href="<?= \f\ifm::app()->fileBaseUrl . $websiteInfo['favicon'] ?>" sizes="192x192"/>
    <link rel="apple-touch-icon-precomposed" href="<?= \f\ifm::app()->fileBaseUrl . $websiteInfo['favicon'] ?>"/>
    <!-- styles -->
    <!--pro details-->
    <?php
    if($dynamicPro=='true') {
        ?>
       <link rel="stylesheet" type="text/css"
              href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/proDetDynamic/jquery-ui.min.css"/>
        <link rel="stylesheet" type="text/css"
              href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/proDetDynamic/bootstrap.rtl.min.css"/>
        <link rel="stylesheet" type="text/css"
              href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/proDetDynamic/jquery.fancybox.css"    media="all"/>
        <link rel="stylesheet" type="text/css"
              href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/proDetDynamic/rtl.css"  media="all"/>
        <link rel="stylesheet" type="text/css"
              href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/proDetDynamic/cropper.css"       media="all"/>
        <link rel="stylesheet" type="text/css"
              href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/proDetDynamic/skin.css"      media="all"/>
        <link rel="stylesheet" type="text/css"
              href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/proDetDynamic/print.css"    media="print"/>
        <?php
    }
    ?>

    <?php
   if($dynamicPro!='true') {
        ?>
        <link rel="stylesheet" type="text/css"
              href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/animate.css">
        <link rel="stylesheet" type="text/css"
              href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/chosen.css">
        <link rel="stylesheet" type="text/css"
               href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/pe-icon-7-stroke.css">
        <?php
    }
    ?>
    <link rel="stylesheet" type="text/css"  href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css"  href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/font-awesome.css">
    <link rel="stylesheet" type="text/css"  href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/style.min.css">
    <link rel="stylesheet" type="text/css"  href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/owl.carousel.css">
    <script type="text/javascript"  src="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/js/jquery.min.js"></script>

    <?php
    if($dynamicPro=='true') {
        ?>
        <script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/proDetDynamic/prototype.js"></script>
        <script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/proDetDynamic/et_currencymanager_round.js"></script>
        <script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/proDetDynamic/jquery.fancybox.js"></script>
        <script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/proDetDynamic/jquery.mousewheel-3.0.6.pack.js"></script>
        <script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/proDetDynamic/enscroll-0.6.1.min.js"></script>
        <script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/proDetDynamic/product_options.js"></script>
        <script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/proDetDynamic/cropper.js"></script>
        <script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/proDetDynamic/jquery.webui-popover.js"></script>
        <script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/proDetDynamic/crop.js"></script>

        <?php
    }
    ?>
    <script type="text/javascript">
        var optionsPrice = new Product.OptionsPrice({"priceFormat":{"pattern":"%s تومان ","precision":1,"requiredPrecision":1,"decimalSymbol":",","groupSymbol":",","groupLength":3,"integerRequired":1},"includeTax":"true","showIncludeTax":true,"showBothPrices":false,"idSuffix":"_clone","oldPlusDisposition":0,"plusDisposition":0,"plusDispositionTax":0,"oldMinusDisposition":0,"minusDisposition":0,"productId":"31766","productPrice":60000,"productOldPrice":60000,"priceInclTax":60000,"priceExclTax":60000,"skipCalculate":1,"defaultTax":9,"currentTax":9,"tierPrices":[],"tierPricesInclTax":[],"swatchPrices":null});
    </script>
    <input id="siteUrl" value="<?= \f\ifm::app()->siteUrl ?>" type="hidden">


    <?php
    if($dynamicPro!='true') {

    if ($dynamicPro != 'true') {
        ?>
        <script type='text/javascript'
                src='<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/base/js/default.min.js'></script>
    <?php
    }
    ?>
        <script>
            document.cookie = "width=" + $(window).width();
            document.cookie = "height=" + $(window).height();
        </script>

        <!-- Global site tag (gtag.js) - Google Analytics -->
       <!-- <script async src="https://www.googletagmanager.com/gtag/js?id=UA-127841002-1"></script>-->
        <script>
            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }

            gtag('js', new Date());

            gtag('config', 'UA-127841002-1');
            $(document).ready(function () {
                alert('dsf');
                $('.menu-on-mobile.hidden-mobile').click(function () {
                    var hasActive = $(this).hasClass('active');
                    if (hasActive) {
                        $(this).removeClass('active');
                        $('.header-nav.smarket-nav').removeClass('has-open');
                    } else {
                        $(this).addClass('active');
                        $('.header-nav.smarket-nav').addClass('has-open');
                    }
                });
            });
        </script>
        <?php
    }
    ?>

</head>

<body class="index-opt-2">
<div class="wrapper">
    <header class="site-header header-opt-1">
        <div class="header-top">
            <div class="container">
                <ul class="header-top-left smarket-nav">
                    <li><a href="" title="شماره تماس"><i class="fa fa-phone" aria-hidden="true"></i> <?= \f\ifm::faDigit( $social['phone'])?> </a></li>
                    <li><a href="" title="پست الکترونیک"><i class="fa fa-envelope" aria-hidden="true"></i> <?= $social['email']?> </a></li>
                </ul>
                <ul class="header-top-right">
                    <li><a href="<?= \f\ifm::app()->siteUrl . 'account/' ?>" title="پیگیری سفارش"><i class="fa fa-car" aria-hidden="true"></i>پیگیری سفارش</a></li>
                    <li><a href="<?= \f\ifm::app()->siteUrl . 'contactUs/' ?>" title="مکان فروشگاه"><i class="fa fa-map-marker" aria-hidden="true"></i>مکان فروشگاه</a></li>
                    <?php
                    if(!empty($_SESSION['user_id'])){
                        ?>
                        <li><a href="<?= \f\ifm::app()->siteUrl . 'member/logout/' ?>" title="خروج"><i class="fa fa-user" aria-hidden="true"></i>خروج  </a>
                            <span class="or-two"> یا </span>
                            <a href="<?= \f\ifm::app()->siteUrl . 'member/account/' ?>" title="پروفایل">پروفایل</a>
                        </li>
                        <?php
                    }else{
                        ?>
                        <li><a href="<?= \f\ifm::app()->siteUrl . 'login/' ?>" title="ورود کاربر"><i class="fa fa-user" aria-hidden="true"></i>ورود  </a><span class="or-two"> یا </span><a href="<?= \f\ifm::app()->siteUrl . 'register/' ?>"> ثبت نام</a></li>
                    <?php }
                    ?>
                </ul>
            </div>
        </div>
        <div class="header-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-2 col-md-3">
                        <div class="logo-header">
                            <a href="<?= \f\ifm::app ()->siteUrl ?>"><img src="<?= $pictureUrl ?>" alt="logo"></a>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-6 ">
                        <div class="block-search">
                            <form method="get" action="#" class="form-search">
                                <div class="form-content">
                                    <div class="search-input">
                                        <input type="hidden" value="0" name="key" id="key">
                                        <input type="hidden" value="0" name="selectDiv" id="selectDiv">
                                        <input type="text" class="ui-autocomplete-input input" name="searchtxt" id="searchtxt" value="" placeholder="محصول، دسته یا برند مورد نظرتان را جستجو کنید ..." onkeyup="search_keyword('<?= \f\ifm::app ()->siteUrl ?>')" onclick="search_keyword('<?= \f\ifm::app ()->siteUrl ?>')" autocomplete="off">
                                    </div>
                                    <button class="btn-search" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                                    <div id="result_search" class="result_search"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-3 text-align-right">
                        <a href="" class="minicart-wishlist" title="تعداد کالا در سبد خرید"><i class="fa fa-heart-o" aria-hidden="true"></i><span>(<?= $_SESSION['like_count'] > 0 ? \f\ifm::faDigit($_SESSION['like_count']) : \f\ifm::faDigit('0') ?>)</span></a>
                        <div class="block-minicart dropdown">
                            <a class="minicart" href="<?= \f\ifm::app()->siteUrl . 'cart/' ?>" title="سبد خرید">
                           <span class="counter qty">
                           <span class="cart-icon"><i class="fa fa-cart-plus" aria-hidden="true"></i></span>
                           <span class="counter-number"><?= $_SESSION['order_count'] > 0 ? \f\ifm::faDigit($_SESSION['order_count']) : \f\ifm::faDigit('0') ?></span>
                           </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-menu-nar header-sticky">
            <div class="container">

                <?php
                echo \f\ttt::block( 'cms.menu.index',
                    [
                        'name' => 'header'
                    ] );
                ?>

            </div>
        </div>
    </header>

