<?php
$this->registerWidgets ( array (
    'formW' => 'form',
) ) ;
$form = '' ;
$form .= $this->formW->begin ( array (
    'htmlOptions' => array (
        'method' => 'post',
        'action' => \f\ifm::app ()->baseUrl . 'core/seo/saveParameter',
        'id'     => 'seoAdd'
    ),
        ) ) ;
$form .= $this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'hidden',
        'name'  => 'component_id',
        'value' => $params[ 'component_id' ],
    ),
        ) ) ;

$form .= $this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'hidden',
        'name'  => 'item_id',
        'value' => $params[ 'item_id' ],
    ),
        ) ) ;

$form .= $this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'hidden',
        'name'  => 'id',
        'value' => $row[ 'id' ],
    ),
        ) ) ;

$form .= $this->formW->rowStart () ;
$form .= $this->formW->input ( array (
    'htmlOptions' => array (
        'type'        => 'text',
        'name'        => 'title',
        'value'       => $row[ 'title' ],
        'id'          => 'title',
        'onkeyup'     => 'countChar('."'#title'".')',
        'placeholder' => \f\ifm::t ( 'maxLengthTitle' )
    ),
    'validation'  => array (
        'required' => ''
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'title' ),
    ),
        ) ) ;

$form.='<span id="titleMsg" style="color:silver"></span>';
$form .= $this->formW->rowEnd () ;

$form .= $this->formW->rowStart () ;
$form .= $this->formW->textarea ( array (
    'htmlOptions' => array (
        'name'        => 'description',
        'id'          => 'description',
        'onkeyup'     => 'countChar('."'#description'".')',
        'rows'        => 3,
        'placeholder' => \f\ifm::t ( 'maxLengthDescription' )
    ),
    'validation'  => array (
        'required' => ''
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'description' )
    ),
    'content'     => $row[ 'description' ]
        ) ) ;

$form.='<span id="descriptionMsg" style="color:silver"></span>';
$form .= $this->formW->rowEnd () ;


$form .= $this->formW->rowStart () ;
$form .= $this->formW->textarea ( array (
    'htmlOptions' => array (
        'name'        => 'keywords',
        'id'          => 'keywords',
        //'onkeyup'     => 'countWords()',
        'rows'        => 2,
        'placeholder' => \f\ifm::t ( 'maxLengthKeywords' )
    ),
    'validation'  => array (
        'required' => ''
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'keywords' )
    ),
    'content'     => $row[ 'keywords' ]
        ) ) ;
$form.='<span id="keywordsMsg" style="color:silver"></span>';
$form .= $this->formW->rowEnd () ;

$form .= $this->formW->rowStart () ;
$form .= $this->formW->buttonTag ( array (
    'htmlOptions' => array (
        'type' => 'submit',
    ),
    'content'     => '<i class="fa fa-floppy-o"></i> ' . \f\ifm::t ( 'save' ),
        ) ) ;
$form .= $this->formW->rowEnd () ;


echo $form ;
?>

<script>
    widgetHelper.formSubmit('#seoAdd');
    function countChar(id)
    {
        var countChar = $(id).val().length;
        $(id+'Msg').html(countChar+' کاراکتر')
        
    }
    
    function countWords()
    {
        var matches = $('#keywords').val().match(/\b/g);
        var wordCounts = matches ? matches.length / 2 : 0;
        //alert(wordCounts);
        $('#keywordsMsg').html(wordCounts+' کلمه');
        
    }
</script>