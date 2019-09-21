<?php

namespace f\w ;

class tab extends \f\widget
{

    private $tabTitlesMarkup ;
    private $tabContentsMarkup ;
    private $renderMarkup ;
    private $tabCounter ;

    public function __construct()
    {
        $this->renderMarkup = '' ;
        $this->tabCounter   = 0 ;
    }

    public function begin($params)
    {
        $this->renderMarkup = \f\html::markupBegin('div', $params) ;
    }

    private function generateTitleMarkup($title , $params)
    {

        $icon = isset($title[ 'icon' ]) ? $title[ 'icon' ] : '' ;

        $a = '' ;
        if ( ! empty($icon) )
        {
            $aParams = array (
                'htmlOptions' => array (
                    'class' => "fa $icon"
                )
                    ) ;
            $a       = \f\html::markupBegin('i', $aParams) ;

            $a .= \f\html::markupEnd('i') ;
        }

        $a .= $title[ 'text' ] ;
        $linkParams                                   = $title ;
        $linkParams[ 'htmlOptions' ][ 'href' ]        = "#autoTab" . $this->tabCounter ++ . "-tab" ;
        $linkParams[ 'htmlOptions' ][ 'data-toggle' ] = "tab" ;

        $b = \f\html::readyMarkup('a', $a, $linkParams, true) ;

        $cParam = array () ;
        if ( isset($title[ 'active' ]) && $title[ 'active' ] )
        {
            $cParam[ 'htmlOptions' ][ 'class' ] = 'active ' ;
        }
        $cParam[ 'htmlOptions' ][ 'class' ] = $cParam[ 'htmlOptions' ][ 'class' ] ." ".$params[ 'htmlOptions' ][ 'class' ];
        $cParam[ 'style' ] = $params[ 'style' ];
        return \f\html::readyMarkup('li', $b, $cParam, true) ;
    }

    private function generateContentMarkup($content , $params)
    {
        $activeClass = '' ;
        if ( isset($content[ 'active' ]) && $content[ 'active' ] )
        {
            $activeClass = 'active' ;
        }
        $autoTabName = "autoTab" . ($this->tabCounter - 1) ;

        $content[ 'htmlOptions' ][ 'class' ] = "tab-pane $autoTabName $activeClass" ;
        $content[ 'htmlOptions' ][ 'id' ]    = $autoTabName . '-tab' ;

        return \f\html::readyMarkup('div', $content[ 'content' ], $content, true) ;
    }

    public function tab($params)
    {
        if ( isset($params[ 'title' ]) )
        {
            if ( isset($params[ 'active' ]) )
            {
                $params[ 'title' ][ 'active' ] = true ;
            }
            $this->tabTitlesMarkup .= $this->generateTitleMarkup($params[ 'title' ] , $params) ;
        }
        if ( isset($params[ 'content' ]) )
        {
            if ( isset($params[ 'active' ]) )
            {
                $params[ 'content' ][ 'active' ] = true ;
            }
            $this->tabContentsMarkup .= $this->generateContentMarkup($params[ 'content' ] , $params) ;
        }
    }

    public function flush()
    {
        $titleParams = array (
            'htmlOptions' => array (
                'class' => 'nav nav-tabs'
            )
                ) ;

        $titleReadyMarkup = \f\html::readyMarkup('ul', $this->tabTitlesMarkup,
                                                 $titleParams, true) ;

        $autoTabName = "autoTab" . ($this->tabCounter - 1) ;

        $contentParams      = array (
            'htmlOptions' => array (
                'class' => "tab-content $autoTabName-page"
            )
                ) ;
        $contentReadyMarkup = \f\html::readyMarkup('div',
                                                   $this->tabContentsMarkup,
                                                   $contentParams, true) ;

        $tabMarkup = $this->renderMarkup . $titleReadyMarkup . $contentReadyMarkup ;

        $tabMarkup .= \f\html::markupEnd('div') ;

        return $tabMarkup ;
    }

}
