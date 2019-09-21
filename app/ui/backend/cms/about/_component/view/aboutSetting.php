<?php
/* @var $this smsCenterView */

$this->registerWidgets(array (
    'formW'      => 'form',
    'boxW'       => 'box',
    'pageTitleW' => 'pageTitle'
)) ;

echo $this->pageTitleW->renderTitle(array (
    'title' => \f\ifm::t('aboutSetting'),
     )) ;


echo $this->boxW->begin(array (
    'type'  => 'form',
    'title' =>  \f\ifm::t('aboutSetting') )) ;



$form = '' ;
$form.=$this->formW->begin(array (
    'htmlOptions' => array (
        'method' => 'post',
        'action' => \f\ifm::app()->baseUrl . 'cms/about/aboutSettingSave',
        'id'     => 'portAdd'
    ),
        )) ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->textarea ( array (
    'htmlOptions' => array (
        'name'  => 'ShortContent',
    ),
    'label' => array (
        'text'    => \f\ifm::t ( 'ShortContent' )
    ),
    'editor'  => true,
    'content' => $settings[ 'ShortContent' ]
) ) ;

$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->textarea ( array (
    'htmlOptions' => array (
        'name'  => 'content',
    ),
    'label' => array (
        'text'    => \f\ifm::t ( 'content' )
    ),
    'editor'  => true,
    'content' => $settings[ 'content' ]
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
        'text'   => \f\ifm::t ( 'picAbout' ),
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
                'path'        => 'cms.about' //chanage
            ),
            'dialogTitle' => \f\ifm::t ( "fileUpload" ),
            'ajaxParams'  => array (
                'mode'   => $settings[ 'pictureAbout' ] == '' ? '' : 'update',
                'fileId' => $settings[ 'pictureAbout' ],
                'path'   => 'cms.about'  //chanage
            )
        )
    ) ) ) ;

$form .= $this->formW->colStart () ;

$fileIdInput = \f\html::readyMarkup ( 'input', '',
    array (
        'htmlOptions' => array (
            'type'  => 'hidden',
            'name'  => 'pictureAbout',
            'id'    => 'fileId',
            'value' => $settings[ 'pictureAbout' ]
        ) ) ) ;

$profilePic = \f\html::readyMarkup ( 'img', '',
    array (
        'htmlOptions' => array (
            'src'      => \f\ifm::app ()->fileBaseUrl . $settings[ 'pictureAbout' ],
            'data-src' => \f\ifm::app ()->fileBaseUrl . $settings[ 'pictureAbout' ],
        ),
        'style'    => array (
            'position'   => 'absolute',
            'left'       => '30px',
            'top'        => "-35px",
            'max-width'  => '50px',
            'max-height' => '70px',
            'display'    => $settings[ 'pictureAbout' ] == '' ? 'none' : 'block'
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
        'type'    => 'button',
        'id'      => 'selectProfilePicBtn1',
        'class'   => 'btn btn-default'
    ),
    'content' => '<i class="fa fa-upload"></i> ' . \f\ifm::t ( 'fileSelect' ),
    'label'   => array (
        'text'   => \f\ifm::t ( 'picAbout' ),
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
            'triggerElement' => 'selectProfilePicBtn1', //chanage
            'containerId'    => '#fileContainer1',
            'urlParams'      => array (
                'path'        => 'cms.about' //chanage
            ),
            'dialogTitle' => \f\ifm::t ( "fileUpload" ),
            'ajaxParams'  => array (
                'mode'   => $settings[ 'pictureAbout1' ] == '' ? '' : 'update',
                'fileId' => $settings[ 'pictureAbout1' ],
                'path'   => 'cms.about'  //chanage
            )
        )
    ) ) ) ;

$form .= $this->formW->colStart () ;

$fileIdInput = \f\html::readyMarkup ( 'input', '',
    array (
        'htmlOptions' => array (
            'type'  => 'hidden',
            'name'  => 'pictureAbout1',
            'id'    => 'fileId',
            'value' => $settings[ 'pictureAbout1' ]
        ) ) ) ;

$profilePic = \f\html::readyMarkup ( 'img', '',
    array (
        'htmlOptions' => array (
            'src'      => \f\ifm::app ()->fileBaseUrl . $settings[ 'pictureAbout1' ],
            'data-src' => \f\ifm::app ()->fileBaseUrl . $settings[ 'pictureAbout1' ],
        ),
        'style'    => array (
            'position'   => 'absolute',
            'left'       => '30px',
            'top'        => "-35px",
            'max-width'  => '50px',
            'max-height' => '70px',
            'display'    => $settings[ 'pictureAbout1' ] == '' ? 'none' : 'block'
        )
    ) ) ;

//$profilePic .= $row[ 'profile_pic' ] == '' ? \f\ifm::t('noFileSelected') : '' ;

$form.= \f\html::readyMarkup ( 'div', $fileIdInput . $profilePic,
    array (
        'htmlOptions' => array (
            'id'        => 'fileContainer1',
            'data-type' => 'image'
        ),
        'style'     => array (
            'margin-top' => '15px'
        )
    ), true ) ;

$form .= $this->formW->colEnd () ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart() ;
$form.=$this->formW->buttonTag(array (
    'htmlOptions' => array (
        'type' => 'submit',
    ),
    'content'     => '<i class="fa fa-floppy-o"></i> ' . (\f\ifm::t('saveEdit')),
        )) ;
$form.=$this->formW->rowEnd() ;



$form.=$this->formW->flush() ;

echo $form ;

echo $this->boxW->flush() ;
?>

<script>
    $(document).ready(function () {
        widgetHelper.makeSelect2('select', '<?= \f\ifm::t ( 'select' ) ?>');
    });
    widgetHelper.formSubmit('#portAdd');
</script>