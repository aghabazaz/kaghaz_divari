<?php
$title = $row ? 'edittransportation' : 'addtransportation' ;
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
            'title' => \f\ifm::t ( 'listtransportation' ),
            'href'  => \f\ifm::app ()->baseUrl . 'shop/transportation/index' ) ) ) ) ;


echo $this->boxW->begin ( array (
    'type'  => 'form',
    'title' => \f\ifm::t ( $title ) ) ) ;



$form = '' ;
$form.=$this->formW->begin ( array (
    'htmlOptions' => array (
        'method' => 'post',
        'action' => \f\ifm::app ()->baseUrl . 'shop/transportation/transportationSave',
        'id'     => 'transpor_Add'
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
        'type'  => 'text',
        'name'  => 'cost',
        'value' => $row[ 'cost' ],
        'class' => 'comma',
        'placeholder'=>'در صورت دریافت هزینه به صورت پس پرداخت این فیلد خالی باشد.',
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'cost' ),
    )
) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'scope_day',
        'value' => $row[ 'scope_day' ],
        'placeholder'=>'مثال : 2',
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'scope_day' ),
    )
) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'scope_time',
        'value' => $row[ 'scope_time' ],
        'placeholder'=>'مثال: 8:30 الی 12:00 صبح - 13:00 الی 16:00 بعداز ظهر - 18:00 الی 20:00 عصر',
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'scope_time' ),
    )
) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->textarea ( array (
    'htmlOptions' => array (
        'name'      => 'description',
        'value'     => $row[ 'description' ],
        'rows'      => 4,
        'maxlength' => 200
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'description' )
    ),
    'content'     => $row[ 'description' ]
        ) ) ;

$form.=$this->formW->rowEnd () ;


$form.='<br></br>' ;
$form.=$this->formW->rowStart () ;
$form.=$this->formW->buttonTag ( array (
    'htmlOptions' => array (
        'type' => 'submit',
    ),
    'content'     => '<i class="fa fa-floppy-o"></i> ' . ($row ? \f\ifm::t ( 'saveEdit' ) : \f\ifm::t ( 'saveNew' )),
        ) ) ;
$form.=$this->formW->rowEnd () ;


$form.=$this->formW->flush () ;

echo $form ;

echo $this->boxW->flush () ;
?>

<script>
    widgetHelper.makeSelect2('select', '<?= \f\ifm::t ( 'select' ) ?>');
    widgetHelper.formSubmit('#transpor_Add');

    jQuery(document).ready(function () {

    });
</script>

<? ?>