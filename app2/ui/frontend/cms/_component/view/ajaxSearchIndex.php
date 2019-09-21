<?php //\f\pre($product_items);?>
<div class="">
    <div class="product">
        
        <div class="row-2-searchAjax groupProduct">
            <div class="heading-tag st" style="padding-right: 15px;padding-left: 15px;">
                <span ><?= 'محصولات' ?></span>
                <div></div>
            </div>
            <?php
            if ( ! empty ( $product_items ) )
            {
                $i = 0 ;
                foreach ( $product_items AS $data )
                {
                    ?>
                    <a href="<?= \f\ifm::app ()->siteUrl ?>productDetail/<?= $data[ 'id' ] ?>" id="<?= $i ++ ; ?>">
                        <div class="result">
                            <div class="img_search">
                                <img src="<?= \f\ifm::app ()->fileBaseUrl . $data[ 'picture' ] ?>" class="search_pic">
                            </div>
                            <div class="title_search_news" style="font-size:10px"><?= $data[ 'title' ] ?></div>
                            <div class="title_search_news" style="font-size: 9px;color: #0061AB"><?= 'گروه: ' . $data[ 'cat_title' ] ?></div>
                            <div class="clear"></div>

                        </div>
                    </a>
                    <?php
                }
                ?>
            <!--
                <div class="continueSearch">
                    <a class="more plmore rtl" id="moreproduct" href="<?= \f\ifm::app ()->siteUrl ?>search/<?= $search ?>" style="">ادامه ...</a>
                    <div class="clearfix"></div>
                </div>
            -->
                <?php
            }
            else
            {
                ?>
                <div style="color:gray;">کالایی یافت نشد....</div>
                <?php
            }
            ?>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="col-sm-12 product " id="left-searchAjax">
<!--        <div class="row-1-searchAjax groupCat">-->
<!--            <div class="heading-tag st">-->
<!--                <span >--><?//= 'دسته بندی کالاها' ?><!--</span>-->
<!--                <div></div>-->
<!--            </div>-->
<!--            --><?php
//            //\f\pr($product_cat_items);
//            if ( ! empty ( $product_cat_items ) )
//            {
//                ?>
<!--                <ul id="content" class="content-ul">-->
<!--                    --><?php
//                    $i = 0 ;
//                    foreach ( $product_cat_items AS $data )
//                    {
//                        ?>
<!--                        <li class="item forced">-->
<!--                            <a style="font-size: 12px;color:#000" href="--><?//= \f\ifm::app ()->siteUrl ?><!--product/--><?//= $data[ 'title_en' ] ?><!--" id="--><?//= $i ++ ; ?><!--">-->
<!--                                --><?//= $data[ 'title' ] ?>
<!--                            </a>-->
<!--                        </li>-->
<!--                        --><?php
//                    }
//                    ?>
<!--                </ul>-->
<!---->
<!--                <div class="clearfix"></div>-->
<!--                <br>-->
<!---->
<!--                --><?php
//            }
//            else
//            {
//                ?>
<!--                <div style="color:gray;">گروه کالایی یافت نشد....</div>-->
<!--                --><?php
//            }
//            ?>
<!--        </div>-->
        <!--
        <div class="row-1-searchAjax groupContent">
            <div class="heading-tag st">
                <span style="background: #F6F6F6 none repeat scroll 0 0;"><?= 'برندها' ?></span>
                <div></div>
            </div>

            <?php
            if ( ! empty ( $brand_items ) )
            {
                ?>
                <?php
                $i = 0 ;
                foreach ( $brand_items AS $data )
                {
                    ?>
                    <a href="<?= \f\ifm::app ()->siteUrl ?>brand/<?= $data[ 'id' ] ?>" id="<?= $i ++ ; ?>">
                        <div class="result" style="height:48px">
                            <div class="img_search">
                                <img src="<?= \f\ifm::app ()->fileBaseUrl . $data[ 'logo' ] ?>" class="search_pic" style="width:40px;height:40px">
                            </div>
                            <div class="title_search_news" style="font-size:12.5px"><?= $data[ 'title_fa' ] ?></div>
                            <div class="clear"></div>
                        </div>
                    </a>
                    <?php
                }
                ?>
                <div class="clearfix"></div>

                <?php
            }
            else
            {
                ?>
                <div style="color:gray;">مدلی  یافت نشد....</div>
                <?php
            }
            ?>
        </div>
        -->
