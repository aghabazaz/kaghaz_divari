<footer>
    <?php
    $social = \f\ttt::service('cms.socialnet.getSocialnetSetting');
    $about = \f\ttt::service('cms.about.getAboutSetting');
    ?>
    <!--...................start for upFooter....................-->
    <div class="upFooter">
        <div class="container">
            <div class="timeWork">
                <p>ساعات کاری : 9 صبح تا 9 شب</p>
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

<!--<script type="text/javascript"-->
<!--        src="--><?//= \f\ifm::app()->siteUrl ?><!--app/ui/templates/frontend/digifirst-mobile/js/scripts.js"></script>-->
<script type="text/javascript"
        src="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst-mobile/js/jquery.min.js"></script>
<script type='text/javascript'  src='<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/base/js/defaultCustom.min.js'></script>


<script type="text/javascript"
        src="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst-mobile/js/owl.carousel.js"></script>

<script type='text/javascript' src='<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/blazy.min.js'></script>

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

    function sendAddToCart() {
       //get price id from attribute data for check stock and add to user orders
        var priceId = $(".button-addToCart").attr("data");
        if(typeof  priceId == 'undefined'){
            priceId= $('#priceIdh').val();
        }

        var option = {
            priceId: parseInt(priceId),
            product_id: $('#product_id').val()
        };
        widgetHelper.tt('ui', 'shop.product.sendAddToCart', option, 'showResultAddCart');
    }
    function showResultAddCart(params)
    {
        if (params.result == 'error') {
            window.location.href = '<?= \f\ifm::app ()->siteUrl ?>login';
        } else if (params.result.message == 'notStock') {
            setTimeout(function () {
                widgetHelper.errorDialog('عدم موجودی');
                widgetHelper.closeDialog('errorDialog');
            }, 800);
            widgetHelper.removeLoading();
        } else {
            window.location.href = '<?= \f\ifm::app ()->siteUrl ?>cart';
        }
    }


    getGurantee($("input[name='colorSelect']:checked").val());
    function  getGurantee(value) {

        var option = {
            color_id: parseInt(value),
            product_id: $('#product_id').val()
        };
        widgetHelper.tt('ui', 'shop.product.getGuranteesByColorId', option, 'showResult')
    }
    function showResult(params) {

        $('#garanty').html(params.content);
        var id = $('#garanty').find("option:selected").val();
        if (params.countAvailable > 0) {
            $('span.ps1').text('fdgdf');
            $('.button-addCart').addClass('showBox');
            $('.button-addCart').removeClass('hiddenBox');
            $('.product_status .ps1').text('موجود');
        } else {
            $('span.ps1').text('fdgdf');
            $('.button-addCart').addClass('hiddenBox');
            $('.button-addCart').removeClass('showBox');

            $('.product_status .ps1').text('ناموجود');
        }
        $('.button-addToCart').attr('data', params.gurantee['idPrice'][id]);
        if (params.gurantee != 'NULL') {
            $('.products-waranty-text').show();
            $('.products-waranty-text1').hide();
        } else {
            $('.products-waranty-text').hide();
            $('.products-waranty-text1').show();
        }
//        $('.button-addToCart').attr('data', params.gurantee['idPrice'][id]);


        //console.log(params.gurantee["idPrice"][id]);
        $('#select_price').val(params.gurantee["idPrice"][id]);
    }
    $("#garanty").change(function () {
        var id =$('#garanty').find(":selected").val();
        var data_id =$('#garanty').find(":selected").attr("data-id");
        $('.button-addToCart').attr('data', data_id);
        //var values = JSON.parse($('#select_price').val());
        //$('.button-addToCart').attr('data', values['idPrice'][id]);
        //  alert('ds');
        // $('.button-addToCart').attr('data', values['idPrice'][id]);

    });

    $('.arrow-btn-box').on('click',function () {
        var className = $('.body-text').attr('class');
        var a=className.indexOf('open');
        if(a>0) {
            $('.arrow-btn-box').html('<i class="fa fa-angle-double-down arrow-btn" aria-hidden="true"></i>\n');
            $('.body-text').animate({'height': '40px'}, 0);
            $('.body-text').removeClass('open');
            $('.product_down_side').css('padding-bottom','10px');
        }else{
            $('.arrow-btn-box').html('<i class="fa fa-angle-double-up arrow-btn" aria-hidden="true"></i>\n');
            $('.body-text').animate({'height': '100%'},0);
            $('.body-text').addClass('open');
            $('.product_down_side').css('padding-bottom','10px');
        }
        });
    $( window ).scroll(function() {
        var topT=$( "div.product_down_side" ).offset().top;
        var heightDiv=$('.product_down_side').height();
        var topW =$(document).scrollTop();
        var top = (topT+heightDiv) - topW;
        if( top>40){
            $( "div.tab" ).css({'position':'relative','width':'100%','top':'0px'});
        }
        if( top<40){
            $( "div.tab" ).css({'position':'fixed','top':'40px','width':'100%','z-index':'99'});
        }
    });

</script>
<script>

    $(document).ready(function () {
        var divHeight = $('.container-cart').height();
        $('.tbody-2').css('height', divHeight);
        $('.tbody-3').css('height', $('.row-2').height());

        var divHeight2 = $('.way-send-product').height();
        $('.way-send-product-tbody').css('height', divHeight2);
    });
</script>
<script  type="text/javascript">
    $(".tab button.tablinks:first").addClass("active");
    $("#review.tabcontent").css("display","block");
    function openTab(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    $(document).ready(function () {
        $('#owl-demo').owlCarousel({
            rtl: true,
            loop: true,
            nav: true,
            dots: true,
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
                }
            }

        });

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
    })

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



</script>
<!--<!--..................mobile AND tablet.............-->

<script>

    $(window).load(function () {
        // Animate loader off screen
        //$(".loading-main").fadeOut("slow");
        //$('body').removeClass('noscroll');
        var bLazy = new Blazy();
        $('.services-item1').on('changed.owl.carousel', bLazy.revalidate);
        $('.myCarouselLogo').on('changed.owl.carousel', bLazy.revalidate);
        //$('.review-comments').on('changed.owl.carousel', bLazy.revalidate);
    });




    function goToRate() {
        widgetHelper.tt('ui', 'shop.product.goToRateOrLogin', {}, 'showResultGoToRate');
    }
    function showResultGoToRate(param) {
        if (param.result == 'success') {
            window.location.href = '<?= \f\ifm::app ()->siteUrl . 'rate/' . $row[ 'id' ] ?>';
        } else {
            window.location.href = '<?= \f\ifm::app ()->siteUrl ?>login';
        }
    }

</script>


<!--        end for owl-curouser...................-->
</body>

</html>