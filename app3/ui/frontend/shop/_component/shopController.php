<?php

class shopController extends \f\controller
{

    /**
     *
     * @var shopView
     */
    private $view ;

    public function __construct ( $params )
    {
        include_once 'shopView.php' ;
        $this->view = new shopView ;
        parent::__construct ( $params ) ;
    }

    public function getProduct ()
    {
        $params = $this->request->getAssocParams () ;
        return $this->renderPartial ( $this->view->renderGetProduct ( $params ) ) ;
    }

    public function searchForm ()
    {
        $params = $this->request->getAssocParams () ;
        //\f\pr($params);
        return $this->renderPartial ( $this->view->renderGetSearchForm ( $params ) ) ;
    }

    public function getSpecialAdvert ()
    {

        $params = $this->request->getAssocParams () ;


        return $this->renderPartial ( $this->view->renderGetSpecialAdvert ( $params ) ) ;
    }

    public function searchResult ()
    {
        $param = $this->request->getAssocParams () ;

        return $this->render ( array (
                    'content'     => $this->view->renderGetSearchResult ( $param ),
                    'websiteInfo' => $param[ 'websiteInfo' ],
                    'title'       => 'نتیجه جستجو',
        ) ) ;
    }

    public function getBrandList ()
    {
        $param = $this->request->getAssocParams () ;
        return $this->renderPartial ( $this->view->renderGetBrandList ( $param ) ) ;
    }

    public function sidebarFilter ()
    {
        $params = $this->request->getAssocParams () ;
        return $this->renderPartial ( $this->view->renderGetSidebarFilter ( $params ) ) ;
    }

}
