<?php

namespace f\w ;

class wizard extends \f\widget
{

    private $wizardTitlesMarkup ;
    private $wizardContentsMarkup ;
    private $wizardButtonsMarkup ;
    private $renderMarkup ;
    private $wizardCounter ;

    public function __construct ()
    {
        $this->renderMarkup  = '' ;
        $this->wizardCounter = 0 ;
    }

    public function begin ( $params )
    {
        $a = $this->generateIcon ( $params[ 'icon' ] ) ;

        $params[ 'htmlOptions' ]['ajax'] = $params['ajax'];
        $params[ 'htmlOptions' ][ 'class' ] = "wizard" ;
        $this->renderMarkup                 = \f\html::markupBegin ( 'div',
                                                                     $params ) ;
        if ( $params[ 'title' ] )
        {
            $titleParams[ 'htmlOptions' ][ 'class' ] = 'wizard-header' ;
            $title                                   = \f\html::readyMarkup ( 'h3',
                                                                              $a . $params[ 'title' ],
                                                                              '',
                                                                              true ) ;

            $this->renderMarkup .= \f\html::readyMarkup ( 'div', $title,
                                                          $titleParams, true ) ;
        }
    }

    private function generateTitleMarkup ( $title )
    {
        $page = $this->wizardCounter ++ ;
        $link = $this->generateLinkTitle ( $title , $page ) ;

        $cParam = array ( ) ;
        if ( ( isset ( $title[ 'active' ] ) && $title[ 'active' ] ) || $page == 0 )
        {
            $cParam[ 'htmlOptions' ][ 'class' ] = 'active' ;
        }
        else
        {
            $cParam[ 'htmlOptions' ][ 'class' ] = $title[ 'htmlOptions' ][ 'class' ] ;
        }
        
        $cParam['data-target'] = '#step'.$page;
        return \f\html::readyMarkup ( 'li', $link, $cParam, true ) ;
    }

    private function generateContentMarkup ( $content )
    {
        $activeClass = '' ;
        if ( ( isset ( $content[ 'active' ] ) && $content[ 'active' ] ) || $this->wizardCounter == 1 )
        {
            $activeClass    = 'active' ;
        }
        $autoWizardName = "autoWizard" . ($this->wizardCounter - 1) ;

        $content[ 'htmlOptions' ][ 'class' ] = "step-pane $autoWizardName $activeClass" ;
        $content[ 'htmlOptions' ][ 'id' ]    = $autoWizardName . '-wizard' ;

        return \f\html::readyMarkup ( 'div', $content[ 'content' ], $content,
                                      true ) ;
    }

    private function generateButtonMarkup ( $button )
    {

        if ( isset ( $button[ 'previus' ] ) )
        {
            $this->wizardButtonsMarkup .= $this->generatePreviusButton ( $button[ 'previus' ] ) ;
        }

        if ( isset ( $button[ 'next' ] ) )
        {
            $this->wizardButtonsMarkup .= $this->generateNextButton ( $button[ 'next' ] ) ;
        }

        if ( isset ( $button[ 'last' ] ) )
        {
            $this->wizardButtonsMarkup .= $this->generateLastButton ( $button[ 'last' ] ) ;
        }

        $div[ 'htmlOptions' ][ 'class' ] = "actions" ;
        return \f\html::readyMarkup ( 'div', $this->wizardButtonsMarkup, $div,
                                      true ) ;
    }

    public function step ( $params )
    {
        if ( isset ( $params[ 'title' ] ) )
        {
            if ( isset ( $params[ 'active' ] ) )
            {
                $params[ 'title' ][ 'active' ] = true ;
            }
            $this->wizardTitlesMarkup .= $this->generateTitleMarkup ( $params[ 'title' ] ) ;
        }
        if ( isset ( $params[ 'content' ] ) )
        {
            if ( isset ( $params[ 'active' ] ) )
            {
                $params[ 'content' ][ 'active' ] = true ;
            }
            $this->wizardContentsMarkup .= $this->generateContentMarkup ( $params[ 'content' ] ) ;
        }
    }

    public function flush ( $params )
    {
        $titleParams[ 'htmlOptions' ][ 'class' ] = 'nav-wizards steps' ;
        $titleReadyMarkup                    = \f\html::readyMarkup ( 'ul',
                                                                      $this->wizardTitlesMarkup,
                                                                      $titleParams,
                                                                      true ) ;

        $autoWizardName = "autoWizard" . ($this->wizardCounter - 1) ;

        $contentParams[ 'htmlOptions' ][ 'class' ] = "step-content $autoWizardName-page" ;
        $contentReadyMarkup                    = \f\html::readyMarkup ( 'div',
                                                                        $this->wizardContentsMarkup,
                                                                        $contentParams,
                                                                        true ) ;

        $buttonParams[ 'htmlOptions' ][ 'class' ] = "wizard-button $autoWizardName-page" ;
        $buttonReadyMarkup                    = $this->generateButtonMarkup ( $params[ 'button' ] ) ;

        $wizardMarkup = $this->renderMarkup . $titleReadyMarkup . $contentReadyMarkup . $buttonReadyMarkup ;
        $wizardMarkup .= \f\html::markupEnd ( 'div' ) ;
        return $wizardMarkup ;
    }
    
