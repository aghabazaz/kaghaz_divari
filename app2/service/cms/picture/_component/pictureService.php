<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 *
 * @package \shop\product
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class pictureService extends \f\service
{
    /**
     *
     * @var shortcutMapper
     */
    private $mapper;

    public function __construct()
    {
        $this->mapper = \f\dalFactory::make('shop.product');
    }

    public function pictureList()
    {
        return \f\ttt::dal('cms.picture.pictureList',
            $this->request->getAssocParams());
    }

    public function getPictureById()
    {
        return \f\ttt::dal('cms.picture.getPictureById',
            $this->request->getAssocParams());
    }

    public function pictureSave ()
    {
        $params   = $this->request->getAssocParams () ;
        //unset checkbox for save params in tbl
        unset ( $params[ 'checkbox' ] ) ;
            if ( $params[ 'id' ] )
            {
                $result = \f\ttt::dal ( 'cms.picture.pictureSaveEdit', $params ) ;
                $msg    = \f\ifm::t ( 'pictureSaveEdit' ) ;
                $reset  = FALSE ;
            }
            else
            {
                $result = \f\ttt::dal ( 'cms.picture.pictureSave', $params ) ;
                $msg    = \f\ifm::t ( 'pictureSave' ) ;
                $reset  = TRUE ;
            }

            if ( $result )
            {
                $data = array (
                    'result'  => 'success',
                    'message' => $msg,
                    'reset'   => $reset,
                   ) ;
            }
            else
            {
                $data = array (
                    'result'  => 'error',
                    'message' => \f\ifm::t ( 'dbError' ) ) ;
            }

        return $data ;
    }

    public function pictureDelete()
    {
        $params = $this->request->getAssocParams();
        $row = \f\ttt::service('core.fileManager.getFileIdByPath',
            array(
                'path' => 'cms.picture.' . $params['id']
            ));

        $fileId = $row['id'];
        \f\ttt::service('core.fileManager.deleteFile',
            array(
                'fileId' => $fileId
            ));
        return \f\ttt::dal('cms.picture.pictureDelete',
            $this->request->getAssocParams());
    }

    public function pictureStatus()
    {
        return \f\ttt::dal('cms.picture.pictureStatus',
            $this->request->getAssocParams());
    }

    public function getPictureListFront(){
        return \f\ttt::dal('cms.picture.getPictureListFront');
    }
    public function getGalleryPicDetails(){
        return \f\ttt::dal('cms.picture.getGalleryPicDetails',
            $this->request->getAssocParams());
    }
}
