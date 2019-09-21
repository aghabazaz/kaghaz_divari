<?php

class websiteMapper extends \f\dal
{

    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
    }

    public function getWebsiteInfo ()
    {
        $params = $this->request->getAssocParams () ;

        $this->sqlEngine->Select ( 't2.*' )
                ->From ( 'core_website AS t1' )
                ->Join ( 'core_website_info AS t2' )
                ->Where ( 't1.core_userid=?', $params[ 'ownerId' ] )
                ->andWhere ( 't1.id=t2.core_websiteid' )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function websiteSettingSave ()
    {
        $params = $this->request->getAssocParams () ;

        //\f\pre($params);

        $result = $this->sqlEngine->save ( 'core_website_info',
                                           array (
            'title'           => $params[ 'title' ],
            'keywords'        => $params[ 'keywords' ],
            'description'     => $params[ 'description' ],
            'logo'            => $params[ 'logo' ],
            'logo_url'        => $params[ 'logo_url' ],
            'logo_footer'     => $params[ 'logo_footer' ],
            'logo_footer_url' => $params[ 'logo_footer_url' ],
            'favicon'         => $params[ 'favicon' ],
            'construction'    => $params[ 'construction' ],
            'mobileTemplate'  => $params[ 'mobileTemplate' ]
                ), array (
            'id=?',
            array (
                $params[ 'id' ] ) ) ) ;

//\f\pre($this->sqlEngine->last_query());

        return $result ;
    }

}

?>
