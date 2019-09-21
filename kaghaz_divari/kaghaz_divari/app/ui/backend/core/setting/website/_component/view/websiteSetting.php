<?php
/* @var $this websiteCenterView */

$this->registerWidgets(array (
    'formW'      => 'form',
    'boxW'       => 'box',
    'pageTitleW' => 'pageTitle'
)) ;

echo $this->pageTitleW->renderTitle(array (
    'title' => \f\ifm::t('websiteSetting'),
     )) ;


echo $this->boxW->begin(array (
    'type'  => 'form',
    'title' =>  \f\ifm::t('websiteSetting') )) ;



$form = '' ;
$form.=$this->formW->begin(array (
    'htmlOptions' => array (
        'method' => 'post',
        'action' => \f\ifm::app()->baseUrl . 'core/setting/website/websiteSettingSave',
        'id'     => 'portAdd'
    ),
        )) ;

$form.=$this->formW->input(array (
    'htmlOptions' => array (
        'type'  => 'hidden',
        'name'  => 'id',
        'value' => $settings[ 'id' ],
        
    ),
    
    
        )) ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->radio ( array (
    'htmlOptions' => array (
        'name'    => 'construction',
        
    ),
    'choices' => array (
        \f\ifm::t ( 'online' )  => 'online',
        \f\ifm::t ( 'offline' ) => 'offline',
    ),
    'label'               => array (
        'text'    => \f\ifm::t ( 'status' ),
    ),
    'checked' => $settings[ 'construction' ] ? $settings[ 'construction' ] : 'online',
    'linear'  => TRUE
        ) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->radio ( array (
    'htmlOptions' => array (
        'name'    => 'mobileTemplate',
        
    ),
    'choices' => array (
        \f\ifm::t ( 'enabled' )  => 'enabled',
        \f\ifm::t ( 'disabled' ) => 'disabled',
    ),
    'label'               => array (
        'text'    => \f\ifm::t ( 'mobileTemplate' ),
    ),
    'checked' => $settings[ 'mobileTemplate' ] ? $settings[ 'mobileTemplate' ] : 'disabled',
    'linear'  => TRUE
        ) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart() ;
$form.=$this->formW->input(array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'title',
        'value' => $settings[ 'title' ],
        
    ),
    'validation'  => array (
        'required' => ''
    ),
    'label'       => array (
        'text' => \f\ifm::t('title'),
    ),
        )) ;
$form.=$this->formW->rowEnd() ;

$form.=$this->formW->rowStart() ;
$form.=$this->formW->input(array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'keywords',
        'value' => $settings[ 'keywords' ],
        'placeholder'=>\f\ifm::t('keywordCm')
    ),
    
    'label'       => array (
        'text' => \f\ifm::t('keyword'),
    ),
        )) ;
$form.=$this->formW->rowEnd() ;

$form.=$this->formW->rowStart() ;
$form.=$this->formW->textarea(array (
    'htmlOptions' => array (
      
        'name'  => 'description',
      
    ),
    
    'label'       => array (
        'text' => \f\ifm::t('description'),
    ),
    'content'       => $settings[ 'description' ]
    
        )) ;
$form.=$this->formW->rowEnd() ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->buttonTag ( array (
    'htmlOptions' => array (
        'type'    => 'button',
        'id'      => 'selectLogoPicBtn',
        'class'   => 'btn btn-default'
    ),
    'content' => '<i class="fa fa-upload"></i> ' . \f\ifm::t ( 'fileSelect' ),
    'label'   => array (
        'text'   => \f\ifm::t ( 'picMainLogo' ),
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
            'triggerElement' => 'selectLogoPicBtn', //chanage
            'containerId'    => '#fileContainer1',
            'urlParams'      => array (
                'path'        => 'website.logo' //chanage
            ),
            'dialogTitle' => \f\ifm::t ( "fileUpload" ),
            'ajaxParams'  => array (
                'mode'   => $settings[ 'logo' ] == '' ? '' : 'update',
                'fileId' => $settings[ 'logo' ],
                'path'   => 'website.logo'  //chanage
            )
        )
    ) ) ) ;

$form .= $this->formW->colStart () ;

$fileIdInput2 = \f\html::readyMarkup ( 'input', '',
                                      array (
            'htmlOptions' => array (
                'type'  => 'hidden',
                'name'  => 'logo',
                'id'    => 'fileId',
                'value' => $settings[ 'logo' ]
            ) ) ) ;

$profilePic2 = \f\html::readyMarkup ( 'img', '',
                                     array (
            'htmlOptions' => array (
                'src'      => \f\ifm::app ()->fileBaseUrl . $settings[ 'logo' ],
                'data-src' => \f\ifm::app ()->fileBaseUrl . $settings[ 'logo' ],
            ),
            'style'    => array (
                'position'   => 'absolute',
                'left'       => '30px',
                'top'        => "-35px",
                'max-width'  => '50px',
                'max-height' => '70px',
                'display'    => $settings[ 'logo' ] == '' ? 'none' : 'block'
            )
        ) ) ;

