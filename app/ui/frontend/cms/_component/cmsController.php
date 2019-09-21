<?php

class cmsController extends \f\controller
{

    /**
     *
     * @var cmsView
     */
    private $view ;

    public function __construct ( $params )
    {
        include_once 'cmsView.php' ;
        $this->view = new cmsView ;
        parent::__construct ( $params ) ;
    }

    public function getSlideList ()
    {


        $content = $this->view->renderGetSlideList () ;
        return $this->renderPartial ( $content ) ;
    }

    public function getAbout ()
    {
        $params = $this->request->getAssocParams () ;

        //\f\pre($pr);
        $content = $this->view->renderGetAbout () ;

        $array = array (
            'content'     => $content,
            'websiteInfo' => $params[ 'websiteInfo' ],
            'title'       => 'درباره ما',
                ) ;

        return $this->render ( $array ) ;
    }

    public function getContact ()
    {
        $params = $this->request->getAssocParams () ;

        $content = $this->view->renderGetContact () ;

        $array = array (
            'content'     => $content,
            'websiteInfo' => $params[ 'websiteInfo' ],
            'title'       => 'تماس با ما',
                ) ;

        return $this->render ( $array ) ;
    }

    public function todayDate ()
    {


        $this->registerGadgets ( array (
            'dateG' => 'date' ) ) ;
        return $this->renderPartial ( \f\ifm::t ( 'today' ) . ' ' . $this->dateG->todayDate () ) ;
    }

    public function getCmsSetting ()
    {
        $params   = $this->request->getAssocParams () ;
        $settings = \f\ttt::service ( 'cms.settings.getSettings' ) ;

        return $this->renderPartial ( $settings[ $params[ 'key' ] ] ) ;
    }

 public function getTextTemplete ()
    {
        $params   = $this->request->getAssocParams () ;
        return $this->renderPartial ( $this->view->renderGetTextTempleteList ( $params ) ) ;
    }

    public function getAboutMainPage ()
    {
        $params   = $this->request->getAssocParams () ;
        return $this->renderPartial ( $this->view->renderGetAboutMainPage () ) ;
    }
    public function getContentList ()
    {
        $params = $this->request->getAssocParams () ;
        return $this->renderPartial ( $this->view->renderGetContentList ( $params ) ) ;
    }

    public function contentList ()
    {
        $params = $this->request->getNonAssocParams () ;
        $param  = $this->request->getAssocParams () ;

        $array = $this->view->renderGetContent ( $params ) ;
        return $this->render ( array (
                    'content'     => $array[ 0 ],
                    'websiteInfo' => $param[ 'websiteInfo' ],
                    'title'       => $array[ 1 ][ 'title' ],
                ) ) ;
    }
    public function contentListMain ()
    {
        $params = $this->request->getAssocParams () ;
        return $this->renderPartial ( $this->view->renderContentMainList ( $params ) ) ;
    }

    public function tagList ()
    {
        $params = $this->request->getNonAssocParams () ;
        $param  = $this->request->getAssocParams () ;

        $array = $this->view->renderGetTag ( $params ) ;
        return $this->render ( array (
                    'content'     => $array[ 0 ],
                    'websiteInfo' => $param[ 'websiteInfo' ],
                    'title'       => $array[ 1 ][ 'title' ],
                ) ) ;
    }

    public function getContentDetail ()
    {
        //\f\pre('ok');
        $params = $this->request->getAssocParams () ;
        $pr     = $this->request->getNonAssocParams () ;
        $array  = $this->view->renderGetContentDetail ( $pr ) ;

        return $this->render ( array (
                    'content'     => $array[ 0 ],
                    'websiteInfo' => $params[ 'websiteInfo' ],
                    'title'       => $array[ 1 ][ 'title' ],
                    'description' => $array[ 1 ][ 'short' ],
                    'keywords'    => implode ( ',', $array[ 2 ] ),
                    'component_id' => 'paperItems',
                    'item_id'      => $pr[0]) ) ;
    }

    public function getSpecialProduct ()
    {
        $params = $this->request->getAssocParams () ;


        return $this->renderPartial ( $this->view->renderGetSpecialProduct ( $params ) ) ;
    }

    public function getLastProduct ()
    {
        $params = $this->request->getAssocParams () ;
        return $this->renderPartial ( $this->view->renderGetLastProduct ( $params ) ) ;
    }

    public function getNewsList ()
    {
        $params = $this->request->getAssocParams () ;
        return $this->renderPartial ( $this->view->renderGetNewsList ( $params ) ) ;
    }

    public function getNewsDetail ()
    {
        //\f\pre('ok');
        $params = $this->request->getAssocParams () ;
        $pr     = $this->request->getNonAssocParams () ;
        $array  = $this->view->renderGetNewsDetail ( $pr ) ;

        return $this->render ( array (
                    'content'     => $array[ 0 ],
                    'websiteInfo' => $params[ 'websiteInfo' ],
                    'title'       => $array[ 1 ][ 'title' ],
                    'description' => $array[ 1 ][ 'short' ],
                ) ) ;
    }

    public function newsList ()
    {
        $params = $this->request->getNonAssocParams () ;
        $param  = $this->request->getAssocParams () ;

        $array = $this->view->renderGetNews ( $params ) ;
        return $this->render ( array (
                    'content'     => $array[ 0 ],
                    'websiteInfo' => $param[ 'websiteInfo' ],
                    'title'       => 'اخبار و اطلاعیه ها',
                ) ) ;
    }

    public function getLastSurvey ()
    {
        $params = $this->request->getAssocParams () ;
        return $this->renderPartial ( $this->view->renderGetLastSurvey ( $params ) ) ;
    }

    public function getAdvertise ()
    {
        $param = $this->request->getAssocParams () ;
        return $this->renderPartial ( $this->view->renderAdvertise ( $param ) ) ;
    }

    public function getVisitInfo ()
    {
        return $this->renderPartial ( $this->view->getVisitInfo () ) ;
    }

    public function getAjaxSearchAllIndex ()
    {
        $params = $this->request->getAssocParams () ;
        return $this->renderPartial ( $this->view->renderGetAjaxSearchAllIndex ( $params ) ) ;
    }

    public function customRequest(){
        //\f\pre('dsf');
        $params = $this->request->getAssocParams () ;
        $view=$this->view->renderCustomRequestIndex();

        return $this->render ( array (
            'content'     => $this->view->renderCustomRequestIndex(),
            'websiteInfo' => $params[ 'websiteInfo' ],
            'title'       => 'اخبار و اطلاعیه ها',
        )) ;
    }
    public function submitCustomReq(){
        $params = $this->request->getAssocParams () ;
       // \f\pre($params);
        $savePic=\f\ttt::dal( 'shop.customProductRequest.submitCustomReq' ,$params) ;

      //  \f\pre($savePic);
        if($savePic>0){
            $result='success';
        }else{
            $result='error';
        }
        return $this->response($result);

    }
}
