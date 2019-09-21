<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \chartex\core\website
 * @category component
 * @author Akram Gharakhani <akramgharakhani@yahoo.com>
 */
class websiteService extends \f\service
{

    public function __construct ()
    {
        spl_autoload_register ( array ( 'websiteService', '__autoload' ) ) ;
    }

    public function __destruct ()
    {
        spl_autoload_unregister ( 'autoload' ) ;
    }

    /**
     * 
     * ******************** Internal usage **************************
     * 
     */
    private function __autoload ( $className )
    {
        $pathToClassFile = __DIR__ . \f\DS . 'model' . \f\DS . $className . '.php' ;
        if ( file_exists ( $pathToClassFile ) )
        {
            require_once $pathToClassFile ;
        }
    }

    public function getSiteList ()
    {
        return \f\ttt::dal ( 'core.website.getSiteList',
                             $this->request->getAssocParams () ) ;
    }

    public function siteRemove ()
    {
        return \f\ttt::dal ( 'core.website.siteRemove',
                             array ( 'id' => $this->request->getParam ( 'id' ) ) ) ;
    }

    public function siteActive ()
    {
        return \f\ttt::dal ( 'core.website.siteActive',
                             array ( 'id'     => $this->request->getParam ( 'id' ), 'status' => $this->request->getParam ( 'status' ) ) ) ;
    }

    public function getUserList ()
    {
        $userList = \f\ttt::dal ( 'core.website.getUserList' ) ;
        foreach ( $userList as $resUser )
        {
            $users[ $resUser[ 'id' ] ] = ($resUser[ 'name1' ]) ? $resUser[ 'name1' ] : $resUser[ 'name2' ] ;
        }
        return $users ;
    }

    public function checkDomain ( $domain = '', $websiteId = '' )
    {
        $whois = new whois ;

        $domainWhois   = ($domain) ? $domain : $this->request->getParam ( 'domain' ) ;
        $domainWebsite = ($websiteId) ? $websiteId : $this->request->getParam ( 'websiteId' ) ;
        $checkWhois    = $whois->whoislookup ( $domainWhois ) ;
        if ( $checkWhois )
        {
            return \f\ttt::dal ( 'core.website.checkDomain',
                                 array ( 'domain'    => $domainWhois, 'websiteId' => $domainWebsite ) ) ;
        }
        else
        {
            return array ( 'result'  => 'error', 'message' => 'invalid' ) ;
        }
    }

    public function getLanguage ()
    {
        return \f\ttt::dal ( 'core.website.getLanguage' ) ;
    }

    public function getTemplate ()
    {
        return \f\ttt::dal ( 'core.website.getTemplate',
                             $this->request->getAssocParams () ) ;
    }

    public function saveSite ()
    {
        $param   = $this->request->getAssocParams () ;
        $id      = ($param[ 'id' ]) ? $param[ 'id' ] : '' ;
        $checked = $this->checkAllDomain ( $param[ 'domain' ], $id ) ;

        if ( $checked === 'ok' )
        {
            $saveMain  = $this->saveMainInfo ( $param, $id ) ;
            $websiteId = ($id) ? $id : $saveMain ;
            if ( $saveMain || $saveMain == 1 )
            {
                $this->savePartInfo ( $this->request->getAssocParams (),
                                      $websiteId ) ;
                if ( $id )
                {
                    return array ( 'success', \f\ifm::t ( 'siteEdited' ) ) ;
                }
                else
                {
                    return array ( 'success', \f\ifm::t ( 'siteAdded' ) ) ;
                }
            }
            else
            {
                return array ( 'error', \f\ifm::t ( 'db' ) ) ;
            }
        }
        else
        {
            return $checked ;
        }
    }

    private function checkAllDomain ( $domainParam, $id )
    {

        foreach ( $domainParam as $domain )
        {
            if ( $domain )
            {
                $check = $this->checkDomain ( $domain, $id ) ;
            }
            if ( $check[ 'result' ] == 'error' )
            {
                $msg = \f\ifm::t ( $check[ 'message' ] ) ;
                $out = array ( 'error', $msg ) ;
                break ;
            }
            else
            {
                $out = 'ok' ;
            }
        }
        return $out ;
    }

    private function saveMainInfo ( $param, $id )
    {

        /* @var $date \f\g\date */
        $date = \f\gadgetFactory::make ( 'date' ) ;

        $mainParam[ 'title' ]       = $param[ 'siteTitle' ][ $param[ 'language' ][ 0 ] ] ;
        $mainParam[ 'expire_date' ] = $date->dateJaToGr ( $param[ 'expireDate' ],
                                                          1 ) ;
        $mainParam[ 'core_userid' ] = $param[ 'userId' ] ;
        $mainParam[ 'status' ]      = $param[ 'status' ] ;

        return \f\ttt::dal ( 'core.website.saveSite',
                             array ( 'values' => $mainParam, 'id'     => $id ) ) ;
    }

