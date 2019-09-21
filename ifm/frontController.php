<?php

namespace f;

/**
 * Application Entry points
 */
class frontController extends component
{

    private static function accessDenied ( $requestType )
    {
        if ( $requestType == 'service' )
        {
            echo json_encode( [
                'result'  => 'failed',
                'message' => 'You have not access to the requested service !'
            ] );
        } else
        {
            if ( \f\ifm::app()->rbacStatus == 'enabled' )
            {
                die ( 'Permission denied !' );
            }
        }

        return true;
    }

    private static function checkRunPermission ( &$translateResult )
    {


        $request = self::makeRequest( $translateResult['requestParams'] );
        //\f\pr($request);
        /** compare requested path to not login required paths * */
        $notLoginRequiredPaths = \f\ttt::service( 'core.auth.notLoginRequiredPaths' );


        if ( in_array( $translateResult['requestCatalog'],
            $notLoginRequiredPaths ) )
        {


            return true;
        }

# Check user login and permision to run the request
# 
# Backward compatibility ########################## Start

        $sessionId = $request->getParam( 'sessionId' );

        //\f\pre($sessionId);


        /*         * * Front service request from legacy system ** */

        $agencyId = $request->getParam( 'agencyId' );


        if ( $agencyId )
        {
            \f\ttt::service( 'core.auth.registerAgencyId',
                [
                    'agencyId' => $agencyId
                ] );
        }

        if ( $translateResult['requestType'] !== 'service' && $sessionId )
        {

            $runPermission = \f\ttt::service( 'core.auth.checkPermission',
                [
                    'path'      => $translateResult['requestCatalog'],
                    'sessionId' => $sessionId
                ] );
        } else if ( $translateResult['requestType'] !== 'service' && !$sessionId )
        {


            $runPermission = \f\ttt::service( 'core.auth.checkPermission',
                [
                    'path' => $translateResult['requestCatalog'],
                ] );
            //var_dump($runPermission) ;
        } else if ( $translateResult['requestType'] === 'service' )
        {
            return;
        }


# Backward compatibility ########################## Finish
        //\f\pr($runPermission);

        if ( $runPermission === 'Authentication_Failed' && $translateResult['requestType'] !== 'service' ) # Authentication failed
        {

            self::redirectToLogin();
        } else if ( $runPermission === 1 && $translateResult['requestType'] !== 'service' ) # Access denied
        {

            self::accessDenied( 'ui' );
        }

        $translateResult['methodFilter'] = $runPermission;
    }

    public static function redirectToLogin ()
    {
        header( "Location: " . \f\ifm::app()->siteUrl . "administrator/login" ); //core/auth/login
    }

    public static function run ()
    {

        $translateResult = self::translateRequest();

        //\f\pre($translateResult);

        # Request is not in the new systsm
        if ( empty ( $translateResult ) )
        {
            return false;
        }


        $checkPermissionNeeded = $translateResult['requestType'] !== 'ui.frontend';
        $checkPermissionNeeded = $checkPermissionNeeded && $translateResult['requestType'] !== 'page';

        if ( $checkPermissionNeeded )
        {

            self::checkRunPermission( $translateResult );
        }

        $runResult = self::runRequest( $translateResult );

        return $runResult;
    }

    private static function translateRequest ()
    {
        $enteredUrl  = self::alias( $_GET['url'] );
        $_GET['url'] = $enteredUrl;
        $urlParts    = array_filter( explode( '/',$enteredUrl ) );


        /** Define what URL is service request, what is backend UI and what is front end request * */
        switch ( $urlParts[0] )
        {
            /** Service requested * */
            case 'api':
                unset ( $urlParts[0] );
                return \f\ttt::service( 'core.code.translateRequest',
                    [
                        'urlParts'    => $urlParts,
                        'requestType' => 'service',
                    ] );

            /** Backend UI Requested * */
            case ifm::app()->appName:
                unset ( $urlParts[0] );
                //define('langActive', \f\ttt::service('core.lang.getAllActiveLangArray'));
                return \f\ttt::service( 'core.code.translateRequest',
                    [
                        'urlParts'    => $urlParts,
                        'requestType' => 'ui.backend',
                    ] );
            /** Frontend UI / website page Request * */
            default :

                return \f\ttt::service( 'core.code.translateRequest',
                    [
                        'urlParts'    => $urlParts,
                        'requestType' => 'ui.frontend',
                    ] );
        }
        return false;
    }

