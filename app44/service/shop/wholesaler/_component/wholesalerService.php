<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \shop\wholesaler
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class wholesalerService extends \f\service
{

    /**
     *
     * @var shortcutMapper 
     */
    private $mapper ;

    public function __construct ()
    {
        $this->mapper = \f\dalFactory::make ( 'shop.wholesaler' ) ;
    }

    public function wholesalerList ()
    {
        return \f\ttt::dal ( 'shop.wholesaler.wholesalerList',
                             $this->request->getAssocParams () ) ;
    }

    public function wholesalerSave ()
    {
        $params = $this->request->getAssocParams () ;
        if ( $params[ 'id' ] )
        {
            $result = \f\ttt::dal ( 'shop.wholesaler.wholesalerSaveEdit', $params ) ;
            $msg    = \f\ifm::t ( 'wholesalerSaveEdit' ) ;
            $reset  = FALSE ;
        }
        else
        {
            $result = \f\ttt::dal ( 'shop.wholesaler.wholesalerSave', $params ) ;
            $msg    = \f\ifm::t ( 'wholesalerSave' ) ;
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

    public function wholesalerDelete ()
    {
        return \f\ttt::dal ( 'shop.wholesaler.wholesalerDelete',
                             $this->request->getAssocParams () ) ;
    }

    public function WholesalerStatus ()
    {
        return \f\ttt::dal ( 'shop.wholesaler.WholesalerStatus',
                             $this->request->getAssocParams () ) ;
    }

    public function getWholesalerById ()
    {
        return \f\ttt::dal ( 'shop.wholesaler.getWholesalerById',
                             $this->request->getAssocParams () ) ;
    }
    public function getWholesalerByOwnerId ()
    {
        return \f\ttt::dal ( 'shop.wholesaler.getWholesalerByOwnerId',
                             $this->request->getAssocParams () ) ;
    }

}