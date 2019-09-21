<?php
class productController extends \f\controller
{

    /**
     *
     * @var \f\slideView
     */
    private $view ;

    public function __construct ()
    {
        require_once 'productView.php' ;
        $this->view = new productView ;
        parent::__construct () ;
    }

    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.product.index',
                    'content'    => $this->view->renderGrid ()
                ) ) ;
    }

    public function productList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderProductGrid ( $requestDataTble ) ) ;
    }

    public function productAdd ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.product.productAdd',
                    'content'    => $this->view->renderProductAdd ()
                ) ) ;
    }

    public function productSave ()
    {
        $pr = $this->request->getAssocParams ();
        return $this->response ( \f\ttt::service ( 'shop.product.productSave',
                                                   $this->request->getAssocParams () ) ) ;
    }
    public function productEdit ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.product.productEdit',
                    'content'    => $this->view->renderProductAdd ( $this->request->getParam ( 0 ) )
                ) ) ;
    }

    public function productDelete ()
    {
        return $this->response ( \f\ttt::service ( 'shop.product.productDelete',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function productStatus ()
    {
        return $this->response ( \f\ttt::service ( 'shop.product.productStatus',
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
        $loadFeature=$this->view->renderLoadFeature ($this->request->getAssocParams () );
       //\f\pre($loadFeature);
        $params=$this->request->getAssocParams ();


        return $this->response ( array ( 'content' => $loadFeature) ) ;
    }
    public function productSpecial ()
    {
        return $this->response ( \f\ttt::service ( 'shop.product.productSpecial',
                                                   $this->request->getAssocParams () ) ) ;
    }
   
    

}
