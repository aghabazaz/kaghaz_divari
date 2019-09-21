<?php

class socialnetController extends \f\controller
{

    /**
     *
     * @var \f\slideView
     */
    private $view ;

    public function __construct()
    {
        require_once 'socialnetView.php' ;
        $this->view = new socialnetView ;
        parent::__construct() ;
    }

      public function index()
    {
          //\f\pre("hiii");
        return $this->render(array (
                    'breadcrumb' => 'cms.socialnet.index',
                    'content'    => $this->view->renderGrid()
                )) ;
    }
    
    public function SocialnetSettingSave ()
    {
       return $this->response(\f\ttt::service('cms.socialnet.SocialnetSettingSave', $this->request->getAssocParams())) ;
    }
    
//    public function socialnetform ()
//    {
        
//                return $this->render ( array (
//                    'breadcrumb' => 'core.setting.website.index',
//                    'content'    => $this->view->renderWebsiteSetting (),
//                ) ) ;
        
        
        
        
        
//        $requestDataTble = $this->request->getAssocParams () ;
//       // \f\pre($requestDataTble);
//        return $this->response ( $this->view->renderMenuGrid ( $requestDataTble ) ) ;
//    }
    
    
//    public function menuStatus ()
//    {
//        return $this->response ( \f\ttt::service ( 'cms.menu.menuStatus',
//                                                   $this->request->getAssocParams () ) ) ;
//    }
//    
//    public function menuDelete ()
//    {
//        return $this->response ( \f\ttt::service ( 'cms.menu.menuDelete',
//                                                   $this->request->getAssocParams () ) ) ;
//    }

//    public function menuAdd ()
//    {
//        return $this->render ( array (
//                    'breadcrumb' => 'cms.menu.menuAdd',
//                    'content'    => $this->view->renderMenuAdd ()
//                ) ) ;
//    }
    
//    public function menuEdit ()
//    {
//        return $this->render ( array (
//                    'breadcrumb' => 'cms.menu.menuEdit',
//                    'content'    => $this->view->renderMenuAdd ( $this->request->getParam ( 0 ) )
//                ) ) ;
//    }

//    public function menuSave ()
//    {
//        $param  = $this->request->getAssocParams () ;    
//        if($param['link'])
//            
//        if (strpos($param['link'], 'https://') === false && strpos($param['link'], 'http://') === false) 
//        {
//            $param['link']='http://'.$param['link'];
//        }
//        return $this->response ( \f\ttt::service ( 'cms.menu.menuSave',
//                                                   $param) ) ;
//    }
     





}
