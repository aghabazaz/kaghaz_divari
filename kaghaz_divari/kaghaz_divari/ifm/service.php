<?php

namespace f ;

class service extends component
{

    /**
     *
     * @var request 
     */
    protected $request ;

    /**
     * Contains the running service route.
     * @var string 
     */
    protected $route ;

    /**
     * Contains running method name of the service.
     * @var string 
     */
    protected $method ;

    /**
     * Contains running method name of the service.
     * @var \f\g\emailg 
     */
    protected $emailG ;

    /**
     * Contains session functions
     * @var \f\g\session 
     */
    protected $sessionG ;

    /**
     * Contains running method name of the service.
     * @var \f\g\coding 
     */
    protected $codingG ;

    /**
     *
     * @var \f\g\imageEdit
     */
    protected $imageEditG ;

    /**
     * Contains known states for service and relative messages.
     * @var array 
     */
    protected $states ;

    public function __construct($params = array ())
    {

        if ( ! empty($params) )
        {
            $this->setMethod($params[ 'method' ]) ;
            $this->setRoute($params[ 'route' ]) ;
        }
        $this->loadStates() ;
    }

    public function setRequest($request)
    {
        $this->request = $request ;
    }

    protected function checkParams($request, $params)
    {
        foreach ( $params as $param )
        {
            if ( $request->getParam($param) === false )
            {
                return false ;
            }
        }
        return true ;
    }

    public function setRoute($route)
    {
        $this->route = $route ;
    }

    public function setMethod($method)
    {
        $this->method = $method ;
    }

    private function loadStates()
    {

        $a           = \f\ifm::app()->serviceDir ;
        $b           = str_replace('.', \f\DS, $this->route) ;
        $servicePath = $a . \f\DS . $b . \f\DS . '_component' ;
        $statesPath  = $servicePath . \f\DS . 'states.php' ;


        if ( file_exists($statesPath) )
        {
            include $statesPath ;

            /* @var $states array defined in the states.php in the service dir */
            if ( isset($states) )
            {
                $this->states = $states ;
            }
            else
            {
                throw new publicException("States file is corruped in the $statesPath") ;
            }
        }
    }

    public function state($code, $translate = true)
    {
        if ( isset($this->states[ $code ]) )
        {
            $state                = $this->states[ $code ] ;
            $state[ 'messageEn' ] = $state[ 'message' ] ;
            $state[ 'message' ]   = $translate ? ifm::t($state[ 'message' ]) : $state[ 'message' ] ;
            return $state ;
        }
        else
        {
            $messageEn = 'State is undefined, contact technical support.' ;
            return array (
                'result'    => 'undefined',
                'messageEn' => $messageEn,
                'message'   => $translate ? ifm::t($messageEn) : $state[ 'message' ]
                    ) ;
        }
    }

}
