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
        'action' => \f\ifm::app()->baseUrl . 'core/setting/sms/smsSettingSave',
        'id'     => 'portAdd'
    ),
        )) ;


$form.=$this->formW->rowStart() ;
$form.=$this->formW->input(array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'userName',
        'value' => $settings[ 'userName' ],
        'placeholder'=>\f\ifm::t('userName')
    ),
    'validation'  => array (
        'required' => ''
    ),
    'label'       => array (
        'text' => \f\ifm::t('userName'),
    ),
        )) ;
$form.=$this->formW->rowEnd() ;

$form.=$this->formW->rowStart() ;
$form.=$this->formW->input(array (
    'htmlOptions' => array (
        'type'  => 'password',
        'name'  => 'passWord',
        'value' => $settings[ 'passWord' ],
        'placeholder'=>\f\ifm::t('password')
    ),
    'validation'  => array (
        'required' => ''
    ),
    'label'       => array (
        'text' => \f\ifm::t('password'),
    ),
        )) ;
$form.=$this->formW->rowEnd() ;

$form.=$this->formW->rowStart() ;
$form.=$this->formW->input(array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'domain',
        'value' => $settings[ 'domain' ],
        'placeholder'=>\f\ifm::t('domain')
    ),
    'validation'  => array (
        'required' => ''
    ),
    'label'       => array (
        'text' => \f\ifm::t('domain'),
    ),
        )) ;
$form.=$this->formW->rowEnd() ;

$form.=$this->formW->rowStart() ;
$form.=$this->formW->input(array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'webService',
        'value' => $settings[ 'webService' ],
        'placeholder'=>\f\ifm::t('webService')
    ),
    'validation'  => array (
        'required' => ''
    ),
    'label'       => array (
        'text' => \f\ifm::t('webService'),
    ),
        )) ;
$form.=$this->formW->rowEnd() ;

$form.=$this->formW->rowStart() ;
$form.=$this->formW->input(array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'senderNumber',
        'value' => $settings[ 'senderNumber' ],
        'placeholder'=>\f\ifm::t('senderNumber')
    ),
    'validation'  => array (
        'required' => ''
    ),
    'label'       => array (
        'text' => \f\ifm::t('senderNumber'),
    ),
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