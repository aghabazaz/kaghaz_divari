<?php
$title = 'stockOrdersDetail' ;
/* @var $this membersView */

$this->registerWidgets ( array (
    'formW'      => 'form',
    'boxW'       => 'box',
    'pageTitleW' => 'pageTitle'
) ) ;

echo \f\html::markupBegin ( 'div' ) ;
echo \f\html::markupBegin ( 'div',
                            array (
    'htmlOptions' => array (
        'class' => 'col-md-6' ) ) ) ;

echo $this->pageTitleW->renderTitle ( array (
    'title' => \f\ifm::t ( $title ),
    'links' => array (
        array (
            'title' => \f\ifm::t ( 'liststockOrders' ),
            'href'  => \f\ifm::app ()->baseUrl . 'accountingStock/stockControl/stockOrders/index' ) ) ) ) ;

echo \f\html::markupEnd ( 'div' ) ;

echo \f\html::markupBegin ( 'div',
                            array (
    'htmlOptions' => array (
        'class' => 'col-md-6' ),
    'style'       => array (
        'text-align' => 'left'
) ) ) ;
//$form.=\f\html::markupBegin ( 'a',
//                              array (
//            'htmlOptions' => array (
//                'href' => \f\ifm::app ()->baseUrl . "stockOrdersStock/stockOrders/stockOrdersEdit/" . $orderItem[ 'id' ],
//    ) ) ) ;
//$form.=\f\html::markupBegin ( 'button',
//                              array (
//            'htmlOptions' => array (
//                'type'  => 'button',
//                'class' => 'btn btn-primary' ) ) ) ;
//$form.='<i class="fa fa-edit"></i> ' . (\f\ifm::t ( 'editBtn' ) ) ;
//$form.=\f\html::markupEnd ( 'button' ) ;
//$form.=\f\html::markupEnd ( 'a' ) ;

$form .= \f\html::readyMarkup ( 'button',
                                '<i class="fa fa-envelope-o "></i> ' . (\f\ifm::t ( 'sendEmail' ) ),
                                                                                    array (
            'htmlOptions' => array (
                'type'  => 'button',
                'class' => 'btn btn-danger',
                'id'    => 'emailBtn' . $orderItem[ 'id' ]
            ),
            'action'      => array (
                'display' => 'dialog',
                'params'  => array (
                    'targetRoute'    => "projectManager.sendEmail",
                    'triggerElement' => 'emailBtn' . $orderItem[ 'id' ], //chanage
                    'dialogTitle'    => \f\ifm::t ( "sendEmail" ),
                    'ajaxParams'     => array (
                        'section_id' => $orderItem[ 'id' ],
                        'email'      => $orderItem[ 'email' ],
                        'section'    => 'projectManager.activity'
                    )
                ) ) ), TRUE ) ;
$form .= \f\html::readyMarkup ( 'button',
                                '<i class="fa fa-mobile-phone "></i> ' . (\f\ifm::t ( 'sendSms' ) ),
                                                                                      array (
            'htmlOptions' => array (
                'type'  => 'button',
                'class' => 'btn btn-warning',
                'id'    => 'smsBtn'
            ),
            'action'      => array (
                'display' => 'dialog',
                'params'  => array (
                    'targetRoute'    => "projectManager.sendSms",
                    'triggerElement' => 'smsBtn', //chanage
                    'dialogTitle'    => \f\ifm::t ( "sendSms" ),
                    'ajaxParams'     => array (
                        'section_id' => $orderItem[ 'id' ],
                        'mobile'     => $orderItem[ 'mobile' ],
                        'section'    => 'projectManager.activity'
                    )
                ) ) ), TRUE ) ;



echo $form ;
echo \f\html::markupEnd ( 'div' ) ;
echo \f\html::markupBegin ( 'div',
                            array (
    'htmlOptions' => array (
        'class' => 'clear' ) ) ) ;
echo \f\html::markupEnd ( 'div' ) ;
echo \f\html::markupEnd ( 'div' ) ;
echo '<br></br>' ;


echo $this->boxW->begin ( array (
    'type'  => 'form',
    'title' => \f\ifm::t ( 'orderInfo' ) ) ) ;

echo \f\html::markupBegin ( 'div' ) ;
echo \f\html::markupBegin ( 'div',
                            array (
    'htmlOptions' => array (
        'class' => 'col-md-6' ) ) ) ;
$this->registerGadgets ( array (
    'dateG' => 'date' ) ) ;
?>
<p>
    <span>
        تاریخ سفارش
    </span>
    <span>
        <?=
        $this->dateG->dateTime ( $order[ 'date_pay' ], 2 ) ;
        ?>
    </span>
</p>
<p>
    <span>
        شماره سفارش 
    </span>
    <span>
        <?= $order[ 'id' ] + 100000 ; ?>
    </span>
