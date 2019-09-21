<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \chartex\crm\marketing\slide
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class materialService extends \f\service
{

    /**
     *
     * @var shortcutMapper 
     */
    private $mapper ;

    public function __construct ()
    {
        $this->mapper = \f\dalFactory::make ( 'shop.guarantee' ) ;
    }

    public function materialList ()
    {
        return \f\ttt::dal ( 'shop.material.materialList',
                             $this->request->getAssocParams () ) ;
    }

    public function materialSave ()
    {
        $params = $this->request->getAssocParams () ;
        if ( $params[ 'id' ] )
        {
            $result = \f\ttt::dal ( 'shop.material.materialSaveEdit', $params ) ;
            $msg    = \f\ifm::t ( 'materialSaveEdit' ) ;
            $reset  = FALSE ;
        }
        else
        {
            $result = \f\ttt::dal ( 'shop.material.materialSave', $params ) ;
            $msg    = \f\ifm::t ( 'materialSave' ) ;
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

    public function materialDelete ()
    {
        return \f\ttt::dal ( 'shop.material.materialDelete',
                             $this->request->getAssocParams () ) ;
    }

    public function materialStatus ()
    {
        return \f\ttt::dal ( 'shop.material.materialStatus',
                             $this->request->getAssocParams () ) ;
    }

    public function getMaterialById ()
    {
        return \f\ttt::dal ( 'shop.material.getMaterialById',
                             $this->request->getAssocParams () ) ;
    }
    public function getMaterial ()
    {
        return \f\ttt::dal ( 'shop.material.getMaterial',
                             $this->request->getAssocParams () ) ;
    }

}