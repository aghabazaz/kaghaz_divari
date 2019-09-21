<?php

class productMapper extends \f\dal
{

    public function __construct()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
    }

    public function getProductsList()
    {
        $this->sqlEngine->Select()
                ->From('core_product')
                ->Run() ;

        return $this->sqlEngine->getRows() ;
    }

}
