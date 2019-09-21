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
                    <div class="footer-tags-content">

<img src="https://trustseal.enamad.ir/logo.aspx?id=107337&amp;p=xbhih0Nnv9LHIZHZ" alt="" onclick="window.open(&quot;https://trustseal.enamad.ir/Verify.aspx?id=107337&amp;p=xbhih0Nnv9LHIZHZ&quot;, &quot;Popup&quot;,&quot;toolbar=no, location=no, statusbar=no, menubar=no, scrollbars=1, resizable=0, width=580, height=600, top=30&quot;)" style="cursor:pointer" id="xbhih0Nnv9LHIZHZ">
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
<a href="#" id="scrollup" title="Scroll to Top"><i class="fa fa-angle-up" aria-hidden="true"></i></a>

<script type="text/javascript" defer="defer" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/jquery-2.1.4.min.js"></script>
<script type='text/javascript' defer="defer"  src='<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/base/js/bootstrap.min.js'></script>
<script type="text/javascript" defer="defer" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/jquery-ui.min.js"></script>
<script type="text/javascript" defer="defer" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/owl.carousel.min.js"></script>
<script type="text/javascript" defer="defer" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/wow.min.js"></script>
<script type="text/javascript" defer="defer" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/jquery.actual.min.js"></script>
<script type="text/javascript" defer="defer" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/chosen.jquery.min.js"></script>
<script type="text/javascript" defer="defer" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/lightbox.min.js"></script>
<script type="text/javascript" defer="defer" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/slick.min.js"></script>
<script type="text/javascript" defer="defer" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/jquery.sticky.js"></script>
<script type="text/javascript" defer="defer"  src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/owl.carousel2.thumbs.js"></script>
<script type="text/javascript" defer="defer" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/Modernizr.js"></script>
<script type="text/javascript" defer="defer" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/jquery.plugin.js"></script>
<script type="text/javascript" defer="defer" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/jquery.countdown.js"></script>
<script type="text/javascript" defer="defer" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/function.js"></script>
<script type='text/javascript' defer="defer" src='<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/jquery/jquery.validate.min.js'></script>
<script type='text/javascript' defer="defer"  src='<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/base/js/defaultCustom.min.js'></script>
<script type='text/javascript' defer="defer" src='<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/confirm.js'></script>
<script type='text/javascript' defer="defer" src='<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/persian.js'></script>
<script type='text/javascript' defer="defer" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/parsley/parsley.js"></script>
<script type="text/javascript" defer="defer" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/main/js/scripts.js"></script>
<!--<script type='text/javascript' defer="defer" src='<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/blazy.min.js'></script>-->
<script type='text/javascript' defer="defer" src='<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/main.js'></script>
<script  type='text/javascript' defer="defer" src='<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/jquery.slimscroll.js'></script>



