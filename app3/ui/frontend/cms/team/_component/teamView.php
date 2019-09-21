<?php

class teamView extends \f\view
{

    public function __construct ()
    {
        
    }

    public function renderGetTeamList ( $param )
    {

        $row = \f\ttt::service ( 'cms.content.getTeamList',
                                 $param
                        , true ) ;
        //\f\pr($state);
        if ( $param[ 'type' ] == 'main' )
        {
            return $this->render ( 'mainTeam',
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

    public function renderGetTeamDetail ( $params )
    {
        $id  = $params[ 0 ] ;
        //\f\pre($id);
        \f\ttt::service ( 'cms.team.items.setTeamVisit',
                          array (
            'id' => $id
        ) ) ;
        $row = \f\ttt::service ( 'cms.team.items.getItemsById',
                                 array (
                    'id' => $id
                ) ) ;

        $sRow = \f\ttt::service ( 'cms.team.category.getCategoryById',
                                  array (
                    'id' => $row[ 'category_id' ]
                ) ) ;

        $picture = \f\ttt::service ( 'core.fileManager.getList',
                                     array (
                    'path' => 'cms.team.' . $id,
                ) ) ;

        //\f\pre($picture['list']);
        foreach ( $picture[ 'list' ] AS $data )
        {
            $picArr[ $data[ 'id' ] ][ 'title' ] = $data[ 'title' ] ;
            $picArr[ $data[ 'id' ] ][ 'path' ]  = $this->filePath ( $data[ 'path' ] ) ;
        }
        //\f\pre($picArr);


        $content = $this->render ( 'detailTeam',
                                   array (
            'row'     => $row,
            'sRow'    => $sRow,
            'picture' => $picArr
                ) ) ;

        return array (
            $content,
            $row,
            array () ) ;
    }

    public function filePath ( $path )
    {
        $path = \f\ifm::app ()->siteUrl . 'upload/' . (str_replace ( '-', '.',
                                                                     str_replace ( '.',
                                                                                   '/',
                                                                                   $path ) )) ;
        return $path ;
    }

    public function renderGetTeam ( $param )
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

        $array = \f\ttt::service ( 'cms.team.items.getTeam',
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
            $sRow = \f\ttt::service ( 'cms.team.category.getCategoryById',
                                      array (
                        'id' => $section
                    ) ) ;
        }
        else
        {
            $sRow[ 'title' ] = 'محصولات' ;
        }

        //\f\pr($state);
        $content = $this->render ( 'team',
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
    
    public function renderGetPersonnel ( $params )
    {
        $row                 = \f\ttt::service ( 'cms.team.personnel.getPersonnelByParam',
                                                 $params ) ;
        
        //\f\pre($params);
        return $this->render ( 'personnel',
                               array (
                    'row' => $row
                        )
                ) ;
    }

}
