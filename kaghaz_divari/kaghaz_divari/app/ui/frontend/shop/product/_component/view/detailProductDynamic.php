<main class="site-main product-set-opt">

    <div class="container-inner breadcrumb-detail-pro">
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
            <div class="col-main">
                <div class="main-content">
                    <div class="wrapper">
                        <div class="page">
                            <div class="main-container col1-layout">
                                <div class="main">
                                    <div class="col-main-inner">
                                        <div class="product-view ">
                                            <div class="product-essential">
                                                <form action="" method="post" id="product_addtocart_form" enctype="multipart/form-data">
                                                    <input name="form_key" type="hidden" value="LUXhSVrAbgflCjsw">
                                                    <div class="no-display">
                                                        <input type="hidden" class="siteUrl" value="<?= \f\ifm::app()->siteUrl ?>" >
                                                        <input type="hidden" name="product" value="31766">
                                                        <input type="hidden" name="related_product" id="related-products-field" value="">
                                                    </div>
                                                    <div class="row">
                                                        <div class="product-img-box col-sm-7 col-md-8 col-xs-12">
                                                            <div class="product-image">
                                                                <div class="product-image-gallery">
                                                                    <img id="image-main" class="gallery-image visible" src="<?= \f\ifm::app ()->fileBaseUrl . $row['picture']?>" alt="<?= $row['title'] ?>" title="<?= $row['title'] ?>">
                                                                    <input type="hidden" value="<?=$row['picture'];?>" name="picSerial" id="picSerial"/>
                                                                </div>
                                                            </div>
                                                            <div class="more-views">
                                                                <h2>نماهای بیشتر</h2>
                                                                <ul class="product-image-thumbs">
                                                                    <?php
                                                                    $cunrterPic = 0;
                                                                    foreach ( $picture AS $data ) {
                                                                        if ($cunrterPic == 0) {
                                                                            $activeSet = 'active';
                                                                        } else {
                                                                            $activeSet = '';
                                                                        }
                                                                        ?>
                                                                        <li>
                                                                            <a rel="group" class="pro_image thumb-link"
                                                                               href="<?= $data['path'] ?>"
                                                                               title="" data-image-index="0">
                                                                                <img src="<?= $data['path'] ?>"
                                                                                     width="90" height="90" alt=""/>
                                                                            </a>
                                                                        </li>
                                                                        <?php
                                                                        $cunrterPic++;
                                                                    }
                                                                    ?>
                                                                </ul>
                                                            </div>
                                                        </div>

                                                        <div class="product-shop is_carpet col-sm-5 col-md-4 col-xs-12">
                                                            <div class="product-name">
                                                                <h1><?=$row['title']?></h1>
                                                            </div>
                                                            <div class="clearer"></div>
                                                            <div class="clr8c product-info">
                                                                <div class="product-options" id="product-options-wrapper">
                                                                    <div class="center-block">
                                                                        <a href="javascript:void(0)" class="btn btn-sm btn-block btn-success open_product_form"><i class="fa fa-info-circle"></i> درخواست ویرایش تصویر</a>
                                                                    </div>
                                                                    <div class="product_form hidden">
                                                                        <a href="javascript:void(0)" class="btn btn-sm btn-block btn-danger close_product_form"><i class="fa fa-times"></i>بستن</a>
                                                                        <div class="info">
                                                                            <br>
                                                                            <p>
                                                                                در صورت تمایل به تغییر سایز تصاویر ،تغییر رنگ تصاویر ، اضافه کردن
                                                                                نوشته و یا لوگو خود به تصویر ، پاک کردن قسمتی از تصویر و یا هر تغییر
                                                                                دیگری، فرم زیر را کامل کنید و درخواست خود را برای ما ارسال کنید. تیم
                                                                                طراحی درخواست شما را پیگیری کرده و نتیجه را به اطلا
                                                                            </p>
                                                                            <br>
                                                                        </div>
                                                                        <form>
                                                                            <div class="form-group">
                                                                                <label>نام و نام خانوادگی:</label>
                                                                                <input type="text" class="form-control sender_name" required="">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>شماره تماس:</label>
                                                                                <input type="text" class="form-control sender_phone">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>ایمیل:</label>
                                                                                <input type="email" class="form-control sender_email" required="">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>طول:</label>
                                                                                <input type="text" class="form-control sender_width" required="">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>ارتفاع:</label>
                                                                                <input type="text" class="form-control sender_height" required="">
                                                                            </div>
                                                                            <div class="form-group">
                                                                                <label>متن درخواست شما:</label>
                                                                                <textarea class="form-control sender_message" rows="4"></textarea>
                                                                                <input type="hidden" class="store_id" value="11">
                                                                                <input type="hidden" class="product_url" value="https://www.boometo.com/%DA%A9%D8%A7%D8%BA%D8%B0-%D8%AF%DB%8C%D9%88%D8%A7%D8%B1%DB%8C-%D8%AF%D8%AE%D8%AA%D8%B1%D8%A7%D9%86-%D8%A7%DB%8C%D8%B3%D8%AA%D8%A7%D8%AF%D9%87.html">
                                                                            </div>
                                                                            <a href="javascript:void(0)" class="btn btn-block btn-sm btn-primary send_product_form">ارسال درخواست</a>
                                                                        </form>
                                                                    </div>
                                                                    <div class="calculator-wrapper " style="display:block !important;">
                                                                        <div class="block block-calculator">
                                                                            <div class="block-title">
                                                                                <small class="number">1</small>
                                                                                <strong><span>ابعاد مد نظر خود را به صورت لاتین (123) وارد کنید</span></strong>
                                                                            </div>
                                                                            <div class="block-content">
                                                                                <div class="inneri">
                                                                                    <div class="inputi">
                                                                                        <p class="inputi-f">طول (cm)</p>
                                                                                        <p class="inputi-f">ارتفاع (cm)</p>
                                                                                    </div>
                                                                                    <div class="inputi">
                                                                                        <p class="inputi-f"><input type="text" size="5" name="room_width" id="room_width" onchange="handleChange(this);" onkeyup="ca.numberOnly(this,false);"></p>
                                                                                        <p class="inputi-f"><input type="text" size="5" name="room_length" id="room_length" onchange="handleChange(this);" onkeyup="ca.numberOnly(this,false);"></p>
                                                                                    </div>
                                                                                    <div class="inputi small">
                                                                                        <p class="inputi-f f-width">0 m</p>
                                                                                        <p class="inputi-f f-height">0 m</p>
                                                                                    </div>
                                                                                    <div class="clearer"></div>
                                                                                    <div class="aspratio">
                                                                                        <input type="checkbox" name="aspect_ratio" disabled="disabled">
                                                                                        <label for="aspect_ratio">پیروی از تناسبات اصلی عکس</label>
                                                                                    </div>
                                                                                    <div class="mirror">
                                                                                        <input type="checkbox" vlaue="mirror" name="mirror" disabled="disabled" id="mirror">
                                                                                        <label for="mirror">چرخش عکس به صورت آینه</label>
                                                                                    </div>
                                                                                    <div class="grayscale">
                                                                                        <input type="checkbox" name="grayscale" disabled="disabled" id="grayscale">
                                                                                        <label for="grayscale">سیاه و سفید</label>
                                                                                    </div>
                                                                                    <div class="buttoni hidden">
                                                                                        <button type="button" onclick="ca.calcRoom();" class="button"><span><span>Calculate</span> </span> </button>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="inneri" style="display:none;">
                                                                                    <p><b>Floor area:</b> <span id="room_area">0.00</span> m<sup><font size="2">2</font></sup></p>
                                                                                </div>
                                                                                <div class="inneri" style="text-align: left;display:none;">
                                                                                    <div id="large_result" style="display: block;">
                                                                                        <p><b>Current product:</b> <font color="#FF0066"><span id="carpet_width">0</span>cm</font> x <font color="#FF0066"><span id="carpet_length">0</span>cm</font></p>
                                                                                        <p style="margin-top: -5px;"><b>Actual product area:</b> <span id="actual_area">0</span> m<sup><font size="2">2</font></sup></p>
                                                                                        <p><b>Total price:</b> <span id="total_price"></span></p>
                                                                                    </div>
                                                                                    <span id="large_message" style="display: none;">
                                                                                        <p><font color="#FF0000">Please contact one of our sales advisors about purchasing larger sizes than are available on our web site.</font></p>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="block block-calculator">
                                                                            <div class="block-title">
                                                                                <small class="number">2</small>
                                                                                <strong><span>برش تصویر</span></strong>
                                                                            </div>
                                                                            <div class="block-content">
                                                                                <p> <i class="fa fa-eye"></i> پس از وارد کردن سایز، با حرکت دادن کادر ظاهر شده بر روی تصویر، هر قسمت از تصویر را که مد نظر دارید را انتخاب کنید</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <dl class="last">
                                                                        <dt class="dtcerceve" id="opt_cerceve">
                                                                            <label class="required">
                                                                            </label>
                                                                        </dt>
                                                                        <dd class="ddcerceve ">
                                                                            <div class="input-box">
                                                                                <ul id="options-59799-list" data-opt_code="cerceve" class="cerceve options-list">
                                                                                    <?php
                                                                                    $firstPrice=$priceList[0]['majorPrice'];

                                                                                    //\f\pre($priceList);
                                                                                    foreach ($priceList as $data) {
                                                                                        //\f\pr($firstPrice);
                                                                                        //\f\pr($data['majorPrice']);
                                                                                        $diff=$data['majorPrice']-$firstPrice;
                                                                                        //\f\pr($diff);
                                                                                       // $data['majorPrice'];
                                                                                        ?>
                                                                                        <li class="cerceve i">
                                                                                            <input data-detail_code=""
                                                                                                   type="radio"
                                                                                                   class="radio  validate-one-required-by-name product-custom-option"
                                                                                                   name="options[59799]"
                                                                                                   id="options_59799_<?=$data['material_id']?>"
                                                                                                   value="4222<?=$data['material_id']?>"
                                                                                                   price="<?=$diff?>">
                                                                                            <span class="label">
                                                                                            <label for="options_59799_<?=$data['material_id']?>">
                                                                                                <?=$data['name']?>
                                                                                            </label>
                                                                                        </span>
                                                                                        </li>
                                                                                        <?php
                                                                                    }
                                                                                    ?>
                                                                                </ul>
                                                                                <span id="options-59799-container"></span>
                                                                            </div>
                                                                        </dd>
                                                                        <dt class="crop_image"><label class="required"><em>*</em>crop_image</label>
                                                                        </dt>
                                                                        <dd>
                                                                            <div class="input-box">
                                                                                <input class="crop_image" type="text"  id="options_59800_text" name="options[59800]">
                                                                            </div>
                                                                        </dd>
                                                                        <dt class=" genislik"><label class="required"><em>*</em>Genişlik</label>
                                                                        </dt>
                                                                        <dd>
                                                                            <div class="input-box">
                                                                                <input class="genislik" type="text"  id="options_59801_text" name="options[59801]">
                                                                            </div>
                                                                        </dd>
                                                                        <dt class=" yukseklik"><label class="required"><em>*</em>Yükseklik</label>
                                                                        </dt>
                                                                        <dd class=" yukseklik last">
                                                                            <div class="input-box">
                                                                                <input class="yukseklik" type="text"  id="options_59802_text" name="options[59802]">
                                                                            </div>
                                                                        </dd>
                                                                    </dl>

                                                                </div>
                                                                <div class="clearer"></div>
                                                                <div class="product-options-bottom">
                                                                    <div class="price-box">
                                                                <span class="regular-price" id="product-price-31766_clone">
                                            <span class="price"></span>                                    </span>
                                                                    </div>
                                                                    <div class="add-to-cart">
                                                                        <label for="qty" style="display: none;">تعداد:</label>
                                                                        <div class="qty-holder">
                                                                            <input type="text" name="qty" id="qty" maxlength="12" value="1" title="تعداد" class="input-text qty" style="display: none;">

                                                                        </div>
                                                                        <button type="button" title="افزودن به سبد" class="button btn-cart disabled" onclick="prepareSubmit()" disabled="disabled"><span><span><i class="icon-cart"></i>افزودن به سبد</span></span></button>
                                                                    </div>
                                                                </div>
                                                                <div class="clearer"></div>
                                                            </div>
                                                            <div class="clearer"></div>
                                                        </div>
                                                    </div></form>
                                            </div>
                                            <!-- OLD COLLATERAL AREA -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ESI START DUMMY COMMENT [] -->
                            <!-- ESI URL DUMMY COMMENT -->
                            <!-- ESI END DUMMY COMMENT [] -->
                        </div>
                    </div>
                    <div class="tab-details-product">
                        <ul class="box-tab nav-tab">
                            <li class="active"><a data-toggle="tab" href="#tab-1"> مشخصات فنی </a></li>
                            <li><a data-toggle="tab" href="#tab-3">نقد و بررسی ها</a></li>
                            <li><a data-toggle="tab" href="#tab-2">نظرات کاربران </a></li>
                        </ul>
                        <div class="tab-container">
                            <div id="tab-1" class="tab-panel active">
                                <div class="box-content">
                                    <h2 class="title">
                                        مشخصات فنی
                                        <span class="product_seo_title">
                                       صندل زنانه سارا جونز لاندن مدل Chavi Mint 320
                                       </span>
                                    </h2>
                                    <b class="title  product-b-title">
                                        <i class="fa fa-caret-left"></i>
                                        <span>مشخصات</span>
                                    </b>
                                    <ul class="spec-list">
                                        <li class="clearfix">
                                            <span class="technicalspecs-title " data-id="">جنس رويه</span>
                                            <span class="technicalspecs-value " data-id="">
                                          <span data-id="">
                                          چرم طبيعي                            </span>
                                          </span>
                                        </li>
                                        <li class="clearfix">
                                            <span class="technicalspecs-title " data-id="">وزن کفش (يک لنگه)</span>
                                            <span class="technicalspecs-value " data-id="">
                                          <span data-id="">
                                          200 گرم                            </span>
                                          </span>
                                        </li>
                                        <li class="clearfix">
                                            <span class="technicalspecs-title " data-id="">جنس کف کفش</span>
                                            <span class="technicalspecs-value " data-id="">
                                          <span data-id="">
                                          اي وي اي¡ چرم                            </span>
                                          </span>
                                        </li>
                                        <li class="clearfix">
                                            <span class="technicalspecs-title " data-id="">ساير توضيحات</span>
                                            <span class="technicalspecs-value " data-id="">
                                          <span data-id="">
                                          ساخته شده از چرم طبيعي                            </span>
                                          </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div id="tab-2" class="tab-panel">
                                <div class="box-content">
                                    <h2 class="title">نظرات کاربران
                                    </h2>
                                    <b class="title  product-b-title col-md-3">
                                        <i class="fa fa-caret-left"></i>
                                        <span> امتیاز کاربربه این محصول </span>
                                    </b>
                                    <div class="rate-user-sum col-md-4">
                                        <span> از 5 نفر </span>
                                        <i class="gold fa fa-star" aria-hidden="true"></i>
                                        <i class="gold fa fa-star" aria-hidden="true"></i>
                                        <i class="gold fa fa-star" aria-hidden="true"></i>
                                        <i class="silver fa fa-star" aria-hidden="true"></i>
                                        <i class="silver fa fa-star" aria-hidden="true"></i>
                                    </div>
                                    <div class="rate-user-sum col-md-4">
                                        <a href="" class="btn-add-comment"> نظر خود را بنویسید </a>
                                    </div>
                                    <b class="title  product-b-title">
                                        <i class="fa fa-caret-left"></i>
                                        <span> نظرات کاربران </span>
                                    </b>
                                    <ul id="frmUL_CommentsList">
                                        <li>
                                            <div class="user-comment-container" itemprop="review" itemscope="" itemtype="http://schema.org/Review">
                                                <div class="user-comment-header clearfix">
                                                    <div class="user-info right clearfix buyer">
                                                        <div class="author">
                                                            <span>سیدمهدی مدقق</span>                                                                           <span>(خریدار این محصول)</span>
                                                            <meta itemprop="datePublished" content="2018-03-25T16:21:50.413">
                                                            <time>۵ فروردين ۱۳۹۷</time>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="user-comment-content clearfix">
                                                    <div class="rating-panel right">
                                                        <div class="buyer-message noidea">
                                                            <p>در مورد خرید این محصول نظری ندارم</p>
                                                        </div>
                                                        <div class="user-rating">
                                                            <ul>
                                                                <li class="clearfix">
                                                                    <span>ارزش خريد به نسبت قيمت</span>
                                                                    <div class="rating-container clearfix">
                                                                        <div class="bar done"></div>
                                                                        <div class="bar done"></div>
                                                                        <div class="bar done"></div>
                                                                        <div class="bar"></div>
                                                                        <div class="bar"></div>
                                                                    </div>
                                                                </li>
                                                                <li class="clearfix">
                                                                    <span>کيفيت ساخت</span>
                                                                    <div class="rating-container clearfix">
                                                                        <div class="bar done"></div>
                                                                        <div class="bar done"></div>
                                                                        <div class="bar done"></div>
                                                                        <div class="bar"></div>
                                                                        <div class="bar"></div>
                                                                    </div>
                                                                </li>
                                                                <li class="clearfix">
                                                                    <span>امکانات و قابليت ها</span>
                                                                    <div class="rating-container clearfix">
                                                                        <div class="bar done"></div>
                                                                        <div class="bar done"></div>
                                                                        <div class="bar done"></div>
                                                                        <div class="bar"></div>
                                                                        <div class="bar"></div>
                                                                    </div>
                                                                </li>
                                                                <li class="clearfix">
                                                                    <span>سهولت استفاده</span>
                                                                    <div class="rating-container clearfix">
                                                                        <div class="bar done"></div>
                                                                        <div class="bar done"></div>
                                                                        <div class="bar done"></div>
                                                                        <div class="bar"></div>
                                                                        <div class="bar"></div>
                                                                    </div>
                                                                </li>
                                                                <li class="clearfix">
                                                                    <span>طراحي و ظاهر</span>
                                                                    <div class="rating-container clearfix">
                                                                        <div class="bar done"></div>
                                                                        <div class="bar done"></div>
                                                                        <div class="bar done"></div>
                                                                        <div class="bar"></div>
                                                                        <div class="bar"></div>
                                                                    </div>
                                                                </li>
                                                                <li class="clearfix">
                                                                    <span>نوآوري</span>
                                                                    <div class="rating-container clearfix">
                                                                        <div class="bar done"></div>
                                                                        <div class="bar done"></div>
                                                                        <div class="bar done"></div>
                                                                        <div class="bar"></div>
                                                                        <div class="bar"></div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="content-panel right">
                                                        <div class="subject">گوشي خوش دست و سبک</div>
                                                        <div class="comment-evaluation clearfix">
                                                            <div class="positive-point">
                                                                <span class="title">نقاط قوت</span>
                                                                <ul>
                                                                    <li class="clearfix">                                     <i class="fa fa-arrow-up"></i>                                     <span>باطري خوب و انتن دهي عالي</span>                                 </li>
                                                                </ul>
                                                            </div>
                                                            <div class="negetive-point">
                                                                <span class="title">نقاط ضعف</span>
                                                                <ul>
                                                                    <li class="clearfix">                                     <i class="fa fa-arrow-down"></i>                                     <span>نقطه ضعفي تا حالا ازش نديدم .</span>                                 </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <div class="comment-text" itemprop="description">
                                                            <p>                             گوشی خوب و کاربردی. اگه از دیجی کالا بخرید بهتره چون بعضی از فروشنده های نامرد هندزفریشو برمیدارن .                         </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div id="tab-3" class="tab-panel">
                                <div class="box-content">
                                    <h2 class="title">
                                        نقد و بررسی
                                        <span class="product_seo_title">
                                       صندل زنانه سارا جونز لاندن مدل Chavi Mint 320
                                       </span>
                                    </h2>
                                    <p>لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است. چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد. کتابهای زیادی در شصت و سه درصد گذشته،
                                    </p>
                                    <span>اندازه و وزن</span>
                                    <div class="parameter">
                                        <p>اندازه: 40" H x 35.5" L x 35.5" W</p>
                                        <p>ارتفاع:40"</p>
                                        <p>وزن: 88 گرم</p>
                                    </div>
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
                    <div class="block-sepecail">
                        <div class="block-title"> محصولات مرتبط </div>
                        <div class="block-sepecail-content">
                            <div class="product-item style-2">
                                <div class="product-inner">
                                    <div class="product-thumb">
                                        <div class="thumb-inner">
                                            <a href=""><img src="images/product/spe1.jpg" alt="p8"></a>
                                        </div>
                                    </div>
                                    <div class="product-innfo">
                                        <div class="product-name"><a href="">پرینتر سه کاره CANON PIXMA MG5740</a></div>
                                        <span class="price">
                                       <ins>360,000 تومان</ins>
                                       <del>390,000 تومان</del>
                                       </span>
                                    </div>
                                </div>
                            </div>
                            <div class="product-item style-2">
                                <div class="product-inner">
                                    <div class="product-thumb">
                                        <div class="thumb-inner">
                                            <a href=""><img src="images/product/spe3.jpg" alt="p8"></a>
                                        </div>
                                    </div>
                                    <div class="product-innfo">
                                        <div class="product-name"><a href="">لورم ایپسوم متن ساختگی با تولید سادگی</a></div>
                                        <span class="price price-dark">
                                       <ins>230,000 تومان</ins>
                                       </span>
                                    </div>
                                </div>
                            </div>
                            <div class="product-item style-2">
                                <div class="product-inner">
                                    <div class="product-thumb">
                                        <div class="thumb-inner">
                                            <a href=""><img src="images/product/spe4.jpg" alt="p8"></a>
                                        </div>
                                    </div>
                                    <div class="product-innfo">
                                        <div class="product-name"><a href="">پرینتر سه کاره CANON PIXMA MG5740</a></div>
                                        <span class="price price-dark">
                                       <ins>230,000 تومان</ins>
                                       </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<script type="text/javascript">
    jQuery(function($){
        $(document).ready(function() {
            $(".pro_image").fancybox();
            $('.counter-number').text($('#basketSidebar #numItems').text());
            getBasketSidebar();
        });
    });
    function getBasketSidebar(params='null') {
        if(params.result=='errorNoLogin'){
            window.location.href = '<?= \f\ifm::app()->siteUrl ?>login';
        }
        var urlAddress=jQuery('#siteUrl').val()+'shop/order/basketOfOrder';

        var request=jQuery.ajax({
            url: urlAddress,
            method: "POST",
            dataType: "html"
        });
        request.done(function( msg ) {
            jQuery('#basketSidebar').html(msg);
            jQuery('.counter-number').text(jQuery('#numItems').text());
        });
    }
    function sendAddToCart() {


        widgetHelper.tt('ui', 'shop.product.sendAddToCart', option, 'getBasketSidebar');
    }
    function prepareSubmit(e, data){
        topPos=jQuery('.product-name').offset().top;
        var widthBox=jQuery('.product-name').width();
        leftPos=jQuery('.product-name').offset().left+widthBox;
        topPosBuy=jQuery('#basketSidebar').offset().top;
        leftPosBuy=jQuery('#basketSidebar').offset().left;

        jQuery('.copyName').css({position:'absolute',left:leftPos,top:topPos,display:'block',opacity:1}).animate({left: leftPosBuy,top:topPosBuy,opacity:0},{
            duration: 2000,
            specialEasing: {
                width: "linear",
                height: "easeOutBounce"
            }});
        var id=<?= $row['id'] ?>;
        var count=jQuery('#pro'+id).find('.number').text();
        //get price id from attribute data for check stock and add to user orders
        var option = {
            priceId: jQuery(".button-addToCart").attr("data"),
            product_id: id,
            typeOpr:'addToCart',
            dynamicOpr:'dynamic'
        };

        var $j = jQuery.noConflict();
        if( $j('.product-shop').hasClass('is_carpet') ) {
            $c_data       = $j.parseJSON( $j('input.crop_image').val() );
            $c_data.mirror= $j('input[type=checkbox]#mirror:checked').val();
            $c_data.grayscale= $j('input[type=checkbox]#grayscale:checked').val();
            $c_data.image = $j('img#image-main').attr('src');
            $c_data.imgAttr =$j('.cropper-crop-box').attr('style');
            $c_data.masterImg=$j('.cropper-bg').attr('style');
            //$c_data.mirror=$j('input[name*="mirror"]').val();
           // $c_data.mirror=$j('input#mirror').val();
            $c_data.serialImage=$j('#picSerial').val();
            $j.ajax({
                type: "POST",
               // url: "http://kaghaz_divari.local/shop/product/saveImageCrop",
                url: jQuery('#siteUrl').val()+'shop/product/sendAddToCart';,
                dataType: 'json',
                data: $c_data,
                success: function(data){
                    $j('input.crop_image').val(data.image);
                    productAddToCartForm.submit(data);
                },
                failure: function(errMsg) {
                    alert(errMsg);
                }
            });
        } else{
            productAddToCartForm.submit(data);
        }

    }
