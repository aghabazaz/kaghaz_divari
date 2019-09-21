<?php

class menuController extends \f\controller
{

    /**
     *
     * @var doctorView
     */
    private $view ;

    public function __construct ( $params )
    {
        include_once 'menuView.php' ;
        $this->view = new menuView ;
        parent::__construct ( $params ) ;
    }

    public function index ()
    {
        $params=  $this->request->getAssocParams();
        $content = $this->view->renderMenuFrontend ($params) ;
        return $this->renderPartial ( $content ) ;
    }
    public function indexOld ()
    {
        $params=  $this->request->getAssocParams();
        $content = $this->view->renderMenuFrontendOld ($params) ;
        return $this->renderPartial ( $content ) ;
    }
    public function getMenuDetail ()
    {
        $params = $this->request->getAssocParams () ;
        $pr     = $this->request->getNonAssocParams () ;
        $array  = $this->view->renderGetMenuDetail ( $pr ) ;
        return $this->render ( array (
                    'content'     => $array[0],
                    'websiteInfo' => $params[ 'websiteInfo' ],
                    'title'       => $array[ 1 ][ 'name' ],
                    'description' => $array[ 1 ][ 'short' ] ) ) ;
    }
    public function getTopFooterMenu () 
    {     
        $params=  $this->request->getAssocParams();
        $content = $this->view->renderTopFooterMenu ($params) ;
        return $this->renderPartial ( $content ) ;
    }
    public function getBottomFooterMenu () 
    {     
        $params=  $this->request->getAssocParams();
        $content = $this->view->renderBottomFooterMenu ($params) ;
        return $this->renderPartial ( $content ) ;
    }
}
?>
