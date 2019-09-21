<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \chartex\crm\marketing\doctor
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class blogService extends \f\service
{

    /**
     *
     * @var shortcutMapper 
     */
    private $mapper ;

    public function __construct ()
    {
        $this->mapper = \f\dalFactory::make ( 'cms.blog' ) ;
    }

    public function getAccountById ()
    {
        return \f\ttt::dal ( 'cms.blog.getAccountById',
                             $this->request->getAssocParams () ) ;
    }

    public function getBlogById ()
    {
        return \f\ttt::dal ( 'cms.blog.getBlogById',
                             $this->request->getAssocParams () ) ;
    }
    
    public function blogList ()
    {
        return \f\ttt::dal ( 'cms.blog.blogList',
                             $this->request->getAssocParams () ) ;
    }

    public function blogSave ()
    {
        $params = $this->request->getAssocParams () ;
        if ( $params[ 'id' ] )
        {
            $result = \f\ttt::dal ( 'cms.blog.blogSaveEdit', $params ) ;
            $msg    = \f\ifm::t ( 'blogSaveEdit' ) ;
            $reset  = FALSE ;
        }
        else
        {
            $result = \f\ttt::dal ( 'cms.blog.blogSave', $params ) ;
            $msg    = \f\ifm::t ( 'blogSave' ) ;
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

    public function blogDelete ()
    {
        $params = $this->request->getAssocParams () ;
        return \f\ttt::dal ( 'cms.blog.blogDelete', $params
                ) ;
    }
    
    public function blogStatus ()
    {
        return \f\ttt::dal ( 'cms.blog.blogStatus',
                             $this->request->getAssocParams () ) ;
    }
    public function getListBlog ()
    {
        return \f\ttt::dal ( 'cms.blog.getListBlog',
                             $this->request->getAssocParams () ) ;
    }
    public function setVisit ()
    {
        return \f\ttt::dal ( 'cms.blog.setVisit',
                             $this->request->getAssocParams () ) ;
    }
}