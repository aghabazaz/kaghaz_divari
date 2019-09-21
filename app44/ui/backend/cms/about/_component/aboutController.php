<?php

class aboutController extends \f\controller
{

    /**
     *
     * @var \f\aboutView
     */
    private $view ;

    public function __construct()
    {
        require_once 'aboutView.php' ;
        $this->view = new aboutView ;
        parent::__construct() ;
    }
    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'cms.about.index',
                    'content'    => $this->view->renderAboutSetting (),
                ) ) ;
    }
    public function aboutSettingSave ()
    {
       return $this->response(\f\ttt::service('cms.about.aboutSettingSave', $this->request->getAssocParams())) ;
    }

    

}
