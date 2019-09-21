<?php
$title = $row ? 'editCustomProductRequest' : 'addCustomProductRequest' ;
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
            'title' => \f\ifm::t ( 'listCustomProductRequest' ),
            'href'  => \f\ifm::app ()->baseUrl . 'shop/customProductRequest/index' ) ) ) ) ;


echo $this->boxW->begin ( array (
    'type'  => 'form',
    'title' => \f\ifm::t ( $title ).' - '.$row['date_register'] ) ) ;



$form = '' ;
$form.=$this->formW->begin ( array (
    'htmlOptions' => array (
        'method' => 'post',
        'action' => \f\ifm::app ()->baseUrl . 'shop/customProductRequest/customProductRequestSave',
        'id'     => 'customProductRequestAdd'
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
        'name'       => 'name_family',
        'value'      => $row[ 'name_family' ],
    ),
    'validation' => array (
        'required' => ''
    ),
    'label'    => array (
        'text' => \f\ifm::t ( 'name_family' ),
    ),
        ) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'       => 'text',
        'name'       => 'call_number',
        'value'      => $row[ 'call_number' ],
    ),
    'validation' => array (
        'required' => ''
    ),
    'label'    => array (
        'text' => \f\ifm::t ( 'call_number' ),
    ),
) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'       => 'text',
        'name'       => 'email',
        'value'      => $row[ 'email' ],
    ),
    'validation' => array (
        'required' => ''
    ),
    'label'    => array (
        'text' => \f\ifm::t ( 'email' ),
    ),
) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'       => 'text',
        'name'       => 'width',
        'value'      => $row[ 'width' ],
    ),
    'validation' => array (
        'required' => ''
    ),
    'label'    => array (
        'text' => \f\ifm::t ( 'width' ),
    ),
) ) ;
$form.=$this->formW->rowEnd () ;

$form.=$this->formW->rowStart () ;
$form.=$this->formW->input ( array (
    'htmlOptions' => array (
        'type'       => 'text',
        'name'       => 'height',
        'value'      => $row[ 'height' ],
    ),
    'validation' => array (
        'required' => ''
    ),
    'label'    => array (
        'text' => \f\ifm::t ( 'height' ),
    ),
) ) ;
$form.=$this->formW->rowEnd () ;

//\f\pre($row);
$form.=$this->formW->rowStart () ;
$form.=$this->formW->buttonTag ( array (
    'htmlOptions' => array (
        'type'    => 'button',
        'id'      => 'selectProfilePicBtn',
        'class'   => 'btn btn-default'
    ),
    'content' => '<i class="fa fa-upload"></i> ' . \f\ifm::t ( 'fileSelect' ),
    'label'   => array (
        'text'   => \f\ifm::t ( 'pic' ),
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
                'path'        => 'shop.customRequest' //chanage
            ),
            'dialogTitle' => \f\ifm::t ( "fileUpload" ),
            'ajaxParams'  => array (
                'mode'   => $row[ 'pic' ] == '' ? '' : 'update',
                'fileId' => $row[ 'pic' ],
                'path'   => 'shop.customRequest'  //chanage
            )
        )
    ) ) ) ;

$form .= $this->formW->colStart () ;

$fileIdInput = \f\html::readyMarkup ( 'input', '',
    array (
        'htmlOptions' => array (
            'type'  => 'hidden',
            'name'  => 'pic',
            'id'    => 'fileId',
            'value' => $row[ 'pic' ]
        ) ) ) ;

$profilePic = \f\html::readyMarkup ( 'img', '',
    array (
        'htmlOptions' => array (
            'src'      => \f\ifm::app ()->fileBaseUrl . $row[ 'pic' ],
            'data-src' => \f\ifm::app ()->fileBaseUrl . $row[ 'pic' ],
        ),
        'style'    => array (
            'position'   => 'absolute',
            'left'       => '30px',
            'top'        => "-35px",
            'max-width'  => '50px',
            'max-height' => '70px',
            'display'    => $row[ 'pic' ] == '' ? 'none' : 'block'
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
    widgetHelper.formSubmit('#customProductRequestAdd');
   
</script>

<? ?>