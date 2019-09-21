<!-- page content -->
<main class="page-content rtl desktop-view" style="background-color: #eeeff1">
    <div class="container">
        <div class="row">
            <div class="url-page-box">
                <div class="page-address-box padding-addressBar">
                    <span class="address-name">
                        <a href="<?= \f\ifm::app()->siteUrl ?>">
                            <i style="padding-left:3px;" class="fa fa-home"></i><span class="address-name">خانه</span>
                        </a>
                    </span>


                    <span class="arrow-address5 fa fa-angle-left"></span>
                    <span class="address-name">
                        <a href="<?= \f\ifm::app()->siteUrl . 'cart' ?>">
                            سبد خرید
                        </a>
                    </span>

                    <span class="arrow-address5 fa fa-angle-left"></span>
                    <span class="address-name">
                        <a href="<?= \f\ifm::app()->siteUrl . 'shipping' ?>">
                            اطلاعات ارسال سفارش
                        </a>
                    </span>
                    <span class="arrow-address5 fa fa-angle-left"></span>
                    <span class="address-name">بازبینی سفارش</span>
                </div>
            </div>
        </div>
    </div>
    <div class="container grid-row section-mainDetail div-line-height">
        <?php
        if ($row) {
            ?>
            <div class="col-md-12">
                <div class="head">
                    <div class="raysan-button-container-review hasIcon step_forward setting-text-left">

                        <a id="lkstepShipping" class="raysan-button green" onclick="goPageBankOrCheckout()">
                            <i class="icon raysan-button-icon raysan-button-icon-caretLeft"></i>

                            <span class="raysan-button-label clearfix">
                                <span class="raysan-button-labelname">تایید و انتخاب شیوه پرداخت </span>
                            </span>
                        </a>
                    </div>
                    <h2 class="title right setting-text-right"><i class="fa fa-refresh"></i> بازبینی سفارش</h2>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-md-12 container-cart">
                <div class="col-md-5  padding-0-col">
                    <div class="thead border">
                        <p>شرح محصول</p>
                    </div>
                </div>
                <div class="col-md-1  padding-0-col">
                    <div class="thead border">
                        <p>تعداد</p>
                    </div>
                </div>
                <div class="col-md-2  padding-0-col">
                    <div class="thead border">
                        <p>قیمت واحد</p>
                    </div>
                </div>
                <div class="col-md-3  padding-0-col">
                    <div class="thead border">
                        <p>قیمت کل</p>
                    </div>
                </div>
                <div class="col-md-1  padding-0-col">
                    <div class="thead border">
                        <p>ویرایش</p>
                    </div>
                </div>

            </div>
            <?php
            //\f\pre($row);
            foreach ($row AS $data) {

                if($data["gift"]=="no") {
                    $price = $data['price'] * $data['count'];
                    $discount=$data['discountEnd']*$data['count'];
                    $priceSumCart = $priceSumCart + ($price - ($discount));
                    $priceTotal += $price;
                    $discountTotal += $discount;
                    ?>
                    <div class="col-md-12 container-cart">
                        <div class="col-md-5  padding-0-col">
                            <div class="tbody border">
                                <div class="pd" style="height: 110px;">
                                    <div class="col-md-2">
                                        <div class="pic" style="vertical-align:middle">
                                            <a href="<?= \f\ifm::app()->siteUrl ?>productDetail/<?= $data['product_id'] ?>"
                                               target="_blank">
                                                <?php
                                                //\f\pre($data);
                                                if($data['dynamic']=='true'){
                                                   /// \f\pre($data['product_pic']);
                                                    ?>
                                                    <img style="width: 100% !important;height: 50%;vertical-align: middle;margin-top: 20%;"
                                                         src="<?=  $data['product_pic'] ?>"
                                                         alt="<?= $data['productTitle'] ?>" title="<?= $data['productTitle'] ?>"
                                                         class="img-responsive">
                                                    <?php
                                                }else{
                                                   // \f\pre($data['product_pic']);
                                                    ?>
                                                    <img style="width: 100% !important;height: 50%;vertical-align: middle;margin-top: 20%;"
                                                         src="<?= \f\ifm::app()->fileBaseUrl . $data['picture'] ?>"
                                                         alt="<?= $data['productTitle'] ?>" title="<?= $data['productTitle'] ?>"
                                                         class="img-responsive">
                                                <?php
                                                }
                                                ?>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="desc phone-proper-en" style="text-align: right;vertical-align: top">
                                            <h2>
                                                <a href="<?= \f\ifm::app()->siteUrl ?>productDetail/<?= $data['product_id'] ?>"
                                                   target="_blank"
                                                   style="color:#000;font-size: 15px;"><?= $data['productTitle'] ?></a>
                                            </h2>
                                            <h4>
                                                <a href="<?= \f\ifm::app()->siteUrl ?>productDetail/<?= $data['product_id'] ?>"
                                                   target="_blank"
                                                   style="color:#000"><?= $data['productTitleSub'] ?> </a>
                                            </h4>
                                            <?php
                                            if($data['dynamic']!='true') {
                                                ?>
                                                <p class="color">
                                                    رنگ:
                                                    <span>
                                                <i id="iProductColor"
                                                   style="background-color:<?= $data['colorCode'] ?>">
                                                </i><?= $data['colorTitle'] ?>
                                            </span>
                                                </p>

                                                <p class="warranty">
                                                    <?= $data['guranteeTitle'] != "" ? " - " . $data['guranteeTitle'] : "" ?>
                                                </p>
                                                <?php
                                            }else{
                                                ?>
                                                <span style="width:70px;display: inline-block;color:#000">اندازه : </span>
                                                <span><?= $data['size'] ?></span>
                                                <?php
                                            }
                                            ?>
                                            <p class="warranty" style="font-size: 12px;">
                                                <?= $data['guranteeTitle'] ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-1  padding-0-col">
                            <div class="tbody border">
                                <div class="pd">
                                    <div class="unitnumber-container-cart fa-digit"
                                         style="position:relative;top:40%;color: #000;">
                                        <?= $data['count'] ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2  padding-0-col">
                            <div class="tbody border">
                                <div class="pd">
                                <span class="unitprice fa-digit" style="position:relative;top: 40%;"
                                      id="unitprice_<?= $data['orderItem_id'] ?>">
                                    <?php  echo number_format($data['price']);?></span><span
                                            class="toman" style="position:relative;top: 40%;">ریال</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3  padding-0-col">
                            <div class="tbody border">
                                <div class="pd">

                                    <div style="position:relative;text-align: right">
                                        <div class="col-md-5">
                                            قیمت کل :
                                        </div>
                                        <div class="col-md-7">
                                        <span class="unitprice price-total-product fa-digit"
                                              id="span_price_all_<?= $data['orderItem_id'] ?>"><?= number_format($price) ?></span>
                                            <span class="toman" style="position:relative;">ریال</span>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div style="position:relative;text-align: right" class="dicountP">
                                        <div class="col-md-5"><?= $data['discount_type'] == 'amazing' ? 'شگفت انگیز :' : 'تخفیف :' ?></div>
                                        <div class="col-md-7">
                                        <span class="discount-product fa-digit"
                                              id="span_price_discount_<?= $data['orderItem_id'] ?>"
                                              style="font-size:17px"><?= number_format($data['discountEnd']*$data['count']) ?></span>
                                            <span class="toman">ریال</span>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div style="position:relative;" class="sepDivDashCart"></div>
                                    <div style="position:relative;text-align: right">
                                        <div class="col-md-5">

                                        </div>
                                        <div class="col-md-7">
                                        <span class="unitprice green span_price_cart fa-digit"
                                              id="span_price_cart_<?= $data['orderItem_id'] ?>"><?= number_format($price - ($data['discountEnd']*$data['count'])) ?></span>
                                            <span class="toman green" style="">ریال</span>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>

                                </div>
                                <input type="hidden" id="product_price_id_<?= $data['orderItem_id'] ?>"
                                       value="<?= $data['product_price_id'] ?>">
                                <input type="hidden" id="product_old_count_<?= $data['orderItem_id'] ?>"
                                       value="<?= $data['count'] ?>">
                                <input type="hidden" id="product_price_<?= $data['orderItem_id'] ?>"
                                       value="<?= $data['price'] ?>">
                                <input type="hidden" id="product_discount_<?= $data['orderItem_id'] ?>"
                                       value="<?= $data['discount_price'] ?>">
                            </div>
                        </div>
                        <div class="col-md-1  padding-0-col">
                            <div class="tbody border">
                                <div class="pd last">
                                    <a class="btnDeleteCart" href="<?= \f\ifm::app()->siteUrl . 'cart' ?>"
                                       style="font-size: 20px;color: #2767dd;height: 149px;position:relative;top: 40%;">
                                        <i class="fa fa-edit" title="ویرایش"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <?php
            }
            ?>
            <div class="col-md-12">
                <div class="col-md-6 right ">
                    <?php
                    if($data["gift"]=="yes") {
                        ?>
                        <div class="row borderCol">
                            <div class="col-md-1">
                                <div>
                                <span style="-webkit-transform: rotate(90deg);
    -webkit-transform-origin: left top;
    -moz-transform: rotate(90deg);
    -moz-transform-origin: left top;
    -ms-transform: rotate(90deg);
    -ms-transform-origin: left top;
    -o-transform: rotate(90deg);
    -o-transform-origin: left top;
    transform: rotate(90deg);transform-origin: left top;

    position: absolute;
    top: 50%;
    left: 100%;
    white-space: nowrap;
    font-size: 18px;width:100%;">هدیه</span></div>
                            </div>
                            <div class="col-md-2">

                                <img src="<?= \f\ifm::app()->fileBaseUrl . $data['picture'] ?>"
                                     alt="<?= $data['productTitle'] ?>"
                                     title="<?= $data['productTitle'] ?>"
                                     class="img-responsive">

                            </div>
                            <div class="col-md-9">
                                <?=$data["productTitle"]?>
                                <div class="detialsGiftPro">
                                    <p class="color" style="font-size: 12px;">
                                        رنگ: <span style="font-size: 12px;"><i id="iProductColor"
                                                                               style="background-color:<?= $data['colorCode'] ?>"></i><?= $data['colorTitle'] ?></span>
                                    </p>
                                    <p class="warranty" style="font-size: 12px;">
                                        <?= $data['guranteeTitle'] ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
                <div class="col-md-6  left" style="padding: 0px!important;">
                    <div class="finalprice ">
                        <div class="total clearfix">
                            <span class="label">جمع کل خرید شما :</span>
                            <p class="label-price left">
                                <span class="price-total-cart fa-digit"><?= number_format($priceTotal) ?></span>
                                <span class="toman">ریال</span>
                            </p>
                        </div>
                        <div class="shipping clearfix">
                            <span class="label brown-color">هزینه بسته بندی و ارسال :</span>
                            <p class="label-price brown-color left">
                                <span class="discount-total-cart brown-color fa-digit"><?= number_format($orderTransport['transportation_cost']) ?></span>
                                <span class="toman brown-color">ریال</span>
                            </p>
                        </div>
                        <div class="discount clearfix">
                            <span class="label red-color">تخفیف شما : </span>
                            <p class="label-price red-color left">
                                <span class="discount-total-cart red-color fa-digit"><?= number_format($discountTotal) ?></span>
                                <span class="toman red-color">ریال</span>
                            </p>
                        </div>
                        <div class="payable clearfix">
                            <span class="label white-color">مبلغ قابل پرداخت :</span>
                            <p class="label-price white-color left">
                                <span class="price-sum-cart fa-digit"><?= number_format($priceSumCart + $orderTransport['transportation_cost']) ?></span>
                                <span class="toman white-color">ریال</span>
                            </p>
                            <input type="hidden" id="price-sum-cart" name="price-sum-cart" value="<?= $priceSumCart ?>">
                        </div>
                    </div>
                </div>
            </div>


            <div class="review">
                <div class="col-md-12">
                    <h2 class="title2 right">
                        <i class="icon icon-caret-left-blue"></i> اطللاعات ارسال سفارش
                    </h2>
                    <div class="clearfix"></div>
                </div>
                <div class="col-md-12 container-cart way-send-product" style="margin-bottom: 0px">
                    <div class="col-md-1  padding-0-col">
                        <div class="tbody border way-send-product-tbody" style="cursor: pointer;">
                            <div class="pd-way">
                                <i class="icon icon-review-location"></i>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-11  padding-0-col">
                        <div class="tbody border way-send-product-tbody">
                            <div class="pd-way" style="padding: 5px">
                                <p class="right fa-digit">
                                    <?php
                                    if ($member['gender'] == 'male') {
                                        ?>
                                        <?= 'این سفارش حضور جناب آقای ' . $member['name'] . ' به آدرس ' . $member['city_title'] . ' - ' . $member['address'] . ' و شماره تماس ' . $member['mobile'] . ' ارسال می گردد. ' ?>
                                        <?php
                                    } else if ($member['gender'] == 'female') {
                                        ?>
                                        <?= 'این سفارش حضور سرکار خانم ' . $member['name'] . ' به آدرس ' . $member['city_title'] . ' - ' . $member['address'] . ' و شماره تماس ' . $member['mobile'] . ' ارسال می گردد. ' ?>
                                        <?php
                                    } else {
                                        ?>
                                        <?= 'این سفارش حضور جناب آقای / سرکار خانم ' . $member['name'] . ' به آدرس ' . $member['city_title'] . ' - ' . $member['address'] . ' و شماره تماس ' . $member['mobile'] . ' ارسال می گردد. ' ?>
                                        <?php
                                    }
                                    ?>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 container-cart way-send-product">
                    <div class="col-md-1  padding-0-col">
                        <!--                    <div class="thead border">
                                                <p>انتخاب</p>
                                            </div>-->
                        <div class="tbody border way-send-product-tbody" style="cursor: pointer;">
                            <div class="pd-way">
                                <i class="icon icon-review-car"></i>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-11  padding-0-col">
                        <div class="tbody border way-send-product-tbody">
                            <div class="pd-way" style="padding: 5px">
                                <p class="right fa-digit">
                                    <?= 'این سفارش از در تاریخ ' . $orderTransport['date_delivery'] . ' و در ساعت '.$orderTransport['time_delivery'].' به شما تحویل داده خواهد شد.' ?>

                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <br>
            <div class="col-md-12">
                <div class="addtocart">
                    <div class="foot">
                        <div class="btn-foot">
                            <div class="raysan-button-container-review right">

                                <a href="<?= \f\ifm::app()->siteUrl . 'shipping' ?>" class="raysan-button dark-blue"
                                   id="btnBack">
                                    <span class="raysan-button-label clearfix">
                                        <span class="raysan-button-labelname"> اطلاعات ارسال سفارش</span>
                                    </span>
                                </a>

                            </div>
                            <div class="raysan-button-container-review hasIcon step_forward left setting-text-left">

                                <a id="lkstepShipping" class="raysan-button green" onclick="goPageBankOrCheckout()">

                                    <i class="icon raysan-button-icon raysan-button-icon-caretLeft"></i>

                                    <span class="raysan-button-label clearfix">
                                        <span class="raysan-button-labelname">تایید و انتخاب شیوه پرداخت </span>
                                    </span>

                                </a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        } else {
            echo 'سبد خرید شما خالی است.';
        }
        ?>
    </div>
    <br>
    <div class="clearfix"></div>

    </div>
</main>

<main class="mobile-view rtl mobile-view-design" style="margin-top:10px">
    <div id="raysan-cart-prograsbar">
        <div id="ctl12_Progressbar_pnlSteps">

            <div class="steps">
                <div class="rounded_rectangle">
                    <div class="dashed clearfix">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                    <div class="rounded_rectangle_over step_review"></div>
                    <span id="ctl12_Progressbar_lblBullet_1" class="bullet login green tick">

                        <span class="spacer first"></span>
                        <a href="/cart" id="ctl12_Progressbar_lblTitle_1" class="s_title last2 green" data-url="/Cart">سبد خرید</a>
                        <span class="spacer second"></span>
                    </span>
                    <span id="ctl12_Progressbar_lblBullet_2" class="bullet or green tick">
                        <span class="spacer first"></span>
                        <a href="/shipping" id="ctl12_Progressbar_lblTitle_2" class="s_title green"
                           data-url="/Shipping">ارسال</a>
                        <span class="spacer second"></span>
                    </span>
                    <span id="ctl12_Progressbar_lblBullet_3" class="bullet pi green">
                        <span class="spacer first"></span>
                        <a href="/review" id="ctl12_Progressbar_lblTitle_3" class="s_title green" data-url="/review">بازبینی</a>
                        <span class="spacer second"></span>
                    </span>
                    <span id="ctl12_Progressbar_lblBullet_4" class="bullet finish">
                        <span class="spacer first"></span>
                        <a id="ctl12_Progressbar_lblTitle_4" class=" s_title first" data-url="/Payment">پرداخت</a>
                        <span class="spacer second"></span>
                    </span>

                    <div class="dashed gray clearfix">
                        <div></div>
                        <div></div>
                    </div>
                </div>
            </div>


        </div>
    </div>
    <?php
    $priceTotal = 0;
    $discountTotal = 0;
    $priceSumCart = 0;
    if ($row) {
        foreach ($row AS $data) {
            $price = $data['price'] * $data['count'];
            $discount=$data['discountEnd']*$data['count'];
            $priceSumCart = $priceSumCart + ($price - ($discount));
            $priceTotal += $price;
            $discountTotal += $discount;
            ?>
            <div class="grid-row section-mainDetail div-line-height"
                 style="margin: 5px;padding: 0px;position: relative">
                <div style="width:25%;float: right;text-align: center;padding: 20px 5px">
                    <a href="<?= \f\ifm::app()->siteUrl ?>productDetail/<?= $data['product_id'] ?>" target="_blank">
                        <?php
                       // \f\pre($data);
                        if($data['dynamic']=='true'){
                            ?>
                            <img style="width: 100% !important;height: 50%;vertical-align: middle;margin-top: 20%;"
                                 src="<?=$data['product_pic']?>"
                                 alt="<?= $data['productTitle'] ?>" title="<?= $data['productTitle'] ?>"
                                 class="img-responsive">
                            <?php
                        }else{
                            ?>
                            <img style="width: 100% !important;height: 50%;vertical-align: middle;margin-top: 20%;"
                                 src="<?= \f\ifm::app()->fileBaseUrl . $data['picture'] ?>"
                                 alt="<?= $data['productTitle'] ?>" title="<?= $data['productTitle'] ?>"
                                 class="img-responsive">
                        <?php
                        }
                        ?>
                    </a>
                </div>
                <div style="width:75%;float: right;padding: 10px 0px 0px 15px">
                    <div class="desc" style="text-align: right;vertical-align: top">
                        <h2><a href="<?= \f\ifm::app()->siteUrl ?>productDetail/<?= $data['product_id'] ?>"
                               target="_blank" style="color:#000"><?= $data['productTitle'] ?></a></h2>
                        <h4><a href="<?= \f\ifm::app()->siteUrl ?>productDetail/<?= $data['product_id'] ?>"
                               target="_blank" style="color:#aaa;font-size:11px"><?= $data['productTitleSub'] ?> </a>
                        </h4>
                        <br>
                        <div>
                            <span style="width:70px;display: inline-block;color:#000">رنگ : </span>
                            <span style="display: inline;color:#aaa"><?= $data['colorTitle'] ?> <i id="iProductColor"
                                                                                                   style="background-color:<?= $data['colorCode'] ?>"></i></span>
                        </div>
                        <div>
                            <span style="width:70px;display: inline-block;color:#000">گارانتی : </span>
                            <span style="display: inline;color:#aaa"><?= $data['guranteeTitle'] ?></span>
                        </div>
                        <div>
                            <span style="width:70px;display: inline-block;color:#000">تعداد : </span>
                            <span style="display: inline;color:#aaa" class="fa-digit">
                                <?php
                                echo $data['count']
                                ?>
                            </span>
                        </div>
                        <div>
                            <span style="width:70px;display: inline-block;color:#000">قیمت : </span>
                            <span style="display: inline;color:#aaa" class="fa-digit">
                                <?= number_format($price-$discount); ?>&nbsp;ریال
                            </span>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>


                <div style="position: absolute;top:0px;left: 0px;text-align: center;width: 0;height: 0;border-style: solid;border-width: 50px 50px 0 0;border-color: #E3F9FB transparent transparent ">
                </div>
                <a class="btnDeleteCart" href="<?= \f\ifm::app()->siteUrl . 'cart' ?>"
                   style="position: absolute;top:6px;left: 7px;color: #42A2E5;font-size:16px">
                    <i class="fa fa-pencil" title="ویرایش محصول"></i>
                </a>
            </div>
            <input type="hidden" id="product_price_id_<?= $data['orderItem_id'] ?>"
                   value="<?= $data['product_price_id'] ?>">
            <input type="hidden" id="product_old_count_<?= $data['orderItem_id'] ?>" value="<?= $data['count'] ?>">
            <input type="hidden" id="product_price_<?= $data['orderItem_id'] ?>" value="<?= $data['price'] ?>">
            <input type="hidden" id="product_discount_<?= $data['orderItem_id'] ?>"
                   value="<?= $data['discount_price'] ?>">

            <?php
        }
        ?>


        <?php
    }
    ?>

    <div style="background:#fff;border-bottom: 1px solid #ddd">
        <div class="col-xs-2" style="color:silver;padding-top: 25px">
            <i class="fa fa-map-marker fa-3x"></i>
        </div>
        <div class="col-xs-10">
            <p class="fa-digit" style="color:#444;padding: 15px 0px;text-align: justify">
                <?php
                if ($member['gender'] == 'male') {
                    ?>
                    <?= 'این سفارش حضور جناب آقای ' . $member['name'] . ' به آدرس ' . $member['city_title'] . ' - ' . $member['address'] . ' و شماره تماس ' . $member['mobile'] . ' ارسال می گردد. ' ?>
                    <?php
                } else if ($member['gender'] == 'female') {
                    ?>
                    <?= 'این سفارش حضور سرکار خانم ' . $member['name'] . ' به آدرس ' . $member['city_title'] . ' - ' . $member['address'] . ' و شماره تماس ' . $member['mobile'] . ' ارسال می گردد. ' ?>
                    <?php
                } else {
                    ?>
                    <?= 'این سفارش حضور جناب آقای / سرکار خانم ' . $member['name'] . ' به آدرس ' . $member['city_title'] . ' - ' . $member['address'] . ' و شماره تماس ' . $member['mobile'] . ' ارسال می گردد. ' ?>
                    <?php
                }
                ?>
            </p>
        </div>
        <div class="clearfix"></div>

    </div>
    <div style="background:#fff;padding-bottom: 60px">
        <div class="col-xs-2" style="color:silver;padding-top: 25px">
            <i class="fa fa-truck fa-3x"></i>
        </div>
        <div class="col-xs-10">
            <p class="fa-digit" style="color:#444;padding: 15px 0px;text-align: justify">
                <?= 'این سفارش از در تاریخ ' . $orderTransport['date_delivery'] . ' و در ساعت '.$orderTransport['time_delivery'].' به شما تحویل داده خواهد شد.' ?>
            </p>
        </div>
        <div class="clearfix"></div>

    </div>

    </div>
    <div class="clearfix"></div>

    <div onclick="goPageBankOrCheckout()"
         style="position:fixed;bottom: 0px;right: 0px;text-align: center;height: 40px;line-height: 40px;width: 100%;background: #3BB153;color:#fff;cursor: pointer;font-size: 15px">
        تایید و انتخاب شیوه پرداخت
        <i class="fa fa-arrow-left" style="font-size:18px;padding-right:5px;position: relative;top:3px"></i>
    </div>
</main>

<style>
    .desc.phone-proper-en > h4 {
        font-size: 12px;
    }

    .desc.phone-proper-en > h4 > a {
        color: grey !important;
    }

    .white-color {
        color: darkgreen !important;
    }

    .red-color {
        color: darkred !important;
    }

    .brown-color {
        color: #B29059 !important;
    }

    /* -- progressbar -- */

    #raysan-cart-prograsbar {
        background: #fff;
        height: 60px;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.1);
    }

    .steps {
        font-size: 12px;
        position: relative;
        padding-top: 5px;
    }

    .steps .rounded_rectangle {
        width: 72%;
        height: 2px;
        background-color: #dee1e7;
        border-radius: 15px;
        margin: 15px auto 15px;
        position: relative;
    }

    .steps .rounded_rectangle .rounded_rectangle_over {
        background: #62b965;
        height: 2px;
        position: absolute;
        right: 0;
        top: 0;
    }
    header {
        right: 0;
        position: relative;
        top: 0;
        width: 100%;
        z-index: 999;
    }

    .steps .rounded_rectangle .bullet {
        background: #fafafa;
        border: 3px solid #bec2cc;
        border-radius: 100%;
        display: block;
        height: 18px;
        position: absolute;
        top: -11px;
        width: 18px;
    }

    p.right.fa-digit {
        float: right;
        width: 100%;
        color: #000;
    }

    .leftProduct .col-lg-3, .col-md-3 {
        padding-left: 0px !important;
        padding-right: 0px !important;
    }

    .steps .rounded_rectangle .bullet .spacer {
        background: #fafcfc;
        display: inline-block;
        height: 20px;
        position: absolute;
        width: 9px;
    }

    .steps .rounded_rectangle .bullet .spacer.second {
        left: -12px;
    }

    .steps .rounded_rectangle .bullet .spacer.first {
        right: -12px;
    }

    .steps .rounded_rectangle .bullet .s_title {
        width: 140px;
        text-align: center;
        font-size: 14px;
        color: #818897;
        position: absolute;
        top: 20px;
        right: -60px;
    }

    .steps .rounded_rectangle .bullet.login {
        right: -1px;
    }

    .steps .rounded_rectangle .bullet.or {
        right: 33%;
    }

    .steps .rounded_rectangle .bullet.pi {
        right: 66%;
    }

    .steps .rounded_rectangle .bullet.finish {
        left: 0;
    }

    .steps .rounded_rectangle .step_user {
        width: 0;
        border: 0;
    }

    .steps .rounded_rectangle .step_shipping {
        width: 33%;
    }

    .steps .rounded_rectangle .step_review {
        width: 66%;
    }

    .steps .rounded_rectangle .step_payment {
        width: 100%;
    }

    .steps .rounded_rectangle .bullet.green {
        background: #ebffeb !important;
        border-color: #62b965;
    }

    .steps .rounded_rectangle .dashed {
        height: 2px;
        position: absolute;
        right: -42px;
        top: -2px;
    }

    .steps .rounded_rectangle .dashed div {
        background: #62b965 none repeat scroll 0 0;
        float: right;
        height: 2px;
        margin: 2px 3px;
        width: 11px;
    }

    .steps .rounded_rectangle .dashed.gray {
        position: absolute;
        right: auto;
        left: -43px;
    }

    .steps .rounded_rectangle .dashed.gray div {
        background: #dee1e7;
    }

    /* -- END progressbar -- */

    @media only screen and (max-width: 980px) {
        .btn-foot, .col-md-12.head {
            text-align: center !important;
        }

        .right {
            float: none !important;;
        }

        .left {
            float: none !important;;
        }
    }

    @media only screen and (max-width: 550px) {
        .steps .rounded_rectangle .bullet .s_title {
            font-size: 10px !important;
            right: -30px !important;
            width: 80px !important;
        }

        .steps .rounded_rectangle {
            width: 75% !important;
        }

        .finalprice {
            width: 100% !important;
        }

        .pd {
            height: auto !important;
        }

    }

    .sepDivDashCart {
        margin: 8px 0;
        border-bottom: 1px dashed #e9e9e9;
        height: 1px;
    }

    .dicountP, .dicountP .toman {
        color: #DD1E25;
    }

    #iProductColor {
        width: 15px;
        height: 15px;
        border: 1px solid rgba(0, 0, 0, .1);
        border-radius: 16px;
        display: inline-block;
        margin: 0 3px 0 10px;
        vertical-align: middle;
    }

    .padding-0-col {
        padding: 0px;
    }

    .container-cart .border {
        border: #ddd solid 1px;
        border-radius: 0px;
        text-align: center;
        padding: 5px;
        height: auto;
    }

    .raysan-button-container-review .raysan-button.dark-blue .raysan-button-label:hover {
        background-color: #666;
    }

    .raysan-button-container-review .raysan-button.dark-blue .raysan-button-label {
        background-color: #969ba8;
    }

    .raysan-button-container-review .raysan-button .raysan-button-label {
        color: #fff;
    }

    .raysan-button-container-review .raysan-button-label {
        margin-right: 0;
        padding: 0 25px;
        font-size: 13px;
    }

    .raysan-button-container-review.hasIcon.step_forward a.raysan-button:hover {
        background-color: #00b85d !important;
    }

    .raysan-button-container-review.hasIcon.step_forward a.raysan-button {
        background-color: #4caf50 !important;
    }

    .container-cart {
        margin-bottom: 0px;
    }

    .finalprice {

        border-radius: 0px;
        margin-bottom: 28px;
        text-align: right;
    }

    .finalprice .total {
        line-height: 55px;
        padding: 0px 15px;
        background: #ddd;
    }

    .clearfix {
        display: block;
    }

    .finalprice span.label {
        color: #000;
        font-size: 12px;
        display: inline-block;
        width: 145px;
        text-align: right;
    }

    .finalprice .total {
        line-height: 55px;
    }

    p.label-price {
        color: #000;
        font-size: 18px;
    }

    .toman {
        color: #666;
        font-size: 10px;
        letter-spacing: 0;
        margin-right: 10px;
        vertical-align: 2px;
    }

    .finalprice .sep {
        background-color: #c0f0c1;
        height: 1px;
    }

    .finalprice .discount {
        font-size: 14px;
        background-color: #EDCECF;
        border-radius: 0px;
        padding-right: 15px;
        padding-left: 15px;
        line-height: 55px
    }

    .finalprice div {

    }

    .finalprice .shipping {
        font-size: 14px;
        padding-right: 15px;
        padding-left: 15px;
        line-height: 55px;
        background-color: #F7DDAD;
        border-radius: 0px;
    }

    .finalprice .payable {
        font-size: 14px;
        background-color: #C9EABB;
        border-radius: 0px;
        padding-right: 15px;
        padding-left: 15px;
        line-height: 55px
    }

    .unitprice {
        color: #666666;
        font-size: 17px;
    }

    .div-line-height div {
        line-height: 22px;
    }

    .lastReview {
        border-left: 0;
        background: #66d9ff;
        border-right: 0;
    }

    .raysan-button-container-review {
        display: inline-block;
        line-height: 0;
        margin: 4px;
        min-height: 38px;
        overflow: hidden;
        float:left;
        cursor: pointer;
        -webkit-box-shadow: 0 2px 3px 0 rgba(0, 0, 0, .15);
        -ms-box-shadow: 0 2px 3px 0 rgba(0, 0, 0, .15);
        box-shadow: 0 2px 3px 0 rgba(0, 0, 0, .15);
    }

    .raysan-button-container-review.hasIcon.step_forward a.raysan-button {
        background-color: #4caf50 !important;
    }

    .raysan-button-container-review .raysan-button, .raysan-button-container-review .raysan-button i.raysan-button-icon {
        box-sizing: border-box;
        display: block;
        overflow: hidden;
    }

    .raysan-button-container-review .raysan-button {
        line-height: 0;
        text-decoration: none;
    }

    .green {
        color: #4caf50 !important;
    }

    .raysan-button-container-review.hasIcon.step_forward a.raysan-button i.raysan-button-icon {
        float: left;
        background-color: transparent !important;
    }

    .raysan-button-container-review .raysan-button i.raysan-button-icon.raysan-button-icon-caretLeft {
        background-position: -12px -554px;
    }

    .raysan-button-container-review.hasIcon .raysan-button i.raysan-button-icon {
        display: block;
        float: right;
        overflow: hidden;
        line-height: 38px;
        width: 54px;
        height: 40px;
    }

    .raysan-button-container-review.hasIcon.step_forward a.raysan-button span.raysan-button-label {
        background-color: transparent !important;
        margin-right: 0;
        margin-left: 54px;
        padding-left: 0;
    }

    .raysan-button-container-review .raysan-button .raysan-button-label {
        color: #fff;
    }

    .raysan-button-container-review .raysan-button-label {
        margin-right: 0;
        padding: 0 25px;
        font-size: 13px;
    }

    .raysan-button-container-review .raysan-button-label .raysan-button-labelname {
        display: block;
        height: 38px;
        line-height: 38px;
        text-align: center;
    }

    .title {
        color: #000;
        font-size: 18px;
        top: 15px;
        position: relative;

    }

    .col-md-12.head .title i {
        margin: 0 0 0 11px;
        top: 1px;
    }

    .icon-caret-left-blue {
        background-position: -36px -652px !important;
        height: 10px;
        width: 5px;
    }

    .paymentRowLast {
        border-bottom-style: none !important;
        background-color: #f7fff7 !important;
    }

    .paymentRowOff {
        border-bottom-style: none !important;
        background-color: #ffcccc !important;
    }

    .paymentRow:first-child {
        background-color: #f7f9fa;
        font-size: 15px;
    }

    .paymentRow {
        border-bottom: 1px solid #f0f1f2;
        padding: 10px;
    }

    .paymentRow:first-child {
        font-size: 15px;
    }

    .prepayedAmount .rowAmount {
        color: #4caf50;
    }

    .paymentRow .prepayedAmount .rowAmount {
        display: inline-block;
        margin-left: 5px;
        font-size: 18px;
    }

    .icon-review-location {
        background-position: -810px -205px;
        width: 18px;
        margin-top: 5px;
        height: 24px;
    }

    .icon-review-car {
        background-position: -806px -250px;
        width: 26px;
        height: 19px;
        margin-top: 10px;
    }

    .container-cart .thead {
        background: #eee;
        color: #000;

    }

    .title2 {
        color: #666;
        font-size: 16px;
        margin: 10px 0px;
    }

    p.label-price.left {
        float: left;
    }
    .borderCol{
        border:1px solid #d7dcdf;
        padding: 5px;
    }
    .detialsGiftPro{
        display: block;
    }
</style>
<script>

    $(document).ready(function () {
        var divHeight = $('.tbody').height();
        $('.pd').css('height', divHeight + 'px');
        var divHeight2 = $('.way-send-product').height();
        $('.way-send-product-tbody').css('height', divHeight2);
    });

    function redirectToBankOrCheckout() {
        var option = {
            id:<?= $row[0]['order_id'] ?>
        };
        widgetHelper.tt('ui', 'shop.order.pay', option, 'goPageBankOrCheckout');
    }

    function goPageBankOrCheckout() {
        window.location.href = '<?= \f\ifm::app()->siteUrl ?>payment';
    }
</script>
