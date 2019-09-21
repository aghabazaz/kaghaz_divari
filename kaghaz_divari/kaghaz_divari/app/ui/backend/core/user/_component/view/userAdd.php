<?php
//echo $param;
$title = $row ? 'edit' : 'add' ;


$back       = $param ;
/* @var $pageWidget \f\w\pageTitle */
$pageWidget = \f\widgetFactory::make ( 'pageTitle' ) ;
echo $pageWidget->renderTitle ( array ( 'title' => \f\ifm::t ( $title ), 'links' => array (
        array ( 'title' => \f\ifm::t ( 'listUser' ), 'href'  => \f\ifm::app ()->baseUrl . 'core/user/' . $back ) ) ) ) ;

/* @var $boxWidget \f\w\box */
$boxWidget = \f\widgetFactory::make ( 'box' ) ;
echo $boxWidget->begin ( array ( 'type'  => 'form', 'title' => \f\ifm::t ( $title ) ) ) ;

/* @var $addWidget \f\w\form */
$addWidget = \f\widgetFactory::make ( 'form' ) ;


/* @var $date \f\g\date */
$date = \f\gadgetFactory::make ( 'date' ) ;

$form = '' ;
$form.=$addWidget->begin ( array (
    'htmlOptions' => array (
        'method' => 'post',
        'action' => \f\ifm::app ()->baseUrl . 'core/user/userSave',
        'id'     => 'userAdd'
    ),
        ) ) ;
$form.=$addWidget->fieldsetStart ( array (
    'legend' => array (
        'text' => \f\ifm::t ( 'userInfo' ),
    ),
        ) ) ;

$form.=$addWidget->rowStart () ;
$form.=$addWidget->input ( array (
    'htmlOptions' => array (
        'type'  => 'hidden',
        'name'  => 'id',
        'value' => $row[ 'id' ] ? $row[ 'id' ] : '',
    ),
        ) ) ;
$form.=$addWidget->rowEnd () ;

$form.=$addWidget->rowStart () ;
$form.=$addWidget->input ( array (
    'htmlOptions' => array (
        'type'  => 'hidden',
        'name'  => 'typeUser',
        'value' => $param,
    ),
        ) ) ;
$form.=$addWidget->rowEnd () ;

if ( $param == 'siteUser' || $param == 'memberUser' )
{
    $otherUser = array (
        'display' => 'none'
            ) ;
    $typeUser = 'real' ;
}
else if ( $param == 'colleagueUser' )
{
    $otherUser = array (
        'display' => 'none'
            ) ;
    $typeUser = 'legal' ;
}
else
{
    $typeUser = 'real' ;
}

$form.=$addWidget->rowStart ( $otherUser ) ;
$form.=$addWidget->radio ( array (
    'htmlOptions' => array (
        'name'    => 'personality',
        'class'   => 'info',
    ),
    'choices' => array (
        \f\ifm::t ( 'real' )  => 'real',
        \f\ifm::t ( 'legal' ) => 'legal',
    ),
    'label'               => array (
        'text'    => \f\ifm::t ( 'userType' ),
    ),
    'checked' => $row[ 'personality' ] ? $row[ 'personality' ] : $typeUser,
    'linear'  => TRUE
        ) ) ;
$form.=$addWidget->rowEnd () ;

$form.=$addWidget->rowStart () ;
$form.=$addWidget->input ( array (
    'htmlOptions' => array (
        'type'       => 'text',
        'name'       => 'username',
        'value'      => $row[ 'username' ],
    ),
    'validation' => array (
        'required' => ''
    ),
    'style'    => array (
        'direction' => 'ltr',
    ),
    'label'     => array (
        'text' => \f\ifm::t ( 'username' ),
    ),
        ) ) ;
$form.=$addWidget->rowEnd () ;
$form.=$addWidget->rowStart () ;
$form.=$addWidget->input ( array (
    'htmlOptions' => array (
        'type'       => 'password',
        'name'       => 'password',
    ),
    'validation' => array (
        'required' => $row[ 'password' ] ? 'false' : '',
    ),
    'style'    => array (
        'direction' => 'ltr',
    ),
    'label'     => array (
        'text' => \f\ifm::t ( 'password' ),
    ),
        ) ) ;
$form.=$addWidget->rowEnd () ;