</p>
<p>
    <span>
        مبلغ کل سفارش
    </span>
    <span>
        <?= number_format ( ($order[ 'price' ] - $order[ 'discount' ] - $discountCodePrice) + $order[ 'transportation_cost' ] ) . ' تومان ' ; ?>
    </span>
</p>
<p>
    <span>
        مبلغ پرداختی 
    </span>
    <span>
        <?= $order[ 'price_pay' ] ? number_format ( $order[ 'price_pay' ] ) . ' تومان ' : '---' ; ?>
    </span>
</p>
<?php
echo \f\html::markupEnd ( 'div' ) ;
echo \f\html::markupBegin ( 'div',
                            array (
    'htmlOptions' => array (
        'class' => 'col-md-6 rtl' ) ) ) ;

?>
<p>
    <span>
        نام و نام خانوادگی 
    </span>
    <span>
        <?= $member[ 'name' ] ; ?>
    </span>
</p>
<p>
    <span>
        تلفن همراه
    </span>
    <span>
        <?= $member[ 'mobile' ] ; ?>
    </span>
</p>
<p>
    <span>
        تلفن ثابت
    </span>
    <span>
        <?= $member[ 'phone' ] ; ?>
    </span>
</p>
<p>
    <span>
        آدرس
    </span>
    <span>
        <?= $member[ 'city' ].' - '.$member[ 'address' ] ; ?>
    </span>
</p>

<?php
echo \f\html::markupEnd ( 'div' ) ;
echo \f\html::markupBegin ( 'div',
                            array (
    'htmlOptions' => array (
        'class' => 'clear' ) ) ) ;
echo \f\html::markupEnd ( 'div' ) ;
echo \f\html::markupEnd ( 'div' ) ;

echo $this->boxW->flush () ;


echo $this->boxW->begin ( array (
    'type'  => 'form',
    'title' => \f\ifm::t ( 'ordersList' ) ) ) ;
?>
<div class="" >
    <div class="col-md-12 container-cart">
        <div class="col-md-6  padding-0-col">
            <div class="thead border">
                <p>شرح محصول</p>
            </div>
            <?php
            foreach ( $orderItem AS $data )
            {
                ?>
                <div class="tbody border">
                    <div class="pd">
                        <div class="pic">
                            <a href="<?= \f\ifm::app ()->siteUrl ?>productDetail/<?= $data[ 'product_id' ] ?>" target="_blank"><img src="<?= \f\ifm::app ()->fileBaseUrl . $data[ 'picture' ] ?>" alt="<?= $data[ 'productTitle' ] ?>" title="<?= $data[ 'productTitle' ] ?>" width="110" class="img-responsive"></a>
                        </div>
                        <div class="description">
                            <h2><a href="<?= \f\ifm::app ()->siteUrl ?>productDetail/<?= $data[ 'product_id' ] ?>" target="_blank"><?= $data[ 'productTitle' ] ?></a></h2>
                            <h4><a href="<?= \f\ifm::app ()->siteUrl ?>productDetail/<?= $data[ 'product_id' ] ?>" target="_blank"><?= $data[ 'productTitleSub' ] ?> </a></h4>
                            <p class="color">
                                رنگ: <span><i id="iProductColor" style="background-color:<?= $data[ 'colorCode' ] ?>"></i><?= $data[ 'colorTitle' ] ?></span>
                            </p>
                            <p class="warranty">
                                <?= $data[ 'guranteeTitle' ] ?>
                            </p>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>

        <div class="col-md-1  padding-0-col">
            <div class="thead border">
                <p>تعداد</p>
            </div>
            <?php
            foreach ( $orderItem AS $data )
            {
                ?>
                <div class="tbody border">
                    <div class="pd">
                        <div class="unitnumber-container-cart" style="position:relative;top: 40%;">
                            <div class="styled-select">
                                <?= $data[ 'count' ] ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>

        </div>

        <div class="col-md-2  padding-0-col">
            <div class="thead border">
                <p>قیمت واحد</p>
            </div>
            <?php
            foreach ( $orderItem AS $data )
            {
                ?>
                <div class="tbody border">
                    <div class="pd" >
                        <span class="unitprice" style="position:relative;top: 40%;" id="unitprice_<?= $data[ 'orderItem_id' ] ?>"><?= number_format ( $data[ 'price' ] ) ?></span><span class="toman" style="position:relative;top: 40%;">تومان</span>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>

        <div class="col-md-3  padding-0-col">
            <div class="thead border">
                <p>قیمت کل</p>
            </div>
            <?php
            foreach ( $orderItem AS $data )
            {
                $price    = $data[ 'price' ] * $data[ 'count' ] ;
                $discount = $data[ 'discount_price' ] * $data[ 'count' ] ;
                ?>
                <div class="tbody border">
                    <div class="pd" >
                        <p style="position:relative;top: 30%;">
                            <span class="right">قیمت کل :</span> 
                            <span class="unitprice" id="span_price_all_<?= $data[ 'orderItem_id' ] ?>" ><?= number_format ( $price ) ?></span>
                            <span class="toman" style="position:relative;top: 40%;">تومان</span>
                        </p>

                        <p  style="position:relative;top: 30%" class="dicountP"> 
                            <span class="right"><?= $data[ 'discount_type' ] == 'amazing' ? '- تخفیف شگفت انگیز: ' : '- تخفیف : ' ?></span> 
                            <span class="unitprice" id="span_price_discount_<?= $data[ 'orderItem_id' ] ?>"><?= number_format ( $discount ) ?></span>
                            <span class="toman" style="position:relative;top: 40%;">تومان</span>
                        </p>
                        <div style="position:relative;top: 30%" class="sepDivDashCart"></div>
                        <p style="position:relative;top: 30%" > 
                            <span class="unitprice green span_price_cart" id="span_price_cart_<?= $data[ 'orderItem_id' ] ?>"><?= number_format ( $price - $discount ) ?></span><span class="toman green" style="position:relative;top: 40%;">تومان</span>
                        </p>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>


    </div>
</div>
<?php
$form               = '' ;
$form               .= $this->formW->begin ( array (
    'htmlOptions' => array (
        'method' => 'post',
        'action' => \f\ifm::app ()->baseUrl . 'accountingStock/stockControl/stockOrders/stockOrdersSave',
        'id'     => 'orderOK'
    ),
        ) ) ;
$form               .= $this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'hidden',
        'name'  => 'id',
        'value' => $order[ 'id' ],
    ),
        ) ) ;
$form               .= $this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'hidden',
        'name'  => 'status_update',
        'value' => time (),
    ),
        ) ) ;
