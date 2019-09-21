<?php

class advertisementView extends \f\view
{

    public function renderGrid()
    {
        /* @var $dashboardWidget \f\w\dashboard */
        $dashboardWidget = \f\widgetFactory::make('dashboard') ;

        return $dashboardWidget->autoUIDashboard('cms.advertisement') ;
    }

}
