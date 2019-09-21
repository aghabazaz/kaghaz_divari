<?php

class discountController extends \f\controller
{

    /**
     *
     * @var \f\portfolioView
     */
    private $view ;

    public function __construct()
    {
        require_once 'discountView.php';
        $this->view = new discountView ;
        parent::__construct() ;
    }

    public function index()
    {
        return $this->render(array (
            'breadcrumb' => 'shop.discount.index',
            'content'    => $this->view->renderGrid()
        )) ;
    }

}