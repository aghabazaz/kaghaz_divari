<?php

class runService extends \f\service
{

    public function getDomainInfo()
    {
        $this->refreshDomainsInformation() ; # temporary
        return \f\ttt::dal('core.website.run.getDomainInfo', $this->request) ;
    }

    public function refreshDomainsInformation()
    {
        \f\ttt::dal('core.website.run.refreshDomainsInformation') ;
    }

}
