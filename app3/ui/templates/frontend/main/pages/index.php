<?php
$title       = $websiteInfo[ 'title' ] ;
$keywords    = $websiteInfo[ 'keywords' ] ;
$description = $websiteInfo[ 'description' ] ;
$logo        = \f\ifm::app ()->fileBaseUrl . $websiteInfo[ 'logo' ] ;
$picture     = $logo ;
$shopSetting = \f\ttt::service ( 'shop.shopSetting.getSettings' ) ;
include 'parts' . \f\DS . 'header.php' ;
?>
<div class="grid-row" style="margin-top : 10px; direction: rtl;">
    <div>
        <div id="slider1" class="slider-wrapper-slider">
            <?php
            echo \f\ttt::block ( 'cms.slide.getSlidetList' ) ;
            ?>
            <div class="hover_arrow">
                <a  href="#" class="backwardSlider prevSlider " ></a>
                <a  href="#" class="forwardSlider nextSlider "></a>
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

    </div>
    <div class="row">
        <div class="col-md-3 col-sm-3  right-content desktop-view">
            <?php
            echo \f\ttt::block ( 'cms.advertisement.getAdvertise',
                                 array (
                'limit'    => '7',
                'plan'     => 'C',
                'location' => 'index'
            ) ) ;
            ?> 
            <div class="news-box" style="margin-bottom: 10px">
                <div class="header-news">
                    <i class="fa fa-newspaper-o icon-index-shop" aria-hidden="true"></i><span>تازه ترین خبرها</span>
                </div>
                <?php
                echo \f\ttt::block ( 'cms.news.newsList' ) ;
                // \f\pre(\f\ttt::block ( 'cms.news.newsList' ));
                ?>
                <footer class="boxmore rtl">
                    <a href="<?= \f\ifm::app ()->siteUrl . 'news/' ?>">مشاهده خبرهای بیشتر</a>
                </footer>
            </div> 
            <div class="brand-box">
                <?php
//                echo \f\ttt::block ( 'shop.getBrandList',
//                                     array (
//                    'limit'   => '6',
//                    'special' => 'enabled',
//                    'picture' => TRUE,
//                ) ) ;
//                
                ?> 
            </div>
         

        </div>
        <div class="col-md-9  col-sm-9  left-content">
            <div class="h-tag-seo">
            <h1><?= $shopSetting['mainPageText']?></h1>
            </div>
            <div class="clearfix"></div>
            <div class="news-box" style="direction: ltr ;">
                <div class="box" id="off-products-section">
                    <div class="content" style="margin:0px;">
                        <div class="content_header clearfix">
                            <h4>تخفیفی ها</h4>
                            <i class="fa fa-angle-double-left" style="padding-right:5px;"></i><a href="<?= \f\ifm::app ()->siteUrl ?>product/off" class="section-link">لیست کامل</a>
                        </div>
                        <div class="content_body clearfix">
                            <div class="products-section">
                                <div class="products-body owl-carousel owl-theme" style="opacity: 1; display: block;">
                                    <div class="owl-wrapper-outer">
                                        <div class="owl-wrapper" style="width: 764px; right: 0px; direction: rtl; display: block;">
                                            <div>
                                                <?php
                                                echo \f\ttt::block ( 'shop.product.getAmazingSlide',
                                                                     array (
                                                    'limit' => '4' ) ) ;
                                                ?>  
                                            </div>
                                        </div>
                                    </div>
                                    <div class="owl-controls clickable" style="display: none;">
                                        <div class="owl-buttons">
                                            <div class="owl-prev disabled">prev</div>
                                            <div class="owl-next disabled">next</div> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>

            <?php
            echo \f\ttt::block ( 'shop.product.getNewOneProduct' ) ;
            ?>                                            
            <div class="clearfix"></div>
            <div class="news-box" style="direction: ltr ; margin-top: 15px;">
                <div class="header-news">           
                    <span>تازه ترین محصولات</span>
                    <i class="fa fa-shopping-bag icon-index-shop" aria-hidden="true"></i>   
                </div>
                <div data-slick='{"slidesToShow": 4, "slidesToScroll": 4}' class="sliderFooter" style="width:90%;margin: 0 auto;margin-top: 20px ; ">
                    <?php
                    echo \f\ttt::block ( 'shop.product.getNewProducts' ) ;
                    ?>                       
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="Products-offer">
                <!--                            <div class="col-sm-4 set-col-Products">      
                                                <div class="small-Products">
                <?php
                echo \f\ttt::block ( 'cms.advertisement.getAdvertise',
                                     array (
                    'limit' => '3',
                    'plan'  => 'A'
                ) ) ;
                ?> 
                                                </div>
                                            </div>-->
                <div class=" set-col-big-Products">
                    <div class="big-Products">
                        <!--<?php
                        echo \f\ttt::block ( 'cms.advertisement.getAdvertise',
                                             array (
                            'limit' => '6',
                            'plan'  => 'B'
                        ) ) ;
                        ?> -->

