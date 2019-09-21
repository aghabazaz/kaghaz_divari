<?php

class menuController extends \f\controller
{

    /**
     *
     * @var \f\slideView
     */
    private $view ;

    public function __construct ()
    {
        require_once 'menuView.php' ;
        $this->view = new menuView ;
        parent::__construct () ;
    }

    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'cms.menu.index',
                    'content'    => $this->view->renderGrid ()
                ) ) ;
    }

    public function menusectionList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderMenuSectionGrid ( $requestDataTble ) ) ;
    }

    public function menusectionAdd ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'cms.menu.menusectionAdd',
                    'content'    => $this->view->renderMenuSectionAdd ()
                ) ) ;
    }

    public function menusectionSave ()
    {
        return $this->response ( \f\ttt::service ( 'cms.menu.menusectionSave',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function menusectionEdit ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'cms.menu.menusectionEdit',
                    'content'    => $this->view->renderMenuSectionAdd ( $this->request->getParam ( 0 ) )
                ) ) ;
    }

    public function menusectionDelete ()
    {
        return $this->response ( \f\ttt::service ( 'cms.menu.menusectionDelete',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function menusectionStatus ()
    {
        return $this->response ( \f\ttt::service ( 'cms.menu.menusectionStatus',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function menutitle ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'cms.menu.menutitle',
                    'content'    => $this->view->renderMenuTitleGrid ( $this->request->getParam ( 0 ) )
                ) ) ;
    }

    public function menuAdd ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'cms.menu.menuAdd',
                    'content'    => $this->view->renderMenuAdd ( $this->request->getParam ( 0 ) )
                ) ) ;
    }

    public function menuEdit ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'cms.menu.menuEdit',
                    'content'    => $this->view->renderMenuEdit ( $this->request->getParam ( 0 ) )
                ) ) ;
    }

    public function menuSave ()
    {
        $param = $this->request->getAssocParams () ;
        if ( $param[ 'link' ] && strpos ( $param[ 'link' ], '.' ))
        {
            if ( strpos ( $param[ 'link' ], 'https://' ) === false && strpos ( $param[ 'link' ],
                                                                               'http://' ) === false )
            {
                $param[ 'link' ] = 'http://' . $param[ 'link' ] ;
            }
        }

        return $this->response ( \f\ttt::service ( 'cms.menu.menuSave', $param ) ) ;
    }

    public function menuStatus ()
    {
        return $this->response ( \f\ttt::service ( 'cms.menu.menuStatus',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function menuDelete ()
    {
        return $this->response ( \f\ttt::service ( 'cms.menu.menuDelete',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function priority ()
    {
        $result = \f\ttt::service ( 'cms.menu.priority',
                                    $this->request->getAssocParams () ) ;
        if ( $result[ 'result' ] == 'failed' )
        {
            if ( $result[ 'type' ] == 'Up' )
            {
                $result[ 'message' ] = "منوی انتخابی شما دارای بالاترین اولویت می باشد!!" ;
            }
            else
            {
                $result[ 'message' ] = "منوی انتخابی شما دارای کم ترین اولویت می باشد!!" ;
            }
        }
        elseif ( $result[ 'result' ] == 'success' )
        {
            
        }
        return $this->response ( $result ) ;
    }

}
