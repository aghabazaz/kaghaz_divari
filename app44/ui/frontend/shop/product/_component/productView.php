<?php

class productView extends \f\view
{

    public function __construct()
    {

    }

    public function renderConcessionProduct($params)
    {
        if ($params[0] == 'page') {
            $page = $params[1];
        }
        $numPerPage = 100;
        if (!$page) {
            $page = 1;
        }
        $this->registerGadgets(array(
            'dateG' => 'date'));
        $todayDate = $this->dateG->today();
        $array = \f\ttt::service('shop.product.getAmazingProducts',
            array(
                'today' => $todayDate,
                'numPerPage' => $numPerPage,
                'page' => $page
            ));
        $sRow['title'] = 'تخفیفی ها';
        $row = $array[0];
        $num = $array[1];
        $content = $this->render('product',
            array(
                'ConcessionProduct' => $row,
                'num' => $num,
                'num_page' => $numPerPage,
                'page' => $page,
                'sRow' => $sRow,
            ));
        return array(
            $content,
            $sRow);
    }

    public function renderBrandsProduct($param)
    {
        if ($param[2] == 'page') {
            $page = $param[3];
        }
        $numPerPage = 12;

        if (!$page) {
            $page = 1;
        }

        $sRow['title'] = 'محصولات انتخابی';

        $brandId = $param['1'];
        $array = \f\ttt::service('shop.product.getProductByBrandId',
            array(
                'status' => 'enabled',
                'page' => $page,
                'numPerPage' => $numPerPage,
                'id' => $brandId
            ), true);

        $getBrand = \f\ttt::service('shop.brand.getBrandById',
            array(
                'status' => 'enabled',
                'id' => $brandId
            ), true);

        $row = $array[0];
        $num = $array[1];

        $content = $this->render('selectiveProduct',
            array(
                'row' => $row,
                'num_page' => $numPerPage,
                'num' => $num,
                'page' => $page,
                'brand' => $getBrand,
                'title' => $getBrand['title_fa']
            ));

        return array(
            'view'=>$content,
            'sRow'=>$sRow,
            'title' => $getBrand['title_fa']
            );
    }

    public function renderGiftsProduct($param)
    {
        if ($param[1] == 'page') {
            $page = $param[2];
        }
        $numPerPage = 10;

        if (!$page) {
            $page = 1;
        }
        $sRow['title'] = 'هدایای تبلیغاتی';

        $array = \f\ttt::service('shop.product.getGiftsProduct',
            array(
                'status' => 'enabled',
                'page' => $page,
                'numPerPage' => $numPerPage,
            ), true);
        $row = $array[0];
        $num = $array[1];

        $content = $this->render('giftsProduct',
            array(
                'row' => $row,
                'num_page' => $numPerPage,
                'num' => $num,
                'page' => $page,
                'brand' => $getBrand,
            ));

        return array(
            $content,
            $sRow);
    }

