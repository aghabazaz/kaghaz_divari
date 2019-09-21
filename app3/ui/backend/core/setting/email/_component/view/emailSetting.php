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
        'action' => \f\ifm::app()->baseUrl . 'core/setting/email/emailSettingSave',
        'id'     => 'portAdd'
    ),
        )) ;


$form.=$this->formW->rowStart() ;
$form.=$this->formW->input(array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'email',
        'value' => $settings[ 'email' ],
       
    ),
    'validation'  => array (
        'required' => '',
        'type'=>'email'
    ),
    'label'       => array (
        'text' => \f\ifm::t('userName'),
    ),
    'style'=>array(
        'direction'=>'ltr'
    )
        )) ;
$form.=$this->formW->rowEnd() ;

$form.=$this->formW->rowStart() ;
$form.=$this->formW->input(array (
    'htmlOptions' => array (
        'type'  => 'password',
        'name'  => 'passWord',
        'value' => $settings[ 'passWord' ],
      
    ),
    'validation'  => array (
        'required' => ''
    ),
    'label'       => array (
        'text' => \f\ifm::t('password'),
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
        'name'  => 'port',
        'value' => $settings[ 'port' ],
        
    ),
    'validation'  => array (
        'required' => ''
    ),
    'label'       => array (
        'text' => \f\ifm::t('domain'),
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
        'name'  => 'address',
        'value' => $settings[ 'address' ],
        
       
    ),
    'validation'  => array (
        'required' => ''
    ),
    'label'       => array (
        'text' => \f\ifm::t('webService'),
    ),
     'style'=>array(
        'direction'=>'ltr'
    )
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