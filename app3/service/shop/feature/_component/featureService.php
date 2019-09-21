<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \shop\feature
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class featureService extends \f\service
{

    /**
     *
     * @var shortcutMapper 
     */
    private $mapper ;

    public function __construct ()
    {
        $this->mapper = \f\dalFactory::make ( 'shop.feature' ) ;
    }

    public function featureList ()
    {
        return \f\ttt::dal ( 'shop.feature.featureList',
                             $this->request->getAssocParams () ) ;
    }

    public function featureSave ()
    {
        $params = $this->request->getAssocParams () ;
        if ( $params[ 'id' ] )
        {
            $result = \f\ttt::dal ( 'shop.feature.featureSaveEdit', $params ) ;
            $msg    = \f\ifm::t ( 'featureSaveEdit' ) ;
            $reset  = FALSE ;
            
        }
        else
        {
            $result = \f\ttt::dal ( 'shop.feature.featureSave', $params ) ;
            $msg    = \f\ifm::t ( 'featureSave' ) ;
            $reset  = TRUE ;
            
            
        }

        if ( $result )
        {
            $data = array ( 'result'  => 'success', 'message' => $msg, 'reset'   => $reset,'func'=>'reload' ) ;
        }
        else
        {
            $data = array ( 'result'  => 'error', 'message' => \f\ifm::t ( 'dbError' ) ) ;
        }

        return $data ;
    }

    public function featureDelete ()
    {
        return \f\ttt::dal ( 'shop.feature.featureDelete',
                             $this->request->getAssocParams () ) ;
    }

    public function featureStatus ()
    {
        return \f\ttt::dal ( 'shop.feature.featureStatus',
                             $this->request->getAssocParams () ) ;
    }

    public function getFeatureById ()
    {
        return \f\ttt::dal ( 'shop.feature.getFeatureById',
                             $this->request->getAssocParams () ) ;
    }
    public function getParameterById ()
    {
        return \f\ttt::dal ( 'shop.feature.getParameterById',
                             $this->request->getAssocParams () ) ;
    }
    public function getFeatureByOwnerId ()
    {
        return \f\ttt::dal ( 'shop.feature.getFeatureByOwnerId',
                             $this->request->getAssocParams () ) ;
    }
    

}