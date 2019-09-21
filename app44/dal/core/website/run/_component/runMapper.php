<?php

class runMapper extends \f\dal
{

    public function __construct()
    {
        $this->sqlEngine   = new \f\sqlStorageEngine ;
        $this->cacheEngine = new \f\cacheStorageEngine ;
    }

    public function getDomainInfo()
    {
        $params     = $this->request->getAssocParams() ;
        $domainName = $params[ 'domainName' ] ;
		//echo $domainName;
        
                
        $this->cacheAllDomainsInfo() ;
        
        //$this->cacheEngine->clear();
        if ( $this->cacheEngine->exists("domainsInfo-$domainName") )
        {
            //\f\pre('okk');
            return $this->cacheEngine->fetch("domainsInfo-$domainName") ;
        }

        # Domain was not cached previousely

        $cacheSingleDomainResult = $this->cacheSingleDomain($domainName) ;
        
        //\f\pre($cacheSingleDomainResult);

        return $cacheSingleDomainResult ;
    }

    private function cacheAllDomainsInfo($refresh = false)
    {
        if ( ! $refresh && $this->cacheEngine->fetch('domainsInfoCached') )
        {
            return 'Already cached' ;
        }

        $this->sqlEngine->Select('
            D.domain as domainName, 
            D.status as domainStatus, 
            W.core_userid as websiteOwner,
            T.name as templateName,
            I.*')
                ->From('core_domain as D')
                ->joinTable('core_website as W')
                ->On('D.core_websiteid = W.id')
                ->joinTable('core_website_core_template as WT')
                ->On('W.id = WT.core_websiteid')
                ->joinTable('core_template as T')
                ->On('WT.core_templateid = T.id')
                ->joinTable('core_website_info as I')
                ->On('W.id = I.core_websiteid')
                ->Run() ;

        $allInfo = $this->sqlEngine->getRows() ;

        foreach ( $allInfo as $info )
        {
            # Get url aliases
            $pathToUrlFile = \f\ifm::app()->templateDir . \f\DS . $info[ 'templateName' ] . \f\DS . 'url.php' ;
            include $pathToUrlFile ;

            if ( isset($urlAliases) )
            {
                $info[ 'urlAliases' ] = $urlAliases ;
                unset($urlAliases) ;
            }

            $infoKeyInCache = "domainsInfo-{$info[ 'domainName' ]}" ;

            $this->cacheEngine->store($infoKeyInCache, $info) ;
        }

        $this->cacheEngine->store('domainsInfoCached', true) ;

        return 'Successfully cached' ;
    }

    private function cacheSingleDomain($domainName)
    {
        //\f\pre('okkk');
        $this->sqlEngine->Select('
            D.domain as domainName, 
            D.status as domainStatus, 
            W.core_userid as websiteOwner,
            T.name as templateName,
            I.*')
                ->From('core_domain as D')
                ->joinTable('core_website as W')
                ->On('D.core_websiteid = W.id')
                ->joinTable('core_website_core_template as WT')
                ->On('W.id = WT.core_websiteid')
                ->joinTable('core_template as T')
                ->On('WT.core_templateid = T.id')
                ->joinTable('core_website_info as I')
                ->On('W.id = I.core_websiteid')
                ->Where('D.domain = ?', $domainName)
                ->Run() ;

        $domainInfo = $this->sqlEngine->getRow() ;

        if ( empty($domainInfo) )
        {
            return 'Domain Was Not Found' ;
        }

        $infoKeyInCache = "domainsInfo-{$domainInfo[ 'domainName' ]}" ;
        $this->cacheEngine->store($infoKeyInCache, $domainInfo) ;

        return $domainInfo ;
    }

    public function refreshDomainsInformation()
    {	
        $this->cacheAllDomainsInfo(true) ;
    }

}
