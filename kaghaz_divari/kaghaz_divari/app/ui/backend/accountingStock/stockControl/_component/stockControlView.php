<?php

class stockControlView extends \f\view
{

    public function renderGrid()
    {
        /* @var $dashboardWidget \f\w\dashboard */
        $dashboardWidget = \f\widgetFactory::make('dashboard') ;
        //session_start();
        //\f\pr($_SESSION['auth']);

        return $dashboardWidget->autoUIDashboard('accountingStock.stockControl') ;
    }

}
