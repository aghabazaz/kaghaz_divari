<?php

class productController extends \f\controller
{

    /**
     *
     * @var productView
     */
    private $view ;

    public function __construct ( $params )
    {
        include_once 'productView.php' ;
        $this->view = new productView ;
        parent::__construct ( $params ) ;
    }

    public function productIndex ()
    {
        $params         = $this->request->getAssocParams () ;
        $nonAssocParams = $this->request->getNonAssocParams () ;
        if ( $nonAssocParams[ 0 ] == 'productDetail' )
        {
            $getNonAssocParams = $this->request->getNonAssocParams () ;
            $content           = $this->view->renderDetailPortfolio ( $getNonAssocParams[ 1 ] ) ;
        }
        else if ( $nonAssocParams[ 0 ] == 'category' )
        {
            $content = $this->view->renderCategoryPortfolio ( $nonAssocParams ) ;
        }
        elseif ( $nonAssocParams[ 0 ] == 'off' )
        {
            $array   = $this->view->renderConcessionProduct ( $params ) ;
            $content = $array[ 0 ] ;
        }
        elseif ( $nonAssocParams[ 0 ] == 'brand' )
        {
            //$brandId = $nonAssocParams['1'] ;
            $array   = $this->view->renderBrandsProduct ( $nonAssocParams ) ;
            $content = $array ;
            $title    = ' محصولات '.$array[ 'title' ];
        }
        elseif ( $nonAssocParams[ 0 ] == 'gifts' )
        {
            //$brandId = $nonAssocParams['1'] ;
            $array   = $this->view->renderGiftsProduct ( $nonAssocParams ) ;
            $content = $array[ 0 ] ;

        }
        else
        {
            $category = \f\ttt::service ( 'shop.category.getCategoryByParam',
                                          array (
                        'selects'  => 'id,title',
                        'title_en' => $nonAssocParams[ 0 ]
                    ) ) ;
           // \f\pre($category);
            $title    = $category[0][ 'title' ] ;
            $content  = $this->view->renderGetProduct ( $nonAssocParams ) ;
            //\f\pre($content);
        }

        //\f\pre($content);
        $params[ 'websiteInfo' ]['title']=$title;
        return $this->render ( array (
                    'content'      => $content['view'],
                    'websiteInfo'  => $params['websiteInfo'],
                    'title'        => $title,
                    'component_id' => 'categoryItems',
                    'category'     => $category,
                    'item_id'      => $content['catId']
                ) ) ;
    }

    public function productIndexOld ()
    {
        $params         = $this->request->getAssocParams () ;
        $nonAssocParams = $this->request->getNonAssocParams () ;
        if ( $nonAssocParams[ 0 ] == 'productDetail' )
        {
            $getNonAssocParams = $this->request->getNonAssocParams () ;
            $content           = $this->view->renderDetailPortfolio ( $getNonAssocParams[ 1 ] ) ;
        }
        else if ( $nonAssocParams[ 0 ] == 'category' )
        {
            $content = $this->view->renderCategoryPortfolio ( $nonAssocParams ) ;
        }
        elseif ( $nonAssocParams[ 0 ] == 'off' )
        {
            $array   = $this->view->renderConcessionProduct ( $params ) ;
            $content = $array[ 0 ] ;
        }
        elseif ( $nonAssocParams[ 0 ] == 'brand' )
        {
            //$brandId = $nonAssocParams['1'] ;
            $array   = $this->view->renderBrandsProduct ( $nonAssocParams ) ;
            $content = $array[ 0 ] ;
        }
        elseif ( $nonAssocParams[ 0 ] == 'gifts' )
        {
            //$brandId = $nonAssocParams['1'] ;
            $array   = $this->view->renderGiftsProduct ( $nonAssocParams ) ;
            $content = $array[ 0 ] ;
        }
        else
        {
            $category = \f\ttt::service ( 'shop.category.getCategoryByParam',
                array (
                    'selects'  => 'id,title',
                    'title_en' => $nonAssocParams[ 0 ]
                ) ) ;
            $title    = $category[ 'title' ] ;
            $content  = $this->view->renderGetProductOld ( $nonAssocParams ) ;
        }

        return $this->render ( array (
            'content'     => $content,
            'websiteInfo' => $params[ 'websiteInfo' ],
            'title'       => $title,
            'category'    => $category
        ) ) ;
    }
  public function  momentSuggestList(){
        $params = $this->request->getAssocParams () ;
        return $this->renderPartial ( $this->view->getMomentSuggest ( $params ) ) ;
  }
    
    
    public function getProductDetail ()
    {
        $params = $this->request->getAssocParams () ;
        if($params['mobileDevice']){
            $pr     = $this->request->getNonAssocParams () ;
            $array  = $this->view->renderGetProductDetailMobile ( $pr ) ;

            return $this->render ( array (
                'content'     => $array[ 0 ],
                'websiteInfo' => $params[ 'websiteInfo' ],
                'title'       => $array[ 1 ][ 'title' ],
                'description' => $array[ 1 ][ 'sub_title' ],
                'picture'     => $array[ 1 ][ 'picture' ],
                'keywords'    => implode ( ',', $array[ 2 ] ),
                'component_id' => 'productItems',
                'item_id'      => $pr[0]
            ) ) ;
        }
        else{
        //\f\pre($params);
        $pr     = $this->request->getNonAssocParams () ;
        $array  = $this->view->renderGetProductDetail ( $pr ) ;
        return $this->render ( array (
                    'content'     => $array[ 0 ],
                    'websiteInfo' => $params[ 'websiteInfo' ],
                    'title'       => $array[ 1 ][ 'title' ],
                    'description' => $array[ 1 ][ 'sub_title' ],
                    'picture'     => $array[ 1 ][ 'picture' ],
                    'keywords'    => implode ( ',', $array[ 2 ] ),
                    'dynamic'=>$array[2],
                    'component_id' => 'productItems',
                    'item_id'      => $pr[0]
                ) ) ;
        }
    }

