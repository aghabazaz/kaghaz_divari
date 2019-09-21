<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \cms.team\personnel
 * @personnel component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class personnelService extends \f\service
{

    /**
     *
     * @var shortcutMapper 
     */
    private $mapper ;

    public function __construct ()
    {
        $this->mapper = \f\dalFactory::make ( 'cms.team.personnel' ) ;
    }

    public function personnelList ()
    {
        return \f\ttt::dal ( 'cms.team.personnel.personnelList',
                             $this->request->getAssocParams () ) ;
    }

    public function personnelSave ()
    {
        $params = $this->request->getAssocParams () ;

        if ( $params[ 'id' ] )
        {
            $result = \f\ttt::dal ( 'cms.team.personnel.personnelSaveEdit',
                                    $params ) ;
            $msg    = \f\ifm::t ( 'personnelSaveEdit' ) ;
            $reset  = FALSE ;
        }
        else
        {
            $result = \f\ttt::dal ( 'cms.team.personnel.personnelSave', $params ) ;
            $msg    = \f\ifm::t ( 'personnelSave' ) ;
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

    public function personnelDelete ()
    {
        return \f\ttt::dal ( 'cms.team.personnel.personnelDelete',
                             $this->request->getAssocParams () ) ;
    }

    public function personnelStatus ()
    {
        return \f\ttt::dal ( 'cms.team.personnel.personnelStatus',
                             $this->request->getAssocParams () ) ;
    }

    public function getPersonnelById ()
    {
        return \f\ttt::dal ( 'cms.team.personnel.getPersonnelById',
                             $this->request->getAssocParams () ) ;
    }

    public function getPersonnelByOwnerId ()
    {
        return \f\ttt::dal ( 'cms.team.personnel.getPersonnelByOwnerId',
                             $this->request->getAssocParams () ) ;
    }

    public function getPersonnelByParam ()
    {
        return \f\ttt::dal ( 'cms.team.personnel.getPersonnelByParam',
                             $this->request->getAssocParams () ) ;
    }

    public function personnelSpecial ()
    {
        return \f\ttt::dal ( 'cms.team.personnel.personnelSpecial',
                             $this->request->getAssocParams () ) ;
    }

    public function getProduct ()
    {
        return \f\ttt::dal ( 'cms.team.personnel.getProduct',
                             $this->request->getAssocParams () ) ;
    }

    public function setProductVisit ()
    {
        return \f\ttt::dal ( 'cms.team.personnel.setProductVisit',
                             $this->request->getAssocParams () ) ;
    }

}
