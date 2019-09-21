<?php

namespace f ;

const IFMBaseDir = __DIR__ ;

/**
 * Any Framework base functionalities can be customized here.
 */
class ifm
{

    /**
     * @var application contains running application.
     */
    private static $_app ;
    private static $lang ;

    public static function createApplication($config = null)
    {
        $app = new application($config) ;
        self::setApplication($app) ;
        //\f\pre($app);
        return $app ;
    }

    /**
     * Registers created application to be useable in hole application.
     * 
     * @param application $app Contains created application.
     * @throws Exception
     */
    private static function setApplication($app)
    {
        if ( self::$_app === null || $app === null )
        {
            self::$_app = $app ;
        }
        else
        {
            throw new \Exception('Application already created.') ;
        }
    }

    /**
     * Returns the application singleton or null if the singleton has not been created yet.
     * @return application the application singleton, null if the singleton has not been created yet.
     */
    public static function app()
    {
        return self::$_app ;
    }

    private static function translate($paths, $requestedLang, $message)
    {
        foreach ( $paths as $pathToLangFile )
        {
            if ( file_exists($pathToLangFile) )
            {
                require $pathToLangFile ;
                if ( isset($lang[ $message ]) ) #cache lang file 
                {
                    foreach ( $lang as $key => $value )
                    {
                        self::$lang[ $requestedLang ][ $key ] = $value ;
                    }
                    return $lang[ $message ] ;
                }
                unset($lang) ;
            }
        }
    }

    public static function t($message, $customLang = 'fa')
    {
        //\f\pre( 'okkkk');
        //$requestedLang = self::app()->lang ;

        if ( ! empty($customLang) )
        {
            $requestedLang = $customLang ;
        }
        

        if ( empty(self::$lang) || ! isset(self::$lang[ $requestedLang ][ $message ]) ) # find and cache
        {
            $paths = array (
                self::app()->componentBaseDir . DS . 'view' . DS . 'lang' . DS . $requestedLang . '.php',
                self::app()->uiDir . DS . 'lang' . DS . $requestedLang . '.php'
                    ) ;
            
            //\f\pr($paths);
            return self::translate($paths, $requestedLang, $message) ;
        }
        else
        {
            return self::$lang[ $requestedLang ][ $message ] ;
        }
        return $message ;
    }

    /**
     * Translate a key given in english into target language.
     * 
     * @param string $key the key name in english
     * @param string $customeLangCode targetLangCode
     * @param string $componentPath componentPath
     */
    public static function t2($key, $langCode = '', $componentPath = '')
    {
        if ( empty($componentPath) )
        {
            $componentPath = self::app()->RCP ;
        }

        if ( empty($langCode) )
        {
            $langCode = self::app()->lang ;
        }

        $translateResult = \f\ttt::service('core.lang.translate',
                                           array (
                    'key'           => $key,
                    'langCode'      => $langCode,
                    'componentPath' => $componentPath
                )) ;

        return $translateResult ;
    }

    /**
     * 
     * @param string $fullClassName the framework class to be load
     */
    public static function autoload($fullClassName)
    {
        $classNameParts = explode('\\', $fullClassName) ;
        $className      = end($classNameParts) ;
        $classFileName  = $className . '.php' ;

        $pathToClassFile = '' ;

        if ( file_exists(IFMBaseDir . DS . $classFileName) )
        {
            $pathToClassFile = IFMBaseDir . DS . $classFileName ;
        }
        else
        {
            return ;
        }
        require_once $pathToClassFile ;
    }

    public static function propagate($params)
    {
        \f\ttt::service('core.signal.propagate',
                        array (
            'params' => $params
        )) ;
    }
    
     public static function faDigit ( $str )
    {
        $newstring = str_replace ( array (
            '0',
            '1',
            '2',
            '3',
            '4',
            '5',
            '6',
            '7',
            '8',
            '9' ), array (
            '۰',
            '۱',
            '۲',
            '۳',
            '۴',
            '۵',
            '۶',
            '۷',
            '۸',
            '۹' ), $str ) ;
        return $newstring ;
    }


}

spl_autoload_register(array (
    'f\ifm',
    'autoload' )) ;
