<?php
if ( $_SESSION['user_id'] )
{
    //\f\pre ( $row);
    ?>
    <!-- page content -->
    <main class="page-content rtl">
        <section class="grayBack dir-rtl">
            <div class="container">
                <div>
                    <div class="url-page-box marginTop120">
                        <div class="page-address-box padding-addressBar">
                            <i style="padding-left:3px;" class="fa fa-home"></i>
                            <a href="<?= \f\ifm::app ()->siteUrl ?>"><span class="address-name">خانه</span></a><span
                                    class="arrow-address5 fa fa-angle-right"></span><span class="address-name"> حساب کاربری </span>
                        </div>
                    </div>
                </div>
            </div>
        <!--        <div class="container">-->
        <!--            <div class="row">-->
        <!--                <div class="url-page-box">-->
        <!--                    <div class="page-address-box padding-addressBar">-->
        <!--                        <i style="padding-left:3px;" class="fa fa-home"></i><span class="address-name"><a-->
        <!--                                    href="--><? //= \f\ifm::app()->siteUrl
        ?><!--">خانه</a></span><span-->
        <!--                                class="arrow-address5 fa fa-angle-left"></span><span-->
        <!--                                class="address-name"> حساب کاربری</span>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->
        <div class="container grid-row desktop-view" style="padding-top: 1px;margin-top: 20px;">
            <div class="order-box row">

                <div class="boxheader">
                    <img style="    width: 66px;
    margin-top: -25px;
    padding-left: 5px;
    vertical-align: -27px;" src="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/digifirst/img/Untitled-1.png">
                    <span> اطلاعات کاربری </span>
                    <button style="float: left" class="btn btn-danger-logut rtl"
                            onclick="window.location.href = '<?= \f\ifm::app()->siteUrl ?>member/logout'"><i
                                class="fa fa-sign-out"></i><?= ' خروج از حساب کاربری ' ?></button>
                </div>
                <div class="contetn-Report row">
                    <div class="col-md-6 col-sm-12 ">
                        <div class="report-one-box">
                            <div class="span-order-details">
                                <span class="col-md-5 no-mobile-padding">نام و نام خانوادگی :
                                </span>
                                <span class="col-md-7 set-user-fild">
                                    <?= $row['name'] ? $row['name'] : "-" ?>
                                </span>
                            </div>

                            <?php
                            $gender = $row['gender'] == 'male' ? 'مرد' : 'زن';
                            ?>
                            <div class="span-order-details">
                                <span class="col-md-5 no-mobile-padding">جنسیت : </span><span
                                        class="col-md-7 set-user-fild"><?= $gender ? $gender : '-' ?></span>
                            </div>
                            <div class="span-order-details">
                                <span class="col-md-5 no-mobile-padding">کد ملی :   </span><span
                                        class="set-user-fild col-md-7 fa-digit"><?= \f\ifm::faDigit($row['national_code'] ? $row['national_code'] : '-') ?></span>
                            </div>
                            <div class="span-order-details">
                                <span class="col-md-5 no-mobile-padding">تاریخ تولد :  </span><span
                                        class="set-user-fild col-md-7 fa-digit"><?= \f\ifm::faDigit($row['birthday'] ? $row['birthday'] : '-' )?></span>
                            </div>
                            <!--                            <div class="span-order-details">-->
                            <!--                                <span class="col-md-5 no-mobile-padding"> شماره کارت بانکی :</span><span class="col-md-7 set-user-fild fa-digit">-->
                            <? //= $card
                            ?><!--</span>-->
                            <!--                            </div>-->
                            <div class="span-order-details">
                                <span class="col-md-5 no-mobile-padding"> نام فروشگاه :</span><span
                                        class="col-md-7 set-user-fild fa-digit"><?= $row['shop_name'] ? $row['shop_name'] : "-" ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="report-one-box">
                            <div class="span-order-details">
                                <span class="col-md-4 no-mobile-padding">شماره تلفن ثابت : </span><span
                                        class="col-md-8 set-user-fild fa-digit"><?=\f\ifm::faDigit($row['phone'] ? $row['phone'] : "-") ?></span>
                            </div>
                            <div class="span-order-details">
                                <span class="col-md-4 no-mobile-padding">شماره تلفن همراه : </span><span
                                        class="set-user-fild col-md-8 fa-digit"><?= \f\ifm::faDigit(($row['mobile'] ? $row['mobile'] : "-")) ?></span>
                            </div>
                            <div class="span-order-details">
                                <span class="col-md-4 no-mobile-padding">رایانامه ( ایمیل )</span><span
                                        class="set-user-fild col-md-8"><?= $row['email'] ? $row['email'] : "-" ?></span>
                            </div>
                            <div class="span-order-details">
                                <span class="col-md-4 no-mobile-padding">آدرس محل سکونت :</span><span
                                        class="set-user-fild col-md-8 fa-digit">
                                    <?php if ( $row['state'] )
                                    {
                                        ?>
                                        <?= $row['state'] . '-' . $row['city'] . ' - ' . $row['address'] ?>
                                        <?php
                                    } else
                                    {
                                        ?>
                                        -
                                        <?php
                                    }
                                    ?>
                                </span>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-5 col-sm-12 no-mobile-padding">

                        <div class="img-bottom-order ">
                            <button class="btn btn-info-edit rtl"
                                    onclick="window.location.href = '<?= \f\ifm::app()->siteUrl ?>additionalinfo'"><i
                                        class="fa fa-pencil" style="font-size: 16px;
    padding-left: 4px;"></i><?= ' ویرایش اطلاعات ... ' ?></button>
                            <button class="btn btn-success-log rtl"
                                    onclick="window.location.href = '<?= \f\ifm::app()->siteUrl ?>passwordChange'"><i
                                        class="fa  fa-unlock-alt" style="font-size: 16px;
    padding-left: 4px;"></i><?= ' تغییر کلمه عبور ' ?></button>
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-12 no-mobile-padding">
                        <?php if ( $upgradeRequest == 'set' )
                        {
                            ?>
                            <button type="button" disabled
                                    class="setUpgrade upgrade-user-icon dis-btn-upgrade btn btn-primary">
                                <i class="fa fa-check-square-o"></i>
                                درخواست ارتقا حساب شما تایید شد .
                            </button>
                            <?php
                        } elseif ( $upgradeRequest == 'suspended' )
                        {
                            ?>
                            <button type="button" disabled class="upgrade-user-icon dis-btn-upgrade btn btn-primary">
                                درخواست ارتقا حساب شما در حال بررسی است
                            </button>
                            <?php
                        }
                        ?>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">

                                <form action="<?= \f\ifm::app()->siteUrl ?>member/UpgradeUserSave" method="POST"
                                      class="clearfix" id="UpgradeUserSave" novalidate="novalidate">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel"> درخواست ارتقا به
                                                فروشنده </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="recipient-name" class="col-form-label"> نام فروشگاه:</label>
                                                <input name="shop_name" type="text" class="form-control"
                                                       id="recipient-name">
                                            </div>
                                            <div class="form-group">
                                                <label for="message-text" class="col-form-label"> آدرس فروشگاه :</label>
                                                <textarea name="address" class="form-control"
                                                          id="message-text"></textarea>
                                            </div>
                                            <input name="user_id" type="hidden" value="<?= $_SESSION['user_id'] ?>"
                                                   class="form-control" id="user_id">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal"> بستن
                                            </button>
                                            <button type="submit" class="btn btn-primary"> ارسال درخواست</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>

                    </div>

                    <div class="clearfix"></div>
                </div>

            </div>
            <div class="row">

                <div class="col-md-12">
                    <div class="order-box row bag-favorit-box" >
                        <div class="boxheader">
                            <span><i class="fa fa-star"></i> علاقه مندی ها </span>
                        </div>
                        <div class="contetn-Report bag-favorit-content ajaxFavoritContent">
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-order-details row">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active nav-tab-order"><a href="#profile" aria-controls="profile"
                                                                            role="tab" data-toggle="tab"><i
                                    class="fa fa-list"></i> سفارشات من</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="profile">
                        <div class="in-nav-tab-order">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>ردیف</th>
                                        <th>شماره سفارش</th>
                                        <th>تاریخ</th>
                                        <th style="display:none;">مبلغ کل</th>
                                        <th>وضعیت</th>
                                        <th>عملیات پرداخت</th>
                                        <th>عملیات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if ( $orders )
                                    {

                                        $i = 0;
                                        $this->registerGadgets( [
                                            'dateG' => 'date' ] );
                                        $oldOrderId = 0;
                                        foreach ( $orders AS $data )
                                        {
                                            $i++;
                                            $discountCodePrice = \f\ttt::service( 'shop.order.getSumDiscountCodePrice',
                                                [
                                                    'orderId' => $data['id']
                                                ] );
                                            if ( $data['order_id'] != $oldOrderId )
                                            {
                                                $oldOrderId = $data['order_id'];
                                                ?>
                                                <tr class="View-status-product">
                                                    <td class="fa-digit">
                                                        <?= $i ?>
                                                    </td>
                                                    <td class="fa-digit">
                                                        <?= $data['id'] + 100000 ?>
                                                    </td>
                                                    <td class="fa-digit">
                                                        <ul>
                                                            <li>
                                                                <?php
                                                                echo $this->dateG->dateTime( $data['date_pay'],
                                                                    2 );
                                                                ?>
                                                            </li>
                                                            <li>
                                                                <?php
                                                                echo ' ، ساعت ' . date( 'H:i',
                                                                        $data['date_pay'] );
                                                                ?>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                    <td style="display:none" class="fa-digit">
                                                        <?= number_format( ( $data['price'] - $data['discount'] - $discountCodePrice ) + $data['transportation_cost'] ) ?>
                                                        <span class="toman ">تومان</span>
                                                    </td>
                                                    <td class="set-send-style">
                                                        <?php
                                                        switch ( $data['status'] )
                                                        {
                                                            case "unpayed":
                                                                echo 'کنسل شده-پرداخت ناموفق';
                                                                break;
                                                            case "payed":
                                                                echo 'پرداخت شده-درحال بررسی';
                                                                break;
                                                            case "delivery":
                                                                echo 'تحویل شده';
                                                                break;
                                                            case "cashOn":
                                                                echo 'پرداخت در محل';
                                                                break;
                                                            case "accountingOk":
                                                                echo 'تایید مالی';
                                                                break;
                                                            case "accountingNo":
                                                                echo 'عدم تاییدمالی';
                                                                break;
                                                            case "inventoryOk":
                                                                echo 'تایید انبار';
                                                                break;
                                                            case "inventoryNo":
                                                                echo 'درحال تامین موجودی';
                                                                break;
                                                            case "sending":
                                                                echo 'در حال ارسال';
                                                                break;
                                                            case "returned":
                                                                echo 'مرجوعی';
                                                                break;
                                                            case "credit":
                                                                echo 'اعتباری';
                                                                break;
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                        if ( $data['status'] == 'unpayed' )
                                                        {
                                                            ?>
                                                            <a href="<?= \f\ifm::app()->siteUrl ?>payment/<?= $data['id'] ?>"><img
                                                                        src="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/main/img/Payment.png"
                                                                        class="img-responsive"></a>

                                                            <?php
                                                        } else
                                                        {
                                                            ?>
                                                            <img class="disable-pay-img"
                                                                 src="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/main/img/Payment.png"
                                                                 class="img-responsive">

                                                            <?php
                                                        }
                                                        ?>
                                                    </td>
                                                    <td>
                                                            <a  data-placement="top"
                                                               title=" جزئیات فاکتور " class="show-factor-detail"
                                                               href="<?= \f\ifm::app()->siteUrl ?>factorDetail/<?= $data['id'] ?>"><i
                                                                        class="fa fa-list" aria-hidden="true"></i></a>
                                                        <a data-toggle="modal" id="<?= $data['id'] ?>"
                                                           data-target="#copyFactorModal" class="factor-copy"
                                                           data-placement="top" title=" کپی فاکتور "><i
                                                                    class="fa fa-files-o" aria-hidden="true"></i></a>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                    } else
                                    {
                                        ?>
                                        <tr class="View-status-product">
                                            <td>
                                                    <span>
                                                        موردی برای نمایش وجود ندارد.
                                                    </span>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                    </tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="messages">
                        <div class="messages-no-ithem">
                            <span>آیتمی برای نمایش وجود ندارد.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="copyFactorModal" tabindex="-1" role="dialog"
             aria-labelledby="copyFactorModal" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">

                <form action="<?= \f\ifm::app()->siteUrl ?>member/buyAgainFactor"
                      method="POST"
                      class="clearfix" id="buyAgainFactor"
                      novalidate="novalidate">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">
                                خرید مجدد
                            </h5>
                            <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body creatModalBody">

                            <div class="form-group">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal"> بستن
                            </button>
                            <button type="submit" class="btn btn-primary">
                                خرید مجدد فاکتور
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="grid-row mobile-view" style="background-color: #fff ;padding-top: 1px;">
            <div class="boxheader mobile-user-show blur">

                <img src="<?= \f\ifm::app()->siteUrl . 'app/ui/templates/frontend/main/img/man-white-icon-hi.png' ?>">
                <div class="mobile-user-name"> <span class="col-md-7 set-user-fild">
                        <?= $row['name'] ?>
                    </span>
                </div>
                <div class="img-bottom-order btn-order-mobile">
                    <a class="  rtl" onclick="window.location.href = '<?= \f\ifm::app()->siteUrl ?>additionalinfo'"><i
                                class="fa fa-pencil-square-o"></i><?= ' ویرایش اطلاعات ' ?></a>
                    <a style="border-left: #fff solid 2px; border-right: #fff solid 2px;" class="rtl"
                       onclick="window.location.href = '<?= \f\ifm::app()->siteUrl ?>passwordChange'"><i
                                class="fa  fa-unlock-alt"></i><?= ' تغییر کلمه عبور ' ?></a>
                    <a class="  rtl" onclick="window.location.href = '<?= \f\ifm::app()->siteUrl ?>member/logout'"><i
                                class="fa fa-sign-out"></i><?= ' خروج ' ?></a>
                </div>
            </div>
            <div class="Specifications">
                <ul class="nav nav-tabs account  mobile-view" id="tab-mobile" style="border:none;">
                    <li class="active" onclick="setOffset()" style=" width: 50%;text-align: center;">
                        <a style="box-shadow:none;" class="set-toggle-custom" data-toggle="tab" href="#home">اطلاعات
                            کاربری</a>
                    </li>
                    <li onclick="setOffset()" style=" width: 50%;text-align: center;">
                        <a style="box-shadow:none;" class="set-toggle-custom" data-toggle="tab" href="#menu1">سفارشات
                            من </a>
                    </li>
                </ul>
                <div class="tab-content" style="padding-bottom:100px">
                    <div id="home" class=" tab-pane in-tab-custome mobile-view-senc fade in active">
                        <div class="order-box">
                            <div class="contetn-Report">
                                <div class="col-md-6 col-sm-12 ">
                                    <div class="report-one-box">
                                        <div class="span-order-details">
                                            <span class="col-md-5 no-mobile-padding">نام و نام خانوادگی :
                                            </span>
                                            <span style="float: left;" class="col-md-7 set-user-fild">
                                                <?= $row['name'] ?>
                                            </span>
                                        </div>
                                        <?php
                                        $gender = $row['gender'] == 'male' ? 'مرد' : 'زن';
                                        ?>
                                        <div class="span-order-details">
                                            <span class="col-md-5 no-mobile-padding">جنسیت : </span><span
                                                    class="col-md-7 set-user-fild"><?= $gender ?></span>
                                        </div>
                                        <div class="span-order-details">
                                            <span class="col-md-5 no-mobile-padding">کد ملی :   </span><span
                                                    class="set-user-fild col-md-7 fa-digit"><?= \f\ifm::faDigit($row['national_code']) ?></span>
                                        </div>
                                        <div class="span-order-details">
                                            <span class="col-md-5 no-mobile-padding">تاریخ تولد :  </span><span
                                                    class="set-user-fild col-md-7 fa-digit"><?= $row['birthday'] ?></span>
                                        </div>
                                        <div class="span-order-details">
                                            <span class="col-md-5 no-mobile-padding"> شماره کارت بانکی :</span><span
                                                    class="col-md-7 set-user-fild fa-digit"><?= $card ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-sm-12">
                                    <div class="report-one-box">
                                        <div class="span-order-details">
                                            <span class="col-md-5 no-mobile-padding">شماره تلفن ثابت : </span><span
                                                    class="col-md-7 set-user-fild fa-digit"><?= $row['phone'] ?></span>
                                        </div>
                                        <div class="span-order-details">
                                            <span class="col-md-5 no-mobile-padding">شماره تلفن همراه : </span><span
                                                    class="set-user-fild col-md-7 fa-digit"><?= \f\ifm::faDigit($row['mobile']) ?></span>
                                        </div>
                                        <div class="span-order-details">
                                            <span class="col-md-5 no-mobile-padding">رایانامه ( ایمیل )</span><span
                                                    class="set-user-fild col-md-7"><?= $row['email'] ?></span>
                                        </div>
                                        <div class="span-order-details">
                                            <span class="col-md-5 no-mobile-padding">آدرس محل سکونت :</span>
                                            <div>
                                                <span style="text-align: right !important;     float: none;    color: #5d6970;"
                                                      class="no-mobile-padding set-user-fild col-md-7 fa-digit"> <?= 'استان ' . $row['state'] . ' - شهر ' . $row['city'] . ' - ' . $row['address'] ?></span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>

                        </div>
                    </div>
                    <div id="menu1" class="in-tab-custome tab-pane fade">
                        <div class="tab-order-details">
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="profile">
                                    <div class="in-nav-tab-order">
                                        <div>
                                            <div class="tab-order-details">
                                                <div class="panel-group" id="accordion" role="tablist"
                                                     aria-multiselectable="true">

                                                    <?php
                                                    if ( $orders )
                                                    {
                                                    $i = 0;
                                                    $this->registerGadgets( [
                                                        'dateG' => 'date' ] );
                                                    $oldOrderId  = 0;
                                                    $totalAmount = 0;
                                                    foreach ( $orders AS $data )
                                                    {
                                                    $i++;
                                                    $discountCodePrice = \f\ttt::service( 'shop.order.getSumDiscountCodePrice',
                                                        [
                                                            'orderId' => $data['id']
                                                        ] );
                                                    ?>
                                                    <?php
                                                    if ( $data['order_id'] != $oldOrderId )
                                                    {
                                                    if ( $oldOrderId != 0 )
                                                    {
                                                        echo '</div></div></div></div>';
                                                    }
                                                    $oldOrderId = $data['order_id'];
                                                    ?>
                                                    <div style="border-radius: 0px;" class="panel panel-default">
                                                        <div class="panel-heading" role="tab"
                                                             id="heading<?= $data['order_id'] ?>">
                                                            <h4 class="panel-title">
                                                                <a role="button" data-toggle="collapse"
                                                                   data-parent="#accordion"
                                                                   href="#collapseOne<?= $data['order_id'] ?>"
                                                                   aria-expanded="true"
                                                                   aria-controls="collapseOne<?= $data['order_id'] ?>"
                                                                   class="fa-digit">
                                                                    <?php echo $data['id'] + 100000 ?>
                                                                </a>
                                                                <a style="float: left;" role="button"
                                                                   data-toggle="collapse" data-parent="#accordion"
                                                                   href="#collapseOne<?= $data['order_id'] ?>"
                                                                   aria-expanded="true"
                                                                   aria-controls="collapseOne<?= $data['order_id'] ?>">
                                                                                <span class="status-product">
                                                                                    <?php
                                                                                    switch ( $data['status'] )
                                                                                    {
                                                                                        case "unpayed":
                                                                                            echo 'کنسل شده-پرداخت ناموفق';
                                                                                            break;
                                                                                        case "payed":
                                                                                            echo 'پرداخت شده-درحال بررسی';
                                                                                            break;
                                                                                        case "delivery":
                                                                                            echo 'تحویل شده';
                                                                                            break;
                                                                                        case "cashOn":
                                                                                            echo 'پرداخت در محل';
                                                                                            break;
                                                                                        case "accountingOk":
                                                                                            echo 'تایید مالی';
                                                                                            break;
                                                                                        case "accountingNo":
                                                                                            echo 'عدم تاییدمالی';
                                                                                            break;
                                                                                        case "inventoryOk":
                                                                                            echo 'تایید انبار';
                                                                                            break;
                                                                                        case "inventoryNo":
                                                                                            echo 'درحال تامین موجودی';
                                                                                            break;
                                                                                        case "sending":
                                                                                            echo 'در حال ارسال';
                                                                                            break;
                                                                                        case "returned":
                                                                                            echo 'مرجوعی';
                                                                                            break;
                                                                                    }
                                                                                    ?>
                                                                                </span>
                                                                    <i style="font-size: 15px;" class="fa fa-angle-down"
                                                                       aria-hidden="true"></i>
                                                                </a>
                                                            </h4>

                                                        </div>
                                                        <div id="collapseOne<?= $data['order_id'] ?>"
                                                             class="panel-collapse collapse" role="tabpanel"
                                                             aria-labelledby="heading<?= $data['order_id'] ?>">
                                                            <div>
                                                                <div class="detail-order-mobil">
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    <?php
                                                                    if ( number_format( ( $data['price'] - $data['discount'] - $discountCodePrice ) + $data['transportation_cost'] ) != $totalAmount )
                                                                    {
                                                                        $totalAmount = number_format( ( $data['price'] - $data['discount'] - $discountCodePrice ) + $data['transportation_cost'] );
                                                                        ?>
                                                                        <div class="totalAmount">
                                                                            <span>مبلغ کل:</span><span
                                                                                    class="fa-digit"><?= number_format( ( $data['price'] - $data['discount'] - $discountCodePrice ) + $data['transportation_cost'] ) ?>
                                                                                    </span>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                    <div class="content-panel-set">
                                                                        <div>
                                                                            <div class="order-image-product col-xs-4">
                                                                                <img class="img-responsive"
                                                                                     src="<?= \f\ifm::app()->fileBaseUrl . $data['picture'] ?>"
                                                                                     alt=" <?php echo $row['title'] ?>">
                                                                            </div>
                                                                            <div class="col-xs-8 order-name-product">
                                                                                <span><?php echo $data['title'] ?>  </span>
                                                                                <div>
                                                                                    <span class="guaranteeTitle-mobile">گارانتی :</span><?php echo $data['guaranteeTitle'] ?>
                                                                                </div>
                                                                                <div>
                                                                                    <span class="guaranteeTitle-mobile ">تعداد :</span><span
                                                                                            class="fa-digit"> <?php echo $data['count'] ?> </span>
                                                                                </div>
                                                                            </div>
                                                                            <div class="clearfix"></div>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                    }
                                                                    echo '</div></div></div>';
                                                                    }
                                                                    else
                                                                    {
                                                                        ?>
                                                                        <tr class="View-status-product">
                                                                            <td>
                                                                                <span>
                                                                                    موردی برای نمایش وجود ندارد.
                                                                                </span>
                                                                            </td>
                                                                        </tr>
                                                                        <?php
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>


                                    </div>
        </section></main>

    <script>
        ajaxFavoritContent();
        function ajaxFavoritContent(){
            var option = {
                user_id: <?= $_SESSION['user_id']?>
            };
            widgetHelper.tt('ui', 'member.getFavoriteProduct', option, 'showResultFavoriteContent');
        }
        function showResultFavoriteContent(params)
        {
            $('.ajaxFavoritContent').html(params.content);
            widgetHelper.removeLoading();
        }

        $(document).ready(function () {
            $('.faNumber').each(function () {
                    addCommas(this);
                }
            );


        });
        String.prototype.toPersianDigits= function(){
            var id= ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
            return this.replace(/[0-9]/g, function(w){
                return id[+w]
            });
        }
        function addCommas(className)
        {
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
                nStr = nStr+mines ;
            }

            //id.value = nStr;
            $(className).text(nStr);

        }

        //alert(S.toIndiaDigits());

     //   $("#log").html($('#log').html() + ""+S.toPersianDigits());
    </script>
    <script>
        $(document).ready(function () {
            $(".pic-Sample-slider").hover(function () {
                $(".carousel-custome").css("opacity", "1");
            }, function () {
                $(".carousel-custome").css("opacity", "0");
            });
        });
        $('.factor-copy').click(function () {
            var orderCopyId = $(this).attr('id');
            var option = {
                order_id: orderCopyId,
                user_id: <?= $_SESSION['user_id']?>,
            };

            widgetHelper.tt('ui', 'member.getCopyOrderDetail', option, 'showResultInCopyModal');
        })

        function showResultInCopyModal(params) {
            $('.creatModalBody').html(params.content);
        }

        function reCharge() {
            var option = {
                bank: 'mellat',
                user_id:<?=$_SESSION['user_id']?>,
                walletIncreaseValue:$('#walletIncreaseValue').val()
            };
            widgetHelper.tt('ui', 'member.reCharge', option, 'goPageBankOrCheckout');
        }
        function goPageBankOrCheckout(params){
            if (params.result.func == 'goToBank') {
                goToBankNew(params.result.params);
            }
        }
        function goToBankNew(params) {
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
        }
    </script>
    <?php
} else
{
    header( "Location: " . \f\ifm::app()->siteUrl . 'login' );
}
?>
<style>
    .greenColor{
        color:#4cae4c;
    }
    .wallet{
        height:70px;
        margin-top: 20px;
        text-align: center;
        padding-top:10px;
    }
    .wallet-value{
        margin-right: 15px;
        margin-left:15px;
        margin-top:75px
    }
    .centerAlign{
        text-align: center;
    }
    .favorit-item {
        border-bottom: #00000017 solid 1px;
        margin-top: 2px;
    }

    .fa-product-delet {
        padding-top: 12px;
    }

    .fa-product-delet i {
        font-size: 20px;
        color: #e57373;
        border: #e57373 solid 1px;
        border-radius: 5px;
        padding: 5px;
    }

    .fa-product-title {
        padding-top: 12px;
        padding-top: 17px;
    }

    .fa-product-image img {
        width: 100% !important;
        padding: 8px;
    }

    button.btn.btn-danger-logut.rtl {
        background: none;
        color: #ef5350bf;
        padding: 1px 5px;
    }

    button.btn.btn-danger-logut.rtl i {
        font-size: 19px;
    }

    button.btn.btn-success-log.rtl:hover {
        background: none;
    }

    .btn-success-log {
        color: #4cae4c;
        background-color: #5cb85c;
        border-color: #4cae4c;
        background: none;
        border: none;
    }

    button.btn.btn-info-edit.rtl {
        background: none !important;
        color: #1ca2bd !important;
    }

    .table > thead > tr > th {
        color: #fff;
        font-size: 13px;
    }

    .boxheader {
        padding-right: 15px;
        width:100%;
    }

    .contetn-Report.bag-favorit-content {
        height: 208px;
        width:100%;
    }

    .boxheader i {
        padding-left: 5px;
    }

    .table {
        width: 100%;
        max-width: 100%;
        margin-bottom: 0px;
    }

    .tab-order-details > ul {
        border-top: none;
        padding-bottom: 0px;
        width:100%;
    }

    .tab-order-details > ul.nav-tabs > li.nav-tab-order.active > a {
        border-radius: 0px;
    }

    .boxheader i {
        padding-right: 7px;
    }

    .boxheader {
        background-color: #f7f7f7;
        height: 36px;
        border-radius: 0px;
        margin-right: 0px;
        text-align: right;
        color: #85b3be;
        padding: 7px;
        font-size: 15px;
        padding-bottom: 35px !important;
    }

    .contetn-Report.bag-favorit-content {
        height: 208px;
        /* overflow: auto; */
        overflow-y: scroll;
    }

    .span-order-details > span.set-user-fild {
        text-align: right;
        color: #939393;
        font-size: 13px;
        height: 27px;
    }

    .col-md-3.wallet-img img {
        max-width: 51px;
        padding-top: 19px;
    }

    .in-nav-tab-order > div.table-responsive > table > thead > tr > th {
        border: none;
    }

    .span-order-details > span {
        text-align: right;
        color: #bababa;
        font-size: 13px;
    }

    button.upgrade-user-icon.btn.btn-primary {
        width: 148px;
        position: absolute;
        left: 15px;
        bottom: 63px !important;
        font-size: 12px;
        padding: 11px;
        background: #5cb85c;
        border: #5cb85c;
    }

    button.upgrade-user-icon.btn.btn-primary i {
        font-size: 18px;
        margin-bottom: 4px;
    }

    button.setUpgrade.upgrade-user-icon.dis-btn-upgrade.btn.btn-primary {
        background: #dff0d8;
        border: #dff0d8;
        color: #3c763d;
    }

    .dis-btn-upgrade {
        width: 258px !important;
        position: absolute;
        left: 15px;
        bottom: 70px !important;
        font-size: 12px;
        padding: 11px;
        background: #F44336;
        border: #F44336;
        color: white;
    }

    .order-box.row.bag-favorit-box {
        margin-top: 16px;
    }

    .tab-order-details {
        margin-bottom: 50px;
    }

    a.show-factor-detail {
        font-size: 14px;
        color: #828282;
    }

    a.factor-copy i {
        /* background: #03A9F4; */
        padding: 7px;
        border-radius: 8px;
        color: #00bcd4;
        border: #00bcd4 solid 1px;
    }

    a.factor-copy:hover {
        cursor: pointer;
    }

    a.factor-copy {
        font-size: 15px;
        margin-right: 5px;
        color: #fff;
        padding-top: 0px;
        padding-bottom: 0px;
    }

    a.show-factor-detail {
        font-size: 15px;
        color: #fff;
        padding-top: 0px;
        padding-bottom: 0px;
    }

    a.show-factor-detail i {
        /* background: #E91E63; */
        padding: 7px;
        border-radius: 7px;
        border: #44648085 solid 1px;
        color: #44648085;
    }

    .modal-header {
        padding: 9px 15px 0px 15px;
        background: #f7f7f7;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
    }

    .modal-header h5 {
        color: #775656bd;
        font-size: 15px;
        display: inline;
    }

    .tab-order-details > ul.nav-tabs > li.active.nav-tab-order > a, .nav-tabs > li.active.nav-tab-order > a:hover, .nav-tabs > li.active.nav-tab-order > a:focus {
        border-top: none !important;
        background: #f7f7f7;
        color: #85b3be !important;
        font-size: 15px;
        border: none;
        padding-top: 11px;
    }

    td.set-send-style {
        background: #ffffff;
        color: #46a651;
    }

    .in-nav-tab-order > div.table-responsive > table > thead > tr {
        background: #00BCD4;
        color: #fff;
    }

    tr.View-status-product {
        border-bottom: #ebebeb solid 1px;
    }

    .col-md-5.wallet-mony {
        color: #bababa;
        font-size: 15px;
        margin-top: 26px;
    }

    .col-md-5.wallet-mony span {
        color: #fb3449ad;
        font-size: 16px;
        font-weight: 700;
    }

    thead.popup-head {
        background: #00BCD4;
        border: #00BCD4 solid 2px;
    }

    thead.popup-head th {
        border: none !important;
    }

    body.index-opt-2 {
        padding-right: 0px !important;
    }

    .modal-header .close {
        margin-top: 0px;
        margin-bottom: 15px;
        display: inline-block;
    }

    .close {
        float: left;
        font-size: 21px;
        font-weight: 700;
        line-height: 1;
        color: #0000006b;
        text-shadow: 0 1px 0 #fff;
        filter: alpha(opacity=20);
        opacity: .2;
        background: white !important;
        opacity: initial;
        padding: 0px 6px !important;
        border-radius: 44px;
        display: inline;
    }

    .Increase-wallet-btn a {
        border: #c4c4c4 solid 1px;
        padding: 9px 10px;
        border-radius: 5px;
        color: #a9a9a9;
    }

    .Increase-wallet-btn:hover {
        cursor: pointer;
    }

    .Increase-wallet-btn:hover a {
        background: #c4c4c44f;
        border: white solid 1px;
    }

    .Increase-wallet-btn {
        padding-top: 31px;
    }
    .tab-order-details > ul.nav-tabs > li.active.nav-tab-order > a{
width:100%;
    }
    .tab-order-details > ul li{
        width:100%;
        display:block;
    }

</style>
