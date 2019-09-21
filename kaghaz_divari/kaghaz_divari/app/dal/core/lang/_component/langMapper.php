<?php

class langMapper extends \f\dal
{

    public function __construct()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
    }

    public function getLangCodes()
    {
        $this->sqlEngine->Select('code')
                ->From('core_lang')
                ->Run() ;

        return $this->sqlEngine->getRows() ;
    }
    
    public function activeLang()
    {
        $this->sqlEngine->Select()
                ->From('core_lang')
                ->Where('status=?','enabled')
                ->Run();
        
        return $this->sqlEngine->getRows ();
    }

}
