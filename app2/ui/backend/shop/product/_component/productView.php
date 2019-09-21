<?php

class productView extends \f\view
{

    public function renderGrid ()
    {

        return $this->render ( 'productList', array (
                ) ) ;
    }

    public function renderProductAdd ( $id = '' )
    {
        if ( $id )
        {
            $row = \f\ttt::service ( 'shop.product.getProductById',
                                     array (
                        'id' => $id ) ) ;
            $price = \f\ttt::service ( 'shop.product.getPriceByProductById',
                                       array (
                        'id' => $id ) ) ;
            $priceHistory = \f\ttt::service ( 'shop.product.getPriceByProductById',
                                              array (
                        'id'      => $id,
                        'history' => TRUE ) ) ;
            $history      = $priceHistory[ 0 ] ;
        }
        else
        {
            if ( ! isset ( $_SESSION[ 'galId' ] ) )
            {
                $id                  = rand ( 10000, 100000 ) ;
                $_SESSION[ 'galId' ] = $id ;

                \f\ttt::service ( 'core.fileManager.createFolder',
                                  array (
                    'path'  => 'shop.product',
                    'name'  => $id,
                    'title' => 'آلبوم پیش فرض'
                ) ) ;
            }
            else
            {
                $id = $_SESSION[ 'galId' ] ;
            }
        }
        $picture = \f\ttt::service ( 'core.fileManager.getList',
                                     array (
                    'path' => 'shop.product.' . $id,
                ) ) ;
        $numPic  = 0 ;

        foreach ( $picture[ 'list' ] AS $data )
        {
            if($data['type']=='file')
            {
                $params = array (
                'id'    => $data[ 'id' ],
                'size'  => $data[ 'size' ],
                'title' => $data[ 'title' ]
                    ) ;
            $gallery.=$this->render ( 'galleryPic',
                                      array (
                'params' => $params,
                'cover'  => $row[ 'picture' ],
                'id'     => $row[ 'id' ]
                    ) ) ;
            $numPic ++ ;
            }
        }
        $cover = $row[ 'picture' ] ;

        $color = \f\ttt::service ( 'shop.color.getColorByOwnerId' ) ;
        foreach ( $color AS $data )
        {
            $colorArr[ $data[ 'id' ] ] = $data[ 'title' ] ;
        }

        $guarantee = \f\ttt::service ( 'shop.guarantee.getGuaranteeByOwnerId' ) ;
        foreach ( $guarantee AS $data )
        {
            $guaranteeArr[ $data[ 'id' ] ] = $data[ 'title' ] ;
        }

        $product = \f\ttt::service ( 'shop.product.getProductByOwnerId' ) ;
        foreach ( $product AS $data )
        {
            $productArr[ $data[ 'id' ] ] = $data[ 'title' ] ;
        }

        $brand = \f\ttt::service ( 'shop.brand.getBrandByOwnerId' ) ;
        foreach ( $brand AS $data )
        {
            $brandArr[ $data[ 'id' ] ] = $data[ 'title_fa' ].' ( '.strtoupper($data['title_en']).' )' ;
        }

        $category = \f\ttt::service ( 'shop.category.getCategoryByOwnerId' ) ;
        $this->sort_category ( $category, NULL, $sort, '' ) ;


        $colorGuarantee = \f\ttt::dal ( 'shop.product.getProductByColorGuaranteeId' ) ;
        foreach ( $colorGuarantee AS $data2 )
        {
            $colorGuaranteeArray[ $data2[ 'id' ] ] = $data2[ 'title' ] ;
        }

        $material = \f\ttt::dal ( 'shop.material.getMaterial' ) ;
        foreach ( $material AS $data2 )
        {
            $materialArray[ $data2[ 'id' ] ] = $data2[ 'name' ] ;
        }


        if($row['active_gift_section']=='enabled'){
            $check='checked';
        }else{
            $check='';
        }

       // \f\pr($productArr);
       // \f\pr($row);
      // \f\pre($price);
        return $this->render ( 'productAdd',
                               array (
                    'row'       => $row,
                    'id'        => $id,
                    'numPic'    => $numPic,
                    'cover'     => $cover,
                    'gallery'   => $gallery,
                    'color'     => $colorArr,
                    'guarantee' => $guaranteeArr,
                    'product'   => $productArr,
                    'category'  => $sort,
                    'price'     => $price,
                    'history'   => $history,
                    'brand'     => $brandArr,
                    'colorGuarantee'=>$colorGuaranteeArray,
                                   'checkedInput'=>$check,
                                   'material'=>$materialArray,
                                       'dynamic'=>$row['dynamic']
                ) ) ;
    }

