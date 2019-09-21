<?php

/**
 * The signal service to connect portal applications together.
 * 
 * 
 * @author Yuness Mahdian <mehdian.y@gmail.com>
 * @package core.signal
 * @category component
 */
class signalService extends \f\service
{

    public function propagate ()
    {

        $businessEvents = \f\ttt::dal ( 'core.signal.getBusinessEvents' ) ;

        $params = $this->request->getParam ( 'params' ) ;

        //\f\pre($params);

        $eventName = $params[ 'eventName' ] ;

        if ( ! isset ( $businessEvents[ $eventName ] ) )
        {
            return false ;
        }

        $businessEventId = $businessEvents[ $eventName ][ 'id' ] ;

//        $fullPath = $params[ 'path' ] ;
//
//        $fullPathParts = explode('.', $fullPath) ;
//        $serviceName   = end($fullPathParts) ;
//
//        unset($fullPathParts[ count($fullPathParts) - 1 ]) ;
//
//        $componentPath = implode($fullPathParts, '.') ;

        $componentPath = $params[ 'path' ] ;

        $signal = $params[ 'signal' ] ;

        $destinationPaths = \f\ttt::dal ( 'core.signal.getDestinationPaths',
                                          array (
                    'sourcePath' => $componentPath
                ) ) ;

        # save signal in activity table       
        if ( $params[ 'act' ] == 'remove' )
        {
           
            \f\ttt::dal ( 'core.signal.removeActivity',
                          array (
                'path'            => $componentPath,
                'params'          => $signal,
                'businessEventID' => $businessEventId,
                'service'         => '',
                'userId'          => \f\ttt::service ( 'core.auth.getUserId' ),
            ) ) ;
        }
        else
        {
            $activityId = \f\ttt::dal ( 'core.signal.saveActivity',
                                        array (
                        'path'            => $componentPath,
                        'params'          => $signal,
                        'businessEventID' => $businessEventId,
                        'service'         => '',
                        'userId'          => \f\ttt::service ( 'core.auth.getUserId' ),
                        'act'             => $params[ 'act' ]
                    ) ) ;
        }


        # propagate signal

        foreach ( $destinationPaths as $dp )
        {
            $destinationPath = $dp[ 'destination_path' ] ;
            try
            {
                \f\ttt::service ( "$destinationPath.antena",
                                  array (
                    'signal'     => $signal,
                    'nationalID' => $signal[ 'nationalID' ],
                    'component'  => $componentPath,
                    'eventName'  => $eventName,
                    'service'    => '',
                    'activityId' => $activityId
                ) ) ;
            }
            catch (Exception $ex)
            {
                continue ;
            }
        }
    }

    public function getEvents ()
    {
        return \f\ttt::dal ( 'core.signal.getBusinessEvents' ) ;
    }

}
