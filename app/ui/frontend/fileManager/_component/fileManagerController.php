<?php

/**
 * @author Yuness Mehdian <mehdian.y@gmail.com>
 * @package core.fileManager
 * @category component
 */
class fileManagerController extends \f\controller
{

    /**
     *
     * @var fileManagerView 
     */
    private $view ;

    public function __construct()
    {
        require_once __DIR__ . \f\DS . "fileManagerView.php" ;
        $this->view = new fileManagerView ;
        parent::__construct() ;
    }



    public function getUploadForm()
    {
        $mode   = 'new' ;
        $fileId = '' ;
        if ( $this->request->getParam('mode') == 'update' )
        {
            $mode   = 'update' ;
            $fileId = $this->request->getParam('fileId') ;
            if ( ! $fileId )
            {
                \f\ifm::app()->end('In the update mode, file id is required !') ;
            }
        }

        return $this->response(array (
                    'content' => $this->view->uploadForm($this->request)
                )) ;
    }
     public function submit()
    {
        $param=  $this->request->getAssocParams ();
        $uploadResult = \f\ttt::service('core.fileManager.upload',
                                        $this->request) ;

      //  \f\pre($uploadResult);
        $output = $uploadResult[ 'stateCode' ] ;
        
       
        //\f\pre($param);
        if ( $output[ 'result' ] == 'success' )
        {
             //\f\pre($param);
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
        //\f\pre($output['params']);
       
        return $this->response($output) ;
    }

 

}