$form.=$addWidget->rowStart () ;
$form.=$addWidget->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'expire_date',
        'class' => 'form-control date',
        'id'    => 'expire',
        'value' => ($row [ 'expire_date' ] !== '0000-00-00' && $row [ 'expire_date' ]) ? $date->dateGrToJa ( $row [ 'expire_date' ],
                                                                                                             1 ) : '',
    ),
    'label' => array (
        'text' => \f\ifm::t ( 'creditDate' ),
    ),
        ) ) ;
$form.=$addWidget->rowEnd () ;

$form.=$addWidget->fieldsetEnd () ;

$form.=$addWidget->newLine () ;
$form.=$addWidget->fieldsetStart ( array (
    'htmlOptions' => array (
        'id'    => 'info-legal',
        'class' => 'info-legal',
    ),
    'style' => array (
        'display' => 'none',
    ),
    'legend'  => array (
        'text' => \f\ifm::t ( 'legalInfo' ),
    ),
        ) ) ;

$form.=$addWidget->rowStart () ;
$form.=$addWidget->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'nameLegal',
        'value' => $row[ 'name' ],
    ),
    'label' => array (
        'text' => \f\ifm::t ( 'legalName' ),
    ),
        ) ) ;
$form.=$addWidget->rowEnd () ;

$form.=$addWidget->rowStart () ;
$form.=$addWidget->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'activityType',
        'value' => $row[ 'activityType' ],
    ),
    'label' => array (
        'text' => \f\ifm::t ( 'activityType' ),
    ),
        ) ) ;
$form.=$addWidget->rowEnd () ;

$form.=$addWidget->rowStart () ;
$form.=$addWidget->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'reg',
        'value' => $row[ 'reg' ],
    ),
    'label' => array (
        'text' => \f\ifm::t ( 'reg' ),
    ),
        ) ) ;
$form.=$addWidget->rowEnd () ;

$form.=$addWidget->rowStart () ;
$form.=$addWidget->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'regDate',
        'class' => 'date',
        'id'    => 'date',
        'value' => ($row [ 'regDate' ] !== '0000-00-00' && $row [ 'regDate' ]) ? $date->dateGrToJa ( $row [ 'regDate' ],
                                                                                                     1 ) : '',
    ),
    'label' => array (
        'text' => \f\ifm::t ( 'regDate' ),
    ),
        ) ) ;
$form.=$addWidget->rowEnd () ;

$form.=$addWidget->rowStart () ;
$form.=$addWidget->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'ceo',
        'value' => $row[ 'ceo' ],
    ),
    'label' => array (
        'text' => \f\ifm::t ( 'ceo' ),
    ),
        ) ) ;
$form.=$addWidget->rowEnd () ;

$form.=$addWidget->fieldsetEnd () ;

$form.=$addWidget->fieldsetStart ( array (
    'htmlOptions' => array (
        'id'    => 'info-real',
        'class' => 'info-real',
    ),
    'style' => array (
        'display' => 'none',
    ),
    'legend'  => array (
        'text' => \f\ifm::t ( 'realInfo' ),
    ),
        ) ) ;

$form.=$addWidget->rowStart () ;
$form.=$addWidget->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'nameReal',
        'value' => $row[ 'name' ],
    ),
    'label' => array (
        'text' => \f\ifm::t ( 'realName' ),
    ),
        ) ) ;
$form.=$addWidget->rowEnd () ;

$form.=$addWidget->rowStart () ;
$form.=$addWidget->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'fatherName',
        'value' => $row[ 'father_name' ],
    ),
    'label' => array (
        'text' => \f\ifm::t ( 'fatherName' ),
    ),
        ) ) ;

$form.=$addWidget->rowEnd () ;
$form.=$addWidget->rowStart () ;
$form.=$addWidget->radio ( array (
    'htmlOptions' => array (
        'name'    => 'gender',
    ),
    'choices' => array (
        \f\ifm::t ( 'male' )   => 'male',
        \f\ifm::t ( 'female' ) => 'female',
    ),
    'label'                => array (
        'text'    => \f\ifm::t ( 'gender' ),
    ),
    'checked' => $row[ 'gender' ] ? $row[ 'gender' ] : 'male',
    'linear'  => TRUE
        ) ) ;
