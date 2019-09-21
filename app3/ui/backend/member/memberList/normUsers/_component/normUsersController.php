<?php

class normUsersController extends \f\controller
{

    /**
     *
     * @var \f\cmsView
     */
    private $view ;

    public function __construct ()
    {
        require_once 'normUsersView.php';
        $this->view = new normUsersView ;
        parent::__construct () ;
    }

    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'member.memberList.normUsers.index',
                    'content'    => $this->view->renderGrid ()
                ) ) ;
    }

    public function normUsersList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderNormUsersGrid ( $requestDataTble ) ) ;
    }

    public function normUsersAdd ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'member.memberList.normUsers.normUsersAdd',
                    'content'    => $this->view->renderNormUsersAdd ()
        ));
    }

    public function normUsersSave ()
    {
        return $this->response ( \f\ttt::service ( 'member.memberListSave',
            $this->request->getAssocParams () ) ) ;
    }

    public function normUsersEdit ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'member.memberList.normUsers.normUsersEdit',
                    'content'    => $this->view->renderNormUsersAdd ( $this->request->getParam ( 0 ) )
                ) ) ;
    }

    public function normUsersStatus ()
    {
        return $this->response ( \f\ttt::service ( 'member.memberListStatus',
            $this->request->getAssocParams () ) ) ;
    }

    public function normUsersDelete ()
    {
        return $this->response ( \f\ttt::service ( 'member.memberListDelete',
            $this->request->getAssocParams () ) ) ;
    }
}