<!--        <div class="row-2-searchAjax groupNews">-->
<!--            <div class="heading-tag st">-->
<!--                <span style="background: #F6F6F6 none repeat scroll 0 0;">--><?//= 'اخبار' ?><!--</span>-->
<!--                <div></div>-->
<!--            </div>-->
<!---->
<!--            --><?php
//            if ( ! empty ( $content_items[ 0 ] ) || ! empty ( $content_items[ 1 ] ) )
//            {
//                ?>
<!--                <ul id="content" class="content-ul">-->
<!--                    --><?php
//                    $i = 0 ;
//                    foreach ( $content_items[ 0 ] AS $data )
//                    {
//                        ?>
<!--                        <li class="item forced">-->
<!--                            <div class="result_li">-->
<!--                                <a style="font-size:12px;color:#000" href="--><?//= \f\ifm::app ()->siteUrl ?><!--newsDetail/--><?//= $data[ 'id' ] ?><!--" id="--><?//= $i ++ ; ?><!--">-->
<!--                                    --><?//= $data[ 'title' ] ?>
<!--                                </a>-->
<!--                            </div>-->
<!--                        </li>-->
<!--                        --><?php
//                    }
//                    foreach ( $content_items[ 1 ] AS $data )
//                    {
//                        ?>
<!--                        <li class="item forced">-->
<!--                            <div class="result_li">-->
<!--                                <a style="font-size:12px;color:#000" href="--><?//= \f\ifm::app ()->siteUrl ?><!--newsDetail/--><?//= $data[ 'id' ] ?><!--" id="--><?//= $i ++ ; ?><!--">-->
<!--                                    --><?//= $data[ 'title' ] ?>
<!--                                </a>-->
<!--                            </div>-->
<!--                        </li>-->
<!--                        --><?php
//                    }
//                    ?>
<!--                </ul>-->
<!--            <!---->
<!--                <div class="continueSearch">-->
<!--                    <a class="more plmore rtl" id="moreproduct" href="--><?//= \f\ifm::app ()->siteUrl ?><!--search/--><?//= $search ?><!--" style="">ادامه ...</a>-->
<!--                    <div class="clearfix"></div>-->
<!--                </div>-->
<!--            -->
<!--                --><?php
//            }
//            else
//            {
//                ?>
<!--                <div style="color:gray;">مطلبی  یافت نشد....</div>-->
<!--                --><?php
//            }
//            ?>
<!--            <div class="clearfix"></div>-->
<!--        </div>-->
    </div>
    <div class="clearfix"></div>
</div>
<style>
    .product .heading-tag {
        padding-bottom: 12px;
    }
    .product .heading-tag span {
        background: #fff none repeat scroll 0 0;
        color: #0061ab;
        float: right;
        margin-right: 15px;
        padding: 0 5px;
    }
    .product .heading-tag div {
        border-bottom: 1px solid gray;
        height: 15px;
    }
    .continueSearch .plmore {
        float:left;
    }
    .continueSearch .more {
        text-decoration: none;
        background-color: #c3c3c3;
        box-shadow: 0 0 15px rgba(0,0,0,.5) inset;
        width: 55px;
        height: 20px;
        line-height: 20px;
        display: block;
        color: #fff;
        text-align: center;
        margin-bottom: 5%;
        margin-top: 5%;
    }

    #content .item{
        background: url('app/ui/templates/backend/default/images/newsarrow.gif') no-repeat 99% 9px;
        overflow: hidden;
        text-align: right;
        white-space: nowrap;
        text-overflow: ellipsis;
        padding-right: 13px;
    }
    .content-ul{
        padding: 0px;
    }
    #left-searchAjax {
        background: #f6f6f6 url('app/ui/templates/backend/default/images/left_serach_ajax.png') no-repeat 100% 50%;
        display: none;
    }
</style>
<script>
    $(document).ready(function () {
        var maxHeightRow1 = Math.max.apply(null, $(".row-1-searchAjax").map(function ()
        {
            return $(this).height();
        }).get());
        $('.row-1-searchAjax').css('height', maxHeightRow1);
        var maxHeightRow2 = Math.max.apply(null, $(".row-2-searchAjax").map(function ()
        {
            return $(this).height();
        }).get());
        $('.row-2-searchAjax').css('height', maxHeightRow2);
    });
</script>
