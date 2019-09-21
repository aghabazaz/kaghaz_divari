<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \chartex\crm\marketing\slide
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class discountCodeService extends \f\service
{

    /**
     *
     * @var shortcutMapper 
     */
    private $mapper ;

    public function __construct ()
    {
        $this->mapper = \f\dalFactory::make ( 'shop.discount.discountCode' ) ;
    }

    public function discountCodeList ()
    {
        return \f\ttt::dal ( 'shop.discount.discountCode.discountCodeList',
                             $this->request->getAssocParams () ) ;
    }

    public function discountCodeSave ()
    {
        $params = $this->request->getAssocParams () ;
        if ( $params[ 'id' ] )
        {
            $result = \f\ttt::dal ( 'shop.discount.discountCode.discountCodeSaveEdit', $params ) ;
            $msg    = \f\ifm::t ( 'discountCodeSaveEdit' ) ;
            $reset  = FALSE ;
        }
        else
        {
            $result = \f\ttt::dal ( 'shop.discount.discountCode.discountCodeSave', $params ) ;
            $msg    = \f\ifm::t ( 'discountCodeSave' ) ;
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

    public function discountCodeDelete()
    {
        return \f\ttt::dal ( 'shop.discount.discountCode.discountCodeDelete',
                             $this->request->getAssocParams () ) ;
    }

    public function discountCodeStatus ()
    {
        return \f\ttt::dal ( 'shop.discount.discountCode.discountCodeStatus',
                             $this->request->getAssocParams () ) ;
    }

    public function getDiscountCodeId ()
    {
        return \f\ttt::dal ( 'shop.discount.discountCode.getDiscountCodeId',
                             $this->request->getAssocParams () ) ;
    }
}
