<?php
$title = 'dashboard' ;
$icon  = 'fa-tachometer' ;

/* @var $pageWidget \f\w\pageTitle */
$pageWidget = \f\widgetFactory::make ( 'pageTitle' ) ;
echo $pageWidget->renderTitle ( array (
    'title' => '<i class="fa ' . $icon . '"></i> ' . \f\ifm::t ( $title ),
    'links' => array (
) ) ) ;
?>
<div class="col-sm-12">
    <div class="row">
        <div class="items">
            <div class="item-1" >
                <a href="<?= \f\ifm::app ()->siteUrl . 'account/product/productAdd/' ?>" target="_parent">
                    <h1 style="font-size: 80px;margin-right:5%;">
                        <i class="fa fa-gears"></i>

                    </h1>
                    <p style=""><?= 'درخواست فروش' ?></p>
                </a>
            </div>
        </div>
        <div class="items">
            <div class="item-2" >
                <div class="red-label"style=""><?=$count ?></div>
                <a href="<?= \f\ifm::app ()->siteUrl . 'account/message/' ?>" target="_parent">
                    <h1 style="font-size: 80px;margin-right:5%;">
                        <i class="fa fa-envelope"></i>

                    </h1>
                    <p style=""><?= 'پیام ها' ?></p>
                </a>
            </div>
        </div>
        <div class="items">
            <div class="item-3" >
                <a href="<?= \f\ifm::app ()->siteUrl . 'account/advert/itemsAdd/' ?>" target="_parent">
                    <h1 style="font-size: 80px;margin-right:5%;">
                        <i class="fa fa-bullhorn"></i>

                    </h1>
                    <i class="fa fa-plus i-plus" ></i>
                    <p style=""><?= 'آگهی جدید' ?></p>
                </a>
            </div>
        </div>        
    </div>

</div>
<style>
    .items{
        width: 170px;
        height: 150px;
        max-height: 300px;
        border: 1px #00aba5 solid;
        border-radius: 5px;
        text-align: center;
        margin-right: 13%;
        float: right;
        
    }
    .item-2{
        position: relative;
    }
    .item-3{
        position: relative;
    }    
    .red-label{
        width:25px;
        height:25px;
        border:1px solid red;
        border-radius: 100%;
        background-color: #D95C5C !important;
        border-color: #D95C5C !important;
        color: #FFFFFF !important;
        position: absolute;
        top: 18px;
        right: 33px;
        z-index: 100;
    }
    .i-plus{

        position: absolute;
        top:20px;
        right: 30px;
        z-index: 100;
    }    
</style>


