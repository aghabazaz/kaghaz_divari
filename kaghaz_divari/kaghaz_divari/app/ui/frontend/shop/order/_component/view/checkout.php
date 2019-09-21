<!-- page content -->
<main class="page-content rtl" style="background-color: #eeeff1">
    <div class="container" >
        <div class="row">
            <div class="page-address-box padding-addressBar">
                <span class="address-name">
                    <a href="<?= \f\ifm::app ()->siteUrl ?>">
                        <i style="padding-left:3px;" class="fa fa-home"></i><span class="address-name">خانه</span>
                    </a>
                </span>
                <span class="arrow-address5 fa fa-angle-left"></span>
                <span class="address-name">وضعیت خرید و پرداخت سفارش</span>
            </div>
        </div>
    </div>
    <div class="container grid-row section-mainDetail margin-btn-20" >
        <div class="" >
            <div class="col-md-12">
                <div class="head  end-order-status"> 
                    <h2 class="title right"><i class="fa fa-flag-checkered"></i> وضعیت خرید و پرداخت سفارش</h2>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="checkout container-cart ">
                <div class="top_wrap">
                    <div class="columns clearfix ">
                        <div class="col-md-12 thanks right" >

                            <?php
                            if ( $status == 'cancel' )
                            {
                                ?>
                                <div class="alert alert-danger"><i class="fa fa-times"></i> 
                                    شما پرداخت خود را کنسل کردید!
                                </div>
                                <div class="alert alert-warning"><i class="fa fa-warning"></i> 
                                    توجه داشته باشید سفارش به مدت محدودی در سبد خرید شما باقی خواهد ماند و در صورت عدم پرداخت به صورت خودکار حذف خواهد شد.
                                </div>
                                <div class="alert alert-warning"><i class="fa fa-warning"></i> 
                                    همچنین توجه داشته باشید قیمت محصولات سفارش داده شده بر اساس قیمت لحظه ای محاسبه می شود و ممکن است قیمت ها و یا تخفیف ها در ساعات آینده تغییر کند.
                                </div>
                                <!--
                                    <div class="col-md-6">
                                        <div class="bankinfo clearfix">
                                            <span id="rbOnlinePaymentBank">
                                                <div id="rbOnlinePaymentBank_0" class="radio-control">
                                                    <input id="rbMellat" name="onlinePay" value="mellat" type="radio"><label id="rbMellat" for="rbMellat"></label>
                                                </div><label id="rbMellat" for="rbMellat"><img src="<?= \f\ifm::app ()->fileBaseUrl ?>409" alt="بانک ملت"></label>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">

                                        <div class=" clearfix">
                                            <div class="left" style="margin-top: 40px;">
                                                <div class="form-group clearfix">
                                                    <div class=" left">
                                                        <button value="Submit" class="form-control raysan-button-reg" style="background-color:#4caf50;color:#fff;box-shadow: 0 2px 3px 0 rgba(0, 0, 0, 0.15);" type="submit">پرداخت اینترنتی</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <span id="" class="error-msg" style="color:Red;display:none;">↑ لطفا یک بانک را انتخاب کنید.</span>
                                -->
                                <?php
                            }
                            else if ( $status == 'pay' )
                            {
                                ?>
                                <div class="alert alert-success"><i class="fa fa-check"></i> 
                                    پرداخت شما با موفقیت انجام شد.
                                </div>

                                <div class="alert alert-info"><i class="fa fa-info-circle"></i> 
                                    سفارش شما با موفقیت ثبت و پرداخت شد. بر اساس نوع نحوه ارسال ، سفارش شما در چند روز آینده به شما تحویل داده خواهد شد.
                                </div>
                                <?php
                            }
                            else if ( $status == 'errorPay' )
                            {
                                ?>
                                <div class="alert alert-danger"><i class="fa fa-times"></i> 
                                    متاسفانه پرداخت اینترنتی ناموفق بود!
                                </div>
                                <div class="alert alert-info "><i class="fa fa-info-circle"></i> 
                                    <span class="fa-digit">
                                        درصورتیکه طی این فرآیند، مبلغی از حساب شما کسر شده است، طی 72 ساعت آینده، به حساب شما باز خواهد گشت.

                                    </span>
                                </div>

                                <!--
                                <div class="col-md-6">
                                    <div class="bankinfo clearfix">
                                        <span id="rbOnlinePaymentBank">
                                            <div id="rbOnlinePaymentBank_0" class="radio-control">
                                                <input id="rbMellat" name="onlinePay" value="mellat" type="radio"><label id="rbMellat" for="rbMellat"></label>
                                            </div><label id="rbMellat" for="rbMellat"><img src="<?= \f\ifm::app ()->fileBaseUrl ?>409" alt="بانک ملت"></label>
                                        </span>
                                    </div>
                                </div>
                                <div class="col-md-6">

                                    <div class=" clearfix">
                                        <div class="left" style="margin-top: 40px;">
                                            <div class="form-group clearfix">
                                                <div class=" left">
                                                    <button value="Submit" class="form-control raysan-button-reg" style="background-color:#4caf50;color:#fff;box-shadow: 0 2px 3px 0 rgba(0, 0, 0, 0.15);" type="submit">پرداخت اینترنتی</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <span id="" class="error-msg" style="color:Red;display:none;">↑ لطفا یک بانک را انتخاب کنید.</span>
                                -->
                                <?php
                            }
                            else if ( $status == 'cashOn' )
                            {
                                ?>
                                <div class="alert alert-info"><i class="fa fa-info-circle"></i> 
                                    سفارش ثبت شده بر اساس نحوه وضعیت ارسال در چند روز آینده به دست شما خواهد رسید. همچنین پرداخت مبلغ سفارش در هنگام تحویل توسط شما انجام خواهد شد.
                                </div>
                                <?php
                            } else if ( $status == 'credit' ){
                                ?>
                                <div class="alert alert-info"><i class="fa fa-info-circle"></i>
                                    سفارش ثبت شده بر اساس نحوه وضعیت ارسال به دست شما خواهد رسید.
                                </div>
                                <?php
                            }
                            ?>


                        </div>

                    </div>
                </div>

                <div class="col-md-12">
                    <h2 class="title2 right"><i class="icon icon-caret-left-blue"></i>&nbsp;خلاصه وضعیت سفارش</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="paymentList paymentListDesign" >
                    <div class="col-md-12 container-cart">
                        <div class="col-md-4 padding-0-col">
                            <div class="thead border color-head">
                                <p>شماره سفارش</p>
                            </div>
                            <div class="tbody border">
                                <div class="pd">
                                    <div class="desc">
                                        <p class="fa-digit">
                                            <?php
                                            
                                            if ( $status == 'pay' )
                                            {
                                                echo $refId ;
                                            }
                                            else
                                            {
                                                
                                                echo $order[ 'id' ] + 100000;
                                            }
                                            ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div style="display:none;" class="col-md-3 padding-0-col">
                            <div class="thead border color-head">
                                <p>قیمت کل</p>
                            </div>
                            <div class="tbody border">
                                <div class="pd">
                                    <div class="desc">
                                        <p class="fa-digit" style="font-size:17px">
                                            <?= number_format ( ($orderTransport[ 'price' ] - $orderTransport[ 'discount' ] - $discountCodePrice) + $orderTransport[ 'transportation_cost' ] ) ?><span class="toman">تومان</span>

                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 padding-0-col">
                            <div class="thead border color-head">
                                <p>وضعیت پرداخت</p>
                            </div>
                            <div class="tbody border">
                                <div class="pd">
                                    <div class="desc">
                                        <p> 
                                            <?php
                                            switch ( $status )
                                            {
                                                case "cancel":
                                                    echo 'کنسل شده' ;
                                                    break ;
                                                case "pay":
                                                    echo 'پرداخت شده' ;
                                                    break ;
                                                case "credit":
                                                    echo 'اعتباری' ;
                                                    break ;
                                                case "errorPay":
                                                    echo 'عدم موفقیت' ;
                                                    break ;
                                                case "cashOn":
                                                    echo 'در محل' ;
                                                    break ;
                                            }
                                            ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 padding-0-col">
                            <div class="thead border color-head">
                                <p>وضعیت سفارش</p>
                            </div>
                            <div class="tbody border">
                                <div class="pd">
                                    <div class="desc">
                                        <p> در حال بررسی</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <h2 class="title2 right"><i class="icon icon-caret-left-blue"></i>&nbsp;اطلاعات ارسالی سفارش</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="paymentList" >
                    <div class="col-md-12 container-cart">
                        <div class="col-md-2 padding-0-col">
                            <div class="thead border color-head">
                                <p>نام سفارش دهنده</p>
                            </div>
                            <div class="tbody border">
                                <div class="pd">
                                    <div class="desc">
                                        <p><?= $member[ 'name' ] ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 padding-0-col">
                            <div class="thead border color-head">
                                <p>آدرس</p>
                            </div>
                            <div class="tbody border">
                                <div class="pd">
                                    <div class="desc">
                                        <p class="fa-digit"><?= $member[ 'city_title' ] . ' - ' . $member[ 'address' ] ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 padding-0-col">
                            <div class="thead border color-head">
                                <p>شماره تماس</p>
                            </div>
                            <div class="tbody border">
                                <div class="pd">
                                    <div class="desc">
                                        <p class="fa-digit"> <?= $member[ 'phone' ] . ' - ' . $member[ 'mobile' ] ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 padding-0-col"  style="padding-right:0px !important;padding-left:0px !important;">
                            <div class="thead border color-head">
                                <p>نحوه ارسال سفارش</p>
                            </div>
                            <div class="tbody border">
                                <div class="pd">
                                    <div class="desc">
                                        <p style="width: 100%" class="fa-digit"> <?= $orderTransport[ 'trans_title' ] ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                if ( $status != 'cashOn' && $status != 'cancel' && $status != 'credit' )
                {
                    ?>
                    <div class="col-md-12">
                        <h2 class="title2 right"><i class="icon icon-caret-left-blue"></i>&nbsp;جزییات پرداخت شما</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="paymentList paymentListDesign" >
                        <div class="col-md-12 container-cart">
                            <div class="col-md-1 padding-0-col">
                                <div class="thead border color-head">
                                    <p>ردیف</p>
                                </div>
                                <div class="tbody border">
                                    <div class="pd">
                                        <div class="desc">
                                            <p>1</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1 padding-0-col">
                                <div class="thead border color-head">
                                    <p>درگاه پرداخت</p>
                                </div>
                                <div class="tbody border">
                                    <div class="pd">
                                        <div class="desc">
                                            <p> 
                                                <?= $order[ 'bankid' ] ? $order[ 'bankid' ] : 'در محل' ; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1 padding-0-col">
                                <div class="thead border color-head">
                                    <p>نوع پرداخت</p>
                                </div>
                                <div class="tbody border">
                                    <div class="pd">
                                        <div class="desc">
                                            <p>
                                                <?= $order[ 'bankid' ] ? 'درگاه آنلاین' : 'در محل' ; ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 padding-0-col">
                                <div class="thead border color-head">
                                    <p>
                                        شماره رسید
                                    </p>
                                </div>
                                <div class="tbody border">
                                    <div class="pd">
                                        <div class="desc">
                                            <p class="fa-digit">
                                                <?= $order[ 'orderNumber' ] ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 padding-0-col">
                                <div class="thead border color-head">
                                    <p>تاریخ</p>
                                </div>
                                <div class="tbody border">
                                    <div class="pd">
                                        <div class="desc">
                                            <p class="fa-digit">
                                                <?php
                                                $this->registerGadgets ( array (
                                                    'dateG' => 'date' ) ) ;
                                                echo $this->dateG->dateTime ( $order[ 'date_pay' ],
                                                                              2 ) . ' ساعت: ' . date ( 'H:i',
                                                                                                       $order[ 'date_pay' ] ) ;
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 padding-0-col">
                                <div class="thead border color-head">
                                    <p>مبلغ</p>
                                </div>
                                <div class="tbody border">
                                    <div class="pd">
                                        <div class="desc">
                                            <p class="label-price fa-digit">
                                                <?= number_format ( ($orderTransport[ 'price' ] - $orderTransport[ 'discount' ] - $discountCodePrice) + $orderTransport[ 'transportation_cost' ] ) ?><span class="toman ">تومان</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 padding-0-col">
                                <div class="thead border color-head">
                                    <p>وضعیت</p>
                                </div>
                                <div class="tbody border">
                                    <div class="pd">
                                        <div class="desc">
                                            <p>
                                                <?php
                                                switch ( $status )
                                                {
                                                    case "cancel":
                                                        echo 'کنسل شده' ;
                                                        break ;
                                                    case "pay":
                                                        echo 'پرداخت شده' ;
                                                        break ;
                                                    case "errorPay":
                                                        echo 'عدم موفقیت' ;
                                                        break ;
                                                    case "credit":
                                                        echo 'بررسی برای ارسال' ;
                                                        break ;
                                                    case "cashOn":
                                                        echo 'بررسی برای ارسال' ;
                                                        break ;
                                                }
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>

                    <?php
                }
                if ( $status == 'pay' )
                {
                    $class = " tick " ;
                }
                ?>
                <div class="clearfix"></div>
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
                                <div class="rounded_rectangle_over step_financial"></div>
                                <span id="ctl12_Progressbar_lblBullet_1" class="bullet login blue tick">

                                    <span class="spacer first"></span>
                                    <a id="ctl12_Progressbar_lblTitle_1" class="s_title last2" >تایید سفارش</a>
                                    <span class="spacer second"></span>
                                </span>
                                <span id="ctl12_Progressbar_lblBullet_2" class="bullet or blue <?= $class ?>">
                                    <span class="spacer first"></span>
                                    <a  id="ctl12_Progressbar_lblTitle_2" class="s_title " >تایید مالی</a>
                                    <span class="spacer second"></span>
                                </span>
                                <span id="ctl12_Progressbar_lblBullet_3" class="bullet pi  ">
                                    <span class="spacer first"></span>
                                    <a  id="ctl12_Progressbar_lblTitle_3" class="s_title ">موجودی انبار</a>
                                    <span class="spacer second"></span>
                                </span>
                                <span id="ctl12_Progressbar_lblBullet_4" class="bullet send ">
                                    <span class="spacer first"></span>
                                    <a id="ctl12_Progressbar_lblTitle_4" class=" s_title first " >آماده ارسال</a>
                                    <span class="spacer second"></span>
                                </span>
                                <span id="ctl12_Progressbar_lblBullet_5" class="bullet finish ">
                                    <span class="spacer first"></span>
                                    <a id="ctl12_Progressbar_lblTitle_5" class=" s_title first " >تحویل</a>
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

            </div>
        </div>
    </div>

    <div class="clearfix"></div>

