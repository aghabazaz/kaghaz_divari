<?php
$title = $row ? 'edit_menu' : 'add_menu' ;
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
            'title' => \f\ifm::t ( 'listMenu' ),
            'href'  => \f\ifm::app ()->baseUrl . 'cms/menu/menutitle/' . $section_id ) ) ) ) ;


echo $this->boxW->begin ( array (
    'type'  => 'form',
    'title' => \f\ifm::t ( $title ) ) ) ;

$form = '' ;
$form.=$this->formW->begin ( array (
    'htmlOptions' => array (
        'method' => 'post',
        'action' => \f\ifm::app ()->baseUrl . 'cms/menu/menuSave',
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
//$form.=$this->formW->input ( array (
//    'htmlOptions' => array (
//        'type'  => 'hidden',
//        'name'  => 'parentTitle',
//        'value' => $row[ 'parentTitle' ],
//    ),
//        ) ) ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'hidden',
        'name'  => 'section_id',
        'value' => $section_id,
    ),
        ) ) ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'hidden',
        'name'  => 'priority',
        'value' => $row[ 'priority' ],
    ),
        ) ) ;

$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'hidden',
        'name'  => 'parentTitle',
        'value' => $row[ 'parentTitle' ],
    ),
        ) ) ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'title',
        'value' => $row[ 'Title' ],
    ),
    'validation'  => array (
        'required' => ''
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'title_menu' ),
    ),
        ) ) ;
$form.=$this->formW->rowEnd () ;
$form .= $this->formW->rowStart () ;
$form .= $this->formW->select ( array (
    'htmlOptions' => array (
        'name' => 'show_title',
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'show_title' )
    ),
    'choices'     => array (
        'enabled'  => 'فعال',
        'disabled' => 'غیرفعال'
    ),
    'selected'    => $row[ 'show_title' ] ? $row[ 'show_title' ] : 'enabled'
) ) ;
$form .= $this->formW->rowEnd () ;
$form .= $this->formW->rowStart () ;
$form .= $this->formW->select ( array (
    'htmlOptions' => array (
        'name'     => 'type',
        'id'       => 'type',
        'onchange' => 'hideElement()'
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'type' )
    ),
    'choices'     => array (
        'link'  => 'لینک',
        'label' => 'برچسب ، سرتیتر'
    ),
    'selected'    => $row[ 'type' ] ? $row[ 'type' ] : 'link'
) ) ;
$form .= $this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$state ;

//$form.=$this->formW->select ( array (
//    'htmlOptions' => array (
//        'name'  => 'parent_id',
//    ),
//    'label' => array (
//        'text'     => \f\ifm::t ( 'titleState' )
//    ),
//    'choices'  => $state,
//    'selected' => $row[ 'parentTitle' ]
//        ) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'link',
        'value' => $row[ 'Link' ],
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'Link_menu' ),
    ),
    'style'       => array (
        'direction' => 'ltr'
    )
        ) ) ;
$form.=$this->formW->rowEnd () ;

$form.='<div class="formRow">
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
$form.=$this->formW->rowStart () ;
$form.=$this->formW->textarea ( array (
    'htmlOptions' => array (
        'name' => 'content',
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'content_menu' )
    ),
    'editor'      => true,
    'content'     => $row[ 'content' ]
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
            'triggerElement' => 'selectProfilePicBtn', //chanage
            'containerId'    => '#fileContainer',
            'urlParams'      => array (
                'path'        => 'cms.menu' //chanage
            ),
            'dialogTitle' => \f\ifm::t ( "fileUpload" ),
            'ajaxParams'  => array (
                'mode'   => $row[ 'picture' ] == 0 ? '' : 'update',
                'fileId' => $row[ 'picture' ],
                'path'   => 'cms.menu'  //chanage
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
                'display'    => $row[ 'picture' ] ==0 ? 'none' : 'block'
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
    widgetHelper.formSubmit('#slideAdd');
    $('.icp-auto').iconpicker();
</script>

<?
?>