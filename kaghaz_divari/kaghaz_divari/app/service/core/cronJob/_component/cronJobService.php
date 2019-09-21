<?php

/**
 * @author gharakhani
 * @package \core
 * @category component
 * 
 */
class cronJobService extends \f\service
{
    
    public function specialOccasions(){
        $this->propagateSpecialOccasions () ;
    }
    
    private function propagateSpecialOccasions ()
    {
        # Standardization the Register activity record,
        # This is because all softwares can process the activity 
        # in a general way.

        $activity = array ( ) ;
        $activity[ 'systemPlan' ] = TRUE; 
        $activity[ 'date' ]       = time () ;

        # Propagating the standarded event
        \f\ifm::propagate ( array (
            'path'      => 'core.cronJob.specialOccasions',
            'eventName' => 'specialOccasions',
            'signal'    => $activity
        ) ) ;
    }
    
}
