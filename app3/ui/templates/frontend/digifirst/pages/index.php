<?php
$title       = $websiteInfo['title'];
$keywords    = $websiteInfo['keywords'];
$description = $websiteInfo['description'];
$logo        = \f\ifm::app()->fileBaseUrl . $websiteInfo['logo'];
$picture     = $logo;
$pictureUrl  = \f\ttt::service( 'core.fileManager.loadFileUrl',[
    'fileId' => $websiteInfo['logo']
] );
$shopSetting = \f\ttt::service( 'shop.shopSetting.getSettings' );
$settings = \f\ttt::service( 'cms.settings.getSettings' );
include 'parts' . \f\DS . 'headerNew.php';
//\f\pre($settings);
?>
<main class="site-main">
    <?php
    echo \f\ttt::block( 'cms.slide.getSlideList' );
    ?>
    <?php
    //echo \f\ttt::block( 'shop.product.getAmazingSlide' );?>
    <div class="container-inner vc_row wpb_row vc_row-fluid theme-container vc_custom_1505998143675 vc_row-has-fill vc_row-o-content-middle vc_row-flex">
        <div class="cms-banner-img" style="background-image: url(<?=\f\ifm::app ()->fileBaseUrl.$settings['picBasketRep']?>)">
                                <span class="static-wrapper">
                                    <span class="static-inner">
                                        <h1 class="text2 static-text"><?= $settings['titleIndexH1'] ?></h1>
                                        <h2 class="text2 static-text"><?= $settings['titleIndexH2'] ?></h2>
                                    </span>
                                </span>
        </div>
    </div>
    <?php    echo \f\ttt::block( 'shop.product.getSpecialCategory' );
    ?>

    <div class="container-inner">
        <div class="row">
            <div class="col-md-3">
                <div class="block-blog blog-home hide-mobile">
                    <div class="title-top">
                        <h3 class="title-block style2">آخرین مطالب بلاگ</h3>
                    </div>
                    <div class="owl-carousel nav-style2" data-nav="true" data-autoplay="true" data-dots="false" data-loop="true" data-margin="30" data-responsive='{"0":{"items":1},"480":{"items":3},"768":{"items":3},"1200":{"items":1}}'>
                        <?php
                       echo \f\ttt::block( 'cms.contentListMain' );
                        ?>
                    </div>
                </div>
                <?php
                echo \f\ttt::block( 'cms.advertisement.getSocialAdvertise',
                    [
                        'plan'     => 'B',
                        'plan2'    => 'sideAdver',
                        'location' => 'index'
                    ] );
                ?>
                <div class="block-blog blog-home hide-mobile">
                    <div class="title-top">
                        <h3 class="title-block style2">اخرین اخبار</h3>
                    </div>
                    <div class="owl-carousel nav-style2" data-nav="true" data-autoplay="true" data-dots="false" data-loop="true" data-margin="30" data-responsive='{"0":{"items":1},"480":{"items":3},"768":{"items":3},"1200":{"items":1}}'>
                        <?php
                       echo \f\ttt::block( 'cms.news.newsList' );
                        ?>
                    </div>
                </div>
            </div>
            <?php
            echo \f\ttt::block( 'shop.product.getNewProducts' );
            ?>
            <?php
            echo \f\ttt::block( 'cms.advertisement.getSocialAdvertise',
                [
                    'plan'     => 'C',
                    'plan2'    => 'MainPlan',
                    'location' => 'index'
                ] );
            ?>
            <?php
             echo \f\ttt::block( 'shop.product.getMustVisit' );
            ?>
        </div>
    </div>

    <div class="container-inner">
        <div class="row marg-top">
            <?php
            echo \f\ttt::block( 'cms.getTextTemplete' );
            ?>
        </div>
    </div>
    <?php
    echo \f\ttt::block ( 'shop.getBrandList',
        array (
            'limit'   => '5',
            'special' => 'enabled',
            'picture' => TRUE,
        ) ) ;
    ?>
</main>

<?php
include 'parts' . \f\DS . 'footerNew.php';
?>

