<?php
$title = 'commentDetail' ;
/* @var $this membersView */

$this->registerWidgets ( array (
    'formW'      => 'form',
    'boxW'       => 'box',
    'pageTitleW' => 'pageTitle'
) ) ;

$this->registerGadgets ( array (
    'dateG' => 'date' ) ) ;

echo \f\html::markupBegin ( 'div' ) ;
echo \f\html::markupBegin ( 'div',
                            array (
    'htmlOptions' => array (
        'class' => 'col-md-6' ) ) ) ;

echo $this->pageTitleW->renderTitle ( array (
    'title' => \f\ifm::t ( $title ),
    'links' => array (
        array (
            'title' => \f\ifm::t ( 'comment' ),
            'href'  => \f\ifm::app ()->baseUrl . 'shop/comment/index' ) ) ) ) ;

echo \f\html::markupEnd ( 'div' ) ;

echo \f\html::markupBegin ( 'div',
                            array (
    'htmlOptions' => array (
        'class' => 'col-md-6' ),
    'style'       => array (
        'text-align' => 'left'
) ) ) ;


echo \f\html::markupEnd ( 'div' ) ;

echo \f\html::markupBegin ( 'div',
                            array (
    'htmlOptions' => array (
        'class' => 'clear' ) ) ) ;
echo \f\html::markupEnd ( 'div' ) ;

echo \f\html::markupEnd ( 'div' ) ;

echo \f\html::markupBegin ( 'div', //div col 12 and BOX
                            array (
    'htmlOptions' => array (
        'class' => 'col-md-12' ) ) ) ;
echo $this->boxW->begin ( array (
    'type'  => 'form',
    'title' => \f\ifm::t ( 'infoDetail' ) ) ) ;
?>
<p>
    <span>
        تاریخ ثبت نظر:
    </span>
    <span>
        <?=
        $this->dateG->dateTime ( $productComment[ 'date_register' ], 2 ) ;
        ?>
    </span>
</p>
<p>
    <span>
        نام کاربر :
    </span>
    <span>
        <?= $productComment[ 'name' ] ; ?>
    </span>
</p>
<p>
    <span>
        محصول :
    </span>
    <span>
        <?= $ratingOptions[ 'title' ] ; ?>
    </span>
    <a target="_blanck" href="<?= \f\ifm::app ()->siteUrl . 'productDetail/' . $ratingOptions[ 'id' ] ?>"><?php echo $ratingOptions[ 'sub_title' ] ; ?></a>
</p>
<?php
echo $this->boxW->flush () ;
echo \f\html::markupEnd ( 'div' ) ;


//div row
echo \f\html::markupBegin ( 'div' ) ;

echo \f\html::markupBegin ( 'div', //div col 5 and BOX
                            array (
    'htmlOptions' => array (
        'class' => 'col-md-5' ) ) ) ;
echo $this->boxW->begin ( array (
    'type'  => 'form',
    'title' => \f\ifm::t ( 'rateDetail' ) ) ) ;
?>
<div class="range-bar-user">
    <?php
    if ( $ratingTitle )
    {
        foreach ( $ratingTitle AS $data )
        {
            $value = $rateOld ? $rateOld[ $data[ 'id' ] ] : 0 ;
            ?>
            <div class="rangeBar-box">
                <div class="col-sm-4">
                    <div class="title-range-span">
                        <span class="title-range"><?= $data[ 'title' ] ?></span>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="rating-bar"><span data-value="<?= $value ?>" class="graph">
                            <div class="graph__container"><span class="graph__item"></span><span class="graph__item"></span><span class="graph__item"></span><span class="graph__item"></span><span class="graph__item"></span></div></span>
                    </div>
                </div>
                <div class="clearfix">
                </div>
            </div>
            <?php
        }
    }
    ?>
</div>

<?php
echo $this->boxW->flush () ;
echo \f\html::markupEnd ( 'div' ) ;
//end col 5
//col 7
echo \f\html::markupBegin ( 'div', //div col 7 and BOX
                            array (
    'htmlOptions' => array (
        'class' => 'col-md-7' ) ) ) ;
echo $this->boxW->begin ( array (
    'type'  => 'form',
    'title' => \f\ifm::t ( 'commentDetail' ) ) ) ;
?>
<h3 class="commentSubject">
    <?= $productComment[ 'title' ] ?>
</h3>
<div class="Scrutiny">
    <?php
    if ( $arrTipStrength || $arrTipWeak )
    {
        ?>
        <div class="col-md-6">
            <i class="fa fa-arrow-up Final-review-arrow" aria-hidden="true"></i><span style="color:#4caf50">نقاط  قوت</span>
            <ul>
                <?php
                foreach ( $arrTipStrength AS $data )
                {
                    echo "<li>$data</li>" ;
                }
                ?>
            </ul>
        </div>

        <div class="col-md-6">
            <i class="fa fa-arrow-down Final-review-arrow" aria-hidden="true" style="color:red"></i><span>نقاط ضعف</span>
            <ul>
                <?php
                if ( $arrTipWeak )
                {
                    foreach ( $arrTipWeak AS $data )
                    {
                        echo "<li>$data</li>" ;
                    }
                }
                ?>
            </ul>
        </div>
        <?php
    }
    ?>
    <div class="clearfix"></div>
</div> 
<p style="padding-top:2%">
    <?= $productComment[ 'description' ] ?>
</p>
</div>  
<div class="clearfix"></div> 

<?php
echo $this->boxW->flush () ;
echo \f\html::markupEnd ( 'div' ) ;
//end col 7
//end div 12
echo \f\html::markupEnd ( 'div' ) ;


echo \f\html::markupBegin ( 'div',
                            array (
    'htmlOptions' => array (
        'class' => 'clear' ) ) ) ;
echo \f\html::markupEnd ( 'div' ) ;


$form = '' ;
$form .= '<br></br>' ;
echo $form ;
?>


<style>
    .rangeBar-box {
        margin-bottom: 9px;
    }
    .comment-box {
        line-height: 12px;
    }
    span.title-range {
        font-size: 11px;
    }
    .graph {
        display: block;
        width: 100%;
    }
    .graph__container {
        display: inline-block;
        width: 90%;
    }
    [data-value="1"] .graph__item:nth-of-type(-n+1), [data-value="2"] .graph__item:nth-of-type(-n+2), [data-value="3"] .graph__item:nth-of-type(-n+3), [data-value="4"] .graph__item:nth-of-type(-n+4), [data-value="5"] .graph__item:nth-of-type(-n+5) {
        background: #69ca6d;
    }
    .graph__item {
        display: inline-block;
        width: 20%;
        height: 8px;
        background: lightblue;
        border-right: 1px solid whitesmoke;
    }
    .commentSubject {
        font-size: 15px;
        color: #686868;
        margin: 0px;
    }
    .Scrutiny {
        padding-top: 10px;
        font-size: 14px;
        line-height: 28px;
    }
    .Final-review-arrow {
        color: #4caf50;
        font-size: 11px;
        margin-left: 3px;
    }
    .Scrutiny > div > span {
        color: #ff5252;
    }
    .graph::after {
        content: attr(data-value);
        padding-right: 5px;
    }
</style>
