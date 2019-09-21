<?php

namespace f\w ;

/**
 * Class Form
 * (widget)
 */
class form2 extends \f\widget
{

    private
            $options,
            $tagName,
            $valuesArray,
            $closeTag        = false,
            $markup          = '',
            $icon,
            $stepsMarkup     = '',
            $step            = 0,
            $setButton       = false,
            $tabHeaderMarkup = '',
            $directory       = '',
            $allowedTypes    = array ( ),
            $isSubForm = false ;

    function __construct ($params)
    {
        $options=  is_array($params['options'])?$params['options']:array();
        $valuesArray=is_array($params['value'])?$params['value']:array();
        $isSubForm=$params['isSubForm']?$params['isSubForm']:FALSE;

        if ( $valuesArray === false )
        {
            $valuesArray = array ( ) ;
        }

        $this->isSubForm = $isSubForm ;

        foreach ( $valuesArray as $key => $val )
        {

            if ( is_array ( $val ) )
            {

                $innerKey = key ( $val ) ;

                $totalKey                  = $key . '[' . $innerKey . ']' ;
                $valuesArray [ $totalKey ] = $val[ $innerKey ] ;
            }
        }

        if ( isset ( $options[ 'wizard' ] ) && $options[ 'wizard' ] )
        {
            $this->stepsMarkup .= '<div class="wizardContainer">' ;
            $options[ 'class' ][ ] = 'wizard' ;
        }

        $this->valuesArray = $valuesArray ;

        # Set action ================================= :

        if ( isset ( $options[ 'action' ] ) )
        {
            $options[ 'htmlOptions' ][ 'action' ] = $options[ 'action' ] ;
        }

        # Set method ================================= :

        if ( isset ( $options[ 'method' ] ) )
        {
            $optios[ 'htmlOptions' ][ 'method' ] = $options[ 'method' ] ;
        }

        $options[ 'class' ] = isset ( $options[ 'class' ] ) ? $options[ 'class' ] : array ( ) ;
        if ( ! is_array ( $options[ 'class' ] ) )
        {
            $options[ 'class' ] = array($options[ 'class' ] ) ;
        }

        if ( ! ( isset ( $options[ 'ajax' ] ) && ! $options[ 'ajax' ] ) )
        {
            $options[ 'class' ][ ] = 'formAjax' ;
        }

        $options[ 'htmlOptions' ][ 'method' ] = isset ( $options[ 'htmlOptions' ][ 'method' ] ) ? $options[ 'htmlOptions' ][ 'method' ] : 'post' ;

        $options[ 'style' ] = isset ( $options[ 'style' ] ) ? $options[ 'style' ] : array ( ) ;

        if ( ! $this->isSubForm )
        {
            $this->markup .= self::createMarkup ( 'form',
                                                  $options[ 'htmlOptions' ],
                                                  $options[ 'style' ],
                                                  $options[ 'class' ] ) ;
        }
    }

    // ===============================================================//
    // ! Main functions ( PUBLIC )                                    //
    // ===============================================================//

    public function startTab ( $title, $active = false )
    {

        $activeClass = $active ? 'class="active"' : '' ;
        $active      = $active ? 'active fade in' : 'fade' ;
        $id          = 'tab' . rand ( 1000, 9000 ) ;
        $this->tabHeaderMarkup .= "<li style=\"float:right;\" role=\"presentation\" $activeClass><a href=\"#$id\" aria-controls=\"$id\" role=\"tab\" data-toggle=\"tab\">$title</a></li>" ;
        $this->markup .= "<div role=\"tabpanel\" class=\"tab-pane $active\" id=\"$id\">" ;
    }

    public function endTab ()
    {

        $this->markup .= '</div>' ;
    }

    public function tabContentStart ()
    {

        $this->markup .= '<div class="tab-content">' ;
        $this->tabHeaderMarkup = '<ul class="nav nav-tabs" role="tablist">' ;
    }

    public function tabContentEnd ()
    {

        $this->markup .= '</div>' ;
        $this->tabHeaderMarkup .= '</ul>' ;
    }

    public function stepStart ( $title )
    {

        $this->step ++ ;
        $stepClass = $this->step == 1 ? 'activeStep wizardStep' : 'wizardStep' ;
        if ( $this->step == 1 )
        {
            $this->stepsMarkup .= '<ul class="steps clearfix">' ;
        }
        $this->markup .= "<div class=\"step$this->step $stepClass\">" ;

        $goToStepActiveClass = $this->step == 1 ? 'goToStepActive' : 'goToStepRemain' ;

        $this->stepsMarkup .= "<li step=\"$this->step\" class=\"goToStep $goToStepActiveClass goToStep$this->step\"><b> <span class=\"badge\">$this->step</span> $title</b></li>" ;
    }

