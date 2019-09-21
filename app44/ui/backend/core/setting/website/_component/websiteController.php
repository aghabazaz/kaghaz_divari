<?php

class websiteController extends \f\controller
{

    /**
     *
     * @var \f\websiteView
     */
    private $view ;

    public function __construct()
    {
        require_once 'websiteView.php' ;
        $this->view = new websiteView ;
        parent::__construct() ;
    }
    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'core.setting.website.index',
                    'content'    => $this->view->renderWebsiteSetting (),
                ) ) ;
    }
    public function websiteSettingSave ()
    {
       return $this->response(\f\ttt::service('core.setting.website.websiteSettingSave', $this->request->getAssocParams())) ;
    }

    

}