    public function renderProductGrid ( $requestDataTble )
    {

        /** Get group list * */
        $this->registerGadgets ( array (
            'dateG' => 'date' ) ) ;


        $productList = \f\ttt::service ( 'shop.product.productList',
                                         array (
                    'dataTableParams' => $requestDataTble ) ) ;
        foreach ( $productList[ 'data' ] as $key => $value )
        {

            $tdContent = $this->createActionButtons ( $value, 'product' ) ;

            $field = array (
                array (
                    'style'     => array (
                        'border' => 'none',
                    ),
                    'formatter' => "<div class='simple-checkbox'><input id='f" . $value[ 'id' ] . "' type='checkbox' class='checkBox'/><label for='f" . $value[ 'id' ] . "'></label></div>"
                ),
                array (
                    'htmlOptions' => array (
                        'id' => 'bgparent',
                    ),
                    'style'       => array (
                        'border' => 'none',
                        'color'  => 'red !important'
                    ),
                    'formatter'   => $value[ 'title' ]
                ),
                array (
                    'htmlOptions' => array (
                        'id' => 'bgparent',
                    ),
                    'style'       => array (
                        'border' => 'none',
                        'color'  => 'red !important'
                    ),
                    'formatter'   => $value[ 'catTitle' ]
                ),
                array (
                    'htmlOptions' => array (
                        'class' => 'act',
                    ),
                    'style'       => array (
                        'border' => 'none'
                    ), //onclick='widgetHelper.remove(\"" . $value[ 'id' ] . "\",\"c\",\"core.user.remove\" )'
                    'formatter'   => $tdContent,
                ),
                    ) ;
            // tr make
            // data-on-confirm='hi'
            $row[] = array (
                'htmlOptions' => array (
                    'id'    => '',
                    'class' => 'c' . $value[ 'id' ],
                ),
                'style'       => array (
                    'background' => 'red !important'
                ),
                'td'          => $field
                    ) ;
        }
        $row[ 'total' ] = $productList[ 'total' ] ;
        $row[ 'draw' ]  = $productList[ 'draw' ] ;
        /* @var $table \f\w\table */
        $table          = \f\widgetFactory::make ( 'table' ) ;

        $userListRow = $table->renderRow ( $row ) ;
        return $userListRow ;
    }

    private function createActionButtons ( $data, $section )
    {
        $buttonsParam = array (
            array (
                'type' => 'edit',
                'href' => \f\ifm::app ()->baseUrl . "shop/product/" . $section . "Edit/" . $data[ 'id' ]
            ),
            array (
                'type'           => 'status',
                'confirm'        => TRUE,
                'id'             => 's' . $data[ 'id' ],
                'status'         => $data[ 'status' ],
                'action'         => 'shop.product.' . $section . 'Status',
                'clientCallBack' => 'toggleEnable',
                'params'         => array (
                    'id'     => $data[ 'id' ],
                    'status' => "\"{$data[ 'status' ]}\""
                ),
            ),
            array (
                'type'           => 'delete',
                'confirm'        => true,
                'action'         => 'shop.product.' . $section . 'Delete',
                'clientCallback' => 'remove',
                'params'         => array (
                    'id'       => $data[ 'id' ],
                    'selector' => "\"#f{$data[ 'id' ]}\""
                )
            ),
            array (
                'type'           => 'special',
                'confirm'        => TRUE,
                'id'             => 'sp' . $data[ 'id' ],
                'status'         => $data[ 'special' ],
                'action'         => 'shop.product..' . $section . 'Special',
                'clientCallBack' => 'toggleEnable',
                'params'         => array (
                    'id'     => $data[ 'id' ],
                    'status' => "\"{$data[ 'special' ]}\""
                ),
            ),
            array (
                'type'         => 'custom',
                'title'        => 'سئو و بهینه سازی سایت',
                'icon'         => 'fa fa-paw fa-lg',
                'id'           => "ps_" . $data[ 'id' ],
                'clientAction' => array (
                    'display' => 'dialog',
                    'params'  => array (
                        'targetRoute'    => "core.seo.editParameterDialog",
                        'triggerElement' => "ps_" . $data[ 'id' ],
                        'dialogTitle'    => 'سئو و بهینه سازی سایت',
                        'ajaxParams'     => array (
                            'component_id' => 'productItems',
                            'item_id'      => $data[ 'id' ]
                        )
                    )
                )
            )
                ) ;
        return \f\html::gridButton ( $buttonsParam ) ;
    }

    public function addPic ( $params )
    {
        $params[ 'size' ] = $this->fileSize ( $params[ 'fileId' ][ 0 ] ) ;
        $params[ 'id' ]   = $params[ 'fileId' ][ 0 ] ;
        return $this->render ( 'galleryPic',
                               array (
                    'params' => $params,
                    'id'     => $params[ 'galId' ]
                ) ) ;
    }

