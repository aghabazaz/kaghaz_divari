<?php

namespace f ;

class siteLoader extends component
{

    /**
     * Includes a script/file and returns its output as string 
     * without printing to output.
     * @param string $pathToFile path to the file
     * @return string included file/script output
     * @throws publicException if file not exists
     */
    private static function iinclude($pathToFile, $variables)
    {
        //\f\pre($variables);
        if ( ! file_exists($pathToFile) )
        {
            throw new publicException("'$pathToFile' was not found !") ;
        }

        extract($variables) ;
        //echo $domainName;
        ob_start() ;
        include $pathToFile ;
        $fileOutput = ob_get_contents() ;
        ob_clean() ;
        return $fileOutput ;
    }

    public static function load($translateResult)
    {
         //\f\pre('ok');
        //\f\pre($translateResult);

        $templateName      = $translateResult[ 'templateName' ] ;
        $requestedPageName = $translateResult[ 'requestCatalog' ] ;
        $domainStatus      = $translateResult[ 'domainStatus' ] ;
        $websiteInfo      = $translateResult[ 'websiteInfo' ] ;

        $params = $translateResult[ 'requestParams' ] ;
        if(empty($websiteInfo))
        {
            $websiteInfo=$params['content']['websiteInfo'];
        }
        $params['websiteInfo']=$websiteInfo;

        //\f\pre($templateName);
        /*
       require_once 'MobileDetect.php';
       $device = new MobileDetect;

       //\f\pre( $websiteInfo);

       if($device->isMobile() && $websiteInfo['mobileTemplate']=='enabled')
       {
           $templateName.='-mobile';
       }
       */

        //\f\pre($templateName);
        //\f\pre(\f\mobileDetect::isMobile());

        if ( empty($requestedPageName) ) # Load home page
        {
            $requestedPageName = 'index' ;
        }

        if ( $domainStatus === 'disabled' )
        {
            $pageResult = self::loadPage('down', $templateName, $params) ;
            if ( empty($pageResult) )
            {
                return 'Site down, contact technical support..!' ;
            }
            return $pageResult ;
        }
        if ( $websiteInfo['construction'] === 'offline' )
        {
            $pageResult = self::loadPage('construct', $templateName, $params) ;
            
            //\f\pre($pageResult);
            if ( empty($pageResult) )
            {
                return 'website under cunstruction...!Coming Soon.' ;
            }
            return $pageResult ;
        }

        $pageResult = self::loadPage($requestedPageName, $templateName, $params) ;

        if ( empty($pageResult) )
        {
            $pageResult = self::loadPage('404', $templateName, $params) ;
        }

        if ( empty($pageResult) )
        {
            return '404 page not found...!' ;
        }

        return $pageResult ;
    }

    public static function getTemplatePages($templateName)
    {
		//echo $templateName.'<br>';
        
        
        $CSE = new cacheStorageEngine ;
		
		//$CSE->clear();

        $templatePagesKey = $templateName . '-template-pages' ;

        if ( $CSE->exists($templatePagesKey) )
        {
//             return $CSE->fetch($templatePagesKey) ; # temporary commented
        }

        $templateDir = ifm::app()->templateDir . \f\DS . $templateName . \f\DS . 'pages' ;

        $templatePages = scandir($templateDir) ;

        array_shift($templatePages) ;
        array_shift($templatePages) ;

        $cacheablePageNames = array () ;
		
        foreach ( $templatePages as $templatePageName )
        {
            if ( $templatePageName === 'parts' )
            {
                continue ;
            }
            $cacheablePageNames[ $templatePageName ] = 1 ;
        }

        $CSE->store($templatePagesKey, $cacheablePageNames) ;

        return $cacheablePageNames ;
    }

    public static function loadPage($requestedPageName, $templateName, $params)
    {
        require_once 'MobileDetect.php';
        $device = new MobileDetect;


       /* if($device->isMobile() && $params['websiteInfo']['mobileTemplate']=='enabled')
        {
            $params['websiteInfo']['mobileDevice']='yes';

        }
       */

        $app = ifm::app() ;

        $templatePageDir = ifm::app()->templateDir . \f\DS . $templateName . \f\DS . 'pages' . \f\DS ;

        $defaultTemplatePageDir = $app->templateDir . \f\DS . $app->defaultFrontendTemplate . \f\DS . 'pages' . \f\DS ;

        $pathToPageInSeletedTemplate = $templatePageDir . $requestedPageName . '.php' ;
        $pathToPageInDefaultTemplate = $defaultTemplatePageDir . $requestedPageName . '.php' ;

        $selectedTemplatePages = self::getTemplatePages($templateName) ;
        $defaultTemplatePages  = self::getTemplatePages($app->defaultFrontendTemplate) ;
        
        //\f\pre($params);

        if ( isset($selectedTemplatePages[ $requestedPageName . '.php' ]) )
        {
             

            return self::iinclude($pathToPageInSeletedTemplate, $params) ;
        }
        else if ( isset($defaultTemplatePages[ $requestedPageName . '.php' ]) )
        {
            //\f\pre($pathToPageInDefaultTemplate);
            return self::iinclude($pathToPageInDefaultTemplate, $params) ;
        }

        return false ;
    }

}
