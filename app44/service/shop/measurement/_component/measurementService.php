<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \chartex\crm\marketing\slide
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class measurementService extends \f\service
{

    /**
     *
     * @var shortcutMapper 
     */
    private $mapper ;

    public function __construct ()
    {
        $this->mapper = \f\dalFactory::make ( 'shop.measurement' ) ;
    }

    public function measurementList ()
    {
        return \f\ttt::dal ( 'shop.measurement.measurementList',
                             $this->request->getAssocParams () ) ;
    }

    public function measurementSave ()
    {
        $params = $this->request->getAssocParams () ;
        if ( $params[ 'id' ] )
        {
            $result = \f\ttt::dal ( 'shop.measurement.measurementSaveEdit', $params ) ;
            $msg    = \f\ifm::t ( 'measurementEdit' ) ;
            $reset  = FALSE ;
        }
        else
        {
            $result = \f\ttt::dal ( 'shop.measurement.measurementSave', $params ) ;
            $msg    = \f\ifm::t ( 'measurementSave' ) ;
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

    public function measurementDelete()
    {
        return \f\ttt::dal ( 'shop.measurement.measurementDelete',
                             $this->request->getAssocParams () ) ;
    }

    public function measurementStatus ()
    {
        return \f\ttt::dal ( 'shop.measurement.measurementStatus',
                             $this->request->getAssocParams () ) ;
    }

    public function getMeasurementId ()
    {
        return \f\ttt::dal ( 'shop.measurement.getMeasurementId',
                             $this->request->getAssocParams () ) ;
    }
}
