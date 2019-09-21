<?php

namespace f\w ;

class form extends \f\widget
{

    private $rtl ;
    private $formMarkup ;
    private $cssClassArray  = array (
        'input'           => 'form-control',
        'textarea'        => 'form-control',
        'button'          => 'btn btn-primary',
        'radio'           => 'simple-radio',
        'radio-inline'    => 'simple-radio-inline',
        'checkbox'        => 'simple-checkbox',
        'checkbox-inline' => 'simple-checkbox-inline'
            ) ;
    private $prefixValidate = 'data-parsley-' ;

    /**
     *
     * @var \f\w\clientAction
     */
    private $clientActionObj ;

    public function __construct ()
    {
        require_once __DIR__ . \f\DS . 'base' . \f\DS . 'clientAction.php' ;
        $this->clientActionObj = new clientAction ;

        $this->formMarkup = '' ;
    }

    public function begin ( $params )
    {
        $formMarkup = '' ;
        $attr       = $this->attr ( $params ) ;
        //echo $attr;
        $formMarkup .= "<form $attr data-parsley-validate>" ;

        if ( isset ( $params[ 'rtl' ] ) )
        {
            $this->rtl = true ;
        }
        else
        {
            $this->rtl = false ;
        }

        return $formMarkup ;
        //die();
        //\f\pre($this->formMarkup);
    }

    public function flush ()
    {
        $formMarkup = "</form>" ;
        return $formMarkup ;
    }

    public function rowStart ( $htmlOptions = array (), $class = 'formRow',
                               $style = array ()
    )
    {
        $formMarkup = '' ;
        $formMarkup .= $this->createMarkup ( 'div', '', $class, $style,
                                             $htmlOptions, false ) ;

        return $formMarkup ;
    }

    public function rowEnd ()
    {
        $formMarkup = '' ;
        $formMarkup .= "<div class=\"clear\"></div></div>" ;
        return $formMarkup ;
    }

    public function colStart ( $style = array (), $class = 'col-sm-10' )
    {
        return $this->createMarkup ( 'div', '', $class, $style, '', false ) ;
    }

    public function colEnd ()
    {
        $formMarkup = '</div>' ;
        return $formMarkup ;
    }

    #____(Controls)____#

    public function fieldsetStart ( $options )
    {
        $formMarkup = '' ;
        $attr       = $this->attr ( $options ) ;
        $formMarkup .= "<fieldset $attr>" ;

        $legend = isset ( $options[ 'legend' ] ) ? $options[ 'legend' ] : false ;
        if ( $legend )
        {
            $legendAttr = $this->attr ( $legend ) ;
            $legendText = isset ( $legend[ 'text' ] ) ? $legend[ 'text' ] : '' ;
            $formMarkup .= "<legend $legendAttr>$legendText</legend>" ;
        }
        return $formMarkup ;
    }

    public function fieldsetEnd ()
    {
        $formMarkup = '</fieldset>' ;
        return $formMarkup ;
    }

    public function newLine ()
    {
        $formMarkup = '</br>' ;
        return $formMarkup ;
    }

    public function label ( $labelName )
    {
        $formMarkup = '<label class="col-sm-3 control-label">' . $labelName . '</label>' ;
        return $formMarkup ;
    }

