<?php

/**
 * @author Yuness Mehdian <mehdian.y@gmail.com>
 * @author Hajian
 * @package core\code
 * @category ui
 */
final class codeController extends \f\controller
{

    /**
     *
     * @var codeView
     */
    private $view ;

    public function __construct()
    {
        include_once 'codeView.php' ;
        $this->view = new codeView ;
        parent::__construct() ;
    }

    public function index()
    {
        return $this->render(array (
                    'breadcrumb' => 'core.code.index',
                    'content'    => $this->view->showTree()
                )) ;
    }

    public function test()
    {
        
    }

    public function toggleEnableCode()
    {
        
    }

    public function viewSelectableCodesList()
    {
        $params            = $this->request->getAssocParams() ;
        $params[ 'tiers' ] = array ( 'ui' => true, ) ;
        $includeResources  = true ;
        if ( isset($params[ 'dontIncludeResources' ]) )
        {
            $includeResources = false ;
        }
        $codeTreeMarkup = $this->view->renderTreeDialog($params, $includeResources) ;
        return $this->renderPartial($codeTreeMarkup) ;
    }

    public function documentTheCode()
    {
        $path  = $this->request->getParam('path') ;
        $type  = $this->request->getParam('type') ;
        $types = explode(".", $type) ;

        if ( $types[ 0 ] == 'method' )
        {
            return $this->renderPartial($this->view->methodDocTab($path,
                                                                  $types[ 1 ],
                                                                  $type)) ;
        }
        else
        {
            return $this->renderPartial($this->view->componentDocTab($path,
                                                                     $types[ 1 ],
                                                                     $type)) ;
        }
    }

    public function documentSave()
    {
        if ( ! $this->request->getParam('icon_id') )
        {
            $this->request->addAssocParam(array (
                'icon_id' => 381 # default icon
            )) ;
        }
        return $this->response(\f\ttt::service('core.code.documentSave',
                                               $this->request->getAssocParams())) ;
    }

    public function filterCode()
    {
        return $this->renderPartial($this->view->renderFilterForm($this->request->getAssocParams())) ;
    }

    public function removeMethodDocument()
    {

        return $this->response(\f\ttt::service('core.code.removeMethodDocument',
                                               $this->request->getAssocParams())) ;
    }

    public function removeComponentDocument()
    {
        return $this->response(\f\ttt::service('core.code.removeComponentDocument',
                                               $this->request->getAssocParams())) ;
    }

}
