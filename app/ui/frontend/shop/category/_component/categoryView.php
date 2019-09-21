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
    public function renderGetCategoryPro(){
        $specialCategory = \f\ttt::service('shop.category.getCategorySpecial');
        foreach ($specialCategory AS $item){
            $catSp[] = $item['id'];
        }
        $catSearchId = implode(",",$catSp);
        $Category = \f\ttt::service('shop.category.getCategoryByParam');
        $child = array();
        foreach ($specialCategory AS $data) {
            $this->getChildCategory($Category, $data['id'],
                $child[$data['id']]);
            $title[$data['id']] = $data['title'];
        }
        foreach ($child as $key => $item) {
            if (empty($item)) {
                $item[] = $key;
            }else{
                array_push($item ,$key);
            }
            $moreCar[$key] = $item;
        }

        foreach($moreCar AS $key => $value){
            $cat = implode(",",$value);
            $proCat[] = array( 'product' =>  \f\ttt::service('shop.product.getNewOneProduct',
                array('categoryId' => $cat)) , 'catId' => $key );
        }

        $userInfo = \f\ttt::dal ( 'member.getMemberById',array('id' =>$_SESSION['user_id'])) ;

        $catTitle=array_column($specialCategory,'title_en','id');

        $newPro .= $this->render('categoryList',
            array(
                'newProducts' => $proCat,
                'userInfo' => $userInfo,
                'specialCategory' => $specialCategory,
                'catTitle'=>$catTitle
            ));
        //\f\pre($newPro);
        return $newPro;

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
    public function renderGetCategorySpecial(){
        $specialCategory = \f\ttt::service('shop.category.getCategorySpecial');
        $specialCat = $this->render('specialCategory',
            array(
                'specialCategory' => $specialCategory,
            ));

        return $specialCat;
    }
}
