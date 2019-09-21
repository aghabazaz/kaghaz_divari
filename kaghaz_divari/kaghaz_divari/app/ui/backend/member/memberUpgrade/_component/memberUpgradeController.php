<?php

class memberUpgradeController extends \f\controller
{

    /**
     *
     * @var \f\cmsView
     */
    private $view ;

    public function __construct ()
    {
        require_once 'memberUpgradeView.php';
        $this->view = new memberUpgradeView ;
        parent::__construct () ;
    }

    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'member.memberUpgrade.index',
                    'content'    => $this->view->renderGrid ()
                ) ) ;
    }

    public function memberUpgradeList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderMemberUpgradeGrid ( $requestDataTble ) ) ;
    }

    public function memberUpgradeAdd ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'member.memberUpgrade.memberUpgradeAdd',
                    'content'    => $this->view->renderMemberUpgradeAdd ()
        ));
    }

    public function memberUpgradeSave ()
    {
        $params=$this->request->getAssocParams ();
       // \f\pre($params);
        if ( $params[ 'id' ] )
        {
            if($params['confirmation']=='yes'){
                $msg    = \f\ifm::t ( 'confirmationUpgradeUser' ) ;
            }else if($params['confirmation']=='no'){
                $msg    = \f\ifm::t ( 'cancelUpgradeUser' ) ;
            }else{
                $msg    = \f\ifm::t ( 'memberUpgradeSaveEdit' ) ;
            }
            $result=\f\ttt::dal ( 'member.memberUpgrade.memberUpgradeSaveEdit',
                $this->request->getAssocParams () );
            $reset  = FALSE ;
        }
        else
        {
            $result=\f\ttt::dal ( 'member.memberUpgrade.memberUpgradeSave',
                $this->request->getAssocParams () );
            if($params['confirmation']=='yes'){
                $msg    = \f\ifm::t ( 'confirmationUpgradeUser' ) ;
            }else if($params['confirmation']=='no'){
                $msg    = \f\ifm::t ( 'cancelUpgradeUser' ) ;
            }else{
                $msg    = \f\ifm::t ( 'memberUpgradeSave' ) ;
            }
            //$msg    = \f\ifm::t ( 'memberUpgradeSave' ) ;
            $reset  = TRUE ;
        }

        if ( $result )
        {
            $data = array ( 'result'  => 'success', 'message' => $msg, 'reset'   => $reset ) ;
        }
        else
        {
            $data = array ( 'result'  => 'error', 'message' => \f\ifm::t ( 'dbError' ) ) ;
        }



        return $this->response (  $data ) ;
    }

    public function memberUpgradeEdit ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'member.memberUpgrade.memberUpgradeEdit',
                    'content'    => $this->view->renderMemberUpgradeAdd ( $this->request->getParam ( 0 ) )
                ) ) ;
    }

    public function memberUpgradeStatus ()
    {
        return $this->response ( \f\ttt::dal ( 'member.memberUpgrade.memberUpgradeStatus',
            $this->request->getAssocParams () ) ) ;
    }

    public function memberUpgradeDelete ()
    {
        return $this->response ( \f\ttt::dal ( 'member.memberUpgrade.memberUpgradeDelete',
            $this->request->getAssocParams () ) ) ;
    }
}
