<?php

class galleryController extends \f\controller
{
    /**
     *
     * @var seoView
     */
    private $view ;

    public function __construct ()
    {
        require_once 'galleryView.php' ;
        $this->view = new galleryView ;
        parent::__construct () ;
    }
    
    public function renderGallery()
    {
        //\f\pre('dssd');
        $params= $this->request->getAssocParams();
        $result=$this->view->renderGallery($params);

        return $this->renderPartial ( $result);
        
    }
    public function addPic ()
    {
        return $this->response( [
            'content' => $this->view->addPic( $this->request->getAssocParams() )
        ] );
    }
    
    public function deletePic ()
    {
        $fileId       = $this->request->getParam( 'fileId' );
        $deleteResult = \f\ttt::service( 'core.fileManager.deleteFile',
            [
                'fileId' => $fileId
            ] );
        if ( $deleteResult['result'] == 'success' )
        {
            $deleteResult['func'] = 'remove';
            $deleteResult['id']   = $fileId;
        }
        return $this->response( $deleteResult );
    }
    
    public function galleryPic ()
    {
        return $this->response( [
            'content' => $this->view->renderGalleryPic( $this->request ) ] );
    }

}
