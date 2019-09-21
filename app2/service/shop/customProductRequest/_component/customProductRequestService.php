<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \shop\wiki
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class customProductRequestService extends \f\service
{

    /**
     *
     * @var shortcutMapper 
     */
    private $mapper ;

    public function __construct ()
    {
        $this->mapper = \f\dalFactory::make ( 'shop.customProductRequest' ) ;
    }

    public function customProductRequestList ()
    {
        return \f\ttt::dal ( 'shop.customProductRequest.customProductRequestList',
                             $this->request->getAssocParams () ) ;
    }

    public function customProductRequestSave ()
    {
        $params = $this->request->getAssocParams () ;
        if ( $params[ 'id' ] )
        {
            $result = \f\ttt::dal ( 'shop.customProductRequest.customProductRequestSaveEdit', $params ) ;
            $msg    = \f\ifm::t ( 'customProductRequestSaveEdit' ) ;
            $reset  = FALSE ;
        }
        else
        {
            $result = \f\ttt::dal ( 'shop.customProductRequest.customProductRequestSave', $params ) ;
            $msg    = \f\ifm::t ( 'customProductRequestSave' ) ;
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

    public function sendCustomProductRequest(){
        return \f\ttt::dal ( 'shop.customProductRequest.sendCustomProductRequest',
            $this->request->getAssocParams () ) ;
    }

    public function customProductRequestDelete ()
    {
        return \f\ttt::dal ( 'shop.customProductRequest.customProductRequestDelete',
                             $this->request->getAssocParams () ) ;
    }

    public function customProductRequestStatus ()
    {
        return \f\ttt::dal ( 'shop.customProductRequest.wikiStatus',
                             $this->request->getAssocParams () ) ;
    }

    public function getCustomProductRequestById ()
    {
        return \f\ttt::dal ( 'shop.customProductRequest.getCustomProductRequestById',
                             $this->request->getAssocParams () ) ;
    }

    public function getCustomeProductRequestByOwnerId ()
    {
        return \f\ttt::dal ( 'shop.customProductRequest.getCustomProductRequestByOwnerId',
                             $this->request->getAssocParams () ) ;
    }

}