<script type="text/javascript">
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

    function plusItem(item) {
        var count=$(item).parent().parent().find('.number').text();
        var option = {
            priceId: tabdil($(item).parent().find('#product_price_id').val()),
            product_id: tabdil($(item).parent().find('#product_id').val()),
            typeOpr:'increase',
            count:tabdil(count)
        };
        widgetHelper.tt('ui', 'shop.product.sendAddToCart', option, 'getBasketSidebar');
    }

    function minusItem(item) {
        var count=$(item).parent().parent().find('.number').text();
            var option = {
                priceId: tabdil($(item).parent().find('#product_price_id').val()),
                product_id: tabdil($(item).parent().find('#product_id').val()),
                typeOpr: 'decrease',
                count: tabdil(count)
            };
            widgetHelper.tt('ui', 'shop.product.sendAddToCart', option, 'getBasketSidebar');
    }

    function showResultAddCart(params) {
        if (params.result == 'error') {
            window.location.href = '<?= \f\ifm::app()->siteUrl ?>login/detailProduct/'+params.product_id;
        } else if (params.result.message == 'notStock') {
            setTimeout(function () {
                widgetHelper.errorDialog('عدم موجودی');
                widgetHelper.closeDialog('errorDialog');
            }, 800);
            widgetHelper.removeLoading();
        } else {
            $('.notification').css('opacity', '1');
            $('.counter-number').text(<?= $_SESSION['order_count']?>);
            $('#numItems').text(<?= $_SESSION['order_count']?>);
            if(params.typeOpr=='increase') {
                params.count=parseInt(params.count)+1;
                var countPro=params.count;
                $('#pro' + params.product_id).find('.number').text(params.count);
                var endPrice=parseInt(tabdil($('#totalPrice').text()))+  parseInt(tabdil($('#pro'+params.product_id).find('.itemPrice span').text()));
            }
            if(params.typeOpr=='decrease'){
                $('#pro' + params.product_id).find('.number').text(parseInt(tabdil($('#pro' + params.product_id).find('.number').text())) - 1);
                var endPrice=parseInt(tabdil($('#totalPrice').text()))-  parseInt(tabdil($('#pro'+params.product_id).find('.itemPrice span').text()));
            }

            if(params.typeOpr=='addToCart'){
                proId=params.product_id;
                pro_price_id=params.priceId;
                if($("#basketItems #pro" + proId).length == 0) {
                    //add new product to basket
                    linkPro='<?= \f\ifm::app()->siteUrl ?>productDetail/'+proId;
                    var strAddItem='<div id="pro'+proId+'" class="basketItem col-xs-12" data-id="'+params.result.order_item_id+'"><div class="row"><div class="itemTitle col-xs-12"><span class="productName"><a href="'+linkPro+'">'+params.namePro+'</a></span></div><div class="itemPrice"><span>'+params.pricePro+'</span>ریال</div><div class="counterWrap"><span class="number pull-left">1</span><span class="counter d-inline-block pull-left"><input id="product_price_id" value="'+pro_price_id+'" type="hidden"><input id="product_id" value="'+proId+'" type="hidden"><span class="increase fa fa-plus"></span><span class="decrease fa fa-minus"></span></span><span class="fa fa-trash pull-left trashPro" onclick="deletePro(this)"></span></div></div></div>';
                    $('#basketItems').append(strAddItem);
                }else{
                    $('#pro' + params.product_id).find('.number').text(parseInt($('#pro' + params.product_id).find('.number').text()) + 1);
                    var endPrice=parseInt($('#totalPrice').text())+  parseInt($('#pro'+params.product_id).find('.itemPrice span').text());
                    //no count new product
                    productName=params.namePro;
                }
            }
            $('#totalPrice').text(endPrice);
        }
        setTimeout(function () {
            $(".notification").css('opacity', '0');
        }, 5000);
    }

    function deletePro(item) {
        var con = confirm("آیا از حذف این مورد مطمئن هستید ؟");
        if (con) {
            var option = {
                orderItem_id: $(item).parent().parent().parent().attr('data-id'),
                order_id:$('#order_id').val()
            };
            widgetHelper.tt('ui', 'shop.order.orderItemDelete', option, 'deleteItem');
            return true;
        } else {
            return false;
        }
    }

    /*this code is for sidebar basket*/
    $(document).ready(function () {
        if ($(window).width() <= 767) {
            $('.desktop-view').remove();
        } else {
            $('.mobile-view').remove();
        }
        var m=$('#basketSidebar #numItems').text();
        if(m==''){
            $('.counter-number').text(<?= $_SESSION['order_count']?>);
        }else{
            $('.counter-number').text(m);
            getBasketSidebar();
        }
    });

    function getBasketSidebar(params='null') {
        var urlAddress=$('#siteUrl').val()+'shop/order/basketOfOrder';
        if(params.result=='errorNoLogin'){
            window.location.href = '<?= \f\ifm::app()->siteUrl ?>login';
        }else if(params.result.message=='notStock'){
            setTimeout(function () {
                widgetHelper.errorDialog('عدم موجودی');
                widgetHelper.closeDialog('errorDialog');
            }, 100);
            widgetHelper.removeLoading();
        }else{
            var request = $.ajax({
                url:urlAddress,
                method: "POST",
                dataType: "html"
            });
            request.done(function (msg) {
                $('#basketSidebar').html(msg);
                $('.counter-number').text($('#numItems').text());
                $('#mCSB_1_container').slimScroll({
                    height: '185px',
                    alwaysVisible: true,
                });
            });
        }
    }

    function sendAddToCart(id,product_price_id,item) {
        var count=$("#pro"+id+" .counterWrap .number").text();
        topPos=$(item).parent().parent().parent().offset().top;
        leftPos=$(item).parent().parent().parent().offset().left;
        topPosBuy=$('.basketContainer .row .col-md-3').offset().top+200;
        leftPosBuy=$('.basketContainer .row .col-md-3').offset().left+200;
        $('.copyName').text( $(item).parent().parent().parent().find('.product-name a').text());
        $('.copyName').css({position:'absolute',left:leftPos,top:topPos,display:'block',opacity:1}).animate({left: leftPosBuy,top:topPosBuy,opacity:0},{
            duration: 2000,
            specialEasing: {
                width: "linear",
                height: "easeOutBounce"
            }});
        //get price id from attribute data for check stock and add to user orders
        var option = {
            priceId: product_price_id,
            product_id: id,
            typeOpr:'addToCart',
            count:tabdil(count),
            namePro:$(item).parent().parent().parent().find('.product-name a').text(),
            pricePro:tabdil($(item).parent().parent().parent().find('.price ins').text())
        };
        widgetHelper.tt('ui', 'shop.product.sendAddToCart', option, 'getBasketSidebar');
    }

    function deleteItem() {
        getBasketSidebar({result:'success'});
    }

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
<!--        end for owl-curouser...................-->
</div>
</body>

</html>