    public function input ( $options )
    {
        $formMarkup = '' ;
        ####    block start ####

        $type   = isset ( $options[ 'block' ] ) ? 'block' : 'inline' ;
        $block  = isset ( $options[ $type ] ) ? $options[ $type ] : array () ;
        $colRow = isset ( $options[ 'colRow' ] ) ? FALSE : TRUE ;



        ####    Body    ####
        //print_r($options[ 'validation' ]);

        $htmlOptions = isset ( $options[ 'htmlOptions' ] ) ? $options[ 'htmlOptions' ] : array () ;
        //\f\pr($htmlOptions);
        $style       = isset ( $options[ 'style' ] ) ? $options[ 'style' ] : array () ;
        $label       = isset ( $options[ 'label' ] ) ? $options[ 'label' ] : false ;
        $afterLabel  = isset ( $options[ 'afterLabel' ] ) ? $options[ 'afterLabel' ] : false ;
        $validation  = isset ( $options[ 'validation' ] ) ? $this->parse_validate ( $options[ 'validation' ] ) : '' ;
        $lang        = isset ( $options[ 'lang' ] ) ? $options[ 'lang' ] : FALSE ;
        //\f\pr($validation);
        if ( $validation )
        {
            $htmlOptions = array_merge ( $htmlOptions, $validation ) ;
        }

        //\f\pr($options[ 'htmlOptions' ]);
        if ( $lang )
        {
            $langArray = langActive ;
            $name      = $htmlOptions[ 'name' ] ;
            $labelMain = $label[ 'text' ] ;
            foreach ( $langArray AS $data )
            {
                $formMarkup            .= $this->rowStart () ;
                $htmlOptions[ 'name' ] = $name . '[' . $data[ 'name' ] . ']' ;
                $style[ 'direction' ]  = $data[ 'direction' ] ;
                $label[ 'text' ]       = $labelMain . ' [ ' . $data[ 'title' ] . ' ]' ;

                if ( $colRow && ! isset ( $options[ 'noBlocking' ] ) )
                {
                    if ( $type == 'inline' )
                    {
                        $formMarkup .= $this->colStart ( $block ) ;
                    }
                    else
                    {
                        $formMarkup .= $this->rowStart ( $block ) ;
                    }
                }


                $inputMarkup = $this->createMarkup ( 'input', '',
                                                     $this->cssClassArray[ 'input' ],
                                                     $style, $htmlOptions, false ) ;

                $inputMarkup .= $afterLabel ;


                $formMarkup .= $this->renderItem ( $inputMarkup, $label ) ;

                ####    block end   ####
                if ( $colRow && ! isset ( $options[ 'noBlocking' ] ) )
                {
                    if ( $type == 'inline' )
                    {
                        $formMarkup .= $this->colEnd () ;
                    }
                    else
                    {
                        $formMarkup .= $this->rowEnd () ;
                    }
                }
                $formMarkup .= $this->rowEnd () ;
            }
        }
        else
        {
            if ( $colRow && ! isset ( $options[ 'noBlocking' ] ) )
            {
                if ( $type == 'inline' )
                {
                    $formMarkup .= $this->colStart ( $block ) ;
                }
                else
                {
                    $formMarkup .= $this->rowStart ( $block ) ;
                }
            }


            $inputMarkup = $this->createMarkup ( 'input', '',
                                                 $this->cssClassArray[ 'input' ],
                                                 $style, $htmlOptions, false ) ;

            $inputMarkup .= $afterLabel ;


            $formMarkup .= $this->renderItem ( $inputMarkup, $label ) ;

            ####    block end   ####
            if ( $colRow && ! isset ( $options[ 'noBlocking' ] ) )
            {
                if ( $type == 'inline' )
                {
                    $formMarkup .= $this->colEnd () ;
                }
                else
                {
                    $formMarkup .= $this->rowEnd () ;
                }
            }
        }

        return $formMarkup ;
    }

    public function button ( $options )
    {
        $formMarkup = '' ;
        ####    block start ####

        $type = isset ( $options[ 'block' ] ) ? 'block' : 'inline' ;

        $col = isset ( $options[ 'col' ] ) ? $options[ 'col' ] : 'col-sm-10' ;

        $block = isset ( $options[ $type ] ) ? $options[ $type ] : array () ;

        if ( $type == 'inline' )
        {
            $formMarkup .= $this->colStart ( $block, $col ) ;
        }
        else
        {
            $formMarkup .= $this->rowStart ( $block ) ;
        }
        ####    Body    ####

        $htmlOptions           = isset ( $options[ 'htmlOptions' ] ) ? $options[ 'htmlOptions' ] : array () ;
        $style                 = isset ( $options[ 'style' ] ) ? $options[ 'style' ] : array () ;
        $label                 = isset ( $options[ 'label' ] ) ? $options[ 'label' ] : false ;
        $htmlOptions[ 'type' ] = isset ( $htmlOptions[ 'type' ] ) ? $htmlOptions[ 'type' ] : 'submit' ;

        if ( $options[ 'tag' ] == 'button' )
        {
            $label   = isset ( $options[ 'label' ] ) ? $options[ 'label' ] : false ;
            $content = isset ( $options[ 'content' ] ) ? $options[ 'content' ] : '' ;
            if ( ! $htmlOptions[ 'class' ] )
            {
                $class = $this->cssClassArray[ 'button' ] ;
            }
            else
            {
                $class = '' ;
            }

            $inputMarkup = $this->createMarkup ( 'button', $content, $class,
                                                 $style, $htmlOptions ) ;
        }
        else
        {
            $htmlOptions[ 'value' ] = $options[ 'content' ] ;
            $inputMarkup            = $this->createMarkup ( 'input', '',
                                                            $this->cssClassArray[ 'button' ],
                                                            $style,
                                                            $htmlOptions, false ) ;
        }

        $formMarkup .= $this->renderItem ( $inputMarkup, $label ) ;



//        if (isset($options))
        ####    block end   ####

        if ( $type == 'inline' )
        {
            $formMarkup .= $this->colEnd () ;
        }
        else
        {
            $formMarkup .= $this->rowEnd () ;
        }
        $formMarkup .= $this->clientActionObj->addClientAction ( $options ) ;

        return $formMarkup ;
    }

    public function buttonTag ( $options )
    {
        $options[ 'tag' ] = 'button' ;
        $button           = $this->button ( $options ) ;
        return $button ;
    }

