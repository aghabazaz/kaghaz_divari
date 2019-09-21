<?php
$about = \f\ttt::service ( 'cms.about.getAboutSetting' ) ;
$social = \f\ttt::service ( 'cms.socialnet.getSocialnetSetting') ;
?>
<footer class="footer site-footer footer-opt-2">
    <div class="footer-column">
        <div class="container equal-container">
            <div class="row">
                <div class="col-lg-4 equal-elem">
                    <div class="logo-footer">
                        <a href="<?= \f\ifm::app ()->siteUrl ?>" title="سیک مارکت"><img src="<?= $pictureUrl ?>" alt="سیک مارکت" title="سیک مارکت"></a>
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
        <div class="container-inner">
            <div class="footer-copyright-left">
                <p>شرکت رایسان مجری <a href="http://raysan.ir" target="_blank" title="شرکت طراحی سایت رایسان">طراحی سایت در اصفهان  </a></p>
            </div>
        </div>
    </div>

</footer>

<script type="text/javascript"  src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/jquery-2.1.4.min.js"></script>
<script type='text/javascript'   src='<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/base/js/bootstrap.min.js'></script>
<script type="text/javascript"  src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/owl.carousel.min.js"></script>
<script type="text/javascript"  src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/wow.min.js"></script>
<script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/jquery.actual.min.js"></script>
<script type="text/javascript"  src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/chosen.jquery.min.js"></script>
<script type="text/javascript"  src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/lightbox.min.js"></script>
<script type="text/javascript"  src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/slick.min.js"></script>
<script type="text/javascript"  src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/jquery.sticky.js"></script>
<script type="text/javascript"  src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/owl.carousel2.thumbs.js"></script>
<script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/Modernizr.js"></script>
<script type="text/javascript"  src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/jquery.plugin.js"></script>
<script type="text/javascript"  src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/jquery.countdown.js"></script>
<script type="text/javascript"  src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/function.js"></script>
<script type='text/javascript' src='<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/jquery/jquery.validate.min.js'></script>
<script type='text/javascript'  src='<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/base/js/defaultCustom.min.js'></script>
<script type='text/javascript'  src='<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/confirm.js'></script>
<script type='text/javascript' src='<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/persian.js'></script>
<script type='text/javascript' src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/parsley/parsley.js"></script>
<script type="text/javascript"  src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/scripts.js"></script>
<!--<script type='text/javascript' defer="defer" src='<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/blazy.min.js'></script>-->
<script type='text/javascript'  src='<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/main.js'></script>
<script  type='text/javascript'  src='<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/jquery.slimscroll.js'></script>

<!--for gallery image-->
<script src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/galleryPic/picturefill.min.js"></script>
<script src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/galleryPic/lightgallery-all.js"></script>
<script src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/galleryPic/jquery.mousewheel.min.js"></script>
<!--end for gallery img-->
<script type="text/javascript">
    $('#lightgallery').lightGallery();
</script>
<script type="text/javascript">
    $(window).scroll(function () {
        smarket_resizeMegamenu();
    });
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
    /*--------------------------------
	persian to english
	------------------- */
    var tabdil=function(m){
        var num=JSON.parse('{"۰":"0","۱":"1","۲":"2","۳":"3","۴":"4","۵":"5","۶":"6","۷":"7","۸":"8","۹":"9"}');
        return m.replace(/./g,function(c){
            return (typeof num[c]==="undefined")?
                ((/\d+/.test(c))?c:''):
                num[c];
        })
    }

    function num(s){
        var a=["٠", "١", "٢", "٣", "٤", "٥", "٦", "٧", "٨", "٩"]
        var p=["۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹"]
        for(var i=0;i<10;i++){
            s=s.replace(new RegExp(a[i],'g'),i)
                .replace(new RegExp(p[i],'g'),i)
        }
        return s;
    }

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

<script>
    widgetHelper.formSubmit('#registerForm');
    widgetHelper.formSubmit('#contactform');
    widgetHelper.formSubmit('#additionalInfoForm');
    widgetHelper.formSubmit('#confirmationForm');
    widgetHelper.formSubmit('#completeInfo');
    widgetHelper.formSubmit('#UpgradeUserSave');
    widgetHelper.formSubmit('#returnProductSave');
    widgetHelper.formSubmit('#buyAgainFactor');
    widgetHelper.formSubmit('#retrievePass');
    //برای ارسال کد تایید به صورت پیامک
    $('#sendCode').click(function () {
        var mobileNum=$('#mobileNum').val();
        var params = {
            mobile: mobileNum,
        };
        widgetHelper.tt('ui', 'member.sendConfirmationCode', params, 'sendSMSConfirm');
    });
    function sendSMSConfirm(params) {
        alert('کد تایید مجددا ارسال شد');
    }
</script>
<script>
    var fewSeconds = 60;
    $('#sendCode').click(function () {
        // Ajax request
        var btn = $(this);
        btn.prop('disabled', true);
        setTimeout(function(){
            btn.prop('disabled', false);
        }, fewSeconds*1000);
    });

    /*this code is for sidebar basket*/
    $(document).ready(function () {
        if ($(window).width() <= 767) {
            $('.desktop-view').remove();
        } else {
            $('.mobile-view').remove();
        }
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
</script>
<script>
    function refreshAttached2(params)
    {
        var firstFileUrl = "<?= \f\ifm::app ()->fileBaseUrl ?>" + params.fileId[0];

        $('#attach2').html('<a href="' + firstFileUrl + '" target="_blank" ><i class="fa fa-picture-o"></i> تصویر پیوست شده</a>');
        setTimeout(function () {
            window['closeFileDialog' + runningFuncRandName]();
        }, 100);
    }
    function refreshAttached2(params)
    {
        var firstFileUrl = "<?= \f\ifm::app ()->fileBaseUrl ?>" + params.fileId[0];

        $('#attach2').html('<a href="' + firstFileUrl + '" target="_blank" ><i class="fa fa-picture-o"></i> تصویر پیوست شده</a>');

        var scope = angular.element($("body")).scope();
        scope.refreshAttachedPicture(params);

        setTimeout(function () {
            window['closeFileDialog' + runningFuncRandName]();
        }, 100);

    }
</script>
<!--        end for owl-curouser...................-->
</div>
</body>

</html>