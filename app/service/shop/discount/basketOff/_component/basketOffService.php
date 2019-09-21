<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \chartex\crm\marketing\slide
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class basketOffService extends \f\service
{

    /**
     *
     * @var shortcutMapper 
     */
    private $mapper ;

    public function __construct ()
    {
        $this->mapper = \f\dalFactory::make ( 'shop.discount.basketOff' ) ;
    }

    public function basketOffList ()
    {
        return \f\ttt::dal ( 'shop.discount.basketOff.basketOffList',
                             $this->request->getAssocParams () ) ;
    }

    public function basketOffSave ()
    {
        $params = $this->request->getAssocParams () ;
        if ( $params[ 'id' ] )
        {
            $result = \f\ttt::dal ( 'shop.discount.basketOff.basketOffSaveEdit', $params ) ;
            $msg    = \f\ifm::t ( 'basketOffSaveEdit' ) ;
            $reset  = FALSE ;
        }
        else
        {
            $result = \f\ttt::dal ( 'shop.discount.basketOff.basketOffSave', $params ) ;
            $msg    = \f\ifm::t ( 'basketOffSave' ) ;
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

    public function basketOffDelete()
    {
        return \f\ttt::dal ( 'shop.discount.basketOff.basketOffDelete',
                             $this->request->getAssocParams () ) ;
    }

    public function basketOffStatus ()
    {
        return \f\ttt::dal ( 'shop.discount.basketOff.basketOffStatus',
                             $this->request->getAssocParams () ) ;
    }

    public function getBasketOffId ()
    {
        return \f\ttt::dal ( 'shop.discount.basketOff.getBasketOffId',
                             $this->request->getAssocParams () ) ;
    }
}