    public function stepEnd ()
    {

        $this->markup .= '</div>' ;
    }

    public function render ( $echo = true )
    {

        if ( ! empty ( $this->stepsMarkup ) )
        {
            $this->markup = $this->stepsMarkup . '</ul>' . $this->markup . '</div>' ;
        }
        if ( ! empty ( $this->tabHeaderMarkup ) )
        {
            $this->markup = $this->tabHeaderMarkup . '<br>' . $this->markup ;
        }

        if ( ! $this->isSubForm )
        {
            $this->markup .= '</form>' ;
        }
        if ( $echo )
        {
            echo $this->markup ;
        }
        else
        {
            return $this->markup ;
        }
    }

    public function footerStart ()
    {

        $this->markup .= '<div class="formFooter">' ;
    }

    public function footerEnd ()
    {

        $this->markup .= '</div>' ;
    }

    public function html ( $html )
    {

        $this->markup .= $html ;
    }

    public function fieldsetStart ( $legend = false )
    {

        $this->markup .= '<fieldset>' ;
        if ( $legend )
        {
            $this->markup .= "<legend>$legend : </legend>" ;
        }
    }

    public function fieldsetEnd ( $legent = false )
    {

        $this->markup .= '</fieldset>' ;
    }

    public function clearFix ()
    {

        $this->markup .= '<div class="clearfix"></div>' ;
    }

    public function upload ( $options )
    {

        $this->options = $options ;
        $this->tagName = 'upload' ;

        $this->allowedTypes = isset ( $options[ 'allowedTypes' ] ) ? $options[ 'allowedTypes' ] : array ( ) ;

        if ( $this->allowedTypes )
        {
            $this->allowedTypes = explode ( ',', $this->allowedTypes ) ;

            foreach ( $this->allowedTypes as &$allowedType )
            {
                $allowedType = AjaxUploadController::getFileTypeKey ( $allowedType ) ;
            }
        }

        self::renderItem () ;
    }

    public function range ( $options )
    {

        $this->options = $options ;
        $this->tagName = 'range' ;

        self::renderItem () ;
    }

    public function input ( $options )
    {

        # set Eng mode ================================= :

        if ( isset ( $options[ 'eng' ] ) && $options[ 'eng' ] )
        {
            $options[ 'style' ][ 'direction' ]   = 'ltr' ;
            $options[ 'style' ][ 'font-family' ] = 'tahoma' ;
            $options[ 'style' ][ 'text-align' ]  = 'left' ;
        }

        if ( isset ( $options[ 'num' ] ) && $options[ 'num' ] )
        {
            $options[ 'style' ][ 'direction' ]  = 'ltr' ;
            $options[ 'style' ][ 'text-align' ] = 'left' ;
        }

        # Add ( plus ) button ================================= :
        if ( isset ( $options[ 'add' ] ) && $options[ 'add' ] )
        {

            $options[ 'leftAddon' ] = '<i class="fa fa-plus addCopyInput" style="font-size:9px;"></i>' ;
        }

        # Set type directly ================================= :

        $options[ 'htmlOptions' ][ 'type' ] = isset ( $options[ 'htmlOptions' ][ 'type' ] ) ? $options[ 'htmlOptions' ][ 'type' ] : 'text' ;

        if ( isset ( $options[ 'type' ] ) )
        {
            $options[ 'htmlOptions' ][ 'type' ] = $options[ 'type' ] ;
        }

        # ================================= </ Set type directly

        $this->tagName = 'input' ;
        $this->options = $options ;

        self::renderItem () ;
    }

    public function textArea ( $options )
    {

        $this->tagName  = 'textArea' ;
        $this->options  = $options ;
        $this->closeTag = true ;

        self::renderItem () ;
    }