    public function textarea ( $options )
    {
        $formMarkup = '' ;
        ####    block start ####

        $type  = isset ( $options[ 'block' ] ) ? 'block' : 'inline' ;
        $block = isset ( $options[ $type ] ) ? $options[ $type ] : array () ;


        ####    Body    ####

        $htmlOptions = isset ( $options[ 'htmlOptions' ] ) ? $options[ 'htmlOptions' ] : array () ;
        $style       = isset ( $options[ 'style' ] ) ? $options[ 'style' ] : array () ;
        $label       = isset ( $options[ 'label' ] ) ? $options[ 'label' ] : false ;
        $content     = isset ( $options[ 'content' ] ) ? $options[ 'content' ] : '' ;
        $lang        = isset ( $options[ 'lang' ] ) ? $options[ 'lang' ] : FALSE ;

        $class = $this->cssClassArray[ 'textarea' ] ;
        if ( $options[ 'editor' ] )
        {
            $class .= ' ckeditor' ;
        }
        $validation = isset ( $options[ 'validation' ] ) ? $this->parse_validate ( $options[ 'validation' ] ) : '' ;

        if ( $validation )
        {
            $htmlOptions = array_merge ( $htmlOptions, $validation ) ;
        }

        if ( $lang )
        {
            $langArray = langActive ;
            $name      = $htmlOptions[ 'name' ] ;
            $labelMain = $label[ 'text' ] ;
            foreach ( $langArray AS $data )
            {
                $formMarkup            .= $this->rowStart () ;
                $htmlOptions[ 'name' ] = $name . '[' . $data[ 'name' ] . ']' ;
                $style[ 'direction' ]  = $data[ 'direction' ] ;
                $label[ 'text' ]       = $labelMain . ' [ ' . $data[ 'title' ] . ' ]' ;

                if ( $type == 'inline' )
                        $formMarkup .= $this->colStart ( $block ) ;
                else $formMarkup .= $this->rowStart ( $block ) ;



                $inputMarkup = $this->createMarkup ( 'textarea', $content,
                                                     $class, $style,
                                                     $htmlOptions ) ;
                $formMarkup  .= $this->renderItem ( $inputMarkup, $label ) ;

                ####    block end   ####
                //\f\pr($htmlOptions);

                if ( $type == 'inline' ) $formMarkup .= $this->colEnd () ;
                else $formMarkup .= $this->rowEnd () ;
                
                
                $formMarkup .= $this->rowEnd () ;
            }
        }
        else
        {
            if ( $type == 'inline' ) $formMarkup .= $this->colStart ( $block ) ;
            else $formMarkup .= $this->rowStart ( $block ) ;


            $inputMarkup = $this->createMarkup ( 'textarea', $content, $class,
                                                 $style, $htmlOptions ) ;
            $formMarkup  .= $this->renderItem ( $inputMarkup, $label ) ;

            ####    block end   ####
            //\f\pr($htmlOptions);

            if ( $type == 'inline' ) $formMarkup .= $this->colEnd () ;
            else $formMarkup .= $this->rowEnd () ;
            //$formMarkup .= $this->rowEnd () ;
        }






        $formMarkup .= $this->clientActionObj->addClientAction ( $options ) ;

        return $formMarkup ;
    }

    public function radio ( $options )
    {
        $formMarkup = '' ;
        ####    block start ####

        $type        = isset ( $options[ 'block' ] ) ? 'block' : 'inline' ;
        $linearClass = isset ( $options[ 'linear' ] ) ? $this->cssClassArray[ 'radio' ] . ' ' . $this->cssClassArray[ 'radio-inline' ] : $this->cssClassArray[ 'radio' ] ;
        $block       = isset ( $options[ $type ] ) ? $options[ $type ] : array () ;

        if ( $type == 'inline' ) $formMarkup .= $this->colStart ( $block ) ;
        else $formMarkup .= $this->rowStart ( $block ) ;

        ####    Body    ####

        $name        = isset ( $options[ 'htmlOptions' ][ 'name' ] ) ? $options[ 'htmlOptions' ][ 'name' ] : rand () ;
        $htmlOptions = isset ( $options[ 'htmlOptions' ] ) ? $options[ 'htmlOptions' ] : array () ;
        $style       = isset ( $options[ 'style' ] ) ? $options[ 'style' ] : array () ;
        $label       = isset ( $options[ 'label' ] ) ? $options[ 'label' ] : false ;
        $checked     = isset ( $options[ 'checked' ] ) ? $options[ 'checked' ] : '' ;
        $id          = isset ( $options[ 'htmlOptions' ][ 'id' ] ) ? $options[ 'htmlOptions' ][ 'id' ] : $name ;

        $choices       = isset ( $options[ 'choices' ] ) ? $options[ 'choices' ] : array () ;
        $choicesMarkup = '' ;

        $formMarkup .= $this->rowStart ( array (), $linearClass ) ;

        foreach ( $choices as $label_choice => $value )
        {
            if ( $checked == $value )
            {
                $checked_radio = 'checked' ;
            }
            else
            {
                $checked_radio = '' ;
            }
            $choicesMarkup .= $this->createMarkup ( 'input', '', '', '',
                                                    array (
                'type'  => 'radio',
                'name'  => $name,
                'value' => $value,
                'id'    => $id . $value,
                'class' => $htmlOptions[ 'class' ] ), false, $checked_radio ) ;

            $choicesMarkup .= $this->createMarkup
                    ( 'label', $label_choice, '', '',
                      array (
                'for' => $id . $value ) ) ;
        }


        $formMarkup .= $this->renderItem ( $choicesMarkup, $label ) ;
        $formMarkup .= $this->rowEnd () ;

        ####    block end   ####

        if ( $type == 'inline' ) $formMarkup .= $this->colEnd () ;
        else $formMarkup .= $this->rowEnd () ;

        $formMarkup .= $this->clientActionObj->addClientAction ( $options ) ;

        return $formMarkup ;
    }