//$profilePic .= $row[ 'profile_pic' ] == '' ? \f\ifm::t('noFileSelected') : '' ;

$form.= \f\html::readyMarkup ( 'div', $fileIdInput2 . $profilePic2,
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

$form.=$this->formW->rowStart () ;
$form.=$this->formW->buttonTag ( array (
    'htmlOptions' => array (
        'type'    => 'button',
        'id'      => 'selectLogoFooterPicBtn',
        'class'   => 'btn btn-default'
    ),
    'content' => '<i class="fa fa-upload"></i> ' . \f\ifm::t ( 'fileSelect' ),
    'label'   => array (
        'text'   => \f\ifm::t ( 'logo_footer' ),
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
                'path'        => 'website.logo' //chanage
            ),
            'dialogTitle' => \f\ifm::t ( "fileUpload" ),
            'ajaxParams'  => array (
                'mode'   => $settings[ 'logo_footer' ] == '' ? '' : 'update',
                'fileId' => $settings[ 'logo_footer' ],
                'path'   => 'website.logo'  //chanage
            )
        )
    ) ) ) ;

$form .= $this->formW->colStart () ;

$fileIdInput = \f\html::readyMarkup ( 'input', '',
                                      array (
            'htmlOptions' => array (
                'type'  => 'hidden',
                'name'  => 'logo_footer',
                'id'    => 'fileId',
                'value' => $settings[ 'logo_footer' ]
            ) ) ) ;

$profilePic = \f\html::readyMarkup ( 'img', '',
                                     array (
            'htmlOptions' => array (
                'src'      => \f\ifm::app ()->fileBaseUrl . $settings[ 'logo_footer' ],
                'data-src' => \f\ifm::app ()->fileBaseUrl . $settings[ 'logo_footer' ],
            ),
            'style'    => array (
                'position'   => 'absolute',
                'left'       => '30px',
                'top'        => "-35px",
                'max-width'  => '50px',
                'max-height' => '70px',
                'display'    => $settings[ 'logo_footer' ] == '' ? 'none' : 'block'
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

$form.=$this->formW->rowStart () ;
$form.=$this->formW->buttonTag ( array (
    'htmlOptions' => array (
        'type'    => 'button',
        'id'      => 'selectIconPicBtn',
        'class'   => 'btn btn-default'
    ),
    'content' => '<i class="fa fa-upload"></i> ' . \f\ifm::t ( 'fileSelect' ),
    'label'   => array (
        'text'   => \f\ifm::t ( 'picIcon' ),
    ),
    'action' => array (
        'preServerSideAction' => array (
            'route'   => 'core.fileManager.registerUploadSession',
            'options' => array ( //change
                'multiUpload' => 10,
                'extensions'  => '.jpg, .png, .bmp, .jpeg,.ico',
                'tasks'       => array ( 'upload', 'select' )
            ),
        ),
        'display' => 'dialog',
        'params'  => array (
            'targetRoute'    => "core.fileManager.getUploadForm",
            'triggerElement' => 'selectIconPicBtn', //chanage
            'containerId'    => '#fileContainer3',
            'urlParams'      => array (
                'path'        => 'website.icon' //chanage
            ),
            'dialogTitle' => \f\ifm::t ( "fileUpload" ),
            'ajaxParams'  => array (
                'mode'   => $settings[ 'favicon' ] == '' ? '' : 'update',
                'fileId' => $settings[ 'favicon' ],
                'path'   => 'website.icon'  //chanage
            )
        )
    ) ) ) ;

$form .= $this->formW->colStart () ;

$fileIdInput3 = \f\html::readyMarkup ( 'input', '',
                                      array (
            'htmlOptions' => array (
                'type'  => 'hidden',
                'name'  => 'favicon',
                'id'    => 'fileId',
                'value' => $settings[ 'favicon' ]
            ) ) ) ;

$profilePic3 = \f\html::readyMarkup ( 'img', '',
                                     array (
            'htmlOptions' => array (
                'src'      => \f\ifm::app ()->fileBaseUrl . $settings[ 'favicon' ],
                'data-src' => \f\ifm::app ()->fileBaseUrl . $settings[ 'favicon' ],
            ),
            'style'    => array (
                'position'   => 'absolute',
                'left'       => '30px',
                'top'        => "-35px",
                'max-width'  => '50px',
                'max-height' => '70px',
                'display'    => $settings[ 'favicon' ] == '' ? 'none' : 'block'
            )
        ) ) ;

//$profilePic .= $row[ 'profile_pic' ] == '' ? \f\ifm::t('noFileSelected') : '' ;

$form.= \f\html::readyMarkup ( 'div', $fileIdInput3 . $profilePic3,
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

$form.=$this->formW->rowStart() ;
$form.=$this->formW->buttonTag(array (
    'htmlOptions' => array (
        'type' => 'submit',
    ),
    'content'     => '<i class="fa fa-floppy-o"></i> ' . (\f\ifm::t('saveEditSetting')),
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