<?php
//echo $param;
$title = $row ? 'editslide' : 'addslide' ;
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
            'title' => \f\ifm::t ( 'listSlide' ),
            'href'  => \f\ifm::app ()->baseUrl . 'cms/slide/index' ) ) ) ) ;


echo $this->boxW->begin ( array (
    'type'  => 'form',
    'title' => \f\ifm::t ( $title ) ) ) ;



$form = '' ;
$form.=$this->formW->begin ( array (
    'htmlOptions' => array (
        'method' => 'post',
        'action' => \f\ifm::app ()->baseUrl . 'cms/slide/slideSave',
        'id'     => 'slideAdd'
    ),
        ) ) ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'hidden',
        'name'  => 'id',
        'value' => $row[ 'id' ],
    ),
        ) ) ;

/*$form.=$this->formW->rowStart () ;
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
$form.=$this->formW->rowEnd () ;*/
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
        'text' => \f\ifm::t ( 'titleSlide' ),
    ),
        ) ) ;
$form.=$this->formW->rowEnd () ;
//$form.=$this->formW->rowStart () ;
//$form.=$this->formW->input ( array (
//    'htmlOptions' => array (
//        'type'       => 'text',
//        'name'       => 'comment',
//        'value'      => $row[ 'comment' ],
//    ),
//    
//    'label'    => array (
//        'text' => \f\ifm::t ( 'comment' ),
//    ),
//        ) ) ;
//$form.=$this->formW->rowEnd () ;
/*$form.=$this->formW->rowStart () ;
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
*/
$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'       => 'text',
        'name'       => 'link',
        'value'      => $row[ 'link' ],
    ),
    'style' => array (
        'direction' => 'ltr'
    ),
    'label'    => array (
        'text' => \f\ifm::t ( 'link' ),
    ),
        ) ) ;
$form.=$this->formW->rowEnd () ;
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
</div>' ;*/
$form.=$this->formW->rowStart () ;
$form.=$this->formW->buttonTag ( array (
    'htmlOptions' => array (
        'type'    => 'button',
        'id'      => 'selectLogoFooterPicBtn',
        'class'   => 'btn btn-default'
    ),
    'content' => '<i class="fa fa-upload"></i> ' . \f\ifm::t ( 'fileSelect' ),
    'label'   => array (
        'text'   => \f\ifm::t ( 'picture' ),
    ),
    'action' => array (
        'preServerSideAction' => array (
            'route'   => 'core.fileManager.registerUploadSession',
            'options' => array ( //change
                'multiUpload' => 10,
                'extensions'  => '.jpg, .png, .bmp, .jpeg',
                'tasks'       => array ( 'upload', 'select' )
            ),
        ),
        'display' => 'dialog',
        'params'  => array (
            'targetRoute'    => "core.fileManager.getUploadForm",
            'triggerElement' => 'selectLogoFooterPicBtn', //chanage
            'containerId'    => '#fileContainer2',
            'urlParams'      => array (
                'path'        => 'slide' //chanage
            ),
            'dialogTitle' => \f\ifm::t ( "fileUpload" ),
            'ajaxParams'  => array (
                'mode'   => $row[ 'picture' ] >0 ? 'update':'' ,
                'fileId' => $row[ 'picture' ],
                'path'   => 'slide'  //chanage
            )
        )
    ) ) ) ;

$form .= $this->formW->colStart () ;

$fileIdInput = \f\html::readyMarkup ( 'input', '',
                                      array (
            'htmlOptions' => array (
                'type'  => 'hidden',
                'name'  => 'picture',
                'id'    => 'fileId',
                'value' => $row[ 'picture' ]
            ) ) ) ;

$profilePic = \f\html::readyMarkup ( 'img', '',
                                     array (
            'htmlOptions' => array (
                'src'      => \f\ifm::app ()->fileBaseUrl . $row[ 'picture' ],
                'data-src' => \f\ifm::app ()->fileBaseUrl . $row[ 'picture' ],
            ),
            'style'    => array (
                'position'   => 'absolute',
                'left'       => '30px',
                'top'        => "-35px",
                'max-width'  => '50px',
                'max-height' => '70px',
                'display'    => $row[ 'picture' ] == '' ? 'none' : 'block'
            )
        ) ) ;

//$profilePic .= $row[ 'profile_pic' ] == '' ? \f\ifm::t('noFileSelected') : '' ;

$form.= \f\html::readyMarkup ( 'div', $fileIdInput . $profilePic,
                               array (
            'htmlOptions' => array (
                'id'        => 'fileContainer2',
                'data-type' => 'image'
            ),
            'style'     => array (
                'margin-top' => '15px'
            )
                ), true ) ;

$form .= $this->formW->colEnd () ;
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
    widgetHelper.formSubmit('#slideAdd');
    $('#color').colorPicker();
    $('.icp-auto').iconpicker();
</script>

<?

?>