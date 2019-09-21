<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \shop\ratingOptions
 * @ratingOptions component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class ratingOptionsService extends \f\service
{

    /**
     *
     * @var shortcutMapper 
     */
    private $mapper ;

    public function __construct ()
    {
        $this->mapper = \f\dalFactory::make ( 'shop.ratingOptions' ) ;
    }

    public function ratingOptionsList ()
    {
        return \f\ttt::dal ( 'shop.ratingOptions.ratingOptionsList',
                             $this->request->getAssocParams () ) ;
    }

    public function saveRatingOptionsScore ()
    {
        $params      = $this->request->getAssocParams () ;
        $checkRepeat = \f\ttt::dal ( 'shop.ratingOptions.checkRatingOptionsByProductUserId',
                                     $params ) ;
        if ( ! $checkRepeat )
        {
            $result = \f\ttt::dal ( 'shop.ratingOptions.saveRatingOptionsScore',
                                    $params ) ;
        }
        else
        {
            return array (
                'result'  => 'error',
                'message' => \f\ifm::t ( 'repeatRate' )
                    ) ;
        }

        if ( $result )
        {
            $avg = \f\ttt::dal ( 'shop.ratingOptions.getAVGRatingOptionByProductId',
                                 $params ) ;
            \f\ttt::dal ( 'shop.product.updateAvgCountRate',
                          array (
                'id'         => $params[ 'product_id' ],
                'rate_avg'   => round ( $avg[ 'rate_avg' ], 1 ),
                'rate_count' => '+1'
            ) ) ;
            return array (
                'result'  => 'success',
                'message' => \f\ifm::t ( 'rateSave' )
                    ) ;
        }
        else
        {
            return array (
                'result'  => 'error',
                'message' => \f\ifm::t ( 'dbError' )
                    ) ;
        }
    }

    public function getRatingOptionsById ()
    {
        return \f\ttt::dal ( 'shop.ratingOptions.getRatingOptionsById',
                             $this->request->getAssocParams () ) ;
    }

    public function getRatingTitleById ()
    {
        return \f\ttt::dal ( 'shop.ratingOptions.getRatingTitleById',
                             $this->request->getAssocParams () ) ;
    }

    public function getAVGRatingByProductId ()
    {
        return \f\ttt::dal ( 'shop.ratingOptions.getAVGRatingByProductId',
                             $this->request->getAssocParams () ) ;
    }

    public function ratingOptionsSave ()
    {
        $params = $this->request->getAssocParams () ;
        if ( $params[ 'id' ] )
        {
            $result = \f\ttt::dal ( 'shop.ratingOptions.ratingOptionsSaveEdit',
                                    $params ) ;
            $msg    = \f\ifm::t ( 'ratingOptionsSaveEdit' ) ;
            $reset  = FALSE ;
        }
        else
        {
            $result = \f\ttt::dal ( 'shop.ratingOptions.ratingOptionsSave',
                                    $params ) ;
            $msg    = \f\ifm::t ( 'ratingOptionsSave' ) ;
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

    public function ratingOptionsDelete ()
    {
        return \f\ttt::dal ( 'shop.ratingOptions.ratingOptionsDelete',
                             $this->request->getAssocParams () ) ;
    }

    public function ratingOptionsStatus ()
    {
        return \f\ttt::dal ( 'shop.ratingOptions.ratingOptionsStatus',
                             $this->request->getAssocParams () ) ;
    }

    public function getRatingOptionsByOwnerId ()
    {
        return \f\ttt::dal ( 'shop.ratingOptions.getRatingOptionsByOwnerId',
                             $this->request->getAssocParams () ) ;
    }

    public function getFeatureByCatId ()
    {
        return \f\ttt::dal ( 'shop.ratingOptions.getFeatureByCatId',
                             $this->request->getAssocParams () ) ;
    }

    public function getProductCatsByAjaxSearch ()
    {
        return \f\ttt::dal ( 'shop.ratingOptions.getProductCatsByAjaxSearch',
                             $this->request->getAssocParams () ) ;
    }

    public function getRatingOptionsByParam ()
    {
        return \f\ttt::dal ( 'shop.ratingOptions.getRatingOptionsByParam',
                             $this->request->getAssocParams () ) ;
    }

    public function getBrandByRatingOptions ()
    {
        return \f\ttt::dal ( 'shop.ratingOptions.getBrandByRatingOptions',
                             $this->request->getAssocParams () ) ;
    }

    public function getRatingOptionsByUserId ()
    {
        $params = $this->request->getAssocParams () ;
        return \f\ttt::dal ( 'shop.ratingOptions.getRatingOptionsByUserId',
                             $params ) ;
    }

}
