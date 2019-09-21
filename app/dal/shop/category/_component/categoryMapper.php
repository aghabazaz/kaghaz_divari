<?php

class categoryMapper extends \f\dal
{

    public $sqlEngine;
    private $dataTable;
    private $category_tbl = 'shop_category';
    private $category_feature_tbl = 'shop_category_feature';
    private $product_tbl = 'shop_product';
    private $shop_brand = 'shop_brand';
    private $ratingOptions_tbl = 'shop_rating_options';

    public function __construct()
    {
        $this->sqlEngine = new \f\sqlStorageEngine;
        $this->dataTable = \f\dalFactory::make('core.dataTable');
    }

    public function categoryList()
    {
        $pr = $this->request->getAssocParams();
        $requestDataTable = $pr['dataTableParams'];
        $columns = array(
            array(
                'db' => 't1.id', //column name selected
                'dt' => 0, //column num
            ),
            array(
                'db' => 't1.title',
                'dt' => 1,
            ),
            array(
                'db' => 't1.status',
                'dt' => 2,
            ),
            array(
                'db' => 't1.special',
                'dt' => 3,
            ),
        );
        $ownerId = \f\ttt::service('core.auth.getUserOwner');

        $whereJoin = array(
            "t1.owner_id=" . $ownerId);

        $result = array(
            'requestDataTble' => $requestDataTable,
            'tableName' => $this->category_tbl . ' AS t1',
            'primaryKey' => $this->category_tbl . '.id',
            'columnsArray' => $columns,
            'tableJoinName' => $tbjoins = array(),
            'whereJoin' => $whereJoin
        );
        $out = $this->dataTable->getDataTable($result);
        return $out;
    }

    public function getRatingOptions()
    {
        $this->sqlEngine->Select()
            ->From($this->ratingOptions_tbl . ' AS t1')
            ->Where('status=?', 'enabled')
            ->OrderBy('title ASC')
            ->Run();
        //\f\pre($this->sqlEngine->getRows());
        return $this->sqlEngine->getRows();
    }

    public function getCategorySpecial()
    {
        $this->sqlEngine->Select('*')
            ->From($this->category_tbl . ' AS t1')
            ->Where('special=?', 'enabled')
            ->OrderBy('id DESC')
            ->Limit('6')
            ->Run();
        return $this->sqlEngine->getRows();
    }

    public function categorySave()
    {
        $params = $this->request->getAssocParams();

        if(array_key_exists('dynamic',$params)=='true'){
            $dynamic='true';
        }else{
            $dynamic='false';
        }
       // \f\pre($dynamic);
        $params['owner_id'] = \f\ttt::dal('core.auth.getUserOwner');
        $params['picture'] = $params['picture'] ? $params['picture'] : NULL;
        $params['parent_id'] = $params['parent_id'] ? $params['parent_id'] : NULL;
        $params['date_register'] = time();
        $discount = str_replace(',', '',$params['discount']);
        $result = $this->sqlEngine->save($this->category_tbl,
            array(
                'owner_id' => $params['owner_id'],
                'title' => $params['title'],
                'buy_btn' => $params['buy_btn'],
                'show_index' => $params['show_index'],
                'parent_id' => $params['parent_id'],
                'title_en' => $params['title_en'],
                'picture' => $params['picture'],
                'rating_options' => json_encode($params['rating_options']),
                'date_register' => $params['date_register'],
                'discount'=>$discount,
                'dynamic'=>$dynamic
            )
        );

        //\f\pr($params);
       // \f\pre($this->sqlEngine->last_query());
        for ($i = 0; $i < count($params['feature_id']); $i++) {

            $this->sqlEngine->save($this->category_feature_tbl,
                array(
                    'shop_category_id' => $result,
                    'shop_feature_id' => $params['feature_id'][$i],
                    'priority' => $i + 1
                )
            );
        }
        return $result;
    }

