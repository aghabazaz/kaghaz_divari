<?php
if ( $menu != '404' )
{
    //\f\ttt::service( 'core.visit.setVisit',[],true );
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
    <link rel="stylesheet" type="text/css"
          href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/proDetDynamic/jquery-ui.min.css"/>
    <link rel="stylesheet" type="text/css"
          href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/proDetDynamic/bootstrap.rtl.min.css"/>
    <link rel="stylesheet" type="text/css"
          href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/proDetDynamic/jquery.fancybox.css"
          media="all"/>
    <link rel="stylesheet" type="text/css"
          href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/proDetDynamic/rtl.css"
          media="all"/>
    <link rel="stylesheet" type="text/css"
          href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/proDetDynamic/cropper.css"
          media="all"/>
    <link rel="stylesheet" type="text/css"
          href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/proDetDynamic/skin.css"
          media="all"/>
    <link rel="stylesheet" type="text/css"
          href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/proDetDynamic/print.css"
          media="print"/>
    <script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/proDetDynamic/prototype.js"></script>
    <script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/proDetDynamic/et_currencymanager_round.js"></script><
    <script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/proDetDynamic/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/proDetDynamic/jquery.fancybox.js"></script>
    <script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/proDetDynamic/jquery.mousewheel-3.0.6.pack.js"></script>
    <script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/proDetDynamic/enscroll-0.6.1.min.js"></script>
    <script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/proDetDynamic/product_options.js"></script>
    <script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/proDetDynamic/cropper.js"></script>
    <script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/proDetDynamic/jquery.webui-popover.js"></script>
    <script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/proDetDynamic/crop.js"></script>





</head>

<body class="index-opt-2 catalog-product-view rtl catalog-product-view product- pr">
<header id="header" class="header-transparent header-transparent-dark dir-rtl" data-plugin-options="{'stickyEnabled': true, 'stickyEnableOnBoxed': true, 'stickyEnableOnMobile': true, 'stickyStartAt': 1, 'stickyChangeLogo': false}">
    <div class="header-body border-bottom-0">
        <div class="header-container container">
            <div class="header-row">
                <div class="header-column justify-content-start">
                    <div class="header-logo">
                        <a href="<?= \f\ifm::app ()->siteUrl ?>" title="<?=$title?>" >
                            <img title="<?=$title?>" src="<?= $pictureUrl ?>" alt="<?=$title?>">
                        </a>
                    </div>
                </div>
                <?php
                //گرفتن منو
                echo \f\ttt::block( 'cms.menu.index',
                    [
                        'name' => 'headerIndex'
                    ] );
                ?>

            </div>
        </div>
    </div>
</header>