<!--                        <div class="clearfix"></div>-->
<!--                        --><?php
//                        echo \f\ttt::block ( 'shop.getBrandList',
//                                             array (
//                            'limit'   => '5',
//                            'special' => 'enabled',
//                            'picture' => TRUE,
//                        ) ) ;
//                        ?>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <!--    <div class="news-box" style="direction: ltr ; margin-top: 15px;">
            <div class="header-news">
    
                <span>پرفروش ترین محصولات</span>
                <i class="fa fa-diamond icon-index-shop" aria-hidden="true"></i>
    
            </div>
            <div data-slick='{"slidesToShow": 4, "slidesToScroll": 4}' class="sliderFooter" style="width:90%;margin: 0 auto;margin-top: 20px">
    <?php
    echo \f\ttt::block ( 'shop.product.getProductBestselling' ) ;
    ?>                       
            </div>
        </div>-->
</div>
<!-- page footer -->
<footer class="page-footer mobile-view">
    <?php
    $social = \f\ttt::service ( 'cms.socialnet.getSocialnetSetting',
                                array (
            ) ) ;
    ?>
    <!--<a href="index.html#" id="top-link" class="top-link"><i class="fa fa-angle-double-up"></i></a>-->
    <div class="ginfo-bar">
        <div class="grid-row" style="margin: 0 auto;">
            <div class="col-md-4 col-sm-12">
                <div class="box-Support-text">
                    <span class="text-Support"> ۷ روز هفته، ۲۴ ساعته پاسخگوی شما هستیم.</span>
                </div>
            </div>
            <div class="col-md-8 col-sm-12">
                <div class="navbar-info" >
                    <ul class="left-info-bar"> 

                        <li>
                            <span><?= $social[ 'email' ] ?></span>
                            <i class="fa fa-envelope-o"></i>
                        </li>
                        <li style="direction: ltr">
                            <i class="fa  fa-phone"></i>
                            <a href="<?= \f\ifm::app ()->siteUrl ?>contactUs"><span class="fa-digit"><?= $social[ 'phone' ] ?></span>
                                <!--<span> | </span><span>۹٥۱۱۹۰۹٥ - ۰۲۱</span>-->
                            </a>
                        </li> 
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>

<?php
include 'parts' . \f\DS . 'footer.php' ;
?>

<script type="text/javascript">

    $(window).load(function () {
        $('.sliderIndex')._TMS({
            duration: 0,
            easing: '',
            preset: 'img1',
            slideshow: 10000,
            banners: true,
            pauseOnHover: true,
            pagination: '.pagination_slider',
            pagNums: false,
            prevBu: '.prevSlider',
            nextBu: '.nextSlider',
        });
    });
    var origWidth = 1820;
    var origHeight = 670;
    var ratio = origHeight / origWidth;
    calcWH($('#slider1').width());
    function calcWH(width)
    {
        var newWidth = width;
        var newHeight = parseInt(ratio * width);
        $('.sliderIndex,.pic2').css('width', newWidth + 'px');
        $('.sliderIndex,.pic2').css('height', newHeight + 'px');
    }
    $(window).resize(function () {
        var width = $('#slider1').width();
        calcWH(width);
    });
    $(document).ready(function () {
        $(".arrow_show , .backwardSlider , .forwardSlider").hover(function () {
            $(".backwardSlider,.forwardSlider").css("opacity", "1");
        }, function () {
            $(".backwardSlider,.forwardSlider").css("opacity", "0");
        });
    });


    jQuery(document).ready(function ($) {

        var jssor_2_options = {
            $AutoPlay: true,
            $AutoPlayInterval: 6000,
            $DragOrientation: 2,
            $PlayOrientation: 2,
            $ThumbnailNavigatorOptions: {
                $Class: $JssorThumbnailNavigator$,
                $Cols: 9,
                $Orientation: 2,
                $Align: 0,
                $NoDrag: true
            }
        };

        var jssor_2_slider = new $JssorSlider$("jssor_2", jssor_2_options);

        /*responsive code begin*/
        /*you can remove responsive code if you don't want the slider scales while window resizing*/
        function ScaleSlider() {
            var refSize = jssor_2_slider.$Elmt.parentNode.clientWidth;
            if (refSize) {
                refSize = Math.min(refSize, 700);
                jssor_2_slider.$ScaleWidth(refSize);
            } else {
                window.setTimeout(ScaleSlider, 30);
            }
        }
        ScaleSlider();
        $(window).bind("load", ScaleSlider);
        $(window).bind("resize", ScaleSlider);
        $(window).bind("orientationchange", ScaleSlider);
        /*responsive code end*/
    });
