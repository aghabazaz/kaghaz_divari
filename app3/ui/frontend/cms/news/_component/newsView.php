<?php

class newsView extends \f\view
{

    public function __construct ()
    {
        
    }

    public function renderGetNewsList ( $param )
    {
        $row = \f\ttt::service ( 'cms.content.getNewsList',
                                 $param
                        , true ) ;
        if ( $param[ 'type' ] == 'main' )
        {
            return $this->render ( 'mainNews',
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

    public function renderGetNewsDetail ( $params )
    {
        \f\ttt::dal ( 'cms.news.setVisit',
            array (
                'id' => $params
            ) ) ;
        $newsList   = \f\ttt::service ( 'cms.news.getNewsList',
                                            array (
                    'status' => 'enabled',
                    'limit'  => 5
                        ), true ) ;
        $newsDetailList = \f\ttt::service ( 'cms.news.getNewsDetail',
                                            array (
                    'status' => 'enabled',
                    'limit'  => 5,
                    'id'     => $params
                        ), true ) ;
        $content = $this->render ( 'newsDetail',
                               array (
                    'newsDetailList' => $newsDetailList,
                    'newsList'       => $newsList[0],
                ) ) ;
        return array (

            'content' => $content,

            'title' => $newsDetailList['title'] ) ;
    }

    public function renderNewsListDetail ( $params )
    {
        if ( $params[ 0 ] == 'page' )
        {
            $page = $params[ 1 ] ;
        }
        $numPerPage = 10 ;
        if ( ! $page )
        {
            $page = 1 ;
        }
        $newsList = \f\ttt::service ( 'cms.news.getNewsList',
                                      array (
                    'status'   => 'enabled',
                    'limit'    => 4,
                    'num_page' => $numPerPage,
                    'page'     => $page
                        ), true ) ;
        //\f\pre($newsList);
        $row      = $newsList[ 0 ] ;
        $num      = $newsList[ 1 ] ;
        return $this->render ( 'newsList',
                               array (
                    'newsList' => $row,
                    'num'      => $num,
                    'num_page' => $numPerPage,
                    'page'     => $page,
                ) ) ;
    }

    public function filePath ( $path )
    {
        $path = \f\ifm::app ()->siteUrl . 'upload/' . (str_replace ( '-', '.',
                                                                     str_replace ( '.',
                                                                                   '/',
                                                                                   $path ) )) ;
        return $path ;
    }

    public function renderNewsList ()
    {
        $newsList = \f\ttt::service ( 'cms.news.getNewsList',
                                      array (
                    'status' => 'enabled',
                    'limit'  => 4
                        ), true ) ;
        //\f\pre($newsList);
        return $this->render ( 'news',
                               array (
                    'newsList' => $newsList[0],
                ) ) ;
    }

    public function renderGetPersonnel ( $params )
    {
        $row = \f\ttt::service ( 'cms.news.personnel.getPersonnelByParam',
                                 $params ) ;

        //\f\pre($params);
        return $this->render ( 'personnel',
                               array (
                    'row' => $row
                        )
                ) ;
    }
}
