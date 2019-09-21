<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \chartex\crm\marketing\news
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class newsService extends \f\service
{

    /**
     *
     * @var shortcutMapper 
     */
    private $mapper ;

    public function __construct ()
    {
        $this->mapper = \f\dalFactory::make ( 'cms.news' ) ;
    }

    public function newsList ()
    {
        return \f\ttt::dal ( 'cms.news.newsList',
                             $this->request->getAssocParams () ) ;
    }
    public function getNewsDetail ()
    {
        return \f\ttt::dal ( 'cms.news.getNewsDetail',
                             $this->request->getAssocParams () ) ;
    }

    public function newsSave ()
    {
        $params = $this->request->getAssocParams () ;


        if ( $params[ 'id' ] )
        {
            $result = \f\ttt::dal ( 'cms.news.newsSaveEdit', $params ) ;
            $msg    = \f\ifm::t ( 'newsSaveEdit' ) ;
            $reset  = FALSE ;
        }
        else
        {
            $result = \f\ttt::dal ( 'cms.news.newsSave', $params ) ;
            $msg    = \f\ifm::t ( 'newsSave' ) ;
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

    public function newsDelete ()
    {
        return \f\ttt::dal ( 'cms.news.newsDelete',
                             $this->request->getAssocParams () ) ;
    }

    public function newsStatus ()
    {
        return \f\ttt::dal ( 'cms.news.newsStatus',
                             $this->request->getAssocParams () ) ;
    }

    public function getContentById ()
    {
        $param = $this->request->getAssocParams () ;
        return \f\ttt::dal ( 'cms.news.getContentById', $param ) ;
    }

  
    public function getNewsList ()
    {
        return \f\ttt::dal ( 'cms.news.getNewsList',
                             $this->request->getAssocParams () ) ;
    }
    public function setNewsVisit ()
    {
        return \f\ttt::dal ( 'cms.news.setNewsVisit',
                             $this->request->getAssocParams () ) ;
    }
    public function getNews()
    {
        return \f\ttt::dal ( 'cms.news.getNews',
                             $this->request->getAssocParams () ) ;
    }


   

}