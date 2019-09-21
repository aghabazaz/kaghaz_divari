<!-- page content -->
<main class="page-content rtl desktop-view topbreadcrumb marginTop120" style="background-color: #eeeff1">
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
                    <span class="address-name">اطلاعات ارسال سفارش</span>
                </div>
            </div>
        </div>
    </div>
    <div class="container grid-row section-mainDetail div-line-height paddingBtn10">
        <div class="col-md-12">
            <div class="head">
                <div class="raysan-button-container-cart hasIcon step_forward left">
                    <a id="lkstepShipping" class="raysan-button green" onclick="redirectToReview()">

                        <i class="icon raysan-button-icon raysan-button-icon-caretLeft"></i>

                        <span class="raysan-button-label clearfix">
                            <span class="raysan-button-labelname">ثبت و بازبینی سفارش</span>
                        </span>

                    </a>
                </div>
                <h2 class="title right setting-text-right"><i class="fa fa-truck"></i> اطلاعات ارسال سفارش</h2>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="col-md-12">
            <h2 class="title2 right" style="margin-top:0px">
                <i class="icon icon-caret-left-blue"></i>&nbsp;آدرس شما ( در صورت کامل نبودن لطفا اطلاعات خود را ویرایش
                کنید )
            </h2>

        </div>

        <div class="shipping">
            <div class="col-md-12 container-cart">
                <div class="col-md-1  padding-0-col">
                    <!--                    <div class="thead border">
                                            <p>انتخاب</p>
                                        </div>-->
                    <div class="tbody-2 border" style="cursor: pointer;height: 102px;">
                        <div class="pd">
                            <span class="active-address">
                                <i class="fa fa-check"></i>
                            </span>
                            <div class="radio-control">
                                <input id="rChoiseAddress[]" type="radio" name="rChoiseAddress[]"
                                       value="<?= $member[0]['id'] ?>" checked="">
                                <label for="rChoiseAddress" style="position:relative ;top: 100%;"></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-10  padding-0-col">
                    <div class="col-md-12 padding-0-col">
                        <div class="tbody border">
                            <div class="pd ">
                                <p class="p-shipping" style="text-align:right"><?= $member[0]['name'] ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 padding-0-col row-2">
                        <div class="tbody border">
                            <div class="pd ">
                                <span>استان: <span> <?= $member[0]['state_title'] ?> </span></span>

                            </div>
                        </div>
                        <div class="tbody border">
                            <div class="pd ">
                                <span>شهر: <span> <?= $member[0]['city_title'] ?> </span></span>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-7 padding-0-col">
                        <div class="tbody-3 border" style="height: 68px;">
                            <div class="pd ">
                                <span class="fa-digit"> <?= $member[0]['address'] ?> </span>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 padding-0-col row-2" style="padding-right:0px !important;">
                        <div class="tbody border">
                            <div class="pd ">
                                <span>شماره تماس اضطراری: <span
                                            class="left  fa-digit">  <?= $member[0]['mobile'] ?>  </span></span>

                            </div>
                        </div>
                        <div class="tbody border">
                            <div class="pd ">
                                <span>شماره تماس ثابت: <span
                                            class="left  fa-digit">   <?= $member[0]['phone'] ?> </span></span>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-1  padding-0-col">
                    <div class="tbody-2 border">
                        <div class="pd last" style="background: #fff;height:90px">
                            <a id="btnDelete_0" class="delete" href="<?= \f\ifm::app()->siteUrl ?>additionalinfo"
                               target="_blank" style="height: 149px;position:relative;top: 45%;">
                                <i class="fa fa-pencil-square-o" title="ویرایش آدرس"></i>
                            </a>
                        </div>
                        <!--                        <div class="pd last"  >
                                                    <a id="btnDelete_0" class="  delete" href="javascript:WebForm_DoPostBackWithOptions(new WebForm_PostBackOptions(&quot;$repItemList$ctl00$btnDelete&quot;, &quot;&quot;, true, &quot;delValidator&quot;, &quot;&quot;, false, true))" style="height: 149px;position:relative;top: 0%;">
                                                        <i class="fa fa-times" title="حذف آدرس"></i>
                                                    </a>
                                                </div>-->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <h2 class="title2 right" style="margin-top:30px"><i class="icon icon-caret-left-blue"></i>&nbsp;نحوه ارسال
            </h2>
            <div class="clearfix"></div>
        </div>
        <div class="shipping">
            <?php
            foreach ($transports AS $data) {
                if ($data['id'] == $transId) {
                    $checked = 'checked';
                } else {
                    $checked = '';
                }
                ?>
                <div class="col-md-12 container-cart way-send-product">
                    <div class="col-md-1  padding-0-col">
                        <div class="tbody border way-send-product-tbody" style="cursor: pointer;">
                            <div class="pd">
                                <div class="radio-control">
                                    <input id="rbTransport_<?= $data['id'] ?>" type="radio" name="transports"
                                           value="<?= $data['id'] ?>" <?= $checked ?> >
                                    <label for="rbTransport_<?= $data['id'] ?>"
                                           style="position:relative ;top: 50%;"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9  padding-0-col">
                        <div class="tbody border way-send-product-tbody">
                            <div class="pd ">
                                <i class="icon fa fa-truck fa-5x"
                                   style="margin: 2px 25px 0 0;float: right;font-size: 35px;color:#6BBDE9"></i>
                                <div class="raysan">
                                    <p class="title2 fa-digit" style="margin: 0;"><?= $data['title'] ?></p>
                                    <p class="desc fa-digit"><?= $data['description'] ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2  padding-0-col">
                        <div class="tbody border way-send-product-tbody">
                            <div class="pd last" style="background: #fbfcfc none repeat scroll 0 0;">
                                <p>هزینه ارسال</p>
                                <p class="green fa-digit"><?= number_format($data['cost']) . '  ریال ' ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <?php
            }
            ?>
        </div>
        <!--        <div class="">
                    <div class="head">
                        <h2 class="title right"><i class="icon icon-caret-left-blue"></i>آیا مایل هستید به همراه این سفارش فاکتور ارسال شود؟</h2>
                        <div class="right">
                            <div class="radio2">
                                <div class="radio-control">
                                    <input id="rbYes" name="ctl02$yesnoGroup" value="1" type="radio" checked="">
                                    <label for="rbYes"></label>
                                </div>
                                <label for="rbYes">بله</label>

                                <div class="radio-control">
                                    <input id="rbNo" name="ctl02$yesnoGroup" value="0" type="radio">
                                    <label for="rbNo"></label>
                                </div>
                                <label for="rbNo">خیر</label>
                            </div>
                        </div>
                    </div>
                </div>-->
        <div class="clearfix"></div>
        <br></br>
        <div class="col-md-12">
            <div class="addtocart">
                <div class="foot">
                    <div class="btn-foot">

                        <div class="raysan-button-container-cart right" style="top: 0">
                            <a href="<?= \f\ifm::app()->siteUrl ?>cart" class="raysan-button dark-blue" id="btnBack">
                                <i class="raysan-button-icon raysan-button-icon-cart"></i>
                                <span class="raysan-button-label clearfix">
                                    <span class="raysan-button-labelname">بازگشت به سبد خرید</span>
                                </span>
                            </a>
                        </div>
                        <div class="left">
                            <div class="raysan-button-container-cart hasIcon step_forward "
                                 style="top: 0;width: 200px;">

                                <a id="lkstepShipping" class="raysan-button green " onclick="redirectToReview()">

                                    <i class="icon raysan-button-icon raysan-button-icon-caretLeft"></i>
                                    <span class="raysan-button-label clearfix">
                                        <span class="raysan-button-labelname ">ثبت و بازبینی سفارش</span>
                                    </span>

                                </a>

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
                    <span id="ctl12_Progressbar_lblBullet_2" class="bullet or green">
                        <span class="spacer first"></span>
                        <a href="/shipping" id="ctl12_Progressbar_lblTitle_2" class="s_title green"
                           data-url="/Shipping">ارسال</a>
                        <span class="spacer second"></span>
                    </span>
                    <span id="ctl12_Progressbar_lblBullet_3" class="bullet pi ">
                        <span class="spacer first"></span>
                        <a href="/review" id="ctl12_Progressbar_lblTitle_3" class="s_title"
                           data-url="/review">بازبینی</a>
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
    <div style="background:#ddd;padding: 5px;color:#000;margin-bottom: 10px">
        <div>انتخاب آدرس</div>
    </div>
    <div>
        <div class="col-sm-12">
            <div style="border:1px solid #ddd">
                <div style="background:#ddd;padding: 5px;color:#000;">
                    <div style="float:right">
                        <?= $member[0]['name'] ?>
                    </div>
                    <div style="float:left">
                        <a href="<?= \f\ifm::app()->siteUrl ?>additionalinfo">
                            ویرایش
                        </a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div style="background:#fff;">
                    <div style="padding:5px;border-bottom: 1px solid #ddd">
                        <div>استان : <?= $member[0]['state_title'] ?></div>
                        <div>شهر : <?= $member[0]['city_title'] ?></div>
                    </div>
                    <div style="padding:5px;border-bottom: 1px solid #ddd">
                        <div class="fa-digit">
                            <?= $member[0]['address'] ?>
                        </div>
                    </div>
                    <div style="padding:5px;border-bottom: 1px solid #ddd">
                        <div class="fa-digit">
                            تلفن ثابت : <?= $member[0]['phone'] ?>
                        </div>
                        <div class="fa-digit">
                            تلفن همراه: <?= $member[0]['mobile'] ?>
                        </div>
                    </div>
                    <div style="padding:5px;">

                        <div class="radio-control">
                            <input id="rbTransport_1" type="radio" name="address" value="" checked="">
                            <label for="rbTransport_1"></label>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>
    <div style="background:#ddd;padding: 5px;color:#000;margin: 10px 0px">
        <div><i class="fa fa-truck"></i> شیوه ارسال</div>
    </div>
    <?php
    foreach ($transports AS $data) {
        if ($data['id'] == $transId) {
            $checked = 'checked';
        } else {
            $checked = '';
        }
        ?>
        <div class="col-md-12 ">
            <div style="background:#fff;border:1px solid #ddd;padding:5px">
                <div class="radio-control">
                    <input id="rbTransport_<?= $data['id'] ?>" type="radio" name="transports"
                           value="<?= $data['id'] ?>" <?= $checked ?> >
                    <label for="rbTransport_<?= $data['id'] ?>"></label>

                </div>
                <span style="color:#000">
                    <?= $data['title'] ?>
                </span>

                <p class="desc fa-digit"
                   style="background:lemonchiffon;padding: 5px;font-size:12px;margin:5px 0px"><?= $data['description'] ?></p>
                <?php
                if ($data['cost']) {
                    ?>
                    <p>هزینه ارسال : <span
                                class="green fa-digit"><?= number_format($data['cost']) . '  تومان ' ?></span></p>

                    <?php
                }
                ?>


            </div>

        </div>
        <?php
    }
    ?>
    <div style="height:60px">

    </div>
    <div onclick="redirectToReview()"
         style="z-index:999;position:fixed;bottom: 0px;right: 0px;text-align: center;height: 40px;line-height: 40px;width: 100%;background: #3BB153;color:#fff;cursor: pointer;font-size: 15px">
        ثبت و بازبینی سفارش
        <i class="fa fa-arrow-left" style="font-size:18px;padding-right:5px;position: relative;top:3px"></i>
    </div>