$form.=$addWidget->rowEnd () ;

$form.=$addWidget->rowStart () ;
$form.=$addWidget->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'birthday',
        'class' => 'date',
        'id'    => 'birthday',
        'value' => ($row [ 'birthday' ] !== '0000-00-00' && $row [ 'birthday' ]) ? $date->dateGrToJa ( $row [ 'birthday' ],
                                                                                                       1 ) : '',
    ),
    'label' => array (
        'text' => \f\ifm::t ( 'birthday' ),
    ),
        ) ) ;
$form.=$addWidget->rowEnd () ;

$form.=$addWidget->fieldsetEnd () ;


$form.=$addWidget->fieldsetStart ( array (
    'legend' => array (
        'text' => \f\ifm::t ( 'profilePic' ),
    ),
        ) ) ;


$form.=$addWidget->rowStart () ;
$form.=$addWidget->buttonTag ( array (
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
                'path'        => 'userprofile' //chanage
            ),
            'dialogTitle' => \f\ifm::t ( "fileUpload" ),
            'ajaxParams'  => array (
                'mode'   => $row[ 'picture' ] == '' ? '' : 'update',
                'fileId' => $row[ 'picture' ],
                'path'   => 'userprofile'  //chanage
            )
        )
    ) ) ) ;

$form .= $addWidget->colStart () ;

$fileIdInput = \f\html::readyMarkup ( 'input', '',
                                      array (
            'htmlOptions' => array (
                'type'  => 'hidden',
                'name'  => 'profile_pic',
                'id'    => 'fileId',
                'value' => $row[ 'profile_pic' ]
            ) ) ) ;

$profilePic = \f\html::readyMarkup ( 'img', '',
                                     array (
            'htmlOptions' => array (
                'src'      => \f\ifm::app ()->fileBaseUrl . $row[ 'profile_pic' ],
                'data-src' => \f\ifm::app ()->fileBaseUrl . $row[ 'profile_pic' ],
            ),
            'style'    => array (
                'position'   => 'absolute',
                'left'       => '30px',
                'top'        => "-35px",
                'max-width'  => '50px',
                'max-height' => '70px',
                'display'    => $row[ 'profile_pic' ] == '' ? 'none' : 'block'
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

$form .= $addWidget->colEnd () ;
$form.=$addWidget->rowEnd () ;

$form .= $addWidget->fieldsetEnd () ;
$form.=$addWidget->newLine () ;
$form.=$addWidget->fieldsetStart ( array (
    'legend' => array (
        'text' => \f\ifm::t ( 'contactInfo' ),
    ),
        ) ) ;


$form.=$addWidget->rowStart () ;
$form.=$addWidget->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'phone',
        'value' => $row[ 'phone' ],
    ),
    'style' => array (
        'direction' => 'ltr',
    ),
    'label'     => array (
        'text' => \f\ifm::t ( 'phone' ),
    ),
        ) ) ;
$form.=$addWidget->rowEnd () ;
$form.=$addWidget->rowStart () ;
$form.=$addWidget->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'mobile',
        'value' => $row[ 'mobile' ],
    ),
    'style' => array (
        'direction' => 'ltr',
    ),
    'label'     => array (
        'text' => \f\ifm::t ( 'mobile' ),
    ),
        ) ) ;
$form.=$addWidget->rowEnd () ;
$form.=$addWidget->rowStart () ;
$form.=$addWidget->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'fax',
        'value' => $row[ 'fax' ],
    ),
    'style' => array (
        'direction' => 'ltr',
    ),
    'label'     => array (
        'text' => \f\ifm::t ( 'fax' ),
    ),
        ) ) ;
$form.=$addWidget->rowEnd () ;
$form.=$addWidget->rowStart () ;
$form.=$addWidget->input ( array (
    'htmlOptions' => array (
        'type'       => 'text',
        'name'       => 'email',
        'value'      => $row[ 'email' ],
    ),
    'validation' => array
        (
        'type'  => 'email'
    ),
    'style' => array (
        'direction' => 'ltr',
    ),
    'label'     => array (
        'text' => \f\ifm::t ( 'email' ),
    ),
        ) ) ;
