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
<script type='text/javascript' src='<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/jquery/jquery.validate.min.js'></script>
<!--<script type='text/javascript'  src='<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/base/js/bootstrap.min.js'></script>-->
<script type='text/javascript'  src='<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/base/js/defaultCustom.min.js'></script>
<script type="text/javascript"></script>
<script type='text/javascript' src='<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/jquery/jquery.validate.min.js'></script>
<script type='text/javascript' src='<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/confirm.js'></script>
<script type='text/javascript' src='<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/persian.js'></script>
<script type='text/javascript' src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/parsley/parsley.js"></script>
<script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/main/js/scripts.js"></script>
<!--<script type='text/javascript' src='<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/base/js/blazy.min.js'></script>-->
<script type='text/javascript' src='<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/main.js'></script>
<script type="text/javascript" src="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/digifirst/js/function.js"></script>
<script type="text/javascript">
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

    getProductByParam(1);
    function getProductByParam(page){
        if (!page){
            page = 1;
        }
        mode = 'desktop';
        sort = $('#sort').val();
        brand = $('#brand').val();
        color = $('#color').val();
        sort_type = $('#sort_type').val();
        sale_status = $('#sale_status').val();

        $('#page').val(page);
        cat_id = $('#cat_id').val();
        var option = {
            sort: sort,
            sale_status: sale_status,
            sort_type: sort_type,
            page: page,
            brand: brand,
            cat_id: cat_id,
            color: color,
            searchText: $('#searchText').val(),
            mode: mode
        };
        widgetHelper.addLoading("#product", "absolute");
        widgetHelper.tt('ui', 'shop.product.getProductByParam',option, 'showResult')
    }
    function showResult(params)
    {
        $('#product').html(params.content);
        widgetHelper.removeLoading();
    }
    $(document).ready(function () {
        $('#example-getting-started').multiselect();
        $('#example-getting-started1').multiselect();
    });
    $('.dropdown-menu-toggle').hover(function () {

        $('.dropdown-menu').toggle();
    });
</script>
<!--        end for owl-curouser...................-->
</body>

</html>

