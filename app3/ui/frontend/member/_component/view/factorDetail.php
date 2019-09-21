<?php
if ( $_SESSION['user_id'] )
{
    //\f\pre ( $row);
    ?>
    <!-- page content -->
    <main class="page-content rtl">
        <div class="container">
            <div class="row">
                <div class="url-page-box">
                    <div class="page-address-box padding-addressBar">
                        <i style="padding-left:3px;" class="fa fa-home"></i><span class="address-name"><a
                                    href="<?= \f\ifm::app()->siteUrl ?>">خانه</a></span><span
                                class="arrow-address5 fa fa-angle-left"></span><span
                                class="address-name"> جزئیات فاکتور  </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="container grid-row desktop-view" style="padding-top: 1px;">
            <div class="tab-order-details row">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active nav-tab-order"><a href="#profile" aria-controls="profile"
                                                                            role="tab" data-toggle="tab"><i
                                    class="fa fa-list"></i> جزئیات فاکتور </a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="profile">
                        <div class="in-nav-tab-order">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>ردیف</th>
                                        <th> عنوان کالا</th>
                                        <th> گارانتی </th>
                                        <th> رنگ</th>
                                        <th> تعداد</th>
                                        <th> عملیات</th>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if ( $orderDetail )
                                    {

                                        $i = 0;
                                        $this->registerGadgets( [
                                            'dateG' => 'date' ] );
                                        $oldOrderId = 0;
                                        $modalId = 0 ;
                                        foreach ( $orderDetail AS $data )
                                        {
                                            $i++;
                                            ?>
                                            <tr class="View-status-product">
                                                <td class="fa-digit">
                                                    <?= \f\ifm::faDigit( $i ) ?>
                                                </td>
                                                <td class="fa-digit" style="text-align: right;width: 50%;">
                                                    <div class="inline-asp-box img">
                                                        <img src="<?= \f\ifm::app()->fileBaseUrl . $data['picture'] ?>"
                                                             class="img-responsive">
                                                    </div>
                                                    <div class="inline-asp-box">
                                                        <span class="title-prod-factor"> نام محصول : </span>
                                                        <?= \f\ifm::faDigit( $data['title'] ) ?>
                                                    </div>
                                                </td>
                                                <td class="fa-digit">
                                                    <div class="inline-asp-box">
                                                        <?= \f\ifm::faDigit( $data['guaranteeTitle'] ) ?>
                                                    </div>
                                                </td>
                                                <td class="fa-digit">
                                                    <div class="inline-asp-box">
                                                        <?= \f\ifm::faDigit( $data['colorTitle'] ) ?>
                                                    </div>
                                                </td>
                                                <td class="fa-digit">
                                                    <?= \f\ifm::faDigit( $data['count'] ) ?>
                                                </td>
                                                <td>

                                                    <input class="hidden title-product-select<?= $modalId?>"
                                                           value="<?= $data['title'] ?>">
                                                    <input class="hidden order_number_product_select<?= $modalId?>"
                                                           value="<?= $data['id']?>">
                                                    <input class="hidden product_id_select<?= $modalId?>"
                                                           value="<?= $data['product_id'] ?>">
                                                    <input class="hidden product_id_select<?= $modalId?>"
                                                           value="<?= $data['product_id'] ?>">
                                                    <input class="hidden product_price_id<?= $modalId?>"
                                                           value="<?= $data['product_price_id'] ?>">
                                                    <input class="hidden product_count<?= $modalId?>"
                                                           value="<?= $data['count'] ?>">

                                                    <a id="<?= $modalId?>" type="button" data-toggle="modal"
                                                       data-target="#returnProductModal"
                                                       class="show-factor-detail return-pr"><i
                                                                class="fa fa-undo" aria-hidden="true"></i> مرجوع </a>
                                                </td>
                                            </tr>
                                            <?php
                                            $modalId++;
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



        <div class="modal fade" id="returnProductModal" tabindex="-1" role="dialog"
             aria-labelledby="returnProductModal" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">

                <form action="<?= \f\ifm::app()->siteUrl ?>member/returnProductSave"
                      method="POST"
                      class="clearfix" id="returnProductSave"
                      novalidate="novalidate">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title " id="exampleModalLabel">
                                درخواست مرجوع کالا
                            </h5>
                            <button type="button" class="close" data-dismiss="modal"
                                    aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <table class="table">
                                <thead class="popup-head">
                                <tr>
                                    <th>عنوان محصول</th>
                                    <th> تعداد مرجوع شده این کالا </th>
                                    <th> تعداد خریداری شده </th>
                                    <th> حداکثر تعداد مجاز مرجوعی </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr class="View-status-product">
                                    <td style="padding: 11px 0px !important;text-align: center;" class="title-prod-factor">
                                        <span class="product_name_table"></span>
                                    </td>
                                    <td style="padding: 11px 0px !important;text-align: center;" class="title-prod-factor">
                                        <span class="oldReturn_show"></span>
                                    </td>
                                    <td style="padding: 11px 0px !important;text-align: center;" class="title-prod-factor">
                                        <span class="show_by_count"></span>
                                    </td>
                                    <td style="padding: 11px 0px !important;text-align: center;" class="title-prod-factor">
                                        <span class="allow-ret-number"></span>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            <div class="form-group">
                            </div>
                            <div class="form-group">
                                <label for="return_number" class="col-form-label">
                                    تعداد مرجوعی :</label>
                                <input value="1" max="" name="return_number" min="1"
                                       step="1" type="number"
                                       class="returnNumber form-control"
                                       id="recipient-name">
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="col-form-label">
                                    علت مرجوعی :</label>
                                <textarea name="return_cause" class="form-control" id="message-text"></textarea>
                            </div>
                            <input name="user_id" type="hidden"
                                   value="<?= $_SESSION['user_id'] ?>"
                                   class="form-control" id="user_id">

                            <input name="return_title-product" type="hidden"
                                   class="form-control return_title-product" id="user_id">

                            <input name="order_id" type="hidden"
                                   class="form-control order_number" id="user_id">

                            <input name="return_product_id" type="hidden"
                                   class="form-control return_product_id" id="user_id">

                            <input name="return_price_id" type="hidden"
                                   class="form-control return_price_id" id="user_id">

                            <input name="allowed_return_product_count" type="hidden"
                                   class="form-control return_product_count" id="user_id">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary"
                                    data-dismiss="modal"> بستن
                            </button>
                            <button type="submit" id="returnPro" class="btn btn-primary"> ارسال
                                درخواست
                            </button>
                        </div>
                    </div>
            </div>
        </div>

    </main>
    <script>
        var fewSeconds = 60;
        $('#returnPro').click(function () {
            // Ajax request
            var btn = $(this);
            btn.prop('disabled', true);
            setTimeout(function(){
                btn.prop('disabled', false);
            }, fewSeconds*1000);
        });
        $('.return-pr').click(function () {
            var p_id = $( this ).attr('id');
            var p_title = $('.title-product-select'+p_id).val();
            var p_order_num = $('.order_number_product_select'+p_id).val();
            var p_id_select = $('.product_id_select'+p_id).val();
            var p_price_id = $('.product_price_id'+p_id).val();
            var p_count = $('.product_count'+p_id).val();
            $('.show_by_count').text(p_count) ;
            $('.return_title-product').val(p_title) ;
            $('.order_number').val(p_order_num) ;
            $('.return_product_id').val(p_id_select) ;
            $('.return_price_id').val(p_price_id) ;
            $('.return_product_count').val(p_count) ;
            $('.product_name_dis').val(p_title) ;
            $('.product_name_table').text(p_title) ;
            $('.returnNumber').prop('max',p_count) ;
            $('.returnNumber').val(1) ;
            var option = {
                order_id: p_order_num,
                return_product_id: p_id_select,
                return_price_id: p_price_id,
                user_id: <?= $_SESSION['user_id']?>,
            };
            widgetHelper.tt('ui', 'member.getBeforeReturnProduct', option, 'showResultCountReturn');
        });
        function showResultCountReturn(params) {
            if(params.count){
              $('.oldReturn_show').text(params.count);
              $('.allow-ret-number').text(0);

            }else{
                $('.oldReturn_show').text('0');
            }
        }
        $(function () {
            $( ".returnNumber" ).change(function() {
                var min = 1;
                if ($(this).val() < min)
                {
                    alert('حداقل تعداد مرجوعی برای هر کالا یک عدد میباشد .');
                    $('.returnNumber').val(1) ;
                }
            });
        });

        $(document).ready(function () {
            $(".pic-Sample-slider").hover(function () {
                $(".carousel-custome").css("opacity", "1");
            }, function () {
                $(".carousel-custome").css("opacity", "0");
            });
        });
    </script>
    <?php
} else
{
    header( "Location: " . \f\ifm::app()->siteUrl . 'login' );
}
?>
<style>
    .table > thead > tr > th {
        color: #fff;
        font-size: 13px;
    }

    .table {
        width: 100%;
        max-width: 100%;
        margin-bottom: 0px;
    }

    .tab-order-details > ul {
        border-top: #666666 solid 2px;
        padding-bottom: 0px;
    }
    .modal-header h5 {
        color: #fff;
        font-size: 14px;
        display: block;
        width: 90%;
        float: right;
        margin-bottom: 15px;
    }
    body.index-opt-2 {
        padding-right: 0px !important;
    }
    .modal-header {
        padding: 9px 15px 0px 15px;
        background: #9C27B0;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
    }
    .tab-order-details > ul.nav-tabs > li.nav-tab-order.active > a {
        border-radius: 0px;
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
        background: #673ab7;
        border: #673ab7;
    }
    thead.popup-head {
        background: #00bcd4;
        border: #00bcd4 solid 2px;
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
    thead.popup-head th {
        padding: 8px 5px !important;
    }
    .tab-order-details {
        margin-bottom: 50px;
    }

    a.show-factor-detail {
        font-size: 14px;
        color: #fff;
        background: #f44336bf;
        padding: 2px 13px 8px 20px;
        border-radius: 50px;
    }

    a.show-factor-detail:hover {
        cursor: pointer;
    }

    a.factor-copy i {
        background: #03A9F4;
        padding: 7px;
        border-radius: 7px;
    }

    a.factor-copy {
        font-size: 15px;
        margin-right: 5px;
        color: #fff;
        padding-top: 0px;
        padding-bottom: 0px;
    }

    a.show-factor-detail i {
        padding: 5px;
        border-radius: 7px;
    }

    .tab-order-details > ul.nav-tabs > li.active.nav-tab-order > a, .nav-tabs > li.active.nav-tab-order > a:hover, .nav-tabs > li.active.nav-tab-order > a:focus {
        border-top: none !important;
        background: #ffffff;
        color: #33466e !important;
    }

    .in-nav-tab-order > div.table-responsive > table > thead > tr {
        background: #009688;
        color: #fff;
    }

    span.title-prod-factor {
        color: #FF5722;
        font-size: 13px;
        line-height: 25px;
        font-weight: 700;
    }

    .inline-asp-box {
        display: inline-block;
    }

    .inline-asp-box.img {
        width: 11%;
        display: inline-block;
        vertical-align: -26px;
    }
</style>
