<?php
$title = $row ? 'editamazing' : 'addamazing' ;
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
            'title' => \f\ifm::t ( 'listamazing' ),
            'href'  => \f\ifm::app ()->baseUrl . 'shop/amazing/index' ) ) ) ) ;


echo $this->boxW->begin ( array (
    'type'  => 'form',
    'title' => \f\ifm::t ( $title ) ) ) ;



$form = '' ;
$form .= $this->formW->begin ( array (
    'htmlOptions' => array (
        'method' => 'post',
        'action' => \f\ifm::app ()->baseUrl . 'shop/amazing/amazingSave',
        'id'     => 'amazingAdd'
    ),
        ) ) ;
$form .= $this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'hidden',
        'name'  => 'id',
        'value' => $row[ 'id' ],
    ),
        ) ) ;

$form .= $this->formW->rowStart () ;
$form .= $this->formW->select ( array (
    'htmlOptions' => array (
        'id'   => 'shop_product_id',
        'name' => 'shop_product_id',
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'title' ),
    ),
    'choices'     => $product,
    'selected'    => $row[ 'shop_product_id' ] ? json_decode ( $row[ 'shop_product_id' ],
                                                               true ) : '',
        ) ) ;

$form .= $this->formW->rowEnd () ;

$form .= $this->formW->rowStart () ;
$form .= $this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'short',
        'value' => $row[ 'short' ],
    ),
    'validation'  => array (
        'required' => ''
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'short' ),
    ),
        ) ) ;
$form .= $this->formW->rowEnd () ;

$form .= $this->formW->rowStart () ;
$form .= $this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'date_start',
        'id'    => 'date_start',
        'value' => $row[ 'date_start' ],
        'class' => 'date'
    ),
    'validation'  => array (
        'required' => ''
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'date_start' ),
    ),
        ) ) ;
$form .= $this->formW->rowEnd () ;

$form .= $this->formW->rowStart () ;
$form .= $this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'date_end',
        'id'    => 'date_end',
        'value' => $row[ 'date_end' ],
        'class' => 'date'
    ),
    'validation'  => array (
        'required' => ''
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'date_end' ),
    ),
        ) ) ;
$form .= $this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->select ( array (
    'htmlOptions' => array (
        'name'     => 'discount_type',
    ),
    'label'    => array (
        'text'     => \f\ifm::t ( 'discount_type' )
    ),
    'choices'  => array(
        'percent'=>'درصد',
        'fixed'=>'مبلغ ثابت (ریال)'
    ),
    'selected' => $row[ 'discount_type' ]
) ) ;
$form.=$this->formW->rowEnd () ;

$form .= $this->formW->rowStart () ;
$form .= $this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'price',
        'id'    => 'price',
        'value' => number_format ( $row[ 'price' ] ),
    ),
    'validation'  => array (
        'required' => ''
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'price' ),
    ),
        ) ) ;
$form .= $this->formW->rowEnd () ;


$form .= $this->formW->rowStart () ;
$form .= $this->formW->textarea ( array (
    'htmlOptions' => array (
        'name' => 'content',
        'rows' => 6
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'content' )
    ),
    'content'     => $row[ 'content' ]
        ) ) ;

$form .= $this->formW->rowEnd () ;



$form .= '<br></br>' ;
$form .= $this->formW->rowStart () ;
$form .= $this->formW->buttonTag ( array (
    'htmlOptions' => array (
        'type' => 'submit',
    ),
    'content'     => '<i class="fa fa-floppy-o"></i> ' . ($row ? \f\ifm::t ( 'saveEdit' ) : \f\ifm::t ( 'saveNew' )),
        ) ) ;
$form .= $this->formW->rowEnd () ;


$form .= $this->formW->flush () ;

echo $form ;

echo $this->boxW->flush () ;
?>

<script>
    widgetHelper.makeSelect2('select', '<?= \f\ifm::t ( 'select' ) ?>');
    widgetHelper.formSubmit('#amazingAdd');
    $(document).ready(function () {
        $('.date').each(function () {

            var selector = "#" + $(this).attr('id');
            var lang = 'fa';
            var newOption = {
            };
            var newOptionTo = {};
            widgetHelper.makeDatePicker(selector, lang, newOption, newOptionTo);

        });

    });
</script>

<? ?>