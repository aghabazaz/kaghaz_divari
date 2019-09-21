<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \core\seo\webpage
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class webpageService extends \f\service
{

    public function __construct ()
    {
        $this->mapper = \f\dalFactory::make ( 'core.seo.webpage' ) ;
    }

    public function webpageList ()
    {
        return \f\ttt::dal ( 'core.seo.webpage.webpageList',
                             $this->request->getAssocParams () ) ;
    }

    public function webpageSave ()
    {
        $params = $this->request->getAssocParams () ;
        if ( $params[ 'id' ] )
        {
            $result = \f\ttt::dal ( 'core.seo.webpage.webpageSaveEdit', $params ) ;
            $msg    = \f\ifm::t ( 'webpageSaveEdit' ) ;
            $reset  = FALSE ;
        }
        else
        {
            $result = \f\ttt::dal ( 'core.seo.webpage.webpageSave', $params ) ;
            $msg    = \f\ifm::t ( 'webpageSave' ) ;
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

    public function webpageDelete ()
    {
        return \f\ttt::dal ( 'core.seo.webpage.webpageDelete',
                             $this->request->getAssocParams () ) ;
    }

    public function getWebpageById ()
    {
        return \f\ttt::dal ( 'core.seo.webpage.getWebpageById',
                             $this->request->getAssocParams () ) ;
    }

    public function getHeadingByPageId ()
    {
        return \f\ttt::dal ( 'core.seo.webpage.getHeadingByPageId',
                             $this->request->getAssocParams () ) ;
    }

    public function updateInfo ()
    {
        include_once \f\ifm::app ()->baseDir . \f\DS . 'ifm' . \f\DS . 'lib' . \f\DS . 'parseHtml.php' ;

        //file_get_html($url);
        $this->registerGadgets ( array (
            'strG' => 'str' ) ) ;
        $params = $this->request->getAssocParams () ;

        $page = file_get_html ( $params[ "link" ] ) ;

        $info[ 'id' ]          = $params[ 'id' ] ;
        $info[ 'size_page' ]   = mb_strlen ( $page, "8bit" ) ;
        $info[ 'size_text' ]   = mb_strlen ( $this->strG->strip_html_tags ( $page ),
                                                                            "8bit" ) ;
        $info[ 'date_update' ] = time () ;



        $result = \f\ttt::dal ( 'core.seo.webpage.saveUpdateInfo', $info ) ;


        $this->getHeadingPage ( $page, $info, $this->strG ) ;
        $this->getLinkPage ( $page, $info, $this->strG ) ;
        $this->getWordsDensity ( $page, $info, $this->strG ) ;
        //\f\pr($result);

        if ( $result )
        {
            return array (
                'result' => 'success' ) ;
        }
        else
        {
            return array (
                'result' => 'error' ) ;
        }
    }

    public function getWordsDensity ( $page, $info, $strG )
    {
        \f\ttt::dal ( 'core.seo.webpage.removeWords',
                      array (
            'id' => $info[ 'id' ]
        ) ) ;

        $row = \f\ttt::dal ( 'core.seo.webpage.getWebpageById',
                             array (
                    'id' => $info[ 'id' ] ) ) ;

        $text  = $strG->strip_html_tags ( $page ) ;
        $words = array_count_values ( $strG->utf8_str_word_count ( $text, 1 ) ) ;
        arsort ( $words ) ;
        $i     = 0 ;
        foreach ( $words AS $key => $val )
        {
            if ( $i == 20 )
            {
                break ;
            }
            if ( mb_strlen ( $key ) > 1 )
            {
                $titleStatus       = $this->checkWords ( $row[ 'title' ], $key ) ;
                $descriptionStatus = $this->checkWords ( $row[ 'description' ],
                                                         $key ) ;
                $headingStatus     = \f\ttt::dal ( 'core.seo.webpage.checkWordsInHeading',
                                                   array (
                            'word' => $key,
                            'id'   => $info[ 'id' ]
                        ) ) ;

                \f\ttt::dal ( 'core.seo.webpage.saveWordsDensity',
                              array (
                    'core_seo_page_id' => $info[ 'id' ],
                    'word'             => $key,
                    'num_repeat'       => $val,
                    'title'            => $titleStatus,
                    'description'      => $descriptionStatus,
                    'heading'          => $headingStatus,
                ) ) ;
                $i ++ ;
            }
        }
    }

    public function checkWords ( $string, $keyword )
    {
        if ( strpos ( $string, $keyword ) === FALSE )
        {
            return 'no' ;
        }
        else
        {
            return 'yes' ;
        }
    }

    public function getHeadingPage ( $page, $info, $strG )
    {
        \f\ttt::dal ( 'core.seo.webpage.removeHeading',
                      array (
            'id' => $info[ 'id' ]
        ) ) ;

        for ( $i = 1 ; $i <= 6 ; $i ++ )
        {
            $data = $page->find ( 'h' . $i ) ;
            foreach ( $data as $e )
            {
                \f\ttt::dal ( 'core.seo.webpage.saveHeading',
                              array (
                    'core_seo_page_id' => $info[ 'id' ],
                    'type'             => 'h' . $i,
                    'text'             => trim ( str_replace ( '&nbsp;', '',
                                                               $strG->strip_html_tags ( $e->innertext ) ) )
                ) ) ;
            }
        }
    }

    public function getLinkPage ( $page, $info, $strG )
    {
        \f\ttt::dal ( 'core.seo.webpage.removeLink',
                      array (
            'id' => $info[ 'id' ]
        ) ) ;


        $data = $page->find ( 'a' ) ;
        foreach ( $data as $e )
        {
            $link = $e->href ;
            if ( strpos ( $link, \f\ifm::app ()->siteUrl ) === FALSE )
            {
                $type = 'external' ;
            }
            else
            {
                $type = 'internal' ;
            }
            \f\ttt::dal ( 'core.seo.webpage.saveLink',
                          array (
                'core_seo_page_id' => $info[ 'id' ],
                'link_address'     => $e->href,
                'type'             => $type,
                'link_title'       => trim ( str_replace ( '&nbsp;', '',
                                                           $strG->strip_html_tags ( $e->innertext ) ) )
            ) ) ;
        }
    }

    public function getLinkByPageId ()
    {
        return \f\ttt::dal ( 'core.seo.webpage.getLinkByPageId',
                             $this->request->getAssocParams () ) ;
    }

    public function getWordsByPageId ()
    {
        return \f\ttt::dal ( 'core.seo.webpage.getWordsByPageId',
                             $this->request->getAssocParams () ) ;
    }

    public function getBacklinkByPageId ()
    {
        return \f\ttt::dal ( 'core.seo.webpage.getBacklinkByPageId',
                             $this->request->getAssocParams () ) ;
    }

}
