<link rel="stylesheet" href="<?= \f\ifm::app ()->siteUrl ?>app/ui/templates/frontend/main/css/jquery-ui.css" type="text/css" media="screen">

<?php
//\f\pre($brand);

if ( ! $brand[ 'id' ] )
{
    $brand[ 'id' ] = 0 ;
}
?>
<!-- page content -->
<main class="page-content">
    <div class="container">


        <div class="row " style=" ">
            <div class="url-page-box" style="margin-bottom:10px">
                <div class="page-address-box padding-addressBar">
                    <i style="padding-left:3px;" class="fa fa-home"></i><span class="address-name"><a href="<?= \f\ifm::app ()->siteUrl ?>">خانه</a></span>
                    <span class="arrow-address5 fa fa-angle-left"></span>
                    <span class="address-name"> هدایای تبلیغاتی</span>
                    <div class="clearfix"></div> 
                </div>
            </div>
        </div>
        <div class="row" style="background-color: #fff ;">

            <div class="col-md-3">
                <div style="margin-top:15px;">
                    <?php
                    echo \f\ttt::block ( 'cms.advertisement.getAdvertise',
                                         array (
                        'limit' => '7',
                        'plan'  => 'C'
                    ) ) ;
                    ?>
                </div>
            </div>

            <div class="col-md-9" style="padding-top:20px">
                <div class="content_header clearfix">
                    <h1 class="content_title"> هدایای تبلیغاتی </h1>			
                </div>
                <ul class="products">
                    <?php
                    foreach ( $row AS $data )
                    {
                        ?>
                        <li id="" class="product_thumb last price_on col-lg-3 col-md-3 col-sm-6 col-xs-6 col-ms-6">
                            <div class="thumb_body item_body" title="#">
                                <a href="<?= \f\ifm::app ()->siteUrl . 'productDetail/' . $data[ 'id' ] ?>" class="thumb_image_link">
                                    <img style="max-width:150px;" class="product_thumb_image" src="<?= \f\ifm::app ()->fileBaseUrl . $data[ 'picture' ] ?>"></a>
                                <a title="<?= \f\ifm::app ()->siteUrl . 'productDetail/' . $data[ 'title' ] ?>" href="<?= \f\ifm::app ()->siteUrl . 'productDetail/' . $data[ 'id' ] ?>">
                                    <h2><?php echo $data[ 'title' ] ; ?></h2>
                                </a>
                                <div class="product_thumb_badges">
                                    <div class="thumb_badge badge_off"> </div>
                                </div>
                                <div class="product_off"><b><?php echo $data[ 'discount' ] ?>%</b></div>		
                            </div>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </div>

            <div class="clearfix"></div>
            <div class="pagination" style="text-align: center">

                <?php
                $lastpage  = ceil ( ($num / $num_page ) ) ;
                $i         = 1 ;
                $lpm1      = $lastpage - 1 ;
                $adjacents = 3 ;
                $pr        = $page - 1 ;
                $nx        = $page + 1 ;
                if ( $sRow[ 'id' ] )
                {
                    $href = \f\ifm::app ()->siteUrl . 'product/gifts'. $sRow[ 'id' ] ;
                }
                else
                {
                    $href = \f\ifm::app ()->siteUrl . 'product/gifts';
                }

                include 'pagination_1.php' ;
                ?>

            </div>
            <br>
        </div>
    </div>
</main>
<style>
    .content_header.clearfix {
        text-align: right;
        padding: 20px;
        padding-right: 0px;
        font-size: 16px;
        color: #0089ff;
    }
    .products li {
        padding: 0;
        position: relative;
        float: right;
        display: block;
    }
    .products li .thumb_body, .products li .item_body {
        color: #787878;
        margin: 5px;
        border: 1px solid #e3e3e3;
        padding: 10px;
        background-color: #ffffff;
        overflow: hidden;
        text-align: center;
        min-height: 260px;
    }
    .products li .thumb_body a.thumb_image_link, .products li .item_body a.thumb_image_link {
        display: block;
    }
    .products li .thumb_body a.thumb_image_link img, .products li .item_body a.thumb_image_link img {
        width: 100%;
        height: auto;
        opacity: 1;
    }
    .products li .thumb_body h3, .products li .thumb_body h2, .products li .item_body h3, .products li .item_body h2 {
        height: 70px;
        overflow: hidden;
        margin-top: 10px;
        text-align: center;
        color: #595959;

    }
    .products .product_thumb_badges {
        top: 0px;
        left: 10px;
    }
    .product_thumb_badges {
        top: -5px;
        left: 5px;
        position: absolute;
        z-index: 9;
    }
    .product_thumb_badges .thumb_badge {
        float: left;
        margin-left: 0;
        margin-right: 8px;
        padding: 5px 0 0;
        color: #fff;
        border-radius: 0;
        width: 40px;
        -webkit-transform: rotate(-3deg);
        -moz-transform: rotate(-3deg);
        -ms-transform: rotate(-3deg);
        -o-transform: rotate(-3deg);
        transform: rotate(-3deg);
        border-radius: 0 0 0 5px/30px;
        position: relative;
        padding-bottom: 3px;
    }
    .product_off {
        position: absolute;
        top: 0px;
        right: 0;
        color: #fff;
        background: red;
        border-radius: 100%;
        width: 30px;
        height: 30px;
        line-height: 32px;
        transform: rotate(20deg);
        font-size: 13px;
        -webkit-transition: All .2s ease-in-out;
        -moz-transition: All .2s ease-in-out;
        -o-transition: All .2s ease-in-out;
    }
    .product_thumb_badges .thumb_badge.badge_off {
        background-color: #0089ff;
    }
    .product_thumb_badges .thumb_badge.badge_off:before {
        border-left: 5px solid #1d8fa8;
    }
    .product_thumb_badges .thumb_badge:before {
        content: "";
        display: block;
        position: absolute;
        top: 0px;
        right: -10px;
        border-top: 6px solid transparent;
        border-right: 5px solid transparent;
        border-bottom: 0px solid transparent;
    }
    .product_thumb_badges .thumb_badge.badge_off::after {
        content: "حراج";
    }
    .thumb_subtitle {
        overflow: hidden;
        color: #7b7b7b;
        font-size: 12px;
        line-height: 16px;
        text-align: right;
        height: 48px;
        margin-bottom: 10px;
    }
    .products li .product_thumb_price {
        height: 28px;
        color: #707070;
    }
    .products li .price {
        text-align: center;
        color: #19a122;
        display: block;
    }
    .in-tab-custome
    {
        padding-top: 10px;
    }
    #filter-box
    {
        background:#fff;
        position: fixed;
        top:0;
        width:100%;
        height:100%;
        z-index: 1000;
        left:-999px;
        transition-property: all;
        transition-duration: .5s;
        transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
    }
    #sort-box
    {
        background:#fff;
        position: fixed;
        top:0;
        width:100%;
        height:100%;
        z-index: 1000;
        right:-999px;
        transition-property: all;
        transition-duration: .5s;
        transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
    }
    #amount {
        direction: rtl;
        margin-bottom: 35px;
    }
    #amount .maxPrice {
        font-size: 11px;
        float: right;
        text-align: right;
    }
    #amount .minPrice {
        font-size: 11px;
        float: left;
        text-align: left;
    }
    .select-brand{
        margin-top:45px;
    }
    .checkBrand ,.checkColor{
        display: inline;
        min-height: 0px !important;
    }   
    ul.brand-ul {
        direction: rtl;
        text-align: right;
        padding: 7px 12px;
    }
    .brand-ul > li > input {
        margin-left: 5px;
    }
    .brand-ul >div> li > input {
        margin-left: 5px;
    }
    .brand-show {
        direction: rtl;
        text-align: right;
        padding: 0px 12px 15px;
    }
    .hide-brand{
        display :none;
    }
    .show-list-order-color{
        display: none;
    }
    .more-brand-BTN{
        cursor: pointer;
    }
    .more-color-BTN{
        cursor: pointer;
    }
    .ProductColorStyle-black{
        height: 13px;
        width: 5px;
        outline: 1px solid #ddd;
        position: absolute;
        top: 0px;
        right: 0px;
    }
    .ProductColorStyle-red{
        height: 13px;
        width: 5px;
        background-color: red;
        outline: 1px solid #ddd;
        position: absolute;
        top: 0px;
        right: 0px;
    }
    .ProductColorStyle-orange{
        height: 13px;
        width: 5px;
        background-color: orange;
        outline: 1px solid #ddd;
        position: absolute;
        top: 0px;
        right: 0px;
    }


    /**mw*/
    .page-address-box {
        margin-top: 15px;
        text-align: right;
        direction: rtl;
        border-bottom: #cccccc solid 1px;
        padding-bottom: 9px;
        margin-bottom: 11px;
    }
    .page-address-box>span {
        padding-left: 15px;
    }
    .col-product
    {
        padding:0px 5px ;
    }
    .col-product:first-child
    {
        padding-right: 0px !important;
    }
    .col-product:last-child
    {
        padding-left: 0px !important;
    }

    .item
    {
        -moz-border-bottom-colors: none;
        -moz-border-left-colors: none;
        -moz-border-right-colors: none;
        -moz-border-top-colors: none;
        border-color: #e9e9e9;
        border-image: none;
        border-style: solid;
        border-width: 2px 1px 1px;
        margin: 0px 0px 10px 0;
        position: relative;
        padding: 5px;
    }
    .item:hover
    {
        border-color: #ccc;
        box-shadow: 0 1px 4px 1px rgba(0, 0, 0, 0.2);
    }
    .pimg
    {
        margin-top: 0px;
        height: 160px;
        overflow: hidden;
        text-align: center;

    }
    .cat-title
    {
        margin-top: 5px;

    }
    .cat-title a
    {
        color:silver;
    }
    .cat-title a:hover
    {
        color: #000;
    }
    @media (max-width: 768px) 
    {
        .pimg
        {
            height:auto;
            overflow: visible;
        }
        .special
        {
            top:0px;
            z-index: 4;
        }
    }
    .price
    {

        margin: 10px 0px 5px;
        font: 17px Yekan;
    }
    .item-title
    {
        font-family: Arial,Yekan;
        font-size:13px;
        padding: 5px;

    }

    .productId
    {
        background: rgba(255, 255, 255, 0.8) none repeat scroll 0 0;
        opacity: 0;
        font-size:16px;
        padding:5px;
        position: absolute;
        top: 0;
        color:#dd1144;
        transition: opacity 0.5s ease 0s;


    }
    .item:hover .productId
    {

        display: block;
        opacity: 1;

    }
</style>

