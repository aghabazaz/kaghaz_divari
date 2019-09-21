<?php
$title = $row ? 'editbrand' : 'addbrand' ;
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
            'title' => \f\ifm::t ( 'listbrand' ),
            'href'  => \f\ifm::app ()->baseUrl . 'shop/brand/index' ) ) ) ) ;


echo $this->boxW->begin ( array (
    'type'  => 'form',
    'title' => \f\ifm::t ( $title ) ) ) ;



$form = '' ;
$form.=$this->formW->begin ( array (
    'htmlOptions' => array (
        'method' => 'post',
        'action' => \f\ifm::app ()->baseUrl . 'shop/brand/brandSave',
        'id'     => 'brandAdd'
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
        'name'       => 'title_en',
        'value'      => $row[ 'title_en' ],
    ),
    'validation' => array (
        'required' => ''
    ),
    'label'    => array (
        'text' => \f\ifm::t ( 'title' ),
    ),
    'style'=>array(
        'direction'=>'ltr'
    )
        ) ) ;
$form.=$this->formW->rowEnd () ;
$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'       => 'text',
        'name'       => 'title_fa',
        'value'      => $row[ 'title_fa' ],
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
$form.=$this->formW->buttonTag ( array (
    'htmlOptions' => array (
        'type'    => 'button',
        'id'      => 'selectBrandLogo',
        'class'   => 'btn btn-default'
    ),
    'content' => '<i class="fa fa-upload"></i> ' . \f\ifm::t ( 'fileSelect' ),
    'label'   => array (
        'text'   => \f\ifm::t ( 'brandlogo' ),
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
            'triggerElement' => 'selectBrandLogo', //chanage
            'containerId'    => '#fileContainer3',
            'urlParams'      => array (
                'path'        => 'shop.brand' //chanage
            ),
            'dialogTitle' => \f\ifm::t ( "fileUpload" ),
            'ajaxParams'  => array (
                'mode'   => $row[ 'nationCard' ] > 0 ? 'update' : '',
                //'mode'   => '',
                'fileId' => $row[ 'nationCard' ],
                'path'   => 'shop.brand'  //chanage
            )
        )
    ) ) ) ;

$form .= $this->formW->colStart () ;
$fileIdInput = \f\html::readyMarkup ( 'input', '',
                                      array (
            'htmlOptions' => array (
                'type'  => 'hidden',
                'name'  => 'logo',
                'id'    => 'fileId',
                'value' => $row[ 'logo' ]
            ) ) ) ;

$profilePic = \f\html::readyMarkup ( 'img', '',
                                     array (
            'htmlOptions' => array (
                'src'      => \f\ifm::app ()->fileBaseUrl . $row[ 'logo' ],
                'data-src' => \f\ifm::app ()->fileBaseUrl . $row[ 'logo' ],
            ),
            'style'    => array (
                'position'   => 'absolute',
                'left'       => '30px',
                'top'        => "-35px",
                'max-width'  => '50px',
                'max-height' => '70px',
                'display'    => $row[ 'logo' ] > 0 ? 'block' : 'none'
            )
        ) ) ;

//$profilePic .= $row[ 'profile_pic' ] == '' ? \f\ifm::t('noFileSelected') : '' ;

$form.= \f\html::readyMarkup ( 'div', $fileIdInput . $profilePic,
                               array (
            'htmlOptions' => array (
                'id'        => 'fileContainer3',
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
    widgetHelper.formSubmit('#brandAdd');
    
    jQuery(document).ready(function () {

    });
</script>

<? ?>