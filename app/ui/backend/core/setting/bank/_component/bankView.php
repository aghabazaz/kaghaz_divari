<?php

class bankView extends \f\view
{
    public function renderDashboard()
    {
         /* @var $dashboardWidget \f\w\dashboard */
        $dashboardWidget = \f\widgetFactory::make('dashboard') ;

        return $dashboardWidget->autoUIDashboard('core.setting.bank') ;
    }

}