</main>
<style>
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

    @media only screen and (max-width: 500px) {
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

        .tbody, .tbody-2 {
            height: auto !important;
            min-height: 80px;
        }
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
        left: -39px;
    }

    .steps .rounded_rectangle .dashed.gray div {
        background: #dee1e7;
    }

    /* -- END progressbar -- */

    .padding-0-col {
        padding: 0px;
    }

    .pd.send-type-box p {
        font-size: 13px;
        color: #000;
    }

    .container-cart .border {
        border: #ddd solid 1px;
        border-radius: 0px;
        text-align: center;
        padding: 5px;
        height: auto;
        color: #000;
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
        /*margin-top: 15px;*/
    }

    .clearfix {
        display: block;
    }

    div {
        line-height: 22px;
    }

    .last {
        height: 45px;
        border-left: 0;
        background: #ffedee;
        border-right: 0;

    }

    .last a i {
        font-size: 20px;
        width: 12px;
        height: 12px;
        display: inline-block;
        color: #777;
    }

    .tbody.border.way-send-product-tbody.send-radio-type .radio-control {
        top: 0px;
    }

    .raysan-button-container-cart {
        display: inline-block;
        line-height: 0;
        margin: 4px;
        min-height: 38px;
        overflow: hidden;
        position: relative;
        margin-top:20px;
        width: 195px;
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
        font-size: 16px;
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

    .title2 {
        color: #666;
        font-size: 14px;
        margin: 10px 0px;
    }

    p.title2.fa-digit {
        width: 26%;
        float: right;
        margin-right: 20px !important;
    }

    p.desc.fa-digit {
        color: #000;
    }

</style>
<script>
    if ($(window).width() <= 767) {
        $('.desktop-view').remove();
    } else {
        $('.mobile-view').remove();
    }

    function redirectToReview() {

        var option = {
            transportation_id: $("input[name='transports']:checked").val(),
            id:<?= $orderId ?>
        };
        console.log(option);
        widgetHelper.tt('ui', 'shop.order.sendIdTransAndGoToReview', option, 'goPageReview');
    }

    function goPageReview(params) {
        console.log(params);
        if (params.result['result'] == 'success') {
            window.location.href = '<?= \f\ifm::app()->siteUrl ?>review';
        } else {
            setTimeout(function () {
                widgetHelper.errorDialog('لطفا یک روش ارسال را انتخاب کنید');
                widgetHelper.closeDialog('errorDialog');
            }, 800);
            widgetHelper.removeLoading();
        }
    }

    $(document).ready(function () {
        var divHeight = $('.container-cart').height();
        $('.tbody-2').css('height', divHeight);
        $('.tbody-3').css('height', $('.row-2').height());

        var divHeight2 = $('.way-send-product').height();
        $('.way-send-product-tbody').css('height', divHeight2);
    });
</script>
