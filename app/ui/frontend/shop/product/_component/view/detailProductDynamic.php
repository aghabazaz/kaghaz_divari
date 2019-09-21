<main class="site-main product-set-opt">
    <div class="container">
        <div>
            <div class="url-page-box">
                <div class="page-address-box padding-addressBar">
                    <i style="padding-left:3px;" class="fa fa-home"></i>
                    <a href="<?= \f\ifm::app ()->siteUrl ?>"><span class="address-name">خانه</span></a>
                    <?php
                    $this->registerGadgets( [
                        'dateG' => 'date' ] );

                    if ( $amazing['amazing_price'] ){
                        $amazing_price = $amazing['amazing_price'];
                    } else {
                        $amazing_price = "0";
                    }
                    if ($brandDiscount) {
                        $brandDiscount = $brandDiscount;
                    } else {
                        $brandDiscount = "0";
                    }
                    if ( $specialSuggest['specialSuggest_price'] )
                    {
                        $specialSuggest_price = $specialSuggest['specialSuggest_price'];
                    } else {
                        $specialSuggest_price = "0";
                    }
                    end( $sortCat );
                    $key = key( $sortCat );
                    foreach ( $sortCat AS $data )
                    {
                        ?>
                        <span class="arrow-address5 fa fa-angle-right"></span>
                        <a class="address-name" href="<?= \f\ifm::app()->siteUrl . 'product/' . $sortCat[$key]['title_en'] ?>" title="<?= $data['title'] ?>"><?= $data['title'] ?></a>
                        <?php
                    }
                    ?>
                    <span class="arrow-address5 fa fa-angle-right"></span><span class="address-name"> <?= $row['title'] ?> </span>
                </div>
            </div>
        </div>
    </div>

    <div class="container page-address-box">
        <div class="copyName"><?= $row['title'] ?></div>
        <div class="row">
            <div class="page">
                <div class="main-content dynamic-product">
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
                                                        <div class="product-img-box col-sm-5 col-md-6 col-xs-12">
                                                            <div class="product-image">
                                                                <div class="product-image-gallery">
                                                                    <img id="image-main" class="gallery-image visible" src="<?= \f\ifm::app ()->fileBaseUrl . $row['picture']?>" alt="<?= $row['title'] ?>" title="<?= $row['title'] ?>">
                                                                    <input type="hidden" value="<?=$row['picture'];?>" name="picSerial" id="picSerial"/>
                                                                </div>
                                                            </div>
                                                            <div class="more-views">
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

                                                        <div class="product-shop is_carpet col-sm-5 col-md-6 col-xs-12">
                                                            <div class="product-name">
                                                                <h1><?=$row['title']?></h1>