    public function checkbox ( $options )
    {
        $formMarkup = '' ;
        ####    block start ####

        $type        = isset ( $options[ 'block' ] ) ? 'block' : 'inline' ;
        $linearClass = isset ( $options[ 'linear' ] ) ? $this->cssClassArray[ 'checkbox' ] . ' ' . $this->cssClassArray[ 'checkbox-inline' ] : $this->cssClassArray[ 'checkbox' ] ;
        $block       = isset ( $options[ $type ] ) ? $options[ $type ] : array () ;




        if ( $type == 'inline' ) $formMarkup .= $this->colStart ( $block ) ;
        else $formMarkup .= $this->rowStart ( $block ) ;

        ####    Body    ####

        $name        = isset ( $options[ 'htmlOptions' ][ 'name' ] ) ? $options[ 'htmlOptions' ][ 'name' ] : rand () ;
        $htmlOptions = isset ( $options[ 'htmlOptions' ] ) ? $options[ 'htmlOptions' ] : array () ;
        $style       = isset ( $options[ 'style' ] ) ? $options[ 'style' ] : array () ;
        $label       = isset ( $options[ 'label' ] ) ? $options[ 'label' ] : false ;
        $checked     = isset ( $options[ 'checked' ] ) ? $options[ 'checked' ] : array () ;

        //echo $checked;
        $choices       = isset ( $options[ 'choices' ] ) ? $options[ 'choices' ] : array () ;
        $choicesMarkup = '' ;

        $formMarkup .= $this->rowStart ( array (), $linearClass ) ;
        $i          = 0 ;
        foreach ( $choices as $label_choice => $value )
        {
            $id = isset ( $options[ 'htmlOptions' ][ 'id' ] ) ? $options[ 'htmlOptions' ][ 'id' ] : $name . "-" . $i ;
            if ( in_array ( $value, $checked ) )
            {
                $checked_radio = 'checked' ;
            }
            else
            {
                $checked_radio = '' ;
            }
            $choicesMarkup .= $this->createMarkup ( 'input', '', '', '',
                                                    array (
                'type'  => 'checkbox',
                'name'  => $name,
                'value' => isset ( $options[ 'htmlOptions' ][ 'value' ] ) ? $options[ 'htmlOptions' ][ 'value' ] : $value,
                'id'    => $id,
                'class' => $htmlOptions[ 'class' ]
                    ), false, $checked_radio ) ;

            $choicesMarkup .= $this->createMarkup
                    ( 'label', $label_choice, '', '',
                      array (
                'for' => $id ) ) ;

            $i ++ ;
        }


        $formMarkup .= $this->renderItem ( $choicesMarkup, $label ) ;
        $formMarkup .= $this->rowEnd () ;

        ####    block end   ####
        if ( $options[ 'blocking' ] )
        {
            if ( $type == 'inline' ) $formMarkup .= $this->colEnd () ;
            else $formMarkup .= $this->rowEnd () ;
        }
        $formMarkup .= $this->clientActionObj->addClientAction ( $options ) ;

        return $formMarkup ;
    }

