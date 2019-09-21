<?php
//echo $param;
$title = $row ? 'editsection' : 'addsection' ;
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
            'title' => \f\ifm::t ( 'listSection' ),
            'href'  => \f\ifm::app ()->baseUrl . 'cms/section/index' ) ) ) ) ;


echo $this->boxW->begin ( array (
    'type'  => 'form',
    'title' => \f\ifm::t ( $title ) ) ) ;



$form = '' ;
$form.=$this->formW->begin ( array (
    'htmlOptions' => array (
        'method' => 'post',
        'action' => \f\ifm::app ()->baseUrl . 'cms/section/sectionSave',
        'id'     => 'sectionAdd'
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
        'name'       => 'title',
        'value'      => $row[ 'title' ],
    ),
    'validation' => array (
        'required' => ''
    ),
    'label'    => array (
        'text' => \f\ifm::t ( 'titleSection' ),
    ),
        ) ) ;
$form.=$this->formW->rowEnd () ;
/*
$form.=$this->formW->rowStart () ;

$form.=$this->formW->select(array(
    'htmlOptions' => array (
        'name'       => 'type',
      
    ),
    'label'=>array(
        'text'=>  \f\ifm::t('type')
    ),
    'choices'=>$type,
    'selected'=>$row['type']?$row['type']:'NULL'
   
));
$form.=$this->formW->rowEnd () ;
$form.=$this->formW->rowStart () ;

$form.=$this->formW->select(array(
    'htmlOptions' => array (
        'name'       => 'parent',
      
    ),
    'label'=>array(
        'text'=>  \f\ifm::t('parent')
    ),
    'choices'=>$section,
    'selected'=>$row['parent_id']?$row['parent_id']:NULL
   
));
$form.=$this->formW->rowEnd () ;
 * 
 */

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
    widgetHelper.makeSelect2('select','<?=\f\ifm::t ( 'select' )?>');
    widgetHelper.formSubmit('#sectionAdd');
</script>