<p><?=$row['short_explanation']?></p>
                                                                <a id="edit-img">
                                                                    <span class="fa fa-pencil-square-o"></span>
                                                                    درخواست ویرایش تصویر</a>
                                                            </div>
                                                            <div class="clearer"></div>
                                                            <div class="clr8c product-info">
                                                                <div class="product-options" id="product-options-wrapper">
                                                                    <div class="calculator-wrapper " style="display:block !important;">
                                                                        <div class="block block-calculator">
                                                                            <div>
                                                                                <small class="number">1</small>
                                                                                <strong><span>ابعاد مد نظر خود را به صورت لاتین (123) وارد کنید</span></strong>
                                                                            </div>
                                                                            <div class="block-content">
                                                                                <div class="inneri">
                                                                                    <div class="inputi">
                                                                                        <p class="inputi-f">طول (cm)<input type="text" size="5" name="room_width" id="room_width" onchange="handleChange(this);" onkeyup="ca.numberOnly(this,false);"></p>
                                                                                        <p class="inputi-f"> ارتفاع (cm)<input type="text" size="5" name="room_length" id="room_length" onchange="handleChange(this);" onkeyup="ca.numberOnly(this,false);"></p>
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
                                                                                    <span id="large_message">
                                                                                        <p><font color="#FF0000">Please contact one of our sales advisors about purchasing larger sizes than are available on our web site.</font></p>
                                                                                    </span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="block block-calculator">
                                                                            <div>
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
                                                                            <div>
                                                                                <small class="number">3</small>
                                                                                <strong><span>انتخاب نوع</span></strong>
                                                                            </div>
                                                                        </dt>
                                                                        <dd class="ddcerceve ">
                                                                            <div class="input-box">
                                                                                <ul id="options-59799-list" data-opt_code="cerceve" class="cerceve options-list">
                                                                                    <input type="hidden" id="product_price" name="product_price" value="<?=$priceList[0]['id']?>"/>
                                                                                    <?php
                                                                                    $firstPrice=$priceList[0]['majorPrice'];
                                                                                    foreach ($priceList as $data) {
                                                                                        $diff=$data['majorPrice']-$firstPrice;
                                                                                        ?>
                                                                                        <li class="cerceve i">
                                                                                            <input data-detail_code=""
                                                                                                   type="radio"
                                                                                                   class="radio  validate-one-required-by-name product-custom-option"
                                                                                                   name="options[59799]"
                                                                                                   id="options_59799_<?=$data['material_id']?>"
                                                                                                   value="4222<?=$data['material_id']?>"
                                                                                                   price="<?=$diff?>"  onclick="productPriceIdSet(<?=$data['id']?>)">
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
                                                                    <input type="hidden" id="priceVal"/>
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
                                    <?php
                                    if ( count($comments)>1 ) {
                                        ?>
                                        <ul id="frmUL_CommentsList">
                                            <?php foreach ( $comments AS $data )
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
                                                                                        <div class="user-comment-container" itemprop="review"
                                                                                             itemscope=""
                                                                                             itemtype="http://schema.org/Review">
                                                                                        </div>
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
                                                                                                                        <?php
                                                                                                                        for ( $i =0 ; $i < $data['rate'][$key] ; $i++ )
                                                                                                                        {
                                                                                                                            ?>
                                                                                                                            <div class="bar done"></div>
                                                                                                                            <?php
                                                                                                                        }

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
                                            ?>
                                        </ul>
                                        <?php
                                    }
                                    ?>
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

            <!-- The Modal -->
            <div id="myModal" class="modal fade in dir-rtl">

                <div class="modal-dialog">

                <!-- Modal content -->
                <div class="modal-content">
                    <div class="modal-header">

                       <span class="text" style="width:50%">
                             درخواست ویرایش تصویر
                       </span>
                        <span class="close" id="closeModel" style="width:50%;text-align: left;padding:0px !important;position: absolute;left:10px;top:10px;">&times;</span>
                    </div>
<div class="modal-body">
    <div class="info">
        <p>
            در صورت تمایل به تغییر سایز تصاویر ،تغییر رنگ تصاویر ، اضافه کردن
            نوشته و یا لوگو خود به تصویر ، پاک کردن قسمتی از تصویر و یا هر تغییر
            دیگری، فرم زیر را کامل کنید و درخواست خود را برای ما ارسال کنید. تیم
            طراحی درخواست شما را پیگیری کرده و نتیجه را به اطلا
        </p>
        <br>
    </div>

    <form name="customRequest" id="customRequest" enctype="multipart/form-data"  action="<?php echo \f\ifm::app()->siteUrl.'shop/product/submitCustomReq'?>">
        <input type="hidden" name="product_id" class="form-data" value="<?=$row['id']?>"/>
        <div class="form-group">
            <label class="control-label col-sm-2" for="nameFamily">نام و نام خانوادگی:</label>
            <div class="col-sm-10 marginBtn10">
                <input type="text" class="form-control form-data" name="nameFamily" required="required" id="nameFamily" placeholder="نام و نام خانوادگی خود را وارد کنید.">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="callNumber">شماره تماس:</label>
            <div class="col-sm-10 marginBtn10">
                <input type="text" class="form-control form-data" name="callNumber" id="callNumber" required="required" placeholder="شماره تماس خود را وارد کنید.">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="email">پست الکترونیک:</label>
            <div class="col-sm-10 marginBtn10">
                <input type="email" class="form-control form-data" name="email" id="email" placeholder="پست الکترونیکی خود را وارد کنید.">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="width" >طول (سانتی متر):</label>
            <div class="col-sm-10 marginBtn10">
                <input type="text" class="form-control form-data" name="width" id="width" required="required" placeholder="طول مورد نظر خود برای پوستر را انتخاب کنید.">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="height">ارتفاع (سانتی متر):</label>
            <div class="col-sm-10 marginBtn10">
                <input type="text" class="form-control form-data " name="height" required="required" id="height" placeholder="ارتفاع مورد نظر خود برای پوستر را وارد کنید.">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="imageUpload">آپلود لوگو:</label>
            <div class="col-sm-10 marginBtn10">
                <input type="file" name="fileImg" class="form-data" id="picField"  onchange="filePreview(this)"/>
                <img src="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/img/no-image-icon-6.png" id="outImage"/>
            </div>
        </div>
        <div class="form-group">

            <label class="control-label col-sm-2" for="height">توضیحات:</label>
            <div class="col-sm-10 marginBtn10">
                <textarea name="description" class="form-data" rows="4" required="required"></textarea>
            </div>
        </div>

        <br></br>
        <div id="resume"></div>
        <div id="picture"></div>
        <div class="col-md-12">
            <button type="submit" id="my-btn" class="btn btn-primary leftFloat" onclick="AJAXform( 'customRequest', 'my-btn', 'message', 'post' )" ><i class="fa fa-save"></i> ارسال</button>

        </div>
        <div class="clearfix"></div>
    </form>
    <div id="message" >

    </div>
</div>
</div>
                </div>
            </div>

    </div>
</main>
​<style>
    /* The Modal (background) */
    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        padding-top: 100px; /* Location of the box */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }

    .modal-header .close{
        float:left;
    }
    .modal-dialog{
        width: 80% !important;
        max-width:80% !important;
    }
    /* Modal Content */
    .modal-content {
        background-color: #fefefe;
        margin: auto;
        border: 1px solid #888;
        width: 80% !important;
    }

    .send_product_form{
        margin-top:100px;
    }
    .modal-body{
    }
    .modal-body .form-group .form-control {
        float:left;
        width:100%;
        text-align: right;
    }
    .modal-content .text{
        padding-top:10px;
    }
    /* The Close Button */
    .close {
        color: #aaaaaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: #000;
        text-decoration: none;
        cursor: pointer;
    }
    #edit-img{
        color:#00ade6 !important;
    }
    img#outImage{
        max-width:180px;
        float:left;
        margin-top:20px;
        margin-bottom: 20px;
    }
    input[type=file]#picField{
        padding:10px;
        float:right;
    }
    .successDialog{
        z-index: 1000;
    }
    .close{
        position: absolute;
    }
    .modal-header{
        padding-top:0px !important;
    }
