<style>
    .main-header{margin-bottom: 30px !important;}
</style>
<?php
/* @var $this fileManagerView */

$this->registerWidgets ( array (
    'pageTitleW'  => 'pageTitle',
    'tableW'      => 'table',
    'breadcrumbW' => 'breadcrumb',
    'boxW'        => 'box',
    'formW'       => 'form'
) ) ;

echo $this->pageTitleW->renderTitle ( array (
    'title' => \f\ifm::t ( 'fileAndFolderslist' ),
) ) ;

echo $this->breadcrumbW->renderTexty ( $pathsChain ) ;

echo $this->formW->rowStart () ;

echo $this->formW->button ( array (
    'htmlOptions' => array (
        'type' => 'button',
        'id'   => 'fileUpload'
    ),
    'inline'      => array (
        'width' => '70px'
    ),
    'content'     => ' + ' . \f\ifm::t ( 'file' ),
    'action'      => array (
        'preServerSideAction' => array (
            'route'   => 'core.fileManager.registerUploadSession',
            'options' => array (
                'multiUpload' => 100,
                'tasks'       => array (
                    'upload' )
            ),
        ),
        'display'             => 'dialog',
        'params'              => array (
            'targetRoute'    => "core.fileManager.getUploadForm",
            'triggerElement' => 'fileUpload',
            'urlParams'      => array (
                'path' => $path
            ),
            'dialogTitle'    => \f\ifm::t ( "fileUpload" ),
            'ajaxParams'     => array (
                'path'      => $path,
                
            )
        )
    )
) ) ;

echo $this->formW->button ( array (
    'htmlOptions' => array (
        'type' => 'button',
        'id'   => 'newFolder'
    ),
    'content'     => ' + ' . \f\ifm::t ( 'folder' ),
    'action'      => array (
        'display' => 'dialog',
        'params'  => array (
            'targetRoute'    => "core.fileManager.newFolder.getForm",
            'triggerElement' => 'newFolder',
            'urlParams'      => array (
                'path' => $path
            ),
            'dialogTitle'    => \f\ifm::t ( "newFolder" ),
        )
    )
) ) ;
echo $this->formW->rowEnd () ;

$params = array (
    'table' => array (
        'title'       => \f\ifm::t ( $param ),
        'htmlOptions' => array (
            'id' => 'myTable',
        )
    ),
    'thead' => array (
        'check' => array (
            'style'     => array (
                'width' => '5%'
            ),
            'formatter' => \f\ifm::t ( 'check' ),
        ),
        'title' => array (
            'style'     => array (
                'width'      => '30%',
                'text-align' => 'center'
            ),
            'sortable'  => true,
            'formatter' => \f\ifm::t ( 'title' ),
        ),
        'name'  => array (
            'style'     => array (
                'width'      => '15%',
                'text-align' => 'center'
            ),
            'sortable'  => true,
            'formatter' => \f\ifm::t ( 'name' ),
        ),
        'link'  => array (
            'style'     => array (
                'width'      => '25%',
                'text-align' => 'center'
            ),
            'sortable'  => true,
            'formatter' => \f\ifm::t ( 'link' ),
        ),
//        'type'  => array (
//            'style'     => array (
//                'width'      => '10%',
//                'text-align' => 'center'
//            ),
//            'formatter' => \f\ifm::t('type'),
//        ),
        'size'  => array (
            'style'     => array (
                'width'      => '15%',
                'text-align' => 'center'
            ),
            'formatter' => \f\ifm::t ( 'size' ),
        ),
        'act'   => array (
            'style'     => array (
                'width'      => '10%',
                'text-align' => 'center'
            ),
            'formatter' => '',
        ),
    ),
    'body'  => $listBody,
        ) ;

echo $this->boxW->begin ( array (
    'type'  => 'table',
    'title' => \f\ifm::t ( 'fileAndFolderslist' )
) ) ;

echo $this->tableW->renderTable ( $params ) ;

echo $this->boxW->flush () ;
?> 
<script>
    $(document).ready(function () {

        var newOption = {
            "serverSide": false,
            "sServerMethod": "POST",
            "aoColumns": [
                {
                    "bSortable": false
                },
                {
                    "bSortable": false
                },
                {
                    "bSortable": false
                },
                {
                    "bSortable": false
                },
                {
                    "bSortable": false
                },
                {
                    "bSortable": false
                }
            ]
        };

        widgetHelper.makeDataTable('#myTable', newOption);
        $('.actionButton').tooltip();
    });
</script>