$form.=$addWidget->rowEnd () ;
$form.=$addWidget->rowStart () ;
$form.=$addWidget->input ( array (
    'htmlOptions' => array (
        'type'       => 'text',
        'name'       => 'website',
        'value'      => $row[ 'website' ],
    ),
    'validation' => array
        (
        'type'  => 'url',
    ),
    'style' => array (
        'direction' => 'ltr',
    ),
    'label'     => array (
        'text' => \f\ifm::t ( 'website' ),
    ),
        ) ) ;
$form.=$addWidget->rowEnd () ;
$form.=$addWidget->rowStart () ;
$form.=$addWidget->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'postal_code',
        'value' => $row[ 'postal_code' ],
    ),
    'style' => array (
        'direction' => 'ltr',
    ),
    'label'     => array (
        'text' => \f\ifm::t ( 'postal_code' ),
    ),
        ) ) ;
$form.=$addWidget->rowEnd () ;

$form.=$addWidget->rowStart () ;
$form.=$addWidget->select ( array (
    'htmlOptions' => array (
        'id'       => 'country',
        'name'     => 'country_id',
        'onchange' => "get_city('country');",
    ),
    'label'    => array (
        'text'     => \f\ifm::t ( 'country' ),
    ),
    'choices'  => $country,
    'selected' => $row[ 'country_id' ] ? $row[ 'country_id' ] : 'IR',
        ) ) ;
$form.=$addWidget->rowEnd () ;

$form.=$addWidget->rowStart () ;
$form.=$addWidget->select ( array (
    'htmlOptions' => array (
        'name'  => 'city_id',
        'id'    => 'city',
    ),
    'label' => array (
        'text'    => \f\ifm::t ( 'city' ),
    ),
    'choices' => array (
    ),
    'selected' => $row[ 'city_id' ] ? $row[ 'city_id' ] : '',
        ) ) ;
$form.=$addWidget->rowEnd () ;

$form.=$addWidget->rowStart () ;
$form.=$addWidget->textarea ( array (
    'htmlOptions' => array (
        'name'  => 'address',
        'id'    => 'address',
    ),
    'style' => array (
        'height' => '100px',
    ),
    'label'  => array (
        'text'    => \f\ifm::t ( 'address' ),
    ),
    'content' => $row[ 'address' ],
        )
        ) ;
$form.=$addWidget->rowEnd () ;
$form.=$addWidget->fieldsetEnd () ;

$form.=$addWidget->newLine () ;
$form.=$addWidget->fieldsetStart ( array (
    'htmlOptions' => array (
        'id'     => 'info-real',
        'class'  => 'info-real',
    ),
    'legend' => array (
        'text' => \f\ifm::t ( 'jobInfo' ),
    ),
        ) ) ;

$form.=$addWidget->rowStart () ;
$form.=$addWidget->select ( array (
    'htmlOptions' => array (
        'id'    => 'job',
        'name'  => 'job_group',
    ),
    'label' => array (
        'text'     => \f\ifm::t ( 'jobGroup' ),
    ),
    'choices'  => $job,
    'selected' => $row[ 'job_group' ] ? $row[ 'job_group' ] : '',
        ) ) ;
$form.=$addWidget->rowEnd () ;

$form.=$addWidget->rowStart () ;
$form.=$addWidget->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'job',
        'value' => $row[ 'job' ],
    ),
    'style' => array (
    ),
    'label' => array (
        'text' => \f\ifm::t ( 'job' ),
    ),
        ) ) ;
$form.=$addWidget->rowEnd () ;

$form.=$addWidget->rowStart () ;
$form.=$addWidget->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'company',
        'value' => $row[ 'company' ],
    ),
    'style' => array (
    ),
    'label' => array (
        'text' => \f\ifm::t ( 'company' ),
    ),
        ) ) ;
$form.=$addWidget->rowEnd () ;

$form.=$addWidget->fieldsetEnd () ;
$form.=$addWidget->newLine () ;

$form.=$addWidget->fieldsetStart ( array (
    'htmlOptions' => array (
        'id'     => 'info-real',
        'class'  => 'info-real',
    ),
    'legend' => array (
        'text' => \f\ifm::t ( 'educationInfo' ),
    ),
        ) ) ;

