<?php

class seoMapper extends \f\dal
{

    private $seoTbl = 'core_seo_page' ;
    private $seoBacklinkTbl = 'core_seo_page_backlink' ;

    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
    }

    public function saveParameter ()
    {
        $params = $this->request->getAssocParams () ;
        $result = $this->sqlEngine->save ( $this->seoTbl, $params ) ;
        return $result ;
    }

    public function saveParameterEdit ()
    {
        $params = $this->request->getAssocParams () ;
       
        $result = $this->sqlEngine->save ( $this->seoTbl, $params,
                                           array (
            'id=?',
            array (
                $params[ 'id' ] )
        ) ) ;

        return $result ;
    }

    public function getPageInfo ()
    {
        $params = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ()
                ->From ( $this->seoTbl )
                ->Where ( 'component_id=?', $params[ 'component_id' ] )
                ->andWhere ( 'item_id=?', $params[ 'item_id' ] )
                ->Run () ;

        return $this->sqlEngine->getRow () ;
    }

    public function getBacklinkInfo ()
    {
        $params = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ()
                ->From ( $this->seoBacklinkTbl )
                ->Where ( 'core_seo_page_id=?', $params[ 'core_seo_page_id' ] )
                ->andWhere ( 'link=?', $params[ 'link' ] )
                ->Run () ;

        return $this->sqlEngine->getRow () ;
    }
    public function saveEditBacklinkInfo ()
    {
        $params = $this->request->getAssocParams () ;
        $result = $this->sqlEngine->save ( $this->seoBacklinkTbl, $params,
                                           array (
            'id=?',
            array (
                $params[ 'id' ] )
        ) ) ;

        return $result ;
    }
    public function saveBacklinkInfo ()
    {
        $params = $this->request->getAssocParams () ;
        $result = $this->sqlEngine->save ( $this->seoBacklinkTbl, $params ) ;

        return $result ;
    }

}

?>
