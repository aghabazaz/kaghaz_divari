<?php
/* @var $this fileManagerView */

$folderTitle = $folderName  = $folderId    = '' ;

if ( isset($fileDetail) )
{
    $path        = $fileDetail[ 'path' ] ;
    $folderTitle = $fileDetail[ 'title' ] ;
    $folderName  = $fileDetail[ 'name' ] ;
    $folderId    = $fileDetail[ 'id' ] ;
}


$this->registerWidgets(array (
    'formW' => 'form'
)) ;

echo $this->formW->begin(array (
    'htmlOptions' => array (
        'id'     => 'newFolderForm',
        'action' => \f\ifm::app()->baseUrl . 'core/fileManager/newFolder',
        'method' => 'post'
    ),
)) ;

echo $this->formW->input(array (
    'htmlOptions' => array (
        'type'  => 'hidden',
        'name'  => 'mode',
        'value' => 'save'
    )
)) ;

if ( ! empty($folderId) )
{
    echo $this->formW->input(array (
        'htmlOptions' => array (
            'type'  => 'hidden',
            'name'  => 'fileId',
            'value' => $folderId
        )
    )) ;
}

echo $this->formW->input(array (
    'htmlOptions' => array (
        'type'  => 'hidden',
        'name'  => 'path',
        'value' => $path
    )
)) ;

echo $this->formW->input(array (
    'htmlOptions' => array (
        'name'  => 'folderTitle',
        'value' => $folderTitle
    ),
    'block'       => array (),
    'label'       => array (
        'text' => \f\ifm::t('folderTitle')
    )
)) ;

echo $this->formW->input(array (
    'htmlOptions' => array (
        'name'  => 'folderName',
        'value' => $folderName
    ),
    'style'       => array (
        'direction' => 'ltr'
    ),
    'block'       => array (),
    'label'       => array (
        'text' => \f\ifm::t('folderName')
    )
)) ;

echo '<hr>' ;
echo $this->formW->button(array (
    'htmlOptions' => array (
        'type' => 'submit',
    ),
    'block'       => array (),
    'content'     => \f\ifm::t('ok')
)) ;

echo $this->formW->flush() ;
?>

<script>
    $(document).ready(function () {
        $('#newFolderForm input[type="submit"]').click(function (e) {
            if ($('input[name="folderTitle"]').val() === '') {
                widgetHelper.errorDialog("<?= \f\ifm::t('enterFolderTitle') ; ?>");
                e.preventDefault();
                return false;
            }
            if ($('input[name="folderName"]').val() === '') {
                widgetHelper.errorDialog("<?= \f\ifm::t('enterFolderName') ; ?>");
                e.preventDefault();
                return false;
            }
        });
        widgetHelper.formSubmit('#newFolderForm');
    });
</script>