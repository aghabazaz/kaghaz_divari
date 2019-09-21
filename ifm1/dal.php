<?php

namespace f ;

abstract class dal extends component
{

    /**
     *
     * @var \f\g\session
     */
    protected $sessionG ;

    /**
     *
     * @var \f\g\coding
     */
    protected $codingG ;

    /**
     *
     * @var \f\g\validator
     */
    protected $validatorG ;

    /**
     *
     * @var \f\sqlStorageEngine
     */
    public $sqlEngine ;

    /**
     *
     * @var \f\cacheStorageEngine 
     */
    public $cacheEngine ;

    /**
     *
     * @var request 
     */
    protected $request ;

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

}
