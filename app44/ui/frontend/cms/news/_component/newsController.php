<?php

class newsController extends \f\controller
{

    /**
     *
     * @var newsView
     */
    private $view ;

    public function __construct ( $params )
    {
        include_once 'newsView.php' ;
        $this->view = new newsView ;
        parent::__construct ( $params ) ;
    }

    public function getNewstList ()
    {
        $params = $this->request->getAssocParams () ;
        return $this->renderPartial ( $this->view->renderGetNewsList ( $params ) ) ;
    }

    public function getNewsDetail ()
    {
        $pr = $this->request->getNonAssocParams();
        $params = $this->request->getAssocParams () ;
        $array = $this->view->renderGetNewsDetail ($pr[0]) ;
        $params['websiteInfo']['title'] = $array['title'];
        return $this->render ( array (
            'content'     => $array['content'],
            'websiteInfo' => $params[ 'websiteInfo' ],
            'component_id' => 'newsItems',
            'item_id'      => $pr[0]
        ) ) ;

    }

    public function newsListDetail ()
    {
        $pr = $this->request->getNonAssocParams();
        $params = $this->request->getAssocParams () ;
        $params['websiteInfo']['title'] = 'اخبار';
        return $this->render ( array (
                    'content'     => $this->view->renderNewsListDetail ($pr),
                    'websiteInfo' => $params[ 'websiteInfo' ],
                ) ) ;
    }
    
    public function getPersonnel ()
    {
        $params = $this->request->getAssocParams () ;
        return $this->renderPartial ( $this->view->renderGetPersonnel ( $params ) ) ;
    }

    public function newsList ()
    {   
        $params = $this->request->getAssocParams () ;
        return $this->renderPartial ( $this->view->renderNewsList ( $params ) ) ;
    }

}
