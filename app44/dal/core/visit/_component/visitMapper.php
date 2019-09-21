<?php

class visitMapper extends \f\dal
{

    private $tbl_VisitDay     = 'visit_day' ;
    private $tbl_VisitUrl     = 'visit_url' ;
    private $tbl_VisitBrowser = 'visit_browser' ;
    private $tbl_VisitOs      = 'visit_os' ;
    private $tbl_VisitCountry = 'visit_country' ;
    private $tbl_VisitInf     = 'visit_inf' ;
    private $tbl_Alexa        = 'visit_alexa' ;
    private $tbl_Backlink     = 'visit_backlink' ;

    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
    }

    public function getDataVisit ()
    {
        $params  = $this->request->getAssocParams () ;
        $ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;
        if(!$ownerId)
        {
            $ownerId = \f\ttt::dal ( 'core.auth.getOwnerFront' ) ;
        }
        $date    = date ( 'Ymd' ) ;
        $this->sqlEngine->Select ( 'date,num_visit,num_visitor' )
                ->From ( $this->tbl_VisitInf )
                ->Where ( 'date<=?', $date )
                ->andWhere ( 'owner_id=?', $ownerId ) ;
        if ( $params[ 'site_id' ] )
        {
            $this->sqlEngine->andWhere ( 'site_id=?', $params[ 'site_id' ] ) ;
        }
        $this->sqlEngine->OrderBy ( 'date DESC' )
                ->Limit ( 2 )
                ->Run () ;

        $tody = $this->sqlEngine->getRow () ;

        $yesterday = $this->sqlEngine->getRow () ;

        if ( $params[ 'site_id' ] )
        {
            $site_id = 'AND  site_id=' . $params[ 'site_id' ] ;
        }
        else
        {
            $site_id = '' ;
        }
        $this->sqlEngine->Select ( 'date,num_visit' )
                ->From ( $this->tbl_VisitInf )
                ->Where ( 'num_visit = (SELECT MAX(num_visit) FROM visit_inf WHERE owner_id=? ' . $site_id . ')',
                          $ownerId )
                ->Run () ;

        $row              = $this->sqlEngine->getRow () ;
        $max[ 'num_visit' ] = $row[ 'num_visit' ] ;

        $max[ 'date' ] = $row[ 'date' ] ;
        return array (
            'today'     => $tody,
            'yesterday' => $yesterday,
            'max'       => $max ) ;
    }

    public function visitAll ()
    {
        $params  = $this->request->getAssocParams () ;
        $ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;
        if(!$ownerId)
        {
            $ownerId = \f\ttt::dal ( 'core.auth.getOwnerFront' ) ;
        }
        $this->sqlEngine->Select ( 'SUM(num_visit) AS all_visit' )
                ->From ( $this->tbl_VisitInf )
                ->Where ( 'owner_id=?', $ownerId ) ;
        if ( $params[ 'site_id' ] )
        {
            $this->sqlEngine->andWhere ( 'site_id=?', $params[ 'site_id' ] ) ;
        }

        $this->sqlEngine->Run () ;
        $row = $this->sqlEngine->getRow () ;

        return $row[ 'all_visit' ] ;
    }

    public function visitDay ()
    {
        $params  = $this->request->getAssocParams () ;
        $ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;
        $this->sqlEngine->Select ()
                ->From ( $this->tbl_VisitDay )
                ->Where ( 'owner_id=?', $ownerId ) ;
        if ( $params[ 'site_id' ] )
        {
            $this->sqlEngine->andWhere ( 'site_id=?', $params[ 'site_id' ] ) ;
        }
        $this->sqlEngine->OrderBy ( 'id DESC' )
                ->Limit ( 20 )
                ->Run () ;

        return $this->sqlEngine->getRows () ;
    }

    public function getCountryArray ()
    {
        $this->sqlEngine->Select ( 'code,countryNameFa' )
                ->From ( 'country' )
                ->Run () ;

        $row = $this->sqlEngine->getRows () ;

        foreach ( $row AS $data )
        {
            $arr[ $data[ 'code' ] ] = $data[ 'countryNameFa' ] ;
        }

        return $arr ;
    }

    public function getChartByCount ()
    {

        $param   = $this->request->getAssocParams () ;
        //\f\pre($param);
        $ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;

        $this->sqlEngine->Select ( $param[ 'col' ] . ' AS columns, SUM(num_visit) AS rows' )
                ->From ( $param[ 'tbl' ] . ' AS t1' )
                ->Where ( 'owner_id=?', $ownerId ) ;
        if ( $param[ 'siteId' ] )
        {
            $this->sqlEngine->andWhere ( 'site_id=?', $param[ 'siteId' ] ) ;
        }
        $this->sqlEngine->GroupBy ( 't1.' . $param[ 'col' ] )
                ->OrderBy ( 'rows DESC' )
                ->Run () ;

        return $this->sqlEngine->getRows () ;
    }

    public function getChartByDate ()
    {
        $param   = $this->request->getAssocParams () ;
        $ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;

        $this->sqlEngine->Select ( 'date,num_visit,num_visitor' )
                ->From ( $param[ 'tbl' ] . ' AS t1' )
                ->Where ( 'owner_id=?', $ownerId ) ;
        if ( $param[ 'site_id' ] )
        {
            $this->sqlEngine->andWhere ( 'site_id=?', $param[ 'site_id' ] ) ;
        }
        $this->sqlEngine->OrderBy ( 'date DESC' )
                ->Limit ( 30 )
                ->Run () ;

        return $this->sqlEngine->getRows () ;
    }

    public function alexaRank ()
    {
        $ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;
        $this->sqlEngine->Select ()
                ->From ( $this->tbl_Alexa )
                ->Where ( 'owner_id=?', $ownerId )
                ->OrderBy ( 'date DESC' )
                ->Limit ( 2 )
                ->Run () ;
        $row     = $this->sqlEngine->getRows () ;

        return (array (
            $row[ 0 ],
            $row[ 1 ] )) ;
    }

    public function setVisit ()
    {

        $url_title = '' ;
        $ownerId   = \f\ttt::dal ( 'core.auth.getOwnerFront' ) ;

        $siteId = \f\ttt::dal ( 'core.auth.getSiteId' ) ;

        //\f\pre($siteId);
        //Get date of day 
        $date = date ( 'Ymd' ) ;
        //Get Ip of visitor
        $ip   = $_SERVER[ 'REMOTE_ADDR' ] ;

        //Get Url of visited
        $url          = $_SERVER[ 'SERVER_NAME' ] . $_SERVER[ 'REQUEST_URI' ] ;
        //Get time
        $time         = date ( 'H:i' ) ;
        //get browser
        //$ip = "".mt_rand(0,255).".".mt_rand(0,255).".".mt_rand(0,255).".".mt_rand(0,255);
        $browser      = $this->getBrowser () ;
//        $arr_location = (geoip_record_by_name ( $ip )) ;
        //get country
        
        if ( isset ( $arr_location[ 'country_code' ] ) )
        {
            $country      = $arr_location[ 'country_code' ] ;
        }
                
        else
        {
			
            $country      = $this->ip_info ( $ip, "Country Code" ) ;
			if(!$country)
			{
				$country      = 'Unknown' ;
			}
        }

        $this->sqlEngine->Select ( 'date' )
                ->From ( $this->tbl_VisitInf )
                ->Where ( 'date=?', $date )
                ->andWhere ( 'owner_id=?', $ownerId )
                ->Run () ;


        if ( $this->sqlEngine->numRows () == 0 )
        {
            $this->sqlEngine->Select ( 'date' )
                    ->From ( $this->tbl_VisitInf )
                    ->Where ( 'date=?', $date )
                    ->Run () ;

            if ( $this->sqlEngine->numRows () == 0 )
            {
                $this->sqlEngine->truncate ( $this->tbl_VisitDay )->Run () ;
                //$this->sqlEngine->truncate($this->tbl_VisitUrl)->Run();
            }
            $alexa = $this->alexa_rank () ;


            $this->sqlEngine->save ( $this->tbl_Alexa,
                                     array (
                'date'     => $date,
                'owner_id' => $ownerId,
                'country'  => $alexa[ 'country' ],
                'world'    => $alexa[ 'alexa' ],
                'domain'   => $alexa[ 'domain' ]
            ) ) ;
        }
        $this->sqlEngine->Select ( 'date' )
                ->From ( $this->tbl_VisitInf )
                ->Where ( 'date=?', $date )
                ->andWhere ( 'site_id=?', $siteId )
                ->Run () ;
        if ( $this->sqlEngine->numRows () == 0 )
        {
            $this->sqlEngine->save ( $this->tbl_VisitInf,
                                     array (
                'date'     => $date,
                'owner_id' => $ownerId,
                'site_id'  => $siteId
            ) ) ;
        }



        $this->sqlEngine->Update ( $this->tbl_VisitInf )
                ->setField ( 'num_visit=num_visit+1' )
                ->Where ( 'date=?', $date )
                ->andWhere ( 'owner_id=?', $ownerId )
                ->andWhere ( 'site_id=?', $siteId )
                ->Run () ;



        $this->sqlEngine->Select ( 'ip' )
                ->From ( $this->tbl_VisitDay )
                ->Where ( 'ip=?', $ip )
                ->andWhere ( 'owner_id=?', $ownerId )
                ->andWhere ( 'site_id=?', $siteId )
                ->Run () ;

        if ( $this->sqlEngine->numRows () == 0 )
        {
            $this->sqlEngine->Update ( $this->tbl_VisitInf )
                    ->setField ( 'num_visitor=num_visitor+1' )
                    ->Where ( 'date=?', $date )
                    ->andWhere ( 'owner_id=?', $ownerId )
                    ->andWhere ( 'site_id=?', $siteId )
                    ->Run () ;

            $this->sqlEngine->Select ( 'browserName' )
                    ->From ( $this->tbl_VisitBrowser )
                    ->Where ( 'browserName=?', $browser[ 'name' ] )
                    ->andWhere ( 'browserVersion=?', $browser[ 'version' ] )
                    ->andWhere ( 'owner_id=?', $ownerId )
                    ->andWhere ( 'site_id=?', $siteId )
                    ->Run () ;

            if ( $this->sqlEngine->numRows () == 0 )
            {
                $this->sqlEngine->Insert ( $this->tbl_VisitBrowser,
                                           'owner_id,site_id,browserName,browserVersion',
                                           4,
                                           array (
                    $ownerId,
                    $siteId,
                    $browser[ 'name' ],
                    $browser[ 'version' ] ) )->Run () ;
            }
            else
            {
                $this->sqlEngine->Update ( $this->tbl_VisitBrowser )
                        ->setField ( 'num_visit=num_visit+1' )
                        ->Where ( 'browserName=?', $browser[ 'name' ] )
                        ->andWhere ( 'browserVersion=?', $browser[ 'version' ] )
                        ->andWhere ( 'owner_id=?', $ownerId )
                        ->andWhere ( 'site_id=?', $siteId )
                        ->Run () ;
            }
            $this->sqlEngine->Select ( 'osVersion' )
                    ->From ( $this->tbl_VisitOs )
                    ->Where ( 'osVersion=?', $browser[ 'osVersion' ] )
                    ->andWhere ( 'owner_id=?', $ownerId )
                    ->andWhere ( 'site_id=?', $siteId )
                    ->Run () ;

            if ( $this->sqlEngine->numRows () == 0 )
            {
                $this->sqlEngine->Insert ( $this->tbl_VisitOs,
                                           'owner_id,site_id,osName,osVersion',
                                           4,
                                           array (
                    $ownerId,
                    $siteId,
                    $browser[ 'osName' ],
                    $browser[ 'osVersion' ] ) )->Run () ;
            }
            else
            {
                $this->sqlEngine->Update ( $this->tbl_VisitOs )
                        ->setField ( 'num_visit=num_visit+1' )
                        ->Where ( 'osVersion=?', $browser[ 'osVersion' ] )
                        ->andWhere ( 'owner_id=?', $ownerId )
                        ->andWhere ( 'site_id=?', $siteId )
                        ->Run () ;
            }
            $this->sqlEngine->Select ( 'countryName' )
                    ->From ( $this->tbl_VisitCountry )
                    ->Where ( 'countryName=?', $country )
                    ->andWhere ( 'owner_id=?', $ownerId )
                    ->andWhere ( 'site_id=?', $siteId )
                    ->Run () ;

            if ( $this->sqlEngine->numRows () == 0 )
            {
                $this->sqlEngine->Insert ( $this->tbl_VisitCountry,
                                           'owner_id,site_id,countryName', 3,
                                           array (
                    $ownerId,
                    $siteId,
                    $country ) )->Run () ;
            }
            else
            {
                $this->sqlEngine->Update ( $this->tbl_VisitCountry )
                        ->setField ( 'num_visit=num_visit+1' )
                        ->Where ( 'countryName=?', $country )
                        ->andWhere ( 'owner_id=?', $ownerId )
                        ->andWhere ( 'site_id=?', $siteId )
                        ->Run () ;
            }
        }

        $this->sqlEngine->Select ( 'url' )
                ->From ( $this->tbl_VisitUrl )
                ->Where ( 'url=?', $url )
                ->andWhere ( 'owner_id=?', $ownerId )
                ->andWhere ( 'site_id=?', $siteId )
                ->Run () ;

        if ( $this->sqlEngine->numRows () == 0 )
        {
            $this->sqlEngine->Insert ( $this->tbl_VisitUrl,
                                       'owner_id,site_id,url,last_ip_visit,last_time_visit,num_visit,title_url',
                                       7,
                                       array (
                $ownerId,
                $siteId,
                $url,
                $ip,
                time (),
                1,
                $url_title ) )->Run () ;
        }
        else
        {
            $this->sqlEngine->Update ( $this->tbl_VisitUrl )
                    ->setField ( 'last_ip_visit=?,last_time_visit=?,num_visit=num_visit+1,title_url=?',
                                 array (
                        $ip,
                        time (),
                        $url_title ) )
                    ->Where ( 'url=?', $url )
                    ->andWhere ( 'owner_id=?', $ownerId )
                    ->andWhere ( 'site_id=?', $siteId )
                    ->Run () ;
        }



        //\f\pr($_SERVER['HTTP_REFERER']);
        if ( isset ( $_SERVER[ 'HTTP_REFERER' ] ) )
        {
            preg_match ( '#^(?:http://|https://)?([^/]+)#i',
                         $_SERVER[ 'HTTP_REFERER' ], $siteName ) ;
            $backlinkDomain = str_replace ( 'www.', '', $siteName[ 1 ] ) ;
            if ( $backlinkDomain != \f\DOMAIN )
            {

                $backlink = $_SERVER[ 'HTTP_REFERER' ] ;
                $this->sqlEngine->Select ( 'domain' )
                        ->From ( $this->tbl_Backlink )
                        ->Where ( 'domain=?', $backlinkDomain )
                        ->andWhere ( 'owner_id=?', $ownerId )
                        ->andWhere ( 'site_id=?', $siteId )
                        ->Run () ;

                if ( $this->sqlEngine->numRows () == 0 )
                {
                    $this->sqlEngine->Insert ( $this->tbl_Backlink,
                                               'owner_id,site_id,domain', 3,
                                               array (
                        $ownerId,
                        $siteId,
                        $backlinkDomain ) )->Run () ;
                }
                else
                {
                    $this->sqlEngine->Update ( $this->tbl_Backlink )
                            ->setField ( 'num_visit=num_visit+1' )
                            ->Where ( 'domain=?', $backlinkDomain )
                            ->andWhere ( 'owner_id=?', $ownerId )
                            ->andWhere ( 'site_id=?', $siteId )
                            ->Run () ;
                }
            }
            else
            {

                $backlink = '--' ;
            }
        }
        else
        {
            $backlink = '--' ;
        }
        $this->sqlEngine->Insert ( $this->tbl_VisitDay,
                                   'owner_id,site_id,ip,url,time,browserName,browserVersion,country,osName,osVersion,backlink',
                                   11,
                                   array (
            $ownerId,
            $siteId,
            $ip,
            $url,
            $time,
            $browser[ 'name' ],
            $browser[ 'version' ],
            $country,
            $browser[ 'osName' ],
            $browser[ 'osVersion' ],
            $backlink ) )->Run () ;
    }

    //------------------------------------------------------------------------------------------
    function getBrowser ()
    {
        $u_agent = $_SERVER[ 'HTTP_USER_AGENT' ] ;
        $bname   = 'Unknown' ;
        $osName  = 'Unknown' ;
        $version = "" ;

        //\f\pr($u_agent);
        if ( preg_match ( '/Android/i', $u_agent ) )
        {
            $osName = 'android' ;
        }
        elseif ( preg_match ( '/linux/i', $u_agent ) )
        {
            $osName = 'linux' ;
        }
        elseif ( preg_match ( '/macintosh|mac os x/i', $u_agent ) )
        {
            $osName = 'mac' ;
        }
        elseif ( preg_match ( '/windows|win32/i', $u_agent ) )
        {
            $osName = 'windows' ;
        }
        // Next get the name of the useragent yes seperately and for good reason
        if ( (preg_match ( '/MSIE/i', $u_agent ) || preg_match ( '/Trident/i',
                                                                 $u_agent )) && ! preg_match ( '/Opera/i',
                                                                                               $u_agent ) )
        {
            $bname = 'IE' ;
            $ub    = "MSIE" ;
        }
        elseif ( preg_match ( '/Edge/i', $u_agent ) )
        {
            $bname = 'Edge' ;
            $ub    = "Edge" ;
        }
        elseif ( preg_match ( '/Firefox/i', $u_agent ) )
        {
            $bname = 'Firefox' ;
            $ub    = "Firefox" ;
        }
        elseif ( preg_match ( '/OPR/i', $u_agent ) )
        {
            $bname = 'Opera' ;
            $ub    = "OPR" ;
        }
        elseif ( preg_match ( '/Chrome/i', $u_agent ) )
        {
            $bname = 'Chrome' ;
            $ub    = "Chrome" ;
        }
        elseif ( preg_match ( '/Safari/i', $u_agent ) )
        {
            $bname = 'Safari' ;
            $ub    = "Safari" ;
        }
        elseif ( preg_match ( '/Opera/i', $u_agent ) )
        {
            $bname = 'Opera' ;
            $ub    = "Opera" ;
        }
        elseif ( preg_match ( '/Netscape/i', $u_agent ) )
        {
            $bname = 'Netscape' ;
            $ub    = "Netscape" ;
        }

        if ( preg_match ( '/Trident/i', $u_agent ) )
        {
            $version = 11 ;
        }
        else
        {
            $known   = array (
                'Version',
                $ub,
                'other' ) ;
            $pattern = '#(?<browser>' . join ( '|', $known ) .
                    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#' ;
            if ( ! preg_match_all ( $pattern, $u_agent, $matches ) )
            {
                // we have no matching number just continue
            }

            // see how many we have
            $i = count ( $matches[ 'browser' ] ) ;
            if ( $i != 1 )
            {
                //we will have two since we are not using 'other' argument yet
                //see if version is before or after the name
                if ( strripos ( $u_agent, "Version" ) < strripos ( $u_agent, $ub ) )
                {
                    $version = $matches[ 'version' ][ 0 ] ;
                }
                else
                {
                    $version = $matches[ 'version' ][ 1 ] ;
                }
            }
            else
            {
                $version = $matches[ 'version' ][ 0 ] ;
            }

            // check if we have a number
            if ( $version == null || $version == "" )
            {
                $version = "?" ;
            }
        }

        $platform = $this->getOS ( $u_agent ) ;

        return array (
            'userAgent' => $u_agent,
            'name'      => $bname,
            'version'   => intval ( $version ),
            'osVersion' => $platform,
            'osName'    => $osName,
            'pattern'   => $pattern
        ) ;
    }

    //--------------------------------------------------------------------------------
    function getOS ( $userAgent )
    {
        //\f\pr($userAgent);
        //var_dump($userAgent);
        // Create list of operating systems with operating system name as array key 
        $oses = array (
            'iPhone'         => '(iPhone)',
            'Android'        => '(Android)',
            'Windows 3.11'   => 'Win16',
            'Windows 95'     => '(Windows 95)|(Win95)|(Windows_95)', // Use regular expressions as value to identify operating system
            'Windows 98'     => '(Windows 98)|(Win98)',
            'Windows 2000'   => '(Windows NT 5.0)|(Windows 2000)',
            'Windows XP'     => '(Windows NT 5.1)|(Windows XP)',
            'Windows 2003'   => '(Windows NT 5.2)',
            'Windows Vista'  => '(Windows NT 6.0)|(Windows Vista)',
            'Windows 7'      => '(Windows NT 6.1)|(Windows 7)',
            'Windows 8'      => '(Windows NT 6.2)|(Windows 8)',
            'Windows 10'     => '(Windows NT 10.0)|(Windows 10)',
            'Windows NT 4.0' => '(Windows NT 4.0)|(WinNT4.0)|(WinNT)|(Windows NT)',
            'Windows ME'     => 'Windows ME',
            'Open BSD'       => 'OpenBSD',
            'Sun OS'         => 'SunOS',
            'Linux'          => '(Linux)|(X11)',
            'Safari'         => '(Safari)',
            'Macintosh'      => '(Mac_PowerPC)|(Macintosh)',
            'QNX'            => 'QNX',
            'BeOS'           => 'BeOS',
            'OS/2'           => 'OS/2',
            'Search Bot'     => '(nuhk)|(Googlebot)|(Yammybot)|(Openbot)|(Slurp/cat)|(msnbot)|(ia_archiver)'
        ) ;

        foreach ( $oses as $os => $pattern )
        { // Loop through $oses array
            // Use regular expressions to check operating system type
            if ( preg_match ( "/" . $pattern . "/i", $userAgent ) )
            { // Check if a value in $oses array matches current user agent.
                return $os ; // Operating system was matched so return $oses key
            }
        }
        return 'Unknown' ; // Cannot find operating system so return Unknown
    }

    //---------------------------------------------------------------------------------------
    function alexa_rank ()
    {

        $sWebSite = \f\DOMAIN ;
        //\f\pr(\f\DOMAIN);
        $sWebSite = 'systemreserve.ir' ;
        if ( $source   = simplexml_load_file ( 'http://data.alexa.com/data?cli=10&url=' . $sWebSite ) )
        {



            if ( $source->SD->COUNTRY[ 'RANK' ] )
            {
                $countryArr = $this->xml2array ( $source->SD->COUNTRY[ 'RANK' ] ) ;
                $country    = $countryArr[ 0 ] ;
            }
            else
            {
                $country = 0 ;
            }
            if ( $source->SD->POPULARITY[ 'TEXT' ] )
            {
                $popularityArr = $this->xml2array ( $source->SD->POPULARITY[ 'TEXT' ] ) ;
                $popularity    = $popularityArr[ 0 ] ;
            }
            else
            {
                $popularity = 0 ;
            }
            //\f\pr(  $popularity);
        }
        else
        {
            $country    = 0 ;
            $popularity = 0 ;
            $reach      = 0 ;
        }
        if ( $country == 0 )
        {
            //include_once \f\ifm::app()->baseDir.\f\DS.'ifm'.\f\DS.'lib'.\f\DS.'parseHtml.php';
            //$html = file_get_html("http://www.alexa.com/siteinfo/$sWebSite");
            //$data=$html->find('.metrics-data');
            //$country=  str_replace(',','', $data[1]->innertext);     
        }

        return array (
            'domain'  => $sWebSite,
            'country' => $country,
            'alexa'   => $popularity ) ;
    }

    function xml2array ( $xmlObject, $out = array () )
    {
        foreach ( ( array ) $xmlObject as $index => $node )
                $out[ $index ] = ( is_object ( $node ) ) ? xml2array ( $node ) : $node ;

        return $out ;
    }

    function ip_info ( $ip = NULL, $purpose = "location", $deep_detect = TRUE )
    {
        $output = NULL ;
        if ( filter_var ( $ip, FILTER_VALIDATE_IP ) === FALSE )
        {
            $ip = $_SERVER[ "REMOTE_ADDR" ] ;
            if ( $deep_detect )
            {
                if ( filter_var ( @$_SERVER[ 'HTTP_X_FORWARDED_FOR' ],
                                  FILTER_VALIDATE_IP ) )
                        $ip = $_SERVER[ 'HTTP_X_FORWARDED_FOR' ] ;
                if ( filter_var ( @$_SERVER[ 'HTTP_CLIENT_IP' ],
                                  FILTER_VALIDATE_IP ) )
                        $ip = $_SERVER[ 'HTTP_CLIENT_IP' ] ;
            }
        }
        $purpose    = str_replace ( array (
            "name",
            "\n",
            "\t",
            " ",
            "-",
            "_" ), NULL, strtolower ( trim ( $purpose ) ) ) ;
        $support    = array (
            "country",
            "countrycode",
            "state",
            "region",
            "city",
            "location",
            "address" ) ;
        $continents = array (
            "AF" => "Africa",
            "AN" => "Antarctica",
            "AS" => "Asia",
            "EU" => "Europe",
            "OC" => "Australia (Oceania)",
            "NA" => "North America",
            "SA" => "South America"
        ) ;
        if ( filter_var ( $ip, FILTER_VALIDATE_IP ) && in_array ( $purpose,
                                                                  $support ) )
        {
            $ipdat = @json_decode ( file_get_contents ( "http://www.geoplugin.net/json.gp?ip=" . $ip ) ) ;
            if ( @strlen ( trim ( $ipdat->geoplugin_countryCode ) ) == 2 )
            {
                switch ( $purpose )
                {
                    case "location":
                        $output    = array (
                            "city"           => @$ipdat->geoplugin_city,
                            "state"          => @$ipdat->geoplugin_regionName,
                            "country"        => @$ipdat->geoplugin_countryName,
                            "country_code"   => @$ipdat->geoplugin_countryCode,
                            "continent"      => @$continents[ strtoupper ( $ipdat->geoplugin_continentCode ) ],
                            "continent_code" => @$ipdat->geoplugin_continentCode
                        ) ;
                        break ;
                    case "address":
                        $address   = array (
                            $ipdat->geoplugin_countryName ) ;
                        if ( @strlen ( $ipdat->geoplugin_regionName ) >= 1 )
                                $address[] = $ipdat->geoplugin_regionName ;
                        if ( @strlen ( $ipdat->geoplugin_city ) >= 1 )
                                $address[] = $ipdat->geoplugin_city ;
                        $output    = implode ( ", ", array_reverse ( $address ) ) ;
                        break ;
                    case "city":
                        $output    = @$ipdat->geoplugin_city ;
                        break ;
                    case "state":
                        $output    = @$ipdat->geoplugin_regionName ;
                        break ;
                    case "region":
                        $output    = @$ipdat->geoplugin_regionName ;
                        break ;
                    case "country":
                        $output    = @$ipdat->geoplugin_countryName ;
                        break ;
                    case "countrycode":
                        $output    = @$ipdat->geoplugin_countryCode ;
                        break ;
                }
            }
        }
        return $output ;
    }

}

?>
