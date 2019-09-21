<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \shop\amazing
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class amazingService extends \f\service
{

    /**
     *
     * @var shortcutMapper 
     */
    private $mapper ;

    public function __construct ()
    {
        $this->mapper = \f\dalFactory::make ( 'shop.amazing' ) ;
    }

    public function amazingList ()
    {
        return \f\ttt::dal ( 'shop.amazing.amazingList',
                             $this->request->getAssocParams () ) ;
    }

    public function amazingSave ()
    {
        $params = $this->request->getAssocParams () ;
        if ( $params[ 'id' ] )
        {
            $result = \f\ttt::dal ( 'shop.amazing.amazingSaveEdit', $params ) ;
            $msg    = \f\ifm::t ( 'amazingSaveEdit' ) ;
            $reset  = FALSE ;
        }
        else
        {
            $result = \f\ttt::dal ( 'shop.amazing.amazingSave', $params ) ;
            $msg    = \f\ifm::t ( 'amazingSave' ) ;
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

    public function amazingDelete ()
    {
        return \f\ttt::dal ( 'shop.amazing.amazingDelete',
                             $this->request->getAssocParams () ) ;
    }

    public function amazingStatus ()
    {
        return \f\ttt::dal ( 'shop.amazing.amazingStatus',
                             $this->request->getAssocParams () ) ;
    }

    public function getAmazingById ()
    {
        return \f\ttt::dal ( 'shop.amazing.getAmazingById',
                             $this->request->getAssocParams () ) ;
    }

    public function getAmazingByOwnerId ()
    {
        return \f\ttt::dal ( 'shop.amazing.getAmazingByOwnerId',
                             $this->request->getAssocParams () ) ;
    }

    public function checkAmazingByProductId ()
    {
        return \f\ttt::dal ( 'shop.amazing.checkAmazingByProductId',
                             $this->request->getAssocParams () ) ;
    }

}
