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
                    <span class="address-name">
                        <a href="<?= \f\ifm::app()->siteUrl . 'review' ?>">
                            بازبینی سفارش
                        </a>
                    </span>
                    <span class="arrow-address5 fa fa-angle-left"></span>
                    <span class="address-name">پرداخت سفارش</span>
                </div>
            </div>
        </div>
    </div>
    <div class="container grid-row section-mainDetail">
        <div class="col-md-12">
            <div class="paymenthead">
                <h2 class="title right"><i class="fa fa-credit-card"></i> پرداخت سفارش</h2>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="voucher_cart" style="padding-right: 15px;padding-left: 15px;">
            <div class=" review-buy">

                <div class="col-md-12" style="text-align:right;background: #EDCECF;color:#666;padding-bottom: 20px">
                    <div class="col-md-7 right">
                        <h2 class="title2 right" style="color:#8B0000"><i class="fa fa-percent"></i>&nbsp;کد تخفیف </h2>
                        <p class="right">
                            اگر کد تخفیف از فروشگاه دارید و مایل هستید از آن استفاده کنید، کافیست کد آن را وارد کرده و
                            با انتخاب دکمه ثبت ، مبلغ آن از هزینه قابل پرداخت شما کسر می‌شود
                            .
                        </p>
                        <p class="right">

                        </p>
                    </div>
                    <div class="col-md-5">
                        <div class="voucherfrm">
                            <input type="text" name="offCode" class="form-control en"
                                   style="width:230px;height:35px;display: inline-block;border-radius: 0px !important;"
                                   placeholder="کد تخفیف را وارد کنید ...">
                            <button type="button" value="Submit" onclick="submitOffCode()" class="form-control">
                                ثبت کدتخفیف
                            </button>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <?php
        $discountCodePrice = 0;
        if ( !empty ( $orderDiscountCode ) )
        {
            ?>
            <div style="padding-right: 15px;padding-left: 15px;">

                <div class="" style="padding:10px 15px;background: #eee;color:#000;font-size:13px">
                    <div class="col-md-1">ردیف</div>
                    <div class="col-md-7">عنوان کد تخفیف</div>
                    <div class="col-md-3">میزان تخفیف</div>
                    <div class="col-md-1">حذف</div>
                    <div class="clearfix"></div>
                </div>
                <?php
                foreach ( $orderDiscountCode AS $data )
                {
                    $discountCodePrice += $data['discount_price'];
                    ?>
                    <div class=""
                         style="padding:10px 15px;background: #fff;color:#555;font-size:13px;border:1px solid #eee;border-top-width: 0px">
                        <div class="col-md-1 fa-digit"><?= ++$i ?></div>
                        <div class="col-md-7"><?= $data['title'] . ' ( ' . $data['credit_code'] . ' )' ?></div>
                        <div class="col-md-3 fa-digit"><?= number_format( $data['discount_price'] ) . ' ریال' ?></div>
                        <div class="col-md-1"><a href="javascript:void(0)"
                                                 onclick="removeDiscountCode(<?= $data['id'] ?>)"
                                                 style="color:#8B0000;font-size:15px"><i class="fa fa-times-circle"></i></a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <?php
                }
                ?>

            </div>
            <?php
        }
        ?>
        <div class="container-cart" style="padding-right: 15px;padding-left: 15px;">

            <div class="" style="padding:15px 30px;background: #C9EABB;color:#006400;font-size:16px">
                <span class="rowTitle right">مبلغ قابل پرداخت</span>
                <span class="prepayedAmount left">
                    <span class="rowAmount fa-digit"
                          id="priceEndPay"><?= number_format( ( $prices['price'] - $prices['discount'] - $prices['discount_price'] ) + $prices['transportation_cost'] - $discountCodePrice ) ?></span>
                    <span class="rowAmount fa-digit"
                          id="newPriceEndPay"></span>
                    <span class="rowCurrency">ریال</span>
                </span>
                <span class="prepayedAmount left dis_code">
                  <strong>
                    کد تخفیف با موفقیت اعمال شد
                  </strong>
                </span>
                <div class="clearfix"></div>
            </div>

        </div>

        <div class="order_payment_info clearfix container-cart">
            <div class="">
                <div class="col-md-12">
                    <h2 class="title2 right"><i class="icon icon-caret-left-blue"></i>&nbsp; شیوه پرداخت</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="payment">
                    <div class="col-md-12 way-send-product">
                        <div class="col-md-1  padding-0-col" style="background:#eee;">
                            <!--                    <div class="thead border">
                                                    <p>انتخاب</p>
                                                </div>-->
                            <div class="tbody border way-send-product-tbody" style="cursor: pointer;">
                                <div class="pd">
                                    <div class="radio-control">
                                        <input id="rbBank" type="radio" name="rbPayWay" value="onlinePay" checked="">
                                        <label for="rbBank" style="position:relative ;top: 25px;"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-11  padding-0-col" style="background:#eee;">
                            <div class="tbody border way-send-product-tbody">
                                <div class="pd " style="padding: 10px">
                                    <!--<img class=""  src="" alt="IconPath">-->
                                    <div class="raysan" style="text-align: right;margin-right: 10px" ;>
                                        <div class="col-md-12">
                                            <p class="title" style="margin: 0;">پرداخت اینترنتی</p>
                                        </div>
                                        <div class="col-md-12">
                                            <p class="desc">
                                                <label class="pull-right">
                                                    <input type="radio" name="bank" id="mellat" value="mellat" checked/>
                                                    <img src="<?= \f\ifm::app()->siteUrl . 'upload/mellat.png' ?>">
                                                </label>

                                            </p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="payment">
                    <div class="col-md-12  way-send-product">
                        <div class="col-md-1  padding-0-col" style="background:#eee;">
                            <div class="tbody border way-send-product-tbody" style="cursor: pointer;">
                                <div class="pd">
                                    <div class="radio-control">
                                        <input id="rbPlacePayPos" type="radio" name="rbPayWay" value="placePayPos">
                                        <label for="rbPlacePayPos" style="position:relative ;top: 25px"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-11  padding-0-col" style="background:#eee;">
                            <div class="tbody border way-send-product-tbody">
                                <div class="pd " style="padding: 10px">
                                    <!--<img class=""  src="" alt="IconPath">-->
                                    <div class="raysan" style="text-align: right;margin-right: 10px">
                                        <div class="col-md-12">
                                            <p class="title" style="margin: 0;"> پرداخت در محل به همراه دستگاه پرداخت</p>
                                        </div>
                                        <div class="col-md-12">
                                            <p class="desc">
                                                در هنگام تحویل گرفتن سفارش ، پرداخت را انجام خواهید داد.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="payment">
                    <div class="col-md-12  way-send-product">
                        <div class="col-md-1  padding-0-col" style="background:#eee;">
                            <div class="tbody border way-send-product-tbody" style="cursor: pointer;">
                                <div class="pd">
                                    <div class="radio-control">
                                        <input id="rbPlacePay" type="radio" name="rbPayWay" value="placePay">
                                        <label for="rbPlacePay" style="position:relative ;top: 25px"></label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-11  padding-0-col" style="background:#eee;">
                            <div class="tbody border way-send-product-tbody">
                                <div class="pd " style="padding: 10px">
                                    <!--<img class=""  src="" alt="IconPath">-->
                                    <div class="raysan" style="text-align: right;margin-right: 10px">
                                        <div class="col-md-12">
                                            <p class="title" style="margin: 0;">پرداخت در محل به صورت نقدی</p>
                                        </div>
                                        <div class="col-md-12">
                                            <p class="desc">
                                                در هنگام تحویل گرفتن سفارش ، پرداخت را انجام خواهید داد.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <div class="col-md-12" style="padding-right: 0px;padding-left: 0px;">
            <div class="addtocart">
                <div class="foot">
                    <div class="btn-foot">
                        <div class="col-md-6">
                            <div class="raysan-button-container-cart right" style="top: 0">

                                <a href="<?= \f\ifm::app()->siteUrl . 'review' ?>" class="raysan-button dark-blue"
                                   id="btnBack">
                                    <i class="icon raysan-button-icon raysan-button-icon-cartLeft"></i>

                                    <span class="raysan-button-label clearfix">
                                    <span class="raysan-button-labelname"> بازبینی سفارش</span>
                                </span>
                                </a>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="left">
                                <div class="raysan-button-container-cart hasIcon step_forward "
                                     style="top: 0;width: 200px;">

                                    <a id="lkstepShipping" class="raysan-button green"
                                       onclick="redirectToBankOrCheckout()">

                                        <i class="icon raysan-button-icon raysan-button-icon-caretLeft"></i>

                                        <span class="raysan-button-label clearfix">
                                        <span class="raysan-button-labelname">پرداخت و ثبت سفارش</span>
                                    </span>

                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="clearfix"></div>

    </div>
