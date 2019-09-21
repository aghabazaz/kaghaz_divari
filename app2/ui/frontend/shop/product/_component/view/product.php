<link rel="stylesheet" href="<?= \f\ifm::app()->siteUrl ?>app/ui/templates/frontend/main/css/jquery-ui.css"
      type="text/css" media="screen">

<?php
if (!$brand['id']) {
    $brand['id'] = 0;
}
?>
<!-- page content -->
<main class="page-content  desktop-view">
    <div class="container">
        <div class="row " style=" ">
            <div class="url-page-box" style="margin-bottom:10px">
                <div class="page-address-box padding-addressBar">
                    <i style="padding-left:3px;" class="fa fa-home"></i><span class="address-name"><a title="خانه"
                                href="<?= \f\ifm::app()->siteUrl ?>">خانه</a></span>
                    <?php
                    if ($ConcessionProduct) {
                        ?>
                        <span class="arrow-address5 fa fa-angle-left"></span>
                        <span class="address-name">تخفیفی ها</span>
                        <?php
                    }
                    foreach ($sortCat AS $data) {
                        ?>
                        <span class="arrow-address5 fa fa-angle-left"></span>
                        <span class="address-name"><?= $data['title'] ?></span>
                        <?php
                        $title = $data['title'];
                    }
                    ?>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="row" style="background-color: #fff ;">
            <?php
            if ($ConcessionProduct) {
                ?>
                <div class="col-md-3">
                    <div style="margin-top:15px;">
                        <?php
                        echo \f\ttt::block('cms.advertisement.getAdvertise',
                            array(
                                'limit' => '7',
                                'plan' => 'C'
                            ));
                        ?>
                    </div>
                </div>
                <?php
            }
            if (!$ConcessionProduct) {
                ?>
                <!-- photo tour -->
                <div class="col-md-3">
                    <div class="custome-serch">
                        <!--                        <div class="product-name">-->
                        <!--                            <span class="group-product">--><?//= $category[ 'title' ]
                        ?><!--</span>-->
                        <!--                            <span class="fa  fa-chevron-down"></span>-->
                        <!--                        </div>-->
                        <!--                        <div class="category-one">-->
                        <!--                            --><?php
                        //                            //\f\pre($sortCat);
                        //                            $flag  = true ;
                        //                            $flag2 = true ;
                        //                            foreach ( $sortCat AS $data )
                        //                            {
                        //                                if ( $flag )
                        //                                {
                        //
                        ?>
                        <!--                                    <div class="product-name-categories">-->
                        <!--                                        <span class="group-product">-->
                        <?//= $data[ 'title' ]
                        ?><!--</span>-->
                        <!--                                        <span class="cat-show fa  fa-minus"></span>-->
                        <!--                                    </div>-->
                        <!--                                    <div class="show-hide-categury">-->
                        <!--                                        --><?php
                        //                                        $flag = false ;
                        //                                    }
                        //                                    else if ( $flag2 )
                        //                                    {
                        //
                        ?>
                        <!--                                        <div class="subset"> -->
                        <!--                                            <span style="padding-left:4px" class="subset-icons fa  fa-angle-left"> </span>-->
                        <!--                                            <span class="subset-title">-->
                        <?//= $data[ 'title' ]
                        ?><!--</span>-->
                        <!--                                        </div>-->
                        <!--                                        --><?php
                        //                                        $flag2 = false ;
                        //                                    }
                        //                                    else
                        //                                    {
                        //
                        ?>
                        <!--                                        <div class="subset-tow"> -->
                        <!--                                            <span style="padding-left:4px" class="subset-icons fa  fa-angle-left"> </span>-->
                        <!--                                            <span class="subset-title">-->
                        <?//= $data[ 'title' ]
                        ?><!--</span>-->
                        <!--                                        </div>-->
                        <!--                                        --><?php
                        //                                    }
                        //                                }
                        //
                        ?>
                        <!--                            </div>-->
                        <!--                        </div>-->
                        <!--                        <hr class="line-catgury"/>-->
                        <!--                        <div class="category-tow">-->
                        <!--                            <div class="product-name-categories">-->
                        <!--                                <span class="group-product">براساس قیمت</span> -->
                        <!--                            </div>-->
                        <!--                        </div>-->
                        <!--                        <div class="price-range-div">-->
                        <!--                            <div id="price-range"></div>-->
                        <!--                            <div id="amount">-->
                        <!--                                <span class="minPrice "></span>-->
                        <!--                                <span class="maxPrice"></span>-->
                        <!--                            </div>-->
                        <!--                        </div>-->
                        <hr class="line-catgury"/>
                        <div class="product-name-categories">
                            <span class="group-product">بر اساس سازنده</span>
                        </div>
                        <div class="category-tow">
                            <div class="select-brand">
                                <ul class="brand-ul">
                                    <?php
                                    $i = 1;
                                    foreach ($brands AS $data) {
                                        if ($i == 4) {
                                            $flagBrand = TRUE;
                                            echo '<div class="show-list-order">';
                                        }
                                        ?>
                                        <li>
                                            <input type="checkbox" onchange="getProductByParam()" name="brand"
                                                   value="<?= $data['brand_id'] ?>" id="check<?= $data['brand_id'] ?>"
                                                   class="checkbox checkBrand">
                                            <label for="check<?= $data['brand_id'] ?>"
                                                   class="checkBrand"><?= $data['brand_fa'] ?></label>
                                            <label for="check<?= $data['brand_id'] ?>" class="checkBrand"
                                                   style="float:left"><?= ucfirst($data['brand_en']) ?></label>
                                        </li>
                                        <?php
                                        $i++;
                                    }
                                    if ($flagBrand) {
                                        echo '</div>';
                                    }
                                    ?>
                                </ul>
                                <?php
                                if ($flagBrand) {
                                    echo '<div class="brand-show more-brand-BTN">
                                    <i style="padding-left :5px;" class="fa fa-plus aroww-all-product-show"><i style="padding-left :5px;" class="fa fa-minus aroww-all-product-hide"></i></i><label for="check9" class="checkBrand more-brand">بیشتر... </label>  
                                  </div>';
                                }
                                ?>

                            </div>
                        </div>
                        <hr class="line-catgury"/>
                        <div class="product-name-categories">
                            <span class="group-product">بر اساس رنگ</span>
                        </div>
                        <div class="category-tow">
                            <div class="select-brand">
                                <ul class="brand-ul">
                                    <?php
                                    $i = 1;
                                    foreach ($colors AS $data) {
                                        if ($i == 4) {
                                            $flagColor = TRUE;
                                            echo '<div class="show-list-order">';
                                        }
                                        ?>
                                        <li>
                                            <input type="checkbox" onchange="getProductByParam()" name="color"
                                                   value="<?= $data['id'] ?>" id="color<?= $data['id'] ?>"
                                                   class="checkbox checkColor">
                                            <div class="checkColor" style="position : relative;"><p
                                                        class="ProductColorStyle-black checkColor"
                                                        style="background-color:<?= $data['code'] ?>"></p></div>
                                            <label style="margin-right:8px;" for="color<?= $data['id'] ?>"
                                                   class="checkColor"><?= $data['title'] ?></label>
                                        </li>
                                        <?php
                                        $i++;
                                    }
                                    if ($flagColor) {
                                        echo '</div>';
                                    }
                                    ?>
                                </ul>
                                <?php
                                if ($flagColor) {
                                    echo '<div class="brand-show more-brand-BTN">
                                    <i style="padding-left :5px;" class="fa fa-plus aroww-all-product-show"><i style="padding-left :5px;" class="fa fa-minus aroww-all-product-hide"></i></i><label for="check9" class="checkBrand more-brand">بیشتر... </label>  
                                  </div>';
                                }
                                ?>

                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            if (!$ConcessionProduct) {
                ?>
                <div class="col-md-9" style="padding-top:20px">
                    <div class="mtb" style="padding-bottom:15px;margin-bottom: 5px;border-bottom: 1px solid #eee">
                        <div class="sortorder">
                            <div class="col-md-7" style="padding:0px">
                                <div class="col-md-5" style="padding:0px">
                                    <span class="checkbox-item">
                                        <label class="switch">
                                            <input class="switch-input" type="checkbox" id="sale_status"
                                                   name="sale_status" onchange="getProductByParam()" value="enabled"/>
                                            <span class="switch-label" data-on="بله" data-off="خیر"></span>
                                            <span class="switch-handle"></span>
                                        </label>
                                    </span>
                                    <div class="show-Available-prodoct">
                                        <span>نمایش کالاهای موجود</span>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <input class="input-search-items" type="text" name="searchText" id="searchText"
                                           placeholder="جستجو ..." onkeyup="getProductByParam()">
                                </div>
                            </div>
                            <div class="col-md-5" style="padding:0px">
                                <div class="col-md-4"
                                     style="font-size:12px;color:#000;text-align: left;padding: 13px 0px 0px 5px">
                                    <span style="vertical-align:middle">
                                        مرتب سازی براساس
                                    </span>
                                </div>
                                <div class="col-md-4" style="padding:0px">
                                    <select id="sort" name="sort" onchange="getProductByParam()">
                                        <option value="t1.id">جدیدترین</option>
                                        <option value="t1.num_visit">پر بازدیدترین</option>
                                        <option value="t1.special">پیشنهاد ویژه</option>
                                        <option value="(t3.price-t3.discount)">قیمت</option>
                                        <option value="(t1.rate_avg)">امتیاز</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select id="sort_type" name="sort_type" onchange="getProductByParam()">
                                        <option value="DESC">نزولی</option>
                                        <option value="ASC">صعودی</option>
                                    </select>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    <div class="set-Item row" style="margin-bottom:10px;margin-left: 15px">
                        <span>تعداد نتیجه : </span><span id="countSearchProduct" class="fa-digit"></span>
                    </div>
                    <input type="hidden" id="minPrice" name="minPrice">
                    <input type="hidden" id="maxPrice" name="maxPrice">
                    <div id="product" style="min-height: 400px;position: relative;width:100%;height:100%;">

                    </div>
                </div>
                <?php
            } elseif ($ConcessionProduct) {
                ?>
                <div class="col-md-9" style="padding-top:20px">
                    <div class="content_header clearfix">
                        <h1 class="content_title">محصولات: تخفیفی</h1>
                    </div>
                    <ul class="products">
                        <?php
                        foreach ($ConcessionProduct AS $data) {
                            ?>
                            <li id="" class="product_thumb last price_on col-lg-3 col-md-3 col-sm-4 col-xs-4 col-ms-6">
                                <div class="thumb_body item_body" title="#">
                                    <a href="<?= \f\ifm::app()->siteUrl . 'productDetail/' . $data['id'] ?>"
                                       class="thumb_image_link">
                                        <img style="max-width:150px;" class="product_thumb_image"
                                             src="<?= \f\ifm::app()->fileBaseUrl . $data['picture'] ?>"></a>
                                    <a title="<?= \f\ifm::app()->siteUrl . 'productDetail/' . $data['title'] ?>"
                                       href="<?= \f\ifm::app()->siteUrl . 'productDetail/' . $data['id'] ?>">
                                        <h2><?php echo $data['title']; ?></h2>
                                    </a>
                                    <div class="product_thumb_badges">
                                        <div class="thumb_badge badge_off"></div>
                                    </div>
                                    <div class="product_off"><b><?php echo $data['discount'] ?>%</b></div>
                                </div>
                            </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
                <?php
            }
            ?>
            <div class="clearfix"></div>
            <?php
            if ($ConcessionProduct) {
                ?>
                <div class="pagination" style="text-align: center">

                    <?php
                    $lastpage = ceil(($num / $num_page));
                    $i = 1;
                    $lpm1 = $lastpage - 1;
                    $adjacents = 3;
                    $pr = $page - 1;
                    $nx = $page + 1;
                    //\f\pre($lastpage);
                    if ($sRow['id']) {
                        $href = \f\ifm::app()->siteUrl . 'product/off/' . $sRow['id'];
                    } else {
                        $href = \f\ifm::app()->siteUrl . 'product/off';
                    }

                    include 'pagination_1.php';
                    ?>

                </div>
                <?php
            }
            ?>
            <br>
        </div>
    </div>
</main>
<div class="mobile-view">
    <div style="padding:4px 8px ;background: #fff;margin-top: 10px">
        <div class="right" style="color:#000;padding-top: 7px"><?= $title ?></div>
        <div class="left">
            <!--
            <button class="btn btn-default">
                <i class="fa fa-sort-amount-desc" style="color:gray"></i>
            </button>
            -->
        </div>
        <div class="clearfix"></div>
    </div>
    <input type="hidden" id="page" value="">
    <div id="product-mobile" style="min-height: 400px;padding:10px 10px 50px">

    </div>
    <div class="mobile-footer"
         style="position: fixed;bottom: 0px;background: #fff;height: 40px;width: 100%;direction: rtl">
        <div class="right"
             style="width:50%;border-left:1px solid silver;height: 40px;text-align: center;line-height: 38px;cursor: pointer"
             onclick="showSort()">
            <i class="fa fa-sort-amount-asc"></i> <span style="color:#000">مرتب سازی</span>
        </div>
        <div class="right" style="width:50%;height: 40px;text-align: center;line-height: 38px;cursor: pointer"
             onclick="showFilter()">
            <i class="fa fa-filter"></i> <span style="color:#000">فیلتر کردن</span>
        </div>
        <div class="clearfix"></div>
    </div>

    <div id="filter-box">
        <div style="padding:8px ;background: #eee;border-bottom: 1px solid silver;margin-bottom: 10px">
            <div class="right" style="color:#000;"><?= $title ?></div>
            <div class="left">

                <i class="fa fa-times" style="color:gray;font-size: 18px;cursor: pointer" onclick="hideFilter()"></i>

            </div>
            <div class="clearfix"></div>
        </div>
        <div>
            <ul class="nav nav-tabs">
                <li class="active">
                    <a class="set-toggle-custom" data-toggle="tab" href="#home" title="قیمت">
                        قیمت
                    </a>
                </li>
                <li>
                    <a class="set-toggle-custom" data-toggle="tab" href="#menu1" title="سازنده">
                        سازنده
                    </a>
                </li>
                <li>
                    <a class="set-toggle-custom" data-toggle="tab" href="#menu2" title="رنگ">
                        رنگ
                    </a>
                </li>
            </ul>
            <div class="tab-content" id="tab-content-mobile" style="overflow-y: scroll">
                <div id="home" class=" tab-pane in-tab-custome fade in active">
                    <div class="price-range-div">
                        <div id="price-range-mobile"></div>
                        <div id="amount">
                            <span class="minPrice "></span>
                            <span class="maxPrice"></span>
                        </div>
                    </div>
                </div>
                <div id="menu1" class=" tab-pane in-tab-custome fade">
                    <div>
                        <div>
                            <ul class="brand-ul">
                                <?php
                                $i = 1;
                                foreach ($brands AS $data) {
                                    if ($i == 4) {
                                        $flagBrand = TRUE;
                                        echo '<div class="show-list-order">';
                                    }
                                    ?>
                                    <li>
                                        <input type="checkbox" onchange="getProductByParam()" name="brand"
                                               value="<?= $data['brand_id'] ?>" id="check<?= $data['brand_id'] ?>"
                                               class="checkbox checkBrand">
                                        <label for="check<?= $data['brand_id'] ?>"
                                               class="checkBrand"><?= $data['brand_fa'] ?></label>
                                        <label for="check<?= $data['brand_id'] ?>" class="checkBrand"
                                               style="float:left"><?= ucfirst($data['brand_en']) ?></label>
                                    </li>
                                    <?php
                                    $i++;
                                }
                                if ($flagBrand) {
                                    echo '</div>';
                                }
                                ?>
                            </ul>
                            <?php
                            if ($flagBrand) {
                                echo '<div class="brand-show more-brand-BTN">
                                    <i style="padding-left :5px;" class="fa fa-plus aroww-all-product-show"><i style="padding-left :5px;" class="fa fa-minus aroww-all-product-hide"></i></i><label for="check9" class="checkBrand more-brand">بیشتر... </label>  
                                  </div>';
                            }
                            ?>

                        </div>
                    </div>
                </div>
                <div id="menu2" class=" tab-pane in-tab-custome fade">
                    <div>
                        <div>
                            <ul class="brand-ul">
                                <?php
                                foreach ($colors AS $data) {
                                    ?>
                                    <li>
                                        <input type="checkbox" onchange="getProductByParam()" name="color"
                                               value="<?= $data['id'] ?>" id="color<?= $data['id'] ?>"
                                               class="checkbox checkColor">
                                        <div class="checkColor" style="position : relative;"><p
                                                    class="ProductColorStyle-black checkColor"
                                                    style="background-color:<?= $data['code'] ?>"></p></div>
                                        <label style="margin-right:8px;" for="color<?= $data['id'] ?>"
                                               class="checkColor"><?= $data['title'] ?></label>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>


                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div style="direction: rtl;text-align: right;position: absolute;right:0px;bottom: 50px;width: 100%;height:50px;line-height: 48px;text-align: center;padding-right: 10px;border-top: 1px solid #eee">

            <span class="checkbox-item">
                <label class="switch">
                    <input class="switch-input" type="checkbox" id="sale_status_mobile" name="sale_status"
                           onchange="getProductByParam()" value="enabled"/>
                    <span class="switch-label" data-on="بله" data-off="خیر"></span>
                    <span class="switch-handle"></span>
                </label>
            </span>
            <div style="text-align:right;">
                <span style="padding-right:5px">نمایش کالاهای موجود</span>
            </div>
            <div class="clearfix"></div>

        </div>
        <div onclick="hideFilter()"
             style="cursor: pointer;position: absolute;right:0px;bottom: 0px;width: 100%;height:50px;line-height: 48px;text-align: center;background: #49BDFC;color: #fff;">
            اعمال فیلتر
        </div>
    </div>

    <div id="sort-box">
        <div style="padding:8px ;background: #eee;border-bottom: 1px solid silver;margin-bottom: 10px">
            <div class="right" style="color:#000;"><?= $title ?></div>
            <div class="left">

                <i class="fa fa-times" style="color:gray;font-size: 18px;cursor: pointer" onclick="hideSort()"></i>

            </div>
            <div class="clearfix"></div>
        </div>
        <div>
            <div class="col-md-12" style="text-align:right;padding: 10px 15px;color:#000">
                <span style="vertical-align:middle">
                    مرتب سازی براساس
                </span>
            </div>
            <div class="col-md-12" style="padding-bottom:10px">
                <select id="sort-mobile" name="sort" onchange="getProductByParam()">
                    <option value="t1.id">جدیدترین</option>
                    <option value="t1.num_visit">پر بازدیدترین</option>
                    <option value="t1.special">پیشنهاد ویژه</option>
                    <option value="(t3.price-t3.discount)">قیمت</option>
                    <option value="(t1.rate_avg)">امتیاز</option>
                </select>
            </div>
            <div class="col-md-12">
                <select id="sort-type-mobile" name="sort_type" onchange="getProductByParam()">
                    <option value="DESC">نزولی</option>
                    <option value="ASC">صعودی</option>
                </select>
            </div>
        </div>
        <div onclick="hideSort()"
             style="cursor: pointer;position: absolute;right:0px;bottom: 0px;width: 100%;height:50px;line-height: 48px;text-align: center;background: #49BDFC;color: #fff;">
            اعمال مرتب سازی
        </div>
    </div>
</div>
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

    .in-tab-custome {
        padding-top: 10px;
    }

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

    #sort-box {
        background: #fff;
        position: fixed;
        top: 0;
        width: 100%;
        height: 100%;
        z-index: 1000;
        right: -999px;
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

    .select-brand {
        margin-top: 45px;
    }

    .checkBrand, .checkColor {
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

    .brand-ul > div > li > input {
        margin-left: 5px;
    }

    .brand-show {
        direction: rtl;
        text-align: right;
        padding: 0px 12px 15px;
    }

    .hide-brand {
        display: none;
    }

    .show-list-order-color {
        display: none;
    }

    .more-brand-BTN {
        cursor: pointer;
    }

    .more-color-BTN {
        cursor: pointer;
    }

    .ProductColorStyle-black {
        height: 13px;
        width: 5px;
        outline: 1px solid #ddd;
        position: absolute;
        top: 0px;
        right: 0px;
    }

    .ProductColorStyle-red {
        height: 13px;
        width: 5px;
        background-color: red;
        outline: 1px solid #ddd;
        position: absolute;
        top: 0px;
        right: 0px;
    }

    .ProductColorStyle-orange {
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

    .page-address-box > span {
        padding-left: 15px;
    }

    .col-product {
        padding: 0px 5px;
    }

    .col-product:first-child {
        padding-right: 0px !important;
    }

    .col-product:last-child {
        padding-left: 0px !important;
    }

    .item {
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

    .item:hover {
        border-color: #ccc;
        box-shadow: 0 1px 4px 1px rgba(0, 0, 0, 0.2);
    }

    .pimg {
        margin-top: 0px;
        height: 160px;
        overflow: hidden;
        text-align: center;

    }

    .cat-title {
        margin-top: 5px;

    }

    .cat-title a {
        color: silver;
    }

    .cat-title a:hover {
        color: #000;
    }

    @media (max-width: 768px) {
        .pimg {
            height: auto;
            overflow: visible;
        }

        .special {
            top: 0px;
            z-index: 4;
        }
    }

    .price {

        margin: 10px 0px 5px;
        font: 17px Yekan;
    }

    .item-title {
        font-family: Arial, Yekan;
        font-size: 13px;
        padding: 5px;

    }

    .productId {
        background: rgba(255, 255, 255, 0.8) none repeat scroll 0 0;
        opacity: 0;
        font-size: 16px;
        padding: 5px;
        position: absolute;
        top: 0;
        color: #dd1144;
        transition: opacity 0.5s ease 0s;

    }

    .item:hover .productId {

        display: block;
        opacity: 1;

    }
</style>
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

    function showSort() {
        document.getElementById("sort-box").style.right = "0px";
        $('body').addClass('noscroll');
    }

    /* Set the width of the side navigation to 0 */
    function hideSort() {
        document.getElementById("sort-box").style.right = "-999px";
        $('body').removeClass('noscroll');

    }

    getProductByParam(1);

    function getProductByParam(page) {
        if (!page) {
            page = 1;
        }


        var brand = [];
        $.each($("input[name='brand']:checked"), function () {
            brand.push($(this).val());
        });

        var color = [];
        if ($('#color').val()) {
            color.push($('#color').val());
        } else {
            $.each($("input[name='color']:checked"), function () {

                color.push($(this).val());

            });
        }

        if ($(window).width() <= 767) {
            var mode = 'mobile';
            var sort = $('#sort-mobile').val();
            var sort_type = $('#sort-type-mobile').val();
            if ($('#sale_status_mobile').is(":checked")) {
                var sale_status = "disabled";
            } else {
                sale_status = '';
            }
        } else {
            mode = 'desktop';
            sort = $('#sort').val();
            sort_type = $('#sort_type').val();
            if ($('#sale_status').is(":checked")) {
                var sale_status = "disabled";
            } else {
                sale_status = '';
            }
        }
        $('#page').val(page);


        var option = {
            sort: sort,
            sort_type: sort_type,
            page: page,
            sale_status: sale_status,
            brand: brand,
            color: color,
            cat_id: <?= $category['id'] ?>,
            searchText: $('#searchText').val(),
            brand_id: <?= $brand['id'] ?>,
            minPrice: $('#minPrice').val(),
            maxPrice: $('#maxPrice').val(),
            mode: mode

        };
        widgetHelper.addLoading("#product", "absolute");
        //widgetHelper.addLoading("#product-mobile", "absolute");
        widgetHelper.tt('ui', 'shop.product.getProductByParam', option, 'showResult')
    }

    function showResult(params) {

        if ($(window).width() <= 767) {
            var page = $('#page').val();

            if (page == 1) {
                $('#product-mobile').html(params.content);
            } else {
                $('#product-mobile').append(params.content);
            }


        } else {
            $('#product').html(params.content);
        }


        $(".fa-digit").each(function () {
            var text = $(this).text();
            var newText = persianJs(text).englishNumber().toString();
            $(this).text(newText);
        });
        widgetHelper.removeLoading();
    }

    function betterParseFloat(x) {
        if (isNaN(parseFloat(x)) && x.length > 0)
            return betterParseFloat(x.substr(1));
        return parseFloat(x);
    }

    var s = 0;
    $(".more-brand-BTN").click(function () {
        if (s == 0) {
            $(".more-brand").text("بستن...");
            s = 1;
        } else {
            $(".more-brand").text("بیشتر...");
            s = 0;
        }
        $(".show-list-order").slideToggle(300);
    });
    var x = 0;
    $(".more-color-BTN").click(function () {
        if (x == 0) {
            $(".aroww-all-product-show").css('display', 'none');
            $(".aroww-all-product-hide").css('display', 'block');
            $(".more-color").text("بستن...");

            x = 1;
        } else {
            $(".more-color").text("بیشتر...");
            x = 0;
        }
        $(".show-list-order-color").slideToggle(300);
    });

    $(".cat-show").click(function () {
        $(".show-hide-categury").slideToggle(500);
    });

    if ($(window).width() <= 767) {
        $(function () {
            $(window).scroll(function () {
                //console.log($(document).height());
                //console.log($(document).height()+'---'+($(window).scrollTop() + $(window).height()));
                if ($(document).height() == $(window).scrollTop() + $(window).height()) {
                    //alert('ok');
                    var page = parseInt($('#page').val()) + 1;
                    if (page) {
                        getProductByParam(page);
                    }

                }
            });
        });
    }
</script>
