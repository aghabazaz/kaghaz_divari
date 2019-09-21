<?php

//\f\pr($row);
//echo $param;
$title = $row ? 'editLead' : 'addLead' ;
//var_dump($param);
/* @var $this membersView */

$this->registerWidgets ( array (
    'formW'      => 'form',
    'boxW'       => 'box',
    'pageTitleW' => 'pageTitle'
) ) ;
$form = '' ;

$form.=$this->formW->begin ( array (
    'htmlOptions' => array (
        'method' => 'post',
        'action' => \f\ifm::app ()->baseUrl . 'cms/contact/sendAnswer',
        'id'     => 'awardsAdd'
    ),
        ) ) ;
$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'title',
        'value'=>'پاسخ به پیام شما در سامانه رزرو آنلاین',
    ),
    'label' => array (
        'text' => \f\ifm::t ( 'title' ),
    ),
    'block' => 'block',
     
        ) ) ;
$form.=$this->formW->rowEnd () ;
$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'reciever_name',
        'value'=>$params['name'],
    ),
    'label' => array (
        'text' => \f\ifm::t ( 'reciever_name' ),
    ),
    'block' => 'block',
        ) ) ;
$form.=$this->formW->rowEnd () ;
$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'reciever_email',
        'value'=>$params['email'],
    ),
    'label' => array (
        'text' => \f\ifm::t ( 'reciever_email' ),
    ),
    'block' => 'block',
        ) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->textarea ( array (
    'htmlOptions' => array (
        'name'  => 'message',
        'rows'=>3,
        'readonly'=>''
    ),
    'content'=>$params['message'],
    'label' => array (
        'text' => \f\ifm::t ( 'message' ),
    ),
    'block' => 'block',
        ) ) ;
$form.=$this->formW->rowEnd () ;
$form.=$this->formW->rowStart () ;
$form.=$this->formW->textarea ( array (
    'htmlOptions' => array (
        'name'  => 'answer',
        'rows'=>10
    ),
    'content'=>$params[''],
    'label' => array (
        'text' => \f\ifm::t ( 'answerMsg' ),
    ),
    'block' => 'block',
        ) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=\f\html::markupBegin('button',
                            array (
            'htmlOptions' => array (
                'type'  => 'submit',
                'class' => 'btn btn-primary' ) )) ;
$form.='<i class="fa fa-floppy-o"></i> ' .  (($row['id'])?(\f\ifm::t ( 'send' )):(\f\ifm::t ( 'send' ))) ;
$form.=\f\html::markupEnd('button') ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->flush () ;
echo $form ;
?>
<style>
    .formRow
    {
        padding:0px;
    }
</style>
<script>
    widgetHelper.formSubmit('#awardsAdd');
    $(document).ready(function () {
        widgetHelper.makeSelect2('select', '<?= \f\ifm::t ( 'select' ) ?>');
        $(".comma").keyup(function ()
        {
            //alert('ok');
            addCommas(this);
        });
    });
</script>