    private function savePartInfo ( $param, $websiteId )
    {
        if ( $param[ 'id' ] )
        {
            \f\ttt::dal ( 'core.website.deletePartInfo',
                          array ( 'id' => $param[ 'id' ] ) ) ;
        }
        if ( $param[ 'language' ] )
        {
            $this->saveLangInfo ( $param, $websiteId ) ;
        }
        if ( $param[ 'domain' ] )
        {
            $this->saveDomainInfo ( $param, $websiteId ) ;
        }

        if ( ! isset ( $param[ 'settings' ] ) )
        {
            $param[ 'settings' ] = array ( ) ;
        }
        $this->saveSettings ( $param[ 'settings' ], $websiteId ) ;
    }

    private function siteSettings ()
    {
        return array (
            "showdate",
            "showTelInHeader",
            "showAdressInFooter",
            "enableIntro",
            "showCopyrightInFooter",
            "showTitleInHeader",
            'searchInSite'
                ) ;
    }

    private function siteSettingsDefaults ()
    {
        return array (
            "showdate"              => 'no',
            "showTelInHeader"       => 'no',
            "showAdressInFooter"    => 'no',
            "enableIntro"           => 'no',
            "showCopyrightInFooter" => 'no',
            "showTitleInHeader"     => 'no',
            'searchInSite'          => 'no'
                ) ;
    }

    private function saveSettings ( $settings, $websiteId )
    {

        $keyValues = $this->siteSettingsDefaults () ;
        foreach ( $settings as $key => $value )
        {
            $keyValues[ $key ] = 'yes' ;
        }

        \f\ttt::service ( 'core.setting.saveKeyGroup',
                          array (
            'keyValues' => $keyValues,
            'params'    => array (
                'userId'    => \f\ttt::dal ( 'core.auth.getUserOwner' ),
                'websiteId' => $websiteId
            )
        ) ) ;
    }

    private function saveLangInfo ( $param, $websiteId )
    {
        foreach ( $param[ 'language' ] as $key => $lang )
        {

            $templateParam[ 'core_websiteid' ]  = $websiteId ;
            $templateParam[ 'core_templateid' ] = $param[ 'template' ][ $lang ] ;
            $templateParam[ 'core_langid' ]     = $lang ;

            \f\ttt::dal ( 'core.website.saveSiteTemplate',
                          array ( 'values' => $templateParam ) ) ;

            $infoParam[ 'title' ]          = $param[ 'siteTitle' ][ $lang ] ;
            $infoParam[ 'keywords' ]       = $param[ 'keywords' ][ $lang ] ;
            $infoParam[ 'description' ]    = $param[ 'desc' ][ $lang ] ;
            $infoParam[ 'logo' ]           = $param[ 'logo' ][ $lang ] ;
            $infoParam[ 'logo_footer' ]    = $param[ 'footer' ][ $lang ] ;
            $infoParam[ 'favicon' ]        = $param[ 'icon' ][ $lang ] ;
            $infoParam[ 'core_websiteid' ] = $websiteId ;
            $infoParam[ 'core_langid' ]    = $lang ;

            \f\ttt::dal ( 'core.website.saveSiteInfo',
                          array ( 'values' => $infoParam ) ) ;
        }
    }

    public function getSettings ()
    {
        $websiteId = $this->request->getParam ( 'websiteId' ) ;

        return \f\ttt::service ( 'core.setting.getKey',
                                 array (
                    'key'    => 'showdate',
                    'params' => array (
                        'userId'    => \f\ttt::dal ( 'core.auth.getUserOwner' ),
                        'websiteId' => $websiteId
                    ) ) ) ;

        $keys = $this->siteSettings () ;

        return \f\ttt::service ( 'core.setting.getKeyGroup',
                                 array (
                    'keys'   => $keys,
                    'params' => array (
                        'userId'    => \f\ttt::dal ( 'core.auth.getUserOwner' ),
                        'websiteId' => $websiteId
                    ) ) ) ;
    }

    private function saveDomainInfo ( $param, $websiteId )
    {
        foreach ( $param[ 'domain' ] as $domain )
        {
            $domainParam[ 'domain' ]         = $domain ;
            $domainParam[ 'core_websiteid' ] = $websiteId ;
            $domainParam[ 'status' ]         = 'enabled' ;

            \f\ttt::dal ( 'core.website.saveSiteDomain',
                          array ( 'values' => $domainParam ) ) ;
        }
    }

    public function getSiteInfo ()
    {
        return \f\ttt::dal ( 'core.website.getSiteInfo',
                             $this->request->getAssocParams () ) ;
    }

    public function getSiteNameByOwnerId ()
    {
        return \f\ttt::dal ( 'core.website.getSiteNameByOwnerId' ) ;
    }

}