    public function renderGetProductDetail($params)
    {
        $id = $params[0];
        \f\ttt::service('shop.product.setProductVisit',
            array(
                'id' => $id
            )
        );
        if(!empty($_SESSION['user_id'])){
            $user_type=\f\ttt::dal('member.getUserType',
                array(
                    'user_id' => $_SESSION['user_id']
                )
            );
            $_SESSION['type_user']=$user_type['type_user'];
        }
        $relatedPro = \f\ttt::service('shop.product.getRelatedProductById',
            array(
                'id' => $id,
                'status' => 'enabled'
            )
        );

        $row = \f\ttt::service('shop.product.getProductById',
            array(
                'id' => $id
            ));
        $this->registerGadgets(array(
            'dateG' => 'date'));
        $today = $this->dateG->today();
        $amazingId = \f\ttt::service('shop.amazing.checkAmazingByProductId',
            array(
                'id' => $row['id'],
                'today' => $today,
            ));
       // \f\pr($row);
        $catId = \f\ttt::service('shop.category.getCategoryByParam',
            array(
                'selects' => 'id,title,parent_id,buy_btn,title_en,dynamic',
                'id' => $row['shop_category_id']
            ));
        $buyLicense = $catId[0]['buy_btn'];
        //get parent Category
        $parentsCat = $this->sortByCatIdBreadcrumbs($catId[0], $sort_category);
        $keys = array_keys($parentsCat);
        $values = array_values($parentsCat);
        $reverseArrValue = array_reverse($values);
        $reverseArrKey = array_reverse($keys);
        $sort_path_cat = array_combine($reverseArrKey, $reverseArrValue);
        $brandId = \f\ttt::service('shop.brand.getBrandByParam',
            array(
                'selects' => 'id,title_fa,title_en',
                'id' => $row['shop_brand_id']
            ));
        //get Features product by cat_id and id product
        $wiki = \f\ttt::service('shop.wiki.getWikiByOwnerId');
        foreach ($wiki AS $data) {
            $wikiArr[$data['id']] = $data['title'];
        }
        $pFeature = \f\ttt::service('shop.product.getFeatureByProductId',
            array(
                'id' => $row['id']
            ));
        foreach ($pFeature AS $data) {
            $pfValue[$data['shop_feature_item_id']] = json_decode($data['value'],
                TRUE);
        }
        //send last cat 
        foreach ($sort_path_cat AS $data) {
            $features[] = \f\ttt::service('shop.product.getFeatureByCatId',
                array(
                    'id' => $data['id']
                ));
        }
        $colors = \f\ttt::service('shop.color.getColorsGuranteeByProductIdWidthoutPrice',
            array(
                'product_id' => $row['id'],
            ));
        $brandId = \f\ttt::service('shop.brand.getBrandByParam',
            array(
                'selects' => 'id,title_fa,title_en,discount,type_discount',
                'id' => $row['shop_brand_id'],
                'today'=>$today
            ));
        $picture = \f\ttt::service('core.fileManager.getList',
            array(
                'path' => 'shop.product.' . $id,
            ));
        foreach ($picture['list'] AS $data) {
            if ($data['type'] == 'file') {
                $picArr[$data['id']]['title'] = $data['title'];
                $picArr[$data['id']]['path'] = $this->filePath($data['path']);
            }
        }
        $ratingOptions = \f\ttt::service('shop.ratingOptions.getRatingOptionsById',
            array(
                'id' => $id
            ));
        $ratingValue = json_decode($ratingOptions['rating_options']);
        $ratingTitle = \f\ttt::service('shop.ratingOptions.getRatingTitleById',
            array(
                'ratingValue' => $ratingValue
            ));
        foreach ($ratingTitle AS $data) {
            $arrRatingTitle[$data['id']] = $data['title'];
        }
        $ratingValues = \f\ttt::service('shop.ratingOptions.getAVGRatingByProductId',
            array(
                'product_id' => $id
            ));
        foreach ($ratingValues AS $data) {
            $arrRatingValue[$data['option_id']] = round($data['rate_avg'],
                1);
        }
        $productComments = \f\ttt::service('shop.comment.getCommentByProductId',
            array(
                'product_id' => $id,
                'status' => 'enabled',
                'multi' => 'true'
            ));

        $i = 0;
        foreach ($productComments AS $data) {
            foreach ($productComments AS $data2) {
                $arrComment[$data[$i]['id']] = $data[$i];
                $arrComment[$data[$i]['id']]['tip'] = $productComments[1][$i];

                foreach ($arrComment[$data[$i]['id']]['tip'] as $data3) {
                    if ($data3['type'] == 'weakness') {
                        $arrComment[$data[$i]['id']]['weakness'][$data3['id']] = $data3['title'];
                    } else {
                        $arrComment[$data[$i]['id']]['strenght'][$data3['id']] = $data3['title'];
                    }
                }
                unset ($arrComment[$data[$i]['id']]['tip']);
                $arrComment[$data[$i]['id']]['rating'] = $productComments[2][$i];
                foreach ($arrComment[$data[$i]['id']]['rating'] AS $data4) {
                    $arrComment[$data[$i]['id']]['rate'][$data4['option_id']] = round($data4['rate_avg'],
                        1);
                }
                unset ($arrComment[$data[$i]['id']]['rating']);
                $i++;
            }
        }
        //when we dont have any garranty
        $priceId=\f\ttt::dal('shop.product.getStockByProductId',
            array(
                'product_id' => $id,
            ));

        $stockProductGift=\f\ttt::dal('shop.product.getStockOfGift',$row);

     // \f\pre($catId);
        if($catId['dynamic']=='true'){
            $material= \f\ttt::service('shop.material.getMaterial',
                array(
                    'product_id' => $row['id'],
                ));
            $materialArray=array_column($material,'name','id');

            $priceForProduct=\f\ttt::dal('shop.product.getPriceByProductId',
                array(
                    'product_id' => $id,
                ));

            $content = $this->render('detailProductDynamic',
                array(
                    'row' => $row,
                    'picture' => $picArr,
                    'category' => $catId,
                    'brandDiscount' => $brandId['discount'],
                    'brandDiscountType' => $brandId['type_discount'],
                    'brandTitle' => $brandId['title_fa'],
                    'sortCat' => $sort_path_cat,
                    'colors' => $colors,
                    'feature' => $features,
                    'wiki' => $wikiArr,
                    'value' => $pfValue,
                    'amazing' => $amazingId,
                    'ratingTitle' => $arrRatingTitle,
                    'arrRatingValue' => $arrRatingValue,
                    'comments' => $arrComment,
                    'relarenderCustomProductRequestGridtedPro' => $relatedPro,
                    'buyLicense' => $buyLicense,
                    'priceId' => $priceId['id'],
                    'stockGifts' => $stockProductGift['stockGift'],
                    'priceList'=>$priceForProduct,

                ));
        }else{
            $content = $this->render('detailProduct',
                array(
                    'row' => $row,
                    'picture' => $picArr,
                    'category' => $catId,
                    'brandDiscount' => $brandId['discount'],
                    'brandDiscountType' => $brandId['type_discount'],
                    'brandTitle' => $brandId['title_fa'],
                    'sortCat' => $sort_path_cat,
                    'colors' => $colors,
                    'feature' => $features,
                    'wiki' => $wikiArr,
                    'value' => $pfValue,
                    'amazing' => $amazingId,
                    'ratingTitle' => $arrRatingTitle,
                    'arrRatingValue' => $arrRatingValue,
                    'comments' => $arrComment,
                    'relatedPro' => $relatedPro,
                    'buyLicense' => $buyLicense,
                    'priceId' => $priceId['id'],
                    'stockGifts' => $stockProductGift['stockGift']
                ));
        }

        return array(
            $content,
            $row,
            $catId['dynamic'],
            array());
    }


