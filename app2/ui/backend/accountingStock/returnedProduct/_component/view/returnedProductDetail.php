<?php
$title = 'sendDeliverDetail' ;
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
            'title' => \f\ifm::t ( 'listReturnedProOrder' ),
            'href'  => \f\ifm::app ()->baseUrl . 'accountingStock/returnedProduct/index' ) ) ) ) ;

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
//                'href' => \f\ifm::app ()->baseUrl . "sendDeliverStock/sendDeliver/sendDeliverEdit/" . $orderItem[ 'id' ],
//    ) ) ) ;
//$form.=\f\html::markupBegin ( 'button',
//                              array (
//            'htmlOptions' => array (
//                'type'  => 'button',
//                'class' => 'btn btn-primary' ) ) ) ;
//$form.='<i class="fa fa-edit"></i> ' . (\f\ifm::t ( 'editBtn' ) ) ;
//$form.=\f\html::markupEnd ( 'button' ) ;
//$form.=\f\html::markupEnd ( 'a' ) ;


echo \f\html::markupEnd ( 'div' ) ;
echo \f\html::markupBegin ( 'div',
                            array (
    'htmlOptions' => array (
        'class' => 'clear' ) ) ) ;
echo \f\html::markupEnd ( 'div' ) ;
echo \f\html::markupEnd ( 'div' ) ;


echo $this->boxW->begin ( array (
    'type'  => 'form',
    'title' => \f\ifm::t ( 'orderInfo' ) ) ) ;

echo \f\html::markupBegin ( 'div' ) ;
echo \f\html::markupBegin ( 'div',
                            array (
    'htmlOptions' => array (
        'class' => 'col-md-5' ) ) ) ;
$this->registerGadgets ( array (
    'dateG' => 'date' ) ) ;
?>
<p>
    <span>
        تاریخ فاکتور
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
        مبلغ کل فاکتور
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
        <?= $order[ 'price_pay' ]?number_format ( $order[ 'price_pay' ] ) . ' تومان ':'پرداخت در محل' ; ?>
    </span>
</p>

<?php
echo \f\html::markupEnd ( 'div' ) ;
echo \f\html::markupBegin ( 'div',
                            array (
    'htmlOptions' => array (
        'class' => 'col-md-7 rtl' ) ) ) ;
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
        <?= $member[ 'state_title' ] . ' ، ' . $member[ 'city_title' ] . ' ، ' . $member[ 'address' ] ; ?>
    </span>
</p>
<p>
    <span>
        نحوه ارسال
    </span>
    <span>
        <?= $order[ 'trans_title' ] ; ?>
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
    'title' => \f\ifm::t ( 'returnedProList' ) ) ) ;
