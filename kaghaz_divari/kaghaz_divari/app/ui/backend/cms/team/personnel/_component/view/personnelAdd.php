<?php
//echo $param;
$title = $row ? 'editPersonnel' : 'addPersonnel' ;
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
            'title' => \f\ifm::t ( 'listPersonnel' ),
            'href'  => \f\ifm::app ()->baseUrl . 'cms/team/personnel/index' ) ) ) ) ;


echo $this->boxW->begin ( array (
    'type'  => 'form',
    'title' => \f\ifm::t ( $title ) ) ) ;



$form = '' ;
$form.=$this->formW->begin ( array (
    'htmlOptions' => array (
        'method' => 'post',
        'action' => \f\ifm::app ()->baseUrl . 'cms/team/personnel/personnelSave',
        'id'     => 'personnelAdd'
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
        'type'  => 'text',
        'name'  => 'name',
        'value' => $row[ 'name' ],
    ),
    'validation'  => array (
        'required' => ''
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'titlePersonnel' ),
    ),
        ) ) ;
$form.=$this->formW->rowEnd () ;
$form.=$this->formW->rowStart () ;

$form.=$this->formW->select ( array (
    'htmlOptions' => array (
        'name' => 'department_id',
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'section' )
    ),
    'choices'     => $category,
    'selected'    => $row[ 'department_id' ] ? $row[ 'department_id' ] : ''
        ) ) ;
$form.=$this->formW->rowEnd () ;
$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'job',
        'value' => $row[ 'job' ],
    ),
    'validation'  => array (
        'required' => ''
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'job' ),
    ),
        ) ) ;
$form.=$this->formW->rowEnd () ;
$form.=$this->formW->rowStart () ;
$form.=$this->formW->textarea ( array (
    'htmlOptions' => array (
        'name' => 'content',
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'personnel2' )
    ),
    'editor'      => true,
    'content'     => $row[ 'content' ]
        ) ) ;

$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->buttonTag ( array (
    'htmlOptions' => array (
        'type'  => 'button',
        'id'    => 'selectProfilePicBtn',
        'class' => 'btn btn-default'
    ),
    'content'     => '<i class="fa fa-upload"></i> ' . \f\ifm::t ( 'fileSelect' ),
    'label'       => array (
        'text' => \f\ifm::t ( 'picContent' ),
    ),
    'action'      => array (
        'preServerSideAction' => array (
            'route'   => 'core.fileManager.registerUploadSession',
            'options' => array (
                //change
                'multiUpload' => 10,
                'extensions'  => '.jpg, .png, .bmp, .jpeg',
                'tasks'       => array (
                    'upload',
                    'select' )
            ),
        ),
        'display'             => 'dialog',
        'params'              => array (
            'targetRoute'    => "core.fileManager.getUploadForm",
            'triggerElement' => 'selectProfilePicBtn', //chanage
            'containerId'    => '#fileContainer',
            'urlParams'      => array (
                'path' => 'cms.team.personnel' //chanage
            ),
            'dialogTitle'    => \f\ifm::t ( "fileUpload" ),
            'ajaxParams'     => array (
                'mode'   => $row[ 'picture' ] == '' ? '' : 'update',
                'fileId' => $row[ 'picture' ],
                'path'   => 'cms.team.personnel'  //chanage
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
            'style'       => array (
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
            'style'       => array (
                'margin-top' => '15px'
            )
                ), true ) ;

$form .= $this->formW->colEnd () ;
$form.=$this->formW->rowEnd () ;


$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'phone',
        'value' => $row[ 'phone' ],
    ),
//    'validation'  => array (
//        'required' => ''
//    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'phone' ),
    ),
    'style'       => array (
        'direction' => 'ltr'
    )
        ) ) ;
$form.=$this->formW->rowEnd () ;
$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'mobile',
        'value' => $row[ 'mobile' ],
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'mobile' ),
    ),
    'style'       => array (
        'direction' => 'ltr'
    )
        ) ) ;
$form.=$this->formW->rowEnd () ;
$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'website',
        'value' => $row[ 'website' ],
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'website' ),
    ),
    'style'       => array (
        'direction' => 'ltr'
    )
        ) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'email',
        'value' => $row[ 'email' ],
    ),
//    'validation'  => array (
//        'required' => ''
//    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'email' ),
    ),
    'style'       => array (
        'direction' => 'ltr'
    )
        ) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'twitter',
        'value' => $row[ 'twitter' ],
    ),
//    'validation'  => array (
//        'required' => ''
//    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'twitter' ),
    ),
    'style'       => array (
        'direction' => 'ltr'
    )
        ) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'facebook',
        'value' => $row[ 'facebook' ],
    // 'placeholder'=>\f\ifm::t('keywordCm')
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'Facebook' ),
    ),
    'style'       => array (
        'direction' => 'ltr'
    )
        ) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'google',
        'value' => $row[ 'google' ],
    // 'placeholder'=>\f\ifm::t('keywordCm')
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'Google' ),
    ),
    'style'       => array (
        'direction' => 'ltr'
    )
        ) ) ;
$form.=$this->formW->rowEnd () ;
$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'instagram',
        'value' => $row[ 'instagram' ],
    // 'placeholder'=>\f\ifm::t('keywordCm')
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'Instagram' ),
    ),
    'style'       => array (
        'direction' => 'ltr'
    )
        ) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'telegram',
        'value' => $row[ 'telegram' ],
    // 'placeholder'=>\f\ifm::t('keywordCm')
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'Telegram' ),
    ),
    'style'       => array (
        'direction' => 'ltr'
    )
        ) ) ;
$form.=$this->formW->rowEnd () ;
$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'linkedin',
        'value' => $row[ 'linkedin' ],
    // 'placeholder'=>\f\ifm::t('keywordCm')
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'LinkedIn' ),
    ),
    'style'       => array (
        'direction' => 'ltr'
    )
        ) ) ;
$form.=$this->formW->rowEnd () ;





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
    widgetHelper.formSubmit('#personnelAdd');

</script>

