<?php

class discountCodeController extends \f\controller
{

    /**
     *
     * @var \f\cmsView
     */
    private $view ;

    public function __construct ()
    {
        require_once 'discountCodeView.php';
        $this->view = new discountCodeView ;
        parent::__construct () ;
    }

    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.discount.discountCode.index',
                    'content'    => $this->view->renderGrid ()
                ) ) ;
    }

    public function discountCodeList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderDiscountCodeGrid ( $requestDataTble ) ) ;
    }

    public function discountCodeAdd ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.discount.discountCode.discountCodeAdd',
                    'content'    => $this->view->renderDiscountCodeAdd ()
        ));
    }

    public function discountCodeSave ()
    {
        return $this->response ( \f\ttt::service ( 'shop.discount.discountCode.discountCodeSave',
            $this->request->getAssocParams () ) ) ;
    }

    public function discountCodeEdit ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'shop.discount.discountCode.discountCodeEdit',
                    'content'    => $this->view->renderDiscountCodeAdd ( $this->request->getParam ( 0 ) )
                ) ) ;
    }

    public function discountCodeStatus ()
    {
        return $this->response ( \f\ttt::service ( 'shop.discount.discountCode.discountCodeStatus',
            $this->request->getAssocParams () ) ) ;
    }

    public function discountCodeDelete ()
    {
        return $this->response ( \f\ttt::service ( 'shop.discount.discountCode.discountCodeDelete',
            $this->request->getAssocParams () ) ) ;
    }
}
