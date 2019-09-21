<footer>
    <?php
    $social = \f\ttt::service('cms.socialnet.getSocialnetSetting');
    $about = \f\ttt::service('cms.about.getAboutSetting');
    ?>
    <!--...................start for upFooter....................-->
    <div class="upFooter">
        <div class="container">
            <div class="timeWork">
                <p>    ساعت کاری : <?= \f\ifm::faDigit($social['timeWorke']); ?></p>
            </div>
            <div class="emailUpFooter">
                <i class="fa fa-envelope" aria-hidden="true"></i>
                <p><?= $social['email'] ?></p>

            </div>
            <div class="phoneUpFooter">
                <i class="fa fa-phone-square" aria-hidden="true"></i>
                <span><?= \f\ifm::faDigit( $social[ 'phone' ]) ?></span>

            </div>
        </div>
    </div>
    <!--...................end for upFooter....................-->
    <div class="footerMobile">
        <div class="container">
            <div class="row noMargin">
                <div class="col-sm-12 col-xs-12">
                    <div class="aboutUsFooterMobile">
                        <img src="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/img/logoFooter.png"
                             class="img-responsive"/>
                        <br/>
                        <span><?= $about['ShortContent'] ?></span>
                        <div class="col-sm-12 col-xs-12 ">
                            <div class="row">
                                <div class="SocialFooterMobile">
                                <a href="<?= $social['twitter'] ?>"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                                <a href="<?= $social['Facebook'] ?>"><i class="fa fa-facebook"
                                                                        aria-hidden="true"></i></a>
                                <a href="<?= $social['Google'] ?>"><i class="fa fa-google-plus" aria-hidden="true"></i></a>
                                <a href="<?= $social['Telegram'] ?>""><i class="fa fa-paper-plane"
                                                                         aria-hidden="true"></i></a>
                                <a href="<?= $social['Instagram'] ?>"> <i class="fa fa-instagram"
                                                                          aria-hidden="true"></i></a>
                            </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="raysanAdMobile">
                <span>

 طراحی و پیاده سازی توسط شرکت رایسان مجری
                    <br/>
                    <strong>
                        <a href="http://raysan.ir">طراحی سایت در اصفهان</a>
                    </strong>
</span>
        </div>
</footer>

<script type="text/javascript"
        src="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst-mobile/js/jquery.min.js"></script>

<script type='text/javascript'  src='<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/base/js/defaultCustom.js'></script>
<!--<script type="text/javascript"-->
<!--        src="--><?//= \f\ifm::app()->siteUrl ?><!--app/ui/templates/frontend/digifirst-mobile/js/scripts.js"></script>-->
<script type="text/javascript"
        src="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst-mobile/js/owl.carousel.js"></script>
<script type='text/javascript' src='<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/blazy.min.js'></script>
<script type='text/javascript'  src='<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/base/js/bootstrap.js'></script>
<script type='text/javascript' src='<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/jquery/jquery.validate.min.js'></script>

<script>
    /* Set the width of the side navigation to 250px */
    function openNav() {
        document.getElementById("mySidenav").style.right = "0px";
        document.getElementById("myCanvasNav").style.width = "100%";
        document.getElementById("myCanvasNav").style.opacity = "0.8";
        $('body').addClass('noscroll');
    }

    /* Set the width of the side navigation to 0 */
    function closeNav() {
        document.getElementById("mySidenav").style.right = "-999px";
        document.getElementById("myCanvasNav").style.width = "0%";
        document.getElementById("myCanvasNav").style.opacity = "0";
        $('body').removeClass('noscroll');

    }
    $("#mySidenav.header-menu-mobile>ul>li>ul>li:has('ul')").find("i.fa-caret-left:first").addClass("fa-plus-circle").removeClass("fa-caret-left");

    $("#mySidenav.header-menu-mobile>ul>li>a").on('click',function () {
        $("#mySidenav.header-menu-mobile>ul>li ul").hide();
        $("#mySidenav.header-menu-mobile>ul>li>a>i.fa-angle-up").addClass("fa-angle-down");
        $("#mySidenav.header-menu-mobile>ul>li>a>i.fa-angle-up").removeClass("fa-angle-up");
        var showUl=$(this).attr('class');
        if(showUl=="show-ul"){
            $("#mySidenav.header-menu-mobile>ul>li>a.show-ul").parent().find("ul").hide();
            $(this).removeClass('show-ul');
            $(this).find("i.fa-angle-up").addClass("change");
            $(this).find("i.change").removeClass("fa-angle-up");
            $(this).find("i.change").addClass("fa fa-angle-down");
            $(this).find("i.change").removeClass("change");

            $("#mySidenav.header-menu-mobile>ul>li>a").removeClass("show-ul");
        }else{
            $("#mySidenav.header-menu-mobile>ul>li>a").removeClass("show-ul");
            $("#mySidenav.header-menu-mobile>ul>li>ul>li:has('ul')").find("i.fa-minus-circle").addClass("fa-plus-circle").removeClass("fa-minus-circle");
            $(this).parent().find("ul:first").show();
            $(this).addClass('show-ul');
            $(this).find("i.fa-angle-down").addClass("change");
            $(this).find("i.change").removeClass("fa-angle-down");
           $(this).find("i.change").addClass("fa fa-angle-up");
            $(this).find("i.change").removeClass("change");
        }
    });
    $("#mySidenav.header-menu-mobile>ul>li>ul>li>i").on('click',function () {
        var plusClass=$(this).attr('class');
        console.log(plusClass);
        if(plusClass=="fa fa-plus-circle"){
            $(this).addClass("fa-minus-circle").removeClass("fa-plus-circle");
        }else{
            $(this).addClass("fa-plus-circle").removeClass("fa-minus-circle");
        }
        $(this).parent().find("ul").toggle();
    });