    public function categorySaveEdit()
    {
        $params = $this->request->getAssocParams();

        if(array_key_exists('dynamic',$params)=='true'){
            $dynamic='true';
        }else{
            $dynamic='false';
        }

        $id = $params['id'];
        unset ($params['id']);
        $params['picture'] = $params['picture'] ? $params['picture'] : NULL;
        $params['parent_id'] = $params['parent_id'] ? $params['parent_id'] : NULL;
        $discount = str_replace(',', '',$params['discount']);
        $result = $this->sqlEngine->save($this->category_tbl,
            array(
                'title' => $params['title'],
                'buy_btn' => $params['buy_btn'],
                'show_index' => $params['show_index'],
                'parent_id' => $params['parent_id'],
                'title_en' => $params['title_en'],
                'picture' => $params['picture'],
                'rating_options' => json_encode($params['rating_options']),
                'discount'=>$discount,
                'dynamic'=>$dynamic
                //'type_discount'=>$params['type_discount']
            ),
            array(
                'id=?',
                array(
                    $id)
            )
        );
        $this->sqlEngine->Select('id')
            ->From($this->category_feature_tbl . ' AS t1')
            ->Where('t1.shop_category_id=?', $id)
            ->Run();

        $row = $this->sqlEngine->getRows();
        foreach ($row AS $data) {
            $curParam[] = $data['id'];
        }
        for ($i = 0; $i < count($params['feature_id']); $i++) {

            $pid = $params['idFeature'][$i];
            if (in_array($pid, $curParam)) {
                if ($params['feature_id'][$i]) {
                    $this->sqlEngine->save($this->category_feature_tbl,
                        array(
                            'shop_category_id' => $id,
                            'shop_feature_id' => $params['feature_id'][$i],
                            'priority' => $i + 1
                        ),
                        array(
                            'id=?',
                            array(
                                $pid))
                    );
                    unset ($curParam[array_search($pid, $curParam)]);
                }


            } else {
                $this->sqlEngine->save($this->category_feature_tbl,
                    array(
                        'shop_category_id' => $id,
                        'shop_feature_id' => $params['feature_id'][$i],
                        'priority' => $i + 1
                    )
                );
            }
        }
        $curParamStr = implode(',', $curParam);

        $this->sqlEngine->remove($this->category_feature_tbl,
            array(
                "id IN ($curParamStr)"
            ));

        return $result;
    }

    public function categoryDelete()
    {
        $param = $this->request->getAssocParams();
        $id = $param['id'];
        $this->sqlEngine->remove($this->category_tbl,
            array(
                'id=?',
                array(
                    $id)));

        return array(
            'result' => 'success',
            'func' => 'remove');
    }

    public function categoryStatus()
    {
        $param = $this->request->getAssocParams();
        $id = $param['id'];
        $status = $param['status'] == 'enabled' ? 'disabled' : 'enabled';

        $this->sqlEngine->save($this->category_tbl,
            array(
                'status' => $status
            ),
            array(
                'id=?',
                array(
                    $id)));

        return array(
            'result' => 'success',
            'status' => $status,
            'id' => $id,
            'func' => 'status');
    }

    public function getCategoryById()
    {
        $param = $this->request->getAssocParams();
        $this->sqlEngine->Select()
            ->From($this->category_tbl . ' AS t1')
            ->Where('t1.id=?', $param['id'])
            ->Run();
        return $this->sqlEngine->getRow();
    }

    public function getBrandByCategory()
    {
        $param = $this->request->getAssocParams();
        $this->sqlEngine->Select('t3.id,t3.title_fa,t3.title_en')
            ->From($this->product_tbl . ' AS t2')
            ->Join($this->shop_brand . ' AS t3')
            ->Where('t2.shop_category_id=?', $param['categotyId'])
            ->andWhere('t2.shop_brand_id = t3.id')
            ->GroupBy('t3.id')
            ->OrderBy('title_fa ASC')
            ->Run();
        //\f\pre($this->sqlEngine->getRows());
        return $this->sqlEngine->getRows();
    }

    public function getCategoryByOwnerId()
    {
        $ownerId = \f\ttt::dal('core.auth.getUserOwner');

        if (!$ownerId) {
            $ownerId = \f\ttt::dal('core.auth.getOwnerFront');
        }

        $this->sqlEngine->Select()
            ->From($this->category_tbl . ' AS t1')
            ->Where('t1.owner_id=?', $ownerId)
            ->andWhere('status=?', 'enabled')
            ->OrderBy('title ASC')
            ->Run();
      //  \f\pre( $this->sqlEngine->getRows());
        return $this->sqlEngine->getRows();
    }

