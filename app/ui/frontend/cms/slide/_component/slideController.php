<?php

class slideController extends \f\controller
{

    /**
     *
     * @var slideView
     */
    private $view ;

    public function __construct ( $params )
    {
        include_once 'slideView.php' ;
        $this->view = new slideView ;
        parent::__construct ( $params ) ;
    }
    public function getSlideList ()
    {
        //\f\pre('salam');
        $params = $this->request->getAssocParams () ;
        return $this->renderPartial ( $this->view->renderGetSlideList ( $params ) ) ;
    }

    public function getSlideDetail ()
    {
        //\f\pre('ok');
        $params = $this->request->getAssocParams () ;
        $pr     = $this->request->getNonAssocParams () ;
        $array  = $this->view->renderGetSlideDetail ( $pr ) ;

        return $this->render ( array (
                    'content'     => $array[ 0 ],
                    'websiteInfo' => $params[ 'websiteInfo' ],
                    'title'       => $array[ 1 ][ 'title' ],
                    'description' => $array[ 1 ][ 'short' ],
                    'keywords'    => implode ( ',', $array[ 2 ] ) ) ) ;
    }
    
    public function getPersonnel ()
    {
        $params = $this->request->getAssocParams () ;
        
        


        return $this->renderPartial ( $this->view->renderGetPersonnel ( $params ) ) ;
    }
    




public function slideList ()
    {   
        $params = $this->request->getAssocParams () ;
        return $this->renderPartial ( $this->view->renderSlideList ( $params ) ) ;
    }

}