?>
<div class="" >
    <div class="col-md-12 container-cart">
        <div class="col-md-6  padding-0-col">
            <div class="thead border">
                <p>شرح محصول</p>
            </div>
            <?php
          //  \f\pre($orderItem);
            foreach ( $orderItem AS $item )
            {
                foreach ($item AS $data) {
                    ?>
                    <div class="tbody border">
                        <div class="pd">
                            <div class="pic">
                                <a href="<?= \f\ifm::app()->siteUrl ?>productDetail/<?= $data['product_id'] ?>"
                                   target="_blank"><img src="<?= \f\ifm::app()->fileBaseUrl . $data['picture'] ?>"
                                                        alt="<?= $data['productTitle'] ?>"
                                                        title="<?= $data['productTitle'] ?>" width="110"
                                                        class="img-responsive"></a>
                            </div>
                            <div class="description">
                                <h2>
                                    <a href="<?= \f\ifm::app()->siteUrl ?>productDetail/<?= $data['product_id'] ?>"
                                       target="_blank"><?= $data['productTitle'] ?></a></h2>
                                <h4>
                                    <a href="<?= \f\ifm::app()->siteUrl ?>productDetail/<?= $data['product_id'] ?>"
                                       target="_blank"><?= $data['productTitleSub'] ?> </a></h4>
                                <p class="color">
                                    رنگ: <span><i id="iProductColor"
                                                  style="background-color:<?= $data['colorCode'] ?>"></i><?= $data['colorTitle'] ?></span>
                                </p>
                                <p class="warranty">
                                    <?= $data[$key]['guranteeTitle'] ?>
                                </p>
                            </div>
                        </div>
                    </div>

                    <?php
                    break;
                }
            }
            ?>
        </div>

        <div class="col-md-2  padding-0-col">
            <div class="thead border">
                <p>تعداد مرجوع شده</p>
            </div>
            <?php
            foreach ( $orderItem AS $item )
            { ?>
                <div class="tbody border"> <div class="pd">
                <?php
                $countItem=count($item);
                $cusHeight=100/$countItem;
                foreach ($item AS $data) {
                    ?>


                            <div class="unitnumber-container-cart" style="position:relative;top: 0%;height:<?=$cusHeight?>%">
                                <div class="styled-select">
                                    <?= $data['return_count'] ?>
                                </div>
                            </div>


                    <?php
                }
                ?>
                </div> </div>
                    <?php
            }
            ?>

        </div>

        <div class="col-md-2  padding-0-col">
            <div class="thead border">
                <p>تاریخ مرجوع</p>
            </div>
            <?php
            foreach ( $orderItem AS $item )
            { ?>
                <div class="tbody border"> <div class="pd">
                        <?php
                        $countItem=count($item);
                        $cusHeight=100/$countItem;
                        foreach ($item AS $data) {
                            ?>
                            <div class="unitnumber-container-cart" style="position:relative;top: 0%;height:<?=$cusHeight?>%">
                                <div class="styled-select">
                                    <?=(!empty($data[ 'date' ])?$this->dateG->dateTime ( $data[ 'date' ], 2 ):''); ?>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div> </div>
                <?php
            }
            ?>

        </div>


        <div class="col-md-2  padding-0-col">
            <div class="thead border">
                <p>توضیحات</p>
            </div>
            <?php
            foreach ( $orderItem AS $item )
            { ?>
                <div class="tbody border"> <div class="pd">
                        <?php
                        $countItem=count($item);
                        $cusHeight=100/$countItem;
                        foreach ($item AS $data) {
                            ?>


                            <div class="unitnumber-container-cart" style="position:relative;top: 0%;height:<?=$cusHeight?>%">
                                <div class="styled-select">
                                    <?= $data['return_cause'] ?>
                                </div>
                            </div>


                            <?php
                        }
                        ?>
                    </div> </div>
                <?php
            }
            ?>

        </div>


    </div>
</div>
<?php
$form               = '' ;



$form .= '<div id="showPrice"></div>' ;

$form .= '<br></br>' ;
$form .= $this->formW->rowStart () ;

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

    .pic{
        float:right;
    }
    .tbody{
        height:250px !important;
    }
    .unitnumber-container-cart{
        border-top:1px dashed #ddd;
    }
      .unitnumber-container-cart:first-child{
          border-top:0px;
      }

</style>
<script>
    widgetHelper.makeSelect2('select', '<?= \f\ifm::t ( 'select' ) ?>');
    widgetHelper.formSubmit('#orderOK');

    checkStatusDeliver();

    $(document).ready(function () {
        var divHeight = $('.tbody').height();
        $('.pd').css('height', divHeight + 'px');
    });
    function checkStatusDeliver()
    {
        if ($('#status').val() == 'delivery') {
            $('#showPrice').css('display', 'block');
            var order = <?= ($order[ 'price' ] - $order[ 'discount' ] - $discountCodePrice) + $order[ 'transportation_cost' ]?>;
            widgetHelper.tt('ui', 'accountingStock.sendDeliver.setInputPrice', {order:order}, 'refreshInputPrice');
        } else {
            $('#showPrice').css('display', 'none');
            //$('#price_pay').removeAttr('data-parsley-required');
        }
    }
    function refreshInputPrice(params)
    {
        $('#showPrice').html(params.content);
        //$('#price_pay').attr('data-parsley-required', '');
    }

</script>