</script>
<style>
    .content {
        text-align: justify;
        line-height: 25px;
        padding: 10px 20px;
        border-radius: 4px;
        background-color: #ffffff;
        overflow: hidden;
    }
    .content .content_header {
        padding: 0px 10px;
        color: #0089ff;
        display: block;
    }
    .content .content_body {
        background-color: #ffffff;
        text-align: justify;
        line-height: 25px;
    }
    .content .content_header h1, .content .content_header h2, .content .content_header h4, .content .content_header b.btitle, .content .content_header .content_title {
        width: auto;
        float: right;
        line-height: 36px;
        font-size: 16px;
    }
    .products-section {
        overflow: hidden;
        padding: 10px 25px;
    }
    .owl-carousel .owl-wrapper-outer {
        overflow: hidden;
        position: relative;
        width: 100%;
    }
    .products-section .owl-wrapper-outer {
        padding: 5px 0;
    }
    .wrapper .owl-carousel .owl-item {
        float: right;
    }
    .products-section .owl-item {
        padding: 0 5px;
    }
    .products-section .product_thumb {
        float: none;
        margin: 0 0;
        position: relative;
        transition: all 0.2s ease-in-out;
    }
    .thumb_body {
        overflow: hidden;
        text-align: center;
    }
    .imagelink {
        display: block;
        height: auto;
        text-align: center;
    }
    .box img {
        max-width: 100%;
    }
    .product-link h3, .product-link h2 {
        height: 25px;
        overflow: hidden;
        margin-top: 10px;
        text-align: center;
        color: #595959;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .thumb_subtitle {
        overflow: hidden;
        color: #7b7b7b;
        font-size: 12px;
        line-height: 16px;
        text-align: right;
        height: 48px;
        margin-bottom: 10px;
    }
    .product_thumb_price {
        height: 28px;
        font-family: Font1, Arial;
        color: #707070;
    }
    .product_thumb_badges {
        top: -5px;
        left: 5px;
        position: absolute;
        z-index: 9;
    }

    .product_thumb_badges .thumb_badge.badge_off {
        background-color: #0089ff;
    }
    .product_thumb_badges .thumb_badge {
        float: left;
        margin-left: 0;
        margin-right: 8px;
        padding: 2px 0 0;
        color: #fff;
        border-radius: 0;
        width: 40px;
        -webkit-transform: rotate(-3deg);
        -moz-transform: rotate(-3deg);
        -ms-transform: rotate(-3deg);
        -o-transform: rotate(-3deg);
        transform: rotate(-3deg);
        border-radius: 0 0 0 5px/30px;
        position: relative;
        padding-bottom: 3px;
    }
    .product_thumb_badges .thumb_badge.badge_off::after {
        content: "حراج";
    }
    .product_thumb_badges .thumb_badge.badge_off:before {
        border-left: 5px solid #1d8fa8;
    }
    .product_thumb_badges .thumb_badge:before {
        content: "";
        display: block;
        position: absolute;
        top: 0px;
        right: -10px;
        border-top: 6px solid transparent;
        border-right: 5px solid transparent;
        border-bottom: 0px solid transparent;
    }
    .product_off {
        position: absolute;
        top: 0px;
        right: 0;
        color: #fff;
        background: red;
        border-radius: 100%;
        width: 30px;
        height: 30px;
        line-height: 32px;
        transform: rotate(20deg);
        font-size: 13px;
        -webkit-transition: All .2s ease-in-out;
        -moz-transition: All .2s ease-in-out;
        -o-transition: All .2s ease-in-out;
    }
    .owl-item:hover .product_off{
        -webkit-transition: All .2s ease-in-out;
        -moz-transition: All .2s ease-in-out;
        -o-transition: All .2s ease-in-out;
        transform: rotate(0deg);
    }
    img.product_thumb_image.lazyOwl {
        border-top: rgba(213, 215, 217, 0.41) solid 1px;
    }
    .h-tag-seo {
        text-align: right;
        margin-bottom: 25px;
        padding-top: 12px;
        font-size: 16px;
        color: #424144;
    }
</style>