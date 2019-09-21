<?php

/**
 * @author Hajian
 * @package \chartex\core
 * @category component
 *
 */
class fileManagerService extends \f\service
{

    /**
     *
     * @var fileManager
     */
    private $fileMgr;

    private function registerFileMgr ()
    {
        include __DIR__ . \f\DS . 'model' . \f\DS . 'fileMgr.php';

        /* @var $fileManager fileManager */
        if ( empty ( $this->fileMgr ) )
        {
            $this->fileMgr = new fileMgr;
        }
    }

    public function load ()
    {

        return \f\ttt::dal( 'core.fileManager.loader',$this->request );
    }

    public function getList ()
    {
        return \f\ttt::dal( 'core.fileManager.getList',$this->request );
    }

    public function getPictureList ()
    {
        return \f\ttt::dal( 'core.fileManager.getPictureList',$this->request );
    }

    public function getFileDetail ()
    {
        return \f\ttt::dal( 'core.fileManager.getFileDetail',$this->request );
    }

    public function registerUploadSession ()
    {
        $uploadKey = \f\ttt::dal( 'core.fileManager.registerLimits',
            $this->request );
        return $uploadKey;
    }

    public function getLimitParams ()
    {
        return \f\ttt::dal( 'core.fileManager.getLimits',$this->request );
    }

    public function upload ()
    {

        $this->registerFileMgr();

        $result = $this->fileMgr->upload( $this->request );
        //\f\pre($result);

        $mode = $this->request->getParam( 'mode' );
        if ( $mode == '' )
        {
            $mode = 'new';
        }
        return [
            'stateCode' => $this->state( $result['stateCode'] ),
            'info'      => $result['info']
        ];
    }

    public function createFolder ()
    {
        /* check permission to create folder here */

        $createFolderResult = \f\ttt::dal( 'core.fileManager.createFolder',
            $this->request );

        return $this->state( $createFolderResult );
    }

    public function deleteFile ()
    {
        $deleteResult = \f\ttt::dal( 'core.fileManager.deleteFile',
            $this->request );
        if ( $deleteResult )
        {
            return [
                'result' => 'success'
            ];
        }
        return false;
    }

    public function updateFileDetails ()
    {
        $updateResult = \f\ttt::dal( 'core.fileManager.updateFileDetails',
            $this->request );

        if ( $updateResult === true )
        {
            return $this->state( 11 );
        }
    }

    public function frontendPathFile ()
    {
        $param = $this->request->getAssocParams();

        $uploadBaseDir = \f\ifm::app()->uploadDir;
        $pathToFile    = $uploadBaseDir . \f\DS . str_replace( '-','.',
                str_replace( '.',
                    \f\DS,
                    $param['path'] ) );
        $path          = str_replace( $param['fileName'],'',$pathToFile );
        $pathToFile    = $path . 'thumb' . \f\DS . $param['width'] . '_' . $param['height'] . '_' . $param['fileName'];

        if ( file_exists( $pathToFile ) )
        {
            return $this->makeFileUrl( $pathToFile );;
        } else
        {
            return \f\ifm::app()->fileBaseUrl . $param['id'] . '/' . $param['width'] . '/' . $param['height'];
        }
    }

    public function makeFileUrl ( $path )
    {

        $uploadBaseUrl = \f\ifm::app()->legacyBaseUrl . 'upload';
        $path1         = str_replace( \f\ifm::app()->uploadDir,
            $uploadBaseUrl,$path );
        $pathToFile    = str_replace( \f\DS,'/',$path1 );
        return $pathToFile;
    }

    public function searchFileByTitle ()
    {
        return \f\ttt::dal( 'core.fileManager.searchFileByTitle',
            $this->request->getAssocParams() );
    }

