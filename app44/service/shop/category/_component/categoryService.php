<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \shop\category
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class categoryService extends \f\service
{

    /**
     *
     * @var shortcutMapper 
     */
    private $mapper ;

    public function __construct ()
    {
        $this->mapper = \f\dalFactory::make ( 'shop.category' ) ;
    }

    public function categoryList ()
    {
        return \f\ttt::dal ( 'shop.category.categoryList',
                             $this->request->getAssocParams () ) ;
    }

    public function categorySave ()
    {
        $params = $this->request->getAssocParams () ;
        if ( $params[ 'id' ] )
        {
            $result = \f\ttt::dal ( 'shop.category.categorySaveEdit', $params ) ;
            $msg    = \f\ifm::t ( 'categorySaveEdit' ) ;
            $reset  = FALSE ;
        }
        else
        {
            $result = \f\ttt::dal ( 'shop.category.categorySave', $params ) ;
            $msg    = \f\ifm::t ( 'categorySave' ) ;
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

    public function categoryDelete ()
    {
        return \f\ttt::dal ( 'shop.category.categoryDelete',
                             $this->request->getAssocParams () ) ;
    }

    public function categoryStatus ()
    {
        return \f\ttt::dal ( 'shop.category.categoryStatus',
                             $this->request->getAssocParams () ) ;
    }

    public function categorySpecial ()
    {
        return \f\ttt::dal ( 'shop.category.categorySpecial',
                             $this->request->getAssocParams () ) ;
    }

    public function getCategorySpecial ()
    {
        //\f\pre('salam');
        return \f\ttt::dal ( 'shop.category.getCategorySpecial',
                             $this->request->getAssocParams () ) ;
    }

    public function getCategoryById ()
    {
        return \f\ttt::dal ( 'shop.category.getCategoryById',
                             $this->request->getAssocParams () ) ;
    }

    public function getCategoryByOwnerId ()
    {
        return \f\ttt::dal ( 'shop.category.getCategoryByOwnerId',
                             $this->request->getAssocParams () ) ;
    }

    public function getFeatureByCatId ()
    {
        return \f\ttt::dal ( 'shop.category.getFeatureByCatId',
                             $this->request->getAssocParams () ) ;
    }

    public function getProductCatsByAjaxSearch ()
    {
        return \f\ttt::dal ( 'shop.category.getProductCatsByAjaxSearch',
                             $this->request->getAssocParams () ) ;
    }

    public function getCategoryByParam ()
    {
        return \f\ttt::dal ( 'shop.category.getCategoryByParam',
                             $this->request->getAssocParams () ) ;
    }
    public function getCategoryProductByParam ()
    {

        return \f\ttt::dal ( 'shop.category.getCategoryProductByParam',
            $this->request->getAssocParams () ) ;
    }

    public function getBrandByCategory ()
    {
        return \f\ttt::dal ( 'shop.category.getBrandByCategory',
                             $this->request->getAssocParams () ) ;
    }

    public function getRatingOptions ()
    {
        return \f\ttt::dal ( 'shop.category.getRatingOptions',
                             $this->request->getAssocParams () ) ;
    }

    public function getCategoryListForApp ()
    {
        return \f\ttt::dal ( 'shop.category.getCategoryListForApp',
            $this->request->getAssocParams () ) ;
    }

}
