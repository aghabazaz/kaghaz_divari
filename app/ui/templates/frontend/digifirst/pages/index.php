<?php
/*در این پروژه محصولات به دو شکل مختلف می تواند باشد حالت اول برای محصولاتی است که تصاویر آنها قابل برش هستند
 و می توان آپشنهایی را برای تغییر اندازه و رنگ تصویر مشخص نمود
 به طوری که قیمت محصول پس از مشخص نمودن اندازه تصویر و جنس تشکیل دهنده آن مشخص می شود که اصولا این حالت برای محصولاتی که اندازه محصول مهم است
 مثل کاغذ دیواری به کار می رود و حالت دوم مثل پروژه های قبل است که تصاویر به صورت ثابت است و انعطافی در مشخص کردن آنها نیست
 برای مشخص کردن نوع محصولات بایستی از دسته بندی محصولات کمک گرفت اگر دسته بندی محصولات از نوع داینامیک باشد
 تصاویر آنها به صورت حالت اول است و اگر تیک داینامیک بودن تصویر محصولات نزده شده باشد محصولات از نوع حالت دوم است*/

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
include 'parts' . \f\DS . 'headerNewIndex.php';
?>
<div role="main" class="main">
  <?php
    echo \f\ttt::block( 'cms.slide.getSlideList' );
    ?>

    <section id="start" class="section call-to-action bg-light-5 call-to-action-height-2">
        <div class="container">
            <div class="row">

                <div class="col-lg-12 mb-md-4 mb-lg-0 appear-animation" data-appear-animation="fadeInRightShorter">
                    <div class="call-to-action-content">
                        <h1 class="font-weight-bold text-3">
                        <?= $settings['titleIndexH1'] ?>
                         </h1>
                        <h2 class="font-weight-light mb-0">
                            <?=$settings['titleIndexH2']?>
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
    echo \f\ttt::block('shop.category.getCategorySpecial' );
    ?>

    <section class="section p-0" style="direction:rtl;margin-top:50px;">
        <div class="container">
            <div class="row text-center">
                <div class="col-12">
                    <div class="overflow-hidden mb-2">
                        <h2 class="font-weight-bold mb-0 appear-animation" data-appear-animation="maskUp"> جدیدترین محصولات </h2>
                    </div>
                </div>
            </div>
        </div>
        <?php
        echo \f\ttt::block( 'shop.category.getCategoryPro' );
        ?>
    </section>

    <?php
    echo \f\ttt::block('cms.contentListMain' );
    ?>

    <?php
   echo \f\ttt::block('cms.getAboutMainPage' );
    ?>

    <section id="team" class="section nav-secondary-dark pt-4">
        <div class="container">
            <div class="row appear-animation" data-appear-animation="fadeInUpShorter" data-appear-animation-delay="1000">

            </div>
        </div>
    </section>

</div>
<?php
include 'parts' . \f\DS . 'footerNewIndex.php';
?>

