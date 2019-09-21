<?php

class pictureController extends \f\controller
{

    /**
     *
     * @var \f\slideView
     */
    private $view ;

    public function __construct ()
    {
        require_once 'pictureView.php';
        $this->view = new pictureView ;
        parent::__construct () ;
    }

    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'cms.picture.index',
                    'content'    => $this->view->renderGrid ()
                ) ) ;
    }

    public function pictureList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderPictureGrid ( $requestDataTble ) ) ;
    }

    public function pictureAdd ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'cms.picture.pictureAdd',
                    'content'    => $this->view->renderPictureAdd ()
                ) ) ;
    }

    public function pictureSave ()
    {
       //\f\pre($this->request->getAssocParams ());
       return $this->response ( \f\ttt::service ( 'cms.picture.pictureSave',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function pictureEdit ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'cms.picture.pictureSave',
                    'content'    => $this->view->renderPictureAdd ( $this->request->getParam ( 0 ) )
                ) ) ;
    }

    public function pictureDelete ()
    {
        return $this->response ( \f\ttt::service ( 'cms.picture.pictureDelete',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function pictureStatus ()
    {
        return $this->response ( \f\ttt::service ( 'cms.picture.pictureStatus',
                                                   $this->request->getAssocParams () ) ) ;
    }
    public function addPic ()
    { 
        return $this->response ( array ( 
            'content' => $this->view->addPic ($this->request->getAssocParams ()) 
                )) ;
    }
    public function galleryPic ()
    {
        return $this->response ( array ( 'content' => $this->view->renderGalleryPic ($this->request ) ) ) ;
    }
    
    public function submit()
    {
        $param=  $this->request->getAssocParams ();
        $uploadResult = \f\ttt::service('core.fileManager.upload',
                                        $this->request) ;

        $output = $uploadResult[ 'stateCode' ] ;
        if ( $output[ 'result' ] == 'success' )
        {
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
       
        return $this->response($output) ;
    }
    public function deletePic()
    {
        $fileId       = $this->request->getParam('fileId') ;
        $deleteResult = \f\ttt::service('core.fileManager.deleteFile',
                                        array (
                    'fileId' => $fileId
                )) ;
        if ( $deleteResult[ 'result' ] == 'success' )
        {
            $deleteResult[ 'func' ] = 'remove' ;
            $deleteResult[ 'id' ]=$fileId;
        }
        return $this->response($deleteResult) ;
    }
    public function loadFeature ()
    {
        return $this->response ( array ( 'content' => $this->view->renderLoadFeature ($this->request->getAssocParams () ) ) ) ;
    }

}
