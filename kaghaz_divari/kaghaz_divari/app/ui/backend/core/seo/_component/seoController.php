<?php

class seoController extends \f\controller
{

    /**
     *
     * @var seoView
     */
    private $view ;

    public function __construct()
    {
        require_once 'seoView.php' ;
        $this->view = new seoView ;
        parent::__construct() ;
    }

    public function index()
    {
        return $this->render(array (
                    'breadcrumb' => 'core.seo.index',
                    'content'    => $this->view->renderDashboard()
                )) ;
    }
    
    public function editParameterDialog()
    {
        $params= $this->request->getAssocParams();
        return $this->response (array('content'=>$this->view->renderEditParameterDialog($params)) );
    }
    public function saveParameter()
    {
        $params= $this->request->getAssocParams();
        return $this->response (\f\ttt::service ('core.seo.saveParameter',$params));
    }

}