</main>
<main class="mobile-view rtl" style="margin-top:10px">
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
                    <div class="rounded_rectangle_over step_shipping"></div>
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
                    <span id="ctl12_Progressbar_lblBullet_3" class="bullet pi green tick">
                        <span class="spacer first"></span>
                        <a href="/review" id="ctl12_Progressbar_lblTitle_3" class="s_title green" data-url="/review">بازبینی</a>
                        <span class="spacer second"></span>
                    </span>
                    <span id="ctl12_Progressbar_lblBullet_4" class="bullet finish green">
                        <span class="spacer first"></span>
                        <a id="ctl12_Progressbar_lblTitle_4" class=" s_title first green" data-url="/Payment">پرداخت</a>
                        <span class="spacer second"></span>
                    </span>

                    <div class="dashed gray clearfix">
                        <div></div>
                        <div></div>
                        <div></div>
                        <div></div>

                    </div>
                </div>
            </div>


        </div>
    </div>
    <div class="voucher_cart">
        <div class="review-buy">

            <div class="col-md-12" style="text-align:right;background: #EDCECF;color:#666;padding: 5px">
                <div class="col-md-7 right">
                    <h2 class="title2 right" style="color:#8B0000"><i class="fa fa-percent"></i>&nbsp;کد تخفیف </h2>
                    <p class="right" style="text-align:justify;color:#666">
                        اگر کد تخفیف از فروشگاه دارید و مایل هستید از آن استفاده کنید، کافیست کد آن را وارد کرده و با
                        انتخاب <span class="submit">دکمه ثبت</span> ، مبلغ آن از هزینه قابل پرداخت شما کسر می‌شود .
                    </p>

                </div>
                <div class="col-md-5">
                    <div class="voucherfrm" style="margin:10px 0px">
                        <input type="text" name="offCode" class="form-control en"
                               style="width:66% !important;height:35px;display: inline-block;"
                               placeholder="کد تخفیف را وارد کنید ...">
                        <button type="button" value="Submit" onclick="submitOffCode()" class="form-control">
                            ثبت کدتخفیف
                        </button>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <?php
    $discountCodePrice = 0;
    if ( !empty ( $orderDiscountCode ) )
    {
        foreach ( $orderDiscountCode AS $data )
        {
            $discountCodePrice += $data['discount_price'];
            ?>
            <div class="grid-row section-mainDetail div-line-height"
                 style="margin: 5px;padding: 0px;position: relative;background: #fff">

                <div style="margin-left:55px;padding: 10px 10px 10px 0px">
                    <div style="color:#000;font-size: 13px"><?= $data['title'] . ' ( ' . $data['code'] . ' )' ?></div>
                    <div style="color:#8B0000" class="fa-digit">میزان تخفیف
                        : <?= number_format( $data['discount_price'] ) . ' تومان' ?></div>
                </div>

                <div style="position: absolute;top:0px;left: 0px;text-align: center;width: 0;height: 0;border-style: solid;border-width: 50px 50px 0 0;border-color: #EDCECF transparent transparent ">
                </div>
                <a onclick="removeDiscountCode(<?= $data['id'] ?>)"
                   style="position: absolute;top:6px;left: 7px;color: #8B0000;font-size:16px">
                    <i class="fa fa-times" title="حذف"></i>
                </a>
            </div>


            <?php
        }
    }
    ?>
    <div class="container-cart">

        <div class="" style="padding:15px;background: #C9EABB;color:#006400;font-size:16px">
            <div class="rowTitle" style="float:right">مبلغ قابل پرداخت</div>
            <div class="prepayedAmount" style="float:left">
                <span class="rowAmount faNumber fa-digit"
                      id="priceEndPay"><?= number_format( ( $prices['price'] - $prices['discount'] - $prices['discount_price'] ) + $prices['transportation_cost'] - $discountCodePrice ) ?></span>
                <span class="rowCurrency">ریال</span>
            </div>
            <div class="clearfix"></div>
        </div>

    </div>
    <div class="order_payment_info clearfix container-cart">
        <div class="">
            <div class="col-md-12">
                <h2 class="title2 right">شیوه پرداخت</h2>
                <div class="clearfix"></div>
            </div>
            <div class="payment">
                <div class="col-md-12 way-send-product">

                    <div class="tbody border way-send-product-tbody" style="background:#fff;border-bottom: 0px">
                        <div class="pd ">
                            <!--<img class=""  src="" alt="IconPath">-->
                            <div class="raysan" style="text-align: right;">
                                <div style="float:right;width:10%">
                                    <div class="pd">
                                        <div class="radio-control">
                                            <input id="rbBank" type="radio" name="rbPayWay" value="onlinePay"
                                                   checked="">
                                            <label for="rbBank"></label>
                                        </div>
                                    </div>
                                </div>
                                <div style="float:right;width:90%;padding-top: 2px">
                                    <p class="title" style="margin: 0;">پرداخت اینترنتی</p>
                                    <p class="desc">

                                        <label class="pull-right" style="margin-left:10px">
                                            <input type="radio" name="bank" id="mellat" value="mellat" checked/>
                                            <img src="<?= \f\ifm::app()->siteUrl . 'upload/mellat.png' ?>"
                                                 style="width:42px">
                                        </label>

                                    </p>
                                </div>


                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="payment">
                <div class="col-md-12  way-send-product">
                    <div class="tbody border way-send-product-tbody" style="background:#fff">
                        <div class="pd ">
                            <div class="raysan" style="text-align: right;">
                                <div style="float:right;width:10%">
                                    <div class="radio-control">
                                        <input id="rbPlacePay" type="radio" name="rbPayWay" value="placePay">
                                        <label for="rbPlacePay"></label>
                                    </div>
                                </div>
                                <div style="float:right;width:90%;padding-top: 2px">
                                    <p class="title">
                                       پرداخت در محل به صورت نقدی
                                    </p>
                                    <p class="desc">
                                        در هنگام تحویل گرفتن سفارش ، پرداخت را انجام خواهید داد.
                                    </p>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


            <div class="payment">
                <div class="col-md-12 container-cart way-send-product">
                    <div class="tbody border way-send-product-tbody" style="background:#fff">
                        <div class="pd ">
                            <div class="raysan" style="text-align: right;">
                                <div style="float:right;width:10%">
                                    <div class="radio-control">
                                        <input id="rbPlacePayPos" type="radio" name="rbPayWay" value="placePayPos">
                                        <label for="rbPlacePayPos"></label>
                                    </div>
                                </div>
                                <div style="float:right;width:90%;padding-top: 2px">
                                    <p class="title">
                                       پرداخت در محل به همراه دستگاه کارت خوان
                                    </p>
                                    <p class="desc">
                                        در هنگام تحویل گرفتن سفارش ، پرداخت را انجام خواهید داد.
                                    </p>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <div onclick="redirectToBankOrCheckout()"
         style="position:fixed;bottom: 0px;right: 0px;text-align: center;height: 40px;line-height: 40px;width: 100%;background: #3BB153;color:#fff;cursor: pointer;font-size: 15px">
        پرداخت و ثبت سفارش
        <i class="fa fa-arrow-left" style="font-size:18px;padding-right:5px;position: relative;top:3px"></i>
    </div>
