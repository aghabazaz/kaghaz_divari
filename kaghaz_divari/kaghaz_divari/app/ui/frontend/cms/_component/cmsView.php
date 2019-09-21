<?php

class cmsView extends \f\view
{

    public function __construct ()
    {
        
    }

    public function renderGetSlideList ()
    {
        //\f\pre('ok');

        $slide = \f\ttt::service ( 'cms.slide.getSlideList',
                                   array (
                    'status' => 'enabled'
                        ), true ) ;
        return $this->render ( 'slideList_2',
                               array (
                    'row' => $slide ) ) ;
    }

    public function renderGetAbout ()
    {

        $about = \f\ttt::service ( 'cms.about.getAboutSetting' ) ;
        //\f\pr($state);
        return $this->render ( 'about_2',
                               array (
                    'row' => $about ) ) ;
    }

    public function renderGetContact ()
    {

        $social = \f\ttt::service ( 'cms.socialnet.getSocialnetSetting',
                                    array (
                ) ) ;
        return $this->render ( 'contact_2',
                               array (
                    'row' => $social
                ) ) ;
    }

    public function renderGetContentList ( $param )
    {

        $row = \f\ttt::service ( 'cms.content.getContentList',
                                 $param
                        , true ) ;
        //\f\pre($param);
        if ( $param[ 'type' ] == 'main' )
        {
            return $this->render ( 'mainContent',
                                   array (
                        'row' => $row ) ) ;
        }
        else
        {
            return $this->render ( 'contentList_1',
                                   array (
                        'row' => $row ) ) ;
        }
    }
    public function renderContentMainList ()
    {
        $contntList = \f\ttt::dal ( 'cms.content.getContentList',
            array (
                'status' => 'enabled',
                'special' => 'enabled',
                'limit'  => 4
            ), true ) ;

        if ($contntList){
            return $this->render ( 'ctnList',
                array (
                    'contntList' => $contntList
                ) ) ;
        }else{
            return "&nbsp";
        }

    }

    public function renderGetTag ( $param )
    {
        $page = $param[ 3 ] ;
        $tag  = $param[ 0 ] ;

        $numPerPage = 10 ;
        if ( ! $page )
        {
            $page = 1 ;
        }

        $array = \f\ttt::service ( 'cms.content.getContentByTagId',
                                   array (
                    'status'     => 'enabled',
                    'page'       => $page,
                    'numPerPage' => $numPerPage,
                    'id'         => $tag
                        ), true ) ;

        $row = $array[ 0 ] ;
        $num = $array[ 1 ] ;

        if ( $tag )
        {
            $sRow = \f\ttt::service ( 'cms.tag.getTagById',
                                      array (
                        'id' => $tag
                    ) ) ;
        }
        else
        {
            $sRow[ 'title' ] = 'برچسب ها' ;
        }

        //\f\pr($state);
        $content = $this->render ( 'tagList',
                                   array (
            'row'      => $row,
            'sRow'     => $sRow,
            'num_page' => $numPerPage,
            'num'      => $num,
            'page'     => $page
                ) ) ;

        return array (
            $content,
            $sRow ) ;
    }

    public function renderGetContentDetail ( $params )
    {
        $id  = $params[ 0 ] ;
        //\f\pre($id);
        \f\ttt::service ( 'cms.content.setContentVisit',
                          array (
            'id' => $id
        ) ) ;
        $row = \f\ttt::service ( 'cms.content.getContentById',
                                 array (
                    'id' => $id
                ) ) ;
        // \f\pre($row);

        $keyword    = \f\ttt::service ( 'cms.content.getContentKeywordById',
                                        array (
                    'id' => $id,
                        ), true ) ;
        $keywordArr = array () ;
        $keywordStr = '' ;
        foreach ( $keyword AS $data )
        {
            $keywordStr   .= '<div  style="padding:5px;background:#eee;border-radius:5px;margin:0px 0px 0px 5px;float:right"><a target="_blank" href="'. $data['link'] .'">' . $data[ 'title' ] . '</a></div>' ;
            $keywordArr[] = $data[ 'title' ] ;
        }
    
        $related = \f\ttt::service ( 'cms.content.getContentRelatedById',
                                     array (
                    'id' => $id,
                        ), true ) ;
        $tag = \f\ttt::dal ( 'cms.content.getContentTagById',
            array (
                'id' => $row[ 'id' ]
            ) ) ;
        //\f\pre($keyword);
        $content = $this->render ( 'detailContent_1',
                                   array (
            'row'     => $row,
            'tag' => $tag,
            'keyword' => $keywordStr,
            'related' => $related
                ) ) ;

        return array (
            $content,
            $row,
            $keywordArr,
                ) ;
    }

    public function renderGetContent ( $param )
    {

        if ( $param[ 0 ] == 'page' )
        {
            $page = $param[ 1 ] ;
        }
        else
        {
            $page    = $param[ 2 ] ;
            $section = $param[ 0 ] ;
        }

        $numPerPage = 10 ;

        if ( ! $page )
        {
            $page = 1 ;
        }

        $array = \f\ttt::service ( 'cms.content.getContent',
                                   array (
                    'status'     => 'enabled',
                    'page'       => $page,
                    'numPerPage' => $numPerPage,
                    'section'    => $section
                        ), true ) ;

        $row = $array[ 0 ] ;
        $num = $array[ 1 ] ;

        if ( $section )
        {
            $sRow = \f\ttt::service ( 'cms.section.getSectionById',
                                      array (
                        'id' => $section
                    ) ) ;
        }
        else
        {
            $sRow[ 'title' ] = 'مطالب و مقالات' ;
        }

        //\f\pr($state);
        $content = $this->render ( 'content_1',
                                   array (
            'row'      => $row,
            'sRow'     => $sRow,
            'num_page' => $numPerPage,
            'num'      => $num,
            'page'     => $page
                ) ) ;

        return array (
            $content,
            $sRow ) ;
    }