$stockOrders_status = array (
    'inventoryOk' => 'تایید موجودی انبار',
    'inventoryNo' => 'عدم موجودی کافی',
        ) ;
$form               .= $this->formW->rowStart () ;
$form               .= $this->formW->select ( array (
    'htmlOptions' => array (
        'id'   => 'status',
        'name' => 'status',
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'stockOrders_status' ),
    ),
    'validation'  => array (
        'required' => ''
    ),
    'choices'     => $stockOrders_status,
    'selected'    => '',
        ) ) ;

$form .= $this->formW->rowEnd () ;


$form .= '<br></br>' ;
$form .= $this->formW->rowStart () ;
$form .= $this->formW->buttonTag ( array (
    'htmlOptions' => array (
        'type' => 'submit',
    ),
    'content'     => '<i class="fa fa-floppy-o"></i> ' . \f\ifm::t ( 'saveNew' ),
        ) ) ;
$form .= $this->formW->rowEnd () ;
$form .= $this->formW->flush () ;

echo $form ;

echo $this->boxW->flush () ;
?>


<style>
    p span:first-child
    {
        width:120px;
        color:gray;
        display: inline-block;
    }
    @media only screen and (max-width: 980px) {
        .foot .btn-foot .seven {
            margin-top:20px;
            margin-left:-2%!important;
            width: 300px!important;
        }
        .btn-foot , .col-md-12.head{
            text-align: center!important;
        }
        .right{
            float:none!important;;
        }
        .left{
            float:none!important;;
        }
    }
    @media only screen and (max-width: 550px) {
        .finalprice{
            width:100%!important;
        }
        .pd{
            height:auto!important;
        }

    }
    .sepDivDashCart{
        margin: 14px 0;
        border-bottom: 1px dashed #e9e9e9;
        height: 1px;
    }
    .dicountP > span {
        color: red;
    }
    #iProductColor{
        width: 15px;
        height: 15px;
        border: 1px solid rgba(0, 0, 0, .1);
        border-radius: 16px;
        display: inline-block;
        margin: 0 3px 0 10px;
        vertical-align: middle;
    }
    .padding-0-col{
        padding: 0px;
    }

    .container-cart .border{
        border: #f0f1f2 solid 1px;
        border-radius: 2px;
        text-align: center;
        padding:5px;
        height:auto;
    }
    .toman {
        color: #666;
        font-size: 10px ;
        letter-spacing: 0;
        margin-right: 10px;
        vertical-align: 2px;
    }
    .last a i {
        width: 12px;
        height: 12px;
        display: inline-block;
    }
    .green {
        color: #4caf50 !important;
    }
    .container-cart{
        margin-bottom:25px;
    }

</style>
<script>
    widgetHelper.makeSelect2('select', '<?= \f\ifm::t ( 'select' ) ?>');
    widgetHelper.formSubmit('#orderOK');
    $(document).ready(function () {
        var divHeight = $('.tbody').height();
        $('.pd').css('height', divHeight + 'px');
    });

</script>