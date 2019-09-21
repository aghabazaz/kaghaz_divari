<?php

class returnedController extends \f\controller
{

    /**
     *
     * @var \f\slideView
     */
    private $view ;

    public function __construct ()
    {
        require_once 'returnedView.php' ;
        $this->view = new returnedView ;
        parent::__construct () ;
    }

    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'accountingStock.returned.index',
                    'content'    => $this->view->renderGrid ()
                ) ) ;
    }

    public function returnedList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderReturnedGrid ( $requestDataTble ) ) ;
    }

    public function returnedDetail ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'accountingStock.returned.returnedDetail',
                    'content'    => $this->view->renderReturnedDetail ( $this->request->getParam ( 0 ) )
                ) ) ;
    }


}