    public function getProductCompare ()
    {
        $params = $this->request->getAssocParams () ;
        $pr     = $this->request->getNonAssocParams () ;

        if ( count ( $pr ) == 0 )
        {
            header ( 'Location:' . \f\ifm::app ()->siteUrl ) ;
        }

        //\f\spre($productId);
        return $this->render ( array (
                    'content'     => $this->view->renderCompare ( $pr ),
                    'websiteInfo' => $params[ 'websiteInfo' ],
                    'title'       => 'مقایسه محصولات',
                ) ) ;
    }

    public function rateForm ()
    {
        $pr     = $this->request->getNonAssocParams () ;
        $params = $this->request->getAssocParams () ;
        if ( ! $_SESSION[ 'user_id' ] || ! $pr[ '0' ] )
        {
            header ( "Location:" . \f\ifm::app ()->siteUrl . 'login' ) ;
        }
        $params['websiteInfo']['title'] = 'امتیازدهی به محصول';
        return $this->render ( array (
                    'content'     => $this->view->renderRateForm ( $pr[ '0' ] ),
                    'websiteInfo' => $params[ 'websiteInfo' ]
                ) ) ;
    }

    public function getProductByParam ()
    {
        $params = $this->request->getAssocParams () ;
        //\f\pre('sdf');
        return $this->response ( array ('content' => $this->view->getProductByParam ( $params ) ) ) ;
    }

    public function productRateSave ()
    {

        $params              = $this->request->getAssocParams () ;
        $params[ 'user_id' ] = $_SESSION[ 'user_id' ] ;
        $row                 = \f\ttt::service ( 'shop.ratingOptions.saveRatingOptionsScore',
                                                 $params ) ;
        return $this->response ( $row ) ;
    }

    public function productCommentSave ()
    {

        $params = $this->request->getAssocParams () ;

            if ( $params[ 'description' ] )
            {
                $params[ 'user_id' ] = $_SESSION[ 'user_id' ] ;
                $row                 = \f\ttt::service ( 'shop.comment.commentSave',
                                                         $params ) ;
            }
            else
            {
                $row = array (
                    'result'  => 'error',
                    'message' => 'پر کردن متن نقد و بررسی الزامی است.' ) ;
            }

        return $this->response ( $row ) ;
    }

    public function getNewProducts ()
    {
        $params  = $this->request->getAssocParams () ;
        $content = $this->view->renderNewProducts ( $params ) ;
        if ( ! $content )
        {
            $content = '&nbsp;' ;
        }

        return $this->renderPartial ( $content ) ;

    }

    public function getNewProductsMobile ()
    {
        $params  = $this->request->getAssocParams () ;
        //\f\pre($params);
        $content = $this->view->renderNewProductsMobile ( $params ) ;
        //\f\pre($content);
        if ( ! $content )
        {
            $content = '&nbsp;' ;
        }

        return $this->renderPartial ( $content ) ;

    }

