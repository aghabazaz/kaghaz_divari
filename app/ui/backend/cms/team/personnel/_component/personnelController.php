<?php

class personnelController extends \f\controller
{

    /**
     *
     * @var \f\coreView
     */
    private $view ;

    public function __construct()
    {
        require_once 'personnelView.php' ;
        $this->view = new personnelView ;
        parent::__construct() ;
    }

    public function index()
    {
        return $this->render(array (
                    'breadcrumb' => 'cms.team.personnel.index',
                    'content'    => $this->view->renderPersonnelList()
                )) ;
    }
    public function personnelAdd ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'cms.team.personnel.personnelAdd',
                    'content'    => $this->view->renderPersonnelAdd ()
                ) ) ;
    }
    
     public function personnelSave ()
    {
        return $this->response ( \f\ttt::service ( 'cms.team.personnel.personnelSave',
                                                   $this->request->getAssocParams () ) ) ;
    }
    
    public function personnelList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderPersonnelGrid ( $requestDataTble ) ) ;
    }
    public function personnelEdit ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'cms.team.personnel.personnelEdit',
                    'content'    => $this->view->renderPersonnelAdd ( $this->request->getParam ( 0 ) )
                ) ) ;
    }
    
    public function personnelDelete ()
    {
        return $this->response ( \f\ttt::service ( 'cms.team.personnel.personnelDelete',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function personnelStatus ()
    {
        return $this->response ( \f\ttt::service ( 'cms.team.personnel.personnelStatus',
                                                   $this->request->getAssocParams () ) ) ;
    }
    public function personnelSpecial ()
    {
        return $this->response ( \f\ttt::service ( 'cms.team.personnel.personnelSpecial',
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
    
   
    

}

