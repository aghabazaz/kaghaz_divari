<?php

class productMapper extends \f\dal
{

    public $sqlEngine;
    private $dataTable;
    private $product_tbl = 'shop_product';
    private $product_related_tbl = 'shop_product_related';
    private $product_gift_tbl = 'shop_product_gift';
    private $product_feature_tbl = 'shop_product_feature';
    private $product_price_tbl = 'shop_product_price';
    private $product_price_history_tbl = 'shop_product_price_history';
    private $shop_amazing = 'shop_amazing';
    private $shop_favorite_product_tbl = 'shop_favorite_product';

    public function __construct()
    {
        $this->sqlEngine = new \f\sqlStorageEngine;
        $this->dataTable = \f\dalFactory::make('core.dataTable');
    }

    public function productList()
    {
        $pr = $this->request->getAssocParams();
        //\f\pre();
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
                'db' => 't2.title AS catTitle',
                'dt' => 2,
            ),
            array(
                'db' => 't1.status',
                'dt' => 3,
            ),
            array(
                'db' => 't1.special',
                'dt' => 4,
            ),
        );
        $ownerId = \f\ttt::service('core.auth.getUserOwner');

        $whereJoin = array(
            "t1.owner_id=" . $ownerId);

        $result = array(
            'requestDataTble' => $requestDataTable,
            'tableName' => $this->product_tbl . ' AS t1',
            'primaryKey' => 't1.id',
            'columnsArray' => $columns,
            'joinType' => 'left',
            'groupBy' => 't1.id',
            'onJoin' => array(
                't1.shop_category_id=' . 't2.id'),
            'tableJoinName' => $tbjoins = array(
                'shop_category AS t2'),
            'whereJoin' => $whereJoin
        );

        $out = $this->dataTable->getDataTable($result);
        return $out;
    }

    public function productSave()
    {
        $params = $this->request->getAssocParams();
        $params['owner_id'] = \f\ttt::dal('core.auth.getUserOwner');
        $params['picture'] = $params['picture'] ? $params['picture'] : NULL;
        $params['brand'] = $params['brand'] ? $params['brand'] : NULL;
        $params['date_register'] = time();
        $result = $this->sqlEngine->save($this->product_tbl,
            array(
                'owner_id' => $params['owner_id'],
                'title' => $params['title'],
                'sub_title' => $params['sub_title'],
                'shop_brand_id' => $params['brand'],
                'shop_category_id' =>str_replace('"','',str_replace(']','',str_replace('[','',json_encode($params['category'])))),
                'short_explanation' => $params['short_explanation'],
                //'dynamic'=>$params['dynamic'],
              //  'content' => $params['content'],
            //    'video' => $params['video'],
              // 'gifts' => $params['gifts'],
                'picture' => $params['picture'],
                'related' => json_encode($params['related']),
                'date_register' => $params['date_register'],
                'date_update' => $params['date_register'],
                'n_buy'=>($params['n_buy']==''?NULL:$params['n_buy']),
                'm_free'=>($params['m_free']==''?NULL:$params['m_free']),
                'shop_product_gift_id' => ($params['shop_product_gift_id']==''?NULL:$params['shop_product_gift_id']),
                'review' => $params['review'],
                'gift_text'=>($params['gift_text']==''?NULL:$params['gift_text']),
                'active_gift_section'=>$params['active_gift_section']
            )
        );
//\f\pr($result);
      //  \f\pre($this->sqlEngine->last_query());
        $id = $result;
        //save price products
        $time = time();
     //  \f\pre($params);
        for ($i = 0; $i < count($params['price']); $i++) {
            //\f\pre ( $params[ 'price' ]  ) ;
            $stock = str_replace(',', '', $params['stock'][$i]);
            $price = str_replace(',', '', $params['price'][$i]);
            $majorPrice = str_replace(',', '', $params['majorPrice'][$i]);
            $user_price = str_replace(',', '', $params['user_price'][$i]);
            $discount = str_replace ( ',', '', $params[ 'discount' ][ $i ] ) ;
            //\f\pre($majorPrice);
            if($params['typeCat']=='true'){
                $dynamic='true';
            }else{
                $dynamic='false';
            }

            $this->sqlEngine->save($this->product_price_tbl,
                array(
                    'shop_product_id' => $id,
                    'color_id' => $params['color'][$i],
                    'guarantee_id' => $params['guarantee'][$i],
                    'material_id' => $params['material'][$i],
                    'stock' => $stock,
                    'price' => $price,
                    'majorPrice' => $majorPrice,
                    'user_price' => $user_price,
                    'discount' => $discount,
                    'type_discount' => $params['type_discount'][$i],
                    'dynamic'=>$dynamic
                    ));
            //\f\pr($params);
            //\f\pre();
           /* \f\pr($id);
            \f\pr($params['color'][$i]);
            \f\pr($params['guarantee'][$i]);
            \f\pr($params['material'][$i]);
            \f\pr($stock);
            \f\pr($price);
            \f\pr($majorPrice);

            \f\pr($user_price);
            \f\pr($discount);
            \f\pr($params['type_discount'][$i]);

            \f\pr($this->sqlEngine->last_query());*/
            $this->sqlEngine->save($this->product_price_history_tbl,
                array(
                    'shop_product_id' => $id,
                    'color_id' => $params['color'][$i],
                    'guarantee_id' => $params['guarantee'][$i],
                   // 'material_id' => $params['material'][$i],
                    'stock' => $stock,
                    'price' => $price,
                    'discount' => $discount,
                    'date_register' => $time,
                    'type_discount' => $params['type_discount'][$i],
                ));
          //  \f\pr($params);
        }
        //save feature products
        for ($i = 0; $i < count($params['shop_feature_item_id']); $i++) {
            $fId = $params['shop_feature_item_id'][$i];
            $this->sqlEngine->save($this->product_feature_tbl,
                array(
                    'shop_product_id' => $id,
                    'shop_category_feature_id' => $params['shop_category_feature_id'][$i],
                    'shop_feature_item_id' => $fId,
                    'value' => json_encode($params['feature' . $fId])
                ));
        }
        //save related products
        for ($i = 0; $i < count($params['related']); $i++) {
            $this->sqlEngine->save($this->product_related_tbl,
                array(
                    'shop_product_id' => $id,
                    'related_product_id' => $params['related'][$i]
                ));
        }
        //save gifts product
        for ($i = 0; $i < count($params['gift']); $i++) {
            $this->sqlEngine->save($this->product_gift_tbl,
                array(
                    'shop_product_id' => $id,
                    'gift_product_id' => $params['gift'][$i]
                ));
        }

        //rename gallery folder
        $galId = $_SESSION['galId'];

        $picture = \f\ttt::service('core.fileManager.getList',
            array(
                'path' => 'shop.product.' . $galId,
            ));


        rename(\f\ifm::app()->uploadDir . \f\DS . 'shop' . \f\DS . 'product' . \f\DS . $galId,
            \f\ifm::app()->uploadDir . \f\DS . 'shop' . \f\DS . 'product' . \f\DS . $id);

        $this->sqlEngine->save('core_file',
            array(
                'title' => $params['title'],
                'name' => $id
            ),
            array(
                'name=?',
                array(
                    $galId)));

        $path = 'shop.product.';
        $this->sqlEngine->save('core_file', array(
            'path' => $path . $id
        ), array(
            'path=?', array($path . $galId)
        ));


        foreach ($picture['list'] AS $data) {
            unset ($_SESSION['file' . $data['id']]);

            $pathFile = explode('.', $data['path']);

            $newPath = 'shop.product.' . $id . '.' . $pathFile[3];
            $this->sqlEngine->save('core_file',
                array(
                    'path' => $newPath
                ),
                array(
                    'id=?',
                    array(
                        $data['id'])));
        }

        //$path = 'shop.product.' ;

        /*
        $this->sqlEngine->Update ( 'core_file' )
                ->setField ( "path=REPLACE(path,'" . $path . $galId . "','" . $path . $id . "')" )
                ->Where ( "path LIKE '%" . $path . $galId . "%'" )
                ->Run () ;
         * 
         * 
         */
        unset ($_SESSION['galId']);

        return $result;
    }


    public function productSaveWithoutPrice()
    {
        $params = $this->request->getAssocParams();
        $params['owner_id'] = \f\ttt::dal('core.auth.getUserOwner');
        $params['picture'] = $params['picture'] ? $params['picture'] : NULL;
        $params['brand'] = $params['brand'] ? $params['brand'] : NULL;
        $params['date_register'] = time();


        $result = $this->sqlEngine->save($this->product_tbl,
            array(
                'owner_id' => $params['owner_id'],
                'title' => $params['title'],
                'sub_title' => $params['sub_title'],
                'shop_brand_id' => $params['brand'],
                'shop_category_id' => $params['category'],
                'short_explanation' => $params['short_explanation'],
//                'content' => $params['content'],
            //    'video' => $params['video'],
              //  'gifts' => $params['gifts'],
                'picture' => $params['picture'],
                'related' => json_encode($params['related']),
                'date_register' => $params['date_register'],
                'date_update' => $params['date_register'],
                'review' => $params['review'],
                'n_buy'=>$params['n_buy'],
                'm_free'=>$params['m_free']
            )
        );

        $id = $result;


        //save price products
        $time = time();
        for ($i = 0; $i < count($params['color']); $i++) {
            //\f\pre ( $params[ 'price' ]  ) ;
            $stock = str_replace(',', '', $params['stock'][$i]);

            $discount = str_replace(',', '', $params['discount'][$i]);
            $this->sqlEngine->save($this->product_price_tbl,
                array(
                    'shop_product_id' => $id,
                    'color_id' => $params['color'][$i],
                    'guarantee_id' => $params['guarantee'][$i],
                    'stock' => $stock,
                    'type_discount' => $params['type_discount'][$i],
                    'discount' => $discount,
                ));

            $this->sqlEngine->save($this->product_price_history_tbl,
                array(
                    'shop_product_id' => $id,
                    'color_id' => $params['color'][$i],
                    'guarantee_id' => $params['guarantee'][$i],
                    'stock' => $stock,
                    'type_discount' => $params['type_discount'][$i],
                    'discount' => $discount,
                    'date_register' => $time,
                ));
        }
        //save feature products
        for ($i = 0; $i < count($params['shop_feature_item_id']); $i++) {
            $fId = $params['shop_feature_item_id'][$i];
            $this->sqlEngine->save($this->product_feature_tbl,
                array(
                    'shop_product_id' => $id,
                    'shop_category_feature_id' => $params['shop_category_feature_id'][$i],
                    'shop_feature_item_id' => $fId,
                    'value' => json_encode($params['feature' . $fId])
                ));
        }
        //save related products
        for ($i = 0; $i < count($params['related']); $i++) {
            $this->sqlEngine->save($this->product_related_tbl,
                array(
                    'shop_product_id' => $id,
                    'related_product_id' => $params['related'][$i]
                ));
        }
        //save gifts product
        for ($i = 0; $i < count($params['gift']); $i++) {
            $this->sqlEngine->save($this->product_gift_tbl,
                array(
                    'shop_product_id' => $id,
                    'gift_product_id' => $params['gift'][$i]
                ));
        }

        //rename gallery folder
        $galId = $_SESSION['galId'];

        $picture = \f\ttt::service('core.fileManager.getList',
            array(
                'path' => 'shop.product.' . $galId,
            ));


        rename(\f\ifm::app()->uploadDir . \f\DS . 'shop' . \f\DS . 'product' . \f\DS . $galId,
            \f\ifm::app()->uploadDir . \f\DS . 'shop' . \f\DS . 'product' . \f\DS . $id);

        $this->sqlEngine->save('core_file',
            array(
                'title' => $params['title'],
                'name' => $id
            ),
            array(
                'name=?',
                array(
                    $galId)));

        $path = 'shop.product.';
        $this->sqlEngine->save('core_file', array(
            'path' => $path . $id
        ), array(
            'path=?', array($path . $galId)
        ));


        foreach ($picture['list'] AS $data) {
            unset ($_SESSION['file' . $data['id']]);

            $pathFile = explode('.', $data['path']);

            $newPath = 'shop.product.' . $id . '.' . $pathFile[3];
            $this->sqlEngine->save('core_file',
                array(
                    'path' => $newPath
                ),
                array(
                    'id=?',
                    array(
                        $data['id'])));
        }

        //$path = 'shop.product.' ;

        /*
        $this->sqlEngine->Update ( 'core_file' )
                ->setField ( "path=REPLACE(path,'" . $path . $galId . "','" . $path . $id . "')" )
                ->Where ( "path LIKE '%" . $path . $galId . "%'" )
                ->Run () ;
         * 
         * 
         */

        unset ($_SESSION['galId']);


        return $result;
    }

    public function productSaveEdit()
    {
        $params = $this->request->getAssocParams();
        //\f\pre($params);
        $params['picture'] = $params['picture'] ? $params['picture'] : NULL;
        $params['brand'] = $params['brand'] ? $params['brand'] : NULL;

        $id = $params['id'];

      //  \f\pre(json_encode($params['category']));
        $result = $this->sqlEngine->save($this->product_tbl,
            array(
                'title' => $params['title'],
                'sub_title' => $params['sub_title'],
                'shop_brand_id' => $params['brand'],
                'shop_category_id' =>str_replace('"','',str_replace(']','',str_replace('[','',json_encode($params['category'])))),
          //  'dynamic'=>$params['dynamic'],
            //   'gifts' => $params['gifts'],
//                'content' => $params['content'],
                'short_explanation' => $params['short_explanation'],
             //   'video' => $params['video'],
                'picture' => $params['picture'],
                'related' => json_encode($params['related']),
                'review' => $params['review'],
                'date_update' => time(),
                'n_buy'=>($params['n_buy']==''?NULL:$params['n_buy']),
                'm_free'=>($params['m_free']==''?NULL:$params['m_free']),
                'shop_product_gift_id' => ($params['shop_product_gift_id']==''?NULL:$params['shop_product_gift_id']),
                'gift_text'=>($params['gift_text']==''?NULL:$params['gift_text']),
                'active_gift_section'=>$params['active_gift_section']
            ),
            array(
                'id=?',
                array(
                    $id))
        );
      //  \f\pr($params);
 //     \f\pre($this->sqlEngine->last_query());
        /*  \f\pr(time());
        \f\pr(json_encode($params['related']));
\f\pr($params);*/
      //  \f\pre($this->sqlEngine->last_query());
      /*  \f\pr(time());
        \f\pr(json_encode($params['related']));
        \f\pr($params['short_product_id'][0]);
        \f\pr($params);
        \f\pre($this->sqlEngine->last_query());*/
        /*\f\pr(time());
        \f\pr(json_encode($params['related']));
        \f\pr($params);
        \f\pre($this->sqlEngine->last_query());*/
        //save price products
        $priceIdStr = implode(',', $params['idPrice']);

        $this->sqlEngine->remove($this->product_price_tbl,
            array(
                "id NOT IN ($priceIdStr) AND shop_product_id=$id"
            ));
        $time = time();
        for ($i = 0; $i < count($params['price']); $i++) {
            $stock = str_replace(',', '', $params['stock'][$i]);
            $price = str_replace(',', '', $params['price'][$i]);
            $majorPrice = str_replace(',', '', $params['majorPrice'][$i]);
            $user_price = str_replace(',', '', $params['user_price'][$i]);
            $discount = str_replace ( ',', '', $params[ 'discount' ][ $i ] ) ;
            //\f\pre($majorPrice);

            if ($params['idPrice'][$i]) {
                $this->sqlEngine->save($this->product_price_tbl,
                    array(
                        'shop_product_id' => $id,
                        'color_id' => $params['color'][$i],
                        'guarantee_id' => $params['guarantee'][$i],
                        'material_id' => $params['material'][$i],
                        'stock' => $stock,
                        'price' => $price,
                        'majorPrice' => $majorPrice,
                        'user_price' => $user_price,
                        'discount' => $discount,
                        'type_discount' => $params['type_discount'][$i],
                        'dynamic'=>$params['dynamic']
                    ),
                    array(
                        'id=?',
                        array(
                            $params['idPrice'][$i])));
               /* \f\pr('id='.$id);
                \f\pr('color='.$params['color'][$i]);
                \f\pr('guarantee='.$params['guarantee'][$i]);
                \f\pr('material='.$params['material'][$i]);
                \f\pr('stock='.$stock);
                \f\pr('price='.$price);
                \f\pr('majorpric'.$majorPrice);
                \f\pr('userprice'.$user_price);
                \f\pr('discount'.$discount);
                \f\pr('type_discount'.$params['type_discount'][$i]);
                \f\pr($this->sqlEngine->last_query());*/

              //  \f\pr($params);
             //   \f\pre($this->sqlEngine->last_query());
            } else {
                $this->sqlEngine->save($this->product_price_tbl,
                    array(
                        'shop_product_id' => $id,
                        'color_id' => ($params['color'][$i]==''?NULL:$params['color'][$i]),
                        'guarantee_id' => ($params['guarantee'][$i]==''?NULL:$params['guarantee'][$i]),
                        'material_id' => ($params['material'][$i]==''?NULL:$params['material'][$i]),
                        'stock' => ($stock==''?NULL:$stock),
                        'price' => ($price==''?NULL:$price),
                        'majorPrice' => ($majorPrice==''?NULL:$majorPrice),
                        'discount' => ($discount==''?NULL:$discount),
                        'type_discount' => ($params['type_discount'][$i]==''?NULL:$params['type_discount'][$i]),
                        'dynamic'=>$params['dynamic']
                    ));
              /* \f\pr('id='.$id);
                \f\pr('color='.($params['color'][$i]==''?NULL:$params['color'][$i]));
                \f\pr('guarantee='.($params['guarantee'][$i]==''?NULL:$params['guarantee'][$i]));
                \f\pr('material='.($params['material'][$i]==''?NULL:$params['material'][$i]));
                \f\pr('stock='.($stock==''?NULL:$stock));
                \f\pr('price='.($price==''?NULL:$price));
                \f\pr('majorpric'.($majorPrice==''?NULL:$majorPrice));
                \f\pr('userprice'.$user_price);
                \f\pr('discount'.($discount==''?NULL:$discount));
                \f\pr('type_discount'.($params['type_discount'][$i]==''?NULL:$params['type_discount'][$i]));
                \f\pr($this->sqlEngine->last_query());*/
              // \f\pr($params);
             //  \f\pre($this->sqlEngine->last_query());
            }

            if ($params['history']) {
                $this->sqlEngine->save($this->product_price_history_tbl,
                    array(
                        'shop_product_id' => $id,
                        'color_id' => $params['color'][$i],
                        'guarantee_id' => $params['guarantee'][$i],
                        'stock' => $stock,
                        'price' => $price,
                        'discount' => $discount,
                        'date_register' => $time,
                    ));
            }
        }

        //save feature products
        $this->sqlEngine->remove($this->product_feature_tbl,
            array(
                'shop_product_id=?',
                array(
                    $id)
            ));


        for ($i = 0; $i < count($params['shop_feature_item_id']); $i++) {

            $fId = $params['shop_feature_item_id'][$i];
            $this->sqlEngine->save($this->product_feature_tbl,
                array(
                    'shop_product_id' => $id,
                    'shop_category_feature_id' => $params['shop_category_feature_id'][$i],
                    'shop_feature_item_id' => $fId,
                    'value' => json_encode($params['feature' . $fId])
                ));
        }
        //save related products
        $this->sqlEngine->remove($this->product_related_tbl,
            array(
                'shop_product_id=?',
                array(
                    $id)
            ));
        for ($i = 0; $i < count($params['related']); $i++) {
            $this->sqlEngine->save($this->product_related_tbl,
                array(
                    'shop_product_id' => $id,
                    'related_product_id' => $params['related'][$i]
                ));
        }
        //save gifts product
        $this->sqlEngine->remove($this->product_gift_tbl,
            array(
                'shop_product_id=?',
                array(
                    $id)
            ));
        for ($i = 0; $i < count($params['gift']); $i++) {
            $this->sqlEngine->save($this->product_gift_tbl,
                array(
                    'shop_product_id' => $id,
                    'gift_product_id' => $params['gift'][$i]
                ));
        }

        return $result;
    }


    public function productSaveEditWithoutPrice()
    {
        $params = $this->request->getAssocParams();
        //\f\pre ( $params ) ;
        $params['picture'] = $params['picture'] ? $params['picture'] : NULL;
        $params['brand'] = $params['brand'] ? $params['brand'] : NULL;
        //\f\pre($params['brand']);
        $id = $params['id'];

        $result = $this->sqlEngine->save($this->product_tbl,
            array(
                'title' => $params['title'],
                'sub_title' => $params['sub_title'],
                'shop_brand_id' => $params['brand'],
                'shop_category_id' => $params['category'],
                'gifts' => $params['gifts'],
                'content' => $params['content'],
                'short_explanation' => $params['short_explanation'],
              //  'video' => $params['video'],
                'picture' => $params['picture'],
                'related' => json_encode($params['related']),
                'review' => $params['review'],
                'date_update' => time(),
            ),
            array(
                'id=?',
                array(
                    $id))
        );

        //save price products
        $priceIdStr = implode(',', $params['idPrice']);

        $this->sqlEngine->remove($this->product_price_tbl,
            array(
                "id Not IN ($priceIdStr) AND shop_product_id=$id"
            ));
        // \f\pr($priceIdStr);
//\f\pre($this->sqlEngine->last_query());

        $time = time();
        for ($i = 0; $i < count($params['color']); $i++) {
            $stock = str_replace(',', '', $params['stock'][$i]);
            $price = str_replace(',', '', $params['price'][$i]);
            $discount = str_replace(',', '', $params['discount'][$i]);
            //\f\pr($params['idPrice'][$i]);
            if ($params['idPrice'][$i]) {
                $this->sqlEngine->save($this->product_price_tbl,
                    array(
                        'shop_product_id' => $id,
                        'color_id' => $params['color'][$i],
                        'guarantee_id' => $params['guarantee'][$i],
                        'stock' => $stock,

                    ),
                    array(
                        'id=?',
                        array(
                            $params['idPrice'][$i])));
                // \f\pr($params);
               //\f\pr('hi');
               //\f\pr($this->sqlEngine->last_query());
                // \f\pr($params['idPrice'][$i]);
            } else {
                //  \f\pr('by');
                $this->sqlEngine->save($this->product_price_tbl,
                    array(
                        'shop_product_id' => $id,
                        'color_id' => $params['color'][$i],
                        'guarantee_id' => $params['guarantee'][$i],
                        'stock' => $stock,

                    ));
            }

            if ($params['history']) {
                $this->sqlEngine->save($this->product_price_history_tbl,
                    array(
                        'shop_product_id' => $id,
                        'color_id' => $params['color'][$i],
                        'guarantee_id' => $params['guarantee'][$i],
                        'stock' => $stock,

                        'discount' => $discount,
                        'date_register' => $time,
                    ));
            }
        }

        //save feature products
        $this->sqlEngine->remove($this->product_feature_tbl,
            array(
                'shop_product_id=?',
                array(
                    $id)
            ));


        for ($i = 0; $i < count($params['shop_feature_item_id']); $i++) {

            $fId = $params['shop_feature_item_id'][$i];
            $this->sqlEngine->save($this->product_feature_tbl,
                array(
                    'shop_product_id' => $id,
                    'shop_category_feature_id' => $params['shop_category_feature_id'][$i],
                    'shop_feature_item_id' => $fId,
                    'value' => json_encode($params['feature' . $fId])
                ));
        }
        //save related products
        $this->sqlEngine->remove($this->product_related_tbl,
            array(
                'shop_product_id=?',
                array(
                    $id)
            ));
        for ($i = 0; $i < count($params['related']); $i++) {
            $this->sqlEngine->save($this->product_related_tbl,
                array(
                    'shop_product_id' => $id,
                    'related_product_id' => $params['related'][$i]
                ));
        }
        //save gifts product
        $this->sqlEngine->remove($this->product_gift_tbl,
            array(
                'shop_product_id=?',
                array(
                    $id)
            ));
        for ($i = 0; $i < count($params['gift']); $i++) {
            $this->sqlEngine->save($this->product_gift_tbl,
                array(
                    'shop_product_id' => $id,
                    'gift_product_id' => $params['gift'][$i]
                ));
        }

        return $result;
    }

    public function productDelete()
    {
        $param = $this->request->getAssocParams();
        $id = $param['id'];
        $this->sqlEngine->remove($this->product_tbl,
            array(
                'id=?',
                array(
                    $id)));

        return array(
            'result' => 'success',
            'func' => 'remove');
    }

    public function productStatus()
    {
        $param = $this->request->getAssocParams();
        $id = $param['id'];
        $status = $param['status'] == 'enabled' ? 'disabled' : 'enabled';

        $this->sqlEngine->save($this->product_tbl,
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

    public function getProductById()
    {
        $param = $this->request->getAssocParams();
        $this->sqlEngine->Select('t1.*')
            ->From($this->product_tbl . ' AS t1')
           // ->leftJoin('shop_category')
           // ->On('shop_category.id IN(REPLACE(REPLACE(t1.shop_category_id,"[",""),"]",""))')
            ->Where('t1.id=?', $param['id'])
            ->andWhere('t1.status=?', 'enabled')
            ->Run();
        $row=$this->sqlEngine->getRow();
        $cats=str_replace('[','',str_replace( ']','',$row['shop_category_id']));
        $this->sqlEngine->Select('t1.*,shop_category.dynamic')
            ->From($this->product_tbl . ' AS t1')
            ->innerJoin('shop_category')
             ->On('shop_category.id IN('.$cats.')')
            ->Where('t1.id =?', $param['id'])
            ->andWhere('t1.status=?', 'enabled')
            ->groupBy('t1.id')
            ->Run();
        $row=$this->sqlEngine->getRow();
        return $row;
    }

    public function getFavoriteProductById()
    {
        $param = $this->request->getAssocParams();
        $productId =implode(',', $param['productsId']);
        $this->sqlEngine->Select()
            ->From($this->product_tbl . ' AS t1')
             ->Where('t1.id IN (' . $productId . ')')
            ->Run();
        //\f\pre($this->sqlEngine->getRow());
        return $this->sqlEngine->getRows();
    }

    public function getStockOfGift(){
        $param = $this->request->getAssocParams();
        $this->sqlEngine->Select('t1.stock AS stockGift')
            ->From('shop_product_price AS t1')
            ->Where('t1.id=?', $param['shop_product_gift_id'])
            ->Run();
        return $this->sqlEngine->getRow();
    }

    public function getProductByColorGuaranteeId(){
        $param = $this->request->getAssocParams();
        $this->sqlEngine->Select('CONCAT (t1.title," - ",t4.title," - ",t3.title) AS title,t2.id')
            ->From($this->product_tbl . ' AS t1')
            ->rightJoin('shop_product_price AS t2')
            ->on('t1.id=t2.shop_product_id')
            ->rightJoin('shop_guarantee AS t3')
            ->on('t3.id=t2.guarantee_id')
            ->rightJoin('shop_color AS t4')
            ->on('t4.id=t2.color_id')
            ->orderBy('title')
            ->Run();
    //   \f\pre($this->sqlEngine->last_query());
        return $this->sqlEngine->getRows();
    }

    public function getProductByOwnerId()
    {
        $ownerId = \f\ttt::dal('core.auth.getUserOwner');

        if (!$ownerId) {
            $ownerId = \f\ttt::dal('core.auth.getOwnerFront');
        }
        $this->sqlEngine->Select()
            ->From($this->product_tbl . ' AS t1')
            ->Where('t1.owner_id=?', $ownerId)
            ->andWhere('status=?', 'enabled')
            ->OrderBy('title ASC')
            ->Run();
        //\f\pre($this->sqlEngine->getRows());
        return $this->sqlEngine->getRows();
    }

    public function getFeatureByCatId()
    {
        $id = $this->request->getParam('id');

        $this->sqlEngine->Select('t1.id AS catId,t2.title AS featureTitle,t3.type,t3.options,t3.shop_wiki_id AS id,t3.id AS fId,t3.required')
            ->From('shop_category_feature AS t1')
            ->Join('shop_feature AS t2')
            ->Join('shop_feature_item AS t3')
            ->Where('t1.shop_category_id=?', $id)
            ->andWhere('t1.shop_feature_id=t2.id')
            ->andWhere('t2.id=t3.shop_feature_id')
            ->OrderBy('t1.priority ASC,t3.priority ASC')
            ->Run();

        return $this->sqlEngine->getRows();
    }

    public function getConcessionProduct()
    {
        $params = $this->request->getAssocParams();

        $this->sqlEngine->Select()
            ->From($this->shop_amazing);
        if ($num) {
            $this->sqlEngine->Limit("$min,$num");
        }
        $this->sqlEngine->Run();
        $product = $this->sqlEngine->getRows();
        $number = $this->sqlEngine->numRows();
        return array(
            $product,
            $number);
    }

    public function getFeatureByProductId()
    {

        $id = $this->request->getParam('id');
        $this->sqlEngine->Select()
            ->From($this->product_feature_tbl)
            ->Where('shop_product_id=?', $id)
            ->Run();

        return $this->sqlEngine->getRows();
    }

    public function getPriceByProductById()
    {
        $id = $this->request->getParam('id');
        $history = $this->request->getParam('history');
        if ($history) {
            $tbl = $this->product_price_history_tbl;
        } else {
            $tbl = $this->product_price_tbl;
        }
        $this->sqlEngine->Select()
            ->From($tbl)
            ->Where('shop_product_id=?', $id);
        if ($history) {
            $this->sqlEngine->OrderBy('id DESC');
        }
        $this->sqlEngine->Run();

        return $this->sqlEngine->getRows();
    }

    public function productSpecial()
    {
        $param = $this->request->getAssocParams();
        $id = $param['id'];
        $status = $param['status'] == 'enabled' ? 'disabled' : 'enabled';

        $this->sqlEngine->save($this->product_tbl,
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

    public function getProductsByAjaxSearch()
    {

        $param = $this->request->getAssocParams();
        $this->sqlEngine->Select('t1.id,t1.title,t1.picture,t2.title AS cat_title')
            ->From($this->product_tbl . ' AS t1')
            ->leftJoin('shop_category AS t2')
            ->On('t1.shop_category_id = t2.id')
            ->Where('t1.status=?', 'enabled')
            ->andWhere("t1.title LIKE '%" . $param['keyword'] . "%'")
            ->orWhere("t1.sub_title LIKE '%" . $param['keyword'] . "%'");

        $this->sqlEngine->OrderBy('t1.id DESC');
        if ($param['limit']) {
            $this->sqlEngine->Limit($param['limit']);
        }
        $this->sqlEngine->Run();
        return $this->sqlEngine->getRows();
    }

    public function getProductByParams()
    {
        $param = $this->request->getAssocParams();
        $this->sqlEngine->Select('t1.id,t1.shop_product_id,t1.stock')
            ->From($this->product_price_tbl . ' AS t1')
            ->Join($this->product_tbl . ' AS t2')
            ->Where('t1.shop_product_id=t2.id')
          //  ->andWhere("t2.shop_category_id =?", $param['cat_id'])
            ->OrderBy('(t1.price-t1.discount) ASC')
            ->Run();
        $row = $this->sqlEngine->getRows();
        //\f\pre($row);
       // \f\pre($th);
        $oldId = 0;
        foreach ($row AS $data) {
            if ($oldId != $data['shop_product_id']) {

                if (!$arr[$oldId] && $oldId) {
                    $arr[$oldId] = $old;
                }
                $oldId = $data['shop_product_id'];
            }
            if (!$arr[$data['shop_product_id']] && $data['stock'] > 0) {
                $arr[$data['shop_product_id']] = $data['id'];
            }
            $old = $data['id'];
        }
        if (!$arr[$oldId] && $oldId) {
            $arr[$oldId] = $old;
        }
        $idList = implode(',', $arr);

        $ownerId = \f\ttt::dal('core.auth.getUserOwner');
        if (!$ownerId) {
            $ownerId = \f\ttt::dal('core.auth.getOwnerFront');
        }

        $this->sqlEngine->Select('SQL_CALC_FOUND_ROWS t1.id,t1.*,t2.title AS catTitle,t3.discount,t3.stock,t3.price')
            ->From($this->product_tbl . ' AS t1')
            ->innerJoin('shop_category AS t2')
            ->On('t2.id IN(t1.shop_category_id)')
            ->leftJoin($this->product_price_tbl . ' AS t3')
            ->On('t1.id=t3.shop_product_id')
            ->Where('t1.owner_id=?', $ownerId)
            ->andWhere('t1.status=?', 'enabled');

        if ($param['id']) {
            $this->sqlEngine->andWhere('t1.id=?', $param['id']);
        }
        if ($param['minPrice'] != NULL && $param['maxPrice'] != NULL) {
            if ($param['minPrice'] == 0) {
                $param['minPrice'] = 1;
            }
            $this->sqlEngine->andWhere('t3.price>=?', $param['minPrice']);
            $this->sqlEngine->andWhere('t3.price<=?', $param['maxPrice']);
        }
        if ($param['sale_status'] == 'enabled') {
            $this->sqlEngine->andWhere('t3.stock>0');
        }
        if ($param['searchText']) {
            $this->sqlEngine->andWhere("t1.title LIKE '%" . $param['searchText'] . "%'");
        }
        /*if ($param['cat_id']) {
            $this->sqlEngine->andWhere("t1.shop_category_id =?",
                $param['cat_id']);
        }*/
        if ($param['brand_id'] && !$param['brand']) {
            $this->sqlEngine->andWhere("t1.shop_brand_id =?",
                $param['brand_id']);
        } else if ($param['brand']) {
            $this->sqlEngine->andWhere("t1.shop_brand_id =?",
                $param['brand']);
        }

        if ($param['color']) {
            $this->sqlEngine->andWhere("t3.color_id =?",
                $param['color']);
        }
        if ($param['special']) {
            $this->sqlEngine->andWhere("t1.special=?", $param['special']);
            //$this->sqlEngine->GroupBy (['0'].'t3.shop_product_id') ;
        }
        $this->sqlEngine->andWhere('t3.id IN (' . $idList . ')');
        //$this->sqlEngine->OrderBy ( 't1.' . $param[ 'sort' ] . ' ' . $param[ 'sort_type' ] ) ;
        //$this->sqlEngine->GroupBy ( 't1.id' ) ;
        $this->sqlEngine->OrderBy($param['sort'] . ' ' . $param['sort_type']);
        if ($param['limit']) {
            $this->sqlEngine->Limit($param['limit']);
        }
        $this->sqlEngine->Run();
        $row = $this->sqlEngine->getRows();
       // \f\pr($param);
       // \f\pre($this->sqlEngine->last_query());
        $this->sqlEngine->Select('FOUND_ROWS() AS num')
            ->Run();
        $num = $this->sqlEngine->getRow();
        return array(
            $row,
            $num['num']);
    }

    public function getNewProduct()
    {
        $param = $this->request->getAssocParams();
        $ownerId = \f\ttt::dal('core.auth.getUserOwner');
        if (!$ownerId) {
            $ownerId = \f\ttt::dal('core.auth.getOwnerFront');
        }
        $this->sqlEngine->Select('t2.id AS product_price_id,t1.title,t1.picture,t1.id,t2.price,t2.stock,t2.discount,t2.type_discount,shop_category.dynamic,t2.majorPrice,shop_category.dynamic')
            ->From($this->product_tbl . ' AS t1')
            ->innerJoin('shop_category')
            ->on('shop_category.id IN (t1.shop_category_id)')
            ->leftJoin($this->product_price_tbl . ' AS t2')
            ->On('t1.id=t2.shop_product_id AND t2.dynamic=shop_category.dynamic')
           // ->Where('t1.owner_id=?', $ownerId)
            ->Where('t1.status=?', 'enabled')
            ->GroupBy('t1.id DESC')
            ->orderBy('t1.id DESC')
            ->Limit(16)
            ->Run();
        $row = $this->sqlEngine->getRows();
        return $row;
    }

    public function getNewOneProduct()
    {
        $param = $this->request->getAssocParams();
        if(!empty($_SESSION['user_id'])){
            $this->sqlEngine->Select('*')
                ->from('member')
                ->Where('member.id=?',$_SESSION['user_id'])
                ->Run();
            $user=$this->sqlEngine->getRow();
            $_SESSION['type_user']=$user['type_user'];
        }

        $this->sqlEngine->Select('t1.title,t1.picture,t1.id,t2.price,t2.stock,
if(t2.discount=0 or t2.discount IS NULL, 
			if(shop_brand.discount=0 or shop_brand.discount IS NULL,
			0,
			if(shop_brand.type_discount="percent",(t2.price*(shop_brand.discount/100)),shop_brand.discount)
		)
			,
			if(t2.type_discount="percent",(t2.price*(t2.discount/100)),t2.discount)
			) as endDisSeller,
 if(t2.discount=0 or t2.discount IS NULL, 
			if(shop_brand.discount=0 or shop_brand.discount IS NULL,
			0,
			if(shop_brand.type_discount="percent",(t2.user_price*(shop_brand.discount/100)),shop_brand.discount)
		)
			,
			if(t2.type_discount="percent",(t2.user_price*(t2.discount/100)),t2.discount)
			) as endDisNormUser,
            t2.price,t2.user_price')
            ->From($this->product_tbl . ' AS t1')
            ->innerJoin($this->product_price_tbl . ' AS t2')
            ->On('t1.id=t2.shop_product_id')
            ->innerJoin('shop_brand')
            ->On('shop_brand.id=t1.shop_brand_id')
            ->Where('t1.shop_category_id IN (' . $param['categoryId'] . ')')
            ->andWhere('t1.status=?', 'enabled')
           // ->andWhere('t2.stock>0')
            ->GroupBy('t1.id DESC')
            ->Limit(16)
            ->Run();

        $row = $this->sqlEngine->getRows();
        return $row;
    }

    public function getRelatedProductById()
    {
        $param = $this->request->getAssocParams();
        $ownerId = \f\ttt::dal('core.auth.getUserOwner');
        if (!$ownerId) {
            $ownerId = \f\ttt::dal('core.auth.getOwnerFront');
        }
        $this->sqlEngine->Select('t1.*')
            ->From($this->product_tbl . ' AS t1')
            ->leftJoin($this->product_related_tbl . ' AS t2')
            ->On('t1.id=t2.related_product_id')
            ->Where('t2.shop_product_id=?', $param['id'])
            ->andWhere('t1.status=?', $param['status'])
            ->GroupBy('t1.id DESC')
            ->Limit(16)
            ->Run();
        $row = $this->sqlEngine->getRows();
        return $row;
    }

    public function getProductBestselling()
    {
        //$param   = $this->request->getAssocParams () ;
        $ownerId = \f\ttt::dal('core.auth.getUserOwner');
        if (!$ownerId) {
            $ownerId = \f\ttt::dal('core.auth.getOwnerFront');
        }
        $this->sqlEngine->Select('t2.id AS product_price_id,SUM(t1.count) AS countSum,t3.title,t3.picture,t3.id,t2.price,t2.discount')
            ->From('shop_order_items AS t1')
            ->leftJoin($this->product_price_tbl . ' AS t2')
            ->On('t1.product_price_id=t2.id')
            ->leftJoin($this->product_tbl . ' AS t3')
            ->On('t2.shop_product_id = t3.id')
            ->Where('t3.owner_id=?', $ownerId)
            ->andWhere('t3.status=?', 'enabled');
        $this->sqlEngine->GroupBy('t3.id');
        $this->sqlEngine->OrderBy('countSum DESC');
        $this->sqlEngine->Limit(16);
        $this->sqlEngine->Run();
       // \f\pre ( 'jkkj' ) ;
        $row = $this->sqlEngine->getRows();
        return $row;
    }

    public function getBestsellingManually()
    {
        //$param   = $this->request->getAssocParams () ;
        $ownerId = \f\ttt::dal('core.auth.getUserOwner');
        if (!$ownerId) {
            $ownerId = \f\ttt::dal('core.auth.getOwnerFront');
        }
        $this->sqlEngine->Select('t3.title,t3.picture,t3.id,t2.price,t2.discount')
            ->From($this->product_price_tbl . ' AS t2')
            ->leftJoin($this->product_tbl . ' AS t3')
            ->On('t2.shop_product_id=t3.id')
            ->Where('t3.owner_id=?', $ownerId)
            ->andWhere('t3.bestselling=?', 'yes')
            ->andWhere('t3.status=?', 'enabled');
        $this->sqlEngine->GroupBy('t3.id');
        $this->sqlEngine->OrderBy('t3.id DESC');
        $this->sqlEngine->Limit(16);
        $this->sqlEngine->Run();
        //\f\pre ( $this->sqlEngine->getRows () ) ;
        $row = $this->sqlEngine->getRows();
        return $row;
    }

    public function getAmazingProducts()
    {
        $param = $this->request->getAssocParams();
        $num = $param['numPerPage'];
        //\f\pre($param['today']);
        $min = ($param['page'] - 1) * $num;
        $ownerId = \f\ttt::dal('core.auth.getUserOwner');
        if (!$ownerId) {
            $ownerId = \f\ttt::dal('core.auth.getOwnerFront');
        }
        $this->sqlEngine->Select('t3.discount_type,t1.title,t3.date_end,t1.picture,t1.id,t3.price AS discount,min(t2.user_price) AS user_price,min(t2.price) AS colleague_price,min(t2.majorPrice) AS major_price,t2.stock,t3.content,t3.short AS categoryTitle,t2.id AS product_price_id')
            ->From($this->product_tbl . ' AS t1')
            ->leftJoin($this->product_price_tbl . ' AS t2')
            ->On('t1.id=t2.shop_product_id')
            ->leftJoin($this->shop_amazing . ' AS t3')
            ->On('t1.id = t3.shop_product_id')
            ->Where("t3.date_start<=?", $param['today'])
            ->andWhere("t3.date_end>=?", $param['today'])
            ->andWhere('t1.owner_id=?', $ownerId)
            ->andWhere('t1.status=?', 'enabled')
            ->andWhere('t2.stock>0')
            ->GroupBy('t1.id')
            ->OrderBy('t3.id DESC');
        if ($param['limit']) {
            $this->sqlEngine->Limit($param['limit']);
        }
        if ($num) {
            $this->sqlEngine->Limit("$min,$num");
        }
        $this->sqlEngine->Run();

        //\f\pr($param);
        //\f\pre($this->sqlEngine->last_query());
        $row = $this->sqlEngine->getRows();
        $number = $this->sqlEngine->numRows();
        return array(
            $row,
            $number
        );
    }

    public function getProductPriceById(){
        $param = $this->request->getAssocParams();
        $this->sqlEngine->Select()
            ->From($this->product_price_tbl . ' AS t1')
            ->Where('t1.id=?',$param['product_price_id'])
            ->Run();
        $row = $this->sqlEngine->getRow();
        return $row;
    }


    public function getBrandsByProductsCat()
    {
        $param = $this->request->getAssocParams();
        $this->sqlEngine->Select('t4.title_fa AS brand_fa,t4.title_en AS brand_en,t4.id AS brand_id')
            ->From($this->product_tbl . ' AS t1')
            ->leftJoin('shop_brand AS t4')
            ->On('t1.shop_brand_id=t4.id')
            ->Where("t1.shop_category_id", $param['cat_id']);

        $this->sqlEngine->GroupBy('brand_id');
        //$this->sqlEngine->OrderBy ( 'brand_id ASC' ) ;
        $this->sqlEngine->Run();
        return $this->sqlEngine->getRows();
    }

    public function getPriceMaxByCatId()
    {
        $param = $this->request->getAssocParams();
        //\f\pre($param);
        $this->sqlEngine->Select('MAX(t3.price) AS priceMax')
            ->From($this->product_tbl . ' AS t1')
            ->leftJoin($this->product_price_tbl . ' AS t3')
            ->On('t1.id=t3.shop_product_id')
            ->Where('t1.status=?', 'enabled')
            ->andWhere('t1.shop_category_id=?', $param['cat_id']);
        $this->sqlEngine->GroupBy('t3.price');
        $this->sqlEngine->Run();
        $row = $this->sqlEngine->getRows();
        //\f\pre($this->sqlEngine->last_query());
        return $row;
    }

    public function setProductVisit()
    {
        $param = $this->request->getAssocParams();
        $this->sqlEngine->Update($this->product_tbl)
            ->setField('num_visit=num_visit+1')
            ->Where('id=?', $param['id'])
            ->Run();
    }
    public function getMostVisitProduct(){
        $param = $this->request->getAssocParams();
        $this->sqlEngine->Select('t1.*,shop_product_price.*,shop_category.dynamic,t1.id as productId')
            ->From($this->product_tbl . ' AS t1')
            ->innerJoin('shop_category')
            ->on('shop_category.id IN(t1.shop_category_id)')
            ->leftJoin('shop_product_price')
            ->On('shop_product_price.shop_product_id=t1.id AND shop_product_price.dynamic=shop_category.dynamic')
            ->Where('t1.status=?', 'enabled')
            // ->andWhere('shop_product_price.stock>0')
            ->groupBy('t1.id')
            ->orderBy('t1.num_visit DESC')
            ->limit('12');
        $this->sqlEngine->Run();
      //  \f\pre($this->sqlEngine->last_query());
        $row = $this->sqlEngine->getRows();
        return $row;
    }
    public function getGuranteesByColorId()
    {
        $param = $this->request->getAssocParams();
        $this->sqlEngine->Select('t1.id,t1.stock ,t1.price,t1.majorPrice,t1.user_price,t1.discount,t2.id AS gurantee_id,t2.title AS gurantee_title,t1.type_discount')
            ->From($this->product_price_tbl . ' AS t1')
            ->leftJoin('shop_guarantee AS t2')
            ->On('t2.id=t1.guarantee_id')
            //->leftJoin ( 'shop_amazing AS t3' )
            //->On ( 't1.shop_product_id=t3.shop_product_id' )
            ->Where("t1.shop_product_id=?", $param['product_id']);
        if ($param['color_id'] == '0') {
            $this->sqlEngine->andWhere("t1.color_id=0");
        } else {
            $this->sqlEngine->andWhere("t1.color_id=?", $param['color_id']);
        }
        $this->sqlEngine->andWhere("t1.stock>0");
        $this->sqlEngine->OrderBy('t1.price ASC');
        $this->sqlEngine->Run();
        // \f\pr($param);
        // \f\pre($this->sqlEngine->getRows());
        // \f\pre($this->sqlEngine->last_query ());
        return $this->sqlEngine->getRows();
    }

    public function checkStockByPriceId()
    {
        $param = $this->request->getAssocParams();
        //\f\pre($param);
        $this->sqlEngine->Select()
            ->From($this->product_price_tbl . ' AS t1')
            ->Where("t1.id=?", $param['product_price_id']);
        if (!$param['lastCheck']) {
            $this->sqlEngine->andWhere("t1.stock>0");
        }
        $this->sqlEngine->Run();

        // \f\pr($param);
        // \f\pre($this->sqlEngine->last_query());
        //  \f\pre($this->sqlEngine->getRow());
        return $this->sqlEngine->getRow();
    }

    public function getStockByProductId()
    {
        $param = $this->request->getAssocParams();
        $this->sqlEngine->Select()
            ->From($this->product_price_tbl . ' AS t1')
            ->Where("t1.shop_product_id=?", $param['product_id']);
        if (!$param['lastCheck']) {
            $this->sqlEngine->andWhere("t1.stock>0");
        }
        $this->sqlEngine->Run();
       // \f\pre();
        return $this->sqlEngine->getRow();
    }

    public function getPriceByProductId(){
        $param = $this->request->getAssocParams();
        $this->sqlEngine->Select("t1.id,t1.shop_product_id,t1.color_id,t1.guarantee_id,t1.material_id,t1.price,t1.majorPrice,t1.user_price,t1.discount,t1.type_discount,shop_material.name")
            ->From($this->product_price_tbl . ' AS t1')
            ->innerJoin('shop_material')
            ->on('shop_material.id=t1.material_id')
            ->Where("t1.shop_product_id=?", $param['product_id'])
            ->andWhere("t1.material_id>0");
        $this->sqlEngine->Run();
        //\f\pr($param['product_id']);
 //       \f\pre($this->sqlEngine->getRow());
        return $this->sqlEngine->getRows();
    }
    public function minesPlusProductStock()
    {
        $param = $this->request->getAssocParams();

        $sql = "stock=stock" . $param['changeModel'] . $param['count'];
        $this->sqlEngine->Update($this->product_price_tbl)
            ->setField($sql)
            ->Where('id=?', $param['id'])
            ->Run();
    }

    public function getCompareProductDetail()
    {
        $params = $this->request->getAssocParams();

        $this->sqlEngine->Select('t1.id,t1.picture,t1.title,t1.sub_title,t1.shop_category_id,t2.price AS price,t2.discount')
            ->From($this->product_tbl . ' AS t1')
            ->Join($this->product_price_tbl . ' AS t2')
            ->Where('status=?', 'enabled')
            ->andWhere('t1.id IN (' . $params['id'] . ')')
            ->andWhere('t1.id=t2.shop_product_id')
            ->GroupBy('t1.id')
            ->OrderBy('t2.price ASC')
            ->Run();

        $row = $this->sqlEngine->getRows();

        return $row;
    }

    public function getProductByBrand()
    {
        $params = $this->request->getAssocParams();

        $this->sqlEngine->Select('id,title')
            ->From($this->product_tbl)
            ->Where('shop_brand_id=?', $params['id'])
            ->andWhere('status=?', 'enabled')
            ->andWhere('shop_category_id=?', $params['category'])
            ->OrderBy('id DESC')
            ->Limit(100)
            ->Run();
        return $this->sqlEngine->getRows();
    }

    public function getProductByBrandId()
    {
        //$ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;
        $param = $this->request->getAssocParams();
        $num = $param['numPerPage'];
        $min = ($param['page'] - 1) * $num;
        //\f\pre($min);

        $this->sqlEngine->Select('*')
            ->From($this->product_tbl)
            ->Where('status=?', 'enabled')
            ->andWhere('shop_brand_id=?', $param['id'])
            ->OrderBy('id DESC')
            ->Limit("$min,$num")
            ->Run();
        $row = $this->sqlEngine->getRows();

        $this->sqlEngine->Select('id')
            ->From($this->product_tbl)
            ->Where('status=?', 'enabled')
            ->andWhere('shop_brand_id=?', $param['id'])
            ->OrderBy('id DESC')
            ->Run();
        $num = $this->sqlEngine->numRows();

        return array(
            $row,
            $num);
    }

    public function getGiftsProduct()
    {
        //$ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;
        $param = $this->request->getAssocParams();
        //\f\pre($param);
        $num = $param['numPerPage'];
        $min = ($param['page'] - 1) * $num;
        //\f\pre($min);

        $this->sqlEngine->Select('*')
            ->From($this->product_tbl)
            ->Where('status=?', 'enabled')
            ->andWhere('gifts=?', 'enabled')
            ->OrderBy('id DESC')
            ->Limit("$min,$num")
            ->Run();
        $row = $this->sqlEngine->getRows();

        $this->sqlEngine->Select('id')
            ->From($this->product_tbl)
            ->Where('status=?', 'enabled')
            ->andWhere('gifts=?', 'enabled')
            ->OrderBy('id DESC')
            ->Run();
        $num = $this->sqlEngine->numRows();

        return array(
            $row,
            $num);
    }

    public function updateAvgCountRate()
    {
        $params = $this->request->getAssocParams();

        $result = $this->sqlEngine->Update($this->product_tbl)
            ->setField('rate_avg=' . $params['rate_avg'] . ' , rate_count=rate_count' . $params['rate_count'])
            ->Where('id=?', $params['id'])
            ->Run();
        return $result;
    }

    public function getProductListForApp()
    {
        $params = $this->request->getAssocParams();
        $this->sqlEngine->Select('T1.id,T1.title,T1.sub_title,T1.shop_category_id,T1.shop_brand_id,T2.price,T1.picture')
            ->From($this->product_tbl . ' AS T1')
            ->leftJoin($this->product_price_tbl . ' AS T2')
            ->On('T1.id=T2.shop_product_id')
            ->Where('T1.status=?', 'enabled');
        if ($params['title']) {
            $this->sqlEngine->andWhere("T1.title like '%" . $params['title'] . "%'");
        }
        if ($params['cat_id']) {
            $this->sqlEngine->andWhere("T1.shop_category_id =?",
                $params['cat_id']);
        }
        if ($params['brand_id']) {
            $this->sqlEngine->andWhere("T1.shop_brand_id =?",
                $params['brand_id']);
        }
        if (isset($params['orderby'])) {
            $orderby = $params['orderby'];
            $sort = $params['sort'];
            switch ($orderby) {
                case "date_register":
                    $this->sqlEngine->OrderBy('T1.date_register ' . $sort);
                    break;
                case "price":
                    $this->sqlEngine->OrderBy('T2.price ' . $sort);
                    break;
            }
        }
        if (isset($params['offset']) && $params['offset'] >= 0) {
            $offset = $params['offset'];
            $len = 25;
            $this->sqlEngine->Limit("$offset,$len");
        }
        $this->sqlEngine->Run();
        return $this->sqlEngine->getRows();
    }

    public function getDiscountForProductGroup(){
        $param = $this->request->getAssocParams();
        $this->sqlEngine->Select( '*' )
            ->From( $this->product_tbl . ' AS t1' )
            ->Where( 't1.id=?',$param['id'] )
            ->Run();
        $row = $this->sqlEngine->getRow();
        $brand_pro=$row['shop_brand_id'];
        $arrayPriceDiscount=array();
        $i=0;
        $this->sqlEngine->Select( 'id,type_discount,discount' )
            ->From('shop_brand as t1' )
            ->where("t1.id=?",$brand_pro)
            ->Run();;
        $rowBrand=$this->sqlEngine->getRow();

        if(!empty($rowBrand)){
            $arrayPriceDiscount[$i]= $rowBrand;
        }

        return $arrayPriceDiscount;
    }

    public function getProductBrand(){
        $params = $this->request->getAssocParams();
        $this->sqlEngine->Select( 't1.shop_brand_id' )
            ->From( $this->product_tbl . ' AS t1' )
            ->Where( 't1.id=?',$params['id'] )
            ->Run();
        $row = $this->sqlEngine->getRow();
        return $row;
    }
    public function favoriteSave(){
        $params = $this->request->getAssocParams();
        $result = $this->sqlEngine->save('shop_favorite_product',
            array(
              'product_id'=>$params['productId'],
              'user_id'=>$params['user_id']
            )
        );
        return $result;
    }

    public function getFavoriteProductByUseId()
    {
        $param = $this->request->getAssocParams();
        $this->sqlEngine->Select()
            ->From($this->shop_favorite_product_tbl . ' AS t1')
            ->Where('t1.user_id=?', $param['user_id'])
            ->Run();
       //\f\pre($this->sqlEngine->getRow());
        return $this->sqlEngine->getRows();
    }
    public function deleteFaveProduct()
    {
        $param = $this->request->getAssocParams();
        $id = $param['user_id'];
        $productId = $param['p_id'];
        $this->sqlEngine->remove($this->shop_favorite_product_tbl,
            [
                'user_id=? AND product_id=?',
                [
                    $id,$productId
                ]]);
        return array(
            'result' => 'success',
            'func' => 'remove');
    }

    public function getTypeCat(){
        $param = $this->request->getAssocParams();
        $this->sqlEngine->Select()
             ->From('shop_category AS t1')
             ->Where('t1.id=?', $param['id'])
             ->Run();
        return $this->sqlEngine->getRow();
    }
}
