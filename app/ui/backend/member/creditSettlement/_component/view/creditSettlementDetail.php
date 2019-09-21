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
            'href'  => \f\ifm::app ()->baseUrl . 'member/creditSettlement/index' ) ) ) ) ;

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

echo $this->boxW->begin(array(
    'type' => 'form',
    'title' => \f\ifm::t('creditFactor')));
echo \f\html::markupBegin('div');
echo \f\html::markupBegin ( 'div',
    array (
        'htmlOptions' => array (
            'class' => 'col-md-6',

            ) ) ) ;
?>
<p>
    <span style="width:140px">
مبلغ کل استفاده از اعتبار
    </span>
    <span>
    <?=abs($order[0][0]['wallet_credit']).'تومان';?>
    </span>
</p>
    <p>
    <span>
مهلت زمان تسویه
    </span>
        <span>
    <?=$dateSettlement?>
        </span>

</p>

<?php
echo \f\html::markupEnd ( 'div' ,
    array (
        'htmlOptions' => array (
            'class' => 'widget widget-table' ) )) ;

echo \f\html::markupBegin ( 'div',
    array (
        'htmlOptions' => array (
            'class' => 'col-md-6' ) ) ) ;


$form = '' ;
$form.=$this->formW->begin ( array (
    'htmlOptions' => array (
        'method' => 'post',
        'action' => \f\ifm::app ()->baseUrl . 'member/creditSettlement/creditSettlementFun',
        'id'     => 'creditSettlement'
    ),
) ) ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'hidden',
        'name'  => 'id',
        'value' => $order[0][0][ 'user_id' ],
    ),
) ) ;
$form.=$this->formW->buttonTag ( array (
    'htmlOptions' => array (
        'type'    => 'submit',

        ),
    'style'=>array(
        'display'=>'block',
        'margin-right'=>'auto',
        'margin-left'=>'auto'
    ),
    'content' => '<i class="fa fa-credit-card"></i> ' . \f\ifm::t ( 'clearing' ) ,
) ) ;
$form.=$this->formW->flush () ;

echo $form ;


echo \f\html::markupEnd ( 'div' ) ;
echo \f\html::markupBegin('div',
    array(
        'htmlOptions' => array(
            'class' => 'clear')));
echo \f\html::markupEnd('div');
echo \f\html::markupEnd('div');
echo $this->boxW->flush();
//\f\pre($order);
foreach($order[0] AS $data){
    echo $this->boxW->begin(array(
        'type' => 'form',
        'title' => \f\ifm::t('orderInfo')));

    echo \f\html::markupBegin('div');
    echo \f\html::markupBegin('div',
        array(
            'htmlOptions' => array(
                'class' => 'col-md-5')));
    $this->registerGadgets(array(
        'dateG' => 'date'));
    ?>
    <p>
    <span>
        تاریخ فاکتور
    </span>
        <span>
        <?=
        $this->dateG->dateTime($data['date_pay'], 2);
        ?>
    </span>
    </p>
    <p>
    <span>
        شماره سفارش 
    </span>
        <span>
        <?= $data['orderID'] + 100000; ?>
    </span>
    </p>
    <p>
    <span>
        مبلغ کل فاکتور
    </span>
        <span>
        <?php echo(($data['endPrice']+$data['transportation_cost'])-($data['endDiscountPrice']+$data['discountCode'])).'تومان' ?>
    </span>
    </p>


    <?php
    echo \f\html::markupEnd('div');
    echo \f\html::markupBegin('div',
        array(
            'htmlOptions' => array(
                'class' => 'col-md-7 rtl')));
    ?>
    <p>
    <span>
        نام و نام خانوادگی 
    </span>
        <span>
        <?= $data['name']; ?>
    </span>
    </p>
    <p>
    <span>
        تلفن همراه
    </span>
        <span>
        <?= $data['mobile']; ?>
    </span>
    </p>
    <p>
    <span>
        تلفن ثابت
    </span>
        <span>
        <?= $data['phone']; ?>
    </span>
    </p>
    <p>
    <span>
        آدرس 
    </span>
        <span>
        <?= $data['stateTitle'] . ' ، ' . $data['cityName'] . ' ، ' . $data['address']; ?>
    </span>
    </p>
    <p>
    <span>
        نحوه ارسال
    </span>
        <span>
        <?= $data['titleTrans']; ?>
    </span>
    </p>

    <?php
    echo \f\html::markupEnd('div');
    echo \f\html::markupBegin('div',
        array(
            'htmlOptions' => array(
                'class' => 'clear')));
    echo \f\html::markupEnd('div');
    echo \f\html::markupEnd('div');

    echo $this->boxW->flush();
}
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
    widgetHelper.formSubmit('#creditSettlement');

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