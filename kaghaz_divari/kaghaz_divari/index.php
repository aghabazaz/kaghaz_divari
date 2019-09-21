<?php

namespace f ;


error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors','off');
define('domainName', $_SERVER['HTTP_HOST']) ;
date_default_timezone_set('Asia/Tehran') ;
const DOMAIN = domainName ;
const domain= domainName ;
const DS     = DIRECTORY_SEPARATOR ;
const ROOT   = __DIR__ ;



/** Static Application configuration and bootstrap file address */
$config      = ROOT . DS . 'config' . DS . 'main.php' ;
$pathToIFM   = ROOT . DS . 'ifm' . DS . 'ifm.php' ;
$pathToDebug = ROOT . DS . 'ifm' . DS . 'debug.php' ;

require_once $pathToDebug ;

/** Load bootstraper. */
require_once $pathToIFM ;


//\f\pre('ok');
/** Create and Run the application based on configuration */
$app = ifm::createApplication($config) ;

$runResult = $app->run() ;

/** Run Legacy system * */
if ( ! $runResult )
{
    unset($app) ;
    spl_autoload_unregister(array (
        'f\ifm',
        'autoload' )) ;
    $isLegacy = true;
	//echo 'nooo';
    //include __DIR__ . DS . ".." . DS . "indexBack.php" ;
    die ;
}

