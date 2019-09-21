<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \chartex\crm\marketing\slide
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class brandService extends \f\service
{

    /**
     *
     * @var shortcutMapper 
     */
    private $mapper ;

    public function __construct ()
    {
        $this->mapper = \f\dalFactory::make ( 'shop.brand' ) ;
    }

    public function brandList ()
    {
        return \f\ttt::dal ( 'shop.brand.brandList',
                             $this->request->getAssocParams () ) ;
    }

    public function brandSave ()
    {
        $params = $this->request->getAssocParams () ;
        if ( $params[ 'id' ] )
        {
            $result = \f\ttt::dal ( 'shop.brand.brandSaveEdit', $params ) ;
            $msg    = \f\ifm::t ( 'brandSaveEdit' ) ;
            $reset  = FALSE ;
        }
        else
        {
            $result = \f\ttt::dal ( 'shop.brand.brandSave', $params ) ;
            $msg    = \f\ifm::t ( 'brandSave' ) ;
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

    public function brandDelete ()
    {

        return \f\ttt::dal ( 'shop.brand.brandDelete',
                             $this->request->getAssocParams () ) ;
    }
    public function getBrandListFront ()
    {
        return \f\ttt::dal ( 'shop.brand.getBrandListFront',
                             $this->request->getAssocParams () ) ;
    }

    public function brandStatus ()
    {
        return \f\ttt::dal ( 'shop.brand.brandStatus',
                             $this->request->getAssocParams () ) ;
    }

    public function getBrandById ()
    {
        return \f\ttt::dal ( 'shop.brand.getBrandById',
                             $this->request->getAssocParams () ) ;
    }

    public function getBrandByOwnerId ()
    {
        return \f\ttt::dal ( 'shop.brand.getBrandByOwnerId',
                             $this->request->getAssocParams () ) ;
    }

    public function getBrandsByAjaxSearch ()
    {
        return \f\ttt::dal ( 'shop.brand.getBrandsByAjaxSearch',
                             $this->request->getAssocParams () ) ;
    }

    public function getBrandByParam ()
    {
        return \f\ttt::dal ( 'shop.brand.getBrandByParam',
                             $this->request->getAssocParams () ) ;
    }
    public function checkBrandByProductId ()
    {
        return \f\ttt::dal ( 'shop.brand.checkBrandByProductId',
            $this->request->getAssocParams () ) ;
    }
}
