<?php
//echo $param;
$title = $row ? 'edittextTemplate' : 'addtextTemplate' ;
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
            'title' => \f\ifm::t ( 'listTextTemplate' ),
            'href'  => \f\ifm::app ()->baseUrl . 'cms/textTemplate/index' ) ) ) ) ;


echo $this->boxW->begin ( array (
    'type'  => 'form',
    'title' => \f\ifm::t ( $title ) ) ) ;



$form = '' ;
$form.=$this->formW->begin ( array (
    'htmlOptions' => array (
        'method' => 'post',
        'action' => \f\ifm::app ()->baseUrl . 'cms/textTemplate/textTemplateSave',
        'id'     => 'textTemplateAdd'
    ),
        ) ) ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'hidden',
        'name'  => 'id',
        'value' => $row[ 'id' ],
    ),
        ) ) ;
/*
$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'       => 'text',
        'name'       => 'top_title',
        'value'      => $row[ 'top_title' ],
    ),
    'validation' => array (
        'required' => ''
    ),
    'label'    => array (
        'text' => \f\ifm::t ( 'top_title' ),
    ),
        ) ) ;
$form.=$this->formW->rowEnd () ;
 * 
 */
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
        'text' => \f\ifm::t ( 'titleTextTemplate' ),
    ),
        ) ) ;

$form.=$this->formW->rowEnd () ;
$form .= $this->formW->rowStart () ;
$form .= $this->formW->textarea ( array (
    'htmlOptions' => array (
        'name' => 'text',
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'text' )
    ),
    'editor'      => true,
    // 'lang'        => TRUE,
    'content'     => $row[ 'text' ]
) ) ;

$form .= $this->formW->rowEnd () ;
$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'color',
        'value' => $row[ 'color' ],
        'id'    => 'color'
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'color' ),
    ),
    'style'       => array (
        'direction' => 'ltr',
        'font'      => '12px Arial'
    )
) ) ;
$form.=$this->formW->rowEnd () ;

$form .= '<div class="formRow">
<div class="col-sm-10">
<label class="col-sm-3 control-label">آیکون</label>
<div class="col-sm-9">
<div class="input-group">
    <input data-placement="bottomRight" class="form-control icp icp-auto" value="' . $row[ 'icon' ] . '" name="icon" type="text" />
    <span class="input-group-addon "></span>
</div>

</div>
</div>
<div class="clear"></div>
</div>' ;
/*
$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'       => 'text',
        'name'       => 'comment',
        'value'      => $row[ 'comment' ],
    ),
    
    'label'    => array (
        'text' => \f\ifm::t ( 'comment' ),
    ),
        ) ) ;
$form.=$this->formW->rowEnd () ;

 
$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'color',
        'value' => $row[ 'color' ],
        'id'    => 'color'
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'color' ),
    ),
    'style'       => array (
        'direction' => 'ltr',
        'font'      => '12px Arial'
    )
        ) ) ;
$form.=$this->formW->rowEnd () ;
 * 
 */
/*
$form.='<div class="formRow">
<div class="col-sm-10">
<label class="col-sm-3 control-label">آیکون</label>
<div class="col-sm-9">
<div class="input-group">
    <input data-placement="bottomRight" class="form-control icp icp-auto" value="'.$row['icon'].'" name="icon" type="text" />
    <span class="input-group-addon "></span>
</div>

</div>
</div>
<div class="clear"></div>
</div>' ;
 * 
 */

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
    widgetHelper.formSubmit('#textTemplateAdd');
    $('#color').colorPicker();
    $('.icp-auto').iconpicker();
</script>

<?

?>