        private function generateLinkTitle ( $title , $page )
    {

        $a = $this->generateIcon ( $title[ 'icon' ] ) ;
        
        $a .= $title[ 'text' ] ;
        $linkParams                                   = $title ;
        $linkParams[ 'htmlOptions' ][ 'href' ]        = "#autoWizard" . $page . "-wizard" ;
        $linkParams[ 'htmlOptions' ][ 'data-toggle' ] = "wizard" ;
        $linkParams[ 'htmlOptions' ][ 'class' ]       = ($page == 0) ? "enable" : "disable" ;
        $linkParams[ 'style' ]                        = array ( 'cursor' => 'default' ) ;

        $spanParams[ 'htmlOptions' ][ 'class' ]    = ($page == 0) ? "badge badge-info" : "badge" ;
        $chevronParams[ 'htmlOptions' ][ 'class' ] = "chevron" ;

        $b = \f\html::readyMarkup ( 'span', '', $chevronParams, true ) ;
        $b .= \f\html::readyMarkup ( 'a', $a, $linkParams, true ) ;
        $b .= \f\html::readyMarkup ( 'span', $page + 1, $spanParams, true ) ;

        return $b ;
    }

    private function generatePreviusButton ( $previus )
    {
        $a = $this->generateIcon ( $previus[ 'icon' ], 'fa-arrow-right' ) ;

        $previus[ 'htmlOptions' ][ 'class' ]       = "btn btn-default btn-prev  wizard-button-previus " . $previus[ 'htmlOptions' ][ 'class' ] ;
        $previus[ 'htmlOptions' ][ 'id' ]          = "autoWizard" . 0 . '-wizard' ;
        $previus[ 'htmlOptions' ][ 'data-toggle' ] = "wizard-button-previus" ;
        
        $type = $previus[ 'htmlOptions' ][ 'type' ];
        $previus[ 'htmlOptions' ][ 'type' ]        = ($type) ? $type : 'button';
        
        return \f\html::readyMarkup ( 'button', $a . $previus[ 'content' ],
                                      $previus, true ) ;
    }

    private function generateNextButton ( $next )
    {
        $a = $this->generateIcon ( $next[ 'icon' ], 'fa-arrow-left' ) ;

        $next[ 'htmlOptions' ][ 'class' ]       = "btn btn-primary btn-next  wizard-button-next " . $next[ 'htmlOptions' ][ 'class' ] ;
        $next[ 'htmlOptions' ][ 'id' ]          = "autoWizard" . ($this->wizardCounter - 1) . '-wizard' ;
        $next[ 'htmlOptions' ][ 'data-toggle' ] = "wizard-button-next" ;

        $type = $next[ 'htmlOptions' ][ 'type' ];
        $next[ 'htmlOptions' ][ 'type' ]        = ($type) ? $type : 'button';
        
        return \f\html::readyMarkup ( 'button', $next[ 'content' ] . $a, $next,
                                      true ) ;
    }

    private function generateLastButton ( $last )
    {
        $a = $this->generateIcon ( $last[ 'icon' ], 'fa-check-circle' ) ;

        $last[ 'htmlOptions' ][ 'class' ]       = "btn btn-next btn-success wizard-button-last" . $last[ 'htmlOptions' ][ 'class' ] ;
        $last[ 'htmlOptions' ][ 'data-toggle' ] = "wizard-button-last" ;

        $last[ 'style' ] = array (
            'display' => 'none',
                ) ;
        $type = $last[ 'htmlOptions' ][ 'type' ];
        $last[ 'htmlOptions' ][ 'type' ]    = ($type) ? $type : 'button';

        return \f\html::readyMarkup ( 'button', $last[ 'content' ] . $a, $last,
                                      true ) ;
    }

    private function generateIcon ( $iconGet, $defultClass = '' )
    {
        $icon = isset ( $iconGet ) ? $iconGet : $defultClass ;

        $a = '' ;
        if ( ! empty ( $icon ) )
        {
            $aParams = array (
                'htmlOptions' => array (
                    'class' => "fa $icon"
                )
                    ) ;
            $a      = \f\html::markupBegin ( 'i', $aParams ) ;

            $a .= \f\html::markupEnd ( 'i' ) ;
        }
        return $a ;
    }

}