<?php

class teamController extends \f\controller
{

    /**
     *
     * @var teamView
     */
    private $view ;

    public function __construct ( $params )
    {
        include_once 'teamView.php' ;
        $this->view = new teamView ;
        parent::__construct ( $params ) ;
    }

    public function getTeamtList ()
    {
        $params = $this->request->getAssocParams () ;
        return $this->renderPartial ( $this->view->renderGetTeamList ( $params ) ) ;
    }

    public function teamList ()
    {
        $params = $this->request->getNonAssocParams () ;
        $param  = $this->request->getAssocParams () ;

        $array = $this->view->renderGetTeam ( $params ) ;
        return $this->render ( array (
                    'content'     => $array[ 0 ],
                    'websiteInfo' => $param[ 'websiteInfo' ],
                    'title'       => $array[ 1 ][ 'title' ],
                ) ) ;
    }

    public function getTeamDetail ()
    {
        //\f\pre('ok');
        $params = $this->request->getAssocParams () ;
        $pr     = $this->request->getNonAssocParams () ;
        $array  = $this->view->renderGetTeamDetail ( $pr ) ;

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

}
