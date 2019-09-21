<!-- page content -->
<main class="page-content rtl desktop-view">
    <div class="container">
        <div class="row">
            <div class="url-page-box">
                <div class="page-address-box padding-addressBar">
                    <i style="padding-left:3px;" class="fa fa-home"></i><span class="address-name"><a
                                href="<?= \f\ifm::app()->siteUrl ?>">خانه</a></span><span
                            class="arrow-address5 fa fa-angle-left"></span><span class="address-name"> سبد خرید</span>
                </div>
            </div>
        </div>
    </div>
    <div class="container grid-row section-mainDetail div-line-height">
        <?php
        if ($row)
        {
        ?>
        <div class="col-md-12">
            <div class="head">
                <div class="raysan-button-container-cart hasIcon step_forward left">
                    <a id="LinkButton1" class="raysan-button green" onclick="redirectToShipping()">
                        <i class="icon raysan-button-icon raysan-button-icon-caretLeft"></i>
                        <span class="raysan-button-label clearfix">
                                <span class="raysan-button-labelname">انتخاب شیوه ارسال</span>
                            </span>
                    </a>
                </div>
                <h2 class="title right-cart"><i class="fa fa-shopping-basket"></i> سبد خرید</h2>
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="">
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
                <div class="col-md-3  padding-0-col ">
                    <div class="thead border">
                        <p>قیمت کل</p>
                    </div>
                </div>
                <div class="col-md-1  padding-0-col">
                    <div class="thead border">
                        <p>حذف محصول</p>
                    </div>
                </div>

            </div>
            <?php
            foreach ($row AS $data) {
                $priceUnit=$data['price'];
                $price = $data['price'] * $data['count'];
                $discount = $data['discountEnd'] * $data['count'];
                $priceSumCart = $priceSumCart + ($price - $discount);
                $priceTotal += $price;
                $discountTotal += $discount;
                ?>
                <div class="col-md-12 container-cart">
                    <div class="col-md-5  padding-0-col">
                        <div class="tbody border">
                            <div class="pd" style="height: 120px;">
                                <div class="col-md-2">
                                    <div class="pic" style="vertical-align:middle">
                                        <a href="<?= \f\ifm::app()->siteUrl ?>productDetail/<?= $data['product_id'] ?>"
                                           target="_blank">
                                            <?php
                                            if($data['dynamic']=='true'){
                                                ?>
                                                <img style="width: 100% !important;height: 50%;vertical-align: middle;margin-top: 20%;"
                                                     src="<?=  $data['product_pic'] ?>"
                                                     alt="<?= $data['productTitle'] ?>" title="<?= $data['productTitle'] ?>"
                                                     class="img-responsive">
                                            <?php
                                            }else{
                                                ?>
                                                <img style="width: 100% !important;height: 50%;vertical-align: middle;margin-top: 20%;"
                                                     src="<?= \f\ifm::app()->fileBaseUrl . $data['picture'] ?>"
                                                     alt="<?= $data['productTitle'] ?>" title="<?= $data['productTitle'] ?>"
                                                     class="img-responsive">
<?php                                            }
                                            ?>

                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="desc product-pro" style="text-align: right;vertical-align: top">
                                        <h2>
                                            <a href="<?= \f\ifm::app()->siteUrl ?>productDetail/<?= $data['product_id'] ?>"
                                               target="_blank"
                                               style="color: #4e4949;font-size: 16px;"><?= $data['productTitle'] ?>
                                            </a>
                                        </h2>
                                        <h4>
                                            <a href="<?= \f\ifm::app()->siteUrl ?>productDetail/<?= $data['product_id'] ?>"
                                               target="_blank" style="color:#000"><?= $data['productTitleSub'] ?>
                                            </a>
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
                                    </div>
                                </div>
                                <div class="clearfix"></div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-1  padding-0-col">
                        <div class="tbody border">
                            <div class="pd" style="height: 110px;">
                                <div class="unitnumber-container-cart" style="position:relative;top: 25%;">

                                    <?php
                                    if ($data['count'] > 0) {
                                        ?>
                                        <div class="styled-select ">
                                            <select name="order_count_<?= $data['orderItem_id'] ?>"
                                                    onchange="calcPrice(<?= $data['orderItem_id'] ?>)"
                                                    id="order_count_<?= $data['orderItem_id'] ?>">
                                                <?php
                                                if($data['dynamic']){
                                                    $stockAll=1000;
                                                }else{
                                                    $stockAll = $data['stock'] == 0 ? $data['stock'] + 1 : $data['stock'];
                                                }

                                                for ($i = 1; $i <= $stockAll; $i++) {
                                                    if ($i == $data['count']) {
                                                        $selected = "selected='selected'";
                                                    }
                                                    echo '<option  value="' . $i . '" ' . $selected . '>' . \f\ifm::faDigit($i) . '</option>';
                                                    $selected = '';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <?php
                                    } else {
                                        echo '<span style="color:#DD1E25">ناموجود</span>';
                                    }
                                    ?>


                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2  padding-0-col">
                        <div class="tbody border">
                            <div class="pd" style="height: 110px;">
                                <span class="unitprice fa-digit" style="position:relative;top: 40%;"
                                      id="unitprice_<?= $data['orderItem_id'] ?>"><?=number_format($priceUnit);
                                    ?></span><span
                                        class="toman" style="position:relative;top: 40%;">ریال</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3  padding-0-col">
                        <div class="tbody border">
                            <div class="pd" style="height: 110px;">

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
                                              style="font-size:17px"><?= number_format($discount) ?></span>
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
                                              id="span_price_cart_<?= $data['orderItem_id'] ?>"><?= number_format($price - $discount) ?></span>
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
                                   value="<?=$priceUnit?>">
                            <input type="hidden" id="product_discount_<?= $data['orderItem_id'] ?>"
                                   value="<?=$data['discountEnd']?>">
                        </div>
                    </div>
                    <div class="col-md-1  padding-0-col">
                        <div class="tbody border">
                            <div class="pd last" style="height: 110px;">
                                <a class="btnDeleteCart" data="<?= $data['orderItem_id'] ?>" href=""
                                   style="height: 149px;position:relative;top: 40%;">
                                    <i class="fa fa-times-circle" title="حذف محصول"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>

            <div class="col-md-12">
                <div class="col-md-6">
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
                                <span class="price-sum-cart fa-digit"><?= number_format($priceSumCart) ?></span>
                                <span class="toman white-color">ریال</span>
                            </p>
                            <input type="hidden" id="price-sum-cart" name="price-sum-cart" value="<?= $priceSumCart ?>">
                        </div>
                    </div>
                </div>

            </div>
            <div class="">
                <div class="addtocart">
                    <div class="foot">
                        <div class="btn-foot">
                            <div class="raysan-button-container-cart right" style="margin-top:25px;margin-right: 15px;">

                                <a href="<?= \f\ifm::app()->siteUrl ?>" class="raysan-button dark-blue" id="btnBack">
                                        <span class="raysan-button-label clearfix">
                                            <span class="raysan-button-labelname">بازگشت به صفحه اصلی</span>
                                        </span>
                                </a>

                            </div>
                            <div class="raysan-button-container-cart hasIcon step_forward left"
                                 style="margin-top:25px;margin-left: 15px;">

                                <a id="lkstepShipping" class="raysan-button green" onclick="redirectToShipping()">

                                    <i class="icon raysan-button-icon raysan-button-icon-caretLeft"></i>

                                    <span class="raysan-button-label clearfix">
                                            <span class="raysan-button-labelname">انتخاب شیوه ارسال</span>
                                        </span>

                                </a>

                            </div>

                            <div class="seven left" style="margin-top: 25px;">
                                بر اساس مکان تحویل سفارش، امکان افزوده شدن هزینه ارسال به این مبلغ وجود دارد.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            }
            else {
                $_SESSION['order_count'] = 0;
                echo 'سبد خرید شما خالی است.';
                //$row[ 0 ][ 'order_id' ]    = 0 ;
            }
            ?>
        </div>
        <br>
        <div class="clearfix"></div>

    </div>
</main>

<main class="mobile-view rtl mobile-view-design" style="margin-top:60px">
    <?php
    $priceTotal = 0;
    $discountTotal = 0;
    $priceSumCart = 0;
    if ($row) {
        foreach ($row AS $data) {
            $price = $data['price'] * $data['count'];
            $priceUnit = $data['price'] * $data['count'];

            $discount = $data['discountEnd'] * $data['count'];
            $endPrice=$price-$discount;
            $priceSumCart = $priceSumCart + ($price - $discount);
            $priceTotal += $price;
            $discountTotal += $discount;
            ?>
            <div class="grid-row section-mainDetail div-line-height"
                 style="margin: 5px;padding: 0px;position: relative;padding-bottom: 10px;">
                <div style="width:25%;float: right;text-align: center;padding: 20px 5px">
                    <a href="<?= \f\ifm::app()->siteUrl ?>productDetail/<?= $data['product_id'] ?>" target="_blank">
                        <?php
                        if($data['dynamic']=='true'){?>
                            <img src="<?=$data['product_pic']  ?>"
                                 alt="<?= $data['productTitle'] ?>" title="<?= $data['productTitle'] ?>"
                                 class="img-responsive">
                       <?php
                        }else {
                            ?>
                            <img src="<?=\f\ifm::app()->fileBaseUrl . $data['picture'] ?>"
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
                            <?php
                            //\f\pre($data);
                            if($data['dynamic']!=true) {
                                //\f\pr('dsf');
                                //\f\pr($data['dynamic']);
                                ?>
                                <span style="width:70px;display: inline-block;color:#000">رنگ : </span>
                                <span style="display: inline;color:#aaa"><?= $data['colorTitle'] ?> <i
                                            id="iProductColor"
                                            style="background-color:<?= $data['colorCode'] ?>"></i></span>
                                <?php
                            }else{
                               // \f\pr('bu');
                               // \f\pr($data['dynamic']);
                                ?>
                                <span style="width:70px;display: inline-block;color:#000">اندازه : </span>
                                <span><?= $data['size'] ?> </span>
                            <?php
                            }
                            ?>
                        </div>
                        <?php
                        if($data['dynamic']!=true) {
                            ?>
                            <div>
                                <span style="width:70px;display: inline-block;color:#000">گارانتی : </span>
                                <span style="display: inline;color:#aaa"><?= $data['guranteeTitle'] ?></span>
                            </div>
                            <?php
                        }
                        ?>
                        <div>
                            <span style="width:70px;display: inline-block;color:#000">قیمت : </span>
                            <span class="unitprice price-total-product fa-digit"
                                  id="span_price_all_<?= $data['orderItem_id'] ?>"><?= number_format($endPrice) ?></span>
                        </div>

                        <div style="margin-top:15px">
                            <span style="width:70px;display: inline-block;color:#000">تعداد : </span>
                            <span style="display: inline;color:#aaa">
                                <?php
                                if ($data['count'] > 0) {
                                    ?>
                                    <select style="width:100px" name="order_count_<?= $data['orderItem_id'] ?>"
                                            onchange="calcPrice(<?= $data['orderItem_id'] ?>)"
                                            id="order_count_<?= $data['orderItem_id'] ?>">
                                        <?php
                                        if($data['dynamic']=='true'){
                                         $stockAll=1000;
                                        }else {
                                            $stockAll = $data['stock'] == 0 ? $data['stock'] + 1 : $data['stock'];

                                           // $stockAll=10;
                                        }
                                        //\f\pre($stockAll);
                                        for ($i = 1; $i <= $stockAll; $i++) {
                                            if ($i == $data['count']) {
                                                $selected = "selected='selected'";
                                            }
                                            echo '<option  value="' . $i . '" ' . $selected . '>' . $i . '</option>';
                                            $selected = '';
                                        }
                                        ?>
                                    </select>
                                    <?php
                                } else {
                                    echo '<span style="color:#DD1E25">ناموجود</span>';
                                }
                                ?>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div style="position: absolute;top:0px;left: 0px;text-align: center;width: 0;height: 0;border-style: solid;border-width: 50px 50px 0 0;border-color: #e89797 transparent transparent ">
                </div>
                <a class="btnDeleteCart" data="<?= $data['orderItem_id'] ?>"
                   style="position: absolute;top: 1%;left: 3%;">
                    <i class="fa fa-times" title="حذف محصول"></i>
                </a>
            </div>

            <input type="hidden" id="product_price_id_<?= $data['orderItem_id'] ?>"
                   value="<?= $data['product_price_id'] ?>">
            <input type="hidden" id="product_old_count_<?= $data['orderItem_id'] ?>" value="<?= $data['count'] ?>">
            <input type="hidden" id="product_price_<?= $data['orderItem_id'] ?>" value="<?php if($data['user_type']=='normUser'){
                echo $data['user_price'];
            }elseif($data['user_type']=='seller'){
                echo $data['price'];
            }  ?>">

            <?php  if($data['type_discount_end']=='percent'){
                $discountEndPrice=$data['price']*($data['discount_price']/100);
            }else{
                $discountEndPrice=$data['discount_price'];
            } ?>

            <input type="hidden" id="product_discount_<?= $data['orderItem_id'] ?>"
                   value="<?=$discountEndPrice?>">


            <?php
        }
        ?>


        <div onclick="redirectToShipping()"
             style="z-index:999;position:fixed;bottom: 0px;right: 0px;text-align: center;height: 40px;line-height: 40px;width: 100%;background: #3BB153;color:#fff;cursor: pointer;font-size: 15px">
            انتخاب شیوه ارسال
            <i class="fa fa-arrow-left" style="font-size:18px;padding-right:5px;position: relative;top:3px"></i>
        </div>

        <?php
    } else {
        $_SESSION['order_count'] = 0;
        echo '<div class="alert alert-warning"><i class="fa fa-warning"></i> سبد خرید شما خالی است.</div>';
        //$row[ 0 ][ 'order_id' ]    = 0 ;
    }
    ?>
</main>

<style>
    .white-color {
        color: darkgreen !important;
    }

    .red-color {
        color: darkred !important;
    }

    .styled-select::before {
        background: none !important;
    }

    .styled-select {
        width: 100%;
    }

    @media only screen and (max-width: 980px) {
        .foot .btn-foot .seven {
            margin-top: 20px;
            margin-left: -2% !important;
            width: 300px !important;
        }

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
        border: 2px solid #ddd;
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

    .container-cart .thead {
        background: #eee;
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

    .foot .btn-foot .seven {
        color: #4d4d4d;
        direction: rtl;
        display: inline-block;
        margin-left: 51px;
        position: relative;
        right: 3%;
        width: 366px;
        margin-bottom: 30px;
        float: left;
        font-weight: bold;
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
        font-size: 15px;
        display: inline-block;
        width: 145px;
        text-align: right;
    }

    p.label-price {
        color: #000;
        font-size: 18px;
    }

    .toman {
        color: #666;
        font-size: 11px;
        letter-spacing: 0;
        margin: 0px 5px;
        vertical-align: 2px;
    }

    .finalprice .sep {
        background-color: #86b687;
        height: 1px;
    }

    .finalprice .payable {
        font-size: 14px;
        padding: 15px;
        background-color: #C9EABB;
        border-radius: 0px;
    }

    .finalprice .discount {
        font-size: 14px;
        padding: 15px;
        background-color: #EDCECF;
        border-radius: 0px;
    }

    .finalprice .discount span.label-price {
        font-size: 23px;
    }

    .unitprice {
        color: #666666;
        font-size: 17px;
    }

    .tbody.border {
        min-height: 86px;
    }

    .last a i {
        font-size: 18px;
        color: #DD1E25;
    }

    .col-md-12.head {
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
    }

    .raysan-button-container-cart .raysan-button {
        line-height: 0;
        text-decoration: none;
        -webkit-border-radius: 0px;
        -ms-border-radius: 0px;
        border-radius: 0px;
    }

    .green {
        color: #4caf50 !important;
    }

    .raysan-button-container-cart.hasIcon.step_forward a.raysan-button i.raysan-button-icon {
        float: left;
        background-color: transparent !important;
    }

    .raysan-button-container-cart .raysan-button i.raysan-button-icon.raysan-button-icon-caretLeft {
        background-position: -12px -550px;
    }

    .raysan-button-container-cart.hasIcon .raysan-button i.raysan-button-icon {
        display: block;
        float: right;
        overflow: hidden;
        line-height: 38px;
        width: 54px;
        height: 40px;
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
    header {
        right: 0;
        position: relative;
        top: 0;
        width: 100%;
        z-index: 999;
    }
    .leftProduct .col-lg-3, .col-md-3 {
        padding-left: 0px !important;
        padding-right: 0px !important;
    }
</style>
<script>
    if ($(window).width() <= 767) {
        $('.desktop-view').remove();
    } else {
        $('.mobile-view').remove();
    }
    $('.btnDeleteCart').click(function () {
        var con = confirm("آیا از حذف این مورد مطمئن هستید ؟");
        var c=<?= $row[0]['order_id'] ?>;

        if (con) {
            var option = {
                orderItem_id: $(this).attr('data'),
                order_id: <?= $row[0]['order_id'] ?>
            };
            widgetHelper.tt('ui', 'shop.order.orderItemDelete', option, '');
            return true;
        } else {
            return false;
        }
    });
    $(document).ready(function () {
        var divHeight = $('.tbody').height();
        $('.pd').css('height', divHeight + 'px');
    });

    function calcPrice(valueId) {
        var product_price_id = $("#product_price_id_" + valueId).val();
        var product_old_count = $("#product_old_count_" + valueId).val();
        var product_price = $("#product_price_" + valueId).val();
        var product_discount = $("#product_discount_" + valueId).val();
        var price = product_price - product_discount;
        var option = {
            count: $("#order_count_" + valueId).val(),
            price: price,
            orderItem_id: valueId,
            old_count: product_old_count,
            price_id: product_price_id
        };
        widgetHelper.tt('ui', 'shop.order.updatePriceAndCount', option, 'refreshPrice');
    }

    function refreshPrice(params) {
        $("#product_old_count_" + params.orderItem_id).val($("#order_count_" + params.orderItem_id).val());
        //product_amazing_
        var all_price = $("#product_price_" + params.orderItem_id).val() * $("#order_count_" + params.orderItem_id).val();

        $("#span_price_all_" + params.orderItem_id).text(toTomanComment(all_price));
        var off = $("#product_discount_" + params.orderItem_id).val();

        var discount_all_price = off * $("#order_count_" + params.orderItem_id).val();

        $("#span_price_discount_" + params.orderItem_id).text(toTomanComment(discount_all_price));
        $("#span_price_cart_" + params.orderItem_id).text(toTomanComment(all_price - discount_all_price));

        var sum = 0;
        var sum_total = 0;
        var discount = 0;
        var x;
        $(".span_price_cart").each(function (index, obj) {
            x = $(this).text().split(',').join('');
            sum += parseInt(persianJs(x).persianNumber());
        });
        $(".price-total-product").each(function (index, obj) {
            x = $(this).text().split(',').join('');
            sum_total += parseInt(persianJs(x).persianNumber());
        });
        $(".discount-product").each(function (index, obj) {
            x = $(this).text().split(',').join('');
            discount += parseInt(persianJs(x).persianNumber());
        });
        $(".price-sum-cart").text(toTomanComment(sum));
        $(".price-total-cart").text(toTomanComment(sum_total));
        $(".discount-total-cart").text(toTomanComment(discount));
        $("#price-sum-cart").val(sum);

        $(".fa-digit").each(function () {
            var text = $(this).text();
            var newText = persianJs(text).englishNumber().toString();
            $(this).text(newText);
        });
    }

    function redirectToShipping() {
        var option = {
            order_id: <?= $row[0]['order_id'] ?>,
            user_id:<?= $_SESSION['user_id'] ?>,
            status: 'cart'
        };
        widgetHelper.tt('ui', 'shop.order.calculatOrderEndPrice', option, 'goPageShipping');
    }

    function goPageShipping(params) {
        if (params.result['result'] == 'success') {
            window.location.href = '<?= \f\ifm::app()->siteUrl ?>shipping';
        } else {
            window.location.reload();
        }
    }
</script>
