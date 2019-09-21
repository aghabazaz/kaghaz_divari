<?php $about = \f\ttt::service ( 'cms.about.getAboutSetting' ) ;
$social = \f\ttt::service ( 'cms.socialnet.getSocialnetSetting') ;
$settings = \f\ttt::service ( 'cms.settings.getSettings' ) ;
?>
<footer class="footer site-footer footer-opt-2">
    <div class="footer-column">
        <div class="container equal-container">
            <div class="row">
                <div class="col-lg-4 equal-elem">
                    <div class="logo-footer">
                        <a href="<?= \f\ifm::app ()->siteUrl ?>" title="سیک مارکت"><img src="<?= $pictureUrl ?>" title="سیک مارکت" alt="سیک مارکت"></a>
                    </div>
                    <p class="des-footer"><?= $about['ShortContent']?></p>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 equal-elem after-first">
                    <h3 class="title-of-footer"> تماس با ما </h3>
                    <div class="contacts">
                        <span class="contacts-icon info-address"></span><span class="contacts-info"> <?= $social['address']?> </span>
                        <span class="contacts-icon info-support"></span><span class="contacts-info"> <?= $social['email']?> </span>
                        <span class="contacts-icon info-phone"></span><span class="contacts-info">
								 <span class="ltr_text"><?= $social['phone']?></span></span>
                    </div>
                    <div class="footer-follow">
                        <ul>
                            <li><a class="facebook" href="<?= $social['Facebook']?>" target="_blank" title="فیسبوک"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                            <li><a class="twitter" href="<?= $social['twitter']?>" target="_blank" title="توییتر"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                            <li><a class="pinterest" href="<?= $social['Instagram']?>" target="_blank" title="اینستاگرام"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                            <li><a class="vk-plus" href="<?= $social['Telegram']?>" target="_blank" title="تلگرام"><i class="fa fa-paper-plane" aria-hidden="true"></i></a></li>
                            <li><a class="google-plus" href="<?= $social['Google']?>" target="_blank" title="گوگل پلاس"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6 equal-elem after-last">
                    <h3 class="title-of-footer"> نماد الکترونیکی </h3>
                    <div class="footer-tags-content">
<img src="https://trustseal.enamad.ir/logo.aspx?id=107337&amp;p=hJ4TwKnavqEBZHMX" alt="" onclick="window.open(&quot;https://trustseal.enamad.ir/Verify.aspx?id=107337&amp;p=hJ4TwKnavqEBZHMX&quot;, &quot;Popup&quot;,&quot;toolbar=no, location=no, statusbar=no, menubar=no, scrollbars=1, resizable=0, width=580, height=600, top=30&quot;)" style="cursor:pointer" id="hJ4TwKnavqEBZHMX">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container-inner">
            <div class="footer-copyright-left">
                <p>شرکت رایسان مجری <a href="http://raysan.ir" target="_blank" title="شرکت طراحی سایت رایسان">طراحی سایت در اصفهان . </a></p>
            </div>
        </div>
    </div>
</footer>

<!--/ page footer -->
</div>

<!-- scripts -->
<script type="text/javascript">

</script>
<?php
if($dynamicPro!='true') {
    ?>
    <script type="text/javascript"
            src="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/js/function.js"></script>
    <script type="text/javascript"
            src="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/js/jquery.magnific-popup.min.js"></script>
    <!--<script type="text/javascript" src="--><?//= \f\ifm::app ()->siteUrl
    ?><!--app/ui/templates/frontend/main/js/app.js"></script>-->
    <script type="text/javascript"
            src="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/js/owl.carousel.min.js"></script>
    <script type="text/javascript"
            src="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/js/owl.carousel.min.js"></script>
    <script type="text/javascript"
            src="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/js/owl.carousel2.thumbs.js"></script>

    <?php
}
 ?>


