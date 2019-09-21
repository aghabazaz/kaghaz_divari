<!DOCTYPE html>
<html lang="fa-IR" dir="rtl">
<body class="backGray">
			<main class="site-main product-set-opt catProduct dir-rtl">
                <div class="desktopView" >
                    <section class="grayBack dir-rtl">
                        <div class="container no-padding">
                            <div >
                                <div class="url-page-box">
                                    <div class="page-address-box padding-addressBar">
                                        <i style="padding-left:3px;" class="fa fa-home"></i>
                                        <a href="<?= \f\ifm::app ()->siteUrl ?>"><span class="address-name">خانه</span></a><span
                                                class="arrow-address5 fa fa-angle-right"></span><span class="address-name"> درباره ما </span>
                                    </div>
                                </div>
                            </div>
                        </div>
				<div class="container backFFF">
					<div class="float-none float-right">
						<div class="content-main">
							<div class="toolbar-products toolbar-full-width">
								<div class="toolbar-option toolbar-option-top">
									<h4 class="title-primary"> <?= $title ?> </h4>
									<div class="toolbar-per">
									<span>جستجو در این گروه :</span>
									 <input onkeyup="getProductByParam()" id="searchText" type="text" name="searchText" type="email" name="email" class="toolbar-input-search input-subscribe">
									</div>
                                    <input type="hidden" value="<?= $category['id'] ?>" name="cat_id" id="cat_id">
									<div class="toolbar-sort">
										<span>مرتب سازی براساس سازنده :</span>
										<select name="brand" onchange="getProductByParam()" id="brand" class="sorter-options form-control brand">
                                            <option selected value="">انتخاب کنید</option>
                                            <?php
                                            foreach ($brands AS $data) {
                                                ?>
                                                <option value="<?= $data['brand_id'] ?>" id="check<?= $data['brand_id'] ?>"> <?= $data['brand_fa'] ?> </option>
                                                <?php
                                            }
                                            ?>
										</select>
									</div>
									<div class="toolbar-per">
									<span>فیلتر بر اساس رنگ :</span>
										<select onchange="getProductByParam()"
                                                name="color" data-id="color" id="color" class="limiter-options form-control color">
                                            <option selected value="">انتخاب کنید</option>
                                            <?php
                                            foreach ($colors AS $data) {
                                                ?>
                                                <option value="<?= $data['id'] ?>"><?= $data['title'] ?></option>
                                                <?php
                                            }
                                            ?>
										</select>
									</div>
									<div class="toolbar-per">
                                        <span>نمایش به صورت :</span>
                                        <select id="sort_type" name="sort_type"
                                                onchange="getProductByParam(1)" class="limiter-options form-control">
                                            <option value="ASC">صعودی</option>
                                            <option value="DESC">نزولی</option>
                                        </select>
                                    </div>
                                    <div class="toolbar-per">
                                        <span> مرتب سازی بر اساس : </span>
                                        <select id="sort" name="sort"
                                                onchange="getProductByParam()" class="limiter-options form-control">
                                            <option value="t1.id">جدیدترین</option>
                                            <option value="t1.num_visit">پر بازدیدترین</option>
                                            <option value="t1.special">پیشنهاد ویژه</option>
                                        </select>
                                    </div>
                                    <div class="toolbar-per">
                                        <span> نمایش کالا های موجود: </span>
                                        <select id="sale_status" name="sale_status"
                                                onchange="getProductByParam()" class="limiter-options form-control">
                                            <option value="disabled">خیر</option>
                                            <option value="enabled"> بله </option>
                                        </select>
                                    </div>
								</div>
							</div>
							<div id="product" class="products auto-clear">

							</div>
						</div>
					</div>

				</div>
				</div>
			</main>

    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    


