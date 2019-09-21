<?php

namespace f ;

return array (
    /**
     * Application name
     */
    'appName'                   => 'administrator',
    /**
     * Application base directory
     */
    'baseDir'                   => ROOT,
    'repoDir'                   => ROOT . DS . 'app',
    'serviceDir'                => ROOT . DS . 'app' . DS . 'service',
    'uiDir'                     => ROOT . DS . 'app' . DS . 'ui',
    'dalDir'                    => ROOT . DS . 'app' . DS . 'dal',
    'templateDir'               => ROOT . DS . 'app' . DS . 'ui' . DS . 'templates' . DS . 'frontend',
    /*
     * Application upload directory
     */
    'uploadDir'                 => ROOT . DS . 'upload',
    'fileBaseUrl'               => 'http://' . DOMAIN . '/file/',
    'maxUploadSize'             => 20000000,
    /**
     * Application base url
     */
    'uploadUrl'                 => 'http://' . DOMAIN . '/upload/',
    'baseUrl'                   => 'http://' . DOMAIN . '/administrator/',
    'siteUrl'                   => 'http://' . DOMAIN . '/',
    'legacyBaseUrl'             => 'http://' . DOMAIN . '/',
    'domain'                    => DOMAIN,
    'backendTemplateUrl'        => 'http://' . DOMAIN . '/app/ui/templates/backend/',
    /**
     * Default components 
     */
    'defaultComponentName'      => 'core',
    'defaultActionName'         => 'index',
    'frontComponentName'        => 'site',
    /**
     * Template settings
     */
    'defaultBackendTemplateUrl' => 'http://' . DOMAIN . '/app/ui/templates/backend/default/',
    'defaultBackendTemplate'    => 'default',
    'defaultFrontendTemplate'   => 'base',
    /**
     * Language settings
     */
    'defaultLang'               => 'fa',
    'backendTitle'              => 'سیستم مدیریت وب سایت',
    'description' => '',
    'keywords'    => '',
    'title'       => '',
    /**
     * Domain name.
     */
    /**
     * Database variables
     */
    'database'    => array (
        'driver'     => 'mysql',
        'hostName'   => 'localhost',
        'dbName'     => 'kaghaz_divari',
        'username'   => 'root',
        'password'   => ''
    ),
    /*     * *********** */
    'rbacStatus' => 'enabled',
    /*     * *********** */
    'googleMapKey' => 'AIzaSyCzUBN0c7ufPJ8x-RNvJ520Y6O1Mlz4nCo',
    'apiTokenStatus' => 'disabled',
    'apiTokenValue' => 'Raysan@2068',
    /**
     * Base timezone of the application
     */
    'timezone'   => 'Asia/Tehran',
    'urlAliases' => array (
        /* backend aliasing */
        'administrator'       => 'administrator/core/dashboard/index',
        'administrator/'       => 'administrator/core/dashboard/index',
        'administrator/login' => 'administrator/core/auth/login',
        /* frontend aliasing */
       
        'reset'               => 'core/auth/reset',
        'panel'               => 'core/panel/index',
    )
        ) ;