</div>
</main>
<style>
    @media only screen and (max-width: 980px) {
        .head{
            text-align: center!important;
        }
        .right{
            float:none!important;;
        }
        .left{
            float:none!important;;
        }
    }
    @media only screen and (max-width: 500px) {
        .review-buy .head .title {
            margin-top: 20% !important;
        }
        .steps .rounded_rectangle .bullet .s_title {
            font-size: 12px !important;
            right: -7px !important;
            width: 100% !important;
        }
        .steps .rounded_rectangle .dashed {
            display: none;
        }
        .steps .rounded_rectangle {
            width: 90% !important;
        }
        .radio2{
            top: 0px !important;
        }
        .tbody , .tbody-2 , .pd{
            height:auto !important;
            min-height: 20px !important;
        }
        .voucherfrm input[type=text]{
            width: 100% !important;
        }

    }

    /* checkout */
    .thead.color-head{
        background-color: #eee;
        color: #000;
        font-size: 13px;
        height: 47px;
    }
    .raysan-button-reg{
        width: 170px;
        height:38px!important;
    }
    .caption.title {
        margin: 0px;
    }
    .checkout .top_wrap {
        margin-top: 30px
    }


    .checkout .top_wrap .columns .mrg {
        box-sizing: border-box;
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -ms-box-sizing: border-box
    }

    .checkout .top_wrap .columns .thanks {
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -ms-box-sizing: border-box
    }

    .checkout .top_wrap .columns .thanks .error-msg {
        font-size: 14px ;
    }

    .checkout .top_wrap .columns .thanks h1.green {
        font-size: 15px
    }

    .checkout .top_wrap .columns .thanks h1.green .red img {
        vertical-align: middle;
        margin-left: 10px
    }

    .checkout .top_wrap .columns .thanks .email {
        margin-top: 15px;
        font-size: 16px
    }

    .checkout .top_wrap .columns .thanks .h48 {
        margin: 15px 0 27px;
        font: 15px/30px yekan;
        color: #777
    }

    .checkout .top_wrap .columns .thanks .h48 img {
        width: 30%;
        margin-left: 20px
    }

    .checkout .top_wrap .columns .thanks .h48 .gtext {
        float: left;
        width: 30%;
    }

    .checkout .top_wrap .columns .thanks .btn {
        direction: ltr
    }


    .checkout .top_wrap .columns .thanks .btn .fill_information {
        display: block;
        height: 10%;
        width: 20%;
        background-image: url("../Image/Btn/vtwo/fill_information_button.png");
        background-repeat: no-repeat
    }

    .checkout .top_wrap .columns .thanks .btn .fill_information:hover,
    .checkout .top_wrap .columns .thanks .btn .fill_information:focus {
        background-position: 0 -42px
    }

    .checkout .top_wrap .columns .thanks .note {
        margin: 5px 0 15px;
        background: #fffce0;
        border-radius: 2px;
        color: #957f38;
        padding: 10px;
        font: 17px yekan
    }

    .checkout .top_wrap .columns .thanks .bankinfo label {
        margin-left: 22px;
        position: relative;
        cursor: pointer
    }

    .checkout .top_wrap .columns .thanks .bankinfo .radio-control {
        margin: 0 18.8px;
        top: 15px;
        right: 39px;
    }

    .checkout .top_wrap .columns .thanks .bankinfo #rbOnlinePaymentBank>label::after {
        border: 1px solid #f0f1f2;
        border-radius: 8px;
        content: "";
        height: 80px;
        width: 130px;
        position: absolute;
        top: -14px;
        display: inherit;
    }

    .checkout .top_wrap .columns .thanks .bankinfo img {
        position: relative;
        top: 8px;
        right: 40px;
        vertical-align: middle;
        width:50px;
    }

    .checkout .top_wrap .columns .thanks .bankinfo input {
        margin-left: 10px
    }

    .checkout .top_wrap .columns .thanks .online_payment {
        display: block;
        height: 10%;
        width: 30%;
        background-image: url("../Image/Btn/vtwo/online_payment_button.png");
        background-repeat: no-repeat;
        margin-top: 8px
    }

    .checkout .top_wrap .columns .thanks .online_payment:hover,
    .checkout .top_wrap .columns .thanks .online_payment:focus {
        background-position: 0 -42px
    }

    .checkout .top_wrap .columns .summary {
        height: 30%;
        color: #777
    }

    .checkout .top_wrap .columns .summary .table-block .row2 {
        font-size: 12px
    }

    .checkout .top_wrap .columns .summary .table-block .cell {
        vertical-align: middle;
        text-align: center
    }

    .checkout .top_wrap .columns .summary .table-block .cell:first-child {
        border-left: 1px solid #f0f1f2;
    }
    .cell span.cell-value , .cell-label{
        vertical-align: middle;
        line-height: 40px;
    }

    .checkout .top_wrap .columns .summary .table-block .caption {
        border: 1px solid #f0f1f2;
        border-bottom: 0;
        height: 47px;
        line-height: 47px
    }

    .checkout .top_wrap .columns .order_summary {
        margin-left: 10px;
        border-radius: 2px;
        border: 1px solid #f0f1f2
    }

    .checkout .top_wrap .columns .order_summary .cln2 .left {
        font-size: 14px
    }

    .checkout .top_wrap .columns .order_summary .cln2 .cell-value {
        font-size: 16px
    }

    .checkout .top_wrap .columns .order_summary .cln3 .red {
        color: #ff5153
    }

    .checkout .top_wrap .columns .order_info {
        border-radius: 2px;
        border: 1px solid #f0f1f2;
    }


    .checkout .top_wrap .columns .order_info.min .last2 .val {
        top: 12px
    }

    .checkout .top_wrap .columns .order_info .cln2 .val {
        position: absolute;
        bottom: 0;
        left: 10px
    }

    .checkout .top_wrap .columns .order_info .cln3 .val {
        position: absolute;
        left: 10px;
        top: 0
    }
    .cln1 , .cln2 , .cln3 , .cln4  {
        border-bottom: 1px solid #f0f1f2;
    } 

    .checkout .top_wrap .columns .row2:last-child .cell {
        border-bottom: 0
    }

    .checkout .top_wrap .columns .order_summary .last2,
    .checkout .top_wrap .columns .order_info .last2 {
        border: 0;
        position: relative
    }

    .checkout .top_wrap .columns .order_summary .title,
    .checkout .top_wrap .columns .order_info .title {
        text-align: center;
        height: 40px;
        line-height: 40px;
        background-color: #f7f9fa;
        border-bottom: 1px solid #f0f1f2;
        border-radius: 2px 2px 0 0;
        color: #777
    }

    .checkout .top_wrap .columns .order_summary .title h1,
    .checkout .top_wrap .columns .order_info .title h1 {
        font-size: 13px
    }

    .checkout .top_wrap .columns .order_summary .cln1
    {
        color: #4caf50;
        font-size: 15px!important
    }

    .checkout .top_wrap .columns .order_summary .cln1 .cell-value {

    }

    .checkout .top_wrap .columns .order_info .cln1 .cell-value {
        font: normal 12px yekan;
        color: #777
    }

    .checkout .top_wrap .columns .order_info.cln4 .cell-value {}

    .checkout .top_wrap .columns .order_summary .cln1 .left {
        font-family: Tahoma;
        font-size: 14px
    }
    .checkout .top_wrap .columns .bottom-box {
        color: #777;
        font: 14px yekan;
        margin-top: 35px
    }


    .checkout .top_wrap .columns .bottom-box .qus a {
        color: #2196f3;
        border-bottom: 1px dashed #2196f3;
        margin: 0 10px 0 38px;
        display: inline-block
    }

    .checkout .top_wrap .columns .bottom-box .tel {
        direction: ltr;
        color: #2196f3;
        display: inline-block;
        font-family: yekan;
        font-size: 14px;
        margin-top: 10px
    }

    .checkout .top_wrap .columns .bottom-box .tel span {
        direction: rtl;
        display: inline-block;
        margin: 0 3px
    }

    .checkout .top_wrap .columns .bottom-box .tel i {
        margin-left: 15px;
        top: 2px
    }

    .checkout .payment_details .space {
        height: 110px
    }

    .checkout .header {
        height: auto;
        position: relative;
        border-top: none;
        min-width: 940px
    }

    .checkout .header h2 {
        font-size: 18px;
        padding: 0;
        float: right
    }

    .checkout .header h2 i {
        margin: 0 0 0 11px;
        top: 1px
    }

    .checkout .container {
        border-radius: 2px;
        margin-top: 15px
    }

    .checkout .container table {
        border: 1px solid #f0f1f2;
        direction: rtl;
        display: table;
        width: 100%
    }

    .checkout .container table .w70 {
        width: 70px
    }

    .checkout .container table .w139 {
        width: 139px
    }

    .checkout .container table .w199 {
        width: 199px
    }

    .checkout .container table td {
        text-align: center;
        vertical-align: middle;
        border-bottom: 1px solid #f0f1f2;
        border-left: 1px solid #f0f1f2;
        height: 60px
    }

    .checkout .container table td.last2 {
        border-left: 0
    }

    .checkout .container table td.total {
        color: #4caf50
    }

    .checkout .container table td.unitprice,
    .checkout .container table td.discount,
    .checkout .container table td.total {
        font-size: 16px
    }

    .checkout .container table thead td {
        background-color: #f7f9fa;
        color: #777;
        font-size: 13px;
        height: 47px
    }

    .checkout .container table thead td.first {
        border-radius: 0 4px 0 0
    }

    .checkout .container table thead td.last2 {
        border-radius: 2px 0 0 0
    }

    .checkout .container table tbody td .pd {
        padding: 20px 15px;
        direction: rtl;
        text-align: right
    }

    .checkout .container table tbody td h2 {
        font-size: 18px
    }

    .checkout .container table tbody td h3 {
        font-size: 15px;
        font-family: Tahoma;
        margin-top: 15px
    }

    .checkout .container table tbody td .receipt {
        font-family: Tahoma
    }

    .checkout .container table tbody td .color {
        font-size: 14px;
        margin-top: 15px
    }

    .checkout .container table tbody td .warranty {
        line-height: 20px;
        font-size: 14px;
        margin-top: 10px
    }

    .checkout .container table td.paymentNotConfirmed {
        color: red
    }

    .checkout .container table td.paymentConfirmed {
        color: green
    }

    .checkout .container table td.underReview {
        color: #f7d200
    }
    /* END checkout */

    .order_shipping_info .items .item .cell:first-child{
        border-left: 1px solid #f0f1e8;
        padding: 10px 0 10px;
        text-align: center;
        vertical-align: middle;
        width: 64px;
    }

    .order_shipping_info .items .item .cell {
        display: table-cell;
        vertical-align: middle;
        padding: 10px 20px;
        font-size: 14px;
        color: #777;
    }
    .order_shipping_info .items .item i {
        font-size: 20px;
        top: 4px;
    }
    .order_shipping_info .items .item .cell {
        font-size: 14px ;
        color: #777;
    }
    .review-buy .items .item.last .left .blue {
        font-size: 22px;
    }
    .review-buy .items .item.last .blue {
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
        font-size: 10px ;
        letter-spacing: 0;
        margin-right: 10px;
        vertical-align: 2px;
    }
    .unitprice {
        color: #666666;
        font-size: 17px;
    }

    .last .p{
        color: #4caf50;
        font-size: 15px;
        line-height: 26px;
        white-space: nowrap;
    }
    .last .blue {
        font-size: 15px;
        margin-left: 5px;
    }
    .last p:first-child {
        color: #666;
        font-size: 12px;
    }
    .blue {
        color: #4caf50 !important;
    }
    .green {
        color: #4caf50 !important;
    }
    .red {
        color: #ff6b6b;
    }
    .paymentRow:last-child {
        border-bottom-style: none;
        background-color: #f7fff7;
    }
    /*    .paymentRow:first-child {
            background-color: #f7f9fa;
            font-size: 15px;
        }*/
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
        font-size:15px;
        position:absolute;
        right: 4px;
        top: -38px;
        color:#fff;
    }
    .radio2{
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
        background: #fafcfc;
        height: 105px;
    }

    .steps {
        font-size: 12px;
        position: relative;
        padding-top: 18px;
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
        background: #2396f3 ;
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
        top: 35px;
        right: -60px;
    }

    .steps .rounded_rectangle .bullet.login {
        right: -1px;
    }

    .steps .rounded_rectangle .bullet.or {
        right: 22%;
    }

    .steps .rounded_rectangle .bullet.pi {
        right: 44%;
    }
    .steps .rounded_rectangle .bullet.send {
        right: 66%;
    }
    .steps .rounded_rectangle .bullet.finish {
        left: 0;
    }

    .steps .rounded_rectangle .step_user {
        width: 0;
        border: 0;
    }

    .steps .rounded_rectangle .step_financial {
        width: 21%;
    }

    .steps .rounded_rectangle .step_stock {
        width: 43%;
    }

    .steps .rounded_rectangle .step_readysend {
        width: 66%;
    }

    .steps .rounded_rectangle .step_delivery {
        width: 100%;
    }

    .steps .rounded_rectangle .bullet.blue {
        background: #e3f3ff !important;
        border-color: #2396f3;
    }

    .steps .rounded_rectangle .bullet.blue.tick {
        background: url("../img/slices.png") no-repeat scroll -812px -479px #2396f3 !important;
        border-color: #2396f3;
    }

    .steps .rounded_rectangle .dashed {
        height: 2px;
        position: absolute;
        right: -77px;
        top: -2px;
    }

    .steps .rounded_rectangle .dashed div {
        background: #2396f3 none repeat scroll 0 0;
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


    p.label-price {
        color: #777777;
        font-size: 18px;
    }

    .padding-0-col{
        padding: 0px;
    }
    .container-cart  .border{
        border: #ddd solid 1px;
        border-radius: 0px;
        text-align: center;
        padding:5px;
        height:auto;
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
        margin-bottom:25px;
    }

    .clearfix {
        display: block;
    }

    div{
        line-height: 22px;
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

    .head {
        margin: 0 0 30px 0;
        height: auto;
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
        -webkit-box-shadow: 0 2px 3px 0 rgba(0,0,0,.15);
        -ms-box-shadow: 0 2px 3px 0 rgba(0,0,0,.15);
        box-shadow: 0 2px 3px 0 rgba(0,0,0,.15);
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
        -webkit-border-radius: 3px;
        -ms-border-radius: 3px;
        border-radius: 3px;
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
        font-size: 18px;
        top:0px;
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
        font-size: 16px;
        margin:10px 0px;
    }



</style>
<script>
    $(document).ready(function () {
        var divHeight = $('.barbari-height').height();
        $('.barbari-height-right').css('height', divHeight);

        var divHeight2 = $('.address-height').height();
        $('.address-height-right').css('height', divHeight2);

    });
</script>
