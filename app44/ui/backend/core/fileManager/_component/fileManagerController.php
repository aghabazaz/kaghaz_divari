<?php

/**
 * @author Yuness Mehdian <mehdian.y@gmail.com>
 * @package core.fileManager
 * @category component
 */
class fileManagerController extends \f\controller
{

    /**
     *
     * @var fileManagerView 
     */
    private $view ;

    public function __construct()
    {
        require_once __DIR__ . \f\DS . "fileManagerView.php" ;
        $this->view = new fileManagerView ;
        parent::__construct() ;
    }

    public function index()
    {
        $path = implode('.', $this->request->getNonAssocParams()) ;
        if ( empty($path) )
        {
            $path = 'root' ;
        }
        return $this->render(array (
                    'breadcrumb' => 'core.fileManager.index',
                    'content'    => $this->view->showFilesGird($path)
                )) ;
    }

    public function fileDetail()
    {
        $fileId = $this->request->getParam(0) ;
        return $this->render(array (
                    'breadcrumb' => 'core.fileManager.fileDetail',
                    'content'    => $this->view->showFileDetail($fileId)
                )) ;
    }

    public function getList()
    {
        return $this->response(array (
                    'test'
                )) ;
    }

    public function getUploadForm()
    {
         //\f\pre($this->request);
        $mode   = 'new' ;
        $fileId = '' ;
        if ( $this->request->getParam('mode') == 'update' )
        {
            $mode   = 'update' ;
            $fileId = $this->request->getParam('fileId') ;
            if ( ! $fileId )
            {
                \f\ifm::app()->end('In the update mode, file id is required !') ;
            }
        }

        return $this->response(array (
                    'content' => $this->view->uploadForm($this->request)
                )) ;
    }

    public function updateFileDetail()
    {
        $updateResult = \f\ttt::service('core.fileManager.updateFileDetails',
                                        $this->request) ;
        return $this->response($updateResult) ;
    }

    public function newFolder()
    {
        $mode   = $this->request->getParam(0) ;
        $fileId = $this->request->getParam('fileId') ;

        $content = '' ;
        if ( $mode == 'getForm' ) // view edit/save form
        {
            if ( $fileId )
            {
                $content = $this->view->editFolderForm($fileId) ;
            }
            else
            {
                $urlParams = $this->request->getNonAssocParams() ;
                unset($urlParams[ 0 ]) ;
                $path      = implode('.', $urlParams) ;
                $content   = $this->view->newFolderForm($path) ;
            }
        }
        else // save/update
        {
            $saveFolderParams = array (
                'name'  => $this->request->getParam('folderName'),
                'title' => $this->request->getParam('folderTitle'),
                'path'  => $this->request->getParam('path')
                    ) ;
            if ( $fileId )
            {
                $saveFolderParams[ 'fileId' ] = $fileId ;
            }
            $createFolderResult = \f\ttt::service('core.fileManager.createFolder',
                                                  $saveFolderParams) ;

            if ( $createFolderResult[ 'result' ] == 'success' )
            {
                $createFolderResult[ 'func' ] = 'refreshPage' ;
            }
            return $this->response($createFolderResult) ;
        }
        return $this->response(array (
                    'content' => $content
                )) ;
    }

    public function loader()
    {
        $fileId = $this->request->getParam(0) ;
        $width=$this->request->getParam(1) ;
        $height=$this->request->getParam(2) ;
        return $this->renderPartial(\f\ttt::service('core.fileManager.load',
                                                    array (
                            'fileId' => $fileId,
                            'width' => $width,
                            'height' => $height,                            
                ))) ;
    }

    public function submit()
    {
        $param=  $this->request->getAssocParams ();
        $uploadResult = \f\ttt::service('core.fileManager.upload',
                                        $this->request) ;

        $output = $uploadResult[ 'stateCode' ] ;
        
       
        //\f\pre($param);
        if ( $output[ 'result' ] == 'success' )
        {
             //\f\pre($param);
            if($param['func']!='')
            {
               $output[ 'func' ]   = $param['func'] ;
            }
            else
            {
                $output[ 'func' ]   = 'refreshImage' ;
            }
            
            $output[ 'params' ] = $uploadResult[ 'info' ] ;
            $output['params']['title']=$param['title'];
        }
        //\f\pre($output['params']);
       
        return $this->response($output) ;
    }

    public function deleteFile()
    {
        $fileId       = $this->request->getParam('fileId') ;
        $deleteResult = \f\ttt::service('core.fileManager.deleteFile',
                                        array (
                    'fileId' => $fileId
                )) ;
        if ( $deleteResult[ 'result' ] == 'success' )
        {
            $deleteResult[ 'func' ] = 'remove' ;
        }

        return $this->response($deleteResult) ;
    }
    
    public function searchFileByTitle()
    {
         return $this->response(array (
                    'content' =>  $this->view->renderSearchFileByTitle($this->request->getAssocParams ())
                )) ;
    }

}
