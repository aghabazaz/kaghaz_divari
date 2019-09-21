<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \shop\product
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class productService extends \f\service
{
    /**
     *
     * @var shortcutMapper 
     */
    private $mapper ;

    public function __construct ()
    {
        $this->mapper = \f\dalFactory::make ( 'shop.product' ) ;
    }

    public function productList ()
    {
        return \f\ttt::dal ( 'shop.product.productList',
                             $this->request->getAssocParams () ) ;
    }

    public function productSave ()
    {
        $params   = $this->request->getAssocParams () ;
        $checkbox = $params[ 'checkbox' ] ;
        //unset checkbox for save params in tbl
        unset ( $params[ 'checkbox' ] );

        if(isset($params['enable_gift'])){
            $params['active_gift_section']='enabled';
            //$params['gifts']='yes';
        }else{
            $params['active_gift_section']='disabled';
           // $params['gifts']='no';
        }
        $rowDynamic=\f\ttt::dal ( 'shop.product.getTypeCat',
            array (
                'id' => $params['category'][0]
            ) ) ;


        $params['dynamic']=$rowDynamic['dynamic'];
        if($params['active_gift_section']=='enabled'){
            if($params['n_buy']==0 || $params['n_buy']=='' || $params['m_free']==0 || $params['m_free']=='' || $params['shop_product_gift_id']==''){
                return array (
                    'result'  => 'error',
                    'message' => \f\ifm::t ( 'fullOfFields' ) ) ;
            }
        }
        //if ( $params[ 'price' ][ 0 ] && $params[ 'guarantee' ][ 0 ] )
        if(TRUE)
        {
            if ( $params[ 'id' ] )
            {
                $result = \f\ttt::dal ( 'shop.product.productSaveEdit', $params ) ;
                $msg    = \f\ifm::t ( 'productSaveEdit' ) ;
                $reset  = FALSE ;
            }
            else
            {
                $result = \f\ttt::dal ( 'shop.product.productSave', $params ) ;
                $msg    = '' ;
                $reset  = TRUE ;
                $func   = 'confirmNewProduct' ;
            }

            if ( $result )
            {
                $brand                     = \f\ttt::dal ( 'shop.brand.getBrandById',
                                                           array (
                            'id' => $params[ 'brand' ]
                        ) ) ;
                $nlParam[ 'id' ]           = $params[ 'id' ] ? $params[ 'id' ] : $result ;
                $nlParam[ 'title' ]        = $params[ 'title' ] ;
                $nlParam[ 'sub_title' ]    = $params[ 'sub_title' ] ;
                $nlParam[ 'brand_fa' ]     = $brand[ 'title_fa' ] ;
                $nlParam[ 'brand_en' ]     = $brand[ 'title_en' ] ;
                $nlParam[ 'link' ]         = \f\ifm::app ()->siteUrl . 'productDetail/' . $nlParam[ 'id' ] ;
                $nlParam[ 'template_cat' ] = "product" ;

                if ( is_array ( $checkbox ) && in_array ( 'emailSend', $checkbox ) )
                {
                    $nlParam[ 'type' ] = 'email' ;
                    \f\ttt::service ( 'newsletter.getEmailsMobiles', $nlParam ) ;
                }

                $data = array (
                    'result'  => 'success',
                    'message' => $msg,
                    'reset'   => $reset,
                    'func'    => $func ) ;
            }
            else
            {
                $data = array (
                    'result'  => 'error',
                    'message' => \f\ifm::t ( 'dbError' ) ) ;
            }
        }
        else
        {
            $data = array (
                'result'  => 'error',
                'message' => \f\ifm::t ( 'priceError' ) ) ;
        }

        return $data ;
    }
    public function productDelete ()
    {
        $params = $this->request->getAssocParams () ;
        $row    = \f\ttt::service ( 'core.fileManager.getFileIdByPath',
                                    array (
                    'path' => 'shop.product.' . $params[ 'id' ]
                ) ) ;

        $fileId = $row[ 'id' ] ;
        \f\ttt::service ( 'core.fileManager.deleteFile',
                          array (
            'fileId' => $fileId
        ) ) ;
        return \f\ttt::dal ( 'shop.product.productDelete',
                             $this->request->getAssocParams () ) ;
    }

    public function productStatus ()
    {
        return \f\ttt::dal ( 'shop.product.productStatus',
                             $this->request->getAssocParams () ) ;
    }

    public function getProductById ()
    {
        return \f\ttt::dal ( 'shop.product.getProductById',
                             $this->request->getAssocParams () ) ;
    }

    public function getProductByOwnerId ()
    {
        return \f\ttt::dal ( 'shop.product.getProductByOwnerId',
                             $this->request->getAssocParams () ) ;
    }

    public function getFeatureByCatId ()
    {
        return \f\ttt::dal ( 'shop.product.getFeatureByCatId',
                             $this->request->getAssocParams () ) ;
    }

    public function getFeatureByProductId ()
    {
        return \f\ttt::dal ( 'shop.product.getFeatureByProductId',
                             $this->request->getAssocParams () ) ;
    }

    public function getPriceByProductById ()
    {
        return \f\ttt::dal ( 'shop.product.getPriceByProductById',
                             $this->request->getAssocParams () ) ;
    }

    public function productSpecial ()
    {
        return \f\ttt::dal ( 'shop.product.productSpecial',
                             $this->request->getAssocParams () ) ;
    }

    public function getProductsByAjaxSearch ()
    {
        return \f\ttt::dal ( 'shop.product.getProductsByAjaxSearch',
                             $this->request->getAssocParams () ) ;
    }

    public function getProductByParams ()
    {
        return \f\ttt::dal ( 'shop.product.getProductByParams',
                             $this->request->getAssocParams () ) ;
    }

    public function getNewProduct ()
    {
        return \f\ttt::dal ( 'shop.product.getNewProduct',
                             $this->request->getAssocParams () ) ;
    }

    public function getMostVisitProduct(){
        return \f\ttt::dal ( 'shop.product.getMostVisitProduct',
            $this->request->getAssocParams () ) ;
    }
    public function getNewOneProduct ()
    {
        return \f\ttt::dal ( 'shop.product.getNewOneProduct',
                             $this->request->getAssocParams () ) ;
    }

    public function getRelatedProductById ()
    {
        return \f\ttt::dal ( 'shop.product.getRelatedProductById',
                             $this->request->getAssocParams () ) ;
    }

    public function getProductBestselling ()
    {
        return \f\ttt::dal ( 'shop.product.getProductBestselling',
                             $this->request->getAssocParams () ) ;
    }

    public function getBestsellingManually ()
    {
        return \f\ttt::dal ( 'shop.product.getBestsellingManually',
                             $this->request->getAssocParams () ) ;
    }

    public function getAmazingProducts ()
    {
        //\f\pre('salam');
        return \f\ttt::dal ( 'shop.product.getAmazingProducts',
                             $this->request->getAssocParams () ) ;
    }

    public function getBrandsByProductsCat ()
    {
        return \f\ttt::dal ( 'shop.product.getBrandsByProductsCat',
                             $this->request->getAssocParams () ) ;
    }

    public function getPriceMaxByCatId ()
    {
        return \f\ttt::dal ( 'shop.product.getPriceMaxByCatId',
                             $this->request->getAssocParams () ) ;
    }

    public function setProductVisit ()
    {
        return \f\ttt::dal ( 'shop.product.setProductVisit',
                             $this->request->getAssocParams () ) ;
    }

    public function getGuranteesByColorId ()
    {
        return \f\ttt::dal ( 'shop.product.getGuranteesByColorId',
                             $this->request->getAssocParams () ) ;
    }

    public function checkStockByPriceId ()
    {
        return \f\ttt::dal ( 'shop.product.checkStockByPriceId',
                             $this->request->getAssocParams () ) ;
    }

    public function minesPlusProductStock ()
    {
        return \f\ttt::dal ( 'shop.product.minesPlusProductStock',
                             $this->request->getAssocParams () ) ;
    }

    public function getCompareProductDetail ()
    {
        return \f\ttt::dal ( 'shop.product.getCompareProductDetail',
                             $this->request->getAssocParams () ) ;
    }

    public function getProductByBrand ()
    {
        $params = $this->request->getAssocParams () ;
        return \f\ttt::dal ( 'shop.product.getProductByBrand', $params ) ;
    }

    public function getProductByBrandId ()
    {
        $params = $this->request->getAssocParams () ;
        return \f\ttt::dal ( 'shop.product.getProductByBrandId', $params ) ;
    }

    public function getGiftsProduct ()
    {
        $params = $this->request->getAssocParams () ;
        return \f\ttt::dal ( 'shop.product.getGiftsProduct', $params ) ;
    }

    public function getProductListForApp ()
    {
        $params = $this->request->getAssocParams () ;
        return \f\ttt::dal ( 'shop.product.getProductListForApp', $params ) ;
    }
}
