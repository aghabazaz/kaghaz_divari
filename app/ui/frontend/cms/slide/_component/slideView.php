<?php

class slideView extends \f\view
{

    public function __construct ()
    {
        
    }

    public function renderGetSlideList ( $param )
    {

        $SlideList = \f\ttt::service ( 'cms.slide.getSlideList',
                                 $param
                        , true ) ;
        //\f\pre($SlideList[0]);
        //\f\pre($SlideList);
        return $this->render ( 'slide',
                                   array (
                        'SlideList' => $SlideList[0]) ) ;
        
    }

    public function renderGetSlideDetail ( $params )
    {
        $id  = $params[ 0 ] ;
        //\f\pre($id);
        \f\ttt::service ( 'cms.slide.items.setSlideVisit',
                          array (
            'id' => $id
        ) ) ;
        $row = \f\ttt::service ( 'cms.slide.items.getItemsById',
                                 array (
                    'id' => $id
                ) ) ;

        $sRow = \f\ttt::service ( 'cms.slide.category.getCategoryById',
                                  array (
                    'id' => $row[ 'category_id' ]
                ) ) ;

        $picture = \f\ttt::service ( 'core.fileManager.getList',
                                     array (
                    'path' => 'cms.slide.' . $id,
                ) ) ;

        //\f\pre($picture['list']);
        foreach ( $picture[ 'list' ] AS $data )
        {
            $picArr[ $data[ 'id' ] ][ 'title' ] = $data[ 'title' ] ;
            $picArr[ $data[ 'id' ] ][ 'path' ]  = $this->filePath ( $data[ 'path' ] ) ;
        }
        //\f\pre($picArr);


        $content = $this->render ( 'detailSlide',
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

    public function renderSlideList ( )
    {
        $slideList = \f\ttt::service ( 'cms.slide.getSlideList',
                                   array (
                    'status'     => 'enabled',
                    'limit' => 5
                        ), true ) ;

        return $this->render ( 'slide',
                                   array (
            'slideList'      => $slideList,
            
                ) ) ;

       
    }
    
    public function renderGetPersonnel ( $params )
    {
        $row                 = \f\ttt::service ( 'cms.slide.personnel.getPersonnelByParam',
                                                 $params ) ;
        
        //\f\pre($params);
        return $this->render ( 'personnel',
                               array (
                    'row' => $row
                        )
                ) ;
    }

}
