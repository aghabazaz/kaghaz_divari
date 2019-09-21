<?php
$title      = 'changePassword' ;
$icon       = 'fa-key' ;
$pageWidget = \f\widgetFactory::make ( 'pageTitle' ) ;
echo $pageWidget->renderTitle ( array (
    'title' => '<i class="fa ' . $icon . '"></i> ' . \f\ifm::t ( $title ),
    'links' => array (
    ) ) ) ;
$this->registerWidgets ( array (
    'formW'      => 'form',
    'boxW'       => 'box',
    'pageTitleW' => 'pageTitle'
) ) ;
$form        = '' ;
$form.=$this->formW->begin ( array (
    'htmlOptions' => array (
        'method' => 'post',
        'action' => \f\ifm::app ()->siteUrl . 'member/changePassword',
        'id'     => 'changePassword'
    ),
        ) ) ;
$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'       => 'text',
        'name'       => 'username',
        'value'      => '',
    ),
    'validation' => array (
        'required' => ''
    ),
    'label'    => array (
        'text' => \f\ifm::t ( 'username' ),
    ),
        ) ) ;
$form.=$this->formW->rowEnd () ;
$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'       => 'password',
        'name'       => 'oldPass',
        'value'      => '',
    ),
    'validation' => array (
        'required' => ''
    ),
    'label'    => array (
        'text' => \f\ifm::t ( 'oldPass' ),
    ),
        ) ) ;
$form.=$this->formW->rowEnd () ;
$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'       => 'password',
        'name'       => 'newPass',
        'value'      => '',
    ),
    'validation' => array (
        'required' => ''
    ),
    'label'    => array (
        'text' => \f\ifm::t ( 'newPass' ),
    ),
        ) ) ;
$form.=$this->formW->rowEnd () ;
$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'       => 'password',
        'name'       => 'renewPass',
        'value'      => '',
    ),
    'validation' => array (
        'required' => ''
    ),
    'label'    => array (
        'text' => \f\ifm::t ( 'renewPass' ),
    ),
        ) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->buttonTag ( array (
    'htmlOptions' => array (
        'type'    => 'submit',
    ),
    'content' => '<i class="fa fa-floppy-o"></i> ' . (\f\ifm::t ( 'savePassword' ) ),
        ) ) ;
$form.=$this->formW->rowEnd () ;
$form.=$this->formW->flush () ;

echo $form ;

echo $this->boxW->flush () ;
?>
<script>
    widgetHelper.formSubmit('#changePassword');
</script>