    public function renderGetSpecialProduct ( $params )
    {
        $params[ 'special' ] = 'enabled' ;
        $row                 = \f\ttt::service ( 'cms.product.items.getItemsByParam',
                                                 $params ) ;
        return $this->render ( 'specialProduct',
                               array (
                    'row' => $row
                        )
                ) ;
    }
    public function renderGetTextTempleteList ( $params )
    {
        $params[ 'special' ] = 'enabled' ;
        $params['limit'] = 4 ;
        $row                 = \f\ttt::service ( 'cms.textTemplate.getTextTemplateList',
                                                 $params ) ;
        return $this->render ( 'textTempleteList',
                               array (
                    'row' => $row
                        )
                ) ;
    }
    public function renderGetLastProduct ( $params )
    {
        $row = \f\ttt::service ( 'cms.product.items.getItemsByParam', $params ) ;
        return $this->render ( 'lastProductMain',
                               array (
                    'row' => $row
                        )
                ) ;
    }

    public function renderGetNewsList ( $param )
    {

        $row = \f\ttt::service ( 'cms.news.getNewsList',
                                 $param
                        , true ) ;
        //\f\pr($state);
        if ( $param[ 'type' ] == 'main' )
        {
            return $this->render ( 'mainNews',
                                   array (
                        'row' => $row ) ) ;
        }
        else
        {
            return $this->render ( 'newsList',
                                   array (
                        'row' => $row ) ) ;
        }
    }

    public function renderGetNewsDetail ( $params )
    {
        $id  = $params[ 0 ] ;
        //\f\pre($id);
        \f\ttt::service ( 'cms.news.setNewsVisit',
                          array (
            'id' => $id
        ) ) ;
        $row = \f\ttt::service ( 'cms.news.getContentById',
                                 array (
                    'id' => $id
                ) ) ;

        //\f\pre($row);




        $content = $this->render ( 'detailNews',
                                   array (
            'row' => $row,
                ) ) ;

        return array (
            $content,
            $row ) ;
    }

    public function renderGetNews ( $param )
    {

        if ( $param[ 0 ] == 'page' )
        {
            $page = $param[ 1 ] ;
        }

        $numPerPage = 10 ;

        if ( ! $page )
        {
            $page = 1 ;
        }

        $array = \f\ttt::service ( 'cms.news.getNews',
                                   array (
                    'status'     => 'enabled',
                    'page'       => $page,
                    'numPerPage' => $numPerPage,
                        ), true ) ;

        $row = $array[ 0 ] ;
        $num = $array[ 1 ] ;


        $sRow[ 'title' ] = 'اخبار و اطلاعیه ها' ;


        //\f\pr($state);
        $content = $this->render ( 'news',
                                   array (
            'row'      => $row,
            'sRow'     => $sRow,
            'num_page' => $numPerPage,
            'num'      => $num,
            'page'     => $page
                ) ) ;

        return array (
            $content,
            $sRow ) ;
    }

    public function renderGetLastSurvey ( $param )
    {

        $row = \f\ttt::service ( 'cms.survey.renderSurveyFrontend',
                                 $param
                        , true ) ;

        $choice = \f\ttt::service ( 'cms.survey.getAnswresById',
                                    array (
                    'id' => $row[ 'questionId' ]
                        )
                        , true ) ;

        //\f\pre($row);

        return $this->render ( 'survey',
                               array (
                    'row'    => $row,
                    'choice' => $choice ) ) ;
    }

    public function renderAdvertise ( $param )
    {
        $this->registerGadgets ( array (
            'dateG' => 'date' ) ) ;
        $param[ 'date' ] = $this->dateG->today () ;
        $row             = \f\ttt::service ( 'cms.advertisement.getListAdvertiseByPlan',
                                             $param, true ) ;
        return $this->render ( 'advertise',
                               array (
                    'row'  => $row,
                    'plan' => $param[ 'plan' ]
                ) ) ;
    }

    public function getVisitInfo ()
    {
        $data_visit = \f\ttt::service ( 'core.visit.getDataVisit',
                                        array (
                    'site_id' => 1 ) ) ;
        $visit_all  = \f\ttt::service ( 'core.visit.visitAll',
                                        array (
                    'site_id' => 1 ) ) ;

        return $this->render ( 'visitInfo',
                               array (
                    'data_visit' => $data_visit,
                    'visit_all'  => $visit_all,
                ) ) ;
    }

    public function renderGetAjaxSearchAllIndex ( $params )
    {
        $params[ 'limit' ]   = 5 ;
//        $result_product_cats = \f\ttt::service ( 'shop.category.getProductCatsByAjaxSearch',
//                                                 $params ) ;

        $result_products = \f\ttt::service ( 'shop.product.getProductsByAjaxSearch',
                                             $params ) ;
//        $result_brands   = \f\ttt::service ( 'shop.brand.getBrandsByAjaxSearch',
//                                             $params ) ;//

     //   $result_contents       = \f\ttt::service ( 'cms.content.getContentsByAjaxSearch',
          //                                         $params ) ;
        //$result_news           = \f\ttt::service ( 'cms.news.getNewsByAjaxSearch',
                                              // $params ) ;
        //\f\pre($result_contents);
        return $this->render ( 'ajaxSearchIndex',
                               array (
                    'product_cat_items' => $result_product_cats,
                    'product_items'     => $result_products,
//                    'brand_items'       => $result_brands,
                    'search'            => $params[ 'keyword' ],
                    'content_items'     => $result_contents,
                    //'content_items'     => $result_contents,
                ) ) ;
    }

}
