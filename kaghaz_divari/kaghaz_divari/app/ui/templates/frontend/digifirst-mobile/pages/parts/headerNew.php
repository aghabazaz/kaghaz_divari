<?php
if ( $menu != '404' )
{
    \f\ttt::service( 'core.visit.setVisit',[],true );
}
?>
<!DOCTYPE html>
<html lang="fa-IR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title><?= $title ?></title>
    <meta name="description" content="<?= $description ?>"/>
    <meta name="keywords" content="<?= $keywords ?>"/>
    <meta name="twitter:image:src" itemprop="image" property="og:image" content="<?= $picture ?>"/>
    <meta name="msapplication-TileImage" content="<?= \f\ifm::app()->fileBaseUrl . $websiteInfo['favicon'] ?>"/>
    <link rel="icon" href="<?= \f\ifm::app()->fileBaseUrl . $websiteInfo['favicon'] ?>" sizes="192x192"/>
    <link rel="apple-touch-icon-precomposed" href="<?= \f\ifm::app()->fileBaseUrl . $websiteInfo['favicon'] ?>"/>
    <!-- styles for new digiFirst -->
    <link rel="stylesheet" type="text/css" href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst-mobile/css/owl.carousel.css">
    <link rel="stylesheet" type="text/css" href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst-mobile/css/jscroll-style.css">
    <link rel="stylesheet" type="text/css" href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst-mobile/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst-mobile/css/entypo.css">
    <link rel="stylesheet" type="text/css" href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst-mobile/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst-mobile/css/style.css">
    <input id="siteUrl" value="<?= \f\ifm::app()->siteUrl ?>" type="hidden">
    <script type="text/javascript"
            src="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst-mobile/js/jquery.min.js"></script>


</head>
<body>
<header>
    <div class="headerMobile">
        <!--.......start for menu mobile.................-->
        <div class="menuMobile">
            <div class="menu-mobile">
                <a href="javascript:void(0)" onclick="openNav()">
                    <i class="fa fa-bars"></i>
                </a>
            </div>
        </div>
        <div class="mobile-view">
            <div id="myCanvasNav" class="overlay3" onclick="closeNav()"></div>
            <div id="mySidenav" class="sidenav">
                <div class="header-menu-mobile" id="mySidenav" >
                    <img src="<?= \f\ifm::app()->siteUrl . $websiteInfo['logo_url'] ?>" alt="پخش لوازم جانبی موبایل">
                    <?php
                    echo \f\ttt::block( 'cms.menu.index',
                        [
                            'name' => 'header-mobile'
                        ] );
                    ?>
                </div>
            </div>
        </div>
        <!--.......start for menu mobile.................-->
        <div class="searchMobile">
            <div class="">
                <form class="searchbox">
                    <input type="search" placeholder="جستجو....." name="search" class="searchbox-input" onkeyup="buttonUp();" required>
                    <input type="submit" class="searchbox-submit" value="برو" >
                    <span class="searchbox-icon">
                        <i class="fa fa-search" aria-hidden="true"></i>
                    </span>
                </form>
            </div>
        </div>
        <?php
        if(!empty($_SESSION['user_id'])){
            $leftDiv='style="left:80px;"';
            ?>
            <div class="userMobile" style="width:60px;">
                <a href="<?= \f\ifm::app()->siteUrl . 'member/logout/' ?>"><i class="fa fa-sign-out" aria-hidden="true"></i></a>
                <a  class="link-lg" href="<?= \f\ifm::app()->siteUrl . 'member/account/' ?>">  <i class="fa fa-user"></i></a>
            </div>
            <?php
        }else{
            $leftDiv="";
            ?>
            <div class="userMobile">
                <a href="<?= \f\ifm::app()->siteUrl . 'login/' ?>"><i class="fa fa-user-o" aria-hidden="true"></i></a>
            </div>
            <?php
        }
        ?>



        <div class="basketShopMobile" <?=$leftDiv?>>
            <a href=""><i class="fa fa-cart-plus" aria-hidden="true"></i></a>
        </div>
    </div>
    <div class="logoMobile">
        <img src="<?= $picture ?>">
    </div>

</header>