    public function button ( $options )
    {

        if ( $options === 'default' )
        {
            $options = array (
                'class'   => 'btn-primary',
                'content' => 'ثبت',
                'icon'    => 'fa-check-circle',
            ) ;
        }

        if ( $this->stepsMarkup != '' && ! $this->setButton )
        {
            $this->setButton = true ;

            $this->html ( '<div class="seperator"></div>' ) ;

            $this->button ( array (
                'class' => array ( 'wizardPrev', 'btn-primary' ),
                'icon'    => 'fa-arrow-right',
                'content' => 'قبلی',
                'block'   => false,
                'submit'  => false,
                'style'   => array ( 'width' => 1 ),
            ) ) ;

            $this->button ( array (
                'class' => array ( 'wizardNext', 'btn-primary' ),
                'icon' => array ( 'fa-arrow-left', 'left' ),
                'content' => 'بعدی',
                'block'   => false,
                'submit'  => false,
                'style'   => array ( 'width' => 1 ),
            ) ) ;
        }

        if ( ! isset ( $options[ 'style' ][ 'width' ] ) )
        {
            $options[ 'style' ][ 'width' ] = 2 ;
        }

        # Set action directly ================================= :

        if ( isset ( $options[ 'icon' ] ) )
        {
            if ( is_array ( $options[ 'icon' ] ) )
            {

                $this->icon = $options[ 'icon' ] ;
            }
            else
            {
                $this->icon[ 0 ] = $options[ 'icon' ] ;
                $this->icon[ 1 ] = 'right' ;
            }
        }

        if ( isset ( $options[ 'action' ] ) )
        {
            $options[ 'htmlOptions' ][ 'formaction' ] = $options[ 'action' ] ;
        }

        # ================================= </ Set action directly

        $this->tagName = 'a' ;

        if ( ! ( isset ( $options[ 'submit' ] ) && ! $options[ 'submit' ] ) )
        {
            $options[ 'htmlOptions' ][ 'type' ] = 'submit' ;
            $this->tagName                      = 'button' ;
        }

        $this->options = $options ;

        self::renderItem () ;
    }

    public function datePicker ( $options )
    {

        if ( isset ( $options[ 'min' ] ) )
        {
            $options[ 'htmlOptions' ][ 'minDate' ] = $options[ 'min' ] ;
        }
        if ( isset ( $options[ 'max' ] ) )
        {
            $options[ 'htmlOptions' ][ 'maxDate' ] = $options[ 'max' ] ;
        }

        $options[ 'class' ][ ]                   = 'datePicker' ;
        $options[ 'rightAddon' ]                = '<i class="fa fa-calendar-o"></i>' ;
        $options[ 'htmlOptions' ][ 'role' ]     = 'tooltip' ;
        $options[ 'htmlOptions' ][ 'readonly' ] = '' ;
        self::input ( $options ) ;
    }

    public function timePicker ( $options )
    {

        $options[ 'htmlOptions' ][ 'format' ] = isset ( $options[ 'format' ] ) ? $options[ 'format' ] : 'h:m' ;

        if ( isset ( $options[ 'min' ] ) )
        {
            $options[ 'htmlOptions' ][ 'minDate' ] = $options[ 'min' ] ;
        }
        if ( isset ( $options[ 'max' ] ) )
        {
            $options[ 'htmlOptions' ][ 'maxDate' ] = $options[ 'max' ] ;
        }

        $options[ 'class' ][ ]                   = 'timePicker' ;
        $options[ 'rightAddon' ]                = '<i class="fa fa-clock-o"></i>' ;
        $options[ 'htmlOptions' ][ 'role' ]     = 'tooltip' ;
        $options[ 'htmlOptions' ][ 'readonly' ] = '' ;
        self::input ( $options ) ;
    }

    public function dateTimePicker ( $options )
    {

        $options[ 'htmlOptions' ][ 'format' ] = isset ( $options[ 'format' ] ) ? $options[ 'format' ] : 'h:m' ;

        if ( isset ( $options[ 'min' ] ) )
        {
            $options[ 'htmlOptions' ][ 'minDate' ] = $options[ 'min' ] ;
        }
        if ( isset ( $options[ 'max' ] ) )
        {
            $options[ 'htmlOptions' ][ 'maxDate' ] = $options[ 'max' ] ;
        }

        $options[ 'class' ][ ]                   = 'dateTimePicker' ;
        $options[ 'rightAddon' ]                = '<i class="fa fa-globe"></i>' ;
        $options[ 'htmlOptions' ][ 'role' ]     = 'tooltip' ;
        $options[ 'htmlOptions' ][ 'readonly' ] = '' ;
        self::input ( $options ) ;
    }

    public function colorPicker ( $options )
    {

        $color = isset ( $this->valuesArray[ $options[ 'name' ] ] ) ? '#' .
                $this->valuesArray[ $options[ 'name' ] ] : '#000000' ;

        if ( isset ( $options[ 'content' ] ) )
        {
            $color = '#' . $options[ 'content' ] ;
        }

        $options[ 'class' ][ ]                   = 'colorPicker' ;
        $options[ 'rightAddon' ]                = '<div style="background:' .
                $color .
                ';" class="colorPreview"></div>' ;
        $options[ 'htmlOptions' ][ 'readonly' ] = '' ;
        self::input ( $options ) ;
    }

