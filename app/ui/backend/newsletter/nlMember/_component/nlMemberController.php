<?php

class nlMemberController extends \f\controller
{

    /**
     *
     * @var \f\coreView
     */
    private $view ;

    public function __construct()
    {
        require_once 'nlMemberView.php' ;
        $this->view = new nlMemberView ;
        parent::__construct() ;
    }

    public function index()
    {
        return $this->render(array (
                    'breadcrumb' => 'newsletter.nlMember.index',
                    'content'    => $this->view->rendernlMemberList()
                )) ;
    }
    public function nlMemberAdd ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'newsletter.nlMember.nlMemberAdd',
                    'content'    => $this->view->rendernlMemberAdd ()
                ) ) ;
    }
    
     public function nlMemberSave ()
    {
        $params = $this->request->getAssocParams ();
        return $this->response ( \f\ttt::service ( 'newsletter.newsletterSave',
                                                   $params ) ) ;
    }
    
    public function nlMemberList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->rendernlMemberGrid ( $requestDataTble ) ) ;
    }
    public function nlMemberEdit ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'newsletter.nlMember.nlMemberEdit',
                    'content'    => $this->view->rendernlMemberAdd ( $this->request->getParam ( 0 ) )
                ) ) ;
    }
    
    public function nlMemberDelete ()
    {
        return $this->response ( \f\ttt::service ( 'newsletter.nlMemberDelete',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function nlMemberStatus ()
    {
        return $this->response ( \f\ttt::service ( 'newsletter.nlMemberStatus',
                                                   $this->request->getAssocParams () ) ) ;
    }
    
   
    

}

