<?php

class dashboardView extends \f\view
{

    public function renderGrid()
    {
		

        $mainModulesList   = \f\ttt::service('core.code.getUIByParent',
                                             array (
                    'target' => 'byLevel',
                    'level'  => 0,
                )) ;
		
        $mainModulesListDashboardReady = $this->makeModulesListDashboardReady($mainModulesList) ;
        
        /* @var $dashboardWidget \f\w\dashboard */
        $dashboardWidget               = \f\widgetFactory::make('dashboard') ;

        $mainModuleMarkup = $dashboardWidget->renderGrid($mainModulesListDashboardReady) ;
        
        
        return $mainModuleMarkup ;
    }

    private function makeModulesListDashboardReady($mainModulesList)
    {
        $dashboardReadyList = array () ;
        foreach ( $mainModulesList as $nonReadyItem )
        {

            if ( empty($nonReadyItem[ 'icon_id' ]) )
            {
                continue ;
            }

            $dashboardReadyItem             = array () ;
            $dashboardReadyItem[ 'url' ]    = \f\ifm::app()->baseUrl . $nonReadyItem[ 'name' ] . '/index' ;
            $dashboardReadyItem[ 'title' ]  = $nonReadyItem[ 'title' ] ;
            $dashboardReadyItem[ 'target' ] = '_parent' ;
            $dashboardReadyItem[ 'icon' ]   = \f\ifm::app()->fileBaseUrl . $nonReadyItem[ 'icon_id' ] ;
            $dashboardReadyList[]           = $dashboardReadyItem ;
        }

        return $dashboardReadyList ;
    }

}
