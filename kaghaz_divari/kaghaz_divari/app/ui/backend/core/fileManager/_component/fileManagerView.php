<?php

class fileManagerView extends \f\view
{

    public function showFilesGird ( $path )
    {

        /* @var $formWidget \f\w\form */
        $formWidget = \f\widgetFactory::make ( 'form' ) ;

        $dirInfo = \f\ttt::service ( 'core.fileManager.getList',
                                     array (
                    'path' => $path
                ) ) ;

        $list      = $dirInfo[ 'list' ] ;
        $pathsInfo = $dirInfo[ 'pathsInfo' ] ;

        $listBody = array () ;
        foreach ( $list as $file )
        {
            $checkbox = $formWidget->checkbox ( array (
                'htmlOptions' => array (
                    'id' => 'f' . $file[ 'id' ]
                ),
                'choices'     => array (
                    '' => 'required' ),
                    ) ) ;

            $tr      = array () ;
            $checkTd = array (
                'formatter' => $checkbox ) ;
            $tr[]    = $checkTd ;

            if ( $file[ 'type' ] == 'folder' )
            {
                //$folderIcon     = "<i class='fa fa-folder-open'></i>" ;
                $fileIconMarkup = "<i class='fa fa-folder-open' style='color:#F2AF2D'></i>" ;
                $href           = \f\ifm::app ()->baseUrl . "core/fileManager/index/" . str_replace ( ".",
                                                                                                      "/",
                                                                                                      $file[ 'path' ] ) ;
            }
            else
            {
                $icon = $this->iconType ( strtolower ( pathinfo ( $file[ 'name' ],
                                                                  PATHINFO_EXTENSION ) ) ) ;

                if ( $icon[ 'icon' ] == 'fa-file-image-o' )
                {
                    $fileIcon       = \f\ifm::app ()->fileBaseUrl . "/{$file[ 'id' ]}" ;
                    $fileIconMarkup = "<img style='float: right; width: 30px; height: 30px;border-radius:100%;margin-left:5px' src='$fileIcon'> " ;
                }
                else
                {
                    $fileIconMarkup = "<i class='fa " . $icon[ 'icon' ] . "' style='color:" . $icon[ 'color' ] . "'></i>" ;
                }

                $href = \f\ifm::app ()->baseUrl . "core/fileManager/fileDetail/" . $file[ 'id' ] ;
            }

            $linkStyle = "style='width: 100%; display: block; padding-right: 0px;'" ;
            $url       = "<a $linkStyle href='$href'> $fileIconMarkup {$file[ 'title' ]}</a>" ;

            $titleTd        = array (
                'formatter' => $url ) ;
            $tr[]           = $titleTd ;
            $fileNameMarkup = '<i style="direction: ltr; float: left; text-align: center; width: 100%;">' ;

            if ( strlen ( $file[ 'name' ] ) > 25 )
            {
                $fileNameMarkup .= substr ( $file[ 'name' ], 0, 25 ) . '...' . '</i>' ;
            }
            else
            {
                $fileNameMarkup .= $file[ 'name' ] . '</i>' ;
            }
            $nameTd = array (
                'formatter' => $fileNameMarkup ) ;
            $tr[]   = $nameTd ;
//            $typeTd  = array ( 'formatter' => \f\ifm::t($file[ 'type' ]) ) ;
//            $tr[]    = $typeTd ;

            $actions = $this->createActionButtons ( $file ) ;

            $fileSize = $file[ 'size' ] / 1024 ;
            $sizeUnit = 'KB' ;
            if ( $fileSize > 1024 )
            {
                $fileSize = $fileSize / 1024 ;
                $sizeUnit = 'MB' ;
            }
            if ( $fileSize > 1024 )
            {
                $fileSize = $fileSize / 1024 ;
                $sizeUnit = 'GB' ;
            }
            if ( $file[ 'type' ] == 'file' )
            {
                $link = '<a href="' . \f\ifm::app ()->fileBaseUrl . $file[ 'id' ] . '" target="_blank">' . \f\ifm::app ()->fileBaseUrl . $file[ 'id' ] . '</a>' ;
            }
            else
            {
                $link = 'folder' ;
            }
            $tr[][ 'formatter' ] = '<p style="direction: ltr; font-family: arial;text-align:center">' . $link . '</p>' ;
            $tr[][ 'formatter' ] = '<p style="direction: ltr; font-family: arial;text-align:center">' . (( int ) $fileSize) . " $sizeUnit" . '</p>' ;
            $tr[][ 'formatter' ] = $actions ;
            $listBody[][ 'td' ]  = $tr ;
        }

        return $this->render ( 'filesList',
                               array (
                    'listBody'   => $listBody,
                    'pathsChain' => $this->pathsBreadcrumb ( $pathsInfo ),
                    'path'       => $path
                ) ) ;
    }

