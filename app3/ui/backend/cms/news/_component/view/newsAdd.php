<?php
//echo $param;
$title = $row ? 'editContent' : 'addContent' ;
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
            'title' => \f\ifm::t ( 'listContent' ),
            'href'  => \f\ifm::app ()->baseUrl . 'cms/news/index' ) ) ) ) ;


echo $this->boxW->begin ( array (
    'type'  => 'form',
    'title' => \f\ifm::t ( $title ) ) ) ;



$form = '' ;
$form.=$this->formW->begin ( array (
    'htmlOptions' => array (
        'method' => 'post',
        'action' => \f\ifm::app ()->baseUrl . 'cms/news/newsSave',
        'id'     => 'newsAdd'
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
        'text' => \f\ifm::t ( 'titleContent' ),
    ),
        ) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->textarea ( array (
    'htmlOptions' => array (
        'name'       => 'short',
        'value'      => $row[ 'short' ],
        'rows'       => 4
    ),
    'validation' => array (
        'required' => ''
    ),
    'label'    => array (
        'text'    => \f\ifm::t ( 'shortContent' )
    ),
    'content' => $row[ 'short' ]
        ) ) ;
$form.=$this->formW->rowEnd () ;
$form.=$this->formW->rowStart () ;
$form.=$this->formW->textarea ( array (
    'htmlOptions' => array (
        'name' => 'content',
    ),
    'label' => array (
        'text'    => \f\ifm::t ( 'news2' )
    ),
    'editor'  => true,
    'content' => $row[ 'content' ]
        ) ) ;

$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->buttonTag ( array (
    'htmlOptions' => array (
        'type'    => 'button',
        'id'      => 'selectProfilePicBtn',
        'class'   => 'btn btn-default'
    ),
    'content' => '<i class="fa fa-upload"></i> ' . \f\ifm::t ( 'fileSelect' ),
    'label'   => array (
        'text'   => \f\ifm::t ( 'picContent' ),
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
            'triggerElement' => 'selectProfilePicBtn', //chanage
            'containerId'    => '#fileContainer',
            'urlParams'      => array (
                'path'        => 'cms.news' //chanage
            ),
            'dialogTitle' => \f\ifm::t ( "fileUpload" ),
            'ajaxParams'  => array (
                'mode'   => $row[ 'picture' ] == '' ? '' : 'update',
                'fileId' => $row[ 'picture' ],
                'path'   => 'cms.news'  //chanage
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
                'id'        => 'fileContainer',
                'data-type' => 'image'
            ),
            'style'     => array (
                'margin-top' => '15px'
            )
                ), true ) ;

$form .= $this->formW->colEnd () ;
$form.=$this->formW->rowEnd () ;


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
<!--
<input type="hidden" id="thisid" style="width:300px" multiple="multiple" class="input-xlarge" />
-->
<script>
    widgetHelper.makeSelect2('select','<?= \f\ifm::t ( 'select' ) ?>');
    widgetHelper.formSubmit('#newsAdd');
    
   

    
</script>

