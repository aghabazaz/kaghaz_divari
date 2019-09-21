<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \shop\colleague
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class colleagueService extends \f\service
{

    /**
     *
     * @var shortcutMapper 
     */
    private $mapper ;

    public function __construct ()
    {
        $this->mapper = \f\dalFactory::make ( 'shop.colleague' ) ;
    }

    public function colleagueList ()
    {
        return \f\ttt::dal ( 'shop.colleague.colleagueList',
                             $this->request->getAssocParams () ) ;
    }

    public function colleagueSave ()
    {
        $params = $this->request->getAssocParams () ;
        if ( $params[ 'id' ] )
        {
            $result = \f\ttt::dal ( 'shop.colleague.colleagueSaveEdit', $params ) ;
            $msg    = \f\ifm::t ( 'colleagueSaveEdit' ) ;
            $reset  = FALSE ;
        }
        else
        {
            $result = \f\ttt::dal ( 'shop.colleague.colleagueSave', $params ) ;
            $msg    = \f\ifm::t ( 'colleagueSave' ) ;
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

    public function colleagueDelete ()
    {
        return \f\ttt::dal ( 'shop.colleague.colleagueDelete',
                             $this->request->getAssocParams () ) ;
    }

    public function colleagueStatus ()
    {
        return \f\ttt::dal ( 'shop.colleague.colleagueStatus',
                             $this->request->getAssocParams () ) ;
    }

    public function getColleagueById ()
    {
        return \f\ttt::dal ( 'shop.colleague.getColleagueById',
                             $this->request->getAssocParams () ) ;
    }
    public function getColleagueByOwnerId ()
    {
        return \f\ttt::dal ( 'shop.colleague.getColleagueByOwnerId',
                             $this->request->getAssocParams () ) ;
    }

}