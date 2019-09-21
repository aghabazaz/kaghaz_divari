<?php
$about = \f\ttt::service ( 'cms.about.getAboutSetting' ) ;
$social = \f\ttt::service ( 'cms.socialnet.getSocialnetSetting') ;
?>
<footer id="footer" class="bg-dark-2 footer-hover-links-light mt-0">
    <div class="footer-column">
        <div class="container equal-container">
            <div class="row">
                <div class="col-lg-4 equal-elem">
                    <div class="logo-footer">
                        <a href="<?= \f\ifm::app ()->siteUrl ?>" title="سیک مارکت"><img src="<?= $pictureUrl ?>" alt="سیک مارکت" title="سیک مارکت"></a>
                    </div>
                    <div class="des-footer"><?= $about['ShortContent']?></div>
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
                            <li><a class="facebook" href="<?= $social['Facebook']?>" title="فیسبوک" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                            <li><a class="twitter" href="<?= $social['twitter']?>" title="توییتر" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                            <li><a class="pinterest" href="<?= $social['Instagram']?>" title="اینستاگرام" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                            <li><a class="vk-plus" href="<?= $social['Telegram']?>" title="تلگرام" target="_blank"><i class="fa fa-paper-plane" aria-hidden="true"></i></a></li>
                            <li><a class="google-plus" href="<?= $social['Google']?>" title="گوگل پلاس" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-sm-6 equal-elem after-last">
                    <h3 class="title-of-footer"> نماد الکترونیکی </h3>
                    <img src="https://trustseal.enamad.ir/logo.aspx?id=115696&;p=vz5HFGb7WR0x39Vd" alt="" onclick="window.open(&quot;https://trustseal.enamad.ir/Verify.aspx?id=115696&;p=vz5HFGb7WR0x39Vd&quot;, &quot;Popup&quot;,&quot;toolbar=no, location=no, statusbar=no, menubar=no, scrollbars=1, resizable=0, width=580, height=600, top=30&quot" style="cursorointer" id="vz5HFGb7WR0x39Vd"> </div>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            <div class="row text-center text-md-left align-items-center">
                <div class="col">
                    <p class="text-md-right pb-0 mb-0">شرکت رایسان مجری <a href="http://raysan.ir" target="_blank" title="شرکت طراحی سایت رایسان">طراحی سایت در اصفهان  </a></p>
                </div>
            </div>
        </div>
    </div>

</footer>
</div>
<script type="text/javascript"  src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/scripts.js"></script>


<!--<script type="text/javascript"  src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/jquery.min.js"></script>-->
<!--<script type="text/javascript"  src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/jquery.appear.min.js"></script>-->
<script type="text/javascript"  src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/bootstrap.bundle.min.js"></script>
<!--<script type="text/javascript"  src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/common.min.js"></script>-->
<script type='text/javascript'   src='<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/js/jquery.isotope.min.js'></script>
<!--<script type='text/javascript'   src='<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/js/owl.carousel.min.js'></script>-->
<script type='text/javascript'   src='<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/js/theme.js'></script>
<script type='text/javascript'   src='<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/js/theme.init.js'></script>