    function select ( $options )
    {
        $formMarkup  = '' ;
        ####    block start ####
        //echo 'salam';
        $type        = isset ( $options[ 'block' ] ) ? 'block' : 'inline' ;
        $linearClass = isset ( $options[ 'linear' ] ) ? 'block-radio' : 'inline-radio' ;
        $block       = isset ( $options[ $type ] ) ? $options[ $type ] : array () ;

        // $type='inline';
        if ( ! isset ( $options[ 'noBlocking' ] ) )
        {
            if ( $type == 'inline' ) $formMarkup .= $this->colStart ( $block ) ;
            else $formMarkup .= $this->rowStart ( $block ) ;
        }
        ####    Body    ####

        $id          = isset ( $options[ 'htmlOptions' ][ 'id' ] ) ? $options[ 'htmlOptions' ][ 'id' ] : rand () ;
        $htmlOptions = isset ( $options[ 'htmlOptions' ] ) ? $options[ 'htmlOptions' ] : array () ;
        $style       = isset ( $options[ 'style' ] ) ? $options[ 'style' ] : array () ;
        $label       = isset ( $options[ 'label' ] ) ? $options[ 'label' ] : false ;
        $selected    = isset ( $options[ 'selected' ] ) ? $options[ 'selected' ] : '' ;

        $choices       = isset ( $options[ 'choices' ] ) ? $options[ 'choices' ] : array () ;
        $choicesMarkup = '' ;
        $choicesMarkup .= $this->createMarkup ( 'option', '', '', '', array () ) ;

        foreach ( $choices as $choice => $value )
        {

            if ( $selected == $choice || (is_array ( $selected ) && in_array ( $choice,
                                                                               $selected )) )
            {
                $choicesMarkup .= $this->createMarkup ( 'option', $value, '',
                                                        '',
                                                        array (
                    'value'    => $choice,
                    'selected' => 'selected' ) ) ;
            }
            else
            {
                $choicesMarkup .= $this->createMarkup ( 'option', $value, '',
                                                        '',
                                                        array (
                    'value' => $choice ) ) ;
            }
        }



        //$selectAttr = $this->attr($options) ;
        $validation = isset ( $options[ 'validation' ] ) ? $this->parse_validate ( $options[ 'validation' ] ) : '' ;

        if ( $validation )
        {
            $htmlOptions = array_merge ( $htmlOptions, $validation ) ;
        }
        $selectMarkup = $this->createMarkup ( 'select', $choicesMarkup, '',
                                              $style, $htmlOptions, TRUE ) ;

        $formMarkup .= $this->renderItem ( $selectMarkup, $label ) ;



//        $formMarkup .= $this->renderItem($selectTag . $choicesMarkup .
//                '</select>', $label) ;
        ####    block end   ####
        if ( ! isset ( $options[ 'noBlocking' ] ) )
        {
            if ( $type == 'inline' ) $formMarkup .= $this->colEnd () ;
            else $formMarkup .= $this->rowEnd () ;
        }
        $formMarkup .= $this->clientActionObj->addClientAction ( $options ) ;

        return $formMarkup ;
    }

    #____(PRIVATE FUNCTIONS)____#

    private function arrayToAttr ( $array )
    {
        $attr = '' ;
        foreach ( $array as $att => $value ) $attr .= "$att=\"$value\" " ;
        return $attr ;
    }

    private function arrayToStyle ( $array )
    {

        if ( is_array ( $array ) )
        {
            $style = 'style="' ;
            foreach ( $array as $attr => $value ) $style .= "$attr: $value; " ;
            $style .= '"' ;
            return $style ;
        }
        else
        {
            return '' ;
        }
    }

    private function renderItem ( $element, $label = false )
    {
        $block  = $label && isset ( $label[ 'block' ] ) && $label[ 'block' ] ? true : false ;
        $markup = '' ;

        $class = ! $block && $label ? 'col-sm-9' : 'full' ;

        if ( $this->rtl )
        {
            $markup .= $this->createMarkup ( 'div', $element, $class ) ;

            if ( $label )
            {
                $labelStyle = isset ( $label[ 'style' ] ) ? $label[ 'style' ] : array () ;

                $labelHtmlOptions = isset ( $label[ 'htmlOptions' ] ) ? $label[ 'htmlOptions' ] : array () ;

                $markup .= $this->createMarkup ( 'label',
                                                 $label[ 'text'
                        ], 'col-sm-3 control-label', $labelStyle,
                                                 $labelHtmlOptions ) ;
            }
        }
        else
        {
            if ( $label )
            {
                $labelStyle = isset ( $label[ 'style' ] ) ? $label[ 'style' ] : array () ;

                $labelHtmlOptions = isset ( $label[ 'htmlOptions' ] ) ? $label[ 'htmlOptions' ] : array () ;

                $markup .= $this->createMarkup ( 'label',
                                                 $label[ 'text'
                        ], 'col-sm-3 control-label', $labelStyle,
                                                 $labelHtmlOptions ) ;
            }
            $markup .= $this->createMarkup ( 'div', $element, $class ) ;
        }
        return $markup ;
    }

    private function createMarkup ( $tagName, $content, $class = '',
                                    $style = '', $htmlOptions = '',
                                    $closeTheTag = true, $checked = '' )
    {


        $closeTag = $closeTheTag ? "</$tagName>" : '' ;
        if ( isset ( $htmlOptions[ 'class' ] ) && ! empty ( $class ) )
        {
            $htmlOptions[ 'class' ] = $htmlOptions[ 'class' ] . " $class" ;
        }
        else if ( ! empty ( $class ) )
        {
            $htmlOptions[ 'class' ] = $class ;
        }




        $htmlOptions = $htmlOptions ? $this->arrayToAttr ( $htmlOptions ) : '' ;
        $style       = $style ? $this->arrayToStyle ( $style ) : '' ;



        return "<$tagName $style $htmlOptions $checked>$content$closeTag" ;
    }