    public function renderGetProductDetailMobile($params)
    {
        $id = $params[0];
        \f\ttt::service('shop.product.setProductVisit',
            array(
                'id' => $id
            )
        );
        $row = \f\ttt::service('shop.product.getProductById',
            array(
                'id' => $id
            ));
        $this->registerGadgets(array(
            'dateG' => 'date'));
        $today = $this->dateG->today();
        $amazingId = \f\ttt::service('shop.amazing.checkAmazingByProductId',
            array(
                'id' => $row['id'],
                'today' => $today,
            ));
        $catId = \f\ttt::service('shop.category.getCategoryByParam',
            array(
                'selects' => 'id,title,parent_id,title_en',
                'id' => $row['shop_category_id']
            ));

        //get parent Category
        $parentsCat = $this->sortByCatIdBreadcrumbs($catId[0], $sort_category);
        $keys = array_keys($parentsCat);
        $values = array_values($parentsCat);
        $reverseArrValue = array_reverse($values);
        $reverseArrKey = array_reverse($keys);
        $sort_path_cat = array_combine($reverseArrKey, $reverseArrValue);
        //\f\pre($sort_path_cat);
        $brandId = \f\ttt::service('shop.brand.getBrandByParam',
            array(
                'selects' => 'id,title_fa,title_en',
                'id' => $row['shop_brand_id']
            ));
        //get Features product by cat_id and id product
        $wiki = \f\ttt::service('shop.wiki.getWikiByOwnerId');
        foreach ($wiki AS $data) {
            $wikiArr[$data['id']] = $data['title'];
        }
        $pFeature = \f\ttt::service('shop.product.getFeatureByProductId',
            array(
                'id' => $row['id']
            ));
        foreach ($pFeature AS $data) {
            $pfValue[$data['shop_feature_item_id']] = json_decode($data['value'],
                TRUE);
        }
        //send last cat
        foreach ($sort_path_cat AS $data) {
            $features[] = \f\ttt::service('shop.product.getFeatureByCatId',
                array(
                    'id' => $data['id']
                ));
        }
        $colors = \f\ttt::service('shop.color.getColorsGuranteeByProductIdWidthoutPrice',
            array(
                'product_id' => $row['id'],
            ));

        $picture = \f\ttt::service('core.fileManager.getList',
            array(
                'path' => 'shop.product.' . $id,
            ));
        foreach ($picture['list'] AS $data) {
            if ($data['type'] == 'file') {
                $picArr[$data['id']]['title'] = $data['title'];
                $picArr[$data['id']]['path'] = $this->filePath($data['path']);
            }

        }
        $ratingOptions = \f\ttt::service('shop.ratingOptions.getRatingOptionsById',
            array(
                'id' => $id
            ));
        $ratingValue = json_decode($ratingOptions['rating_options']);
        $ratingTitle = \f\ttt::service('shop.ratingOptions.getRatingTitleById',
            array(
                'ratingValue' => $ratingValue
            ));
        foreach ($ratingTitle AS $data) {
            $arrRatingTitle[$data['id']] = $data['title'];
        }
        $ratingValues = \f\ttt::service('shop.ratingOptions.getAVGRatingByProductId',
            array(
                'product_id' => $id
            ));
        foreach ($ratingValues AS $data) {
            $arrRatingValue[$data['option_id']] = round($data['rate_avg'],
                1);
        }

        $productComments = \f\ttt::service('shop.comment.getCommentByProductId',
            array(
                'product_id' => $id,
                'status' => 'enabled',
                'multi' => 'true'
            ));
        $i = 0;
        foreach ($productComments AS $data) {
            foreach ($productComments AS $data2) {
                $arrComment[$data[$i]['id']] = $data[$i];
                $arrComment[$data[$i]['id']]['tip'] = $productComments[1][$i];

                foreach ($arrComment[$data[$i]['id']]['tip'] as $data3) {
                    if ($data3['type'] == 'weakness') {
                        $arrComment[$data[$i]['id']]['weakness'][$data3['id']] = $data3['title'];
                    } else {
                        $arrComment[$data[$i]['id']]['strenght'][$data3['id']] = $data3['title'];
                    }
                }
                unset ($arrComment[$data[$i]['id']]['tip']);
                $arrComment[$data[$i]['id']]['rating'] = $productComments[2][$i];
                foreach ($arrComment[$data[$i]['id']]['rating'] AS $data4) {
                    $arrComment[$data[$i]['id']]['rate'][$data4['option_id']] = round($data4['rate_avg'],
                        1);
                }
                unset ($arrComment[$data[$i]['id']]['rating']);
                $i++;
            }
        }
        //when we dont have any garranty
        $priceId=\f\ttt::dal('shop.product.getStockByProductId',
            array(
                'product_id' => $id,
            ));
        $content = $this->render('detailProductMobile',
            array(
                'row' => $row,
                'picture' => $picArr,
                'category' => $catId,
                'brand' => $brandId,
                'sortCat' => $sort_path_cat,
                'colors' => $colors,
                'feature' => $features,
                'wiki' => $wikiArr,
                'value' => $pfValue,
                'amazing' => $amazingId,
                'ratingTitle' => $arrRatingTitle,
                'arrRatingValue' => $arrRatingValue,
                'comments' => $arrComment,
                'priceId'=>$priceId['id']
            ));

        return array(
            $content,
            $row,
            array());
    }

