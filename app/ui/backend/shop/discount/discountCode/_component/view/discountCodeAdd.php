<?php
//echo $param;
$title = $row ? 'editDiscountCode' : 'addDiscountCode' ;
//var_dump($param);
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
            'title' => \f\ifm::t ( 'discountCodeList' ),
            'href'  => \f\ifm::app ()->baseUrl . 'shop/discount/discountCode/index' ) ) ) ) ;


echo $this->boxW->begin ( array (
    'type'  => 'form',
    'title' => \f\ifm::t ( $title ) ) ) ;



$form = '' ;
$form.=$this->formW->begin ( array (
    'htmlOptions' => array (
        'method' => 'post',
        'action' => \f\ifm::app ()->baseUrl . 'shop/discount/discountCode/discountCodeSave',
        'id'     => 'discountCodeAdd'
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
    'htmlOptions' => array(
        'type'       => 'text',
        'name'       => 'title',
        'value'      => $row[ 'title' ],
    ) ,
    'validation' => array (
        'required' => ''
    ),

    'label'    => array (
        'text' => \f\ifm::t ( 'title' ),
    ),
) ) ;
$form.=$this->formW->rowEnd () ;
$form.=$this->formW->rowStart () ;
$form.=$this->formW->select ( array (
    'htmlOptions' => array (
        'id'   => 'type_use',
        'name' => 'type_use',
        //'onchange' => 'getCityByStateId()'
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'type_use' ),
    ),
    'choices'     => $type_use,
    'selected'    => $row[ 'type_use' ] ? $row[ 'type_use' ] : '',
    'validation'  => array (
        'required' => ''
    ),
) ) ;

$form.=$this->formW->rowEnd () ;
$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array(
        'type'       => 'text',
        'name'       => 'credit_code',
        'value'      => $row[ 'credit_code' ],
    ) ,
    'validation' => array (
        'required' => ''
    ),

    'label'    => array (
        'text' => \f\ifm::t ( 'credit_code' ),
    ),
) ) ;
$form.=$this->formW->rowEnd () ;


$form.=$this->formW->rowStart () ;
$form.=$this->formW->select ( array (
    'htmlOptions' => array (
        'name'     => 'type_discount',
    ),
    'label'    => array (
        'text'     => \f\ifm::t ( 'type_discount' )
    ),
    'choices'  => array(
        'percent'=>'درصد',
        'fixed'=>'مبلغ ثابت (تومان)'
    ),
    'selected' => $row[ 'type_discount' ]
) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array(
        'type'       => 'text',
        'name'       => 'price',
        'value'      => $row[ 'price' ],
    ) ,
    'validation' => array (
        'required' => ''
    ),

    'label'    => array (
        'text' => \f\ifm::t ( 'price' ),
    ),
) ) ;
$form.=$this->formW->rowEnd () ;

$form .= $this->formW->rowStart () ;
$form .= $this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'date_credit',
        'id'    => 'date_credit',
        'value' => $row[ 'date_credit' ],
        'class' => 'date'
    ),
    'validation'  => array (
        'required' => ''
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'date_credit' ),
    ),
) ) ;
$form .= $this->formW->rowEnd () ;

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
        widgetHelper.formSubmit('#discountCodeAdd');
        $(document).ready(function () {
            $('.date').each(function () {
                var selector = "#" + $(this).attr('id');
                var lang = 'fa';
                var newOption = {
                };
                var newOptionTo = {};
                widgetHelper.makeDatePicker(selector, lang, newOption, newOptionTo);

            });
            $(".comma").keyup(function ()
            {
                addCommas(this);
            });
        });
    </script>

<?

?>