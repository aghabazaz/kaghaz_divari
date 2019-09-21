<main class="page-content" style="margin-top:20px ;">
    <div class="container grid-row" style="background-color: #fff ;direction :rtl;">
        <h1 class="catg-compare"> لیست مقایسه <?php echo $catId['title'] ?></h1>
        <div class="slider-device-pic">
            <?php
            //\f\pre($row);
            foreach ( $row AS $data )
            {
                $removeUrl = str_replace( 'RP-' . $data['id'] . '/','',
                    $strProduct );
                ?>
                <div class="col-md-3 col-sm-4  col-xs-6 " id="boxProductCompare">
                    <div style="" class="removeProductCompare">
                        <a href="<?= \f\ifm::app()->siteUrl . 'compare/' . $removeUrl ?>" style="color:silver;">
                            <i class="fa fa-times-circle-o"></i>
                        </a>

                    </div>


                    <div class="device-select-box">
                        <div class="pic-Sample-slider">
                            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                                <!-- Wrapper for slides -->
                                <div class="carousel-inner" role="listbox">
                                    <a href="<?= \f\ifm::app()->siteUrl . 'productDetail/' . $data['id'] ?>">

                                        <div class="item active">
                                            <img class="img-responsive"
                                                 src="<?= \f\ifm::app()->fileBaseUrl . $data['picture'] ?>"
                                                 alt=" <?php echo $row['title'] ?>">
                                        </div>
                                    </a>
                                </div>
                                <!-- Controls 
                                <a class="left carousel-control carousel-custome" href="#carousel-example-generic" role="button" data-slide="prev">
                                    <span class="fa fa-chevron-left" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="right carousel-control carousel-custome" href="#carousel-example-generic" role="button" data-slide="next">
                                    <span class="fa fa-chevron-right" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                                -->
                            </div>
                        </div>
                        <div class="product-title-div">
                            <a href="<?= \f\ifm::app()->siteUrl . 'productDetail/' . $data['id'] ?>" target="_blank">
                                <div class="persian_title_product">
                                    <p class="firstTitle"><?php echo $data['title']; ?></p>
                                </div>
                                <p class="firstTitle"><?php echo $data['sub_title']; ?></p>
                                <!--                        <div class="rating">
                                                            <div class="stars">
                                                                <span class="star rated"></spam>
                                                                    <span class="star rated"></span>
                                                                    <span class="star rated"></span>
                                                                    <span class="star"></span>
                                                                    <span class="star"></span>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                        </div>-->
<!--                                <div class="oldprice"><span>--><?php //echo number_format( $data['price'] ); ?><!--</span></div>-->
<!--                                <div class="price-compare-box">-->
<!--                                    <span class="price-compare">--><?php //echo number_format( $data['price'] - $data['discount'] ); ?><!-- </span><span-->
<!--                                            class="tomaan-unit">تومان</span>-->
<!--                                </div>-->
                            </a>
                        </div>
                    </div>

                </div>
                <?php
            }
            ?>
            <?php

            for ( $x = 1; $x <= $num - $count; $x++ )
            {
                ?>
                <div class="col-md-3 col-sm-4 col-xs-6">
                    <div class="device-select-box desktop-view">
                        <div class="add-compare-product">
                            <span>افزودن</span>
                            <div class="styled-select2" style="direction: rtl !important">
                                <select id="brand<?php echo $x ?>" class="chosen-rtl"
                                        onchange="getProductByBrand(<?php echo $x ?>,<?= $catId['id'] ?>)">
                                    <option value="#">برند</option>
                                    <?php
                                    foreach ( $brandList AS $data )
                                    {
                                        ?>
                                        <option value="<?= $data['id'] ?>"><?php echo $data['title_fa'] . ' [ ' . $data['title_en'] . ' ]'; ?></option>
                                        <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="styled-select2" style="direction: rtl !important">
                                <select class="ddlBrand chosen-rtl" id="product<?php echo $x ?>">
                                    <option value="">انتخاب مدل</option>
                                </select>
                            </div>
                            <div class="btn-add-product-compare">
                                <div class="dka-button-container addtocompare">
                                    <a id="btnSearchCompare3" class="dk-button blue" tabindex="9"
                                       onclick="addProductToCompareList(<?php echo $x ?>)">
                                        <i class="dk-button-icon dk-button-icon-caretLeft"></i>
                                        <span class="dk-button-label clearfix">
                                            <span class="dk-button-labelname"><i class="fa fa-plus-circle"></i>&nbsp;&nbsp; اضافه کن...</span>     
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="mobile-view device-select-box-in-mobile device-select-box">
                        <div class="icon-add-device-in-mobile" onclick="showFilter()">
                            <i class="fa fa-plus-circle"></i>
                        </div>
                        <span>افزودن محصول</span>
                    </div>
                </div>
                <?php
            }
            ?>


            <div class="clearfix"></div>
        </div>
        <?php
        $label = '';
        //\f\pr($feature);
        foreach ( $feature AS $data )
        {
            if ( $data['featureTitle'] != $label )
            {
                $label = $data['featureTitle'];
                ?>
                <div class="title-compare">
                    <span><?= $data['featureTitle'] ?></span>
                </div>
                <?php
            }
            ?>

            <div class="Compare vehicles">
                <div class="title-compare-option">
                    <span><?= $wiki[$data['id']] ?></span>
                </div>
                <div class="row-eq-height">
                    <?php
                    foreach ( $param AS $key )
                    {
                        if ( $data['type'] == 'multiSelect' )
                        {
                            foreach ( $value[$key][$data['fId']] AS $data1 )
                            {
                                $val2[$key][] = $wiki[$data1];
                            }
                            $val = implode( ' ، ',$val2[$key] );
                        } else if ( $data['type'] == 'oneSelect' )
                        {
                            $val = $wiki[$value[$key][$data['fId']]];
                        } else if ( $data['type'] == 'yesOrNo' )
                        {
                            $val = $value[$key][$data['fId']];

                            if ( $val == 'no' )
                            {
                                $val = '<i class="fa fa-times" style="font-size:20px;color: #FF6A6C;"></i>';
                            } else if ( $val == 'yes' )
                            {
                                $val = '<i class="fa fa-check" style="font-size:20px;color: #4CAF50"></i>';
                            }
                        } else
                        {
                            $val = $value[$key][$data['fId']];
                        }
                        ?>
                        <div class="col-md-3 col-sm-4 col-xs-6 col-bg-compare" style="">
                            <p><?= $val ? $val : 'N/A' ?></p>
                        </div>
                        <?php
                    }
                    ?>

                    <div class="clearfix">
                    </div>
                </div>
            </div>
            <?php
            $color = "";
        }
        ?>

    </div>
    <br>
    <div id="filter-box" class="mobile-view">
        <div style="padding:8px ;background: #eee;border-bottom: 1px solid silver;margin-bottom: -1px">
            <div class="right" style="color:#000;"><span style="padding-right:10px;">افزودن</span></div>
            <div class="left">

                <i class="fa fa-times" style="color:gray;font-size: 18px;cursor: pointer" onclick="hideFilter()"></i>

            </div>
            <div class="clearfix"></div>
        </div>
        <div class="device-select-box">
            <div class="add-compare-product">
                <div class="styled-select2" style="direction: rtl !important">
                    <select id="brand<?php echo $x ?>" class="chosen-rtl"
                            onchange="getProductByBrand(<?php echo $x ?>,<?= $catId['id'] ?>)">
                        <option value="#">برند</option>
                        <?php
                        foreach ( $brandList AS $data )
                        {
                            ?>
                            <option value="<?= $data['id'] ?>"><?php echo $data['title_fa'] . ' [ ' . $data['title_en'] . ' ]'; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
                <div class="styled-select2" style="direction: rtl !important">
                    <select class="ddlBrand chosen-rtl" id="product<?php echo $x ?>">
                        <option value="">انتخاب مدل</option>
                    </select>
                </div>
            </div>
        </div>
        <div onclick="addProductToCompareList(<?php echo $x ?>)"
             style="cursor: pointer;position: absolute;right:0px;bottom: 0px;width: 100%;height:50px;line-height: 48px;text-align: center;background: #49BDFC;color: #fff;">
            افزودن کالا
        </div>
    </div>
</main>
<script>
    document.getElementById("tab-content-mobile").style.height = ($(window).height() - 201) + "px";

    function showFilter() {
        document.getElementById("filter-box").style.left = "0px";
        $('body').addClass('noscroll');
    }

    /* Set the width of the side navigation to 0 */
    function hideFilter() {
        document.getElementById("filter-box").style.left = "-999px";
        $('body').removeClass('noscroll');

    }

    $(document).ready(function () {
        $(".pic-Sample-slider").hover(function () {
            $(".carousel-custome").css("opacity", "1");
        }, function () {
            $(".carousel-custome").css("opacity", "0");
        });
    });

    function getProductByBrand(id, category) {
        var val = $('#brand' + id).val();
        widgetHelper.tt('ui', 'shop.product.getProductByBrand', {
            box: id,
            id: val,
            category: category
        }, 'refreshProductList');
        //alert(val);
    }

    function refreshProductList(params) {
        $('#product' + params.box).html(params.content);

    }

    function addProductToCompareList(id) {
        var value = $('#product' + id).val();

        if (value) {
            var url = window.location + 'RP-' + value + '/';
            window.location.href = url;
        }
    }
</script>
<style>
    #filter-box {
        background: #fff;
        position: fixed;
        top: 0;
        width: 100%;
        height: 100%;
        z-index: 1000;
        left: -999px;
        transition-property: all;
        transition-duration: .5s;
        transition-timing-function: cubic-bezier(0, 1, 0.5, 1);
    }
    .add-compare-product select {
        display: block;
        height: 42px;
        padding: 2px 8px 0 0px;
        overflow: hidden;
        position: relative;
        border: 1px solid #eee;
        white-space: nowrap;
        line-height: 38px;
        color: #444;
        text-decoration: none;
        border-radius: 0px;
        background-clip: padding-box;
        -webkit-touch-callout: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        width: 100%;
        margin-top: 10px;
    }
    .device-select-box {
        border: 1px solid #ebeced;
        margin-bottom: 15px;
        padding: 40px;
        background: #f2fdff;
        position: relative;
    }
    a#btnSearchCompare3>i {
        display: inline;
    }

</style>