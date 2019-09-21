<?php
$title = $websiteInfo['title'];
$keywords = $websiteInfo['keywords'];
$description = $websiteInfo['description'];
$logo = \f\ifm::app()->fileBaseUrl . $websiteInfo['logo'];
$picture = $logo;
$shopSetting = \f\ttt::service('shop.shopSetting.getSettings');
include 'parts' . \f\DS . 'headerNew.php';
?>
<main>
        <!--&lt;!&ndash;...................start for slider.........&ndash;&gt;-->
        <div class="sliderMobile">
            <?php
            echo \f\ttt::block('cms.slide.getSlideList');
            ?>
        </div>

        <!--&lt;!&ndash;...................end for slider.........&ndash;&gt;-->

    <!--...................start for titleIndex.........-->
    <?php
    $settings = \f\ttt::service('cms.settings.getSettings');
    ?>
    <div class="container" style="margin-top: 20px;">
        <div class="vc_row wpb_row vc_row-fluid theme-container vc_custom_1505998143675 vc_row-has-fill vc_row-o-content-middle vc_row-flex">
            <div class="wpb_column vc_column_container vc_col-sm-12">
                <div class="vc_column-inner ">
                    <div class="wpb_wrapper">
                        <div class="cms-banner-item order-banner effect style-2">
                            <div class="cms-banner-inner">
                                <div class="cms-banner-img">
                                    <a class="image-link" target="_blank" href="http://demos.templatemela.com/woo/WCM03/WCM030051/WP1/product/led-interior-lighting/" title="خانه"></a>
                                    <span class="static-wrapper">
                                    <span class="static-inner">
                                        <span class="text2 static-text"><?= $settings['titleIndex']?></span>
                                    </span>
                                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--...................start for productNewest.........-->
    <div class="productNewestMobile">
        <div class="upLatestThing">
            <i class="fa fa-shopping-bag" aria-hidden="true"></i>
            <h3>جدیدترین محصولات</h3>
        </div>

        <div class="downLatestThing">
            <?php
            echo \f\ttt::block('shop.product.getNewProductsMobile');
            ?>
        </div>
    </div>
    <!--...................end for productNewest.........-->
<!--    <!--...................end for titleIndex.........-->-->
<!--                    <div class="discountIndexMobile">-->
<!--                        <div class="upLatestThing">-->
<!--                            <i class="fa fa-shopping-bag" aria-hidden="true"></i>-->
<!--                            <h3>تخفیفی ها</h3>-->
<!--                        </div>-->
<!---->
<!--                        <div class="downLatestThing">-->
<!--                            --><?php
//                            echo \f\ttt::block('shop.product.getAmazingSlideMobile',
//                                array(
//                                    'limit' => '8'));
//                            ?>
<!--                        </div>-->
<!--                    </div>-->
<!--    <!--...................end for discountIndex.........-->
    <!--...................start for tabletNewest.........-->

                    <?php
                    echo \f\ttt::block('shop.product.getNewMobileTablet');
                    ?>

    <!--...................end for mobileNewest.........-->



                </div>
            </div>
        </div>
</main>

<?php
include 'parts' . \f\DS . 'footerNew.php';
?>

