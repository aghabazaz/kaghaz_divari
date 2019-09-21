<?php

class fileManagerView extends \f\view
{

    public function uploadForm ( \f\request $request )
    {
        $mode        = $request->getParam ( 'mode' ) ;
        $func        = $request->getParam ( 'func' ) ;
        $replace     = $request->getParam ( 'replace' ) ;
        $fileId      = $request->getParam ( 'fileId' ) ;
        $uploadKey   = $request->getParam ( 0 ) ;
        $path        = $request->getParam ( 'path' ) ;
        $customField = $request->getParam ( 'customField' ) ;
        $watermark   = $request->getParam ( 'watermark' ) ;
        

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
                'func'            => $func,
                'watermark'       => $watermark
                    ) ;
            if ( $request->getParam ( 'params' ) )
            {
                $uploadFormParams[ 'params' ] = $request->getParam ( 'params' ) ;
            }

            $output .= $this->render ( 'uploadForm', $uploadFormParams ) ;
        }

        return $output ;
    }

}
