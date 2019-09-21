<?php

class linksourceController extends \f\controller
{

    /**
     *
     * @var \f\doctorView
     */
    private $view ;

    public function __construct ()
    {
        require_once 'linksourceView.php' ;
        $this->view = new linksourceView ;
        parent::__construct () ;
    }

    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'cms.link.linksource.index',
                    'content'    => $this->view->renderGrid ()
                ) ) ;
    }

    public function linksourceList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderLinkSourceGrid ( $requestDataTble ) ) ;
    }

    public function linksourceStatus ()
    {
        return $this->response ( \f\ttt::service ( 'cms.link.linksource.linksourceStatus',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function linksourceDelete ()
    {
        return $this->response ( \f\ttt::service ( 'cms.link.linksource.linksourceDelete',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function linksourceAdd ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'cms.link.linksource.linksourceAdd',
                    'content'    => $this->view->renderLinkSourceAdd ()
                ) ) ;
    }

    public function linksourceSave ()
    {
        $param = $this->request->getAssocParams () ;
        if ( $param[ 'link' ] )
        {
            if ( strpos ( $param[ 'link' ], 'https://' ) === false && strpos ( $param[ 'link' ],
                                                                               'http://' ) === false )
            {
                $param[ 'link' ] = 'http://' . $param[ 'link' ] ;
            }
        }
        return $this->response ( \f\ttt::service ( 'cms.link.linksource.linksourceSave',
                                                   $param ) ) ;
    }

    public function linksourceEdit ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'cms.link.linksource.linksourceEdit',
                    'content'    => $this->view->renderLinkSourceAdd ( $this->request->getParam ( 0 ) )
                ) ) ;
    }

}
