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

    <script type="text/javascript"
            src="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/js/jquery.min.js"></script>
    <input id="siteUrl" value="<?= \f\ifm::app()->siteUrl ?>" type="hidden">
    <script type='text/javascript'
            src='<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/base/js/default.min.js'></script>
</head>
<body data-spy="scroll" data-target="#navSecondary" data-offset="150">

<div class="body dir-ltr">

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