    public function attr ( $params )
    {
        $styleArray       = isset ( $params[ 'style' ] ) ? $params[ 'style' ] : array () ;
        $htmlOptionsArray = isset ( $params[ 'htmlOptions' ] ) ? $params[ 'htmlOptions' ] : array () ;
        $str              = $this->arrayToStyle ( $styleArray ) ;
        $str              .= ' ' . $this->arrayToAttr ( $htmlOptionsArray ) ;
        return $str ;
    }

    public function readyMarkup ( $tagName, $content = '', $params = array (),
                                  $return = false, $hasClose = false )
    {
        $attrMarkup = self::attr ( $params ) ;
        if ( $return )
        {
            $tag = "<$tagName $attrMarkup>" . ($hasClose ? "$content</$tagName>" : '') ;
            return $tag ;
        }
        else
        {
            $this->formMarkup .= "<$tagName $attrMarkup>" . ($hasClose ? "$content</$tagName>" : '') ;
        }
    }

    public function table ( $params )
    {
        $table = \f\widgetFactory::make ( 'table' ) ;

        $this->formMarkup .= $table->renderTable ( $params ) ;
    }

    public function parse_validate ( $validationArray )
    {
        foreach ( $validationArray as $key => $val )
        {
            $validationArray[ $this->prefixValidate . $key ] = $val ;
            unset ( $validationArray[ $key ] ) ;
        }
        //\f\pr($validationArray);
        return $validationArray ;
    }

    public function checkbox2 ( $options )
    {
        $formMarkup = '' ;
        ####    block start ####

        $type        = isset ( $options[ 'block' ] ) ? 'block' : 'inline' ;
        $linearClass = isset ( $options[ 'linear' ] ) ? $this->cssClassArray[ 'checkbox' ] . ' ' . $this->cssClassArray[ 'checkbox-inline' ] : $this->cssClassArray[ 'checkbox' ] ;
        $block       = isset ( $options[ $type ] ) ? $options[ $type ] : array () ;



        if ( $options[ 'blocking' ] )
        {
            if ( $type == 'inline' )
            {
                $formMarkup .= $this->colStart ( $block ) ;
            }
            else
            {
                $formMarkup .= $this->rowStart ( $block ) ;
            }
        }


        ####    Body    ####

        $name        = isset ( $options[ 'htmlOptions' ][ 'name' ] ) ? $options[ 'htmlOptions' ][ 'name' ] : rand () ;
        $htmlOptions = isset ( $options[ 'htmlOptions' ] ) ? $options[ 'htmlOptions' ] : array () ;
        $style       = isset ( $options[ 'style' ] ) ? $options[ 'style' ] : array () ;
        $label       = isset ( $options[ 'label' ] ) ? $options[ 'label' ] : false ;
        $checked     = isset ( $options[ 'checked' ] ) ? $options[ 'checked' ] : array () ;

        //echo $checked;
        $choices       = isset ( $options[ 'choices' ] ) ? $options[ 'choices' ] : array () ;
        $choicesMarkup = '' ;

        $formMarkup .= $this->rowStart ( array (), $linearClass ) ;
        $i          = 0 ;
        foreach ( $choices as $value => $label_choice )
        {
            $id = isset ( $options[ 'htmlOptions' ][ 'id' ] ) ? $options[ 'htmlOptions' ][ 'id' ] : $name . "-" . $i ;
            if ( in_array ( $value, $checked ) )
            {
                $checked_radio = 'checked' ;
            }
            else
            {
                $checked_radio = '' ;
            }
            $choicesMarkup .= $this->createMarkup ( 'input', '', '', '',
                                                    array (
                'type'     => 'checkbox',
                'name'     => $name,
                'value'    => isset ( $options[ 'htmlOptions' ][ 'value' ] ) ? $options[ 'htmlOptions' ][ 'value' ] : $value,
                'id'       => $id,
                'class'    => $htmlOptions[ 'class' ],
                'onchange' => $htmlOptions[ 'onchange' ]
                    ), false, $checked_radio ) ;

            $choicesMarkup .= $this->createMarkup
                    ( 'label', $label_choice, '', '',
                      array (
                'for' => $id ) ) ;

            $i ++ ;
        }


        $formMarkup .= $this->renderItem ( $choicesMarkup, $label ) ;
        $formMarkup .= $this->rowEnd () ;

        ####    block end   ####
        if ( $options[ 'blocking' ] )
        {
            if ( $type == 'inline' )
            {
                $formMarkup .= $this->colEnd () ;
            }
            else
            {
                $formMarkup .= $this->rowEnd () ;
            }
        }
        $formMarkup .= $this->clientActionObj->addClientAction ( $options ) ;

        return $formMarkup ;
    }

