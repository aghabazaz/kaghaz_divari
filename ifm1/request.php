<?php

namespace f ;

class request
{

    /**
     * Contains Associative parameters. $_POST is an associative array.
     * If $_GET is in form of "url?key1=value1&key2key2=value2" it is assciative parameter.
     * The request object parser method is responsible to parse the url if it is
     * written to parse http requests.
     * 
     * The front end controller responsibility is to detect the type of $_GET.
     * 
     * @var array
     */
    private $assocParams ;

    /** containes Non Associatve parameters. 
     * 
     * If $_GET or any other application inputs is in form of "/param/param/param" it have no keys and only contain values.
     * In this case values should write into this variable.
     * 
     * @var array
     */
    private $nonAssocParams ;

    public function getParam($keyIndex)
    {
        if ( isset($this->assocParams[ $keyIndex ]) )
        {
            return $this->assocParams[ $keyIndex ] ;
        }
        else if ( isset($this->nonAssocParams[ $keyIndex ]) )
        {
            return $this->nonAssocParams[ $keyIndex ] ;
        }

        return false ;
    }

    public function deleteParam($keyIndex)
    {
        if ( isset($this->assocParams[ $keyIndex ]) )
        {
            unset($this->assocParams[ $keyIndex ]) ;
        }
        else if ( isset($this->nonAssocParams[ $keyIndex ]) )
        {
            unset($this->nonAssocParams[ $keyIndex ]) ;
        }
    }

    public function addNonAssocParam($param)
    {
         
        if ( is_array($param) )
        {
            foreach ( $param as $value )
            {
                $this->nonAssocParams[] = $value ;
            }
        }
        else
        {
            $this->nonAssocParams[] = $param ;
        }
    }

    public function addAssocParam($params)
    {
        foreach ( $params as $key => $value )
        {
            $this->assocParams[ $key ] = $value ;
        }
    }

    public function getNonAssocParams()
    {
       
        return $this->nonAssocParams ;
    }

    public function getAssocParams()
    {
        if ( empty($this->assocParams) )
        {
            return array () ;
        }
        return $this->assocParams ;
    }

}
