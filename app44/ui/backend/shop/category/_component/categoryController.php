<?php

class categoryController extends \f\controller
{

    /**
     *
     * @var \f\slideView
     */
    private $view ;

    public function __construct ()
    {
        require_once 'categoryView.php' ;
        $this->view = new categoryView ;
        parent::__construct () ;
    }

    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.category.index',
                    'content'    => $this->view->renderCatGrid ()
                ) ) ;
    }

    public function categoryList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderCategoryGrid ( $requestDataTble ) ) ;
    }

    public function categoryAdd ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.category.categoryAdd',
                    'content'    => $this->view->renderCategoryAdd ()
                ) ) ;
    }

    public function categorySave ()
    {
        //\f\pre($this->request->getAssocParams ());
        return $this->response ( \f\ttt::service ( 'shop.category.categorySave',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function categoryEdit ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.category.categoryEdit',
                    'content'    => $this->view->renderCategoryAdd ( $this->request->getParam ( 0 ) )
                ) ) ;
    }

    public function categoryDelete ()
    {
        return $this->response ( \f\ttt::service ( 'shop.category.categoryDelete',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function categoryStatus ()
    {
        return $this->response ( \f\ttt::service ( 'shop.category.categoryStatus',
                                                   $this->request->getAssocParams () ) ) ;
    }
    
    public function categorySpecial ()
    {
        return $this->response ( \f\ttt::service ( 'shop.category.categorySpecial',
                                                   $this->request->getAssocParams () ) ) ;
    }

}