    /*
     * $form .= $this->formW->rowStart () ;
      $form .= $this->formW->uploadPictureTag ( array (
      'id'          => 'selectProfilePicBtn11', //optional
      'btnTitle'    => 'انتخاب/آپلود فایل', //optional
      'dialogTitle' => 'آپلود فایل', //optional
      'label'       => 'تصویر', //optional
      'multiUpload' => 1, //optional
      'extensions'  => '.jpg, .png, .bmp, .jpeg', //optional
      'tasks'       => [
      'upload',
      'select' ], //optional
      'containerId' => 'fileContainer11', //optional
      'path'        => 'cms.news', //required
      'fileId'      => $row[ 'picture' ], //required
      'name'        => 'picture', //optional
      ) ) ;
      $form .= $this->formW->rowEnd () ;
     */

    public function uploadPictureTag ( $params = array () )
    {
        $form = '' ;
        $form .= $this->buttonTag ( array (
            'htmlOptions' => array (
                'type'  => 'button',
                'id'    => $params[ 'id' ] ? $params[ 'id' ] : 'selectProfilePicBtn',
                'class' => 'btn btn-default'
            ),
            'content'     => '<i class="fa fa-upload"></i> ' . ($params[ 'btnTitle' ] ? $params[ 'btnTitle' ] : 'انتخاب/آپلود فایل'),
            'label'       => array (
                'text' => $params[ 'label' ] ? $params[ 'label' ] : 'تصویر',
            ),
            'action'      => array (
                'preServerSideAction' => array (
                    'route'   => 'core.fileManager.registerUploadSession',
                    'options' => array (
                        //change
                        'multiUpload' => $params[ 'multiUpload' ] ? $params[ 'multiUpload' ] : 1,
                        'extensions'  => $params[ 'extensions' ] ? $params[ 'extensions' ] : '.jpg, .png, .bmp, .jpeg',
                        'tasks'       => $params[ 'tasks' ] ? $params[ 'tasks' ] : array (
                    'upload',
                    'select' )
                    ),
                ),
                'display'             => 'dialog',
                'params'              => array (
                    'targetRoute'    => "core.fileManager.getUploadForm",
                    'triggerElement' => $params[ 'id' ] ? $params[ 'id' ] : 'selectProfilePicBtn', //chanage
                    'containerId'    => '#' . ($params[ 'containerId' ] ? $params[ 'containerId' ] : 'fileContainer'),
                    'urlParams'      => array (
                        'path' => $params[ 'path' ] //chanage
                    ),
                    'dialogTitle'    => $params[ 'dialogTitle' ] ? $params[ 'dialogTitle' ] : 'آپلود فایل',
                    'ajaxParams'     => array (
                        'mode'   => ($params[ 'fileId' ] == '' || $params[ 'fileId' ] == 0) ? '' : 'update',
                        'fileId' => $params[ 'fileId' ],
                        'path'   => $params[ 'path' ]  //chanage
                    )
                )
            ) ) ) ;

        $form .= $this->colStart () ;

        $fileIdInput = \f\html::readyMarkup ( 'input', '',
                                              array (
                    'htmlOptions' => array (
                        'type'  => 'hidden',
                        'name'  => $params[ 'name' ] ? $params[ 'name' ] : 'picture',
                        'id'    => 'fileId',
                        'value' => $params[ 'fileId' ]
            ) ) ) ;

        $profilePic = \f\html::readyMarkup ( 'img', '',
                                             array (
                    'htmlOptions' => array (
                        'src'      => \f\ifm::app ()->fileBaseUrl . $params[ 'fileId' ],
                        'data-src' => \f\ifm::app ()->fileBaseUrl . $params[ 'fileId' ],
                    ),
                    'style'       => array (
                        'position'   => 'absolute',
                        'left'       => '30px',
                        'top'        => "-35px",
                        'max-width'  => '50px',
                        'max-height' => '70px',
                        'display'    => ($params[ 'fileId' ] == '' || $params[ 'fileId' ] == 0) ? 'none' : 'block'
                    )
                ) ) ;


        $form .= \f\html::readyMarkup ( 'div', $fileIdInput . $profilePic,
                                        array (
                    'htmlOptions' => array (
                        'id'        => $params[ 'containerId' ] ? $params[ 'containerId' ] : 'fileContainer',
                        'data-type' => 'image'
                    ),
                    'style'       => array (
                        'margin-top' => '15px'
                    )
                        ), true ) ;

        $form .= $this->colEnd () ;

        return $form ;
    }

