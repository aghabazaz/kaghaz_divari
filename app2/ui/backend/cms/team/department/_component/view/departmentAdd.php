<?php
$title = $row ? 'editdepartment' : 'adddepartment' ;
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
            'title' => \f\ifm::t ( 'listdepartment' ),
            'href'  => \f\ifm::app ()->baseUrl . 'cms/team/department/index' ) ) ) ) ;


echo $this->boxW->begin ( array (
    'type'  => 'form',
    'title' => \f\ifm::t ( $title ) ) ) ;



$form = '' ;
$form.=$this->formW->begin ( array (
    'htmlOptions' => array (
        'method' => 'post',
        'action' => \f\ifm::app ()->baseUrl . 'cms/team/department/departmentSave',
        'id'     => 'departmentAdd'
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
        'name'  => 'title',
        'value' => $row[ 'title' ],
    ),
    'validation'  => array (
        'required' => ''
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'title' ),
    ),
        ) ) ;
$form.=$this->formW->rowEnd () ;



$form.=$this->formW->select ( array (
    'htmlOptions' => array (
        'id'    => 'parent_id',
        'name'  => 'parent_id',
        'class' => 'parent_id'
    ),
    'label'       => array (
        'text' => \f\ifm::t ( 'parent' )
    ),
    'choices'     => $sort,
    'selected'    => $row[ 'parent_id' ] ? $row[ 'parent_id' ] : ''
        ) ) ;

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
                'path' => 'cms.team.department' //chanage
            ),
            'dialogTitle'    => \f\ifm::t ( "fileUpload" ),
            'ajaxParams'     => array (
                'mode'   => $row[ 'picture' ] == '' ? '' : 'update',
                'fileId' => $row[ 'picture' ],
                'path'   => 'cms.team.department'  //chanage
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
    widgetHelper.formSubmit('#departmentAdd');

    jQuery(document).ready(function ()
    {
        $(".bodyParam").sortable();
        $("#addParam").click(function () {
            $('select').select2('destroy');
            var row = $(".paramRow:first").clone();
            $(".bodyParam").append(row);

            widgetHelper.makeSelect2('select', '<?= \f\ifm::t ( 'select' ) ?>');

            $(".paramRow:last").find("select").each(function ()
            {
                $(this).select2('val', 'All');

            });
            $('.paramRow:last a.removeParam').on('click', function ()
            {
                var rowCount = $('.paramRow').length;
                if (rowCount > 1)
                {
                    $(this).closest('.paramRow').remove();
                } else
                {
                    alert('وارد کردن حداقل یک سطر برای مشخصات فنی الزامی است.');
                }
                return false;
            });
        });
        $('a.removeParam').on('click', function () {
            var rowCount = $('.paramRow').length;
            if (rowCount > 1)
            {
                $(this).closest('.paramRow').remove();
            } else
            {
                alert('وارد کردن حداقل یک سطر برای مشخصات فنی الزامی است.');
            }
            return false;
        });

    });
</script>