    public function filePath($path)
    {
        $path = \f\ifm::app()->siteUrl . 'upload/' . (str_replace('-', '.',
                str_replace('.',
                    '/',
                    $path)));
        return $path;
    }

    public function renderGetProduct($param)
    {
        $catIdArr = \f\ttt::service('shop.category.getCategoryProductByParam',
            array(
                'selects' => 'id,title,parent_id,title_en',
                'title_en' => $param[0]
            ));
        $catId = $catIdArr;
        //get parent Category
        $parentsCat = $this->sortByCatId($catId, $sort_category);
        $keys = array_keys($parentsCat);
        $values = array_values($parentsCat);
        $reverseArrValue = array_reverse($values);
        $reverseArrKey = array_reverse($keys);
        $sort_path_cat = array_combine($reverseArrKey, $reverseArrValue);
        if ($param[1]) {
            $brandId = \f\ttt::service('shop.brand.getBrandByParam',
                array(
                    'selects' => 'id,title_fa,title_en',
                    'title_en' => $param[1]
                ));
        }
        $brands = \f\ttt::service('shop.product.getBrandsByProductsCat',
            array(
                'cat_id' => $catId['id']
            ));

        $colors = \f\ttt::service('shop.color.getColorsByParam', array());

        $priceMax = \f\ttt::service('shop.product.getPriceMaxByCatId',
            array(
                'cat_id' => $catId['id']
            ));
        $priceMax = max($priceMax);
        return array('view'=>$this->render('productNew',
            array(
              //  'category' => $catId,
                'category' => $catId,
                'brand' => $brandId,
                'sortCat' => $sort_path_cat,
                'brands' => $brands,
                'colors' => $colors,
                'priceMax' => implode(",", $priceMax)
            )),'catId'=>$catId['id']);
    }



