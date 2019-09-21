<?php

class categoryController extends \f\controller
{

    /**
     *
     * @var productView
     */
    private $view;

    public function __construct($params)
    {
        include_once 'categoryView.php';
        $this->view = new categoryView;
        parent::__construct($params);
    }

    public function getCategoryList()
    {
        $params = $this->request->getAssocParams();
        $params['limit'] = 9;
        $params['special'] = 'enabled';
        return $this->renderPartial($this->view->renderGetCategoryList($params));
    }
}