    public function select ( $options )
    {

        $this->tagName = 'select' ;
        $this->options = $options ;
        $this->content = self::createChoices ( $options[ 'choices' ], 'select' ) ;

        self::renderItem () ;
    }

    public function radio ( $options )
    {

        $this->tagName = 'radio' ;
        $this->options = $options ;
        $this->content = self::createChoices ( $options[ 'choices' ], 'radio' ) ;

        self::renderItem () ;
    }

    public function checkBox ( $options )
    {

        $this->tagName = 'checkbox' ;
        $this->options = $options ;
        $this->content = self::createChoices ( $options[ 'choices' ], 'checkbox' ) ;

        self::renderItem () ;
    }

    // ===============================================================//
    // ! Other functions ( PRIVATE )                                  //
    // ===============================================================//

    private function arrayToMarkup ( $markupArray )
    {

        if ( ! is_array ( $markupArray ) )
        {
            $markupArray = array ( $markupArray ) ;
        }

        $markup = '' ;
        foreach ( $markupArray as $attr => $value )
        {
            if ( $value == '' )
            {
                $markup .= "$attr " ;
            }
            else
            {
                $markup .= "$attr=\"$value\" " ;
            }
        }

        return $markup ;
    }

    private function arrayToStyle ( $styleArray )
    {

        if ( empty ( $styleArray ) )
        {
            return '' ;
        }

        $markup = 'style="' ;
        foreach ( $styleArray as $attr => $value )
        {
            $markup .= "$attr: $value; " ;
        }

        return $markup .= '"' ;
    }

    private function arrayToClassName ( $classArray )
    {

        if ( empty ( $classArray ) )
        {
            return '' ;
        }

        $markup = 'class="' ;

        foreach ( $classArray as $className )
        {
            $markup .= "$className " ;
        }

        return $markup .= '"' ;
    }

    private function createMarkup ( $tagName, $htmlOptionsArr, $styleArr,
                                    $classArr, $content = '', $closeTag = false )
    {

        # Set step ================================= :

        if ( $this->stepsMarkup != '' )
        {
            $htmlOptionsArr[ 'data-parsley-group' ] = 'step' . $this->step ;
            if ( $this->tagName == 'a' || $this->tagName == 'button' )
            {
                $styleArr[ 'padding' ]     = '0 1px 0 1px' ;
                $styleArr[ 'line-height' ] = '35px' ;
            }
        }

        # ================================= </ Set step
        # Set width ================================= :

        if ( isset ( $styleArr[ 'width' ] ) && is_integer ( $styleArr[ 'width' ] ) )
        {
            unset ( $styleArr[ 'width' ] ) ;
        }
        # ================================= </ Set width
        # validation ================================= :

        if ( isset ( $this->options[ 'validation' ] ) )
        {

            if ( isset ( $this->options[ 'validation' ][ 'required' ] ) &&
                    $this->options[ 'validation' ][ 'required' ] &&
                    $this->tagName != 'upload'
            )
            {
                $htmlOptionsArr[ 'data-parsley-required' ] = '' ;
            }

            if ( isset ( $this->options[ 'validation' ][ 'type' ] ) )
            {

                if ( $this->options[ 'validation' ][ 'type' ] == 'int' )
                {
                    $this->options[ 'validation' ][ 'type' ] = 'integer' ;
                }
                else
                {
                    if ( $this->options[ 'validation' ][ 'type' ] == 'meliCode' )
                    {
                        $htmlOptionsArr[ 'parsley-remote' ] = baseUrl ( false ) . '/base/meliValidate' ;
                    }
                    else
                    {
                        if ( in_array ( $this->options[ 'validation' ][ 'type' ],
                                        array ( 'mob', 'tel' ) ) )
                        {
                            $htmlOptionsArr[ 'data-parsley-pattern' ] = '0[0-9]{10}' ;
                        }
                        else
                        {
                            $htmlOptionsArr[ 'data-parsley-type' ] = $this->options[ 'validation' ][ 'type' ] ;
                        }
                    }
                }
            }

            if ( isset ( $this->options[ 'validation' ][ 'minLength' ] ) )
            {
                $htmlOptionsArr[ 'data-parsley-minlength' ] = $this->options[ 'validation' ][ 'minLength' ] ;
            }

            if ( isset ( $this->options[ 'validation' ][ 'maxLength' ] ) )
            {
                $htmlOptionsArr[ 'data-parsley-maxlength' ] = $this->options[ 'validation' ][ 'maxLength' ] ;
            }

            if ( isset ( $this->options[ 'validation' ][ 'min' ] ) )
            {
                $htmlOptionsArr[ 'data-parsley-min' ] = $this->options[ 'validation' ][ 'min' ] ;
            }

            if ( isset ( $this->options[ 'validation' ][ 'max' ] ) )
            {
                $htmlOptionsArr[ 'data-parsley-max' ] = $this->options[ 'validation' ][ 'max' ] ;
            }

            if ( isset ( $this->options[ 'validation' ][ 'equal' ] ) )
            {
                $htmlOptionsArr[ 'data-parsley-equalto' ]  = '#' . $this->options[ 'validation' ][ 'equal' ] ;
                $htmlOptionsArr[ 'data-parsley-required' ] = '' ;
            }

            if ( isset ( $this->options[ 'validation' ][ 'pattern' ] ) )
            {
                $htmlOptionsArr[ 'data-parsley-pattern' ] = $this->options[ 'validation' ][ 'pattern' ] ;
            }
        }
        # ================================= </ validation
        # Set default classes ========================================================================== :

        if ( ( $tagName == 'input' ) || $tagName == 'textArea' )
        {
            $classArr[ ] = 'form-control' ;
        }

        if ( $tagName == 'button' || $tagName == 'a' )
        {
            $classArr[ ] = 'btn' ;
            $classArr[ ] = 'btn-block' ;
        }

        if ( $tagName == 'select' )
        {
            $classArr[ ] = 'form-select' ;
        }

        # ========================================================================== </ Set default classes

        $htmlOptions = self::arrayToMarkup ( $htmlOptionsArr ) ;
        $style       = self::arrayToStyle ( $styleArr ) ;

        $class = self::arrayToClassName ( $classArr ) ;

        $markup = "<$tagName $htmlOptions $style $class>" ;
        if ( $closeTag )
        {
            $markup .= "$content</$tagName>" ;
        }

        return $markup ;
    }

