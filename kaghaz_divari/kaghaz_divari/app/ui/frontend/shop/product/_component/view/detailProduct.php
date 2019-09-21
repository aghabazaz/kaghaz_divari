<input id="brandDiscountType" type="hidden" value="<?= $brandDiscountType ?>"/>
<?php
//\f\pre($row);
?>
<main class="site-main product-set-opt">
    <div class="container-inner ">
        <ol class="breadcrumb-page style2">
            <li><a href="<?= \f\ifm::app()->siteUrl ?>" title="خانه">خانه</a></li>
            <?php
            $this->registerGadgets( [
                'dateG' => 'date' ] );

            if ( $amazing['amazing_price'] )
            {
                $amazing_price = $amazing['amazing_price'];
                //  $amazing_type=$amazing['discount_type'];

            } else
            {
                $amazing_price = "0";
                //$amazing_type=$amazing['discount_type'];
            }
            if ($brandDiscount) {
                $brandDiscount = $brandDiscount;
            } else {
                $brandDiscount = "0";
            }
            // \f\pre($amazing_type);
            if ( $specialSuggest['specialSuggest_price'] )
            {
                $specialSuggest_price = $specialSuggest['specialSuggest_price'];
            } else
            {
                $specialSuggest_price = "0";
            }
            end( $sortCat );
            $key = key( $sortCat );
            foreach ( $sortCat AS $data )
            {
                ?>
                <li><i class="fa fa-angle-left" aria-hidden="true"></i></li>
                <li><a
                            href="<?= \f\ifm::app()->siteUrl . 'product/' . $sortCat[$key]['title_en'] ?>" title="<?= $data['title'] ?>"><?= $data['title'] ?></a>
                </li>
                <?php
            }
            ?>
            <li><i class="fa fa-angle-left" aria-hidden="true"></i></li>
            <li class="active"><a href="#" title="<?= $row['title'] ?>"><?= $row['title'] ?></a></li>
        </ol>
    </div>
    <div class="container-inner">
        <div class="row">
            <div class="copyName"><?= $row['title'] ?></div>
            <div class="col-main">
                <div class="main-content">
                    <div class="single-left style4">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="product-zoom dotted-style-1">
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <?php
                                    $cunrterPic = 0;
                                    foreach ( $picture AS $data )
                                    {
                                        if ( $cunrterPic == 0 )
                                        {
                                            $activeSet = 'active';
                                        } else
                                        {
                                            $activeSet = '';
                                        }
                                        ?>
                                        <div class="tab-pane <?= $activeSet ?>" id="pic<?= $cunrterPic ?>">
                                            <div class="pro-large-img">
                                                <img src="<?= $data['path'] ?>"
                                                     alt="<?= $row['title']; ?>" title="<?= $row['title']; ?>">
                                                <a class="popup-link" href="<?= $data['path'] ?>" title="zoom">مشاهده بزرگتر <i
                                                            class="fa fa-search-plus" aria-hidden="true"></i></a>
                                            </div>
                                        </div>
                                        <?php
                                        $cunrterPic++;
                                    }
                                    ?>
                                </div>
                                <!-- Nav tabs -->
                                <ul class="details-tab owl-carousel">
                                    <?php
                                    $cunrterPicCarousel = 0;
                                    foreach ( $picture AS $data )
                                    {
                                        if ( $cunrterPicCarousel == 0 )
                                        {
                                            $activeSetnear = 'active';
                                        } else
                                        {
                                            $activeSetnear = '';
                                        }
                                        ?>
                                        <li class="<?= $activeSetnear ?>"><a href="#pic<?= $cunrterPicCarousel ?>"
                                                                             data-toggle="tab" title="<?= $row['title']; ?>"><img
                                                        src="<?= $data['path'] ?>" alt="<?= $row['title']; ?>" title="<?= $row['title']; ?>"></a></li>
                                        <?php
                                        $cunrterPicCarousel++;
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="entry-summary">
                        <div class="product-info-main style4">
                            <div class="product-name"><a><?= $row['title'] ?></a></div>
                            <p style="display: block;color:silver">برند: <?=$brandTitle;?></p>


                            <span class="price " style="margin-left:30px;">
                                     <ins> قیمت : </ins>
                                     <ins id="user_price"></ins>
                                     <ins id="user_price_ins"> ریال </ins>
                            </span>

                            <span class="price endPriceFix">
                                     <ins id="txtPriceSpan">قیمت نهایی:</ins>
                                     <ins id="priceMain"></ins>
                                     <ins> ریال </ins>
                            </span>

                            <div class="stock available">
                                <span class="label-stock">وضعیت: </span>
                                <span class="stock-show">

                                </span>
                            </div>
                            <p class="product-des"><?= $row['short_explanation'] ?> </p>
                            <?php if ( !empty ( $colors ) ) { ?>
                                <div class="col-md-7">
                                    <div class="content-select">
                                        <div class="select select-color">
                                            <span>رنگ<span class="note-impor">*</span></span>
                                            <select onchange="getGurantee()" class="select-detail select-color">
                                                <?php
                                                foreach ( $colors AS $data )
                                                {
                                                    ?>
                                                    <option value="<?= $data['color_id'] ?>"> <?= $data['color_title'] ?> </option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="select select-size">
                                            <span>اندازه<span class="note-impor">*</span></span>
                                            <select id="garanty" class=" select-detail select-size">

                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <?php
                                if($row['active_gift_section']=='enabled' and $stockGifts>$row['m_free']) {
                                    ?>
                                    <div class="col-md-5">
                                        <div class="gift">
                                            <?=$row['gift_text']?>
                                        </div>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                            <div class="quantity-cart">
                                <a style="float: left;" onclick="sendAddToCart()" class="btn-add-to-cart button-addToCart" title="افزودن به سبد">افزودن به سبد</a>
                                <a style="float: left;" onclick="sendAddToFavorite()" class="btn-add-to-like button-addToFavorite" title="علاقه مندی">افزودن به علاقه مندی ها</a>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-details-product">
                        <ul class="box-tab nav-tab">
                            <li class="active"><a data-toggle="tab" href="#tab-1" title="مشخصات محصول"> مشخصات محصول </a></li>
                            <li><a data-toggle="tab" href="#tab-3" title="نقد و بررسی">نقد و بررسی ها</a></li>
                            <li><a data-toggle="tab" href="#tab-2" title="نظرات کاربران">نظرات کاربران </a></li>
                        </ul>
                        <div class="tab-container">
                            <div id="tab-1" class="tab-panel active">
                                <div class="box-content">
                                    <h2 class="title">
                                        مشخصات محصول
                                        <span class="product_seo_title">
                             <?= $row['title'] ?>
                              </span>
                                    </h2>


                                    <?php
                                    $label = '';

                                    foreach ( $feature AS $valueArr )
                                    {
                                        foreach ( $valueArr AS $data )
                                        {
                                            if ( $data['featureTitle'] != $label )
                                            {
                                                $label = $data['featureTitle'];
                                                ?>


                                                <b class="title  product-b-title">
                                                    <i class="fa fa-caret-left"></i>
                                                    <span> <?= $data['featureTitle'] ?> </span>
                                                </b>
                                                <?php
                                            }

                                            if ( $data['type'] == 'multiSelect' )
                                            {
                                                foreach ( $value[$data['fId']] AS $data1 )
                                                {
                                                    $val2[] = $wiki[$data1];
                                                }
                                                $val = implode( ' ، ',$val2 );
                                            } else if ( $data['type'] == 'oneSelect' )
                                            {
                                                $val = $wiki[$value[$data['fId']]];
                                            } else if ( $data['type'] == 'yesOrNo' )
                                            {
                                                $val = $value[$data['fId']];

                                                if ( $val == 'no' )
                                                {
                                                    $val = '<i class="fa fa-times" style="font-size:20px;color: #FF6A6C;"></i>';
                                                } else if ( $val == 'yes' )
                                                {
                                                    $val = '<i class="fa fa-check" style="font-size:20px;color: #4CAF50"></i>';
                                                }
                                            } else
                                            {
                                                $val = nl2br( $value[$data['fId']] );
                                            }
                                            if ( $val )
                                            {
                                                ?>
                                                <ul class="spec-list" style="margin-bottom: 0px;">
                                                    <li class="clearfix">
                                                        <span class="technicalspecs-title "
                                                              data-id=""> <?= $wiki[$data['id']] ?> </span>
                                                        <span class="technicalspecs-value " data-id="">
                                 <span data-id=""> <?= $val ? $val : '-' ?> </span>
                                 </span>
                                                    </li>
                                                </ul>
                                                <?php
                                                $color = "";
                                            }
                                        }
                                    }
                                    ?>


                                </div>
                            </div>
                            <div id="tab-2" class="tab-panel">
                                <div class="box-content">
                                    <h2 class="title">نظرات کاربران
                                    </h2>
                                    <b class="title  product-b-title col-md-3 rate-product">
                                        <i class="fa fa-caret-left"></i>
                                        <span> امتیاز کاربربه این محصول </span>
                                    </b>
                                    <div class="rate-user-sum col-md-4">
                                        <span> <?= \f\ifm::faDigit( $row['rate_count'] . ' نفر' ) ?> </span>
                                        <?php
                                        $rate = $row['rate_avg'];
                                        for ( $i = 0; $i < 5; $i++ )
                                        {
                                            if ( $rate > $i && $rate >= $i + 1 )
                                            {
                                                echo ' <i class="gold fa fa-star" aria-hidden="true"></i>';
                                            } else if ( $rate > $i && $rate < $i + 1 )
                                            {
                                                echo '<i class="gold fa fa-star-half-o" aria-hidden="true"></i>';
                                            } else
                                            {
                                                echo ' <i class="silver fa fa-star" aria-hidden="true"></i>';
                                            }
                                        }
                                        ?>


                                    </div>
                                    <div class="rate-user-sum col-md-4">
                                        <a onclick="goToRate()" class="btn-add-comment" title="نظردهی"> نظر خود را بنویسید </a>
                                    </div>
                                    <b class="title  product-b-title">
                                        <i class="fa fa-caret-left"></i>
                                        <span> نظرات کاربران </span>
                                    </b>
                                    <ul id="frmUL_CommentsList">
                                        <?php
                                        if ( $comments )
                                        {
                                            foreach ( $comments AS $data )
                                            {
                                                if ( $data != NULL )
                                                {
                                                    ?>
                                                    <li>
                                                        <div class="user-comment-container" itemprop="review"
                                                             itemscope=""
                                                             itemtype="http://schema.org/Review">
                                                            <div class="user-comment-header clearfix">
                                                                <div class="user-info right clearfix buyer">
                                                                    <div class="author">
                                                                        <span><?= $data['name'] ?></span>
                                                                        <meta itemprop="datePublished"
                                                                              content="2018-03-25T16:21:50.413">
                                                                        <time> <span
                                                                                    class="type-user fa-digit"> <?= \f\ifm::faDigit(
                                                                                    $this->dateG->dateTime( $data['date_register'],
                                                                                        2 ) )
                                                                                ?> </span></time>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="user-comment-content clearfix">
                                                                <div class="col-md-6 right">
                                                                    <div class="buyer-message noidea">
                                                                        <p> <?= $data['title'] ?></p>
                                                                    </div>
                                                                    <div class="user-rating">
                                                                        <ul>
                                                                            <?php
                                                                            if ( $ratingTitle )
                                                                            {
                                                                                foreach ( $ratingTitle AS $key => $data2 )
                                                                                {
                                                                                    ?>

                                                                                    <li class="clearfix">
                                                                                        <span> <?= $data2 ?> </span>
                                                                                        <div class="rating-container clearfix">
                                                                                            <?
                                                                                            for ( $i =0 ; $i < $data['rate'][$key] ; $i++ )
                                                                                            {
                                                                                                ?>
                                                                                                <div class="bar done"></div>
                                                                                                <?php
                                                                                            }
                                                                                            ?>
                                                                                            <?
                                                                                            $barNot = 5 - $data['rate'][$key] ;
                                                                                            for ( $i =0 ; $i < $barNot ; $i++ )
                                                                                            {
                                                                                                ?>
                                                                                                <div class="bar"></div>
                                                                                                <?php
                                                                                            }
                                                                                            ?>

                                                                                        </div>
                                                                                    </li>

                                                                                    <?php
                                                                                }
                                                                            }
                                                                            ?>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6  right">
                                                                    <?php
                                                                    if ( $data['strenght'] || $data['weakness'] )
                                                                    {
                                                                        ?>
                                                                        <div class="comment-evaluation clearfix">
                                                                            <div class="positive-point">
                                                                                <span class="title">نقاط قوت</span>
                                                                                <ul>
                                                                                    <?php
                                                                                    foreach ( $data['strenght'] AS $key2 => $strenght )
                                                                                    {
                                                                                        echo "<li class='clearfix'><i
                                                                                            class='fa fa-arrow-up'></i><span>$strenght</span><br>";
                                                                                    }
                                                                                    ?>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                            <div class="negetive-point">
                                                                                <span class="title">نقاط ضعف</span>
                                                                                <ul>
                                                                                    <?php
                                                                                    if ( $data['weakness'] )
                                                                                    {
                                                                                        foreach ( $data['weakness'] AS $key2 => $weakness )
                                                                                        {
                                                                                            echo "<li class='clearfix'><i
                                                                                            class='fa fa-arrow-down'></i><span>$weakness</span>";
                                                                                        }
                                                                                    }
                                                                                    ?>

                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                    <div class="comment-text" itemprop="description">
                                                                        <p> <?= $data['description'] ?> </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                            <div id="tab-3" class="tab-panel">
                                <div class="box-content">
                                    <h2 class="title">
                                        نقد و بررسی
                                        <span class="product_seo_title">
                              <?= $row['title'] ?>
                              </span>
                                    </h2>

                                    <?= $row['review'] ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sidebar">
                <aside id="basketSidebar" class="basketCol  cart_anchor" style="margin-top:20px;position: relative; overflow: visible; box-sizing: border-box; min-height: 1px;">
                </aside>
                <div class="content-sidebar">
                    <?php
                    if(!empty($relatedPro)) {
                        ?>
                        <div class="block-sepecail">
                            <div class="block-title"> محصولات مرتبط</div>
                            <div class="block-sepecail-content">
                                <?php
                                $countRealated = 0;
                                foreach ($relatedPro AS $data) {
                                    if ($countRealated != 4) {
                                        ?>

                                        <div class="product-item style-2">
                                            <div class="product-inner">
                                                <div class="product-thumb">
                                                    <div class="thumb-inner realated-img-pro ">
                                                        <a href="<?= \f\ifm::app()->siteUrl . 'productDetail/' . $data['id'] . '/' . $data['title'] ?>"
                                                           title="<?= $data['title'] ?>"><img
                                                                    src="<?= \f\ifm::app()->fileBaseUrl . $data['picture']; ?>"
                                                                    alt="<?= $data['title'] ?>"
                                                                    title="<?= $data['title'] ?>"></a>
                                                    </div>
                                                </div>
                                                <div class="product-innfo">
                                                    <div class="product-name"><a
                                                                href="<?= \f\ifm::app()->siteUrl . 'productDetail/' . $data['id'] . '/' . $data['title'] ?>"
                                                                title="<?= $data['title'] ?>"><?= $data['title'] ?></h4></a>
                                                    </div>
                                                    <span class="price price-dark">
                              </span>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    } else {
                                        break;
                                    }
                                    $countRealated++;
                                }
                                ?>


                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>

            </div>
        </div>
        <div class="notification success">
            <div class="icon notif">
                <i class="fa fa-check-circle fa-2x success"></i>
            </div>
            <div class="content">
                محصول مورد نظر به سبد خرید شما افزوده شد .
            </div>
        </div>
    </div>
</main>


<input type="hidden" id="discount_type_amazing" name="discount_type_amazing" value="<?=$amazing['discount_type']?>"/>
<input type="hidden" id="select_price" name="select_price"/>
<input type="hidden" id="priceIdh" name="priceIdh" value="<?= $priceId ?>"/>
<script type="text/javascript"
        src="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/js/jquery.janebi.5.js"></script>
<script type="text/javascript"
        src="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/js/jquery.colorbox.js"></script>
<script src="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/js/owl.carousel.js"></script>
<style>
    body {
        background: #fff !important;
    }
    .notification {
        width: 357px;
        padding: 20px;
        background: #f7c66b;
        box-shadow: 0px 0px 5px 1px rgba(0, 0, 0, 0.2);
        margin-top: 10px;
        opacity: 0;
        position: fixed;
        left: 10px;
        top: 110px;
        z-index: 111;
        color: white;
        transition: 0.2s;
    }
    .notification.success:before {
        content: "";
        position: absolute;
        text-align: center;
        top: -26px;
        width: 21px;
        content: "\f0d8";
        left: 37%;
        font: normal normal normal 14px/1 FontAwesome;
        color: #f7c66b;
        font-size: 44px;
    }
    .product-info-main .price {
        font-size: 17px;
        color: #f24e3d;
        margin-bottom: 0px;
    }

    .icon.notif {
        background: orange;
        color: #FFF;
        position: absolute;
        left: 0;
        width: 60px;
        bottom: 0;
        top: 0;
        font-weight: bold;
        box-sizing: border-box;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .price ins {
        text-decoration: none;
        margin-left: 7px;
        display: initial;
        width: 100%;
    }
    .quantity-cart {
        width: 100%;
        margin-top: 159px;
        padding-top: 25px;
        padding-bottom: 6px;
    }
    .product-des{
        display:block;
    }
    .del{
        color: #c7c7c7;
        font-size: 14px;
        color: #c7c7c7;
        font-weight: normal;
        text-decoration: line-through !important;
    }
    .price ins.del{
        margin-left: 0px;
    }
    .breadcrumb-page li{
        line-height: 40px;
    }
</style>
<script type="text/javascript">
    $(document).ready(function () {
        $('.counter-number').text($('#basketSidebar #numItems').text());
        getBasketSidebar();
    });
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
    function getBasketSidebar(params='null') {
        if(params.result=='errorNoLogin'){
            window.location.href = '<?= \f\ifm::app()->siteUrl ?>login';
        }
        var urlAddress=$('#siteUrl').val()+'shop/order/basketOfOrder';
        var request=$.ajax({
            url: urlAddress,
            method: "POST",
            dataType: "html"
        });
        request.done(function( msg ) {
            $('#basketSidebar').html(msg);
            $('.counter-number').text($('#numItems').text());
        });
    }

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

    function deleteItem() {
        getBasketSidebar();
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
</script>
<script type="text/javascript">
    getGurantee();
    function getGurantee(value) {
        var colorId = $(".select-color option:selected").val();
        var option = {
            color_id: colorId,
            product_id: <?= $row['id'] ?>
        };
        widgetHelper.tt('ui', 'shop.product.getGuranteesByColorId', option, 'showResult')
    }
    var amazingPrice = <?= $amazing_price ?>;
    var amazingDisType = $('#discount_type_amazing').val();
    function showResult(params) {
        $('#garanty').html(params.content);
        var id = $('#garanty').find("option:selected").val();

        if (params.gurantee == 'NULL') {
            $('.price ins').css('display', 'none');
            $('.price').css('margin-bottom', '0px');
            $('.btn-add-to-cart').css('display','none')
            $('.stock-show').text(' در انبار موجود نیست ');
        } else {
            $('.stock-show').text(' آماده ارسال از انبار ');
        }

        // console.log(params);
        var price=0;
        if (params.gurantee != 'NULL') {
            if (amazingPrice) {
                if(amazingDisType=='percent'){
                    price = toTomanComment(params.gurantee['user_price'][id] *((100- amazingPrice)/100));
                }else if(amazingDisType=='fixed'){
                    price = toTomanComment(params.gurantee['user_price'][id] - amazingPrice);
                }
            }else if(params.gurantee['id'][id]>0){
                if(params.gurantee['type_discount'][id]=='percent'){
                    price = toTomanComment(params.gurantee['user_price'][id] *((100-params.gurantee['id'][id])/100));
                }else if(params.gurantee['type_discount'][id]=='fixed'){
                    price = toTomanComment(params.gurantee['user_price'][id] - params.gurantee['id'][id]);
                }
            }
            if (amazingPrice != 0 || params.gurantee['id'][id] != 0) {
                $('#offBox').show();
            }
            if(price==0){
                $('.endPriceFix').css('display','none');
                $('#user_price').removeClass('del');
                $('#user_price_ins').removeClass('del');
            }else{
                $('.endPriceFix').css('display','inline-block');
                $('#user_price').addClass('del');
                $('#user_price_ins').addClass('del');
                $('#priceMain').text(price);
            }

            $('#user_price').text(toTomanComment(params.gurantee['user_price'][id]));
            $('#majorPrice').text(toTomanComment(params.gurantee['majorPrice'][id]));
            $('.button-addToCart').attr('data', params.gurantee['idPrice'][id]);

        } else {
            $('#price-number,.button-addCart,.text-select-color,#sbHolder').hide();
            $('.products-availability-text').show();
        }

        //save to input hidden for change selects
        $('#select_price').val(JSON.stringify(params.gurantee));
    }

    $("#garanty").change(function () {
        var id = $(this).find("option:selected").val();
        var values = JSON.parse($('#select_price').val());
        var price=0;

        if (amazingPrice) {
            if(amazingDisType=='percent'){
                price = toTomanComment(values['user_price'][id] *((100- amazingPrice)/100));
            }else if(amazingDisType=='fixed'){
                price = toTomanComment(values['user_price'][id] - amazingPrice);
            }
        } else if(values['id'][id]>0){
            if(values['type_discount'][id]=='percent'){
                price = toTomanComment(values['user_price'][id] *((100-values['id'][id])/100));
            }else if(values['type_discount'][id]=='fixed'){
                price = toTomanComment(values['user_price'][id] - values['id'][id]);
            }
        }

        if (amazingPrice != 0 || values['id'][id] != 0) {
            $('#offBox').show();
        }

        if(price==0){
            $('.endPriceFix').css('display','none');
            $('#user_price').removeClass('del');
            $('#user_price_ins').removeClass('del');
        }else{
            $('#user_price').addClass('del');
            $('#user_price_ins').addClass('del');
            $('.endPriceFix').css('display','inline-block');
            $('#priceMain').text(price);
        }

        $('#majorPrice').text(toTomanComment(values['majorPrice'][id]));
        $('#user_price').text(toTomanComment(values['user_price'][id]));
        $('.button-addToCart').attr('data', values['idPrice'][id]);
    });

    function sendAddToCart() {
        topPos=$('.product-name').offset().top;
        var widthBox=$('.product-name').width();
        leftPos=$('.product-name').offset().left+widthBox;
        topPosBuy=$('#basketSidebar').offset().top;
        leftPosBuy=$('#basketSidebar').offset().left;
        $('.copyName').css({position:'absolute',left:leftPos,top:topPos,display:'block',opacity:1}).animate({left: leftPosBuy,top:topPosBuy,opacity:0},{
            duration: 2000,
            specialEasing: {
                width: "linear",
                height: "easeOutBounce"
            }});
        var id=<?= $row['id'] ?>;
        var count=$('#pro'+id).find('.number').text();
        //get price id from attribute data for check stock and add to user orders
        var option = {
            priceId: $(".button-addToCart").attr("data"),
            product_id: id,
            typeOpr:'addToCart',
        };
        widgetHelper.tt('ui', 'shop.product.sendAddToCart', option, 'getBasketSidebar');
    }

    function goToRate() {
        widgetHelper.tt('ui', 'shop.product.goToRateOrLogin', {}, 'showResultGoToRate');
    }

    function showResultGoToRate(param) {
        if (param.result == 'success') {
            window.location.href = '<?= \f\ifm::app()->siteUrl . 'rate/' . $row['id'] ?>';
        } else {
            window.location.href = '<?= \f\ifm::app()->siteUrl ?>login';
        }
    }

    function sendAddToFavorite() {
        var k=<?= $row['id'] ?>;
        var option = {
            productId:<?= $row['id'] ?>
        };
        widgetHelper.tt('ui', 'shop.product.sendAddToFavorite', option, 'showResultAddToFavorite');
    }

    function showResultAddToFavorite(params) {
        if(params.result>0){
            setTimeout(function () {
                widgetHelper.successDialog('این محصول به علاقه مندی های شما اضافه شد.');
                widgetHelper.closeDialog('successDialog');
            }, 800);
            $('.minicart-wishlist span').text('('+params.like_count+')');
        }else{
            setTimeout(function () {
                widgetHelper.errorDialog('این محصول قبلا به علاقه مندی های شما اضافه شده است.');
                widgetHelper.closeDialog('errorDialog');
            }, 800);
        }
        widgetHelper.removeLoading();
    }

    var s = 0;
    $(".accordion-content").click(function () {
        if (s == 0) {
            $(".fa-plus.accordion-content").css("display", "block");
            $(".fa-minus.accordion-content").css("display", "none");
            $(".test-team-fade").slideToggle(500);

            s = 1;
        } else {
            $(".fa-minus.accordion-content").css("display", "block");
            $(".fa-plus.accordion-content").css("display", "none");
            $(".test-team-fade").slideToggle(500);

            s = 0;
        }
    });

    var x = 0;
    $(".accordion-content2").click(function () {
        if (x == 0) {
            $(".fa-plus.accordion-content2").css("display", "block");
            $(".fa-minus.accordion-content2").css("display", "none");
            $(".test-team-fade2").slideToggle(500);

            x = 1;
        } else {
            $(".fa-minus.accordion-content2").css("display", "block");
            $(".fa-plus.accordion-content2").css("display", "none");
            $(".test-team-fade2").slideToggle(500);

            x = 0;
        }

    });

    $('.like_dislike #like').click(function (evt) {
        if ($('.like_dislike #dislike').prop('checked') === true) {
            $($('.like_dislike #dislike')).prop('checked', false);
        }
        // Send ajax call.
    });

    $('.like_dislike #dislike').click(function (evt) {
        if ($('.like_dislike #like').prop('checked') === true) {
            $($('.like_dislike #like')).prop('checked', false);
        }
        // Send ajax call.
    });

    $(document).ready(function () {
        $('.slider-for').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            asNavFor: '.slider-nav'
        });
        $('.slider-nav').slick({
            slidesToShow: 3,
            slidesToScroll: 3,
            asNavFor: '.slider-for',
            centerMode: true,
            focusOnSelect: true
        });
    });

    $(document).on('ready', function () {
        $(".regular").slick({
            dots: true,
            infinite: true,
            slidesToShow: 3,
            slidesToScroll: 3
        });
        $(".center").slick({
            dots: true,
            infinite: true,
            centerMode: true,
            slidesToShow: 3,
            slidesToScroll: 3
        });
        $(".variable").slick({
            dots: true,
            infinite: true,
            centerMode: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            focusOnSelect: true

        });
    });

    $(".button-tog").click(function () {
        $(".height-set-mobile").toggleClass("reveal-open");
        $(".reveal-open-btn-trans.button-tog").toggleClass("reveal-open-btn-trans-tr");
        $(window).scrollTop(687);
    });

    if ($(window).width() <= 767) {
        $(function () {
            $(window).scroll(function () {
                if ($('.Specifications').offset().top + 455 < $(window).scrollTop() + $(window).height()) {
                    $('#tab-mobile').addClass('fix-search');
                } else {
                    $('#tab-mobile').removeClass('fix-search');
                }
            });
        });

        function setOffset() {
            $(window).scrollTop($('.Specifications').offset().top - 100);
        }
    }

    // number to convert toman
    function toTomanComment(value) {
        value = value.toString();
        var nStr = value.replace(/[^0-9\.]/g, "");
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(nStr)) {
            nStr = nStr.replace(rgx, '$1,$2');
        }
        nStr = nStr.replace(/(\.\d)$/, "$10");  // if only one DP add another 0
        return nStr;
    }

    $(document).ready(function () {
        jQuery.colorbox.settings.maxWidth = '95%';
        jQuery.colorbox.settings.maxHeight = '95%';
        var resizeTimer;

        function resizeColorBox() {
            if (resizeTimer)
                clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function () {
                if (jQuery('#cboxOverlay').is(':visible')) {
                    jQuery.colorbox.load(true);
                }
            }, 300);
        }

        jQuery(window).resize(resizeColorBox);
        window.addEventListener("orientationchange", resizeColorBox, false);

        $(".product_thumbs a").attr('rel', 'product_thumb');
        $(".product_image,.product_thumbs a").colorbox();
       /* $(".product_thumbs").owlCarouselDet({
            items: 4,
            autoPlay: false,
            responsive: true,
            navigation: true,
            navigationText: ['<i class=\"fa fa-angle-right\"></i>', '<i class=\"fa fa-angle-left\"></i>'],
            direction: 'rtl',
            lazyLoad: true,
            rewindNav: false,
            pagination: false,
            scrollPerPage: true,
            itemsDesktop: [1199, 4],
            itemsDesktopSmall: [980, 3],
            itemsTablet: [768, 2],
            itemsTabletSmall: false,
            itemsMobile: [479, 1]
        });*/
    });
</script>

