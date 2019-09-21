<?php

class templateController extends \f\controller
{

    /**
     *
     * @var templateView
     */
    private $view ;

    public function __construct($params)
    {
        require_once 'templateView.php' ;
        $this->view = new templateView ;
        parent::__construct($params) ;
    }

    public function index()
    {
        return $this->render(array (
                    'breadcrumb' => 'core.template.index',
                    'content'    => $this->view->templateTree()
                )) ;
    }

    public function documentTheTemplate()
    {
        $path = $this->request->getParam('path') ;

        return $this->renderPartial($this->view->documentTemplate($path)) ;
    }

    public function sourceCode()
    {
        $path = $this->request->getParam('path') ;
        $code = show_source($path, TRUE) ;
        return $this->renderPartial($code) ;
    }

    public function documentSave()
    {
        return $this->response(\f\ttt::service('core.template.documentSave',
                                               $this->request->getAssocParams())) ;
    }

}
