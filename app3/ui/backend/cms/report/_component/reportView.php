<?php

class reportView extends \f\view
{
    private $siteId=1;

    public function renderDashboard()
    {
        
        $data_visit=  \f\ttt::service('core.visit.getDataVisit',array('site_id'=>  $this->siteId));
        $visit_all=  \f\ttt::service('core.visit.visitAll',array('site_id'=>  $this->siteId));
        $visitDay = \f\ttt::service('core.visit.visitDay',array('site_id'=>  $this->siteId));  
        $alexa=\f\ttt::service('core.visit.alexaRank',array('site_id'=>  $this->siteId)); 
        $alexaToday=$alexa[0];
        $alexaYesterday=$alexa[1];
        
        return $this->render('dashboard',array(
            'data_visit'=>$data_visit,
            'visit_all'=>$visit_all,
            'visitDay'=>$visitDay,
            'alexaToday'=>$alexaToday,
            'alexaYesterday'=>$alexaYesterday,
            'siteId'=>$this->siteId
        ));
    }

}
