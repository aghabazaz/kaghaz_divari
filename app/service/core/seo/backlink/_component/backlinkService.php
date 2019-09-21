<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \core\seo\backlink
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class backlinkService extends \f\service
{

    public function __construct ()
    {
        $this->mapper = \f\dalFactory::make ( 'core.seo.backlink' ) ;
    }

    public function backlinkList ()
    {
        return \f\ttt::dal ( 'core.seo.backlink.backlinkList',
                             $this->request->getAssocParams () ) ;
    }

    public function backlinkDelete ()
    {
        return \f\ttt::dal ( 'core.seo.backlink.backlinkDelete',
                             $this->request->getAssocParams () ) ;
    }

    public function getBacklinkById ()
    {
        return \f\ttt::dal ( 'core.seo.backlink.getBacklinkById',
                             $this->request->getAssocParams () ) ;
    }

    public function updateInfo ()
    {
        $row = \f\ttt::dal ( 'core.seo.backlink.getBacklinkById',
                             $this->request->getAssocParams () ) ;

        foreach ( $row AS $data )
        {
            $alexa       = $this->alexa_rank ( $data[ 'domain' ] ) ;
            $alexa[ 'id' ] = $data[ 'id' ] ;

            $result = \f\ttt::dal ( 'core.seo.backlink.saveBacklinkInfo', $alexa ) ;
        }
        if ( $result )
        {
            return array (
                'result' => 'success' ) ;
        }
        else
        {
            return array (
                'result' => 'error' ) ;
        }
    }

    private function alexa_rank ( $sWebSite )
    {
        if ( $source = simplexml_load_file ( 'http://data.alexa.com/data?cli=10&url=' . $sWebSite ) )
        {
            if ( $source->SD->COUNTRY[ 'RANK' ] )
            {
                $countryArr = $this->xml2array ( $source->SD->COUNTRY[ 'RANK' ] ) ;
                $country    = $countryArr[ 0 ] ;

                $countryCodeArr = $this->xml2array ( $source->SD->COUNTRY[ 'CODE' ] ) ;
                $countryCode    = strtolower ( $countryCodeArr[ 0 ] ) ;
            }
            else
            {
                $country     = NULL ;
                $countryCode = NULL ;
            }
            if ( $source->SD->POPULARITY[ 'TEXT' ] )
            {
                $popularityArr = $this->xml2array ( $source->SD->POPULARITY[ 'TEXT' ] ) ;
                $popularity    = $popularityArr[ 0 ] ;
            }
            else
            {
                $popularity = NULL ;
            }
        }
        else
        {
            $country    = NULL ;
            $popularity = NULL ;
        }


        return array (
            'alexa_country_rank' => $country,
            'alexa_world_rank'   => $popularity,
            'alexa_country_code' => $countryCode,
                ) ;
    }

    function xml2array ( $xmlObject, $out = array () )
    {
        foreach ( ( array ) $xmlObject as $index => $node )
                $out[ $index ] = ( is_object ( $node ) ) ? xml2array ( $node ) : $node ;

        return $out ;
    }

}