    public function uploadFileTag ( $params )
    {
        $form        = '' ;
        $form        .= $this->buttonTag ( array (
            'htmlOptions' => array (
                'type'  => 'button',
                'id'    => $params[ 'id' ] ? $params[ 'id' ] : 'selectFileBtn',
                'class' => 'btn btn-default'
            ),
            'content'     => '<i class="fa fa-upload"></i> ' . ($params[ 'btnTitle' ] ? $params[ 'btnTitle' ] : 'انتخاب/آپلود فایل'),
            'label'       => array (
                'text' => $params[ 'label' ] ? $params[ 'label' ] : 'فایل',
            ),
            'action'      => array (
                'preServerSideAction' => array (
                    'route'   => 'core.fileManager.registerUploadSession',
                    'options' => array (
                        //change
                        'multiUpload' => 1,
                        'extensions'  => $params[ 'extensions' ],
                        'tasks'       => array (
                            'upload' )
                    ),
                ),
                'display'             => 'dialog',
                'params'              => array (
                    'targetRoute'    => "core.fileManager.getUploadForm",
                    'triggerElement' => $params[ 'id' ] ? $params[ 'id' ] : 'selectFileBtn', //chanage
                    'containerId'    => '#' . ($params[ 'containerId' ] ? $params[ 'containerId' ] : 'fileContainer'),
                    'urlParams'      => array (
                        'path' => $params[ 'path' ] //chanage
                    ),
                    'dialogTitle'    => \f\ifm::t ( "fileUpload" ),
                    'ajaxParams'     => array (
                        'mode'   => '',
                        'fileId' => '',
                        'path'   => $params[ 'path' ], //chanage
                        'func'   => $params[ 'func' ]//chanage
                    )
                )
            ) ) ) ;
        $form        .= $this->colStart () ;
        $fileIdInput = \f\html::readyMarkup ( 'input', '',
                                              array (
                    'htmlOptions' => array (
                        'type'  => 'hidden',
                        'name'  => $params[ 'name' ],
                        'class' => $params[ 'name' ],
                        'id'    => 'fileId',
                        'value' => $params[ 'fileId' ]
            ) ) ) ;

        if ( $params[ 'fileId' ] )
        {
            $file = '<a href="' . \f\ifm::app ()->fileBaseUrl . $params[ 'fileId' ] . '" target="_blank" style="display:block"><i class="fa fa-file"></i> فایل پیوست شده</a>' ;
        }
        $attach = \f\html::readyMarkup ( 'div', $file,
                                         array (
                    'htmlOptions' => array (
                        'id' => ($params[ 'attachId' ] ? $params[ 'attachId' ] : 'attachId')
                    ),
                    'style'       => array (
                        'position' => 'absolute',
                        'left'     => '30px',
                        'top'      => "-28px",
                        'color'    => 'darkblue',
                    )
                        ), true ) ;

        $form .= \f\html::readyMarkup ( 'div', $fileIdInput . $attach,
                                        array (
                    'htmlOptions' => array (
                        'id' => ($params[ 'containerId' ] ? $params[ 'containerId' ] : 'fileContainer'),
                    ),
                    'style'       => array (
                        'margin-top' => '15px'
                    )
                        ), true ) ;

        $form .= $this->colEnd () ;
    }

    public function galleryTag ( $params )
    {
        $form = '' ;
        $form .= $this->fieldsetStart ( array (
            'legend' => array (
                'text' => $params[ 'galleryLabel' ] ? $params[ 'galleryLabel' ] : 'گالری تصاویر'
            )
                ) ) ;
        $form .= '<input type="hidden" name="num_pic" id="num_pic" value="' . $params[ 'num_pic' ] . '">' ;
        $form .= '<input type="hidden" name="cover" id="picture" value="' . $params[ 'cover' ] . '">' ;

        $form .= $this->buttonTag ( array (
            'htmlOptions' => array (
                'type'  => 'button',
                'id'    => $params[ 'id' ] ? $params[ 'id' ] : 'selectGalleryBtn',
                'class' => 'btn btn-custom-primary btn-md'
            ),
            'content'     => '<i class="fa fa-upload"></i> ' . 'آپلود تصویر جدید',
            'action'      => array (
                'preServerSideAction' => array (
                    'route'   => 'core.fileManager.registerUploadSession',
                    'options' => array (
                        //change
                        'multiUpload' => 1,
                        'extensions'  => '.jpg, .png, .bmp, .jpeg,.gif',
                        'tasks'       => array (
                            'upload' )
                    ),
                ),
                'display'             => 'dialog',
                'params'              => array (
                    'targetRoute'    => "core.gallery.galleryPic",
                    'triggerElement' => $params[ 'id' ] ? $params[ 'id' ] : 'selectGalleryBtn', //chanage
                    'containerId'    => '#' . ($params[ 'containerId' ] ? $params[ 'containerId' ] : 'galleryContainer'),
                    'urlParams'      => array (
                        'path' => $params[ 'path' ]//chanage
                    ),
                    'dialogTitle'    => $params[ 'dialogTitle' ] ? $params[ 'dialogTitle' ] : 'آپلود فایل',
                    'ajaxParams'     => array (
                        'mode'   => '',
                        'fileId' => '',
                        'path'   => $params[ 'path' ], //chanage
                        'func'   => 'refreshGalleryPic',
                    )
                )
            ) ) ) ;
        $form .= '<br><div class="row list-group king-gallery" style="margin:30px 3px 0px">' ;

        $form .= $params[ 'gallery' ] ;
        $form .= '<div class="clearfix"></div></div>' ;

        $form .= $this->fieldsetEnd () ;

        return $form ;
    }

}