    public function iconType ( $ext )
    {
        if ( $ext == 'doc' || $ext == 'docx' )
        {
            return array (
                'icon'  => 'fa-file-word-o',
                'color' => 'darkblue' ) ;
        }
        else if ( $ext == 'xls' || $ext == 'xlsx' )
        {
            return array (
                'icon'  => 'fa-file-excel-o',
                'color' => 'green' ) ;
        }
        else if ( $ext == 'pdf' )
        {
            return array (
                'icon'  => 'fa-file-pdf-o',
                'color' => 'red' ) ;
        }
        else if ( $ext == 'jpg' || $ext == 'jpeg' || $ext == 'png' || $ext == 'gif' || $ext == 'bmp' )
        {
            return array (
                'icon'  => 'fa-file-image-o',
                'color' => '' ) ;
        }
        else if ( $ext == 'zip' || $ext == 'rar' )
        {
            return array (
                'icon'  => 'fa-file-archive-o',
                'color' => '#F27070' ) ;
        }
        else if ( $ext == 'apk' )
        {
            return array (
                'icon'  => 'fa-android',
                'color' => '#97C024' ) ;
        }
        else
        {
            return array (
                'icon'  => 'fa-file-o',
                'color' => 'gray' ) ;
        }
    }

    private function createActionButtons ( $file )
    {
        $deleteButton = array (
            'type'    => 'delete',
            'confirm' => true,
            'action'  => 'core.fileManager.deleteFile',
            'params'  => array (
                'fileId'   => $file[ 'id' ],
                'selector' => "\"#f{$file[ 'id' ]}\""
            ),
                ) ;

        $editButton = array (
            'id'   => 'edit' . $file[ 'id' ],
            'type' => 'edit',
            'href' => \f\ifm::app ()->baseUrl . "core/fileManager/fileDetail/" . $file[ 'id' ]
                ) ;
        if ( $file[ 'type' ] == 'folder' )
        {
            $editButton[ 'clientAction' ] = array (
                'display' => 'dialog',
                'params'  => array (
                    'targetRoute'    => "core.fileManager.newFolder.getForm",
                    'triggerElement' => 'edit' . $file[ 'id' ],
                    'ajaxParams'     => array (
                        'fileId' => $file[ 'id' ]
                    ),
                    'dialogTitle'    => \f\ifm::t ( "editFolder" ),
                )
                    ) ;
        }

        $toggleEnableButton = array (
            'type'           => 'status',
            'status'         => 'enabled',
            'action'         => 'core.fileManager.toggleEnable',
            'clientCallBack' => 'toggleEnable',
            'params'         => array (
                'fileId'   => $file[ 'id' ],
                'selector' => "\"#f{$file[ 'id' ]}\""
            ),
                ) ;

        $buttonsParam = array (
            $deleteButton,
            $editButton,
            $toggleEnableButton
                ) ;

        return \f\html::gridButton ( $buttonsParam ) ;
    }

    public function showFileDetail ( $fileId )
    {

        $fileInfo = \f\ttt::service ( 'core.fileManager.getFileDetail',
                                      array (
                    'fileId' => $fileId
                ) ) ;

        $fileDetail = $fileInfo[ 'fileDetail' ] ;
        $pathInfo   = $fileInfo[ 'pathInfo' ] ;

        return $this->render ( 'fileDetail',
                               array (
                    'fileDetail' => $fileDetail,
                    'pathsChain' => $this->pathsBreadcrumb ( $pathInfo ),
                ) ) ;
    }

