<?php
/* @var $this smsCenterView */

$this->registerWidgets(array (
    'formW'      => 'form',
    'boxW'       => 'box',
    'pageTitleW' => 'pageTitle'
)) ;

echo $this->pageTitleW->renderTitle(array (
    'title' => \f\ifm::t('aboutSetting'),
     )) ;


echo $this->boxW->begin(array (
    'type'  => 'form',
    'title' =>  \f\ifm::t('aboutSetting') )) ;



$form = '' ;
$form.=$this->formW->begin(array (
    'htmlOptions' => array (
        'method' => 'post',
        'action' => \f\ifm::app()->baseUrl . 'cms/about/aboutSettingSave',
        'id'     => 'portAdd'
    ),
        )) ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->textarea ( array (
    'htmlOptions' => array (
        'name'  => 'ShortContent',
    ),
    'label' => array (
        'text'    => \f\ifm::t ( 'ShortContent' )
    ),
    'editor'  => true,
    'content' => $settings[ 'ShortContent' ]
) ) ;

$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->textarea ( array (
    'htmlOptions' => array (
        'name'  => 'content',
    ),
    'label' => array (
        'text'    => \f\ifm::t ( 'content' )
    ),
    'editor'  => true,
    'content' => $settings[ 'content' ]
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