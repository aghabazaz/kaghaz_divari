<?php

class galleryView extends \f\view
{

    public function renderGallery ($params)
    {

        if( $params[ 'galleryId' ])
        {
            $path=$params[ 'path' ] . '.' . $params[ 'galleryId' ];
        }
        else
        {
            $path=$params[ 'path' ] ;
        }

        $picture = \f\ttt::service ( 'core.fileManager.getList',
                                     [
                    'path' => $path,
                ] ) ;

        $numPic  = 0 ;
        $gallery = '' ;
        foreach ( $picture[ 'list' ] AS $data )
        {
            $param  = [
                'id'    => $data[ 'id' ],
                'size'  => $data[ 'size' ],
                'title' => $data[ 'title' ]
                    ] ;
            $gallery .= $this->render ( 'galleryPic',
                                        [
                'params' => $param,
                'cover'  => $params[ 'cover' ],
                    ] ) ;
            $numPic ++ ;
        }

        return array('numPic'=>$numPic,'gallery'=>$gallery) ;
    }
    public function addPic ( $params )
    {
        $params[ 'size' ] = $this->fileSize ( $params[ 'fileId' ][ 0 ] ) ;
        $params[ 'id' ]   = $params[ 'fileId' ][ 0 ] ;
        return $this->render ( 'galleryPic',
                               [
                    'params' => $params,
                    'id'     => $params[ 'galleryId' ]
                ] ) ;
    }
    
    public function renderGalleryPic ( \f\request $request )
    {

        $mode        = $request->getParam ( 'mode' ) ;
        $replace     = $request->getParam ( 'replace' ) ;
        $fileId      = $request->getParam ( 'fileId' ) ;
        $uploadKey   = $request->getParam ( 0 ) ;
        $path        = $request->getParam ( 'path' ) ;
        $customField = $request->getParam ( 'customField' ) ;
        $func        = $request->getParam ( 'func' ) ;

        $fileContainerId = $request->getParam ( 'fileContainerId' ) ;

        $limitParams = \f\ttt::service ( 'core.fileManager.getLimitParams',
                                         [
                    'uploadKey'   => $uploadKey,
                    'customField' => $customField
                ] ) ;

        $output = '' ;
        if ( in_array ( 'upload', $limitParams[ 'tasks' ] ) )
        {
            $uploadFormParams = [
                'limitParams'     => $limitParams,
                'uploadKey'       => $uploadKey,
                'mode'            => $mode,
                'replace'         => $replace,
                'fileId'          => $fileId,
                'fileContainerId' => $fileContainerId,
                'path'            => $path,
                'func'            => $func,
                'customField'     => $customField
                    ] ;
            if ( $request->getParam ( 'params' ) )
            {
                $uploadFormParams[ 'params' ] = $request->getParam ( 'params' ) ;
            }

            $output .= $this->render ( 'uploadGallery', $uploadFormParams ) ;
        }
        return $output ;
    }
    
    public function fileSize ( $id )
    {
        $ch = curl_init ( \f\ifm::app ()->fileBaseUrl . $id ) ;
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, TRUE ) ;
        curl_setopt ( $ch, CURLOPT_HEADER, TRUE ) ;
        curl_setopt ( $ch, CURLOPT_NOBODY, TRUE ) ;

        $data = curl_exec ( $ch ) ;
        $size = curl_getinfo ( $ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD ) ;

        curl_close ( $ch ) ;
        return $size ;
    }

}
