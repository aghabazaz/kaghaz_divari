<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \shop\comment
 * @comment component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class commentService extends \f\service
{

    /**
     *
     * @var shortcutMapper 
     */
    private $mapper ;

    public function __construct ()
    {
        $this->mapper = \f\dalFactory::make ( 'shop.comment' ) ;
    }

    public function commentList ()
    {
        return \f\ttt::dal ( 'shop.comment.commentList',
                             $this->request->getAssocParams () ) ;
    }

    public function saveCommentScore ()
    {
        return \f\ttt::dal ( 'shop.comment.saveCommentScore',
                             $this->request->getAssocParams () ) ;
    }

    public function getCommentById ()
    {
        return \f\ttt::dal ( 'shop.comment.getCommentById',
                             $this->request->getAssocParams () ) ;
    }

    public function getCommentByProductId ()
    {
        return \f\ttt::dal ( 'shop.comment.getCommentByProductId',
                             $this->request->getAssocParams () ) ;
    }

    public function getRatingTitleById ()
    {
        return \f\ttt::dal ( 'shop.comment.getRatingTitleById',
                             $this->request->getAssocParams () ) ;
    }

    public function commentSave ()
    {
        $params = $this->request->getAssocParams () ;
        if ( $params[ 'id' ] )
        {
            $result = \f\ttt::dal ( 'shop.comment.commentSaveEdit', $params ) ;
            $msg    = \f\ifm::t ( 'commentSaveEdit' ) ;
            $reset  = FALSE ;
        }
        else
        {
            $result = \f\ttt::dal ( 'shop.comment.commentSave', $params ) ;
            $msg    = \f\ifm::t ( 'commentSave' ) ;
            $reset  = FALSE ;
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

    public function commentDelete ()
    {
        return \f\ttt::dal ( 'shop.comment.commentDelete',
                             $this->request->getAssocParams () ) ;
    }

    public function commentStatus ()
    {
        return \f\ttt::dal ( 'shop.comment.commentStatus',
                             $this->request->getAssocParams () ) ;
    }

    public function getCommentByOwnerId ()
    {
        return \f\ttt::dal ( 'shop.comment.getCommentByOwnerId',
                             $this->request->getAssocParams () ) ;
    }

    public function getFeatureByCatId ()
    {
        return \f\ttt::dal ( 'shop.comment.getFeatureByCatId',
                             $this->request->getAssocParams () ) ;
    }

    public function getProductCatsByAjaxSearch ()
    {
        return \f\ttt::dal ( 'shop.comment.getProductCatsByAjaxSearch',
                             $this->request->getAssocParams () ) ;
    }

    public function getCommentByParam ()
    {
        return \f\ttt::dal ( 'shop.comment.getCommentByParam',
                             $this->request->getAssocParams () ) ;
    }

    public function getBrandByComment ()
    {
        return \f\ttt::dal ( 'shop.comment.getBrandByComment',
                             $this->request->getAssocParams () ) ;
    }

}
