<?php

/**
 * Database
 */
class autoCompleteMapper extends \f\dal
{

    
    public function __construct()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
      
    }
    public function getData ()
    {
        $ownerId = \f\ttt::service ( 'core.auth.getUserOwner' ) ;
        $col=$this->request->getParam('col');
        $tbl=$this->request->getParam('tbl');
        $this->sqlEngine->Select("$col AS lable,id,$col AS value")
                ->From($tbl)
                ->Where("$col LIKE '%".$this->request->getParam('q')."%'")
                ->andWhere('owner_id=?',$ownerId)
                ->GroupBy ("$col ASC")
                
                ->Run();
        
        //\f\pr($this->sqlEngine->last_query());
        return $this->sqlEngine->getRows ();
    }

}