    public function getFeatureByCatId()
    {
        $params = $this->request->getAssocParams();
        $this->sqlEngine->Select()
            ->From($this->category_feature_tbl . ' AS t1')
            ->Where('t1.shop_category_id=?', $params['id'])
            ->OrderBy('priority ASC')
            ->Run();
        return $this->sqlEngine->getRows();
    }

    public function getProductCatsByAjaxSearch()
    {
        $param = $this->request->getAssocParams();
        $this->sqlEngine->Select('id,title,title_en')
            ->From($this->category_tbl)
            ->Where('status=?', 'enabled')
            ->andWhere("title LIKE '%" . $param['keyword'] . "%'")
            ->orWhere("title_en LIKE '%" . $param['keyword'] . "%'");
        $this->sqlEngine->OrderBy('id DESC');
        if ($param['limit']) {
            $this->sqlEngine->Limit($param['limit']);
        }
        $this->sqlEngine->Run();

        return $this->sqlEngine->getRows();
    }

    public function getCategoryByParam()
    {
        $param = $this->request->getAssocParams();
        if ($param['selects']) {
            $select = $param['selects'];
        } else {
            $select = '*';
        }
        $this->sqlEngine->Select($select)
            ->From($this->category_tbl . ' AS t1')
            ->Where(1);
        if ($param['title_en']) {
            $this->sqlEngine->andWhere('t1.title_en=?', $param['title_en']);
        }
        if ($param['id']) {
            $this->sqlEngine->andWhere('t1.id=?', $param['id']);
        }
        $this->sqlEngine->Run();
       // \f\pre($this->sqlEngine->getRows());
        return $this->sqlEngine->getRow();
    }

    public function getCategoryProductByParam()
    {
        $param = $this->request->getAssocParams();
        //\f\pre($param);
        if ($param['selects']) {
            $select = $param['selects'];
        } else {
            $select = '*';
        }
        $this->sqlEngine->Select($select)
            ->From($this->category_tbl . ' AS t1')
            ->Where(1);
        if ($param['title_en']) {
            $this->sqlEngine->andWhere('t1.title_en=?', $param['title_en']);
        }
        if ($param['id']) {
            $this->sqlEngine->andWhere('t1.id=?', $param['id']);
        }
        $this->sqlEngine->Run();
        return $this->sqlEngine->getRow();
    }

    public function categorySpecial()
    {
        $param = $this->request->getAssocParams();
        $id = $param['id'];
        $status = $param['status'] == 'enabled' ? 'disabled' : 'enabled';

        $this->sqlEngine->save($this->category_tbl,
            array(
                'special' => $status
            ),
            array(
                'id=?',
                array(
                    $id)));

        return array(
            'result' => 'success',
            'status' => $status,
            'id' => $id,
            'func' => 'special');
    }

    public function getCategoryListFront()
    {
        $param = $this->request->getAssocParams();
        $this->sqlEngine->Select('t1.id,t1.title,t1.title_en,t1.picture')
            ->From($this->category_tbl . ' AS t1')
            ->Where("t1.status='enabled'");
        if ($param['show_index']) {
            $this->sqlEngine->andWhere('t1.show_index=?', $param['show_index']);
        }
        if ($param['picture']) {
            $this->sqlEngine->andWhere('t1.picture IS NOT NULL');
        }
        $this->sqlEngine->OrderBy('rand()')
            ->Limit($param['limit'])
            ->Run();
        return $this->sqlEngine->getRows();
    }

    public function getCategoryListForApp()
    {
        $param = $this->request->getAssocParams();
        $this->sqlEngine->Select('t1.id,t1.title,t1.title_en,t1.picture')
            ->From($this->category_tbl . ' AS t1')
            ->Where('t1.status=?', 'enabled')
            ->andWhere('t1.parent_id is NULL')
            ->OrderBy('rand()')
            ->Run();
        return $this->sqlEngine->getRows();
    }

}