    public function renderGetProductOld($param)
    {
        $catIdArr = \f\ttt::service('shop.category.getCategoryByParam',
            array(
                'selects' => 'id,title,parent_id,title_en',
                'title_en' => $param[0]
            ));

        $catId = $catIdArr[0];
        //get parent Category
        $parentsCat = $this->sortByCatId($catId, $sort_category);
        $keys = array_keys($parentsCat);
        $values = array_values($parentsCat);
        $reverseArrValue = array_reverse($values);
        $reverseArrKey = array_reverse($keys);
        $sort_path_cat = array_combine($reverseArrKey, $reverseArrValue);
        if ($param[1]) {
            $brandId = \f\ttt::service('shop.brand.getBrandByParam',
                array(
                    'selects' => 'id,title_fa,title_en',
                    'title_en' => $param[1]
                ));
        }
        $brands = \f\ttt::service('shop.product.getBrandsByProductsCat',
            array(
                'cat_id' => $catId['id']
            ));

        $colors = \f\ttt::service('shop.color.getColorsByParam', array());

        $priceMax = \f\ttt::service('shop.product.getPriceMaxByCatId',
            array(
                'cat_id' => $catId['id']
            ));
        $priceMax = max($priceMax);
        return $this->render('product',
            array(
                'category' => $catId,
                'brand' => $brandId,
                'sortCat' => $sort_path_cat,
                'brands' => $brands,
                'colors' => $colors,
                'priceMax' => implode(",", $priceMax)
            ));
    }

    public function sortByCatId($catId, &$sort)
    {
        $sort[$catId['id']] = $catId; //save last id
        $parent_id = $catId['parent_id'];
        do {
            $category = \f\ttt::service('shop.category.getCategoryProductByParam',
                array(
                    'selects' => 'id,title,parent_id,title_en',
                    'id' => $parent_id
                ));
            $sort[$category['id']] = $category;
            $parent_id = $category['parent_id'];
        } while (!empty ($parent_id));
        return $sort;
    }

    public function sortByCatIdBreadcrumbs($catId, &$sort)
    {
        $sort[$catId['id']] = $catId; //save last id


        $parent_id = $catId['parent_id'];
        do {
            $category = \f\ttt::service('shop.category.getCategoryByParam',
                array(
                    'selects' => 'id,title,parent_id,title_en',
                    'id' => $parent_id
                ));
            $sort[$category[0]['id']] = $category[0];
            $parent_id = $category[0]['parent_id'];
        } while (!empty ($parent_id));
        return $sort;
    }

