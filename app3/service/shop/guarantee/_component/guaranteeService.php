<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \chartex\crm\marketing\slide
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class guaranteeService extends \f\service
{

    /**
     *
     * @var shortcutMapper 
     */
    private $mapper ;

    public function __construct ()
    {
        $this->mapper = \f\dalFactory::make ( 'shop.guarantee' ) ;
    }

    public function guaranteeList ()
    {
        return \f\ttt::dal ( 'shop.guarantee.guaranteeList',
                             $this->request->getAssocParams () ) ;
    }

    public function guaranteeSave ()
    {
        $params = $this->request->getAssocParams () ;
        if ( $params[ 'id' ] )
        {
            $result = \f\ttt::dal ( 'shop.guarantee.guaranteeSaveEdit', $params ) ;
            $msg    = \f\ifm::t ( 'guaranteeSaveEdit' ) ;
            $reset  = FALSE ;
        }
        else
        {
            $result = \f\ttt::dal ( 'shop.guarantee.guaranteeSave', $params ) ;
            $msg    = \f\ifm::t ( 'guaranteeSave' ) ;
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

    public function guaranteeDelete ()
    {
        return \f\ttt::dal ( 'shop.guarantee.guaranteeDelete',
                             $this->request->getAssocParams () ) ;
    }

    public function guaranteeStatus ()
    {
        return \f\ttt::dal ( 'shop.guarantee.guaranteeStatus',
                             $this->request->getAssocParams () ) ;
    }

    public function getGuaranteeById ()
    {
        return \f\ttt::dal ( 'shop.guarantee.getGuaranteeById',
                             $this->request->getAssocParams () ) ;
    }
    public function getGuaranteeByOwnerId ()
    {
        return \f\ttt::dal ( 'shop.guarantee.getGuaranteeByOwnerId',
                             $this->request->getAssocParams () ) ;
    }

}