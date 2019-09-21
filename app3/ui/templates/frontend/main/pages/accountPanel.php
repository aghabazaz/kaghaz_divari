<?php
if ( $_SESSION[ 'user_id' ] )
{
    $websiteInfo = $content[ 'websiteInfo' ] ;
//\f\pre($websiteInfo);
    $title       = $websiteInfo[ 'title' ] ;
    if ( $content[ 'title' ] )
    {
        $title.=' - ' . $content[ 'title' ] ;
    }
    if ( $content[ 'keywords' ] )
    {
        $keywords = $websiteInfo[ 'keywords' ] . ',' . $content[ 'keywords' ] ;
    }
    else
    {
        $keywords = $websiteInfo[ 'keywords' ] ;
        if ( $content[ 'title' ] )
        {
            $keywords.=' , ' . str_replace ( ' ', ',', $content[ 'title' ] ) ;
        }
    }
    if ( $content[ 'description' ] )
    {
        $description = $content[ 'description' ] ;
    }
    else
    {
        $description = $websiteInfo[ 'description' ] ;
    }

    $logo = \f\ifm::app ()->fileBaseUrl . $websiteInfo[ 'logo' ] ;

    if ( $content[ 'picture' ] )
    {
        $picture = \f\ifm::app ()->fileBaseUrl . $content[ 'picture' ] ;
    }
    else
    {
        $picture = $logo ;
    }

    include 'parts' . \f\DS . 'header.php' ;
    ?>  
    <section class="page-title" style="margin-bottom: 0px">
        <div class="grid-row clearfix">
            <h1>پنل کاربری</h1>

            <nav class="bread-crumbs">

            </nav>
        </div>
    </section>

    <div class="row" style="direction: rtl;width:100%;display: table;margin:0px;vertical-align: top;">
        <nav class="navbar navbar-default sidebar" role="navigation" >
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-sidebar-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>      
                </div>
                <div class="collapse navbar-collapse" id="bs-sidebar-navbar-collapse-1" >

                    <div style="min-height:100px;text-align: center;padding-top: 10px">
                        <img src="<?= \f\ifm::app ()->fileBaseUrl . $_SESSION[ 'picture' ] ?>" style="width:130px;height: 130px;border-radius: 100%">
                        <div style="font-size: 22px;color:#000;padding-bottom: 10px"><?= $_SESSION[ 'name' ] ?></div>
                    </div>
                    <?=
                    \f\ttt::block ( 'cms.menu.index',
                                    array (
                        'name' => 'sidebar'
                    ) ) ;
                    ?>

                </div>
            </div>
        </nav>
        <div class="content-panel" >
            <?php
            /* @var $pageWidget \f\w\pageTitle */
//            $pageWidget = \f\widgetFactory::make ( 'pageTitle' ) ;
//            echo $pageWidget->renderTitle ( array (
//                'title' => '<i class="fa fa-dashboard"></i> داشبورد',
//                'links' => array (
//                    array (
//                        'title' => 'لینک',
//                        'href'  => '' ) ) ) ) ;
            ?>
            <?php
            echo $content[ 'content' ] ;
            ?>

        </div>
    </div>
<link rel="stylesheet" type="text/css" href="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/datatables/media/css/jquery.dataTables.css">
<script type="text/javascript" language="javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/datatables/media/js/jquery.dataTables.js"></script>

    <style>
        nav.sidebar, .main{
            -webkit-transition: margin 200ms ease-out;
            -moz-transition: margin 200ms ease-out;
            -o-transition: margin 200ms ease-out;
            transition: margin 200ms ease-out;


        }

        .content-panel{
            padding: 10px 10px 50px 10px;
            color:#000;
            vertical-align: top;


        }

        @media (min-width: 765px) {





            nav.sidebar.navbar.sidebar>.container .navbar-brand, .navbar>.container-fluid .navbar-brand {
                margin-left: 0px;
            }

            nav.sidebar .navbar-brand, nav.sidebar .navbar-header{
                text-align: center;
                width: 100%;
                margin-left: 0px;
            }

            nav.sidebar a{
                padding-right: 13px;
            }

            nav.sidebar .navbar-nav > li:first-child{
                border-top: 1px #e5e5e5 solid;


            }

            nav.sidebar .navbar-nav > li{
                border-bottom: 1px #e5e5e5 solid;
            }

            nav.sidebar .navbar-nav > li.active{
                border-right: 3px solid #008fd5;
            }
            nav.sidebar .navbar-nav > li.active a,a:hover{
                color:#008fd5;
            }
            nav.sidebar .navbar-nav > li.active a:hover{
                color:#008fd5;
            }
            nav.sidebar .navbar-nav > li:hover{
                background: #fdfdfd;
            }

            nav.sidebar .navbar-nav .open .dropdown-menu {
                position: static;
                float: none;
                width: auto;
                margin-top: 0;
                background-color: transparent;
                border: 0;
                -webkit-box-shadow: none;
                box-shadow: none;
            }

            nav.sidebar .navbar-collapse, nav.sidebar .container-fluid{
                padding: 0 0px 0 0px;
            }

            .navbar-inverse .navbar-nav .open .dropdown-menu>li>a {
                color: #777;
            }

            nav.sidebar{
                width: 220px;
                height: 100%;

                float: none;
                margin-bottom: 0px;
            }

            nav.sidebar li {
                width: 100%;
                padding-right:0px;

            }

            nav.sidebar:hover{
                margin-left: 0px;
            }

            .forAnimate{
                opacity: 0;
            }
        }

        @media (min-width: 1280px) 
        {

            .content-panel{
                width: calc(100% - 220px);

                display:table-cell
            }

            nav.sidebar{
                margin-right: 0px;
                float: none;
                display:table-cell;
                width:220px;
            }

            nav.sidebar .forAnimate{
                opacity: 1;
            }


        }

        nav.sidebar .navbar-nav .open .dropdown-menu>li>a:hover, nav.sidebar .navbar-nav .open .dropdown-menu>li>a:focus {
            color: #000;
            background-color: transparent;
        }

        nav:hover .forAnimate{
            opacity: 1;
        }
        section{
            padding-right: 15px;
        }


    </style>


    <?php
    include 'parts' . \f\DS . 'footer.php' ;
}
else
{
    header ( "Location:" . \f\ifm::app ()->siteUrl . 'login/' ) ;
}
?>
