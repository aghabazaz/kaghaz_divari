<?php

class dashboardView extends \f\view
{

    public function renderGrid()
    {
        $legacyModulesList = \f\ttt::service('core.code.getLegacyModulesList') ;
        $mainModulesList   = \f\ttt::service('core.code.getUIByParent', array(
            'target' => 'byLevel',
            'level' => 0,
        )) ;

        //\f\pr($legacyModulesList);
        $mainModulesListDashboardReady = $this->makeModulesListDashboardReady($mainModulesList) ;
        /* @var $dashboardWidget \f\w\dashboard */
        $dashboardWidget               = \f\widgetFactory::make('dashboard') ;

        $legacyModulesMarkup = $dashboardWidget->renderGrid($legacyModulesList) ;

        $mainModuleMarkup = $dashboardWidget->renderGrid($mainModulesListDashboardReady) ;
        $mainModuleMarkup .= "<hr>" ;

        return $mainModuleMarkup . $legacyModulesMarkup ;
    }

    private function makeModulesListDashboardReady($mainModulesList)
    {
        $dashboardReadyList = array () ;
        foreach ( $mainModulesList as $nonReadyItem )
        {

            if ( empty($nonReadyItem[ 'icon' ]) )
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
