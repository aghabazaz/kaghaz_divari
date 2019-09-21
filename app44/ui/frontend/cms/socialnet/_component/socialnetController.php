<?php

class socialnetController extends \f\controller
{

    /**
     *
     * @var doctorView
     */
    private $view ;

    public function __construct ( $params )
    {
        include_once 'socialnetView.php' ;
        $this->view = new socialnetView ;
        parent::__construct ( $params ) ;
    }

    public function index ()
    {
        $content = $this->view->rendersocialnetFrontend ( $this->request->getAssocParams () ) ;
        return $this->renderPartial ( $content ) ;
    }

    public function getMenuDetail ()
    {
        $params = $this->request->getAssocParams () ;
        $pr     = $this->request->getNonAssocParams () ;
        $array  = $this->view->renderGetMenuDetail ( $pr ) ;
        return $this->render ( array (
                    'content'     => $array[ 0 ],
                    'websiteInfo' => $params[ 'websiteInfo' ],
                    'title'       => $array[ 1 ][ 'name' ],
                    'description' => $array[ 1 ][ 'short' ] ) ) ;
    }
}

?>
