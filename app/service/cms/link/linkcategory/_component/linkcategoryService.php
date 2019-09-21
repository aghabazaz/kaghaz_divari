<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \chartex\crm\marketing\doctor
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class linkcategoryService extends \f\service
{

    /**
     *
     * @var shortcutMapper 
     */
    private $mapper ;

    public function __construct ()
    {
        $this->mapper = \f\dalFactory::make ( 'cms.link.linkcategory' ) ;
    }

    public function linkcategoryList ()
    {
        return \f\ttt::dal ( 'cms.link.linkcategory.linkcategoryList',
                             $this->request->getAssocParams () ) ;
    }

    public function linkcategoryDelete ()
    {
        $params = $this->request->getAssocParams () ;


        return \f\ttt::dal ( 'cms.link.linkcategory.linkcategoryDelete', $params
                ) ;
    }

    public function linkcategoryStatus ()
    {
        return \f\ttt::dal ( 'cms.link.linkcategory.linkcategoryStatus',
                             $this->request->getAssocParams () ) ;
    }

    public function linkcategorySave ()
    {
        $params = $this->request->getAssocParams () ;
        if ( $params[ 'id' ] )
        {
            $result = \f\ttt::dal ( 'cms.link.linkcategory.linkcategorySaveEdit',
                                    $params ) ;
            $msg    = \f\ifm::t ( 'attactSaveEdit' ) ;
            $reset  = FALSE ;
        }
        else
        {
            $result = \f\ttt::dal ( 'cms.link.linkcategory.linkcategorySave',
                                    $params ) ;
            $msg    = \f\ifm::t ( 'attactSave' ) ;
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

    public function getLinkCategoryById ()
    {
        return \f\ttt::dal ( 'cms.link.linkcategory.getLinkCategoryById',
                             $this->request->getAssocParams () ) ;
    }

}