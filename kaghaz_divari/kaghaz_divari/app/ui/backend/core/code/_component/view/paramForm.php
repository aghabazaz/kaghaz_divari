<?php

$form2 = "";

$form2 .= $form->rowStart () ;
$form2 .= $form->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'p_name[]',
        'value' => (isset($data)) ? $data[ 'name' ] : ''
    ),
    'style' => array (
        'direction' => 'rtl',
    ),
    'label'     => array (
        'text'  => \f\ifm::t ( 'name' ),
    ),
    'block' => array ( )
        ) ) ;

$form2 .= $form->input ( array (
        'htmlOptions' => array (
            'type'  => 'hidden',
            'name'  => 'p_id[]',
            'value' => isset ( $data[ 'id' ] ) ? $data[ 'id' ] : ''
        )
            ) ) ;        
$form2 .= $form->rowEnd () ;

$form2 .= $form->rowStart () ;
$form2 .= $form->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'p_title[]',
        'value' => (isset($data)) ? $data[ 'title' ] : ''
    ),
    'style' => array (
        'direction' => 'rtl',
    ),
    'label'     => array (
        'text'  => \f\ifm::t ( 'title' ),
    ),
    'block' => array ( )
        ) ) ;
$form2 .= $form->rowEnd () ;

$form2.= $form->rowStart () ;
$index = $i-1;
$form2.= $form->radio ( array (
    'htmlOptions' => array (
        'name'    => 'p_type'.$index.'[]',
        'class'   => 'info',
        'id' => 'p_type'.$index
    ),
    'choices' => array (
        'int'    => \f\ifm::t ( 'int' ),
        'string' => \f\ifm::t ( 'string' )
    ),
    'label'  => array (
        'text'    => \f\ifm::t ( 'type' ),
    ),
    'checked' => (isset($data)) ? $data[ 'type' ] : 'int',
    'linear'  => TRUE,
    'block'   => array ( )
        ) ) ;
$form2.= $form->rowEnd () ;


$form2 .= $form->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'defaultValue[]',
        'value' => (isset($data)) ? $data[ 'defaultValue' ] : ''
    ),
    'style' => array (
        'direction' => 'rtl',
    ),
    'label'     => array (
        'text'  => \f\ifm::t ( 'defaultValue' ),
    ),
    'block' => array ( )
        ) ) ;

$form2 .= $form->rowStart () ;
$form2 .= $form->checkbox ( array (
    'htmlOptions' => array (
        'name'    => 'required'.$index.'[]',
        'id' => 'required'.$index
    ),
    'choices' => array ( ''      => 'required' ),
    'label' => array (
        'text'    => \f\ifm::t ( 'required' ),
    ),
    'checked' => (isset($data) && $data[ 'required' ] == 'required') ? array('required'=> $data[ 'required' ])  : array(),
    'block' => array ( )
        ) ) ;
$form2 .= $form->rowEnd () ;

$form2 .= $form->rowStart () ;
$form2 .= $form->textarea ( array (
    'htmlOptions' => array (
        'name' => 'p_description[]'
    ),
    'style' => array (
        'height'  => '100px',
    ),
    'content' => (isset($data)) ? $data[ 'description' ] : '',
    'label'   => array (
        'text'  => \f\ifm::t ( 'description' ),
    ),
    'block' => array ( )
        )
        ) ;

$form2 .= $form->rowEnd () ;
?>