    public function fileSize ( $id )
    {
        $ch = curl_init ( \f\ifm::app ()->fileBaseUrl . $id ) ;

        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, TRUE ) ;
        curl_setopt ( $ch, CURLOPT_HEADER, TRUE ) ;
        curl_setopt ( $ch, CURLOPT_NOBODY, TRUE ) ;

        $data = curl_exec ( $ch ) ;
        $size = curl_getinfo ( $ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD ) ;

        curl_close ( $ch ) ;
        return $size ;
    }

    public function renderGalleryPic ( \f\request $request )
    {

        $mode        = $request->getParam ( 'mode' ) ;
        $replace     = $request->getParam ( 'replace' ) ;
        $fileId      = $request->getParam ( 'fileId' ) ;
        $uploadKey   = $request->getParam ( 0 ) ;
        $path        = $request->getParam ( 'path' ) ;
        $customField = $request->getParam ( 'customField' ) ;
        $func        = $request->getParam ( 'func' ) ;

        $fileContainerId = $request->getParam ( 'fileContainerId' ) ;

        $limitParams = \f\ttt::service ( 'core.fileManager.getLimitParams',
                                         array (
                    'uploadKey'   => $uploadKey,
                    'customField' => $customField
                ) ) ;

        $output = '' ;
        if ( in_array ( 'upload', $limitParams[ 'tasks' ] ) )
        {
            $uploadFormParams = array (
                'limitParams'     => $limitParams,
                'uploadKey'       => $uploadKey,
                'mode'            => $mode,
                'replace'         => $replace,
                'fileId'          => $fileId,
                'fileContainerId' => $fileContainerId,
                'path'            => $path,
                'func'            => $func,
                'customField'     => $customField
                    ) ;
            if ( $request->getParam ( 'params' ) )
            {
                $uploadFormParams[ 'params' ] = $request->getParam ( 'params' ) ;
            }

            $output .= $this->render ( 'uploadGallery', $uploadFormParams ) ;
        }
        return $output ;
    }

    public function sort_category ( $category, $parentId, &$sort, $strId )
    {
        foreach ( $category AS $data )
        {
            if ( $data[ 'parent_id' ] == $parentId )
            {
                if ( $strId )
                {
                    $id = $strId . ',' . $data[ 'id' ] ;
                }
                else
                {
                    $id = $data[ 'id' ] ;
                }

                $sort[ $data[ 'id' ] ][ 'id' ]     = $data[ 'id' ] ;
                $sort[ $data[ 'id' ] ][ 'title' ]  = $data[ 'title' ] ;
                $sort[ $data[ 'id' ] ][ 'parent' ] = $id ;
                $sort[ $data[ 'id' ] ][ 'dynamic' ]= $data['dynamic'];
                $this->sort_category ( $category, $data[ 'id' ], $sort, $id ) ;
            }
        }
        return $sort ;
    }

    public function renderLoadFeature ( $params )
    {
        $id   = explode ( ',', $params[ 'id' ] ) ;

       // \f\pre($params);
        session_start();
        /*session is started if you don't write this line can't use $_Session  global variable*/
        $_SESSION["typeCat"]=$params['catType'];
        //\f\pre($_SESSION);
        $wiki = \f\ttt::service ( 'shop.wiki.getWikiByOwnerId' ) ;
        foreach ( $wiki AS $data )
        {
            $wikiArr[ $data[ 'id' ] ] = $data[ 'title' ] ;
        }

        $this->registerWidgets ( array (
            'formW' => 'form',
        ) ) ;

        if ( $params[ 'pId' ] )
        {
            $pFeature = \f\ttt::service ( 'shop.product.getFeatureByProductId',
                                          array (
                        'id' => $params[ 'pId' ]
                    ) ) ;

            foreach ( $pFeature AS $data )
            {
                $pfValue[ $data[ 'shop_feature_item_id' ] ] = json_decode ( $data[ 'value' ],
                                                                            TRUE ) ;
            }
        }

        for ( $i = 0 ; $i < count ( $id ) ; $i ++ )
        {
            $row = \f\ttt::service ( 'shop.product.getFeatureByCatId',
                                     array (
                        'id' => $id[ $i ]
                    ) ) ;
            
            $feature.= $this->render ( 'feature',
                                       array (
                'row'   => $row,
                'wiki'  => $wikiArr,
                'value' => $pfValue
                    ) ) ;
        }

        if ( $feature == '' )
        {
            $feature = '<div class="alert alert-warning"><i class="fa fa-warning"></i> مشخصات فنی برای بخش بندی انتخاب شده تعریف نشده است.</div>' ;
        }

        return $feature ;
    }

}