    private function pathsBreadcrumb ( $pathsInfo )
    {

        $readyChain = array () ;
        $path       = array () ;
        foreach ( $pathsInfo as $nonReadyItem )
        {
            $path[] = $nonReadyItem[ 'name' ] ;

            $currentPathUrl = \f\ifm::app ()->baseUrl . "core/fileManager/index/" ;
            $currentPathUrl .= implode ( "/", $path ) ;
            $readyItem      = array () ;

            $readyItem[ 'url' ]   = $currentPathUrl ;
            $readyItem[ 'title' ] = $nonReadyItem[ 'title' ] ;
            $readyChain[]         = $readyItem ;
        }
        $rootArray = array (
            'title'      => \f\ifm::t ( 'root' ),
            'url'        => \f\ifm::app ()->baseUrl . "core/fileManager/index/",
            'homeSimple' => true
                ) ;

        array_unshift ( $readyChain, $rootArray ) ;
        return $readyChain ;
    }

    public function uploadForm ( \f\request $request )
    {

        $mode        = $request->getParam ( 'mode' ) ;
        $replace     = $request->getParam ( 'replace' ) ;
        $fileId      = $request->getParam ( 'fileId' ) ;
        $uploadKey   = $request->getParam ( 0 ) ;
        $path        = $request->getParam ( 'path' ) ;
        $customField = $request->getParam ( 'customField' ) ;
        $watermark   = $request->getParam ( 'watermark' ) ;
        $func        = $request->getParam ( 'func' ) ;

        $fileContainerId = $request->getParam ( 'fileContainerId' ) ;

        $limitParams = \f\ttt::service ( 'core.fileManager.getLimitParams',
                                         array (
                    'uploadKey'   => $uploadKey,
                    'customField' => $customField
                ) ) ;


        $output = '' ;

        if ( in_array ( 'select', $limitParams[ 'tasks' ] ) )
        {
            $dirInfo = \f\ttt::service ( 'core.fileManager.getList',
                                         array (
                        'path' => $path
                    ) ) ;

            $files = $dirInfo[ 'list' ] ;

            $output = $this->render ( 'selectFile',
                                      array (
                'files' => $files
//                'limitParams'     => $limitParams,
//                'uploadKey'       => $uploadKey,
//                'mode'            => $mode,
//                'fileId'          => $fileId,
//                'fileContainerId' => $fileContainerId,
//                'path'            => $path
                    ) ) ;
        }

        if ( in_array ( 'upload', $limitParams[ 'tasks' ] ) )
        {
            $uploadFormParams = array (
                'limitParams'     => $limitParams,
                'uploadKey'       => $uploadKey,
                'mode'            => $mode,
                'replace'         => $replace,
                'fileId'          => $fileId,
                'fileContainerId' => $fileContainerId,
                'path'            => $path,
                'customField'     => $customField,
                'watermark'       => $watermark,
                'func'            => $func
                    ) ;
            if ( $request->getParam ( 'params' ) )
            {
                $uploadFormParams[ 'params' ] = $request->getParam ( 'params' ) ;
            }

            $output .= $this->render ( 'uploadForm', $uploadFormParams ) ;
        }

        return $output ;
    }

    public function newFolderForm ( $path )
    {
        return $this->render ( 'newFolderForm',
                               array (
                    'path' => $path
                ) ) ;
    }

    public function editFolderForm ( $fileId )
    {
        $fileDetail = \f\ttt::service ( 'core.fileManager.getFileDetail',
                                        array (
                    'fileId' => $fileId
                ) ) ;

        return $this->render ( 'newFolderForm',
                               array (
                    'fileDetail' => $fileDetail[ 'fileDetail' ]
                ) ) ;
    }

    public function renderSearchFileByTitle ( $params )
    {
        $file = \f\ttt::service ( 'core.fileManager.searchFileByTitle',
                                  array (
                    'search' => $params[ 'id' ]
                ) ) ;

        return $this->render ( 'searchFile',
                               array (
                    'files' => $file
                ) ) ;
    }

}
