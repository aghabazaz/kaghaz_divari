<?php

/**
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 * @package core.visit
 * @category plugin
 */
class visitController extends \f\controller
{
    
    /**
     *
     * @var visitView
     */
    
    private $view ;

    public function __construct ()
    {
        require_once 'visitView.php' ;
        $this->view = new visitView ;
        
        parent::__construct () ;
    }

    public function getChartByCount ( )
    {
        return $this->response( 
                array(
                    'data' => \f\ttt::service ( 'core.visit.getChartByCount' , $this->request->getAssocParams ()),
                    )
                ) ;        
    }
    public function getChartByDate ( )
    {
        return $this->response( 
                array(
                    'data' => \f\ttt::service ( 'core.visit.getChartByDate' , $this->request->getAssocParams ()),
                    )
                ) ;        
    }

}