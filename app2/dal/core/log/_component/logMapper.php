<?php

/**
 * Database
 */
class logMapper extends \f\dal
{

    /**
     *
     * @var \f\g\validator
     */
    public $sqlEngine ;
    private $dataTable ;

    /**
     *
     * @var dataTable 
     */
    public function __construct()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
        $this->dataTable = \f\dalFactory::make('core.dataTable') ;
    }

    

    public function saveLog()
    {
        $params = $this->request->getAssocParams() ;

        $this->sqlEngine->save('core_log', $params) ;
        
        
    }
    
    public function getListLog()
    {
        $params = $this->request->getAssocParams() ;
        $this->sqlEngine->Select()
                ->From('core_log')
                ->Where('section_id=?',$params['section_id'])
                ->andWhere('path=?',$params['path'])
                ->OrderBy('id DESC')
                ->Run();
        
        return $this->sqlEngine->getRows ();
    }

  

}