    public function baseUpload ()
    {
        $param = $this->request->getAssocParams();
        //\f\pre($param);
        $file = $param['files']['file'];
        $path = $param['path'];
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

        //\f\pre($uploadPath);

        if ( $file['size'] <= $param['size'] )
        {
            $ext = strtolower( pathinfo( $file['name'],PATHINFO_EXTENSION ) );


            if ( in_array( $ext,$param['allowed'] ) )
            {
                if ( is_writable( $uploadPath ) )
                {
                    $newFileName   = time() . '_' . str_replace( [
                            ' ',
                            '-' ],'',$file['name'] );
                    $newFilePath   = $path . str_replace( '.','-',
                            str_replace( '-',
                                '_',
                                $newFileName ) );
                    $pathToNewFile = $uploadPath . $newFileName;

                    if ( move_uploaded_file( $file['tmp_name'],
                        $pathToNewFile ) )
                    {
                        $id = \f\ttt::dal( 'core.fileManager.baseUpload',
                            [
                                'name'      => $newFileName,
                                'type'      => 'file',
                                'path'      => $newFilePath,
                                'status'    => 'enabled',
                                'title'     => '',
                                'mime_type' => $file['type'],
                                'size'      => $file['size'],
                                'params'    => NULL
                            ] );
                        if ( $id )
                        {
                            return [
                                'result' => 'success',
                                'params' => [
                                    'id' => $id ] ];
                        } else
                        {
                            return [
                                'result'  => 'error',
                                'message' => \f\ifm::t( 'dbError' ) ];
                        }
                    } else
                    {
                        return [
                            'result'  => 'error',
                            'message' => \f\ifm::t( 'upload' ) ];
                    }
                } else
                {
                    return [
                        'result'  => 'error',
                        'message' => \f\ifm::t( 'path' ) ];
                }
            } else
            {
                return [
                    'result'  => 'error',
                    'message' => \f\ifm::t( 'allowed' ) ];
            }
        } else
        {
            return [
                'result'  => 'error',
                'message' => \f\ifm::t( 'fileSize' ) ];
        }
    }

    public function getFileIdByPath ()
    {
        return \f\ttt::dal( 'core.fileManager.getFileIdByPath',
            $this->request->getAssocParams() );
    }

    public function getFileUrlById ()
    {
        $row           = \f\ttt::dal( 'core.fileManager.getFileDetail',
            $this->request );
        $path          = $row['fileDetail']['path'];
        $uploadBaseUrl = 'upload/';
        $urlToFile     = $this->str_lreplace( '-','.',
            str_replace( '.','/',$path ) );
        return $uploadBaseUrl . $urlToFile;
    }

    function str_lreplace ( $search,$replace,$subject )
    {
        $pos = strrpos( $subject,$search );

        if ( $pos !== false )
        {
            $subject = substr_replace( $subject,$replace,$pos,
                strlen( $search ) );
        }

        return $subject;
    }

    public function uploadFileFromApp ()
    {
        $params = $this->request->getAssocParams();

        $uploadResult = $this->checkFileFromApp( $params );

        $fileId = 0;

        if ( empty( $uploadResult ) )
        {
            $fileId = \f\ttt::dal( 'core.fileManager.uploadFileFromApp',
                $params );
        }

        return [ 'fileId' => $fileId,'errorResult' => $uploadResult ];

    }

    private function checkFileFromApp ( $params )
    {
        $uploadResult = [];
        $limitsArr    = $params['limits'];
        $file         = $params;


        /** check max size * */
        if ( $file['size'] > $limitsArr['maxSize'] && $limitsArr['maxSize'] > 0 )
        {
            $uploadResult = [

                'error'  => 'size',
                'data'   => $file['size']

            ];

        }

        /** check extension * */
        $extensionParts = explode( '.',$file['name'] );
        $extension      = '.' . $extensionParts[count( $extensionParts ) - 1];

        if ( $limitsArr['extensions'] && !in_array( $extension,
                $limitsArr['extensions'] ) )
        {
            $uploadResult = [

                'error'     => 'extension',
                'data' => $extension

            ];

        }


        return $uploadResult;


    }
	
	public function loadFileUrlDynamicPro ()
    {

        return \f\ttt::dal( 'core.fileManager.loadFileUrlDynamicPro',$this->request->getAssocParams() );
    }
    public function loadFileUrl ()
    {

        return \f\ttt::dal( 'core.fileManager.loadFileUrlDynamicPro',$this->request->getAssocParams() );
    }
    public function cropImage ()
    {

       // \f\pre('ds');
        return \f\ttt::dal( 'core.fileManager.cropImage',$this->request->getAssocParams() );
    }
}
