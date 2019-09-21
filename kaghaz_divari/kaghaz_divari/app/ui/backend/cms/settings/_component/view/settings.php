<?php
/* @var $this smsCenterView */

$this->registerWidgets(array (
    'formW'      => 'form',
    'boxW'       => 'box',
    'pageTitleW' => 'pageTitle'
)) ;

echo $this->pageTitleW->renderTitle(array (
    'title' => \f\ifm::t('cmsSetting'),
     )) ;


echo $this->boxW->begin(array (
    'type'  => 'form',
    'title' =>  \f\ifm::t('cmsSetting') )) ;



$form = '' ;
$form.=$this->formW->begin(array (
    'htmlOptions' => array (
        'method' => 'post',
        'action' => \f\ifm::app()->baseUrl . 'cms/settings/settingSave',
        'id'     => 'portAdd'
    ),
        )) ;
/*
$form.=$this->formW->rowStart () ;
$form.=$this->formW->textarea ( array (
    'htmlOptions' => array (
        'name' => 'newsletterPageText',
    ),
    'label' => array (
        'text'    => \f\ifm::t ( 'newsletterPageText' )
    ),
    'content' => $settings[ 'newsletterPageText' ]
        ) ) ;

$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->textarea ( array (
    'htmlOptions' => array (
        'name' => 'mainPageText',
    ),
    'label' => array (
        'text'    => \f\ifm::t ( 'mainPageText' )
    ),
    'editor'  => true,
    'content' => $settings[ 'mainPageText' ]
        ) ) ;

$form.=$this->formW->rowEnd () ;
*/
$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'titleIndex',
        'value' => $settings[ 'titleIndex' ],
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'titleIndex' ),
    ),
    'style'       => array (
        'direction' => 'rtl'
    )
) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'titleIndexH1',
        'value' => $settings[ 'titleIndexH1' ],
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'titleIndexH1' ),
    ),
    'style'       => array (
        'direction' => 'rtl'
    )
) ) ;
$form.=$this->formW->rowEnd () ;


$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'titleIndexH2',
        'value' => $settings[ 'titleIndexH2' ],
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'titleIndexH2' ),
    ),
    'style'       => array (
        'direction' => 'rtl'
    )
) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart() ;
$form.=$this->formW->buttonTag(array (
    'htmlOptions' => array (
        'type' => 'submit',
    ),
    'content'     => '<i class="fa fa-floppy-o"></i> ' . (\f\ifm::t('saveEdit')),
        )) ;
$form.=$this->formW->rowEnd() ;


$form.=$this->formW->flush() ;

echo $form ;

echo $this->boxW->flush() ;
?>

<script>
    $(document).ready(function () {
        widgetHelper.makeSelect2('select', '<?= \f\ifm::t ( 'select' ) ?>');
    });
    widgetHelper.formSubmit('#portAdd');
</script>