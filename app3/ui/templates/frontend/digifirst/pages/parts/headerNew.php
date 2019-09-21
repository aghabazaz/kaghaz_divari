<?php
if ( $menu != '404' )
{
  //  \f\ttt::service( 'core.visit.setVisit',[],true );
}
$social = \f\ttt::service ( 'cms.socialnet.getSocialnetSetting') ;

?>
<!DOCTYPE html>
<html lang="fa-IR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title><?= $title ?></title>
    <meta name="description" content="<?= $description ?>"/>
    <meta name="keywords" content="<?= $keywords ?>"/>
    <meta name="twitter:image:src" itemprop="image" property="og:image" content="<?= $pictureUrl ?>"/>
    <meta name="msapplication-TileImage" content="<?= \f\ifm::app()->fileBaseUrl . $websiteInfo['favicon'] ?>"/>
    <link rel="icon" href="<?= \f\ifm::app()->fileBaseUrl . $websiteInfo['favicon'] ?>" sizes="192x192"/>
    <link rel="apple-touch-icon-precomposed" href="<?= \f\ifm::app()->fileBaseUrl . $websiteInfo['favicon'] ?>"/>
    <!-- styles for new digiFirst -->
    <link rel="stylesheet" type="text/css"
          href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css"
          href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css"
          href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/animate.css">
    <link rel="stylesheet" type="text/css"
          href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/chosen.css">
    <link rel="stylesheet" type="text/css"
          href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/owl.carousel.css">
    <link rel="stylesheet" type="text/css"
          href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/pe-icon-7-stroke.css">
    <link rel="stylesheet" type="text/css"
          href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/style.min.css">
    <script type="text/javascript"
            src="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/js/jquery.min.js"></script>
    <script type='text/javascript'  src='<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/base/js/bootstrap.min.js'></script>
    <input id="siteUrl" value="<?= \f\ifm::app()->siteUrl ?>" type="hidden">
    <script type='text/javascript'
            src='<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/base/js/default.min.js'></script>
    <!-- styles for new digiFirst -->
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <!--<script async src="https://www.googletagmanager.com/gtag/js?id=UA-127841002-1"></script>-->
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-127841002-1');
    </script>
</head>
<body class="index-opt-2">
<div class="wrapper">
    <header class="site-header header-opt-1">
        <div class="header-top">
            <div class="container">
                <ul class="header-top-left smarket-nav">
                    <li><a href="" title="شماره تماس"><i class="fa fa-phone" aria-hidden="true" ></i> <?= \f\ifm::faDigit( $social['phone'])?> </a></li>
                    <li><a href="" title="پست الکترونیک"><i class="fa fa-envelope" aria-hidden="true"></i> <?= $social['email']?> </a></li>
                </ul>
                <ul class="header-top-right">
                    <li><a href="<?= \f\ifm::app()->siteUrl . 'account/' ?>" title="حساب کاربری"><i class="fa fa-car" aria-hidden="true"></i>پیگیری سفارش</a></li>
                    <li><a href="<?= \f\ifm::app()->siteUrl . 'contactUs/' ?>" title="ارتباط با ما"><i class="fa fa-map-marker" aria-hidden="true"></i>مکان فروشگاه</a></li>
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
                        <li><a href="<?= \f\ifm::app()->siteUrl . 'login/' ?>" title="ورود کاربر"><i class="fa fa-user" aria-hidden="true"></i>ورود  </a><span class="or-two"> یا </span><a href="<?= \f\ifm::app()->siteUrl . 'register/' ?>" title="ثبت نام"> ثبت نام</a></li>
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
                            <a href="<?= \f\ifm::app ()->siteUrl ?>" title="<?=$title?>" ><img title="<?=$title?>" src="<?= $pictureUrl ?>" alt="<?=$title?>"></a>
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
                        <a href="" class="minicart-wishlist" title="تعداد علاقه مندی ها"><i class="fa fa-heart-o" aria-hidden="true"></i><span>(<?= $_SESSION['like_count'] > 0 ? \f\ifm::faDigit($_SESSION['like_count']) : \f\ifm::faDigit('0') ?>)</span></a>

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
