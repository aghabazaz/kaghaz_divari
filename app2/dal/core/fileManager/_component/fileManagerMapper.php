<?php

class fileManagerMapper extends \f\dal
{

    /**
     *
     * @var fileManager
     */
    private $fileManager;

    /**
     *
     * @var folderManager
     */
    private $folderManager;

    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine;

        include_once __DIR__ . \f\DS . 'fileManager.php';
        $this->fileManager = new fileManager;

        include_once __DIR__ . \f\DS . 'folderManager.php';
        $this->folderManager = new folderManager;

        $this->registerGadgets( [
            'sessionG' => 'session' ] );
    }

    public function loader ()
    {
        $fileId = $this->request->getParam( 'fileId' );
        $width  = $this->request->getParam( 'width' );
        $height = $this->request->getParam( 'height' );
        $option = $this->request->getParam( 'option' );
        return $this->fileManager->loadFile( $fileId,$width,$height,$option );
    }

    public function getList ()
    {
        $path  = $this->request->getParam( 'path' );
        $where = '';
        if ( $path == 'root' )
        {
            $where = "path NOT LIKE '%.%'";
        } else
        {
            $where = "path LIKE '$path.%' and path NOT LIKE '$path.%.%'";
        }

        $this->sqlEngine->Select()
            ->From( 'core_file' )
            ->Where( $where )
            ->OrderBy( 'type DESC' )
            //->Limit( 19 )
            ->Run();

        $result = [
            'list' => $this->sqlEngine->getRows()
        ];

        $result['pathsInfo'] = $this->fileManager->getPathInfo( $path );
        return $result;
    }

    public function getPictureList ()
    {
        $path  = $this->request->getParam( 'path' );
        $where = '';
        if ( $path == 'root' )
        {
            $where = "path NOT LIKE '%.%'";
        } else
        {
            $where = "path LIKE '$path.%' and path NOT LIKE '$path.%.%'";
        }

        $this->sqlEngine->Select()
            ->From( 'core_file' )
            ->Where( $where )
            ->OrderBy( 'id' )
            ->Limit( 19 )
            ->Run();

        $pictures = [
            'list' => $this->sqlEngine->getRows()
        ];

        $row = 0;
        foreach ( $pictures['list'] AS $data )
        {
            $picArr['pic' . $row]['title'] = $data['title'];
            $picArr['pic' . $row]['path']  = $this->filePath( $data['path'] );
            $row                           += 1;
        }
        return $picArr;
    }

    public function filePath ( $path )
    {
        $path = \f\ifm::app()->siteUrl . 'upload/' . ( str_replace( '-','.',
                str_replace( '.',
                    '/',
                    $path ) ) );
        return $path;
    }

    public function getLimits ()
    {
        $uploadKey = $this->request->getParam( 'uploadKey' );
        $this->registerGadgets( [
            'sessionG' => 'session' ] );

        $fileManagerSessionValue = $this->sessionG->read( 'fileManager' . $uploadKey );

        //\f\pre(($_SESSION));

        //\f\pr($_SESSION['fileManager' . $uploadKey]);

        if ( !$fileManagerSessionValue )
        {
            return false;
        }


        //\f\pre($uploadKey);
        $userId = \f\ttt::dal( 'core.auth.getUserId' );


        $customField = $this->request->getParam( 'customField' );

        if ( !$customField )
        {
            $customField = 'single';
        }
        //\f\pre($userId);

        if ( isset ( $fileManagerSessionValue[$userId] ) )
        {
            $keyIsExists = $fileManagerSessionValue[$userId][$customField]['uploadKey'] == $uploadKey;
            if ( $keyIsExists )
            {

                return $fileManagerSessionValue[$userId][$customField]['limitOptions'];
            }
        }
        return false;
    }

    public function registerLimits ()
    {

        $limitOptions = $this->request->getParam( 'options' );
        $customField  = isset ( $limitOptions['customField'] ) ? $limitOptions['customField'] : false;

        $this->registerGadgets( [
            'codingG'  => 'coding',
            'sessionG' => 'session'
        ] );

        while ( true )
        {
            $uploadKey = $this->codingG->generateRandomString();
            if ( !$this->checkUniqueUploadKey() )
            {
                break;
            }
        }

        $userId = \f\ttt::dal( 'core.auth.getUserId' );

        if ( !$customField )
        {
            $customField = 'single';
        }

        $userSessionValue = [
            'uploadKey'    => $uploadKey,
            'limitOptions' => $limitOptions
        ];

        if ( $this->sessionG->exists( 'fileManager' . $uploadKey ) )
        {
            $fileManagerSessionValue = $this->sessionG->read( 'fileManager' );

            $fileManagerSessionValue[$userId][$customField] = $userSessionValue;
        } else
        {
            $fileManagerSessionValue = [
                $userId => [
                    $customField => $userSessionValue
                ] ];
        }

        $this->sessionG->write( 'fileManager' . $uploadKey,
            $fileManagerSessionValue );

        //\f\pre($_SESSION);
        return $uploadKey;
    }

    private function checkUniqueUploadKey ()
    {
        $key = $this->request->getParam( 'key' );

        if ( $this->sessionG->exists( $key ) )
        {
            return true;
        }
        return false;
    }

    public function getFileDetail ()
    {
        $fileId = $this->request->getParam( 'fileId' );
        return $this->fileManager->getFileDetail( $fileId );
    }

    public function uploadFiles ()
    {

        $mode    = $this->request->getParam( 'mode' );
        $replace = $this->request->getParam( 'replace' );

        if ( !$replace )
        {
            $mode = 'new';
        }
        //\f\pr($mode);

        switch ( $mode )
        {
            case 'update':
                return $this->fileManager->updateFile( $this->request );
            case 'new':
            case '':

                return $this->fileManager->uploadNewFile( $this->request );
        }
    }

    public function createFolder ()
    {
        if ( $this->request->getParam( 'fileId' ) )
        {
            return $this->folderManager->updateExistingFolder( $this->request );
        } else
        {
            return $this->folderManager->createNewFolder( $this->request );
        }
    }

    public function deleteFile ()
    {
        $fileId = $this->request->getParam( 'fileId' );
        return $this->fileManager->deleteFile( $fileId );
    }

    public function updateFileDetails ()
    {
        $title  = $this->request->getParam( 'title' );
        $status = $this->request->getParam( 'enabled' );
        $fileId = $this->request->getParam( 'fileId' );

        $this->sqlEngine->save( 'core_file',
            [
                'title'  => $title,
                'status' => $status,
            ],
            [
                'id = ?',
                [
                    $fileId ] ] );

        return true;
    }

    public function searchFileByTitle ()
    {
        $params = $this->request->getAssocParams();


        $this->sqlEngine->Select( 'id,type' )
            ->From( 'core_file' )
            ->Where( "title LIKE '%" . $params['search'] . "%'" )
            ->Run();

        return $this->sqlEngine->getRows();
    }

    public function baseUpload ()
    {
        $param            = $this->request->getAssocParams();
        $param['user_id'] = NULL;

        $this->sqlEngine->save( 'core_file',$param );

        return $this->sqlEngine->last_id();
    }

    public function getFileIdByPath ()
    {
        $param = $this->request->getAssocParams();
        $this->sqlEngine->Select( 'id' )
            ->From( 'core_file' )
            ->Where( 'path=?',$param['path'] )
            ->Run();
        return $this->sqlEngine->getRow();
    }

    public function uploadFileFromApp ()
    {
        $params = $this->request->getAssocParams();

        return $this->fileManager->uploadFileFromApp( $params );
    }

    public function loadFileUrlDynamicPro ()
    {
       // \f\pre('sdf');
        $fileId = $this->request->getParam( 'fileId' );
        $width  = $this->request->getParam( 'width' );
        $height = $this->request->getParam( 'height' );
        $option = $this->request->getParam( 'option' );
        $optionXY=$this->request->getParam( 'optionXY' );
        $mirror=$this->request->getParam( 'mirror' );
        $grayscale=$this->request->getParam( 'grayscale' );
        return $this->fileManager->loadFileUrlDynamicPro( $fileId,$width,$height,'crop',$optionXY,$mirror,$grayscale );
    }

    public function loadFileUrl ()
    {
        $fileId = $this->request->getParam( 'fileId' );
        $width  = $this->request->getParam( 'width' );
        $height = $this->request->getParam( 'height' );
        $option = $this->request->getParam( 'option' );
        return $this->fileManager->loadFileUrl( $fileId,$width,$height,$option );
    }
}
