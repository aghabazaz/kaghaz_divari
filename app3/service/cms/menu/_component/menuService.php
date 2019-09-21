<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \chartex\crm\marketing\doctor
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class menuService extends \f\service
{

    /**
     *
     * @var shortcutMapper 
     */
    private $mapper ;

    public function __construct ()
    {
        $this->mapper = \f\dalFactory::make ( 'cms.menu' ) ;
    }

    public function renderTopFooterMenu ()
    {
        return \f\ttt::dal ( 'cms.menu.renderTopFooterMenu',
                             $this->request->getAssocParams ()
                ) ;
    }
    public function renderBottomFooterMenu ()
    {
        return \f\ttt::dal ( 'cms.menu.renderBottomFooterMenu',
                             $this->request->getAssocParams ()
                ) ;
    }

    public function menusectionSave ()
    {
        $params = $this->request->getAssocParams () ;
        if ( $params[ 'id' ] )
        {
            $result = \f\ttt::dal ( 'cms.menu.menusectionSaveEdit', $params ) ;
            $msg    = \f\ifm::t ( 'menusectionSaveEdit' ) ;
            $reset  = FALSE ;
        }
        else
        {
            $result = \f\ttt::dal ( 'cms.menu.menusectionSave', $params ) ;
            $msg    = \f\ifm::t ( 'menusectionSave' ) ;
            $reset  = TRUE ;
        }

        if ( $result )
        {
            $data = array (
                'result'  => 'success',
                'message' => $msg,
                'reset'   => $reset ) ;
        }
        else
        {
            $data = array (
                'result'  => 'error',
                'message' => \f\ifm::t ( 'dbError' ) ) ;
        }

        return $data ;
    }

    public function menusectionList ()
    {
        return \f\ttt::dal ( 'cms.menu.menusectionList',
                             $this->request->getAssocParams () ) ;
    }

    public function getMenuSectionById ()
    {
        return \f\ttt::dal ( 'cms.menu.getMenuSectionById',
                             $this->request->getAssocParams ()
                ) ;
    }

    public function menusectionStatus ()
    {
        return \f\ttt::dal ( 'cms.menu.menusectionStatus',
                             $this->request->getAssocParams () ) ;
    }

    public function menusectionDelete ()
    {
        $params = $this->request->getAssocParams () ;
        return \f\ttt::dal ( 'cms.menu.menusectionDelete', $params
                ) ;
    }

    public function renderMenuBackend ()
    {
        return \f\ttt::dal ( 'cms.menu.renderMenuBackend',
                             $this->request->getAssocParams ()
                ) ;
    }

    public function renderMenuFrontend ()
    {
        return \f\ttt::dal ( 'cms.menu.renderMenuFrontend',
                             $this->request->getAssocParams ()
                ) ;
    }

    public function menuStatus ()
    {
        return \f\ttt::dal ( 'cms.menu.menuStatus',
                             $this->request->getAssocParams () ) ;
    }

    public function menuDelete ()
    {
        $params = $this->request->getAssocParams () ;
        return \f\ttt::dal ( 'cms.menu.menuDelete', $params
                ) ;
    }

    public function getMenuById ()
    {
        return \f\ttt::dal ( 'cms.menu.renderMenuAdd',
                             $this->request->getAssocParams ()
                ) ;
    }

    public function menuSave ()
    {
        $params = $this->request->getAssocParams () ;
        if ( $params[ 'id' ] )
        {
            $result = \f\ttt::dal ( 'cms.menu.menuSaveEdit', $params ) ;
            $msg    = \f\ifm::t ( 'menuSaveEdit' ) ;
            $reset  = FALSE ;
        }
        else
        {
            $result = \f\ttt::dal ( 'cms.menu.menuSave', $params ) ;
            $msg    = \f\ifm::t ( 'menuSave' ) ;
            $reset  = TRUE ;
        }

        if ( $result )
        {
            $data = array (
                'result'  => 'success',
                'message' => $msg,
                'reset'   => $reset ) ;
        }
        else
        {
            $data = array (
                'result'  => 'error',
                'message' => \f\ifm::t ( 'dbError' ) ) ;
        }

        return $data ;
    }

    public function priority ()
    {
        $params = $this->request->getAssocParams () ;
        if ( $params[ 'type' ] == 'Up' )
        {
            return \f\ttt::dal ( 'cms.menu.priorityUp', $params
                    ) ;
        }
        else
        {
            return \f\ttt::dal ( 'cms.menu.priorityDown', $params
                    ) ;
        }
    }

}
