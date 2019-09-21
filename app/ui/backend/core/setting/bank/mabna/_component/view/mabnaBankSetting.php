<?php
/* @var $this smsCenterView */

$this->registerWidgets(array (
    'formW'      => 'form',
    'boxW'       => 'box',
    'pageTitleW' => 'pageTitle'
)) ;

echo $this->pageTitleW->renderTitle(array (
    'title' => \f\ifm::t('portSetting'),
     )) ;


echo $this->boxW->begin(array (
    'type'  => 'form',
    'title' =>  \f\ifm::t('portSetting') )) ;



$form = '' ;
$form.=$this->formW->begin(array (
    'htmlOptions' => array (
        'method' => 'post',
        'action' => \f\ifm::app()->baseUrl . 'core/setting/bank/mabna/mabnaBankSettingSave',
        'id'     => 'portAdd'
    ),
        )) ;


$form.=$this->formW->rowStart() ;
$form.=$this->formW->input(array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'merchantID',
        'value' => $settings[ 'merchantID' ],
       
    ),
    'validation'  => array (
        'required' => '',
       
    ),
    'label'       => array (
        'text' => \f\ifm::t('merchantID'),
    ),
    'style'=>array(
        'direction'=>'ltr'
    )
        )) ;
$form.=$this->formW->rowEnd() ;

$form.=$this->formW->rowStart() ;
$form.=$this->formW->input(array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'terminalID',
        'value' => $settings[ 'terminalID' ],
        
    ),
    'validation'  => array (
        'required' => ''
    ),
    'label'       => array (
        'text' => \f\ifm::t('terminalID'),
    ),
     'style'=>array(
        'direction'=>'ltr'
    )
        )) ;
$form.=$this->formW->rowEnd() ;

$form.=$this->formW->rowStart() ;
$form.=$this->formW->textarea(array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'publicKey',
       
        
    ),
    'validation'  => array (
        'required' => ''
    ),
    'label'       => array (
        'text' => \f\ifm::t('publicKey'),
    ),
     'style'=>array(
        'direction'=>'ltr',
           'height'=>'110px'
    ),
    'content' => $settings[ 'publicKey' ],
        )) ;
$form.=$this->formW->rowEnd() ;
$form.=$this->formW->rowStart() ;
$form.=$this->formW->textarea(array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'privateKey',
       
        
    ),
    'validation'  => array (
        'required' => ''
    ),
    'label'       => array (
        'text' => \f\ifm::t('privateKey'),
    ),
     'style'=>array(
        'direction'=>'ltr',
         'height'=>'280px'
    ),
    'content' => $settings[ 'privateKey' ],
        )) ;
$form.=$this->formW->rowEnd() ;

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