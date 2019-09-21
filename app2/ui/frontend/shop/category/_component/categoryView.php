<?php

class categoryView extends \f\view
{

    public function __construct()
    {

    }

    public function renderGetCategoryList($param)
    {
        $param['show_index'] ="enabled";
        $categoryList = \f\ttt::dal('shop.category.getCategoryListFront', $param, true);
        return $this->render('categoryList',
            array('categoryList' => $categoryList));
    }
}