<!-- scripts -->
<script type="text/javascript">
    (function ($) {
        "use strict"; // Start of use strict
        // MENU REPONSIIVE
        function smarket_menu_reposive() {
            var kt_is_mobile = (Modernizr.touch) ? true : false;
            if (kt_is_mobile === true) {
                $(document).on('click', '.smarket-nav .menu-item-has-children >a', function (e) {
                    var licurrent = $(this).closest('li');
                    var liItem = $('.smarket-nav .menu-item-has-children');
                    if (!licurrent.hasClass('show-submenu')) {
                        liItem.removeClass('show-submenu');
                        licurrent.parents().each(function () {
                            if ($(this).hasClass('menu-item-has-children')) {
                                $(this).addClass('show-submenu');
                            }
                            if ($(this).hasClass('main-menu')) {
                                return false;
                            }
                        })
                        licurrent.addClass('show-submenu');
                        // Close all child submenu if parent submenu is closed
                        if (!licurrent.hasClass('show-submenu')) {
                            licurrent.find('li').removeClass('show-submenu');
                        }
                        return false;
                        e.preventDefault();
                    } else {
                        licurrent.removeClass('show-submenu');
                        var href = $(this).attr('href');
                        if ($.trim(href) == '' || $.trim(href) == '#') {
                            licurrent.toggleClass('show-submenu');
                        } else {
                            window.location = href;
                        }
                    }
                    // Close all child submenu if parent submenu is closed
                    if (!licurrent.hasClass('show-submenu')) {
                        licurrent.find('li').removeClass('show-submenu');
                    }
                    e.stopPropagation();
                });
                $(document).on('click', function (e) {
                    var target = $(e.target);
                    if (!target.closest('.show-submenu').length || !target.closest('.smarket-nav').length) {
                        $('.show-submenu').removeClass('show-submenu');
                    }
                });
                // On Desktop
            } else {
                $(document).on('mousemove', '.smarket-nav .menu-item-has-children', function () {
                    $(this).addClass('show-submenu');
                    if ($(this).closest('.smarket-nav').hasClass('main-menu')) {
                        $('body').addClass('is-show-menu');
                    }
                })
                $(document).on('mouseout', '.smarket-nav .menu-item-has-children', function () {
                    $(this).removeClass('show-submenu');
                    $('body').removeClass('is-show-menu');
                })
            }
        }
        //Menu Sticky
        function smarket_sticky_product() {
            var scrollUp = 0;
            $(window).scroll(function (event) {
                var scrollTop = $(this).scrollTop();
                var height_single_left = $('.single-left').outerHeight() - $('.summary').outerHeight();
                //Remove summary sticky
                if (scrollTop > height_single_left) {
                    $('.summary').addClass('remove-sticky-detail-half')
                } else {
                    $('.summary').removeClass('remove-sticky-detail-half');
                }
                if (scrollTop > height_single_left) {
                    $('.summary').addClass('remove-sticky-detail')
                } else {
                    $('.summary').removeClass('remove-sticky-detail');
                }
                scrollUp = scrollTop;
            })
        }
        // Resize mega menu
        function smarket_resizeMegamenu() {
            var window_size = jQuery('body').innerWidth();
            window_size += smarket_get_scrollbar_width();
            if (window_size > 1024) {
                if ($('.site-header .header-menu').length > 0) {
                    var container = $('.site-header .header-menu');
                    if (container != 'undefined') {
                        var container_width = 0;
                        container_width = container.innerWidth();
                        var container_offset = container.offset();
                        setTimeout(function () {
                            $('.header-menu .item-megamenu').each(function (index, element) {
                                $(element).children('.megamenu').css({
                                    'width': container_width + 'px'
                                });
                                var sub_menu_width = $(element).children('.megamenu').outerWidth();
                                var item_width = $(element).outerWidth();
                                $(element).children('.megamenu').css({
                                    'left': '-' + (sub_menu_width / 2 - item_width / 2) + 'px'
                                });
                                var container_left = container_offset.left;
                                var container_right = (container_left + container_width);
                                var item_left = $(element).offset().left;
                                var overflow_left = (sub_menu_width / 2 > (item_left - container_left));
                                var overflow_right = ((sub_menu_width / 2 + item_left) > container_right);
                                if (overflow_left) {
                                    var left = (item_left - container_left);
                                    $(element).children('.megamenu').css({
                                        'left': -left + 'px'
                                    });
                                }
                                if (overflow_right && !overflow_left) {
                                    var left = (item_left - container_left);
                                    left = left - (container_width - sub_menu_width);
                                    $(element).children('.megamenu').css({
                                        'left': -left + 'px'
                                    });
                                }
                            })
                        }, 100);
                    }
                }
            }
        }

        function smarket_get_scrollbar_width() {
            var $inner = jQuery('<div style="width: 100%; height:200px;">test</div>'),
                $outer = jQuery('<div style="width:200px;height:150px; position: absolute; top: 0; left: 0; visibility: hidden; overflow:hidden;"></div>').append($inner),
                inner = $inner[0],
                outer = $outer[0];
            jQuery('body').append(outer);
            var width1 = inner.offsetWidth;
            $outer.css('overflow', 'scroll');
            var width2 = outer.clientWidth;
            $outer.remove();
            return (width1 - width2);
        }
        //Auto width vertical menu
        function smarket_auto_width_vertical_menu() {
            var full_width = parseFloat($('.container-inner').actual('width'));
            var menu_width = parseFloat($('.vertical-menu-content').actual('width'));
            var w = (full_width - menu_width);
            $('.vertical-menu-content').find('.megamenu').each(function () {
                $(this).css('width', w + 'px');
            });
        }
        /* ---------------------------------------------
         Scripts initialization
         --------------------------------------------- */
        $(window).load(function () {
            smarket_resizeMegamenu();
            better_equal_elems();
            smarket_sticky_product();
        });



        /* ---------------------------------------------
         Scripts ready
         --------------------------------------------- */
        $(document).ready(function () {
            // menu on mobile
            $('.menu-on-mobile.hidden-mobile').click(function () {
                var hasActive=$(this).hasClass('active');
                if(hasActive){
                    $(this).removeClass('active');
                    $('.header-nav.smarket-nav').removeClass('has-open');
                }else{
                    $(this).addClass('active');
                    $('.header-nav.smarket-nav').addClass('has-open');
                }
            });

            // vertical megamenu click
            $(".box-vertical-megamenus .title").on('click', function () {
                $(this).toggleClass('active');
                $(this).parent().toggleClass('has-open');
                return false;
            });
            $(".vertical-menu-content .btn-close").on('click', function () {
                $('.box-vertical-megamenus').removeClass('has-open');
                return false;
            });

        });
    })(jQuery);

    // End of use strict

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

<script>
    document.getElementById('closeModel').onclick = function() {

        document.getElementById('myModal').style.display = "none";
    }
    document.getElementById('picField').onchange = function (evt) {
        var tgt = evt.target || window.event.srcElement,
            files = tgt.files;
        // FileReader support
        if (FileReader && files && files.length) {
            var fr = new FileReader();
            fr.onload = function () {
                document.getElementById('outImage').src = fr.result;
            }
            fr.readAsDataURL(files[0]);
        }
        else {
            // fallback -- perhaps submit the input to an iframe and temporarily store
            // them on the server until the user's session ends.
        }
    }
    widgetHelper.formSubmit('#customRequest');
    $('.dropdown-menu-toggle').hover(function () {
        $('.dropdown-menu').toggle();
    });
</script>
</body>
</html>