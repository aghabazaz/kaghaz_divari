<!--..................Start for mobile.................-->
<main>
<div class="mobile-view">
    <div style="padding:4px 8px ;background: #fff;margin-top: 10px">
        <div class="right" style="color:#000;padding-top: 7px"><?= $title ?></div>
        <div class="left">
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
                    <a class="set-toggle-custom" data-toggle="tab" href="#home">
                        قیمت
                    </a>
                </li>
                <li>
                    <a class="set-toggle-custom" data-toggle="tab" href="#menu1">
                        سازنده
                    </a>
                </li>
                <li>
                    <a class="set-toggle-custom" data-toggle="tab" href="#menu2">
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
</main>

<!--.................end for mobile.................-->
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
</script>
<script type="text/javascript">
    getProductByParam(1);
    function getProductByParam(page)
    {
        if (!page)
        {
            page = 1;
        }

        var brand = [];
        $.each($( ".brand option:selected" ), function () {
            brand.push($(this).val());
        });

        var color = [];
        $.each($( ".color option:selected" ), function () {
            color.push($(this).val());
        });



        if ($(window).width() <= 767)
        {
            var mode = 'mobile';
            var sort = $('#sort-mobile').val();
            var sort_type = $('#sort-type-mobile').val();
            if ($('#sale_status_mobile').is(":checked"))
            {
                var sale_status = "disabled";
            } else
            {
                sale_status = '';
            }
        } else
        {
            mode = 'desktop';
            sort = $('#sort').val();
            sort_type = $('#sort_type').val();
            if ($('#sale_status').is(":checked"))
            {
                var sale_status = "disabled";
            } else
            {
                sale_status = '';
            }
        }
        $('#page').val(page);
        sort = $('#sort').val();
        sort_type = $('#sort_type').val();
        cat_id = $('#cat_id').val();
        var option = {
            sort: sort,
            sale_status: sale_status,
            sort_type: sort_type,
            page: page,
            brand: brand,
            cat_id: cat_id,
            color: color,
            searchText: $('#searchText').val(),
            mode: mode
        };
        widgetHelper.addLoading("#product", "absolute");
        widgetHelper.tt('ui', 'shop.product.getProductByParam',option, 'showResult')
    }
    function showResult(params)
    {
        $('#product').html(params.content);
        widgetHelper.removeLoading();
    }


</script>
<!--.................end for mobile.................-->