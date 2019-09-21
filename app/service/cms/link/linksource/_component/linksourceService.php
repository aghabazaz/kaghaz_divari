<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \chartex\crm\marketing\doctor
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class linksourceService extends \f\service
{

    /**
     *
     * @var shortcutMapper 
     */
    private $mapper ;

    public function __construct ()
    {
        $this->mapper = \f\dalFactory::make ( 'cms.link.linksource' ) ;
    }

    public function getCategoryList ()
    {
        return \f\ttt::dal ( 'cms.link.linksource.getCategoryList' ) ;
    }

    public function linksourceList ()
    {
        return \f\ttt::dal ( 'cms.link.linksource.linksourceList',
                             $this->request->getAssocParams () ) ;
    }

    public function getLinkSourceById ()
    {
        return \f\ttt::dal ( 'cms.link.linksource.getLinkSourceById',
                             $this->request->getAssocParams () ) ;
    }

    public function linksourceSave ()
    {
        $params = $this->request->getAssocParams () ;
        if ( $params[ 'id' ] )
        {
            $result = \f\ttt::dal ( 'cms.link.linksource.linksourceSaveEdit',
                                    $params ) ;
            $msg    = \f\ifm::t ( 'attlinkSaveEdit' ) ;
            $reset  = FALSE ;
        }
        else
        {
            $result = \f\ttt::dal ( 'cms.link.linksource.linksourceSave',
                                    $params ) ;
            $msg    = \f\ifm::t ( 'attlinkSave' ) ;
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

        return $data ;
    }

    public function linksourceDelete ()
    {
        $params = $this->request->getAssocParams () ;
        return \f\ttt::dal ( 'cms.link.linksource.linksourceDelete', $params
                ) ;
    }

    public function linksourceStatus ()
    {
        return \f\ttt::dal ( 'cms.link.linksource.linksourceStatus',
                             $this->request->getAssocParams () ) ;
    }

}