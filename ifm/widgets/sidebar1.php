<?php

namespace f\w ;

class sidebar extends \f\widget
{

    private function renderMenu($items, $levelOneReady)
    {
        $rbacStatus        = \f\ifm::app()->rbacStatus ;
        $dashboard         = $this->dashboard() ;
        $sidebarMenuMarkup = "
            <div class='col-md-2 left-sidebar'>
                <nav class='main-nav'>
                    <ul class='main-menu'>
                        <li>
                            <a href='{$dashboard[ 'url' ]}'>
                                <i class='fa {$dashboard[ 'icon' ]} fa-fw'></i>
                                <span class='text'> {$dashboard[ 'title' ]}</span>
                            </a>
                        </li>

        " ;

        $this->registerGadgets(array (
            'sessionG' => 'session'
        )) ;

        $action   = ($this->sessionG->read('actions')) ;
        //\f\pr($action);                     
        $jsonItem = json_encode($levelOneReady) ;
        foreach ( $items as $item )
        {
            //\f\pr($action[$item['path']]);
            if ( ! isset($action[ $item[ 'path' ] ]) && $rbacStatus === 'enabled' )
            {
                continue ;
            }
            //echo count($levelOneReady);
            $bg = \f\ifm::app()->fileBaseUrl . $item[ 'icon_id' ] ;

            $s = "background-image: url($bg);" ;

            $s .= "background-repeat: no-repeat;" ;
            $s .= "background-size: 20px;" ;
            $s .= "background-position: right 5px center;" ;

            $child = strpos($jsonItem, '"parent_id":"' . $item[ 'id' ] . '"') !== FALSE ? TRUE : FALSE ;
            if ( $child )
            {
                $class = 'fa fa-angle-left' ;
            }
            else
            {
                $class = '' ;
            }

            $uiActive = $item[ 'name' ] == \f\ifm::app()->runningUI ? 'active' : '' ;
            $sidebarMenuMarkup .= "
                        <li class='$uiActive'>
                            <a  class='js-sub-menu-toggle' style='$s  height: 41px;' href='{$item[ 'url' ]}'>
                                <span style='padding-right: 20px; height: 41px;' class='text'> {$item[ 'title' ]}</span>
                                <i class='toggle-icon $class'></i>
                            </a>
                            <ul class='sub-menu' >" ;

            $sidebarMenuMarkup .= "<li ><a href='{$item[ 'url' ]}' style='padding-right:15px'><i class='fa fa-dashboard fa-fw' style='font-size:18px;color:#84ADEE'></i> <span class='text'>داشبورد</span></a></li>" ;
            foreach ( $levelOneReady as $levelOne )
            {

                if ( ! isset($action[ $levelOne[ 'path' ] ]) && $rbacStatus === 'enabled' )
                {
                    continue ;
                }

                if ( $levelOne[ 'parent_id' ] == $item[ 'id' ] )
                {
                    $backgroundUrl = \f\ifm::app()->fileBaseUrl . $levelOne[ 'icon_id' ] ;

                    $style = "background-image: url($backgroundUrl);" ;

                    $style .= "background-repeat: no-repeat;" ;
                    $style .= "background-size: 20px;" ;
                    $style .= "background-position: right 13px center;" ;
                    $componentActive = $levelOne[ 'name' ] == \f\ifm::app()->runningComponent ? 'active' : '' ;

                    $sidebarMenuMarkup .= "<li class='$componentActive'><a style='$style' href='{$levelOne[ 'url' ]}'><span class='text'> {$levelOne[ 'title' ]}</span></a></li>" ;
                }
            }
            $sidebarMenuMarkup .= "
                    </ul>
                        </li>
            " ;
        }

        $sidebarMenuMarkup .= "    
                    </ul>
                </nav>
                <div class='sidebar-minified js-toggle-minified'>
                    <i class='fa fa-angle-right'></i>
                </div>
            </div>
        " ;
        return $sidebarMenuMarkup ;
    }

    public function autoGenerateMenu()
    {
        $mainModulesList = \f\ttt::service('core.code.getUIByParent',
                                           array (
                    'target' => 'byLevel',
                    'level'  => 0
                )) ;
        $levelOne        = \f\ttt::service('core.code.getUIByParent',
                                           array (
                    'target' => 'byLevel',
                    'level'  => 1
                )) ;
        $menuReady       = $this->menuReady($mainModulesList, 'fa-book') ;

        $levelOneReady = $this->menuReady($levelOne, 'fa-puzzle-piece') ;
        return $this->renderMenu($menuReady, $levelOneReady) ;
    }

    private function menuReady($mainModulesList, $icon)
    {

        $dashboardReadyList = array () ;
        foreach ( $mainModulesList as $nonReadyItem )
        {
            if ( $nonReadyItem[ 'display_order' ] < 0 )
            {
                continue ;
            }
            $dashboardReadyItem = array () ;

            $url = \f\ifm::app()->baseUrl ;

            $url .= str_replace('.', '/', $nonReadyItem[ 'path' ]) . '/index' ;

            $dashboardReadyItem[ 'url' ]       = $url ;
            $dashboardReadyItem[ 'title' ]     = $nonReadyItem[ 'title' ] ;
            $dashboardReadyItem[ 'target' ]    = '_parent' ;
            $dashboardReadyItem[ 'icon' ]      = $icon ;
            $dashboardReadyItem[ 'parent_id' ] = $nonReadyItem[ 'parent_id' ] ;
            $dashboardReadyItem[ 'id' ]        = $nonReadyItem[ 'id' ] ;
            $dashboardReadyItem[ 'icon_id' ]   = $nonReadyItem[ 'icon_id' ] ;
            $dashboardReadyItem[ 'name' ]      = $nonReadyItem[ 'name' ] ;
            $dashboardReadyItem[ 'path' ]      = $nonReadyItem[ 'path' ] . '.index' ;

            $dashboardReadyList[] = $dashboardReadyItem ;
        }
        return $dashboardReadyList ;
    }

    private function dashboard()
    {
        $loginTo = \f\ttt::service('core.auth.loginTo') ;

        if ( $loginTo === 'newPortal' )
        {
            $dashboardUrl = \f\ifm::app()->siteUrl . 'administrator' ;
        }
        else
        {
            $dashboardUrl = \f\ifm::app()->legacyBaseUrl . 'cms/content/manage/' ;
        }

        return array (
            'url'   => $dashboardUrl,
            'title' => \f\ifm::t('dashboard'),
            'icon'  => 'fa-dashboard'
                ) ;
    }

}
