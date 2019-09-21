<?php

namespace f ;

class response extends component
{

    /**
     *
     * @var string 
     */
    private $type ;

    /**
     *
     * @var array/string 
     */
    private $data ;

    /**
     *
     * @var array 
     */
    private $availableTypes ;

    public function __construct()
    {
        $this->availableTypes = array (
            'layouted',
            'partial',
            'json'
                ) ;
    }

    public function setType($type)
    {
        if ( in_array($type, $this->availableTypes) )
        {
            $this->type = $type ;
        }
        else
        {
            throw new publicException("'$type' is not a valid response type ! framework bug !") ;
        }
    }

    public function getType()
    {
        return $this->type ;
    }

    public function setData($data)
    {
        if ( ! empty($data) )
        {
            $this->data = $data ;
        }
        else
        {
            throw new publicException('Response data cannot be empty !') ;
        }
    }

    public function getData()
    {
        return $this->data ;
    }

}
