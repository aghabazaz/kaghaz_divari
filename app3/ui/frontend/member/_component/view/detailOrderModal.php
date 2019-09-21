<table class="table">
    <thead class="popup-head">
    <tr>
        <th>عنوان محصول</th>
        <th> رنگ و گارانتی</th>
        <th> وضعیت موجودی</th>
        <th> قیمت محصول</th>
    </tr>
    </thead>
    <tbody>

    <?php foreach ( $row AS $data )
    {
        if ( $data['stock'] == '0' )
        {
            $noStockAlert = 'True';
        }

        ?>
        <tr class="View-status-product">
            <td style="padding: 0px 0px !important;
    text-align: center;
    width: 32%;
    line-height: 29px;
    font-size: 12px;"
                class="title-prod-factor">
                <img src="<?= \f\ifm::app()->fileBaseUrl . $data['picture'] ?>"
                     class="img-responsive col-md-4">
                <span class="col-md-8 product_name_table"><?= $data['title'] ?></span>
            </td>
            <td style="line-height: 24px;padding: 11px 0px !important;text-align: center;"
                class="title-prod-factor">
                <span class="oldReturn_show">
                    <span> رنگ : </span> <?= $data['colorTitle'] ?>
                    </br>
                    <span> گارانتی : </span><?= $data['guaranteeTitle'] ?>
                </span>
            </td>
            <td style="width: 15%;padding: 11px 0px !important;text-align: center;"
                class="title-prod-factor">
        <span class="show_by_count">
        <?php if ( $data['stock'] > 0 )
        {
            ?>
            <input type="hidden" name="productId[]" value="<?= $data['product_id']?>">
            <input type="hidden" name="priceId[]" value="<?= $data['product_price_id']?>">
            <div class="isStock">  <i class="fa fa-check"></i> موجود </div>
            <?php
        } elseif ( $data['stock'] == 0 )
        {
            ?>
            <div class="NoStock">  <i class="fa fa-times"></i> ناموجود </div>
            <?php
        }
        ?>
        </span>
            </td>
            <td style="padding: 11px 0px !important;text-align: center;" class="title-prod-factor">
                <?php if ( $data['stock'] > 0 )
                {
                ?>
                <span class="orginal-price">
                     <?= \f\ifm::faDigit( $data['newPrice'] ) ?>تومان
                </span>
                </br>
                <span class="new-product-price">
                    <?= \f\ifm::faDigit( $data['newPrice'] - $data['discountEnd'] ) ?> تومان
                </span>
                    <?php
                } elseif ( $data['stock'] == 0 )
                {
                ?>
                    <span class="new-product-price">
                    -
                </span>
                    <?php
                }
                ?>
            </td>
        </tr>
        <?php
    }
    ?>

    </tbody>
</table>
<?php

if ( $noStockAlert == 'True' )
{
    ?>
    <div style="margin-top: 15px;position: inherit;
    left: 0;
    top: 0;
    height: 100%;
    width: 100%;
    background-color: blanchedalmond;
    opacity: 1;
    visibility: initial;
    transition: opacity 0.3s 0s, visibility 0s 0.3s;" class="alert alert-danger" role="alert">
        <strong> هشدار!!! </strong> برخی محصولات در این فاکتور ناموجود میباشد . در صورت خرید مجدد این فاکتور محصولات
        ناموجود
        حذف خواهند شد .
    </div>
    <?php
}
?>
<style>
    .NoStock {
        margin: 0px 10px;
        padding: 6px;
        color: #fff;
        border-radius: 2px;
        background: #ff00006b;
    }
    span.oldReturn_show span {
        color: #9c27b0;
        font-weight: 700;
    }
    .isStock {
        background: #4caf509c;
        margin: 0px 10px;
        padding: 6px;
        color: #fff;
        border-radius: 2px;
    }

    span.orginal-price {
        color: red;
        font-size: 14px;
        text-decoration: line-through;
    }

    span.new-product-price {
        color: #4CAF50;
        font-size: 16px;
        /* text-decoration: line-through; */
    }
</style>