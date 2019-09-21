<?php

class linkView extends \f\view
{

    public function renderGrid ()
    {
        $dashboardWidget = \f\widgetFactory::make ( 'dashboard' ) ;
        return $dashboardWidget->autoUIDashboard ( 'cms.link' ) ;
    }

}