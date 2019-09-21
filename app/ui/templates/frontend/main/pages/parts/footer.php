<!-- page footer -->
<footer class="page-footer desktop-view" style="min-height: 200px">
    <?php
    $social = \f\ttt::service ( 'cms.socialnet.getSocialnetSetting') ;
    $about = \f\ttt::service ( 'cms.about.getAboutSetting' ) ;
    ?>
    
    <!--<a href="index.html#" id="top-link" class="top-link"><i class="fa fa-angle-double-up"></i></a>-->
    <div class="ginfo-bar">
        <div class="grid-row" style="margin: 0 auto;">
            <div class="col-md-4 col-sm-12">
                <div class="box-Support-text">
                    <span class="text-Support"> ساعات کاری : 9 صبح تا 9 شب </span>
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

    <div class="grid-row desktop-view" style="margin-bottom: 0px; margin-top:35px; color: #4d4d4d;">
        <div class="col-md-4">
            <div class="about-box-footer">
                <span>
                    <?php echo $about['content']?>
                </span>
            </div>
        </div>
        <div class="col-md-3 col-sm-12 col-xs-12">
            <div class="title-text-serise" style="margin-right:15px;">
                <span class="title-footer">در خبرنامه فروشگاه عضو شوید ....</span>
            </div>
            <div class="newsletter">
                <form style="margin-top : 25px;" method="post" action="<?= \f\ifm::app ()->siteUrl ?>newsletter/newsletterShareSave" class="clearfix" id="newsletterForm" novalidate="novalidate">

                    <input type="text" class="ltr" name="email" id="subscribe_email" value="" placeholder="آدرس ایمیل خود را وارد کنید" data-parsley-type="email">
                    <button value="Submit" type="submit" name="save" type="submit" class="btn btn-custom">ثبت</button>
                    <!--                    <div class="row">
                                                                        <div  style="margin-top: 5px">
                                                                            <input id="right-label" name="name" placeholder="نام خود را وارد کنید" type="text" class="form-control" data-parsley-required="">
                                                                        </div>
                                                                        <div style="margin-top: 5px" >
                                                                            <input id="right-label"  name="mobile" placeholder="شماره همراه خود را وارد کنید" type="text" class="form-control leftText" data-parsley-minlength="10" data-parsley-maxlength="11">
                                                                        </div>
                                                <div style="margin-top: 5px">
                                                    <input id="right-label" name="email" placeholder="آدرس ایمیل خود را وارد کنید" type="text" class="form-control leftText"  data-parsley-type="email">
                                                </div>
                                                <div style="margin-top: 5px">
                                                    <button value="Submit" style="margin-left: auto;" name="save" class=" dk-button button form-control" id="newsletterSubmit" type="submit">ثبت اشتراک</button>
                                                </div>
                                            </div>             -->
                </form>
            </div>
            <div class="social-outer">
                <span>شبکه های اجتماعی</span>
                <ul class="social" style="margin-top:10px;">
                    <?php
                    if ( $social[ 'Telegram' ] )
                    {
                        ?>
                        <li>
                            <a target="_blank" href="<?= $social[ 'Telegram' ] ?>" class="icon-social icon-telegram">
                                <i class="fa fa-paper-plane"></i>
                            </a>
                        </li>
                        <?php
                    }
                    ?>
                    <?php
                    if ( $social[ 'Facebook' ] )
                    {
                        ?>
                        <li>
                            <a target="_blank" href="<?= $social[ 'Facebook' ] ?>" class="icon-social icon-facebook">
                                <i class="fa fa-facebook"></i>
                            </a>
                        </li>
                        <?php
                    }
                    ?>
                    <?php
                    if ( $social[ 'Google' ] )
                    {
                        ?>
                        <li>
                            <a target="_blank" href="<?= $social[ 'Google' ] ?>" class="icon-social icon-google_plus" rel="publisher">
                                <i class="fa fa-google-plus"></i>
                            </a>
                        </li>
                        <?php
                    }
                    ?>
                    <?php
                    if ( $social[ 'twitter' ] )
                    {
                        ?>
                        <li>
                            <a target="_blank" href="<?= $social[ 'twitter' ] ?>" class="icon-social icon-twitter">
                                <i class="fa fa-twitter"></i>
                            </a>
                        </li>
                        <?php
                    }
                    ?>
                    <?php
                    if ( $social[ 'Instagram' ] )
                    {
                        ?>
                        <li>
                            <a target="_blank" href="<?= $social[ 'Instagram' ] ?>" class="icon-social icon-instagram">
                                <i class="fa fa-instagram"></i>
                            </a>
                        </li>
                        <?php
                    }
                    ?>
                    <?php
                    if ( $social[ 'email' ] )
                    {
                        ?>
                        <li>
                            <a target="_blank" href="<?= $social[ 'email' ] ?>" class="icon-social icon-email">
                                <i class="fa fa-envelope"></i>
                            </a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>

            <!--
<div class="social-panel">
    <ul class="social-linkbox">
        <li>
            <a href="#" title="فروشگاه رایسان">
                <i class="icon icon-footer-facebook"></i>
            </a>
        </li>
        <li>
            <a title="" href="#">
                <i class="icon icon-footer-twitter"></i>
            </a>
        </li>
        <li>
            <a title="" href="#">
                <i class="icon icon-footer-googleplus"></i>
            </a>
        </li>
        <li>
            <a title="" href="#">
                <i class="icon icon-footer-instagram"></i>
            </a>
        </li>
        <li>
            <a title="" href="#">
                <i class="icon icon-footer-aparat"></i>
            </a>
        </li>
        <li>
            <a title="" href="#">
                <i class="icon icon-footer-telegram"></i>
            </a>
        </li>
        <li class="app-icon-set">
            <a href="#" target="_blank"  title="android app">
                <i class="android-icon"></i> 
            </a>
        </li>
        <li class="app-icon-set">
            <a href="#" target="_blank"  title="ios app">
                <i class="ios-icon"></i>
            </a>
        </li>               
    </ul>

</div>
            -->
        </div>
        <?php
        echo \f\ttt::block ( 'cms.menu.getTopFooterMenu',
                             array (
            'name' => 'topFooter'
        ) ) ;
        ?>
        <div class="col-md-1">
            <div class="namad-box-footer" style="padding-top:17px;">
                <span style="font-size:15px;color:#0089ff;">نماد اعتماد</span>
                <img style="margin-top:25px" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/main/img/namad3.png" alt="پخش لوازم جانبی موبایل">
            </div>
        </div>


    </div>
    <!--    <div class="grid-row desktop-view" style="margin-bottom: 0px; margin-top:35px; color: #4d4d4d;">
    
    <?php
    echo \f\ttt::block ( 'cms.menu.getBottomFooterMenu',
                         array (
        'name' => 'bottomFooter'
    ) ) ;
    ?>
    
        </div>-->
</footer>
<div class="copyrights desktop-view">
    <div class="grid-row" style="margin-bottom: 0px">
        <span class="footer">
            <span id="copyright-full">کلیه حقوق این سایت متعلق به موبایل مرکزی اصفهان می باشد.</span>
        </span>
        <span class="footer" >طراحی و پیاده سازی توسط شرکت 
            <a href="http://raysan.ir">رایسان</a>
        </span>
    </div>
</div>

<!--/ page footer -->


</div>

<!-- scripts -->
<script>
    widgetHelper.formSubmit('#newsletterForm');

</script>




<script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/main/js/app.js"></script>
<!--
<script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/main/js/jquery-ui.min.js"></script>
<script type='text/javascript'  src='<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/base/js/bootstrap.js'></script>
<script type='text/javascript'   src='<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/main/js/vit-gallery.js'></script>
<script src="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/base/js/select/select2.js"></script>
<script src="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/base/js/select/select2_locale_fa.js"></script>
-->
<!--
<script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/main/js/jquery.migrate.min.js"></script>
-->
<!--
<script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/main/js/owl.carousel.min.js"></script>
-->
<!-- Superscrollorama -->
<!--
<script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/main/js/jquery.superscrollorama.js"></script>
<script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/main/js/TweenMax.min.js"></script>
<script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/main/js/TimelineMax.min.js"></script>
-->
<!--/ Superscrollorama -->
<!--
<script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/main/js/jquery.ui.core.min.js"></script>
<script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/main/js/jquery.ui.widget.min.js"></script>
<script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/main/js/jquery.ui.tabs.min.js"></script>
<script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/main/js/jquery-ui-tabs-rotate.js"></script>
<script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/main/js/jquery.ui.accordion.min.js"></script>
<script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/main/js/jquery.tweet.js"></script>
<script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/main/js/jquery.autocomplete.min.js"></script>
<script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/main/js/wow.min.js"></script>
-->

<!--
<script type='text/javascript' src='<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/confirm.js'></script>
<script type='text/javascript' src='<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/persian.js'></script>
<script type='text/javascript' src='<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/jquery/jquery.validate.min.js'></script>

<script src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/main/js/jquery.easing.1.3.js" type="text/javascript"></script>
<script src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/main/js/tms-0.3.js" type="text/javascript"></script>
<script src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/main/js/tms_presets.js" type="text/javascript"></script>
<script src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/main/js/Obj.min.js" type="text/javascript"></script>

<script src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/main/js/slick.js" type="text/javascript"></script>
<script src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/main/js/jssor.slider-21.1.6.mini.js" type="text/javascript"></script>
-->
<!--
<script type='text/javascript' src='<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/main/js/flipclock.js'></script>
<script type='text/javascript' src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/parsley/parsley.js"></script>

<script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/main/js/scripts.js"></script>
-->
<!--/ scripts -->



</body>
</html>