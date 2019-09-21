<?php
$title = $row ? 'editcolleague' : 'addcolleague' ;
$wholesaler_set = array('enabled' => 'فعال' , 'disabled' => 'غیرفعال');
/* @var $this membersView */

$this->registerWidgets ( array (
    'formW'      => 'form',
    'boxW'       => 'box',
    'pageTitleW' => 'pageTitle'
) ) ;


//$this->

echo $this->pageTitleW->renderTitle ( array (
    'title' => \f\ifm::t ( $title ),
    'links' => array (
        array (
            'title' => \f\ifm::t ( 'listcolleague' ),
            'href'  => \f\ifm::app ()->baseUrl . 'shop/colleague/index' ) ) ) ) ;


echo $this->boxW->begin ( array (
    'type'  => 'form',
    'title' => \f\ifm::t ( $title ) ) ) ;



$form = '' ;
$form.=$this->formW->begin ( array (
    'htmlOptions' => array (
        'method' => 'post',
        'action' => \f\ifm::app ()->baseUrl . 'shop/colleague/colleagueSave',
        'id'     => 'colleagueAdd'
    ),
        ) ) ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'hidden',
        'name'  => 'id',
        'value' => $row[ 'id' ],
    ),
        ) ) ;


$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'       => 'text',
        'name'       => 'name',
        'value'      => $row[ 'name' ],
        'disabled'   => 'disabled'
    ),
    'validation' => array (
        'required' => ''
    ),
    'label'    => array (
        'text' => \f\ifm::t ( 'name' ),
    ),
        ) ) ;
$form.=$this->formW->rowEnd () ;
$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'       => 'text',
        'name'       => 'address',
        'value'      => $row[ 'address' ],
        'disabled'   => 'disabled'
    ),
    'validation' => array (
        'required' => ''
    ),
    'label'    => array (
        'text' => \f\ifm::t ( 'address' ),
    ),
) ) ;
$form.=$this->formW->rowEnd () ;
$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'       => 'text',
        'name'       => 'phone',
        'value'      => $row[ 'phone' ],
        'disabled'   => 'disabled'
    ),
    'validation' => array (
        'required' => ''
    ),
    'label'    => array (
        'text' => \f\ifm::t ( 'phone' ),
    ),
) ) ;
$form.=$this->formW->rowEnd () ;
$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'       => 'text',
        'name'       => 'mobile',
        'value'      => $row[ 'mobile' ],
        'disabled'   => 'disabled'
    ),
    'validation' => array (
        'required' => ''
    ),
    'label'    => array (
        'text' => \f\ifm::t ( 'mobile' ),
    ),
) ) ;
$form.=$this->formW->rowEnd () ;
$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'       => 'text',
        'name'       => 'email',
        'value'      => $row[ 'email' ],
        'disabled'   => 'disabled'
    ),
    'validation' => array (
        'required' => ''
    ),
    'label'    => array (
        'text' => \f\ifm::t ( 'email' ),
    ),
) ) ;
$form.=$this->formW->rowEnd () ;
$form.=$this->formW->rowStart () ;
$form.=$this->formW->select ( array (
    'htmlOptions' => array (
        'id'    => 'wholesaler_set',
        'name'  => 'wholesaler_set',
        'class' => 'wholesaler_set'
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'wholesaler_set' )
    ),
    'choices'     => $wholesaler_set,
    'selected'    => $row[ 'wholesaler_set' ] ? $row[ 'wholesaler_set' ] : ''
) ) ;
$form.=$this->formW->rowEnd () ;



$form.='<br></br>' ;
$form.=$this->formW->rowStart () ;
$form.=$this->formW->buttonTag ( array (
    'htmlOptions' => array (
        'type'    => 'submit',
    ),
    'content' => '<i class="fa fa-floppy-o"></i> ' . ($row ? \f\ifm::t ( 'saveEdit' ) : \f\ifm::t ( 'saveNew' )),
        ) ) ;
$form.=$this->formW->rowEnd () ;


$form.=$this->formW->flush () ;

echo $form ;

echo $this->boxW->flush () ;
?>

<script>
    widgetHelper.makeSelect2('select','<?= \f\ifm::t ( 'select' ) ?>');
    widgetHelper.formSubmit('#colleagueAdd');
   
</script>

<? ?>