    private static function runRequest ( $translateResult )
    {
        //\f\pre($translateResult[ 'requestType' ]);
        switch ( $translateResult['requestType'] )
        {
            case 'service' :

                self::setEnvVariables( [
                    'componentRoute' => $translateResult['requestCatalog'],
                    'componentType'  => $translateResult['requestType'],
                ] );
                self::setLang();
                if (isset ($_SERVER['HTTP_ORIGIN'])) {
                    header("Access-Control-Allow-Origin: {$_SERVER[ 'HTTP_ORIGIN' ]}");
                    header('Access-Control-Allow-Credentials: true');
                    header('Access-Control-Max-Age: 86400');    // cache for 1 day
                }

                // Access-Control headers are received during OPTIONS requests
                if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

                    if (isset ($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

                    if (isset ($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                        header("Access-Control-Allow-Headers:        {$_SERVER[ 'HTTP_ACCESS_CONTROL_REQUEST_HEADERS' ]}");

                    exit (0);
                }
//                echo json_encode( ttt::service( $translateResult['requestCatalog'],
//                    $request ) );

                $request = self::makeRequest( $translateResult['requestParams'] );
                $token = $request->getParam('token');
                if (\f\ifm::app()->apiTokenStatus == 'disabled' || (\f\ifm::app()->apiTokenStatus == 'enabled' && \f\ifm::app()->apiTokenValue == $token)) {
                    $request->deleteParam('token');
                    header('Content-Type: application/json');
                    echo json_encode(ttt::service($translateResult['requestCatalog'],
                        $request),
                        JSON_UNESCAPED_UNICODE);
                }

                break;
            case 'ui.backend':

                $request = self::makeRequest( $translateResult['requestParams'] );
                if ( isset ( $translateResult['methodFilter'] ) )
                {

                    $request->addAssocParam( [
                        'methodFilter' => $translateResult['methodFilter']
                    ] );
                }
                self::setEnvVariables( [
                    'componentRoute' => $translateResult['requestCatalog'],
                    'componentType'  => $translateResult['requestType'],
                ] );
                self::setLang();
                ifm::app()->setRunningModule( 'ui.backend' );
                echo ttt::ui( 'ui.backend.' . $translateResult['requestCatalog'],
                    $request );
                break;
            case 'ui.frontend':


                require_once 'MobileDetect.php';
                $device       = new MobileDetect;
                $websiteInfo  = $translateResult['websiteInfo'];
                $templateName = $translateResult['templateName'];

                $request = self::makeRequest( $translateResult['requestParams'] );
                //\f\pre( $websiteInfo);
                if ( $device->isMobile() && $websiteInfo['mobileTemplate'] == 'enabled' )
                {
                    $templateName                    .= '-mobile';
                    $translateResult['templateName'] = $templateName;
                    $request->addAssocParam(['mobileDevice'=>TRUE]);
                }


                //\f\pre($request);


                $request->addAssocParam( [
                    'templateName' => $translateResult['templateName'],
                    'pageName'     => $translateResult['page'],
                    'domainStatus' => $translateResult['domainStatus']
                ] );
                if ( $translateResult['page'] != 'page' )
                {
                    $request->addAssocParam( [
                        'websiteInfo' => $translateResult['websiteInfo']
                    ] );
                }

                self::setEnvVariables( [
                    'componentRoute' => $translateResult['requestCatalog'],
                    'componentType'  => $translateResult['requestType'],
                ] );
                self::setLang();
                ifm::app()->setRunningModule( 'ui.frontend' );

                echo ttt::ui( 'ui.frontend.' . $translateResult['requestCatalog'],
                    $request );

                break;

            case 'page':

                require_once 'MobileDetect.php';
                $device       = new MobileDetect;
                $websiteInfo  = $translateResult['websiteInfo'];
                $templateName = $translateResult['templateName'];
                //\f\pre( $websiteInfo);
                if ( $device->isMobile() && $websiteInfo['mobileTemplate'] == 'enabled' )
                {
                    $templateName                    .= '-mobile';
                    $translateResult['templateName'] = $templateName;
                }

                ifm::app()->setRunningModule( 'page' );
                echo siteLoader::load( $translateResult );
                break;
        }
        return true;
    }

    private static function setEnvVariables ( $params )
    {
        $componentRouteParts = explode( '.',$params['componentRoute'] );
        $runningUI           = $componentRouteParts[0];

        $runningComponent = '';
        if ( count( $componentRouteParts ) > 2 )
        {
            $runningComponent = $componentRouteParts[1];
        }

        unset ( $componentRouteParts[count( $componentRouteParts ) - 1] );
        $componentRoute    = implode( '.',$componentRouteParts );
        $componentRouteDS  = str_replace( '.',DS,$componentRoute );
        $componentRouteURL = str_replace( '.','/',$componentRoute );

        $componentTypeDS  = str_replace( '.',DS,$params['componentType'] );
        $componentTypeURL = str_replace( '.','/',$params['componentType'] );

        ifm::app()->configure( [
            'componentBaseUrl' => 'http://' . ifm::app()->domain . "/app/$componentTypeURL/" . $componentRouteURL . '/_component/',
            'componentBaseDir' => ifm::app()->repoDir . DS . $componentTypeDS . DS . $componentRouteDS . DS . '_component',
            'runningUI'        => $runningUI,
            'runningComponent' => $runningComponent,
            'RCP'              => $componentRoute # Running component path
        ] );
    }

    private static function setLang ()
    {
        $lang = ifm::app()->defaultLang;
        if ( isset ( $_COOKIE['lang'] ) && in_array( $_COOKIE['lang'],
                \f\ttt::service( 'core.lang.getLangCodes' ) ) )
        {
            $lang = $_COOKIE['lang'];
        }
        ifm::app()->configure( [
            'lang' => $lang
        ] );
    }

    private static function makeRequest ( $urlParts )
    {

        $postParams = $_POST;

        $paramsIsSerialized = isset ( $_POST['____type'] ) && $_POST['____type'] === 'serialized';

        $paramsIsSerialized = $paramsIsSerialized && ( !empty ( $_POST['serializedParams'] ) );

        if ( $paramsIsSerialized )
        {
            $postParams = unserialize( $_POST['serializedParams'] );
        }

        $files = count( $_FILES ) ? [ 'files' => $_FILES ] : [];

        $request = new request;
        $request->addNonAssocParam( $urlParts );
        $request->addAssocParam( $postParams );
        $request->addAssocParam( $files );
        return $request;
    }

    private static function alias ( $url )
    {
        $alises = ifm::app()->urlAliases;

        if ( isset ( $alises[$url] ) )
        {
            return $alises[$url];
        }

        return $url;
    }

}
