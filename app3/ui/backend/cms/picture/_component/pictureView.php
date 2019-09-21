<?php

class pictureView extends \f\view
{

    public function renderGrid ()
    {

        return $this->render ( 'pictureList', array (
                ) ) ;
    }

    public function renderPictureAdd ( $id = '' )
    {

        if ( $id )
        {
            $row = \f\ttt::service ( 'cms.picture.getPictureById',
                                     array (
                        'id' => $id ) ) ;
        }
        else
        {
            if ( ! isset ( $_SESSION[ 'galId' ] ) )
            {
                $id                  = rand ( 10000, 100000 ) ;
                $_SESSION[ 'galId' ] = $id ;

                \f\ttt::service ( 'core.fileManager.createFolder',
                                  array (
                    'path'  => 'cms.picture',
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
                    'path' => 'cms.picture.' . $id,
                ) ) ;
        $numPic  = 0 ;

        foreach ( $picture[ 'list' ] AS $data )
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
        $cover = $row[ 'picture' ] ;
        return $this->render ( 'pictureAdd',
                               array (
                    'row'       => $row,
                    'id'        => $id,
                    'numPic'    => $numPic,
                    'cover'     => $cover,
                    'gallery'   => $gallery,
                ) ) ;
    }

    public function renderPictureGrid ( $requestDataTble )
    {

        /** Get group list * */
        $this->registerGadgets ( array (
            'dateG' => 'date' ) ) ;


        $pictureList = \f\ttt::service ( 'cms.picture.pictureList',
                                         array (
                    'dataTableParams' => $requestDataTble ) ) ;
       // \f\pre($pictureList);
        foreach ( $pictureList[ 'data' ] as $key => $value )
        {

            $tdContent = $this->createActionButtons ( $value, 'picture' ) ;

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
        $row[ 'total' ] = $pictureList[ 'total' ] ;
        $row[ 'draw' ]  = $pictureList[ 'draw' ] ;
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
                'href' => \f\ifm::app ()->baseUrl . "cms/picture/" . $section . "Edit/" . $data[ 'id' ]
            ),
            array (
                'type'           => 'status',
                'confirm'        => TRUE,
                'id'             => 's' . $data[ 'id' ],
                'status'         => $data[ 'status' ],
                'action'         => 'cms.picture.' . $section . 'Status',
                'clientCallBack' => 'toggleEnable',
                'params'         => array (
                    'id'     => $data[ 'id' ],
                    'status' => "\"{$data[ 'status' ]}\""
                ),
            ),
            array (
                'type'           => 'delete',
                'confirm'        => true,
                'action'         => 'cms.picture.' . $section . 'Delete',
                'clientCallback' => 'remove',
                'params'         => array (
                    'id'       => $data[ 'id' ],
                    'selector' => "\"#f{$data[ 'id' ]}\""
                )
            ),
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
                $this->sort_category ( $category, $data[ 'id' ], $sort, $id ) ;
            }
        }
        return $sort ;
    }

    public function renderLoadFeature ( $params )
    {
        $id   = explode ( ',', $params[ 'id' ] ) ;

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