</script>

<script>
    $(document).ready(function () {
        var submitIcon = $('.searchbox-icon');
        var inputBox = $('.searchbox-input');
        var searchBox = $('.searchbox');
        var isOpen = false;
        submitIcon.click(function () {
            if (isOpen == false) {
                searchBox.addClass('searchbox-open');
                inputBox.focus();
                isOpen = true;
            } else {
                searchBox.removeClass('searchbox-open');
                inputBox.focusout();
                isOpen = false;
            }
        });
        submitIcon.mouseup(function () {
            return false;
        });
        searchBox.mouseup(function () {
            return false;
        });
        $(document).mouseup(function () {
            if (isOpen == true) {
                $('.searchbox-icon').css('display', 'block');
                submitIcon.click();
            }
        });
    });
    function buttonUp() {
        var inputVal = $('.searchbox-input').val();
        inputVal = $.trim(inputVal).length;
        if (inputVal !== 0) {
            $('.searchbox-icon').css('display', 'none');
        } else {
            $('.searchbox-input').val('');
            $('.searchbox-icon').css('display', 'block');
        }
    }


    $(document).ready(function () {

        var $owl = $('.servicesMobile');
        $('.servicesMobile').owlCarousel({
            rtl: true,
            loop: true,
            margin: 0,
            nav: true,
            dots: false,
            navText: ['<i class="fa fa-chevron-right">', '<i class="fa fa-chevron-left">'],
            responsive: {
                0: {
                    items: 2
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 4
                }
            }

        });

    });

</script>
<!--<!--..................mobile AND tablet.............-->

<script>
    $(document).ready(function () {
        $('#owl-demo5').owlCarousel({
            rtl: true,
            loop: true,
            margin: 0,
            nav: true,
            dots: false,
            autoplay: true,
            autoplayTimeout: 4000,
            autoplayHoverPause: true,
            navText: ['<i class="fa fa-chevron-right">', '<i class="fa fa-chevron-left">'],
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 1
                },
                1000: {
                    items: 1
                }
            }

        });

        $('.services-item1').owlCarousel({
            rtl: true,
            loop: true,
            margin: 10,
            nav: true,
            dots: false,
            navText: ['<i class="fa fa-chevron-right">', '<i class="fa fa-chevron-left">'],
            responsive: {
                0: {
                    items: 2
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 4
                }
            }

        });
    });
    $(window).load(function () {
        // Animate loader off screen
        //$(".loading-main").fadeOut("slow");
        //$('body').removeClass('noscroll');
        var bLazy = new Blazy();
        $('.services-item1').on('changed.owl.carousel', bLazy.revalidate);
        $('.myCarouselLogo').on('changed.owl.carousel', bLazy.revalidate);
        //$('.review-comments').on('changed.owl.carousel', bLazy.revalidate);
    });
    /****range Slider block *****/
    var rangeSlider = function(){
        var slider = $('.range-slider'),
            range = $('.range-slider__range'),
            value = $('.range-slider__value');

        slider.each(function(){
            value.each(function(){
                var value = $(this).prev().attr('value');
                $(this).html(value);
            });
            range.on('input', function(){
                $(this).next(value).html(this.value);
            });
        });
    };

    rangeSlider();
    widgetHelper.formSubmit('#rateSave');
    widgetHelper.formSubmit('#commentSave');
    widgetHelper.formSubmit('#registerForm');
    widgetHelper.formSubmit('#additionalInfoForm');

    widgetHelper.formSubmit('#contactform');

    $(document).ready(function () {
        var max_fields = 5;
        var min_fields = 1;
        var x = $('.strengthInput').length ? $('.strengthInput').length : 1;
        $('.button-add').click(function () {
            //we select the box clone it and insert it after the box
            if (x < max_fields) { //max input box allowed
                x++; //text box
                $('.box.empty').clone()
                    .show()
                    .removeClass("empty")
                    .css("display", "inline")
                    //                        .attr('name', 'strength[]')
                    .insertAfter(".box:last");
            }
        });
        $(document).on("click", ".button-remove", function () {
            if (x > min_fields) {
                $(this).closest(".box").remove();
                x--;
            }
        });
        var max_fields2 = 5;
        var min_fields2 = 1;
        var y = $('.weaknessInput').length ? $('.weaknessInput').length : 1;
        $('.button-adds').click(function () {
            //we select the box clone it and insert it after the box
            if (y < max_fields2) { //max input box allowed
                y++; //text box
                $('.boxs.empty').clone()
                    .show()
                    .removeClass("empty")
                    .css("display", "inline")
                    //                        .attr('name', 'weakness[]')
                    .insertAfter(".boxs:last");

            }
        });
        $(document).on("click", ".button-removes", function () {
            if (y > min_fields2) {
                $(this).closest(".boxs").remove();
                y--;
            }
        });
    });
</script>



<!--        end for owl-curouser...................-->
</body>

</html>