</style>


<script>
    // Get the modal
    var modal = document.getElementById('myModal');

    // Get the button that opens the modal
    var btn = document.getElementById("edit-img");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks the button, open the modal
    btn.onclick = function() {
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    //رفتن به قسمت نظرسنجی و امتیازدهی
    function goToRate() {
        var urlAddress=jQuery('#siteUrl').val()+'shop/product/goToRateOrLogin';
        var request=jQuery.ajax({
            url: urlAddress,
            method: "POST",
            dataType: "html"
        });
        request.done(function( msg ) {
           showResultGoToRate(msg);
        });
    }

    function showResultGoToRate(param) {
        if (param.result == 'success') {
            window.location.href = '<?= \f\ifm::app()->siteUrl . 'rate/' . $row['id'] ?>';
        } else {
            window.location.href = '<?= \f\ifm::app()->siteUrl ?>login';
        }
    }
    ///////////////////////////////////////


</script>
<script type="text/javascript">
    function productPriceIdSet(price_id){
        jQuery('#product_price').val(price_id);
    }

    jQuery(function($){
        $(document).ready(function() {
            $(".pro_image").fancybox();
         //   $('.counter-number').text($('#basketSidebar #numItems').text());
        });
    });

    var tabdil=function(m){
        var num=JSON.parse('{"۰":"0","۱":"1","۲":"2","۳":"3","۴":"4","۵":"5","۶":"6","۷":"7","۸":"8","۹":"9"}');
        return m.replace(/./g,function(c){
            return (typeof num[c]==="undefined")?
                ((/\d+/.test(c))?c:''):
                num[c];
        });
    }

    function sendProductForm(){
        var option= {
            name_family:jQuery('.sender_name').val(),
            call_number:jQuery('.sender_phone').val(),
            email:jQuery('.sender_email').val(),
            width:jQuery('.sender_width').val(),
            height:jQuery('.sender_height').val(),
            message:jQuery('.sender_message').val()
        };
        var urlAddress=jQuery('#siteUrl').val()+'shop/product/sendCustomProductRequest';
        var request=jQuery.ajax({
            url: urlAddress,
            data:option,
            method: "POST",
            dataType: "html"
        });
        request.done(function(data) {
           // console.log(data['result']);
          /*  if() {
                alert('پیام شما با موفقیت ارسال شد');
            }*/
            });
    }

    function sendAddToCart() {
        widgetHelper.tt('ui', 'shop.product.sendAddToCart', option, 'getBasketSidebar');
    }

    function prepareSubmit(e, data){
        var id=<?= $row['id'] ?>;
        var count=jQuery('#pro'+id).find('.number').text();
        //get price id from attribute data for check stock and add to user orders
        var $j = jQuery.noConflict();
       if( $j('.product-shop').hasClass('is_carpet') ) {
            $c_data       = $j.parseJSON( $j('input.crop_image').val() );
            $c_data.mirror= $j('input[type=checkbox]#mirror:checked').val();
            $c_data.grayscale= $j('input[type=checkbox]#grayscale:checked').val();
            $c_data.image = $j('img#image-main').attr('src');
            $c_data.imgAttr =$j('.cropper-crop-box').attr('style');
            $c_data.masterImg=$j('.cropper-bg').attr('style');
            $c_data.typeProduct='dynamic';
            $c_data.priceId=jQuery(".button-addToCart").attr("data");
            $c_data.product_id= id;
            $c_data.product_price_id=jQuery('#product_price').val();
            $c_data.typeOpr='addToCart';
            $c_data.dynamicOpr='dynamic';
            $c_data.serialImage=$j('#picSerial').val();
            $c_data.product_price=$j('#priceVal').val();
            $c_data.width=$j('#room_width').val();
            $c_data.height=$j('#room_length').val();
            $c_data.material=$j('#material').val();
            $j.ajax({
                type: "POST",
                url: jQuery('#siteUrl').val()+'shop/product/sendAddToCart',
                dataType: 'json',
                data: $c_data,
                success: function(data){
                $j('input.crop_image').val(data.image);
                var urlAddr=$j('#siteUrl').val();
                    window.location=urlAddr+'cart';
                // getBasketSidebar(data);
            },
            failure: function(errMsg) {
                alert(errMsg);
             }
            });
        } else{
            productAddToCartForm.submit(data);
        }
    }
    jQuery('.nav-tab li').click(function () {
       jQuery('.nav-tab li').removeClass('active');
       jQuery(this).addClass('active');
       var k=jQuery(this).find('a').attr('href');
       var s=k.substring(1);
       jQuery('.tab-container>div.tab-panel').removeClass('active');
       jQuery('.tab-container>div#'+s).addClass('active');

   });
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

            //
            if( store_code === 'papier') {
                currencyPrice = currencyPrice * (1+taxPercent/100);
            }

            var currencyPriceInclTax = currencyPrice * (1+taxPercent/100);
            //currencyPriceInclTax = currencyPriceInclTax.toFixed(2);

            //var total_price =  optionsPrice.formatPrice(total);

            var excludeTax = optionsPrice.formatPrice(currencyPrice);
            var includeTax = optionsPrice.formatPrice(currencyPriceInclTax);
            document.getElementById("priceVal").value = currencyPrice;
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
            //$('#priceValue').val(includeTax);
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
<script>
    function refreshAttached2(params){
        var firstFileUrl = "<?= \f\ifm::app ()->fileBaseUrl ?>" + params.fileId[0];

        $('#attach2').html('<a href="' + firstFileUrl + '" target="_blank" ><i class="fa fa-picture-o"></i> تصویر پیوست شده</a>');
        setTimeout(function () {
            window['closeFileDialog' + runningFuncRandName]();
        }, 100);
    }
   function AJAXform( formID, buttonID, resultID, formMethod = 'post' ){
        var selectForm = document.getElementById(formID); // Select the form by ID.
        var selectButton = document.getElementById(buttonID); // Select the button by ID.
        var selectResult = document.getElementById(resultID); // Select result element by ID.
        var formAction = document.getElementById(formID).getAttribute('action'); // Get the form action.
        var formInputs = document.getElementById(formID).querySelectorAll(".form-data"); // Get the form inputs.

        //input forms
        var name = document.getElementById("nameFamily").value;
        var callNumber = document.getElementById("callNumber").value;
        var email = document.getElementById("email").value;
        var width = document.getElementById("width").value;
        var email = document.getElementById("email").value;
        var height = document.getElementById("height").value;

        function XMLhttp(){
            var httpRequest = new XMLHttpRequest();
            var formData = new FormData();
            for( var i=0; i < formInputs.length; i++ ){
                formData.append(formInputs[i].name, formInputs[i].value); // Add all inputs inside formData().
            }

            var fileInput = document.getElementById('picField');
            var file = fileInput.files[0];
            formData.append('file', file);
            
            httpRequest.onreadystatechange = function(){
                if ( this.readyState == 4 && this.status == 200 ) {
                    selectResult.style.display='block';
                    selectResult.innerHTML = this.responseText; // Display the result inside result element.
                    for( var i=0; i < formInputs.length; i++ ){
                        formInputs[i].value=''; // Add all inputs inside formData().
                    }
                }
            };
            httpRequest.open(formMethod, formAction);
            httpRequest.send(formData);
            //document.getElementById("message").style.display='block';
        }
        selectButton.onclick = function(){ // If clicked on the button.
            XMLhttp();
        }
        selectForm.onsubmit = function(){ // Prevent page refresh
            return false;
        }
    }

</script>