    public function renderCompare($param)
    {
        $count = count($param);
        $strProduct = '';
        for ($i = 0; $i < $count; $i++) {
            $strProduct .= $param[$i] . '/';
            $param[$i] = str_replace('RP-', '', $param[$i]);
        }

        $row = \f\ttt::service('shop.product.getCompareProductDetail',
            array(
                'id' => implode(',', $param)
            ));

        foreach ($row AS $data) {
            $arr[$data['id']] = $data;
        }
        for ($i = 0; $i < $count; $i++) {
            $sortArr[$i] = $arr[$param[$i]];
        }
        $catId = \f\ttt::service('shop.category.getCategoryProductByParam',
            array(
                'selects' => 'id,title,parent_id,title_en',
                'id' => $row[0]['shop_category_id']
            ));
        $categotyId = $catId['id'];
        $brandList = \f\ttt::service('shop.category.getBrandByCategory',
            array(
                'categotyId' => $categotyId
            ));


        $wiki = \f\ttt::service('shop.wiki.getWikiByOwnerId');
        foreach ($wiki AS $data) {
            $wikiArr[$data['id']] = $data['title'];
        }

        foreach ($row AS $data) {
            $pFeature[$data['id']] = \f\ttt::service('shop.product.getFeatureByProductId',
                array(
                    'id' => $data['id']
                ));
        }

        foreach ($pFeature AS $key => $data) {
            foreach ($data AS $subData) {
                $pfValue[$key][$subData['shop_feature_item_id']] = json_decode($subData['value'],
                    TRUE);
            }
        }
        $features = \f\ttt::service('shop.product.getFeatureByCatId',
            array(
                'id' => $catId['id']
            ));
        if ($features == '') {
            $features = '<div class="alert alert-warning"><i class="fa fa-warning"></i> هیچ مشخصات فنی برای محصول تعریف نشده است.</div>';
        }

        $num = $this->getNumByWidth();
        return $this->render('compare',
            array(
                'catId' => $catId,
                'brandList' => $brandList,
                'feature' => $features,
                'wiki' => $wikiArr,
                'value' => $pfValue,
                'row' => $sortArr,
                'count' => $count,
                'param' => $param,
                'strProduct' => $strProduct,
                'num' => $num
            ));
    }

    public function getNumByWidth()
    {
        $width = $_COOKIE['width'];
        if ($width <= 768) {
            return 2;
        } else if ($width <= 990) {
            return 3;
        } else {
            return 4;
        }
    }

    public function getProductByParam($params)
    {
        if ($params['mode'] == 'desktop') {
            $numPerPage = 20;
        } else {
            $numPerPage = 10;
        }

        $min = ($params['page'] - 1) * $numPerPage;
        $params['limit'] = "$min,$numPerPage";
        $array = \f\ttt::service('shop.product.getProductByParams',
            $params);
        $row = $array[0];
        $num = $array[1];

        return $this->render('productFrontListNew',
            array(
                'row' => $row,
                'num_page' => $numPerPage,
                'num' => $num,
                'page' => $params['page'],
                'mode' => $params['mode']
            ));
    }

    public function renderNewProducts($params)
    {
        $params['special'] = "enabled";
        $newProducts = \f\ttt::service('shop.product.getNewProduct',
            $params);
       //\f\pre($newProducts);
        return $this->render('newSpecial',
            array(
                'row' => $newProducts,
            ));
    }
    public function renderMostVisitProducts(){
        $params['special'] = "enabled";
        $newProducts = \f\ttt::service('shop.product.getMostVisit',
            $params);
        return $this->render('newSpecial',
            array(
                'row' => $newProducts,
            ));
    }
    public function renderNewProductsMobile($params)
    {

        $params['special'] = "enabled";
        $newProducts = \f\ttt::service('shop.product.getNewProduct',
            $params);
        return $this->render('newSpecialMobile',
            array(
                'row' => $newProducts,
            ));
    }

    public function renderMustVisit($params)
    {

        $params['special'] = "enabled";
        $mustVisitProduct = \f\ttt::service('shop.product.getMostVisitProduct',
            $params);
       // \f\pre($mustVisitProduct);
        return $this->render('mustVisit',
            array(
                'row' => $mustVisitProduct
            ));
    }

    public function renderMustSell($params)
    {

        $params['special'] = "enabled";
        $mustSell = \f\ttt::service('shop.product.getMustSell',
            $params);
        return $this->render('mustSell',
            array(
                'newProducts' => $mustSell
            ));
    }

    public function renderGetProductBestselling($params)
    {
        $bestsellingSetting = \f\ttt::service('shop.shopSetting.getSettings',
            array(
                'params' => array(//'bestselling' => 'bestselling'
                )
            ));
        $getNewProduct = \f\ttt::service('shop.product.getNewProduct',
            $params);

        return $this->render('newSpecial',
            array(
                'newProducts' => $bestsellingProducts
            ));
    }

