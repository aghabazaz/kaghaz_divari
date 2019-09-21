<?php
/* @var $this fileManagerView */

$this->registerWidgets(array ( 'formW' => 'form' )) ;

echo $this->formW->begin(array (
    'htmlOptions' => array (
        'id'     => 'uploadForm',
        'method' => 'post',
        'action' => \f\ifm::app()->baseUrl . "core/fileManager/submit",
    ),
)) ;

echo $this->formW->fieldsetStart(array (
    'legend' => array (
        'text' => \f\ifm::t('uploadNewFile'),
    ),
)) ;
echo \f\html::readyMarkup('input', '',
                          array (
    'htmlOptions' => array (
        'type'  => 'hidden',
        'name'  => 'uploadKey',
        'value' => $uploadKey
    )
)) ;
echo \f\html::readyMarkup('input', '',
                          array (
    'htmlOptions' => array (
        'type'  => 'hidden',
        'name'  => 'customField',
        'value' => $customField
    )
)) ;
echo \f\html::readyMarkup('input', '',
                          array (
    'htmlOptions' => array (
        'type'  => 'hidden',
        'name'  => 'path',
        'value' => $path
    )
)) ;


echo \f\html::readyMarkup('input', '',
                          array (
    'htmlOptions' => array (
        'type'  => 'hidden',
        'name'  => 'mode',
        'value' => $mode
    )
)) ;
echo \f\html::readyMarkup('input', '',
                          array (
    'htmlOptions' => array (
        'type'  => 'hidden',
        'name'  => 'replace',
        'value' => $replace
    )
)) ;
echo \f\html::readyMarkup('input', '',
                          array (
    'htmlOptions' => array (
        'type'  => 'hidden',
        'name'  => 'fileId',
        'value' => $fileId
    )
)) ;

echo \f\html::readyMarkup('input', '',
                          array (
    'htmlOptions' => array (
        'type'  => 'hidden',
        'name'  => 'watermark',
        'value' => $watermark
    )
)) ;
echo \f\html::readyMarkup('input', '',
                          array (
    'htmlOptions' => array (
        'type'  => 'hidden',
        'name'  => 'func',
        'value' => $func
    )
)) ;

if ( isset($params) )
{
    foreach ( $params as $key => $value )
    {
        echo \f\html::readyMarkup('input', '',
                                  array (
            'htmlOptions' => array (
                'type'  => 'hidden',
                'name'  => "params[$key]",
                'value' => $value
            )
        )) ;
    }
}

echo \f\html::readyMarkup('input', '',
                          array (
    'htmlOptions' => array (
        'type'  => 'hidden',
        'id'    => 'fileContainer',
        'value' => '#fileContainer'
    )
)) ;

//if ( $mode !== 'update' )
//{
    echo $this->formW->input(array (
        'htmlOptions' => array (
            'type' => 'text',
            'name' => 'title'
        ),
        'block'       => array (),
        'label'       => array (
            'text'  => \f\ifm::t('title'),
            'block' => array ()
        )
    )) ;
//}

$htmlOptions = array (
    'name' => 'file[]',
    'type' => 'file',
    'id'   => 'file'
        ) ;

if ( $limitParams[ 'extensions' ] )
{
    $htmlOptions[ 'accept' ] = $limitParams[ 'extensions' ] ;
}

if ( isset($limitParams[ 'multiUpload' ]) && $limitParams[ 'multiUpload' ] > 1 )
{
    $htmlOptions[ 'multiple' ] = '' ;
}


echo $this->formW->input(array (
    'htmlOptions' => $htmlOptions,
    'style'       => array (

    ),
    'block'       => array (),
    'label'       => array (
        'text'  => \f\ifm::t('selectFile'),
        'block' => array ()
    )
)) ;

echo '<hr>' ;

echo $this->formW->button(array (
    'htmlOptions' => array (
        'type' => 'submit'
    ),
    'block'       => array (),
    'content'     => \f\ifm::t('upload')
)) ;
echo $this->formW->flush() ;
?>

<script>
    function refreshImage(params)
    {
        mode = params.mode;

        if (params.mode === "") {
            mode = 'new';
        }

        containerSelector = fileManagerContainerId;// $('#uploadForm ' + fileManagerContainerId).val();
        switch (mode) {
            case 'update':
                if ($(containerSelector).attr('data-type') !== 'image')
                {
                    return false;
                }
                imageSelector = containerSelector + " img";
                d = new Date();

                imageSrcUrl = "<?= \f\ifm::app()->fileBaseUrl ?>" + params.fileId;

                $(imageSelector).attr('src', imageSrcUrl + '/' + d.getTime());
                $(containerSelector + " #fileId").val(params.fileId);
                setTimeout(function () {
                    window['closeFileDialog' + runningFuncRandName]();
                }, 3100);
                break;

            case 'new':
                if (containerSelector !== '') {
                    imageSelector = containerSelector + " img";
                    $(containerSelector).css('display', 'block');
                    firstFileUrl = "<?= \f\ifm::app()->fileBaseUrl ?>" + params.fileId[0];
                    $(containerSelector + " #fileId").val(params.fileId);
                    $(imageSelector).fadeOut(600);
                    setTimeout(function () {
                        $(imageSelector).attr('src', firstFileUrl);
                    }, 600);
                    $(imageSelector).fadeIn(200);
                    
                    
                }
                setTimeout(function () {
                    window['closeFileDialog' + runningFuncRandName]();
                }, 100);

                break;

            case 'select':
                //alert('ok');
                if (containerSelector !== '') {

                    imageSelector = containerSelector + " img";
                    $(containerSelector + " #fileId").val(params.fileId);
                    $(imageSelector).fadeOut(600);
                    setTimeout(function () {
                        $(imageSelector).attr('src', params.fileUrl);
                    }, 600);
                    $(imageSelector).fadeIn(200);
                }
                setTimeout(function () {
                    window['closeFileDialog' + runningFuncRandName]();
                }, 200);
                break;
        }

    }
    $(document).ready(function ()
    {
        widgetHelper.formSubmit('#uploadForm');

        $("#uploadForm input[type=submit]").click(function (e) {
            if ($('#file').val() === '')
            {
                e.preventDefault();
                widgetHelper.errorDialog("<?= \f\ifm::t('Please Select file[s] first!') ; ?>");
            }
        });

        $('.fileItem').click(function () {
            refreshImage({
                mode: 'select',
                fileUrl: $(this).children('img').attr('src'),
                fileId: $(this).attr('data-id')
            });
        });
    });
</script>