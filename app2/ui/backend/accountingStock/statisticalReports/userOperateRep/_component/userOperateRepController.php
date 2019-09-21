<?php

class userOperateRepController extends \f\controller
{

    /**
     *
     * @var \f\cmsView
     */
    private $view ;

    public function __construct ()
    {
        require_once 'userOperateRepView.php';
        $this->view = new userOperateRepView ;
        parent::__construct () ;
    }

    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'accountingStock.statisticalReports.userOperateRep.index',
                    'content'    => $this->view->renderGrid ()
                ) ) ;
    }

    public function userOperateList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
      //  \f\pre($requestDataTble);
            return $this->response ( $this->view->renderUserOperateGrid ( $requestDataTble ) ) ;

    }
    public function userOperateList2 ()
    {
        $params=$this->request->getNonAssocParams() ;
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderUserOperateGrid2 ( $requestDataTble,$params ) ) ;
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
