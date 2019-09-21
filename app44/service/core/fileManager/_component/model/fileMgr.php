<?php

class fileMgr
{

    private function checkUploadParams(\f\request $request)
    {
        $mode = $request->getParam('mode') ;
        switch ( $mode )
        {
            case '' :
                if ( ! $request->getParam('path') )
                {
                    return 1 ; //failed
                }

                break ;
            case 'update':
                if ( ! $request->getParam('fileId') )
                {
                    return 2 ; // failed
                }
                break ;
            default :
                return 3 ; // failed
        }
        return false ;
    }

    public function upload(\f\request $request)
    {

        $failedState = $this->checkUploadParams($request) ;

        if ( $failedState !== false )
        {

            return $this->uploadResult(13) ;
        }

        $uploadLimits = \f\ttt::dal('core.fileManager.getLimits', $request) ;
        //\f\pre($uploadLimits);
        // If upload key is wrong
        if ( ! $uploadLimits )
        {
            return $this->uploadResult(4) ;
        }


        $limitsArr = $this->parseUploadLimitOptions($uploadLimits) ;
        //\f\pre($limitsArr);
        $filesArr  = $request->getParam('files') ;
        $files     = $this->convertMultiUploadArray($filesArr[ 'file' ]) ;
        $mode      = $request->getParam('mode') ;

        $array = $this->fillerFiles($files, $limitsArr, $mode) ;

        $uploadedFiles=$array[0];
        $uploadResult=$array[1];

        if(!empty($uploadResult))
        {
            if($uploadResult['error']=='size')
            {
                return $this->uploadResult(17) ;
            }
            if($uploadResult['error']=='extension')
            {
                return $this->uploadResult(18) ;
            }

        }

        $request->addAssocParam(array (
            'files'               => $uploadedFiles,
            'requestedFilesCount' => count($files)
        )) ;


        //\f\pre('inja');
        return $this->uploadFilesToServer($request) ;
    }

    private function fillerFiles($files, $limitsArr, $mode)
    {

        $uploadedFiles = array () ;

        $uploadResult = array () ;
        foreach ( $files as $file )
        {

            /** check files count * */
            if ( count($uploadedFiles) >= $limitsArr[ 'filesNumAllowed' ] )
            {
                break ;
            }

            if ( $mode == 'update' && count($uploadedFiles) >= 1 )
            {
                break ;
            }

            //\f\pre($file);

            /** check max size * */
            if ( $file[ 'size' ] > $limitsArr[ 'maxSize' ] && $limitsArr[ 'maxSize' ] > 0 )
            {
                $uploadResult = array (

                    'result' => 'failed',
                    'error'  => 'size'

                ) ;
                continue ;
            }

            /** check extension * */
            $extensionParts = explode('.', $file[ 'name' ]) ;
            $extension      = '.' . $extensionParts[ count($extensionParts)-1 ] ;
            //\f\pre($limitsArr[ 'extensions' ]);

            if ( $limitsArr[ 'extensions' ] && !in_array($extension,
                    $limitsArr[ 'extensions' ]) )
            {
                $uploadResult= array (

                    'result' => 'failed',
                    'error'  => 'extension'

                ) ;
                continue ;
            }

            $uploadedFiles[] = $file ;
        }
        //\f\pre($uploadResult);

        return array($uploadedFiles,$uploadResult) ;
    }

    private function uploadResult($stateCode, $result = array (), $mode = '')
    {
        return array (
            'stateCode' => $stateCode,
            'info'      => array (
                'fileId' => $result,
                'mode'   => $mode
            )
        ) ;
    }

    private function uploadFilesToServer(\f\request $request)
    {

        // on failed the $uploadResult is the state code
        //\f\pre($request);
        $uploadResult = \f\ttt::dal('core.fileManager.uploadFiles', $request) ;

        $mode = $request->getParam('mode') ;

        switch ( $mode )
        {
            case 'update':
                if ( $uploadResult == true )
                {
                    return $this->uploadResult(7, $uploadResult, $mode) ;
                }
                else
                {
                    return $this->uploadResult($uploadResult) ;
                }
                break ;
            case '': // in the new mode, no state is returned
                if ( count($uploadResult) < $request->getParam('requestedFilesCount') )
                {
                    return $this->uploadResult(10, $uploadResult, $mode) ;
                }
                else
                {
                    return $this->uploadResult(9, $uploadResult, $mode) ;
                }
                break ;
        }
    }

    private function parseUploadLimitOptions($uploadLimits)
    {
        //\f\pre($uploadLimits);
        $filesNumAllowed = 1 ;
        if ( isset($uploadLimits[ 'multiUpload' ]) )
        {
            if ( $uploadLimits[ 'multiUpload' ] == 0 )
            {
                $filesNumAllowed = 1000 ; // max file in multi upload mode, hard code :)
            }
            else
            {
                $filesNumAllowed = $uploadLimits[ 'multiUpload' ] ;
            }
        }

        $extensions = false ; // all
        if ( isset($uploadLimits[ 'extensions' ]) )
        {
            $extensions = explode(',', str_replace(" ","",$uploadLimits[ 'extensions' ])) ; // limited
        }

        $maxSize = 0 ;
        if ( isset($uploadLimits[ 'maxSize' ]) )
        {
            $maxSize = $uploadLimits[ 'maxSize' ] ;
        }

        return array (
            'filesNumAllowed' => $filesNumAllowed,
            'extensions'     => $extensions,
            'maxSize'         => $maxSize
        ) ;
    }

    private function convertMultiUploadArray($filesArray)
    {
        $convertedArray = array () ;
        foreach ( $filesArray[ 'name' ] as $num => $name )
        {
            $cArray               = array () ;
            $cArray[ 'name' ]     = $name ;
            $cArray[ 'type' ]     = $filesArray[ 'type' ][ $num ] ;
            $cArray[ 'tmp_name' ] = $filesArray[ 'tmp_name' ][ $num ] ;
            $cArray[ 'error' ]    = $filesArray[ 'error' ][ $num ] ;
            $cArray[ 'size' ]     = $filesArray[ 'size' ][ $num ] ;
            $convertedArray[]     = $cArray ;
        }
        return $convertedArray ;
    }

}