    public function getMustVisit ()
    {
        $params = $this->request->getAssocParams () ;
        return $this->renderPartial ( $this->view->renderMustVisit ( $params ) ) ;
    }

    public function getMustSell ()
    {
        $params = $this->request->getAssocParams () ;
        return $this->renderPartial ( $this->view->renderMustSell ( $params ) ) ;
    }

    public function getNewOneProduct ()
    {
       // \f\pre('hi');
        $params = $this->request->getAssocParams () ;
        return $this->renderPartial ( $this->view->getNewOneProduct ( $params ) ) ;
    }
    public function getNewMobileTablet ()
    {
        $params = $this->request->getAssocParams () ;
        return $this->renderPartial ( $this->view->getNewMobileTablet ( $params ) ) ;
    }
    public function getRelatedProduct ()
    {
        $params = $this->request->getAssocParams () ;
        return $this->renderPartial ( $this->view->getRelatedProduct ( $params ) ) ;
    }

    public function getProductBestselling ()
    {
        $params = $this->request->getAssocParams () ;
        return $this->renderPartial ( $this->view->renderGetProductBestselling ( $params ) ) ;
    }

    public function getAmazingSlide ()
    {
        $params  = $this->request->getAssocParams () ;
        $content = $this->view->renderAmazingSlide ( $params ) ;
        if ( ! $content )
        {
            $content = '&nbsp;' ;
        }

        return $this->renderPartial ( $content ) ;
    }
    public function getAmazingSlideMobile ()
    {
        $params  = $this->request->getAssocParams () ;
        $content = $this->view->renderAmazingSlideMobile ( $params ) ;
        if ( ! $content )
        {
            $content = '&nbsp;' ;
        }

        return $this->renderPartial ( $content ) ;
    }

    public function getGuranteesByColorId ()
    {
        $params = $this->request->getAssocParams () ;
        $array  = $this->view->renderGetGuranteesByColorId ( $params ) ;
        return $this->response ( array (
                    'content'  => $array[ 'content' ],
                    'gurantee' => $array[ 'gurantee' ],
                    'countAvailable'=> $array[ 'countAvailable' ],
                ) ) ;
    }

    public function convert2english($string) {
        $newNumbers = range(0, 9);
        // 1. Persian HTML decimal
        $persianDecimal = array('&#1776;', '&#1777;', '&#1778;', '&#1779;', '&#1780;', '&#1781;', '&#1782;', '&#1783;', '&#1784;', '&#1785;');
        // 2. Arabic HTML decimal
        $arabicDecimal = array('&#1632;', '&#1633;', '&#1634;', '&#1635;', '&#1636;', '&#1637;', '&#1638;', '&#1639;', '&#1640;', '&#1641;');
        // 3. Arabic Numeric
        $arabic = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
        // 4. Persian Numeric
        $persian = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');

        $string =  str_replace($persianDecimal, $newNumbers, $string);
        $string =  str_replace($arabicDecimal, $newNumbers, $string);
        $string =  str_replace($arabic, $newNumbers, $string);
        return str_replace($persian, $newNumbers, $string);
    }
    public function sendAddToCart ()
    {
        $params = $this->request->getAssocParams () ;

        \f\pre($params);
        if (empty($_SESSION[ 'user_id' ]) or !isset($_SESSION['user_id']))
        {
            $result = array (
                'result'  => 'errorNoLogin',
                    ) ;
            return $this->response ( $result ) ;
        }

        if($params['count']<=0 and $params['typeOpr']=='decrease'){
            return $this->response ( array (
                'result' => 'limitZero',
            ) ) ;
        }

        /*if($params){

        }*/

        $array = $this->view->renderSendAddToCart ( $params ) ;
        return $this->response ( array (
                    'result' => $array[ 'result' ],
                    'typeOpr'=>$params['typeOpr']
                ) ) ;
    }


    public function getProductByBrand ()
    {
        $params = $this->request->getAssocParams () ;

        $row = \f\ttt::service ( 'shop.product.getProductByBrand', $params ) ;

        foreach ( $row AS $data )
        {
            $content .= '<option value="' . $data[ 'id' ] . '">' . $data[ 'title' ] . '</option>' ;
        }

        return $this->response ( array (
                    'content' => $content,
                    'box'     => $params[ 'box' ]
                ) ) ;
    }

