<?php

namespace f\w ;

class pageTitle extends \f\widget
{

    public function renderTitle($params)
    {
        $title = $params[ 'title' ] ;
        $links = isset($params[ 'links' ]) ? $params[ 'links' ] : '' ;

        if ( ! $links )
        {
            $borderStyle = array ( 'htmlOptions' => array ( 'style' => 'border:0px' ) ) ;
        }
        else
        {
            $borderStyle = array () ;
        }

        $titleMarkup = \f\html::markupBegin('div',
                                            array ( 'htmlOptions' => array ( 'class' => 'main-header' ) )) ;
        $titleMarkup .= \f\html::readyMarkup('h4', $title, $borderStyle, true) ;

        if ( ! empty($links) )
        {

            $i = 1 ;
            foreach ( $links as $link )
            {
                $titleMarkup .= \f\html::markupBegin('em', array ()) ;

                $linkHtmlOptions = array () ;
                if ( isset($link[ 'id' ]) )
                {
                    $linkHtmlOptions[ 'id' ] = $link[ 'id' ] ;
                }
                if ( isset($link[ 'href' ]) )
                {
                    $linkHtmlOptions[ 'href' ] = $link[ 'href' ] ;
                }
                $linkParams = array ( 'htmlOptions' => $linkHtmlOptions ) ;
                if ( isset($link[ 'action' ]) )
                {
                    $linkParams[ 'action' ] = $link[ 'action' ] ;
                }
                $titleMarkup .= \f\html::readyMarkup('a', $link[ 'title' ],
                                                     $linkParams, true) ;
                $titleMarkup .= \f\html::markupEnd('em') ;

                if ( $i != count($links) ) $titleMarkup .= "<h2>&nbsp;</h2>" ;

                $i ++ ;
            }
        }
        $titleMarkup .= \f\html::markupEnd('div') ;
        return $titleMarkup ;
    }

}
