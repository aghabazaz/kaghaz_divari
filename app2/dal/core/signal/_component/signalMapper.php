<?php

class signalMapper extends \f\dal
{

    public function __construct ()
    {
        $this->sqlEngine   = new \f\sqlStorageEngine ;
        $this->cacheEngine = new \f\cacheStorageEngine ;
    }

    public function getDestinationPaths ()
    {
        $sourcePath = $this->request->getParam ( 'sourcePath' ) ;
        $this->sqlEngine->Select ()
                ->From ( 'core_service_relationships' )
                ->Where ( "source_path = ?", $sourcePath )
                ->Run () ;
        return $this->sqlEngine->getRows () ;
    }

    public function saveActivity ()
    {
        $params  = $this->request->getParam ( 'params' ) ;
        $path    = $this->request->getParam ( 'path' ) ;
        $service = $this->request->getParam ( 'service' ) ;
        //$userId  = $this->request->getParam('userId') ;
        $act     = $this->request->getParam ( 'act' ) ;

        $ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;

        $businessEventID = $this->request->getParam ( 'businessEventID' ) ;
        
        //\f\pre($act);
        if ( $act == 'edit' )
        {
            $activityId = $this->getActivityId ( $params ) ;
            
            //\f\pre($activityId);
            if($activityId)
            {
                $this->sqlEngine->save ( 'core_activity',
                                         array (
                    'path'                  => $path,
                    'service'               => $service,
                    'params'                => json_encode ( $params ),
                    'core_business_eventid' => $businessEventID,
                    'core_userid'           => $ownerId//$userId
                ),array('id=?',array($activityId)) ) ;
            }
        }
        else
        {
            $this->sqlEngine->save ( 'core_activity',
                                     array (
                'path'                  => $path,
                'service'               => $service,
                'params'                => json_encode ( $params ),
                'core_business_eventid' => $businessEventID,
                'core_userid'           => $ownerId//$userId
            ) ) ;

            $activityId = $this->sqlEngine->last_id () ;
        }
        
        return $activityId;


//        \f\pr($this->sqlEngine->last_query()) ;
//        \f\pre($this->sqlEngine->getValue()) ;
    }

    private function getBusinessEventsPlain ()
    {
        $this->sqlEngine->Select ()
                ->From ( 'core_business_event' )
                ->Run () ;
        return $this->sqlEngine->getRows () ;
    }

    private function makeBusinessEventsCachable ( $businessEventsPlain )
    {
        $businessEventsCachable = array () ;
        foreach ( $businessEventsPlain as $businessEventPlain )
        {
            $businessEventsCachable[ $businessEventPlain[ 'name' ] ] = $businessEventPlain ;
        }

        return $businessEventsCachable ;
    }

    public function cacheBusinessEvents ()
    {
        if ( ! $this->cacheEngine->exists ( 'businessEvents' ) )
        {
            $businessEventsPlain    = $this->getBusinessEventsPlain () ;
            $businessEventsCachable = $this->makeBusinessEventsCachable ( $businessEventsPlain ) ;
            $this->cacheEngine->store ( 'businessEvents',
                                        $businessEventsCachable ) ;
        }
    }

    public function getBusinessEvents ()
    {
        $this->cacheBusinessEvents () ;
        return $this->cacheEngine->fetch ( 'businessEvents' ) ;
    }

    public function getActivityId ( $params )
    {
        $purchaseType=$params['productType'];
        $purchaseId=$params['purchaseId'];
        $this->sqlEngine->Select ('id')
                ->From ( 'core_activity' )
                ->Where ( "params like '%productType\":\"$purchaseType%'" )
                ->andWhere ( "params like '%purchaseId\":$purchaseId%'" )
                ->Run () ;
        
        //\f\pre($this->sqlEngine->last_query());
        $row=  $this->sqlEngine->getRow();
        
        return $row['id'];
    }
    
    public function removeActivity ()
    {
        
        $params  = $this->request->getParam ( 'params' ) ;
       
        $activityId = $this->getActivityId ( $params ) ;
        
        $this->sqlEngine->remove('core_activity', array('id=?',array($activityId)));
    }

}