    public function goToRateOrLogin ()
    {
        $result = $_SESSION[ 'user_id' ] ? 'success' : 'error' ;
        return $this->response ( array (
                    'result' => $result,
                ) ) ;
    }
    public function sendAddToFavorite(){
        $params = $this->request->getAssocParams () ;
        if (! $_SESSION[ 'user_id' ])
        {
            $result = array (
                'result'  => 'error',
                'message' => \f\ifm::t ( 'loginUser' ),
                'url'     => \f\ifm::app ()->siteUrl.'login'
            ) ;
            return $this->response ( $result ) ;
        }
        $params['user_id']=$_SESSION['user_id'];

        $array = $this->view->renderSendAddToFavorite ( $params ) ;
       // \f\pre($array);
        return $this->response ( array (
            'like_count'=>$_SESSION['like_count'],
            'result' => $array[ 'result' ]
        ) ) ;
    }
    public function getSpecialCategory(){
        $params = $this->request->getAssocParams () ;
        $this->registerGadgets( [
            'dateG' => 'date' ] );
        $params['date'] = $this->dateG->today();
        $content = $this->view->renderGetSpecialCategory ( $params ) ;
        return $this->renderPartial ( $content ) ;
    }
    public function saveImageCrop(){
        $params = $this->request->getAssocParams () ;
        if(array_key_exists('mirror',$params)){
            $mirror='on';
        }else{
           $mirror='off';
        }
        if(array_key_exists('grayscale',$params)){
            $grayscale='on';
        }else{
            $grayscale='off';
        }
        $imgAttr=explode(';',$params['imgAttr']);
        $widthImageArray=explode(':',$imgAttr[0]);
        $widthImage=$widthImageArray[1];
        $heightImageArray=explode(':',$imgAttr[1]);
        $heightImage=$heightImageArray[1];
        $transactionImageArray=explode(':',$imgAttr[2]);
        $transactionImage=$transactionImageArray[1];

        $masterImgAttr=explode(';',$params['masterImg']);
        $widthMasterImageArray=explode(':',$masterImgAttr[0]);
        $widthMasterImage=$widthMasterImageArray[1];
        $heightMasterImageArray=explode(':',$masterImgAttr[1]);
        $heightMasterImage=$heightMasterImageArray[1];

       // \f\pre($params);
       // $uploadBaseDir = \f\ifm::app()->uploadDir;
        //\f\pre($uploadBaseDir);
        //\f\pre($uploadBaseDir);
       /*$pathToFile    = $uploadBaseDir . \f\DS . str_replace( '-','.',
                str_replace( '.',
                    \f\DS,
                    $path ) );*/
       // \f\pr($widthImage);
       // \f\pre($heightImage);
        //getimagesize();
        //\f\pre($params);
        //\f\pr($widthImage);
        //\f\pre($heightImage);
      /*  $widthImage=substr($widthImage,0,-2);
        $heightImage=substr($heightImage,0,-2);

        $widthMasterImage=substr($widthMasterImage,0,-2);
        $heightMasterImage=substr($heightMasterImage,0,-2);
        $image_p = imagecreatetruecolor($widthImage, $heightImage);
        $image = imagecreatefromjpeg('C:\Users\raysan\Downloads\1534_banner2.jpg');
        imagecopyresampled($image_p, $image, 0, 0, 0, 0, $widthImage, $heightImage, $widthMasterImage, $heightMasterImage);
        imagejpeg($image_p, 'C:\Users\raysan\Downloads\newimg.jpg', 100);
       // \f\pr($widthMasterImage);
        //\f\pre($heightMasterImage);
       // list($width_orig, $height_orig) = getimagesize($filename);

       // $ratio_orig = $width_orig/$height_orig;

        /*if ($width/$height > $ratio_orig) {
            $width = $height*$ratio_orig;
        } else {
            $height = $width/$ratio_orig;
        }*/

// Resample

       /// \f\pre($widthImage);
        $picture = \f\ttt::service('core.fileManager.loadFileUrlDynamicPro', [
            'fileId' => $params['serialImage'],
            'width' => $widthImage,
            'height' => $heightImage,
            'masterWidth'=>$widthMasterImage,
            'masterHeight'=>$heightMasterImage,
            'option' => 'crop',
            'mirror'=>$mirror,
            'grayscale'=>$grayscale,
            'optionXY'=>$transactionImage,'mirror'=>$mirror
        ]);
        $params['picture']=$picture;
        //\f\pre($picture);
        $result = \f\ttt::service('shop.order.orderSave', $params);
        //\f\pre($picture);
        /// \f\pre('end');

    }
}
