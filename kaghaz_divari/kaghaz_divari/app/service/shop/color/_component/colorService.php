<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \chartex\crm\marketing\slide
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class colorService extends \f\service
{

    /**
     *
     * @var shortcutMapper 
     */
    private $mapper ;

    public function __construct ()
    {
        $this->mapper = \f\dalFactory::make ( 'shop.color' ) ;
    }

    public function colorList ()
    {
        return \f\ttt::dal ( 'shop.color.colorList',
                             $this->request->getAssocParams () ) ;
    }

    public function colorSave ()
    {
        $params = $this->request->getAssocParams () ;
        if ( $params[ 'id' ] )
        {
            $result = \f\ttt::dal ( 'shop.color.colorSaveEdit', $params ) ;
            $msg    = \f\ifm::t ( 'colorSaveEdit' ) ;
            $reset  = FALSE ;
        }
        else
        {
            $result = \f\ttt::dal ( 'shop.color.colorSave', $params ) ;
            $msg    = \f\ifm::t ( 'colorSave' ) ;
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

    public function colorDelete ()
    {
        return \f\ttt::dal ( 'shop.color.colorDelete',
                             $this->request->getAssocParams () ) ;
    }

    public function colorStatus ()
    {
        return \f\ttt::dal ( 'shop.color.colorStatus',
                             $this->request->getAssocParams () ) ;
    }

    public function getColorById ()
    {
        return \f\ttt::dal ( 'shop.color.getColorById',
                             $this->request->getAssocParams () ) ;
    }

    public function getColorByOwnerId ()
    {
        return \f\ttt::dal ( 'shop.color.getColorByOwnerId',
                             $this->request->getAssocParams () ) ;
    }

    public function getColorsByParam ()
    {
        return \f\ttt::dal ( 'shop.color.getColorsByParam',
                             $this->request->getAssocParams () ) ;
    }
    
    public function getColorsGuranteeByProductId ()
    {
        return \f\ttt::dal ( 'shop.color.getColorsGuranteeByProductId',
                             $this->request->getAssocParams () ) ;
    }
      public function getColorsGuranteeByProductIdWidthoutPrice ()
    {
        return \f\ttt::dal ( 'shop.color.getColorsGuranteeByProductIdWidthoutPrice',
                             $this->request->getAssocParams () ) ;
    }
}
