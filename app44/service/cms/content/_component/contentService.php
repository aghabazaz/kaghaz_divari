<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \chartex\crm\marketing\content
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class contentService extends \f\service
{

    /**
     *
     * @var shortcutMapper 
     */
    private $mapper ;

    public function __construct ()
    {
        $this->mapper = \f\dalFactory::make ( 'cms.content' ) ;
    }

    public function contentList ()
    {
        return \f\ttt::dal ( 'cms.content.contentList',
                             $this->request->getAssocParams () ) ;
    }

    public function contentSave ()
    {
        $params = $this->request->getAssocParams () ;


        if ( $params[ 'id' ] )
        {
            $result = \f\ttt::dal ( 'cms.content.contentSaveEdit', $params ) ;
            $msg    = \f\ifm::t ( 'contentSaveEdit' ) ;
            $reset  = FALSE ;
        }
        else
        {
            $result = \f\ttt::dal ( 'cms.content.contentSave', $params ) ;
            $msg    = \f\ifm::t ( 'contentSave' ) ;
            $reset  = TRUE ;
        }


        if ( $result )
        {
            $data = array (
                'result'  => 'success',
                'message' => $msg,
                'reset'   => $reset ) ;
        }
        else
        {
            $data = array (
                'result'  => 'error',
                'message' => \f\ifm::t ( 'dbError' ) ) ;
        }

        return $data ;
    }

    public function contentDelete ()
    {
        return \f\ttt::dal ( 'cms.content.contentDelete',
                             $this->request->getAssocParams () ) ;
    }

    public function contentStatus ()
    {
        return \f\ttt::dal ( 'cms.content.contentStatus',
                             $this->request->getAssocParams () ) ;
    }

    public function contentSpecial ()
    {
        return \f\ttt::dal ( 'cms.content.contentSpecial',
                             $this->request->getAssocParams () ) ;
    }

    public function getContentById ()
    {
        $param = $this->request->getAssocParams () ;
        return \f\ttt::dal ( 'cms.content.getContentById', $param ) ;
    }

    public function getContentRelatedByOwnerId ()
    {
        return \f\ttt::dal ( 'cms.content.getContentRelatedByOwnerId',
                             $this->request->getAssocParams () ) ;
    }

    public function getContentByOwnerId ()
    {
        return \f\ttt::dal ( 'cms.content.getContentByOwnerId',
                             $this->request->getAssocParams () ) ;
    }

    public function getMainPageContent ()
    {
        return \f\ttt::dal ( 'cms.content.getMainPageContent',
                             $this->request->getAssocParams () ) ;
    }

    public function getMainPageContentBySection ()
    {
        return \f\ttt::dal ( 'cms.content.getMainPageContentBySection',
                             $this->request->getAssocParams () ) ;
    }

    public function getMainPageContentByState ()
    {
        return \f\ttt::dal ( 'cms.content.getMainPageContentByState',
                             $this->request->getAssocParams () ) ;
    }

    public function setContentVisit ()
    {
        return \f\ttt::dal ( 'cms.content.setContentVisit',
                             $this->request->getAssocParams () ) ;
    }

    public function getMostVisitedNews ()
    {
        return \f\ttt::dal ( 'cms.content.getMostVisitedNews',
                             $this->request->getAssocParams () ) ;
    }

    public function getMostCommentNews ()
    {
        return \f\ttt::dal ( 'cms.content.getMostCommentNews',
                             $this->request->getAssocParams () ) ;
    }

    public function getContentKeywordById ()
    {
        return \f\ttt::dal ( 'cms.content.getContentKeywordById',
                             $this->request->getAssocParams () ) ;
    }

    public function getContentrelatedById ()
    {
        return \f\ttt::dal ( 'cms.content.getContentRelatedById',
                             $this->request->getAssocParams () ) ;
    }

    public function getAllNews ()
    {
        return \f\ttt::dal ( 'cms.content.getAllNews',
                             $this->request->getAssocParams () ) ;
    }

    public function getContentByCategoryId ()
    {
        //\f\pre('hoo');
        return \f\ttt::dal ( 'cms.content.getContentByCategoryId',
                             $this->request->getAssocParams () ) ;
    }

    public function getContentByTagId ()
    {
        //\f\pre('hoo');
        return \f\ttt::dal ( 'cms.content.getContentByTagId',
                             $this->request->getAssocParams () ) ;
    }

    public function getArchive ()
    {
        return \f\ttt::dal ( 'cms.content.getArchive',
                             $this->request->getAssocParams () ) ;
    }

    public function getLastContentApp ()
    {

        $params = $this->request->getNonAssocParams () ;
        $this->registerGadgets ( array (
            'dateG' => 'date' ) ) ;
        if ( count ( $params ) > 2 || (is_numeric ( $params[ 0 ] ) && $params[ 0 ]) )
        {
            $params_array = array (
                'firstId' => $params[ 0 ],
                'numLoad' => $params[ 1 ],
                'type'    => $params[ 2 ],
                'typeId'  => $params[ 3 ]
                    ) ;
        }
        else
        {
            $params_array = array (
                'firstId' => 0,
                'numLoad' => 0,
                'type'    => $params[ 0 ],
                'typeId'  => $params[ 1 ]
                    ) ;
        }
        $result = \f\ttt::dal ( 'cms.content.getLastContentApp', $params_array ) ;

        $i = 0 ;
        foreach ( $result AS $data )
        {
            $array[ $i ]              = $data ;
            $array[ $i ][ 'picture' ] = \f\ttt::service ( 'core.fileManager.frontendPathFile',
                                                          array (
                        'path'     => $data[ 'path' ],
                        'fileName' => $data[ 'fileName' ],
                        'width'    => 100,
                        'height'   => 100,
                        'id'       => $data[ 'picture' ]
                    ) ) ;


            $date                  = $this->dateG->dateTime ( $data[ 'date' ], 1 ) ;
            $array[ $i ][ 'date' ] = $this->dateG->dateGrToJa ( $date, 2 ) ;

            $i ++ ;
        }
        //\f\pr($array);
        return $array ;
    }

    function url_exists ( $url )
    {
        return @fopen ( $url, 'r' ) ;
    }

    public function getNewContentApp ()
    {

        $params = $this->request->getNonAssocParams () ;
        $this->registerGadgets ( array (
            'dateG' => 'date' ) ) ;

        $params_array = array (
            'firstId' => $params[ 0 ],
            'type'    => $params[ 1 ],
            'typeId'  => $params[ 2 ]
                ) ;
        $result       = \f\ttt::dal ( 'cms.content.getNewContentApp',
                                      $params_array ) ;

        $i = 0 ;
        foreach ( $result AS $data )
        {
            $array[ $i ]              = $data ;
            $array[ $i ][ 'picture' ] = \f\ifm::app ()->fileBaseUrl . $data[ 'picture' ] . '/100/100' ;
            $date                     = $this->dateG->dateTime ( $data[ 'date' ],
                                                                 1 ) ;
            $array[ $i ][ 'date' ]    = $this->dateG->dateGrToJa ( $date, 2 ) ;

            $i ++ ;
        }
        return $array ;
    }

    public function getContentByIdApp ()
    {
        $params = $this->request->getNonAssocParams () ;
        $this->registerGadgets ( array (
            'dateG' => 'date' ) ) ;

        $params_array = array (
            'id' => $params[ 0 ],
                ) ;
        $result       = \f\ttt::dal ( 'cms.content.getContentByIdApp',
                                      $params_array ) ;

        \f\ttt::dal ( 'cms.content.setContentVisit', $params_array ) ;

        $array              = $result ;
        $array[ 'picture' ] = \f\ifm::app ()->legacyBaseUrl . 'upload/cms/content/' . $result[ 'fileName' ] ;

        $date               = $this->dateG->dateTime ( $result[ 'date' ], 1 ) ;
        $array[ 'date' ]    = $this->dateG->dateGrToJa ( $date, 2 ) ;
        $array[ 'content' ] = preg_replace ( "/&#?[a-z0-9]+;/i", " ",
                                             strip_tags ( $result[ 'content' ] ) ) ;


        return $array ;
    }

    public function contentAddAuto ()
    {
        \f\ttt::dal ( 'cms.content.contentAddAuto' ) ;
    }

    public function getElectorate ()
    {
        return \f\ttt::dal ( 'cms.content.getElectorate' ) ;
    }

    public function getPeopleByNewsId ()
    {

        return \f\ttt::dal ( 'cms.content.getPeopleByNewsId',
                             $this->request->getAssocParams () ) ;
    }

    public function getContentList ()
    {
        return \f\ttt::dal ( 'cms.content.getContentList',
                             $this->request->getAssocParams () ) ;
    }

    public function getContent ()
    {
        return \f\ttt::dal ( 'cms.content.getContent',
                             $this->request->getAssocParams () ) ;
    }

    public function getContentsByAjaxSearch ()
    {
        return \f\ttt::dal ( 'cms.content.getContentsByAjaxSearch',
                             $this->request->getAssocParams () ) ;
    }

}