</main>

<style>
    h2.title.right {
        float: right;
    }

    label > input + img {
        cursor: pointer;
    }

    label > input:checked + img {
        background: #fff;
        border-radius: 4px;
        padding: 5px;
    }

    label > input {
        display: none;
    }

    @media only screen and (max-width: 980px) {
        .head {
            text-align: center !important;
        }

        .right {
            float: none !important;;
        }

        .left {
            float: none !important;;
        }
    }

    header {
        right: 0;
        position: relative;
        top: 0;
        width: 100%;
        z-index: 999;
    }

    @media only screen and (max-width: 500px) {
        .review-buy .head .title {
            margin-top: 20% !important;
        }

        .steps .rounded_rectangle .bullet .s_title {
            font-size: 10px !important;
            right: -30px !important;
            width: 80px !important;
        }

        .steps .rounded_rectangle {
            width: 75% !important;
        }

        .radio2 {
            top: 0px !important;
        }

        .tbody, .tbody-2, .pd {
            height: auto !important;
            min-height: 80px !important;
        }

        .voucherfrm input[type=text] {
            width: 100% !important;
        }

        label > input:checked + img {
            background: #eee;
            border-radius: 4px;
            padding: 5px;
            margin: 5px 0px 0px 5px;
        }

    }

    /* payement */

    .items div.right {
        margin-right: 20px;
    }

    .items div.right .title {
        color: #4d4d4d;
        font-family: yekan;
        font-size: 14px;
        position: relative;
        top: -2px;
    }

    .voucher_cart_inner .wrap p {
        line-height: 30px;
        color: #777;
        font-size: 16px;
    }

    .voucherfrm {
        margin-left: 10px;
        margin-top: 10%;
    }

    .items div.right .voucherfrm {
        /*position: absolute;*/
        left: 15px;
        bottom: 15px;
    }

    .items div.right .voucherfrm .dk-button-container {
        margin: 0 10px 0 0;
    }

    .form-group input.en {
        color: #acacac;
        direction: ltr;
        text-align: left;
        font: bold 12px arial;
    }

    /* END payment */
    .order_payment_info .items .item .cell:first-child {
        border-left: 1px solid #f0f1e8;
        padding: 10px 0 10px;
        text-align: center;
        vertical-align: middle;
        width: 64px;
    }

    .order_payment_info .items .item .cell {
        display: table-cell;
        vertical-align: middle;
        padding: 10px 20px;
        font-size: 14px;
        color: #777;
    }

    .order_payment_info .items .item i {
        font-size: 20px;
        top: 4px;
    }

    .order_payment_info .items .item .cell {
        font-size: 14px;
        color: #777;
    }

    .review-buy .items .item.last .left .green {
        font-size: 22px;
    }

    .review-buy .items .item.last .green {
        font-size: 17px;
    }

    .review-buy .items .item.red {
        background: #fcf5f5;
        color: #ff6b6b !important;
    }

    .final_invoice .items .item {
        color: #777;
        line-height: 55px;
    }

    .items .item .left {
        font-size: 15px;
    }

    .toman {
        color: #666;
        font-size: 10px;
        letter-spacing: 0;
        margin-right: 10px;
        vertical-align: 2px;
    }

    .unitprice {
        color: #666666;
        font-size: 17px;
    }

    .last .p {
        color: #4caf50;
        font-size: 15px;
        line-height: 26px;
        white-space: nowrap;
    }

    .last .green {
        font-size: 15px;
        margin-left: 5px;
    }

    .last p:first-child {
        color: #666;
        font-size: 12px;
    }

    .green {
        color: #4caf50 !important;
    }

    .paymentRow:last-child {
        border-bottom-style: none;
        background-color: #f7fff7;
    }

    .paymentRow {
        border-bottom: 1px solid #f0f1f2;
        padding: 10px;
    }

    .paymentRow:first-child {
        font-size: 15px;
    }

    .prepayedAmount .rowAmount {
        color: #006400;
    }

    .paymentRow .prepayedAmount .rowAmount {
        display: inline-block;
        margin-left: 5px;
        font-size: 18px;
        /*color: #ff6b6b;*/
    }

    /* active address*/

    .active-address {
        border-left: 39px solid transparent;
        border-top: 39px solid #8cd98e;
        display: inline-block;
        height: 0;
        opacity: 0;
        position: absolute;
        right: 0;
        top: 0;
        transition: all 150ms ease 0s;
        width: 0;
    }

    .active-address {
        opacity: 1;
    }

    .active-address i {
        font-size: 15px;
        position: absolute;
        right: 4px;
        top: -38px;
        color: #fff;
    }

    .radio2 {
        position: relative;
        top: 52px;
        right: 20px;
    }

    .creditUser {
        background: #c9eabb;
        color: #006400;
        padding: 6px;
        margin-top: 8px;
        border-radius: 2px;
        font-weight: 700;
        letter-spacing: 1.2px;
        width: 30%;
    }

    .radio2 > label {
        display: inline-block;
        width: 110px;
        color: #4d4d4d;
    }

    .radio-control {
        top: 9px;
    }

    .radio-control {
        display: inline-block;
        position: relative;
        height: 18px;
        width: 18px;

    }

    .radio-control input[type=radio] {
        position: absolute !important;
        opacity: 0;
        display: none;
    }

    .radio-control label {
        width: 14px;
        height: 14px;
        border-radius: 100%;
        background: #fff;
        display: block;
        position: relative;
        border: 1px solid #d4dbde;
        transition: 150ms ease;
        padding: 0;
        margin: 0;
        cursor: pointer;
    }

    .radio-control + label {
        color: #777;
        margin-left: 15px;
        width: auto !important;
    }

    .radio-control input[type=radio]:checked + label {
        background: #2196f3;
        border: 1px solid transparent;
        width: 14px;
        height: 14px;
    }

    .radio-control label:after {
        position: absolute;
        top: 5px;
        left: 5px;
        content: "";
        background: #fff;
        width: 2px;
        height: 2px;
        border-radius: 100%;
        border: 1px solid #fff;
    }

    /* -- progressbar -- */

    #raysan-cart-prograsbar {
        background: #fff;
        height: 60px;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.1);
    }

    .steps {
        font-family: yekan, Arial;
        font-size: 14px;
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
        left: -77px;
    }

    .steps .rounded_rectangle .dashed.gray div {
        background: #dee1e7;
    }

    /* -- END progressbar -- */

    /* -- END progressbar -- */

    .padding-0-col {
        padding: 0px;
    }

    .container-cart .border {
        border: #ddd solid 1px;
        border-radius: 0px;
        text-align: center;
        padding: 5px;
        height: auto;
        padding-bottom: 20px !important;
    }

    .raysan-button-container-cart .raysan-button.dark-blue .raysan-button-label:hover {
        background-color: #666;
    }

    .raysan-button-container-cart .raysan-button.dark-blue .raysan-button-label {
        background-color: #969ba8;
    }

    .raysan-button-container-cart .raysan-button .raysan-button-label {
        color: #fff;
    }

    .raysan-button-container-cart .raysan-button-label {
        margin-right: 0;
        padding: 0 25px;
        font-size: 13px;
    }

    .raysan-button-container-cart.hasIcon.step_forward a.raysan-button:hover {
        background-color: #00b85d !important;
    }

    .raysan-button-container-cart.hasIcon.step_forward a.raysan-button {
        background-color: #4caf50 !important;
    }

    .container-cart {
        margin-bottom: 25px;
    }

    .clearfix {
        display: block;
    }

    .last {
        height: 45px;
        border-left: 0;
        background: #E3F3FC;
        border-right: 0;

    }

    .last a i {
        font-size: 20px;
        display: inline-block;
        color: #777;
    }

    .raysan-button-container-cart {
        display: inline-block;
        line-height: 0;
        margin: 4px;
        min-height: 38px;
        overflow: hidden;
        position: relative;
        top: 20px;
        width: 180px;
        cursor: pointer;
        -webkit-box-shadow: 0 2px 3px 0 rgba(0, 0, 0, .15);
        -ms-box-shadow: 0 2px 3px 0 rgba(0, 0, 0, .15);
        box-shadow: 0 2px 3px 0 rgba(0, 0, 0, .15);
    }

    .raysan-button-container-cart.hasIcon.step_forward a.raysan-button {
        background-color: #4caf50 !important;
    }

    .raysan-button-container-cart .raysan-button, .raysan-button-container-cart .raysan-button i.raysan-button-icon {
        box-sizing: border-box;
        display: block;
        overflow: hidden;
    }

    .raysan-button-container-cart .raysan-button {
        line-height: 0;
        text-decoration: none;
        -webkit-border-radius: 0px;
        -ms-border-radius: 0px;
        border-radius: 0px;
    }

    .raysan-button-container-cart.hasIcon.step_forward a.raysan-button i.raysan-button-icon {
        float: left;
        background-color: transparent !important;
    }

    .raysan-button-container-cart .raysan-button i.raysan-button-icon.raysan-button-icon-caretLeft {
        background-position: -12px -554px;
    }

    .raysan-button-container-cart.hasIcon .raysan-button i.raysan-button-icon {
        display: block;
        float: right;
        overflow: hidden;
        height: 38px;
        line-height: 38px;
        width: 54px;
    }

    .raysan-button-container-cart.hasIcon.step_forward a.raysan-button span.raysan-button-label {
        background-color: transparent !important;
        margin-right: 0;
        margin-left: 54px;
        padding-left: 0;
    }

    .raysan-button-container-cart .raysan-button .raysan-button-label {
        color: #fff;
    }

    .raysan-button-container-cart .raysan-button-label {
        margin-right: 0;
        padding: 0 25px;
        font-size: 13px;
    }

    .raysan-button-container-cart .raysan-button-label .raysan-button-labelname {
        display: block;
        height: 38px;
        line-height: 38px;
        text-align: center;
    }

    .title {
        color: #000;
        font-size: 15px;
        top: 0px;
        position: relative;

    }

    .pull-right {
        float: right !important;
    }

    label.pull-right {
        margin-left: 20px;
    }

    label.pull-right img {
        width: 30px;
    }

    p.desc {
        font-size: 12px;
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

    .title2 {
        color: #666;
        font-size: 16px;
        margin: 10px 0px;
    }

    .paymenthead {
        border-bottom: 1px solid #ccc;
        color: #000;
        margin-bottom: 30px;
        text-align: center;
        padding-bottom: 5px;
        margin-top: 10px;
    }

    p.right {
        float: right;
        color: #000;
        line-height: 25px;
    }

    .left {
        float: left;
    }

    button.form-control {
        background-color: #2196f3;
        color: #fff;
        box-shadow: 0 2px 3px 0 rgba(0, 0, 0, 0.15);
        display: inline-block;
        width: 120px;
        border: none;
        border-radius: 0px;
    }

    .dis_code {
        display: none;
    }

    .dis_code_error {
        display: none;
    }

    span.prepayedAmount.left.dis_code {
        background: #eeeeee;
        padding: 26px;
        padding-top: 1px;
        padding-bottom: 1px;
        margin-left: 17px;
        font-size: 12px;
    }
</style>
<script>
    $(document).ready(function () {
        $('.faNumber').each(function () {
                addCommas(this);
            }
        );


    });
    String.prototype.toPersianDigits = function () {
        var id = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        return this.replace(/[0-9]/g, function (w) {
            return id[+w]
        });
    }

    function addCommas(className) {
        nStr = $(className).text();
        if (nStr < 0) {
            mines = '-';
        }else{
            mines = '';
        }
        nStr = nStr.replace(/[^0-9\.]/g, "");
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(nStr)) {
            nStr = nStr.replace(rgx, '$1,$2');
        }
        nStr = nStr.replace(/(\.\d)$/, "$10");  // if only one DP add another 0

        nStr = nStr.toPersianDigits();

        if(mines){
            nStr = mines+nStr ;
        }

        //id.value = nStr;
        $(className).text(nStr);

    }

    if ($(window).width() <= 767) {
        $('.desktop-view').remove();
    } else {
        $('.mobile-view').remove();
    }
    $(document).ready(function () {
        var divHeight2 = $('.way-send-product').height();
        $('.way-send-product-tbody').css('height', divHeight2);
    });

    function submitOffCode() {
        var offCode = $("input[name='offCode']").val();
        if (offCode) {
            var productPrice = $('#priceEndPay').text();
            widgetHelper.tt('ui', 'shop.order.checkAndSubmitOffCode', {
                code: offCode,
                productPrice: productPrice,
                orderId:<?= $orderId ?>
            }, 'updatePrice');
        } else {
            alert('مقدار کد تخفیف نمی تواند خالی باشد.');
        }
    }

    function updatePrice(params) {
        if (params.result['result'] == 'error') {
            widgetHelper.removeLoading();
            setTimeout(function () {
                widgetHelper.errorDialog(params.result['message']);
                widgetHelper.closeDialog('errorDialog');
            }, 800);
            widgetHelper.removeLoading();
        } else {
            location.reload();
            $('#priceEndPay').text(toTomanComment(params.result['endPrice']));
        }
    }

    function removeDiscountCode(id) {
        widgetHelper.tt('ui', 'shop.order.removeDiscountCode', {
            id: id,
            orderId:<?= $orderId ?>
        }, 'updatePrice');
    }


    function redirectToBankOrCheckout() {
        var option = {
            payWay: $("input[name='rbPayWay']:checked").val(),
            bank: $("input[name='bank']:checked").val(),
            id:<?= $orderId ?>
        };
        widgetHelper.tt('ui', 'shop.order.pay', option, 'goPageBankOrCheckout');
    }

    function goPageBankOrCheckout(params) {

        if (params.pleaseTick) {
            //plase tick active
        }
        else {
            if (params.result.func == 'goToBank') {
                goToBankNew(params.result.params);
            } else {
                window.location.href = "<?= \f\ifm::app()->siteUrl ?>checkout/" + params.status + "/<?= $orderId ?>";
            }

        }
    }

    function goToBankNew(params) {
        if (params.bank == 'zarinpal') {
            window.location.assign("https://www.zarinpal.com/pg/StartPay/" + params.authority);
        }
        if (params.bank == 'mellat') {
            var form = document.createElement("form");
            form.setAttribute("method", "POST");
            form.setAttribute("action", "https://bpm.shaparak.ir/pgwchannel/startpay.mellat");
            form.setAttribute("target", "_self");
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("name", "RefId");
            hiddenField.setAttribute("value", params.authority);
            form.appendChild(hiddenField);
            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        }
        if (params.bank == 'mabna') {
            var form = document.createElement("form");
            form.setAttribute("method", "POST");
            form.setAttribute("action", "https://mabna.shaparak.ir");
            form.setAttribute("target", "_self");
            var hiddenField = document.createElement("input");
            hiddenField.setAttribute("name", "TOKEN");
            hiddenField.setAttribute("value", params.authority);
            form.appendChild(hiddenField);
            document.body.appendChild(form);
            form.submit();
            document.body.removeChild(form);
        }
    }
</script>