    public function renderRateForm($params)
    {

        $ratingOptions = \f\ttt::service('shop.ratingOptions.getRatingOptionsById',
            array(
                'id' => $params,
            ));

        $productComment = \f\ttt::service('shop.comment.getCommentByProductId',
            array(
                'user_id' => $_SESSION['user_id'],
                'product_id' => $params,
            ));
        $commentStatus = $productComment[0]['status'];
        foreach ($productComment[1] as $data) {
            if ($data['type'] == 'weakness') {
                $arrTipWeak[$data['id']] = $data['title'];
            } else {
                $arrTipStrength[$data['id']] = $data['title'];
            }
        }
        $ratingValue = json_decode($ratingOptions['rating_options']);
        $ratingTitle = \f\ttt::service('shop.ratingOptions.getRatingTitleById',
            array(
                'ratingValue' => $ratingValue
            ));
        $rateOld = \f\ttt::service('shop.ratingOptions.getRatingOptionsByUserId',
            array(
                'user_id' => $_SESSION['user_id'],
                'product_id' => $params,
            ));
        if ($rateOld) {
            foreach ($rateOld AS $data) {
                $arrRateOld[$data['option_id']] = $data['rate'];
            }
        }

        return $this->render('rate',
            array(
                'ratingTitle' => $ratingTitle,
                'ratingOptions' => $ratingOptions,
                'rateOld' => $arrRateOld,
                'productComment' => $productComment[0],
                'arrTipWeak' => $arrTipWeak,
                'arrTipStrength' => $arrTipStrength,
                'commentStatus' => $commentStatus,
            ));
    }

    public function renderAmazingSlide($param)
    {
        $this->registerGadgets(array(
            'dateG' => 'date'));
        $todayDate = $this->dateG->today();

        $settings = \f\ttt::service ( 'cms.settings.getSettings' ) ;
        $amazingProducts = \f\ttt::service('shop.product.getAmazingProducts',
            array(
                'today' => $todayDate,
                'limit' => $param['limit']));
        if ( $_SESSION[ 'user_id' ] )
        {
            $basketRow             = \f\ttt::service ( 'shop.orderItem.getOrderItemByParamsCartSidebar',
                array (
                    'user_id' => $_SESSION[ 'user_id' ],
                    'status'  => 'cart',
                    'gift'=>'no'
                ) ) ;

            $sRow[ 'title' ] = 'سبد خرید' ;
        }

        //\f\pre($settings);
        return $this->render('amazingProducts',
            array(
                'amazingProducts' => $amazingProducts['0'],
                'basketBuy' => $basketRow,
                'picRepBasket'=>$settings['picBasketRep']
            ));
    }

    public function renderAmazingSlideMobile($param)
    {

        $this->registerGadgets(array(
            'dateG' => 'date'));
        $todayDate = $this->dateG->today();
        $amazingProducts = \f\ttt::service('shop.product.getAmazingProducts',
            array(
                'today' => $todayDate,
                'limit' => $param['limit']));

        return $this->render('amazingProductMobile',
            array(
                'amazingProducts' => $amazingProducts['0']
            ));
    }

    public function getNewOneProduct($params)
    {
        $specialCategory = \f\ttt::service('shop.category.getCategorySpecial');

        $amazingProduct=\f\ttt::dal('shop.amazing.getAllAmazingPro');

        $amazingProId=array_column($amazingProduct,'shop_product_id');
        $Category = \f\ttt::service('shop.category.getCategoryByParam');
        $child = array();
        foreach ($specialCategory AS $data) {
            $this->getChildCategory($Category, $data['id'],
                $child[$data['id']]);

            $title[$data['id']] = $data['title'];
        }
        $params['status'] = "enabled";
        $newP = "";

        foreach ($child AS $key => $val) {
            $params['categoryId'] = $key . ',' . implode(',', $val);
            $newOneProduct = \f\ttt::service('shop.product.getNewOneProduct',
                $params);

            $newP .= $this->render('newMobile',
                array(
                    'newProducts' => $newOneProduct,
                    'title' => $title[$key],
                    'amazingProId'=>$amazingProId
                ));
        }
        return $newP;
    }

    public function getNewMobileTablet($params)
    {
        $specialCategory = \f\ttt::service('shop.category.getCategorySpecial');
        $Category = \f\ttt::service('shop.category.getCategoryByParam');

        $child = array();

        foreach ($specialCategory AS $data) {
            $this->getChildCategory($Category, $data['id'],
                $child[$data['id']]);

            $title[$data['id']] = $data['title'];
        }
        $params['status'] = "enabled";

        $newP = "";
        foreach ($child AS $key => $val) {
            $params['categoryId'] = $key . ',' . implode(',', $val);

            $newOneProduct = \f\ttt::service('shop.product.getNewOneProduct',
                $params);
            // \f\pre($newOneProduct);
            $newP .= $this->render('newMobileTablet',
                array(
                    'newProducts' => $newOneProduct,
                    'title' => $title[$key]
                ));
        }

        return $newP;
    }

