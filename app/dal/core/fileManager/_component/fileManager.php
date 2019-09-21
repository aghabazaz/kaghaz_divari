<?php

class fileManager extends \f\dal
{

    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine;

        $this->cacheEngine = new \f\cacheStorageEngine;
    }

    public function getFileInfo ( $fileId )
    {
        $this->sqlEngine->Select()
            ->From( 'core_file' )
            ->Where( "id = $fileId" )
            ->Run();

        return $this->sqlEngine->getRow();
    }

    private function uploadedFileInfo ( $file,$fileId )
    {
        $fileInfo = $this->getFileInfo( $fileId );

        if ( empty( $fileInfo ) )
        {
            return false;
        }
//        $a = \f\ifm::app()->uploadDir ;
//        $b = str_replace('-', '.',
//                         \f\DS . str_replace('.', \f\DS, $fileInfo[ 'path' ])) ;

        $pathToOldFile = $this->makeFilePath( $fileInfo['path'] );
        $path          = substr( $pathToOldFile,0,
            strrpos( $pathToOldFile,\f\DS ) + 1 );

        $newFileName   = $fileId . '_' . str_replace( '-','_',$file['name'] );
        $pathToNewFile = $path . $newFileName;

        $shortFilePath = substr( $fileInfo['path'],0,
            strrpos( $fileInfo['path'],'.' ) + 1 );

        return [
            'pathToNewFile' => $pathToNewFile,
            'pathToOldFile' => $pathToOldFile,
            'newFileName'   => $newFileName,
            'shortFilePath' => $shortFilePath,
            'fullPath'      => $shortFilePath . str_replace( '.','-',
                    $newFileName )
        ];
    }

    public function updateFile ( \f\request $request )
    {
        //\f\pr('miad inja?');
        $files = $request->getParam( 'files' );

        $file   = $files[0]; // 1 file could be upload in update mode
        $fileId = $request->getParam( 'fileId' );

        $uploadedFileInfo = $this->uploadedFileInfo( $file,$fileId );

        if ( !$uploadedFileInfo ) // the id is wrong
        {
            return 13; // state number
        }
        //update new file with old id
        if ( $file['error'] == UPLOAD_ERR_OK )
        {
            if ( file_exists( $uploadedFileInfo['pathToOldFile'] ) )
            {
                unlink( $uploadedFileInfo['pathToOldFile'] );
            }

            if ( !move_uploaded_file( $file['tmp_name'],
                $uploadedFileInfo['pathToNewFile'] ) )
            {
                return false;
            }

            $this->sqlEngine->save( 'core_file',
                [
                    'name'        => $uploadedFileInfo['newFileName'],
                    'mime_type'   => $file['type'],
                    'upload_date' => time(),
                    'size'        => $file['size'],
                    'path'        => $uploadedFileInfo['fullPath']
                ],
                [
                    'id = ?',[ $fileId ]
                ] );
            $this->cacheEngine->clear();
            return true;
        }
        return 8; // state number
    }

    private function saveArray ( $file,\f\request $request )
    {
        $saveArray = [
            'mime_type'   => $file['type'],
            'upload_date' => time(),
            'user_id'     => \f\ttt::dal( 'core.auth.getUserOwner' ),
            'size'        => $file['size'],
        ];

        $params = $request->getParam( 'params' );
        if ( $params && !isset( $params['uploadKey'] ) )
        {
            $saveArray['params'] = json_encode( $params );
        }

        return $saveArray;
    }

    public function uploadNewFile ( \f\request $request )
    {
        $files = $request->getParam( 'files' );
        $path  = $request->getParam( 'path' );

        if ( $path == 'root' )
        {
            $path = '';
        } else
        {
            $path = $path . '.';
        }
        $a = \f\ifm::app()->uploadDir . \f\DS;

        $b = '';
        if ( $path !== 'root' )
        {
            $b = str_replace( '.',\f\DS,$path );
        }

        $uploadPath = $a . $b;

        $fileIds    = [];
        $filesCount = count( $files );
        foreach ( $files as $file )
        {
            if ( $file['error'] == UPLOAD_ERR_OK )
            {
                $saveArray = $this->saveArray( $file,$request );

                $this->sqlEngine->save( 'core_file',$saveArray );

                $fileId = $this->sqlEngine->last_id();

                $newFileName = $fileId . '_' . str_replace( [ ' ','-' ],
                        '',$file['name'] );
                $newFilePath = $path . str_replace( '.','-',
                        str_replace( '-','_',
                            $newFileName ) );
                $titleParam  = $request->getParam( 'title' );

                $fileTitle = $filesCount > 1 || trim( $titleParam ) == '' ? $fileId . '_' . $titleParam : $titleParam;

                $this->sqlEngine->save( 'core_file',
                    [
                        'name'  => $newFileName,
                        'title' => $fileTitle,
                        'path'  => $newFilePath
                    ],
                    [
                        'id = ?',[ $fileId ]
                    ] );

                $pathToNewFile = $uploadPath . $newFileName;
                if ( move_uploaded_file( $file['tmp_name'],$pathToNewFile ) )
                {
                    $fileIds[] = $fileId;
                } else
                {
                    $this->sqlEngine->Delete( 'core_file' )
                        ->Where( 'id = ?',$fileId )
                        ->Run();
                }
            }
        }

        return $fileIds;
    }

    public function makeFilePath ( $path )
    {
        $uploadBaseDir = \f\ifm::app()->uploadDir;
        $pathToFile    = $uploadBaseDir . \f\DS . str_replace( '-','.',
                str_replace( '.',
                    \f\DS,
                    $path ) );
        return $pathToFile;
    }

    public function makeFileUrl ( $path )
    {

        $uploadBaseUrl = \f\ifm::app()->legacyBaseUrl . 'upload';
        $path1         = str_replace( \f\ifm::app()->uploadDir,$uploadBaseUrl,$path );
        $pathToFile    = str_replace( \f\DS,'/',$path1 );
        return $pathToFile;
    }

    public function getPathInfo ( $path )
    {
        $pathParts = explode( '.',$path );

        $where       = "path IN (";
        $growingPath = '';
        foreach ( $pathParts as $key => $pathPart )
        {
            $growingPath .= ( empty( $growingPath ) ? '' : '.' ) . $pathPart;
            $where       .= "'$growingPath'";
            if ( $key < count( $pathParts ) - 1 )
            {
                $where .= ", ";
            }
        }
        $where .= ")";
        $this->sqlEngine->Select()
            ->From( 'core_file' )
            ->Where( $where )
            ->Run();
        return $this->sqlEngine->getRows();
    }

    public function loadFile ( $fileId,$width,$height,$option = 'auto_crop' )
    {
        //\f\pre($width);
        if ( !is_array( $this->cacheEngine->fetch( 'file' . $fileId ) ) )
        {

            $this->sqlEngine->Select()
                ->From( 'core_file' )
                ->Where( 'id = ?',$fileId )
                ->Run();

            $fileInfo = $this->sqlEngine->getRow();
            $this->cacheEngine->store( 'file' . $fileId,$fileInfo );
        }
        $fileInfo   = $this->cacheEngine->fetch( 'file' . $fileId );
        $pathToFile = $this->makeFilePath( $fileInfo['path'] );


        if ( $width && $height )
        {

            $pathArr = explode( '.',$fileInfo['path'] );
            array_pop( $pathArr );
            $filename = $fileInfo['name'];
            $path     = str_replace( $filename,'',$pathToFile );

            if ( !is_dir( $path . 'thumb' ) )
            {
                \f\ttt::service( 'core.gallery.checkGalleryExist',
                    [
                        'path'      => implode( '.',$pathArr ),
                        'galleryId' => 'thumb',
                        'title'     => 'thumb'
                    ] );
            }

            $pathToFile = $path . 'thumb' . \f\DS . $width . '_' . $height . '_' . $option . '_' . $filename;

            if ( !file_exists( $pathToFile ) )
            {
                $this->resize( $path,$filename,$width,$height,$option );
            }

        }
        //$this->cacheEngine->delete('cachePathFile'.$fileId.$width.$height);
        $cachePathFile = $this->cacheEngine->fetch( 'cachePathFile' . $fileId . $width . $height );
        if ( empty( $cachePathFile ) )
        {
            $pathUrl = $this->makeFileUrl( $pathToFile );
            $this->cacheEngine->store( 'cachePathFile' . $fileId . $width . $height,$pathUrl,8640000 );
        }
        //\f\pre($fileInfo[ 'mime_type' ]);
        header( "Content-type: {$fileInfo[ 'mime_type' ]}" );
        header( 'Content-disposition: attachment; filename=' . $fileInfo['name'] );
        header( 'Content-Length: ' . filesize( $pathToFile ) );
        return file_get_contents( $pathToFile );

        //return $pathToFile;
    }

    //--------------------------------------------------------------------------
    public function resizeDynamicPro ( $path,$file,$width,$height,$option,$imageQuality = 80,$optionXY=null,$mirror=null,$grayscale=null )
    {
        $x=0;
        $y=0;
        if($optionXY!=null) {
            $strSplit = str_split($optionXY, 11);
            $strSplit[1]=str_replace(")","",$strSplit[1]);
            $strSplit[1]=str_replace("(","",$strSplit[1]);
            $strSplit[1]=substr($strSplit[1], 0, -2);
            if (strcmp(trim($strSplit[0]),trim('translateX'))==0){
                $x= $strSplit[1];
                $y=0;
            }elseif($strSplit[0]=='translateY'){
                $x=0;
                $y=$strSplit[1];
            }
        }

        $maxW      = $width;
        $maxH      = $height;
        $pathThumb = $path . 'dynamic_pro' . \f\DS;
        $resizeobj = new resize ( $path . $file );

        $optionArray = explode( '_',$option );

        foreach ( $optionArray AS $data )
        {
            $resizeobj->resizeImageDynamicPro($maxW,$maxH,$data,$x,$y,$mirror,$grayscale);

            $resizeobj->saveImage($pathThumb .$x.'_'.$y.'_'.$grayscale.'_'.$mirror.'_'.$width . '_' . $height . '_' . $option . '_' . $file,$imageQuality);
        }

    }

    //--------------------------------------------------------------------------


    public function resize ( $path,$file,$width,$height,$option,$imageQuality = 80 )
    {
        $maxW      = $width;
        $maxH      = $height;
        $pathThumb = $path . 'thumb' . \f\DS;
        $resizeobj = new resize ( $path . $file );

        //\f\pre($resizeobj->width);

        $optionArray = explode( '_',$option );

        foreach ( $optionArray AS $data )
        {
            $resizeobj->resizeImage( $maxW,$maxH,$data );
            $resizeobj->saveImage( $pathThumb . $width . '_' . $height . '_' . $option . '_' . $file,$imageQuality );
        }

    }

    //--------------------------------------------------------------------------
    public function getFileDetail ( $fileId )
    {
        $fileInfo = [];
        $this->sqlEngine->Select()
            ->From( 'core_file' )
            ->Where( "id = ?",$fileId )
            ->Run();
        $fileDetail             = $this->sqlEngine->getRow();
        $fileInfo['fileDetail'] = $fileDetail;
        $fileInfo['pathInfo']   = $this->getPathInfo( $fileDetail['path'] );
        return $fileInfo;
    }

    private function recursiveRemoveDir_Physical ( $dir )
    {
        if ( is_dir( $dir ) )
        {
            $objects = scandir( $dir );
            foreach ( $objects as $object )
            {
                if ( $object != "." && $object != ".." )
                {
                    if ( filetype( $dir . \f\DS . $object ) == "dir" )
                    {
                        self::recursiveRemoveDir_Physical( $dir . \f\DS . $object );
                    } else
                    {
                        unlink( $dir . \f\DS . $object );
                    }
                }
            }
            reset( $objects );
            rmdir( $dir );
        }
    }

    private function recursiveRemoveDir_Logical ( $file )
    {
        $this->sqlEngine->Delete( 'core_file' )
            ->Where( "path LIKE '{$file[ 'path' ]}%' " )
            ->Run();
    }

    public function deleteFile ( $fileId )
    {
        $this->sqlEngine->Select()
            ->From( 'core_file' )
            ->Where( "id = ?",$fileId )
            ->Run();
        $file = $this->sqlEngine->getRow();

        $basePath   = \f\ifm::app()->uploadDir . \f\DS;
        $filePath   = str_replace( '-','.',str_replace( '.',\f\DS,$file['path'] ) );
        $pathToFile = $basePath . $filePath;

        if ( $file['type'] == 'folder' )
        {
            if ( file_exists( $pathToFile ) )
            {
                $this->recursiveRemoveDir_Physical( $pathToFile );
            }
            $this->recursiveRemoveDir_Logical( $file );
        } else
        {
            //\f\pre($pathToFile);
            if ( file_exists( $pathToFile ) )
            {
                unlink( $pathToFile );
            }
            $this->sqlEngine->Delete( 'core_file' )
                ->Where( "id = ?",$file['id'] )
                ->Run();
        }

        return true;
    }

    public function uploadFileFromApp ( $params )
    {
        $path = $params['path'];
        $a    = \f\ifm::app()->uploadDir . \f\DS;
        $b    = '';
        if ( $path !== 'root' )
        {
            $b = str_replace( '.',\f\DS,$path );
        }

        $uploadPath = $a . $b;

        $saveArray = [
            'mime_type'   => $params['type'],
            'upload_date' => time(),
            'user_id'     => \f\ttt::dal( 'core.auth.getOwnerFront' ),
            'size'        => $params['size'],
        ];
        //\f\pre($saveArray);

        $this->sqlEngine->save( 'core_file',$saveArray );

        $this->sqlEngine->save( 'core_file',$saveArray );

        $fileId = $this->sqlEngine->last_id();

        $newFileName = $fileId . '_' . str_replace( [ ' ','-' ],
                '',$params['name'] );
        $newFilePath = $path . str_replace( '.','-',
                str_replace( '-','_',
                    $newFileName ) );

        //$fileTitle = '';

        $this->sqlEngine->save( 'core_file',
            [
                'name'  => $newFileName,
                'title' => $newFileName,
                'path'  => $newFilePath
            ],
            [
                'id = ?',[ $fileId ]
            ] );

        $pathToNewFile = $uploadPath . $newFileName;


        if ( move_uploaded_file( $params['tmp_name'],$pathToNewFile ) )
        {
            return $fileId;
        } else
        {
            $this->sqlEngine->Delete( 'core_file' )
                ->Where( 'id = ?',$fileId )
                ->Run();
        }


    }

    public function loadFileUrlDynamicPro ( $fileId,$width,$height,$option = 'auto_crop',$optionXY=null,$mirror=null,$grayscale=null )
    {
        $x=0;
        $y=0;
        if($optionXY!=null) {
            $strSplit = str_split($optionXY, 11);
            $strSplit[1]=str_replace(")","",$strSplit[1]);
            $strSplit[1]=str_replace("(","",$strSplit[1]);
            $strSplit[1]=substr($strSplit[1], 0, -2);
            if (strcmp(trim($strSplit[0]),trim('translateX'))==0){
                $x= $strSplit[1];
                $y=0;
            }elseif($strSplit[0]=='translateY'){
                $x=0;
                $y=$strSplit[1];
            }
        }
        if ( !is_array( $this->cacheEngine->fetch( 'file' . $fileId ) ) )
        {
            $this->sqlEngine->Select()
                ->From( 'core_file' )
                ->Where( 'id = ?',$fileId )
                ->Run();

            $fileInfo = $this->sqlEngine->getRow();
            $this->cacheEngine->store( 'file' . $fileId,$fileInfo );
        }
        $fileInfo   = $this->cacheEngine->fetch( 'file' . $fileId );
        $pathToFile = $this->makeFilePath( $fileInfo['path'] );


        if ( $width && $height )
        {
            $pathArr = explode( '.',$fileInfo['path'] );
            array_pop( $pathArr );
            $filename = $fileInfo['name'];
            $path     = str_replace( $filename,'',$pathToFile );

            if ( !is_dir( $path . 'dynamic_pro' ) )
            {
                \f\ttt::service( 'core.gallery.checkGalleryExist',
                    [
                        'path'      => implode('.',$pathArr ),
                        'galleryId' => 'dynamic_pro',
                        'title'     => 'dynamic_pro'
                    ] );
            }

            $pathToFile = $path . 'dynamic_pro' . \f\DS .$x.'_'.$y.'_'. $grayscale. '_' . $mirror . '_' . $width . '_' . $height . '_' . $option . '_' . $filename;

            if ( !file_exists( $pathToFile ) )
            {
                $this->resizeDynamicPro( $path,$filename,$width,$height,$option,80,$optionXY,$mirror,$grayscale );
            }
        }

        $cachePathFile = $this->cacheEngine->fetch( 'cachePathFile' . $fileId . $width . $height );
        if ( empty( $cachePathFile ) )
        {
            $pathUrl = $this->makeFileUrl( $pathToFile );
            $this->cacheEngine->store( 'cachePathFile' . $fileId . $width . $height,$pathUrl,8640000 );
        }

        return  $this->makeFileUrl($pathToFile);
    }

    public function loadFileUrl ( $fileId,$width,$height,$option = 'auto_crop' )
    {
        if ( !is_array( $this->cacheEngine->fetch( 'file' . $fileId ) ) )
        {

            $this->sqlEngine->Select()
                ->From( 'core_file' )
                ->Where( 'id = ?',$fileId )
                ->Run();

            $fileInfo = $this->sqlEngine->getRow();
            $this->cacheEngine->store( 'file' . $fileId,$fileInfo );
        }
        $fileInfo   = $this->cacheEngine->fetch( 'file' . $fileId );
        $pathToFile = $this->makeFilePath( $fileInfo['path'] );


        if ( $width && $height )
        {

            $pathArr = explode( '.',$fileInfo['path'] );
            array_pop( $pathArr );
            $filename = $fileInfo['name'];
            $path     = str_replace( $filename,'',$pathToFile );

            if ( !is_dir( $path . 'thumb' ) )
            {
                \f\ttt::service( 'core.gallery.checkGalleryExist',
                    [
                        'path'      => implode( '.',$pathArr ),
                        'galleryId' => 'thumb',
                        'title'     => 'thumb'
                    ] );
            }

            $pathToFile = $path . 'thumb' . \f\DS . $width . '_' . $height . '_' . $option . '_' . $filename;

            if ( !file_exists( $pathToFile ) )
            {
                $this->resize( $path,$filename,$width,$height,$option );
            }

        }
        //$this->cacheEngine->delete('cachePathFile'.$fileId.$width.$height);
        $cachePathFile = $this->cacheEngine->fetch( 'cachePathFile' . $fileId . $width . $height );
        if ( empty( $cachePathFile ) )
        {
            $pathUrl = $this->makeFileUrl( $pathToFile );
            $this->cacheEngine->store( 'cachePathFile' . $fileId . $width . $height,$pathUrl,8640000 );
        }
        //\f\pre($fileInfo[ 'mime_type' ]);
        //header( "Content-type: {$fileInfo[ 'mime_type' ]}" );
        //header( 'Content-disposition: attachment; filename=' . $fileInfo['name'] );
        //header( 'Content-Length: ' . filesize( $pathToFile ) );
        return  $this->makeFileUrl($pathToFile);

        //return $pathToFile;
    }

}
