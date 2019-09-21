<?php

namespace f\w ;

class clientAction extends \f\view
{

    public function addClientAction($options)
    {

        if ( ! isset($options[ 'action' ]) )
        {
            return '' ;
        }

        $action = $options[ 'action' ] ;
        if ( isset($action[ 'preServerSideAction' ]) )
        {
            $preServerSideOptions = $action[ 'preServerSideAction' ] ;
            $serverResult         = \f\ttt::service($preServerSideOptions[ 'route' ],
                                                    array (
                        'options' => $preServerSideOptions[ 'options' ]
                    )) ;
            $action[ 'params' ][ 'targetRoute' ] .= '.' . $serverResult ;
        }

        if ( isset($action[ 'params' ][ 'urlParams' ]) )
        {
            foreach ( $action[ 'params' ][ 'urlParams' ] as $urlParam )
            {
                $action[ 'params' ][ 'targetRoute' ] .= '.' . $urlParam ;
            }
        }
        $pathToDisplayScript = __DIR__ . \f\DS . 'display' . \f\DS . "{$action[ 'display' ]}.js.php" ;

        return $this->iinclude($pathToDisplayScript, $action[ 'params' ]) ;
    }

}