<!--
<div class="mobileView">
    <div style="padding:0px 8px ;background: #fff;margin-top: 10px;line-height: 21px;height: 35px;border-top: 2px solid #7c7c7c4d;">
        <div class="right" style="color:#000;padding-top: 7px;"><?= $title ?></div>
        <div class="left">

        </div>
        <div class="clearfix"></div>
    </div>
    <input type="hidden" id="page" value="">
    <div id="product-mobile" style="min-height: 400px;padding:10px 10px 50px">

    </div>
 <div class="row filterSort">
        <div class="col-sm-6 col-xs-6 sortMobile" style="cursor: pointer" onclick="showSort()">
            <span>مرتب سازی</span>
        </div>
        <div class="col-sm-6 col-xs-6 filterMobile" style="cursor: pointer" onclick="showFilter()">
            <span>فیلتر کردن</span>
          </div>
    </div>
<div id="sortMain">

    <div class="topTitle">
        <h4><?= $title ?></h4>
        <i class="fa fa-times" aria-hidden="true" style="cursor: pointer" onclick="hideSort()"></i>
    </div>
    <div class="titleSpan">
        <span>مرتب سازی بر اساس</span>
    </div>

    <div class="theBestThing">
        <div class="col-lg-4 col-md-4 ">
            <select class="form-controlcc" id="sort-mobile" name="sort" onchange="getProductByParam()">
                <option value="t1.id">جدیدترین</option>
                <option value="t1.num_visit">پر بازدیدترین</option>
                <option value="t1.special">پیشنهاد ویژه</option>
            </select>
        </div>
    </div>
    <div class="reduceIncrease">
        <div class="col-lg-4 col-md-4">
            <select class="form-controlcc" id="sort-type-mobile" name="sort_type" onchange="getProductByParam()">
               <option value="DESC">نزولی</option>
               <option value="ASC">صعودی</option>
            </select>
        </div>
    </div>
    <div class="ordering" onclick="hideSort()">
        <span>اعمال مرتب سازی</span>
    </div>
</div>

<div id="filterMain">
    <div class="topTitle">
        <h4><?= $title ?></h4>
        <i class="fa fa-times" aria-hidden="true" onclick="hideFilter()" style="cursor: pointer" ></i>
    </div>
    <div class="tabProduct">
    <div class="tab">
        <button class="tablinks" onclick="openCity(event, 'London')">سازنده</button>
        <button class="tablinks" onclick="openCity(event, 'Paris')">رنگ</button>
    </div>

    <div id="London" class="tabcontent">
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
    </div>

    <div id="Paris" class="tabcontent">
        <div>
            <ul class="brand-ul">
                <?php
                foreach ($colors AS $data) {
                    ?>
                    <li>
                        <input type="checkbox" onchange="getProductByParam()" name="color"
                               value="<?= $data['id'] ?>" id="color<?= $data['id'] ?>"
                               class="checkbox checkColor">
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
    <label class="switch">
        <span>نمایش کالاهای موجود</span>
        <input class="switch-input" type="checkbox" id="sale_status_mobile" name="sale_status"
               onchange="getProductByParam()" value="enabled">
        <span class="slider round switch-label" data-on="بله" data-off="خیر"></span>
    </label>
    <div class="filtering" onclick="hideFilter()">
        <span>اعمال فیلتر</span>
    </div>

</div>
</div>
-->
<style>
    .site-main.product-set-opt.catProduct.dir-rtl{
        background-color: #fff;
    }
</style>
<script>
    function openCity(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }
</script>

<script>
    function showFilter() {

        document.getElementById("filterMain").style.left = "0px";
    }
    /* Set the width of the side navigation to 0 */
    function hideFilter() {
        document.getElementById("filterMain").style.left = "-999px";

    }

    function showSort() {
        document.getElementById("sortMain").style.right = "0px";
    }

    /* Set the width of the side navigation to 0 */
    function hideSort() {
        document.getElementById("sortMain").style.right = "-999px";
    }
</script>

<!--        end for owl-curouser...................-->
</body>

</html>