    private function renderItem ()
    {

        $options = $this->options ;
        $type    = $this->tagName ;

        $styleArr = isset ( $options[ 'style' ] ) ? $options[ 'style' ] : array ( ) ;
        $htmlOptionsArr = isset ( $options[ 'htmlOptions' ] ) ? $options[ 'htmlOptions' ] : array ( ) ;
        $classArr = isset ( $options[ 'class' ] ) ? $options[ 'class' ] : array ( ) ;
        $classArr = ! is_array ( $classArr ) ? array ( $classArr ) : $classArr ; // convert string to array
        $content = isset ( $options[ 'content' ] ) ? $options[ 'content' ] : false ;

        $label = isset ( $options[ 'label' ] ) ? $options[ 'label' ] : false ;

        if ( $this->tagName != 'button' && $this->tagName != 'a' )
        {
            $name                     = $htmlOptionsArr[ 'name' ] = isset ( $options[ 'name' ] ) ? $options[ 'name' ] : $options[ 'htmlOptions' ][ 'name' ] ;
        }

        $width = isset ( $options[ 'style' ][ 'width' ] ) ? $options[ 'style' ][ 'width' ] : '6' ;

        # Set Id ====================================== :

        if ( in_array ( $type, array ( 'input', 'textArea' ) ) && ! isset ( $htmlOptionsArr[ 'id' ] ) )
        {

            $this->options[ 'htmlOptions' ][ 'id' ] = $name ;
            $htmlOptionsArr[ 'id' ]                 = $name ;
        }

        # ====================================== </ Set Id

        $innerMarkup = '' ;

        if ( in_array ( $type, array ( 'input', 'textArea' ) ) )
        {

            # default value ================================= :

            if ( isset ( $this->valuesArray[ $name ] ) )
            {
                $content = $this->valuesArray[ $name ] ;
            }
            else
            {
                if ( isset ( $options[ 'content' ] ) )
                {
                    $content = $options[ 'content' ] ;
                }
            }
            # ================================= </ default value

            if ( $type == 'input' )
            {
                $htmlOptionsArr[ 'value' ] = $content ;
                $content                   = '' ;
            }

            $innerMarkup = self::createMarkup ( $type, $htmlOptionsArr,
                                                $styleArr, $classArr, $content,
                                                $this->closeTag ) ;
        }

        if ( $type == 'select' )
        {

            $innerMarkup = self::createMarkup ( 'select', $htmlOptionsArr,
                                                $styleArr, $classArr,
                                                $this->content, true ) ;
        }

        if ( in_array ( $type, array ( 'radio', 'checkbox' ) ) )
        {

            $innerMarkup = self::createMarkup ( 'div', array ( ), $styleArr,
                                                $classArr, $this->content, true ) ;
        }

        if ( $type == 'button' || $type == 'a' )
        {
            if ( $this->icon != '' )
            {
                $icon = $this->icon[ 0 ] ;
                if ( $this->icon[ 1 ] == 'right' )
                {
                    $content = "<span class=\"btn-font fa $icon fa-fw\"></span> $content" ;
                }
                else
                {
                    $content = "$content <span class=\"btn-font fa $icon fa-fw\"></span>" ;
                }
            }

            $innerMarkup = self::createMarkup ( $type, $htmlOptionsArr,
                                                $styleArr, $classArr, $content,
                                                true ) ;
        }

        if ( $type == 'upload' )
        {

            $htmlOptionsArr[ 'type' ] = 'file' ;
            unset ( $htmlOptionsArr[ 'name' ] ) ;

            if ( $this->allowedTypes )
            {
                $htmlOptionsArr[ 'allowedTypes' ] = implode ( ',',
                                                              $this->allowedTypes ) ;
            }

            $inputFileMarkup = self::createMarkup ( 'input', $htmlOptionsArr,
                                                    array ( ), array ( ) ) ;

            $value = isset ( $this->valuesArray[ $name ] ) ? Mapper::getFileName ( $this->valuesArray[ $name ] ) : 'No file selected !!' ;

            $fileUrl = '' ;

            if ( $content )
            {
                $fileUrl = baseUrl ( false ) . '/base/showFile/' . $content ;
                $imageId = $content ;
            }

            if ( $value != 'No file selected !!' )
            {
                $fileUrl = baseUrl ( false ) . '/base/showFile/' . $this->valuesArray[ $name ] ;
                $imageId = $this->valuesArray[ $name ] ;
            }

            $previewMarkup = '' ;
            if ( $fileUrl )
            {

                //$fileType = Db::_uploads ( false )->getRow ( 'id = ?', $imageId )[ 'type' ] ;
                if ( in_array ( $fileType,
                                array ( 'image/jpeg', 'image/png', 'image/gif' ) ) )
                {
                    $previewMarkup = "<a class=\"uploadPreview fa fa-eye\" href=\"javascript:void(0)\" onclick=\"showImage($imageId)\"></a>" ;
                }
                else
                {
                    $previewMarkup = "<a class=\"uploadPreview fa fa-eye\" href=\"$fileUrl\" target='_blank'></a>" ;
                }
                $previewMarkup .= "<a class=\"deleteUploadedFile fa fa-times\" href=\"javascript:void(0)\"></a>" ;
            }

            $fileId = isset ( $this->valuesArray[ $name ] ) &&
                    $this->valuesArray[ $name ] != 0 ? $this->valuesArray[ $name ] : '' ;

            $required = isset ( $options[ 'validation' ][ 'required' ] ) &&
                    $options[ 'validation' ][ 'required' ] ? 'required' : '' ;
            $inMarkup = "

			<div class=\"fileName\">
				$previewMarkup
				<span>$value</span>
				$inputFileMarkup
				<input $required type=\"text\" class=\"fileNameInput hidden\" name=\"$name\" value=\"$fileId\">
			</div>
			<span class=\"choosefile\"><i class=\"fa fa-upload\"></i> انتخاب</span>
			<span class=\"alert\"><i class=\"fa icon\"></i> <span class=\"text\"></span></span>
			" ;

            $classArr[ ]  = 'upload' ;
            $innerMarkup = self::createMarkup ( 'label', array ( ), $styleArr,
                                                $classArr,
                                                '<div class="uploadProgress"></div>' . $inMarkup,
                                                true ) ;

            $innerMarkup = $innerMarkup ;
        }

        if ( $type == 'range' )
        {

            $name = $htmlOptionsArr[ 'name' ] ;

            $value = isset ( $this->valuesArray[ $name ] ) ? $this->valuesArray[ $name ] : 0 ;
            $value = isset ( $options[ 'value' ] ) ? $options[ 'value' ] : $value ;

            $min  = $options[ 'min' ] ;
            $max  = $options[ 'max' ] ;
            $step = $options[ 'step' ] ;

            $inputMarkup = "<input type=\"hidden\" name=\"$name\" value=\"$value\">" ;

            $classArr[ ]  = 'rangeSlider' ;
            $innerMarkup = self::createMarkup ( 'div', array ( ), $styleArr,
                                                $classArr,
                                                $inputMarkup .
                            '<span class="valueBox">( ' .
                            $value .
                            ' )</span>', true ) ;

            $this->markup .= "<script>$(document).ready(function(){\$('.rangeSlider').slider({value: $value,min: $min,max: $max,step: $step,slide: function( event, ui ) {
				\$(this).parent('div').find('input').val(ui.value);
				\$(this).parent('div').find('.valueBox').html('( ' + ui.value + ' )');

			}});});</script>" ;
        }

        # Set label ================================= :

        $label    = $hasLabel = isset ( $options[ 'label' ] ) ? $options[ 'label' ] : false ;

        if ( $label )
        {
            $labelWidth = isset ( $label[ 'style' ][ 'width' ] ) ? $label[ 'style' ][ 'width' ] : 2 ;
        }
        else
        {
            $labelWidth = 0 ;
        }

        if ( isset ( $options[ 'style' ][ 'width' ] ) )
        {

            if ( $options[ 'style' ][ 'width' ] == intval ( $options[ 'style' ][ 'width' ] ) )
            {
                $options[ 'style' ][ 'width' ] = intval ( $options[ 'style' ][ 'width' ] ) ;
            }
        }

        $xsLabelWidth = $labelWidth * 2 <= 12 ? $labelWidth * 2 : 12 ;
        $elementWidth = isset ( $options[ 'style' ][ 'width' ] ) &&
                is_integer ( $options[ 'style' ][ 'width' ] ) ? $options[ 'style' ][ 'width' ] : 6 - $labelWidth ;

        $xsElementWidth = $elementWidth * 2 <= 12 ? $elementWidth * 2 : 12 ;

        if ( ! is_array ( $label ) )
        {
            $label = array ( 'content' => $label ) ;
        }

        if ( isset ( $label[ 'class' ] ) && ! is_array ( $label[ 'class' ] ) )
        {
            $label[ 'class' ] = array($label[ 'class' ] ) ;
        }

        $label[ 'class' ][ ] = "col-xs-$xsLabelWidth" ;
        $label[ 'class' ][ ] = "col-md-$labelWidth" ;

        if ( isset ( $this->options[ 'htmlOptions' ][ 'id' ] ) )
        {
            $label[ 'htmlOptions' ][ 'for' ] = $this->options[ 'htmlOptions' ][ 'id' ] ;
        }

        $labelHtmlOptions = isset ( $label[ 'htmlOptions' ] ) ? $label[ 'htmlOptions' ] : array ( ) ;
        $labelClass = isset ( $label[ 'class' ] ) ? $label[ 'class' ] : array ( ) ;
        $labelStyle = isset ( $label[ 'style' ] ) ? $label[ 'style' ] : array ( ) ;
        $labelContent = isset ( $label[ 'content' ] ) ? $label[ 'content' ] : '' ;

        $labelMarkup = $hasLabel ? self::createMarkup ( 'label',
                                                        $labelHtmlOptions,
                                                        $labelStyle,
                                                        $labelClass,
                                                        $labelContent, true ) : '' ;

        # ================================= </ Set label
        # Set item markup ================================= :

        if ( $type == 'input' && ( isset ( $options[ 'rightAddon' ] ) || isset ( $options[ 'leftAddon' ] ) ) )
        {
            if ( isset ( $options[ 'rightAddon' ] ) )
            {
                $rightAddon  = $options[ 'rightAddon' ] ;
                $innerMarkup = "<div class=\"input-group\"><div class=\"input-group-addon addon-right\">$rightAddon</div> $innerMarkup </div>" ;
            }
            if ( isset ( $options[ 'leftAddon' ] ) )
            {
                $leftAddon = $options[ 'leftAddon' ] ;

                $addedbuttons = isset ( $options[ 'remove' ] ) ? $options[ 'remove' ] : '' ;

                $addedbuttonsMarkup = '' ;

                $singleName = substr ( $htmlOptionsArr[ 'name' ], 0,
                                       strrpos ( $htmlOptionsArr[ 'name' ], '[' ) ) ;
                $lastId     = substr ( $htmlOptionsArr[ 'name' ],
                                       strlen ( $htmlOptionsArr[ 'name' ] ) - 2 ) ==
                        '[]' ? 0 : 1 ;

                if ( $addedbuttons )
                {

                    foreach ( $addedbuttons as $key => $val )
                    {

                        $lastId = $key ;

                        if ( ! empty ( $val ) )
                        {

                            $name = $options[ 'name' ] . "[$key]" ;
                            $name = preg_replace ( '/\[]/', '', $name, 1 ) ;

                            if ( is_array ( $val ) )
                            {

                                sort ( $val ) ;
                                $val = $val[ 0 ] ;
                            }

                            unset ( $htmlOptionsArr[ 'id' ] ) ;
                            $htmlOptionsArr[ 'name' ]  = $singleName . '[' . $key . ']' ;
                            $htmlOptionsArr[ 'value' ] = $val ;
                            $thisInput                 = self::createMarkup ( 'input',
                                                                              $htmlOptionsArr,
                                                                              $styleArr,
                                                                              $classArr,
                                                                              '',
                                                                              false ) ;

                            $addedbuttonsMarkup .= "<div class=\"input-group\" style=\"margin-bottom:10px;\">" .
                                    $thisInput .
                                    "<div class=\"input-group-addon\"><i class=\"fa fa-minus removeCopyInput\" style=\"font-size:9px;\"></i></div></div>" ;
                        }
                    }
                }

                if ( isset ( $options[ 'remove' ] ) && $options[ 'remove' ] )
                {

                    $lastId                   = $addedbuttons ?  ++ $lastId : $lastId ;
                    $htmlOptionsArr[ 'name' ] = $singleName . '[' . $lastId . ']' ;
                    unset ( $htmlOptionsArr[ 'value' ] ) ;
                }

                $finalInput  = self::createMarkup ( 'input', $htmlOptionsArr,
                                                    $styleArr, $classArr, '',
                                                    false ) ;
                $innerMarkup = $addedbuttonsMarkup .
                        "<div class=\"input-group\">$finalInput<div class=\"input-group-addon\">$leftAddon</div></div>" ;
            }

            $elementMarkup = self::createMarkup ( 'div', array ( ), array ( ),
                                                  array (
                        "col-xs-$xsElementWidth",
                        "col-md-$elementWidth",
                        'form-group',
                            ), $innerMarkup, true ) ;
        }
        else
        {
            $elementMarkup = self::createMarkup ( 'div', array ( ), array ( ),
                                                  array (
                        "col-xs-$xsElementWidth",
                        "col-md-$elementWidth",
                        'form-group',
                            ), $innerMarkup, true ) ;
        }

        # ================================= </ Set item markup

        $this->markup .= $labelMarkup ;
        $this->markup .= $elementMarkup ;

        # clearfix for block elements ================================= :

        if ( ! ( isset ( $this->options[ 'block' ] ) && ! $this->options[ 'block' ] ) )
        {
            self::clearFix () ;
        }
    }

    private function createChoices ( $choicesArr, $type )
    {

        $name = isset ( $this->options[ 'name' ] ) ? $this->options[ 'name' ] : $this->options[ 'htmlOptions' ][ 'name' ] ;

        $selected = array ( ) ;

        if ( isset ( $this->valuesArray[ $name ] ) )
        {

            $selected = $this->valuesArray[ $name ] ;
        }
        else
        {
            if ( isset ( $this->options[ 'selected' . '' ] ) )
            {

                $selected = $this->options[ 'selected' ] ;
            }
        }

        if ( ! is_array ( $selected ) )
        {
            $selected = array ( $selected ) ;
        }

        $markup = '' ;

        if ( $type == 'select' )
        {
            $markup = '<option></option>' ;

            foreach ( $choicesArr as $value => $content )
            {

                $opt = in_array ( $value, $selected ) ? array ( 'selected' => '' ) : array ( ) ;
                $opt[ 'value' ] = $value ;

                $markup .= self::createMarkup ( 'option', $opt, array ( ),
                                                array ( ), $content, true ) ;
            }
        }
        else
        {

            $htmlOptions = isset ( $this->options[ 'htmlOptions' ] ) ? $this->options[ 'htmlOptions' ] : array ( ) ;
            $htmlOptions[ 'type' ] = $type ;

            $htmlOptions[ 'name' ] = $name ;

            if ( $type == 'checkbox' )
            {
                $htmlOptions[ 'name' ] = $htmlOptions[ 'name' ] . '[]' ;
            }

            foreach ( $choicesArr as $value => $content )
            {
                if ( in_array ( $value, $selected ) )
                {
                    $htmlOptions[ 'checked' ] = '' ;
                }
                else
                {
                    unset ( $htmlOptions[ 'checked' ] ) ;
                }

                $htmlOptions[ 'value' ] = $value ;

                $inputMarkup = self::createMarkup ( 'input', $htmlOptions,
                                                    array ( ), array ( ), '' ) ;

                if ( isset ( $this->options[ 'linear' ] ) && $this->options[ 'linear' ] )
                {
                    $markup .= "<label>$inputMarkup $content</label><br>" ;
                }
                else
                {
                    $markup .= "<label>$content $inputMarkup</label>" ;
                }
            }
        }

        return $markup ;
    }

}