$form.=$addWidget->rowStart () ;
$form.=$addWidget->select ( array (
    'htmlOptions' => array (
        'name'  => 'degree',
    ),
    'style' => array (
    ),
    'label' => array (
        'text'    => \f\ifm::t ( 'degree' ),
    ),
    'choices' => array (
        'diplomas'        => \f\ifm::t ( 'diplomas' ),
        'advanceddiploma' => \f\ifm::t ( 'advanceddiploma' ),
        'license'         => \f\ifm::t ( 'license' ),
        'masters'         => \f\ifm::t ( 'masters' ),
        'phd'             => \f\ifm::t ( 'phd' )
    ),
    'selected'        => $row[ 'degree' ] ? $row[ 'degree' ] : '',
        ) ) ;
$form.=$addWidget->rowEnd () ;

$form.=$addWidget->rowStart () ;
$form.=$addWidget->input ( array (
    'htmlOptions' => array (
        'type'  => 'text',
        'name'  => 'study',
        'value' => $row[ 'study' ],
    ),
    'style' => array (
    ),
    'label' => array (
        'text' => \f\ifm::t ( 'study' ),
    ),
        ) ) ;
$form.=$addWidget->rowEnd () ;

$form.=$addWidget->fieldsetEnd () ;
$form.=$addWidget->newLine () ;


$form.=$addWidget->rowStart () ;
$form.=$addWidget->button ( array (
    'htmlOptions' => array (
        'type'    => 'submit',
    ),
    'content' => $row ? \f\ifm::t ( 'saveEdit' ) : \f\ifm::t ( 'saveNew' ),
        ) ) ;
$form.=$addWidget->rowEnd () ;

$form.=$addWidget->flush () ;

echo $form ;

echo $boxWidget->flush () ;
?>

<script>
    $(document).ready(function () {

        //----------------------------------------------------------------------
        get_city('country');
        //----------------------------------------------------------------------
        var inp = '';
        $('.info').on('click', function () {
            inp = $(this).val();

            $('.info').each(function () {
                if ($(this).val() !== inp) {
                    $('.info-' + $(this).val()).slideUp('slow', function () {
                        $('.info-' + inp).slideDown('slow');
                    });
                }
            });

        });

        $('.info').each(function () {
            if ($(this).is(':checked')) {
                inp = $(this).val();

                $('.info').each(function () {
                    if ($(this).val() !== inp) {
                        $('.info-' + $(this).val()).slideUp('slow', function () {
                            $('.info-' + inp).slideDown('slow');
                        });
                    }
                });
            }
        });
        //----------------------------------------------------------------------
        $('.date').each(function () {
            if ($(this).attr('id') !== 'expire') {
                var selector = "#" + $(this).attr('id');
                var lang = 'fa';
                var newOption = {
                    minDate: '',
                    changeMonth: true,
                    changeYear: true,
                    yearRange: "-100:+0",
                }
                var newOptionTo = {}
                widgetHelper.makeDatePicker(selector, lang, newOption, newOptionTo);
            }
        });
        //expire date
        var newOption2 = {
            minDate: '',
            changeMonth: true,
            changeYear: true,
            yearRange: "-0:+100",
        }
        widgetHelper.makeDatePicker('#expire', 'fa', newOption2);
        //----------------------------------------------------------------------
    });
    $(document).ready(function () {
        widgetHelper.makeSelect2('select', '<?= \f\ifm::t ( 'select' ) ?>');
    });
    //--------------------------------------------------------------------------
    function get_city(id) {
        var code = $('#' + id).val();
        var base_url = '<?= \f\ifm::app ()->baseUrl ?>core/user/cityList';
        var numblock = parseInt($('#numblock').val()) + 1;

        $.ajax(
        {
            url: base_url,
            type: "POST",
            //dataType: "json",
            data:
                {country: code},
            success: function (data) {
                var obj = $.parseJSON(data);
                var option = '';
                $.each(obj, function (key, value) {
                    if (key == '<?= $row[ 'city_id' ] ?>') {
                        $('#s2id_city .select2-chosen').html(value);
                        var selected = 'selected';
                    } else {
                        var selected = '';
                    }
                    option = option + '<option value="' + key + '" ' + selected + '>' + value + '</option>';
                });
                $('#city').html(option);

            }
        });

    }
    //--------------------------------------------------------------------------
    widgetHelper.formSubmit('#userAdd');



</script>
