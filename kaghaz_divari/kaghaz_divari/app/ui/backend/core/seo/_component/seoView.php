<?php

class seoView extends \f\view
{

    public function renderDashboard ()
    {
        /* @var $dashboardWidget \f\w\dashboard */
        $dashboardWidget = \f\widgetFactory::make('dashboard') ;

        return $dashboardWidget->autoUIDashboard('core.seo') ;
    }

    public function renderEditParameterDialog ( $params )
    {
        $row = \f\ttt::dal ( 'core.seo.getPageInfo', $params ) ;
        return $this->render ( 'editParameterDialog',
                               array (
                    'row'    => $row,
                    'params' => $params
        ) ) ;
    }

}
