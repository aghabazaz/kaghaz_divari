<?php

class commentController extends \f\controller
{

    /**
     *
     * @var \f\slideView
     */
    private $view ;

    public function __construct ()
    {
        require_once 'commentView.php' ;
        $this->view = new customRequestView ;
        parent::__construct () ;
    }

    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.comment.index',
                    'content'    => $this->view->renderGrid ()
                ) ) ;
    }

    public function commentList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderCommentGrid ( $requestDataTble ) ) ;
    }

    public function commentStatus ()
    {
        return $this->response ( \f\ttt::service ( 'shop.comment.commentStatus',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function commentDelete ()
    {
        return $this->response ( \f\ttt::service ( 'shop.comment.commentDelete',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function commentDetail ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.comment.commentDetail',
                    'content'    => $this->view->renderCommentDetail ( $this->request->getParam ( 0 ) )
                ) ) ;
    }

}