</script>
<script type="text/javascript">
    Carpet = Class.create();
    Carpet.prototype = {
        initialize : function(config){
            this.config = config;
            if(config && config.iscarpet) {
                this.price = parseFloat(this.config.price);
                if(config.width_type == 'field'){
                    this.widthid = "options_" + config.widthid + "_text";
                }else if(config.width_type == 'select'){
                    this.widthid = "select_" + config.widthid;
                }
                this.lengthid = "options_" + config.lengthid + "_text";
                this.originalPrice = 60000.0000;
                this.widthType = config.width_type;
                this.taxPercent = 9*1;
                this.currencyRate = 1*1 ;
                this.load();
            }
        },
        load : function(){
            var widthInput = $(this.widthid);
            if(this.widthType == 'field'){
                widthInput.observe('keyup',function(){
                    widthInput.setValue(widthInput.getValue().replace(/[^0-9.]/g,''));

                });
                widthInput.observe('keyup',this.getFromFields.bind(this));
            }else if(this.widthType == 'select'){
                widthInput.observe('change',this.getFromFields.bind(this));
            }


            var lengthInput = $(this.lengthid);
            lengthInput.observe('keyup',function(){
                lengthInput.setValue(lengthInput.getValue().replace(/[^0-9.]/g,''));

            });
            lengthInput.observe('keyup',this.getFromFields.bind(this));
            $('qty').setStyle({display: "none"});
            $$(".add-to-cart label").each(function(j){
                j.setStyle({display: "none"});
            });
            this.getFromRoomInput();
            $('carpet_width').innerHTML = this.getFieldValue($(this.widthid));
            $('carpet_length').innerHTML = this.getFieldValue($(this.lengthid));


            if(this.config.options){
                this.config.options.each(function (option){
                    if(option.type == 'drop_down'){
                        $('select_'+option.id).observe('change', function(){
                            ca.getFromQty();
                        }.bind(this));
                    }else if (option.type == 'checkbox' || option.type ==  'radio'){
                        $$('#options-'+option.id+'-list input').each(function (el){
                            el.observe('click', function(){
                                ca.getFromQty();
                            });
                        }.bind(this));
                    }
                });
            }
        },
        calcRoom : function(){
            var widthInput = $(this.widthid);
            var lengthInput = $(this.lengthid);

            var width_type = this.widthType;
            var max_length = this.config.maxlength * 1;

            if(max_length <=0){
                max_length = 999999;
            }

            var widths = this.config.widths;


            if ($('room_width')==null) return;
            var room_width = $('room_width').getValue() * 1; // edited
            var room_length = $('room_length').getValue() * 1; // edited
            var tmp = 0;
            /*if (room_width > room_length) {
                tmp = room_width;
                room_width = room_length;
                room_length = tmp;
                $('room_width').setValue(room_width);
                $('room_length').setValue(room_length);
            }*/
            var room_area = 0;
            var room_circum = 0;

            var qty = 0;
            if (this.isNumeric(room_width)&&this.isNumeric(room_length)) {
                var room_area = room_width * room_length;
                var room_circum = (room_width*2)+(room_length*2);
                $('room_area').innerHTML = room_area.toFixed(2);
                //$('room_circum').innerHTML = room_circum.toFixed(2);

                var available = false;
                var useWidth1 = 10000;
                var useLength1 = 10000;
                var useIndex1 = 0;

                var useWidth2 = 10000;
                var useLength2 = 10000;
                var useIndex2 = 0;

                var message = "";
                var results;

                if (widths !="") {
                    // need to select required carpet width and length, then
                    var temp_withs = ""+widths;
                    var sizes = temp_withs.split(",");
                    var many = sizes.length;


                    var this_size;
                    var debug = "";



                    for (var x = 0; x < many; x++) {
                        this_size = sizes[x]*1;
                        //find best match to width
                        if ((room_width<=this_size)&&(this_size<useWidth1)) {
                            useWidth1 = this_size;
                            useLength1 = room_length;
                            useIndex1 = x;
                            available = true;
                        }
                        //find best match to length
                        if ((room_length<=this_size)&&(this_size<useLength2)) {
                            useWidth2 = this_size;
                            useLength2 = room_width;
                            useIndex2 = x;
                            available = true;
                        }
                    }

                    // make sure we pick the most efficient direction of roll
                    if ((useWidth1*useLength1) > (useWidth2*useLength2)) {
                        useWidth1 = useWidth2;
                        useLength1 = useLength2;
                        useIndex1 = useIndex2;
                    }

                    //can't have extreme lengths of carpet
                    if (useLength1 > max_length) available = false;


                } else {
                    available = true;
                    useWidth1 = room_width;
                    useLength1 = room_length;
                }

                if (available) {
                    //put into results
                    $('carpet_width').innerHTML = useWidth1;
                    $('carpet_length').innerHTML = useLength1;

                    //put back into page form

                    if(width_type == 'select'){
                        widthInput.selectedIndex = useIndex1;
                    }else if (width_type == 'field'){

                        widthInput.setValue(useWidth1);
                    }

                    lengthInput.setValue(useLength1);

                    message = "none";
                    results = "block";
                } else {
                    //this.getFromFields();
                    message = "block";
                    //results = "none";
                }
                this.getFromRoomInput();
                $('large_message').style.display = message;
                $('large_result').style.display = results;

            }
        },
        getFromFields : function(){
            var max_length = parseFloat(this.config.maxlength);

            if(max_length <=0){
                max_length = 999999;
            }

            var _length = this.getFieldValue($(this.lengthid));
            if (!_length){
                _length = 0;
            }else {
                _length = parseFloat(_length);
                if (_length < 0) _length = 0;
            }

            if(_length > max_length) {
                $('large_message').style.display = "block";

            } else {
                $('large_message').style.display = "none";
            }
            var _width = this.getFieldValue($(this.widthid));

            $('carpet_width').innerHTML = _width;
            $('carpet_length').innerHTML = _length

            var room_area =( _width / 100 ) * ( _length / 100 );
            $('actual_area').innerHTML = room_area.toFixed(2);

            var _qty = ( _width / 100 ) * ( _length / 100 );


            //$('qty').setValue(_qty);
            $('actual_area').innerHTML = _qty;

            this.getFromQty();
        },
        getFromRoomInput : function(){
            var _room_width = $('room_width').getValue();
            var _room_length = $('room_length').getValue();

            var room_area = ( _room_width / 100 ) *( _room_length / 100 );
            var room_circum = (_room_width*2)+(_room_length*2);
            $('room_area').innerHTML = room_area.toFixed(2);
            //$('room_circum').innerHTML = room_circum.toFixed(2);
            this.getFromFields();

        },
        getFromQty : function(){
            var  _qty = parseFloat($('actual_area').innerHTML);
            if (!_qty) {_qty = 1} else if (_qty < 1) {
                _qty = 1;
            }

            this.getPrice();
        },
        getFieldValue : function(f) {
            var val = 0;
            if (f.type == "select-one" || f.type == "select-multiple") {
                var index = f.selectedIndex;
                if(index >= 0){
                    val = f.options[index].innerHTML;
                }
            } else {
                val = f.getValue()
            }
            if(!val) return 0;
            return parseFloat(val)
        },
        getPrice : function(){
            var original_price = this.originalPrice;
            var val		= parseFloat($('actual_area').innerHTML);//$('qty').getValue()
            var price	= parseFloat(this.price * 1);
            var currencyRate = parseFloat(this.currencyRate * 1);
            if(currencyRate == 0){
                currencyRate = 1;
            }
            var taxPercent = parseFloat(this.taxPercent * 1);
            var tprice = 0;
            if (this.config.prices){
                this.config.prices.each(function (item){
                    qty = parseFloat(item.price_qty);
                    if (val >= qty){
                        tprice = parseFloat(item.price);
                    }
                });
                if (tprice && (tprice < price)){
                    price = tprice;

                }
                var check = optionsPrice.formatPrice(price);
                this.addTierRowClass(check);
            }



            //Should include prices from all other options
            var option_price = 0;
            var store_code = "boometo";
            var is_tablo = false;
            if (this.config.options){
                this.config.options.each(function (item){
                    if(item.type == 'drop_down'){
                        var e = $('select_'+item.id);
                        var price = e.options[e.selectedIndex].getAttribute('price');
                        option_price = option_price + parseFloat(price);
                    }else if(item.type == 'checkbox' || item.type == 'radio'){
                        $$('#options-'+item.id+'-list input').each(function (el){
                            if(el.checked){
                                price = el.getAttribute('price');
                                option_price = option_price + parseFloat(price);
                            }
                        });
                    }
                });
            }

            if(is_tablo) {
                //var totalPrice = (price + option_price) * currencyRate;
                var totalPrice =  price * currencyRate ;
                var currencyPrice = (val * totalPrice) + (option_price * currencyRate) ;
            } else{
                //var totalPrice = (price + option_price) * currencyRate;
                var totalPrice = (price * currencyRate) + option_price;
                var currencyPrice = val * totalPrice;


            }

            if( store_code === 'papier') {
                currencyPrice = currencyPrice * (1+taxPercent/100);
            }
            var currencyPriceInclTax = currencyPrice * (1+taxPercent/100);
            //currencyPriceInclTax = currencyPriceInclTax.toFixed(2);

            //var total_price =  optionsPrice.formatPrice(total);

            var excludeTax = optionsPrice.formatPrice(currencyPrice);
            var includeTax = optionsPrice.formatPrice(currencyPriceInclTax);

            $('total_price').innerHTML = includeTax;
            $$(".price-box .price").each(function(j) {
                j.innerHTML = excludeTax;
            });

            $$(".price-box .price-including-tax .price").each(function(j) {
                j.innerHTML = includeTax;
            });
            $$(".price-box .price-excluding-tax .price").each(function(j) {
                j.innerHTML = excludeTax;
            });


            $$(".price-box .old-price .price").each(function(j) {
                j.innerHTML = optionsPrice.formatPrice(val * original_price * currencyRate);;
            });

            $$(".price-box .special-price .price-including-tax .price").each(function(j) {
                j.innerHTML = includeTax;
            });
            $$(".price-box .special-price .price-excluding-tax .price").each(function(j) {
                j.innerHTML = excludeTax;
            });
        },
        update : function(){
            if(!config || !config.iscarpet)  return;
            this.getFromFields();
        },

        addTierRowClass : function(bs){

            $$('.tier-prices li').each(function(el){
                el.removeClassName('tierRow');
                if(el.innerHTML.include(bs)){
                    el.addClassName('tierRow');
                }
            }.bind(this));

        },
        conversion : function() {
            var feet = $("calc_feet").value;
            var inches = $("calc_inches").value;
            var result = ((feet*12)+inches*1)*0.0254;
            $("calc_metres").innerHTML = result.toFixed(3);
        },
        isNumeric : function(value) {
            return typeof value != "boolean" && value !== null && !isNaN(+ value);
        },
        numberOnly : function(inputObj,wholeNumbers) {
            if (wholeNumbers)
                inputObj.value = inputObj.value.replace(/[^0-9]/g,'')
            else
                inputObj.value = inputObj.value.replace(/[^0-9]/g,'');
            return true;
        }
    }
</script>
<script type="text/javascript">
    ca = new Carpet({"widths":[],"options":[
        {"id":"59799","values":{
                },"type":"radio"},
            {"id":"59800","values":{"price":0,"oldPrice":0,"priceValue":"0.0000","type":"fixed"},"type":"field"}]
        ,"widthid":"59801","width_type":"field","lengthid":"59802","maxlength":null,"id":"31766","iscarpet":"1","price":<?=$firstPrice?>,"prices":[]});
</script>