    //ok
    public function getMomentSuggest($params)
    {
        $specialCategory = \f\ttt::service('shop.momentSuggest.getMomentSuggest');

        return $specialCategory;
    }

    private function getChildCategory($category, $parentId, &$child)
    {
        foreach ($category AS $value) {

            if ($value['parent_id'] == $parentId) {
                $child[] = $value['id'];
                $this->getChildCategory($category, $value['id'], $child);
            }
        }

        return $child;
    }

    public function getRelatedProduct($params)
    {
        $params['status'] = "enabled";
        $newOneProduct = \f\ttt::service('shop.product.getRelatedProductById',
            $params);
        return $this->render('relatedProduct',
            array(
                'newProducts' => $newOneProduct,
            ));
    }

    public function renderGetGuranteesByColorId($params)
    {
        $gurantees = \f\ttt::service('shop.product.getGuranteesByColorId',
            $params);
        if ($gurantees != NULL) {
            $content = '';
            $selected = "selected='selected'";
            foreach ($gurantees AS $data) {
                $content .= '<option data-id="'.$data['id'].'" value="' . $data["gurantee_id"] . '" ' . $selected . '>' . $data["gurantee_title"] . '</option>';
                $selected = '';
            }
            if($_SESSION['type_user']=='normUser' || empty($_SESSION['type_user'])){
                foreach ($gurantees AS $data) {

                    $guranteesArr[$data['gurantee_id']] = $data['price'];
                    $guranteesArr['majorPrice'][$data['gurantee_id']] = $data['majorPrice'];
                    $guranteesArr['user_price'][$data['gurantee_id']] = $data['price'];
                    $guranteesArr['stock'][$data['gurantee_id']] = $data['stock'];
                    $guranteesArr['id'][$data['gurantee_id']] = $data['discount'];
                    $guranteesArr['idPrice'][$data['gurantee_id']] = $data['id'];
                    $guranteesArr['type_discount'][$data['gurantee_id']] = $data['type_discount'];
                }
            }

        } else {
            $guranteesArr = 'NULL';
        }
        $av=0;
        if(!empty($gurantees)){
            $av=$gurantees[0]['stock'];
        }
        return array(
            'content' => $content,
            'gurantee' => $guranteesArr,
            'countAvailable' => $av
        );
    }

    public function renderSendAddToCart($params)
    {
        $this->registerGadgets(array(
            'dateG' => 'date'));
        $params['today'] = $this->dateG->today();
        $params['user_id'] = $_SESSION['user_id'];
        $result = \f\ttt::service('shop.order.orderSave', $params);
        if (empty($result)) {
            $result = 'NULL';
        }
        return array(
            'result' => $result,
        );
    }

    public function renderSendAddToFavorite($params)
    {
        $this->registerGadgets(array(
            'dateG' => 'date'));
        $params['today'] = $this->dateG->today();
        $params['user_id'] = $_SESSION['user_id'];

        $result = \f\ttt::dal('shop.product.favoriteSave', $params);

        if($result>0){
            $_SESSION['like_count']=$_SESSION['like_count']+1;
        }
        if (!$result) {
            $result = 'NULL';
        }
        return array(
            'result' => $result,

        );
    }
    public function renderGetSpecialCategory(){
        $this->registerGadgets(array(
            'dateG' => 'date'));
        $todayDate = $this->dateG->today();
        $amazingProducts = \f\ttt::service('shop.product.getAmazingProducts',
            array(
                'today' => $todayDate,
            ));

       // \f\pre($amazingProducts);
        if(!empty($amazingProducts[0])){
            $resultShow=true;
        }else{
            $resultShow=false;
        }
        $params['today']=$todayDate;
        $row           = \f\ttt::dal('shop.category.getCategorySpecial',
            $params,true );
        return $this->render('specialCategory',
            array(
                'row'=>$row,
                'resultShow' => $resultShow
            ));
    }

}