<?php
if($dynamicPro!='true') {
    ?>
    <!--/ scripts -->
    <script>
        widgetHelper.formSubmit('#newsletterForm');
        // menu on mobile
        $('.menu-on-mobile.hidden-mobile').click(function () {
            var hasActive = $(this).hasClass('active');
            if (hasActive) {
                $(this).removeClass('active');
                $('.header-nav.smarket-nav').removeClass('has-open');
            } else {
                $(this).addClass('active');
                $('.header-nav.smarket-nav').addClass('has-open');
            }
        });

        $(".header-nav .toggle-submenu").on('click', function () {
            $(this).parent().toggleClass('open-submenu');
            return false;
        });

        $(".box-vertical-megamenus .toggle-submenu").on('click', function () {
            $(this).parent().toggleClass('open-submenu');
            return false;
        });

        $(".header-menu .btn-close").on('click', function () {
            $('.header-nav').removeClass('has-open');
            return false;
        });
        /*----------------------------
        details-tab
        ------------------------------ */
        $('.details-tab').owlCarousel({
            rtl: true,
            loop: true,
            nav: true,
            margin: 10,
            navText: ['<i class="fa fa-arrow-right"></i>', '<i class="fa fa-arrow-left"></i>'],
            responsive: {
                0: {
                    items: 3
                },
                767: {
                    items: 4
                },
                1000: {
                    items: 4
                }
            }
        });
        /*----------------------------
        MagnificPopup
        ------------------------------ */
        $('.popup-link').magnificPopup({
            type: 'image',
            gallery: {
                enabled: true
            }
        });

        /*----------------------------
        Force owl nav show
        ------------------------------ */
        $('.owl-carousel').find('.owl-nav').removeClass('disabled');
        $('.owl-carousel').on('changed.owl.carousel resized.owl.carousel', function () {
            $(this).find('.owl-nav').removeClass('disabled');
        });
        /*----------------------------
        Fix product images select
        ------------------------------ */
        $(document).on('click', '.details-tab li', function () {
            $(this).closest('.details-tab').find('li').not($(this)).removeClass('active');
        });

        function search_keyword(url, type) {
            if (type == 'mobile') {
                var div = '-mobile';
            }
            else {
                div = '';
            }
            jQuery('#searchtxt' + div).keypress(function (e) {
                jQuery('#key' + div).val(e.which);
            });
            var loading = '<p style="text-align:right;color:gray;padding:5px">&nbsp;<img src="' + url + 'app/ui/templates/backend/default/images/loading2.gif" align="center" width="20px" height="20px">&nbsp;&nbsp;&nbsp;در حال جستجو....</p>';

            if (jQuery('#searchtxt' + div).val()) {
                if (jQuery('#key' + div).val() != 0 && jQuery('#key' + div).val() != 13) {
                    jQuery('#result_search' + div).html(loading);

                    if (jQuery('#result_search' + div).css('display') == "none") {
                        jQuery("#result_search" + div).slideDown("fast");
                    }
                }

            } else {
                jQuery("#result_search" + div).slideUp("fast");
            }
            if (jQuery('#searchtxt' + div).val().length >= 2) {
                //go to method controller productController
                var base_url = url + "cms/getAjaxSearchAllIndex";
                jQuery.post(base_url, {keyword: jQuery('#searchtxt' + div).val()}
                    , function (data) {

                        jQuery('#result_search' + div).html(data);
                        if (jQuery('#searchtxt' + div).val()) {
                            var divs = jQuery('.result'),
                                selectedDiv,
                                i;
                            //console.log(selectedDiv);
                            if (divs.length < jQuery('#selectDiv' + div).val()) {
                                selectedDiv = 0;
                            } else {
                                selectedDiv = jQuery('#selectDiv' + div).val();
                            }

                            for (i = 0; i < divs.length; i++) {
                                divs[i].onmouseover = (function (i) {

                                    return function () {

                                        divs[selectedDiv].style.backgroundColor = '';
                                        divs[selectedDiv].style.borderTop = "1px solid #e4e4e4";
                                        divs[selectedDiv].style.borderBottom = "1px solid #e4e4e4";
                                        selectedDiv = i;
                                        divs[selectedDiv].style.backgroundColor = '#EEF9FF';
                                        divs[selectedDiv].style.borderTop = "1px solid #e4e4e4";
                                        divs[selectedDiv].style.borderBottom = "1px solid #e4e4e4";

                                        jQuery('#selectDiv' + div).val(selectedDiv);
                                    }
                                })(i);
                            }
                            divs[selectedDiv].style.backgroundColor = '#EEF9FF';
                            divs[selectedDiv].style.borderTop = "1px solid #gray";
                            divs[selectedDiv].style.borderBottom = "1px solid #gray";
                            jQuery('#searchtxt' + div).keydown(function (e) {
                                if (e.keyCode == 38) {
                                    x = -1;
                                } else if (e.keyCode == 40) {
                                    x = 1;
                                } else if (e.keyCode == 13) {
                                    document.location = jQuery('#' + selectedDiv).attr('href');
                                    return;
                                } else {
                                    return;
                                }
                                divs[selectedDiv].style.backgroundColor = '';
                                divs[selectedDiv].style.borderTop = "1px solid white";
                                divs[selectedDiv].style.borderBottom = "1px solid white";

                                selectedDiv = ((parseInt(selectedDiv) + x) % divs.length);

                                selectedDiv = selectedDiv < 0 ? divs.length + selectedDiv : selectedDiv;
                                jQuery('#selectDiv' + div).val(selectedDiv)


                                divs[selectedDiv].style.backgroundColor = '#EEF9FF';
                                divs[selectedDiv].style.borderTop = "1px solid #gray";
                                divs[selectedDiv].style.borderBottom = "1px solid #gray";
                            });

                            jQuery('#searchtxt' + div).focus();
                        }
                    });
            }
        }

        //END Block search BOX suggestion
    </script>
    <?php
}
?>

</body>
</html>