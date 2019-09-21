<?php
if ( $menu != '404' )
{
   // \f\ttt::service( 'core.visit.setVisit',[],true );
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
    <script type='text/javascript'  src='<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/base/js/bootstrap.min.js'></script>
    <input id="siteUrl" value="<?= \f\ifm::app()->siteUrl ?>" type="hidden">
    <script type='text/javascript'
            src='<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/base/js/default.min.js'></script>
    <!-- styles -->
    <link rel="stylesheet" type="text/css"
          href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/chosen.css">
    <link rel="stylesheet" type="text/css"
          href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/style.min.css">
    <link rel="stylesheet"
          href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/css/bootstrap-multiselect.css"
          type="text/css"/>
    <script>
        document.cookie = "width=" + $(window).width();
        document.cookie = "height=" + $(window).height();
    </script>

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-127841002-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-127841002-1');
    </script>
</head>

<body data-spy="scroll" data-target="#navSecondary" data-offset="150">
<div class="mobile-view">
    <div class="loading-main">
        <div style="text-align: center;padding-top: 40%">
            <img src="<?= \f\ifm::app()->siteUrl . $websiteInfo['logo_url'] ?>" style="max-height: 60px" alt="<?=$title?>" title="<?=$title?>">
        </div>
        <div class="spinner-main" style="">
            <div class="loader-main"></div>
        </div>

    </div>
    <div id="myCanvasNav" class="overlay3" onclick="closeNav()"></div>
    <div id="mySidenav" class="sidenav">
        <div class="header-menu-mobile">
            <img src="<?= \f\ifm::app()->siteUrl . $websiteInfo['logo_url'] ?>" alt="<?=$title?>" title="<?=$title?>">
        </div>
        <?php
        echo \f\ttt::block( 'cms.menu.index',
            [
                'name' => 'header-mobile'
            ] );
        ?>

    </div>
</div>

<div class="page">
    <!-- page header -->
    <div class="desktop-view">
        <section class="top_header">
            <div class="grid-row"
                 style="direction:rtl;padding-top:0px;margin-bottom: 0px;border-bottom: 1px solid #f0f0e9;color:#b0acac">
                <?=
                \f\ttt::block( 'cms.socialnet.index',
                    [
                        'type' => 'header'
                    ] )
                ?>
            </div>
        </section>
        <header class="page-header main-page sticky" style="padding: 5px 0px">
            <div class="sticky-wrapp">
                <div class="sticky-container">
                    <!-- logo -->
                    <div class="grid-row" style="direction: rtl">
                        <section id="logo" class="logo">
                            <div>
                                <a href="<?= \f\ifm::app()->siteUrl ?>" title="<?=$title?>"><img src="<?= \f\ifm::app()->siteUrl . $websiteInfo['logo_url'] ?>"
                                                                                                 alt="<?= $websiteInfo['title'] ?>" title="<?=$title?>"></a>
                            </div>
                        </section>
                        <section class="header-action">
                            <div class="cart" style="position:relative">
                                <button class="btn btn-success"
                                        onclick="window.location.href = '<?= \f\ifm::app()->siteUrl ?>cart'">
                                    <i class="fa fa-shopping-basket"></i> سبد خرید
                                    <div class="fa-digit"><?= $_SESSION['order_count'] ? $_SESSION['order_count'] : '0' ?></div>
                                </button>
                                <div class="btn-group">
                                    <button class="btn btn-info"
                                            onclick="window.location.href = '<?= \f\ifm::app()->siteUrl ?>account'"><i
                                                class="fa fa-user"></i> حساب کاربری
                                    </button>
                                    <button id="account" type="button" class="btn btn-info dropdown-toggle"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="caret"></span>
                                        <span class="sr-only"></span>
                                    </button>
                                    <ul class="dropdown-menu account-menu">
                                        <?php
                                        if ( $_SESSION['user_id'] )
                                        {
                                            ?>
                                            <li style="color:#000;text-align: center;padding: 10px 0px;font-size: 12px">
                                                <?= $_SESSION['name'] . ' خوش آمدید ...' ?>
                                            </li>
                                            <li role="separator" class="divider"></li>
                                            <li style="padding: 5px">
                                                <a href="<?= \f\ifm::app()->siteUrl . 'account' ?>" title="اطلاعات کاربری"
                                                   style="color:#555;text-decoration: none">
                                                    <i class="fa fa-user" style="padding-left: 5px"></i>
                                                    اطلاعات کاربری
                                                </a>
                                            </li>
                                            <li style="padding: 5px">

                                                <a href="<?= \f\ifm::app()->siteUrl . 'member/logout' ?>" title="خروج"
                                                   style="color:#555;text-decoration: none">
                                                    <i class="fa fa-sign-out" style="padding-left: 5px"></i>
                                                    خروج
                                                </a>

                                            </li>
                                        <?php
                                        }
                                        else
                                        {
                                        ?>
                                            <form id="loginForm" method="POST"
                                                  action="<?= \f\ifm::app()->siteUrl . 'member/checkLogin' ?>">
                                                <li style="color:#000;font-size:14px;padding: 5px;">
                                                    ورود به سایت
                                                </li>
                                                <li>
                                                    <input type="text" name="email" placeholder="نام کاربری">
                                                </li>
                                                <li>
                                                    <input type="password" name="password" placeholder="کلمه عبور">
                                                </li>
                                                <li>
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fa fa-sign-in"></i>ورود ...
                                                    </button>
                                                </li>
                                            </form>
                                            <script>
                                                widgetHelper.formSubmit('#loginForm');
                                            </script>


                                            <li role="separator" class="divider"></li>
                                            <li>
                                                <i class="fa fa-lock"></i> تاکنون عضو نشده اید؟
                                                <a href="<?= \f\ifm::app()->siteUrl . 'register' ?>" title="ثبت نام">ثبت نام</a>
                                            </li>
                                            <?php
                                        }
                                        ?>

                                    </ul>
                                </div>
                            </div>
                            <div class="search">
                                <input type="hidden" value="0" name="key" id="key">
                                <input type="hidden" value="0" name="selectDiv" id="selectDiv">
                                <input type="text" placeholder="جستجوی نام ، برند یا دسته بندی کالا ..."
                                       name="searchtxt" id="searchtxt"
                                       onkeyup="search_keyword('<?= \f\ifm::app()->siteUrl ?>')"
                                       onclick="search_keyword('<?= \f\ifm::app()->siteUrl ?>')" autocomplete="off">
                                <button><i class="fa fa-search"></i></button>
                            </div>
                            <div id="result_search" class="result_search" style=""></div>

                        </section>
                    </div>
                    <!--/ logo -->
                </div>
            </div>
        </header>
        <section class="bottom_header">
            <div class="grid-row" style="margin:0px auto;position: relative">
                <?php
                echo \f\ttt::block( 'cms.menu.index',
                    [
                        'name' => 'header'
                    ] );
                ?>
            </div>
        </section>
    </div>
    <div class="mobile-view">
        <div class="mobile-header">
            <div class="menu-mobile">
                <a href="javascript:void(0)" onclick="openNav()" title="منو">
                    <i class="fa fa-bars"></i>
                </a>
            </div>
            <div class="logo-mobile">
                <a href="<?= \f\ifm::app()->siteUrl ?>" title="<?=$title?>">
                    <img src="<?= \f\ifm::app()->siteUrl . $websiteInfo['logo_footer_url'] ?>"
                         alt="<?= $websiteInfo['title'] ?>" title="<?=$title?>">
                </a>
            </div>
            <div class="action-mobile">
                <a href="javascript:void(0)" onclick="openSearch()" title="<?=$title?>">
                    <i class="fa fa-search"></i>
                </a>
                <a href="<?= \f\ifm::app()->siteUrl . 'account' ?>" title="<?=$title?>">
                    <i class="fa fa-user-o"></i>
                </a>
                <a href="<?= \f\ifm::app()->siteUrl . 'cart' ?>" class="cart-mobile" title="<?=$title?>">
                    <i class="fa fa-shopping-basket"></i>
                    <?php
                    if ( $_SESSION['order_count'] )
                    {
                        echo '<div class="fa-digit">' . $_SESSION['order_count'] . '</div>';
                    }
                    ?>
                </a>
            </div>
            <div class="searchbox-mobile">
                <input type="hidden" value="0" name="key-mobile" id="key-mobile">
                <input type="hidden" value="0" name="selectDiv-mobile" id="selectDiv-mobile">
                <input type="text" placeholder="به دنبال چه می گردید..." name="searchtxt" id="searchtxt-mobile"
                       onkeyup="search_keyword('<?= \f\ifm::app()->siteUrl ?>', 'mobile')"
                       onclick="search_keyword('<?= \f\ifm::app()->siteUrl ?>', 'mobile')" autocomplete="off">

                <button onclick="closeSearch()">
                    <i class="fa fa-arrow-left"></i>
                </button>
                <div id="result_search-mobile" class="result_search" style="direction: rtl"></div>


            </div>
        </div>
    </div>
    <!--/ page header -->

