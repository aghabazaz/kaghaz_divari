<?php
$this->registerWidgets ( array (
    'formW' => 'form',
) ) ;
$form = '' ;
$form .= $this->formW->rowStart () ;
$form .= $this->formW->input ( array (
    'htmlOptions' => array (
        'type'     => 'text',
        'id'       => 'price_pay',
        'name'     => 'price_pay',
        'value'    => number_format ( $params[ 'order' ] ),
        'readonly' => ''
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'price_pay' ),
    ),
        ) ) ;
$form .= $this->formW->rowEnd () ;
echo $form ;
