<?
if ( $menu != '404' )
{
    \f\ttt::service ( 'core.visit.setVisit', array ( ), true ) ;

    //\f\pr($websiteInfo);
}
?>
<!DOCTYPE html>
<html lang="fa-IR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <title><?= $title ?></title> 
        <meta name="description" content="<?= $description ?>" />
        <meta name="keywords" content="<?= $keywords ?>" />
        <meta name="twitter:image:src" itemprop="image" property="og:image" content="<?= $picture ?>" />
        <meta name="msapplication-TileImage" content="<?= \f\ifm::app ()->fileBaseUrl . $websiteInfo[ 'favicon' ] ?>" />
        <link rel="icon" href="<?= \f\ifm::app ()->fileBaseUrl . $websiteInfo[ 'favicon' ] ?>" sizes="192x192" />
        <link rel="apple-touch-icon-precomposed" href="<?= \f\ifm::app ()->fileBaseUrl . $websiteInfo[ 'favicon' ] ?>" />



        <script type='text/javascript' src='<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/jquery/jquery.js'></script>
        <script src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/jqueryui/jquery-ui.min.js"></script>
        <script src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/select/select2.js"></script>
        <script src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/select/select2_locale_fa.js"></script>
        <link rel="stylesheet" href="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/select/select2.css">

        <link rel='stylesheet' id='reviews-bootstrap-group-css' href='<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/css/style.css' type='text/css' media='all' />
        <link rel='stylesheet' id='reviews-bootstrap-group-css' href='<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/css/rev-settings.css' type='text/css' media='all' />
    <input type="hidden" id="siteUrl" value="<?= \f\ifm::app ()->siteUrl ; ?>">
    <script type='text/javascript' src='<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/default.js'></script>
    <style id='reviews-style-inline-css' type='text/css'>
        .top-bar{
            background: #ffffff;
            background: #eee;
        }

        .top-bar,
        .top-bar a,
        .top-bar a:visited{
            color: #676767;
        }



        .navigation-bar{
            background:#12222A;
            border-bottom: 3px solid #95C454;
        }

        .navbar-toggle,
        #navigation .nav.navbar-nav > li > a,
        #navigation .nav.navbar-nav > li.open > a,
        #navigation .nav.navbar-nav > li > a:hover,
        #navigation .nav.navbar-nav > li > a:focus ,
        #navigation .nav.navbar-nav > li > a:active,
        #navigation .nav.navbar-nav > li.current > a,
        #navigation .navbar-nav > li.current-menu-parent > a, 
        #navigation .navbar-nav > li.current-menu-ancestor > a, 
        #navigation  .navbar-nav > li.current-menu-item  > a{
            color: #ffffff;
            font-size: 13px;
            font-family:Yekan;
        }

        .nav.navbar-nav li a{
            font-family: Yekan;
        }


        .tagcloud a,
        .big-search a,
        .sticky-wrap,
        .form-submit #submit,
        .alert-success,

        .category-lead-bg{
            background: #9ACC55;
            color: #ffffff;
        }

        .leading-category .fa{
            border-color: #ffffff;
            color: #ffffff;
        }

        a.grey:hover,
        .section-title i,
        .blog-title:hover h4, .blog-title:hover h5,
        .fake-thumb-holder .post-format,
        .comment-reply-link:hover{
            color: #9ACC55;
        }

        .tagcloud a:hover, .tagcloud a:focus, .tagcloud a:active
        {
            background: #232323;
            color: #ffffff;
        }

        .pagination a.active{
            background: #454545;
            color: #ffffff;
        }

        /* BODY */
        body[class*=" "]{
            background-color: #f5f5f5;

            font-family: Yekan;
            font-size: 13px;
            line-height: 23px;
            direction:rtl;
        }

        h1,h2,h3,h4,h5,h6{
            font-family: Yekan;
        }

        h1{
            font-size: 38px;
            line-height: 1.25;
        }

        h2{
            font-size: 32px;
            line-height: 1.25;
        }

        h3{
            font-size: 28px;
            line-height: 1.25;
        }

        h4{
            font-size: 22px;
            line-height: 1.25;
        }

        h5{
            font-size: 18px;
            line-height: 1.25;
        }

        h6{
            font-size: 13px;
            line-height: 1.25;
        }

        .copyrights{
            background: #12222A;
            color: #ffffff;
        }

        .copyrights .copyrights-share{
            color: #ffffff;
        }

        .mega_menu_dropdown .nav-tabs > li.active > a, 
        .mega_menu_dropdown .nav-tabs > li.active > a:hover, 
        .mega_menu_dropdown .nav-tabs > li.active > a:focus,
        .mega_menu_dropdown ul.nav.nav-tabs li,
        .mega_menu_dropdown ul.nav.nav-tabs li li,
        .mega_menu_dropdown .nav-tabs > li > a,
        .mega_menu_dropdown .tab-content{
            background: none;
        }

        a.review-cta.btn,
        a.review-cta.btn:active,
        a.review-cta.btn:visited,
        a.review-cta.btn:focus{
            background: #9ACC55;
            color: #ffffff;
        }

        a.review-cta.btn:hover
        {
            background: #232323;
            color: #ffffff;
        }

        .breadcrumbs
        {
            background: #62B9E4;
            color: #fff;
        }
    </style>



</head>

<body class="home page page-id-16 page-template page-template-page-tpl_home page-template-page-tpl_home-php">

    <section class="top-bar">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="account-action text-right">
                        <?
                        if ( $_SESSION[ 'user_front' ] )
                        {
                            echo $_SESSION[ 'name' ] . ' خوش آمدید.' ;
                            ?>
                            [
                            <a href="<?= \f\ifm::app ()->siteUrl . 'account/' ?>" style="margin-left: 0px">

                                <?= 'پنل کاربری' ?>					
                            </a>&nbsp;|&nbsp;
                            <a href="<?= \f\ifm::app ()->siteUrl . 'user/logout/' ?>" style="margin-left: 0px">

                                <?= 'خروج' ?>						
                            </a>
                            ]
                            <?
                        }
                        else
                        {
                            ?>
                            <a href="<?= \f\ifm::app ()->siteUrl . 'register/' ?>">
                                <i class="fa fa-user animation"></i>
                                <?= 'ثبت نام کنید' ?>					
                            </a>
                            <a href="<?= \f\ifm::app ()->siteUrl . 'login/' ?>">
                                <i class="fa fa-sign-in animation"></i>
                                <?= 'وارد حساب کاربری خود شوید' ?>						
                            </a>
                            <?
                        }
                        ?>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="text-left">
                        <?
                        echo \f\ttt::block ( 'cms.todayDate', array ( ) ) ;
                        ?>
                    </div>
                </div>		

            </div>
        </div>
    </section>
    <header class="page-header main-page sticky">
        <div class="sticky-wrapp">
            <div class="sticky-container">
                <!-- logo -->
                <section id="logo" class="logo">
                    <div>
                        <a href=""><img src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/main/img/blue/logo.png" alt="Clinico"></a>
                    </div>
                </section>
                <!--/ logo -->

                <!-- main nav -->
                <?=
                \f\ttt::block ( 'cms.menu.index',
                                array (
                    'name' => 'header'
                ) ) ;
                ?>
                <!--/ mobile nav -->
            </div>
        </div>
    </header>
