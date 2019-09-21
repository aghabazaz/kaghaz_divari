<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \chartex\crm\marketing\slide
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class transportationService extends \f\service
{

    /**
     *
     * @var shortcutMapper 
     */
    private $mapper ;

    public function __construct ()
    {
        $this->mapper = \f\dalFactory::make ( 'shop.transportation' ) ;
    }

    public function transportationList ()
    {
        return \f\ttt::dal ( 'shop.transportation.transportationList',
                             $this->request->getAssocParams () ) ;
    }

    public function transportationSave ()
    {
        $params = $this->request->getAssocParams () ;
        if ( $params[ 'id' ] )
        {
            $result = \f\ttt::dal ( 'shop.transportation.transportationSaveEdit',
                                    $params ) ;
            $msg    = \f\ifm::t ( 'transportationSaveEdit' ) ;
            $reset  = FALSE ;
        }
        else
        {
            $result = \f\ttt::dal ( 'shop.transportation.transportationSave',
                                    $params ) ;
            $msg    = \f\ifm::t ( 'transportationSave' ) ;
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

    public function transportationDelete ()
    {
        return \f\ttt::dal ( 'shop.transportation.transportationDelete',
                             $this->request->getAssocParams () ) ;
    }

    public function transportationStatus ()
    {
        return \f\ttt::dal ( 'shop.transportation.transportationStatus',
                             $this->request->getAssocParams () ) ;
    }

    public function getTransportationById ()
    {
        return \f\ttt::dal ( 'shop.transportation.getTransportationById',
                             $this->request->getAssocParams () ) ;
    }

    public function getTransportationByParam ()
    {
        return \f\ttt::dal ( 'shop.transportation.getTransportationByParam',
                             $this->request->getAssocParams () ) ;
    }

}
