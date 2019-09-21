<style>
    #pathChainBreadcrumbContainer .breadcrumb li + li:before{
        content: '»';
    }
</style>
<?php
/* @var $this fileManagerView */

$this->registerWidgets(array (
    'formW'       => 'form',
    'boxW'        => 'box',
    'pageTitleW'  => 'pageTitle',
    'breadcrumbW' => 'breadcrumb'
)) ;

echo $this->pageTitleW->renderTitle(array (
    'title' => \f\ifm::t('fileDetail'),
    'links' => array (
        array (
            'title' => \f\ifm::t('fileAndFolderslist'),
            'href'  => \f\ifm::app()->baseUrl . 'core/fileManager/index/',
        ),
    )
)) ;


$pathChainBreadcrumb = $this->breadcrumbW->renderTexty($pathsChain) ;

echo \f\html::readyMarkup('div', $pathChainBreadcrumb,
                          array (
    'htmlOptions' => array (
        'id' => 'pathChainBreadcrumbContainer'
    )
        ), true) ;

/* * ************** Box Start ******************* */

echo $this->boxW->begin(array (
    'type'  => 'form',
    'title' => $fileDetail[ 'title' ],
)) ;


echo $this->formW->begin(array (
    'htmlOptions' => array (
        'method' => 'post',
        'action' => \f\ifm::app()->baseUrl . 'core/fileManager/updateFileDetail',
        'id'     => 'detailform'
    )
)) ;


/* * ************** File content ******************* */

echo $this->formW->fieldsetStart(array (
    'legend' => array (
        'text' => \f\ifm::t('fileContent'),
    ),
    'style'  => array (
        'margin-bottom' => '0px'
    )
)) ;
$fileLink = \f\ifm::app()->fileBaseUrl . $fileDetail[ 'id' ] ;

$fileIdInput = \f\html::readyMarkup('input', '',
                                    array (
            'htmlOptions' => array (
                'type'  => 'hidden',
                'name'  => 'fileId',
                'value' => $fileDetail[ 'id' ]
            )
        )) ;
if ( strrpos($fileDetail[ 'mime_type' ], 'image') !== false )
{
    $img = \f\html::readyMarkup('img', '',
                                array (
                'htmlOptions' => array (
                    'src'      => $fileLink,
                    'data-src' => $fileLink,
                ),
                'style'       => array (
                    'max-height' => '400px',
                    'max-width'  => '550px'
                )
                    ), false) ;
    echo \f\html::readyMarkup('div', $fileIdInput . $img,
                              array (
        'htmlOptions' => array (
            'id'        => 'fileContainer',
            'data-type' => 'image'
        )
            ), true) ;
}
else
{
    echo "<a href='$fileLink' target='_blank'>" . \f\ifm::t('Download') . "</a>" ;

    $downloadLink = \f\html::readyMarkup('a', \f\ifm::t('Download'),
                                                        array (
                'htmlOptions' => array (
                    'href'   => $fileLink,
                    'target' => '_blank',
                ) ), false) ;

    echo \f\html::readyMarkup('div', $fileIdInput . $downloadLink,
                              array (
        'htmlOptions' => array (
            'id'        => 'fileContainer',
            'data-type' => 'file'
        )
            ), true) ;
}

echo '<br><br>' ;

echo $this->formW->button(array (
    'htmlOptions' => array (
        'type' => 'button',
        'id'   => 'fileUpload'
    ),
    'block'       => array (),
    'content'     => \f\ifm::t('select'),
    'action'      => array (
        'preServerSideAction' => array (
            'route'   => 'core.fileManager.registerUploadSession',
            'options' => array (
                'extensions'  => '.jpg, .png, .bmp',
                'multiUpload' => 2,
                'maxSize'     => \f\ifm::app()->maxUploadSize,
                'tasks'       => array ( 'upload' )
            ),
        ),
        'display'             => 'dialog',
        'params'              => array (
            'targetRoute'    => "core.fileManager.getUploadForm",
            'triggerElement' => 'fileUpload',
            'dialogTitle'    => \f\ifm::t("fileUpload"),
            'ajaxParams'     => array (
                'mode'            => 'update',
                'replace'         => true,
                'fileId'          => $fileDetail[ 'id' ],
                'fileContainerId' => '#fileContainer',
            )
        )
    )
)) ;

//echo "<script>$(document).ready(function(){  $('#fileUpload').click(function(){alert('ok');}); });</script>";

echo $this->formW->fieldsetEnd() ;

/* * ******************* File Info ***************** */

echo $this->formW->fieldsetStart(array (
    'legend' => array (
        'text' => \f\ifm::t('fileInfo'),
    ),
)) ;

echo $this->formW->input(array (
    'htmlOptions' => array (
        'name'  => 'title',
        'value' => $fileDetail[ 'title' ]
    ),
    'label'       => array (
        'text' => \f\ifm::t('title'),
    ),
    'style'       => array (
        'width' => '300px'
    ),
    'block'       => array ()
)) ;

echo $this->formW->radio(array (
    'htmlOptions' => array (
        'name' => 'enabled',
    ),
    'choices'     => array (
        \f\ifm::t('enabled')  => 'enabled',
        \f\ifm::t('disabled') => 'disable',
    ),
    'label'       => array (
        'text' => \f\ifm::t('fileStatus'),
    ),
    'block'       => array (),
    'checked'     => $fileDetail[ 'status' ],
    'linear'      => TRUE,
)) ;

echo '<div class="clear"></div><br><hr style="border-color: black">' ;
echo $this->formW->button(array (
    'htmlOptions' => array (
        'type' => 'submit',
    ),
    'block'       => array (),
    'content'     => \f\ifm::t('save'),
)) ;

echo $this->formW->fieldsetEnd() ;

echo $this->formW->flush() ;
echo $this->boxW->flush() ;
?>
<script>
    $(document).ready(function () {
        widgetHelper.formSubmit('#detailform');
    });
</script>