<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \chartex\crm\marketing\slide
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class makerService extends \f\service
{

    /**
     *
     * @var shortcutMapper 
     */
    private $mapper ;

    public function __construct ()
    {
        $this->mapper = \f\dalFactory::make ( 'shop.maker' ) ;
    }

    public function makerList ()
    {
        return \f\ttt::dal ( 'shop.maker.makerList',
                             $this->request->getAssocParams () ) ;
    }

    public function makerSave ()
    {
        $params = $this->request->getAssocParams () ;
        if ( $params[ 'id' ] )
        {
            $result = \f\ttt::dal ( 'shop.maker.makerSaveEdit', $params ) ;
            $msg    = \f\ifm::t ( 'makerSaveEdit' ) ;
            $reset  = FALSE ;
        }
        else
        {
            $result = \f\ttt::dal ( 'shop.maker.makerSave', $params ) ;
            $msg    = \f\ifm::t ( 'makerSave' ) ;
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

    public function makerDelete ()
    {

        return \f\ttt::dal ( 'shop.maker.makerDelete',
                             $this->request->getAssocParams () ) ;
    }
    public function getMakerListFront ()
    {
        return \f\ttt::dal ( 'shop.maker.getMakerListFront',
                             $this->request->getAssocParams () ) ;
    }

    public function makerStatus ()
    {
        return \f\ttt::dal ( 'shop.maker.makerStatus',
                             $this->request->getAssocParams () ) ;
    }

    public function getMakerById ()
    {
        return \f\ttt::dal ( 'shop.maker.getMakerById',
                             $this->request->getAssocParams () ) ;
    }

    public function getMakerByOwnerId ()
    {
        return \f\ttt::dal ( 'shop.maker.getMakerByOwnerId',
                             $this->request->getAssocParams () ) ;
    }

    public function getMakersByAjaxSearch ()
    {
        return \f\ttt::dal ( 'shop.maker.getMakersByAjaxSearch',
                             $this->request->getAssocParams () ) ;
    }

    public function getMakerByParam ()
    {
        return \f\ttt::dal ( 'shop.maker.getMakerByParam',
                             $this->request->getAssocParams () ) ;
    }

}
