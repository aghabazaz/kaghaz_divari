<?php

class pictureView extends \f\view
{
    public function renderPictureList ()
    {
        $galleryPic = \f\ttt::service( 'cms.picture.getPictureListFront',
            [
                'status' => 'enabled'
            ],true );
        return $this->render( 'pictureList',[ 'row' => $galleryPic ] );
    }

    public function renderGalleryPicDetails ( $param )
    {
        $galleryPicDetails = \f\ttt::service( 'cms.picture.getGalleryPicDetails',[ 'status' => 'enabled','idVal' => $param ],true );
        return $this->render( 'pictureDetails',[ 'row' => $galleryPicDetails ] );
    }
}

