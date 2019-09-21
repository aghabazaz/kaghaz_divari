<?php

namespace f ;

class publicException extends \Exception
{

    public function __construct($message)
    {
        parent::__construct($message, 0) ;
        pr('Exception raised with message : ' . $message) ;
        pre($this->getTraceAsString()) ;
    }

}
