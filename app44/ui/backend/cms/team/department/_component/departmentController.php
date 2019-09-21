<?php

class departmentController extends \f\controller
{

    /**
     *
     * @var \f\slideView
     */
    private $view ;

    public function __construct ()
    {
        require_once 'departmentView.php' ;
        $this->view = new departmentView ;
        parent::__construct () ;
    }

    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'cms.team.department.index',
                    'content'    => $this->view->renderGrid ()
                ) ) ;
    }

    public function departmentList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderDepartmentGrid ( $requestDataTble ) ) ;
    }

    public function departmentAdd ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'cms.team.department.departmentAdd',
                    'content'    => $this->view->renderDepartmentAdd ()
                ) ) ;
    }

    public function departmentSave ()
    {
        return $this->response ( \f\ttt::service ( 'cms.team.department.departmentSave',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function departmentEdit ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'cms.team.department.departmentEdit',
                    'content'    => $this->view->renderDepartmentAdd ( $this->request->getParam ( 0 ) )
                ) ) ;
    }

    public function departmentDelete ()
    {
        return $this->response ( \f\ttt::service ( 'cms.team.department.departmentDelete',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function departmentStatus ()
    {
        return $this->response ( \f\ttt::service ( 'cms.team.department.departmentStatus',
                                                   $this->request->getAssocParams () ) ) ;
    }

}
