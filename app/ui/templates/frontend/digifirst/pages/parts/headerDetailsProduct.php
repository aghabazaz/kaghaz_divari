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
              href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/animate.min.css">
        <link rel="stylesheet" type="text/css"
              href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/chosen.css">
        <link rel="stylesheet" type="text/css"
               href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/pe-icon-7-stroke.css">
        <?php
    }
    ?>
    <!--<link rel="stylesheet" type="text/css"
          href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/bootstrap.css">-->
    <link rel="stylesheet" type="text/css"
          href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css"
          href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/font-awesome.css">
    <link rel="stylesheet" type="text/css"
          href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/animate.min.css">
    <link rel="stylesheet" type="text/css"
          href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/linear-icons.min.css">
    <link rel="stylesheet" type="text/css"
          href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css"
          href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/owl.theme.default.min.css">

    <link rel="stylesheet" type="text/css"
          href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/magnific-popup.min.css">
    <link rel="stylesheet" type="text/css"  href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/mainStyle.css">
    <link rel="stylesheet" type="text/css"
          href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/newStyle.css">
    <link rel="stylesheet" type="text/css"
          href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/demo-architecture.css">
    <link rel="stylesheet" type="text/css"
          href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/custom.css">


    <link rel="stylesheet" type="text/css"  href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/style.min.css">
    <script type="text/javascript"  src="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/js/jquery.min.js"></script>

    <script type='text/javascript'
            src='<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/base/js/defaultCustom.js'></script>
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
    <header id="header" class="header-transparent header-transparent-dark dir-rtl" data-plugin-options="{'stickyEnabled': true, 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': true, 'stickyStartAt': 1, 'stickyChangeLogo': false}">
        <div class="header-body border-bottom-0">
            <div class="header-container container">
                <div class="header-row">

                    <?php
                    //گرفتن منو
                    echo \f\ttt::block( 'cms.menu.index',
                        [
                            'name' => 'headerIndex'
                        ] );
                    ?>
                    <div class="header-column justify-content-start">
                        <ul class="nav top-nav">
                            <li class="nav-item">
                                <a href="#" class="nav-link dropdown-menu-toggle py-2" id="dropdownLanguage" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    <i class="fa fa-user-circle"></i>
                                </a>

                                <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownLanguage">
                                    <li><a href="#" class="no-skin"> ورود</a></li>
                                    <li><a href="#" class="no-skin">ثبت نام</a></li>
                                </ul>
                            </li>
                        </ul>
                        /
                        <div class="basketShopMobile">
                            <a href="<?= \f\ifm::app ()->siteUrl . 'cart' ?>" class="cart-mobile" title="سبد خرید">
                                <i class="fa fa-shopping-cart"></i>
                                <?php
                                //\f\pre($order_count);
                                if(!empty($_SESSION['user_id'])) {
                                    if ($order_count['count']>0) {
                                        echo '<div class="fa-digit">' . $order_count['count'] . '</div>';
                                    }
                                }
                                ?>
                            </a>
                        </div>
                        <div class="header-logo">
                            <a href="<?= \f\ifm::app ()->siteUrl ?>" title="<?=$title?>" >
                                <img title="<?=$title?>" src="<?= $pictureUrl ?>" alt="<?=$title?>">
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </header>