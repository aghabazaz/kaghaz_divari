<?php

class materialController extends \f\controller
{

    /**
     *
     * @var \f\slideView
     */
    private $view ;

    public function __construct ()
    {
        require_once 'materialView.php';
        $this->view = new materialView ;
        parent::__construct () ;
    }

    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.material.index',
                    'content'    => $this->view->renderGrid ()
                ) ) ;
    }

    public function materialList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderMaterialGrid ( $requestDataTble ) ) ;
    }

    public function materialAdd ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.material.materialAdd',
                    'content'    => $this->view->renderGuaranteeAdd ()
                ) ) ;
    }

    public function materialSave ()
    {
        return $this->response ( \f\ttt::service ( 'shop.material.materialSave',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function materialEdit ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.material.materialEdit',
                    'content'    => $this->view->renderGuaranteeAdd ( $this->request->getParam ( 0 ) )
                ) ) ;
    }

    public function materialDelete ()
    {
        return $this->response ( \f\ttt::service ( 'shop.material.materialDelete',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function materialStatus ()
    {
        return $this->response ( \f\ttt::service ( 'shop.material.materialStatus',
                                                   $this->request->getAssocParams () ) ) ;
    }

}
