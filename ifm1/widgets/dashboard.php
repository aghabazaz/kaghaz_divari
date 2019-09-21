<?php

namespace f\w ;

class dashboard extends \f\widget
{

    public function renderGrid ( $items )
    {
        $rbacStatus=\f\ifm::app ()->rbacStatus;
        $output = '' ;
        if ( isset ( $items ) )
        {
            $this->registerGadgets ( array (
                'sessionG' => 'session'
            ) ) ;
           
            $action = ($this->sessionG->read ( 'actions' )) ;
            //\f\pr($action);
            $output .= "<div class='dashboard'>" ;
            foreach ( $items as $item )
            {
                if(!  isset($item['path']))
                {
                    $item['path']=  $this->urlToPath($item[ 'url' ]);
                }
                if(!isset($action[$item['path']]) && $rbacStatus==='enabled')
                {
                    continue ;
                }
                $output .= "<div class='dashboard-item'>" ;
                $output .= "<a href='{$item[ 'url' ]}' target='{$item[ 'target' ]}'>" ;
                $output .= "<div>" ;
                $output .= "<img class='content-icon' src='{$item[ 'icon' ]}'>" ;
                $output .= "</div>" ;
                $output .= "<div class='content-title'>{$item[ 'title' ]}</div>" ;
                $output .= "</a>" ;
                $output .= "</div>" ;
            }
            $output .= "<div class='clear'></div>" ;
            $output .= "</div>" ;
        }
        return $output ;
    }

    public function autoUIDashboard ( $parent = NULL )
    {
        $uiList = \f\ttt::service ( 'core.code.getSubUI',
                                    array (
                    'parent' => $parent
                ) ) ;
        return $this->renderGrid ( $this->dashboardReady ( $uiList ) ) ;
    }

    private function dashboardReady ( $mainModulesList )
    {


        $dashboardReadyList = array () ;
        foreach ( $mainModulesList as $nonReadyItem )
        {

            if ( empty ( $nonReadyItem[ 'icon_id' ] ) )
            {
                continue ;
            }
            $dashboardReadyItem             = array () ;
            $dashboardReadyItem[ 'url' ]    = \f\ifm::app ()->baseUrl . str_replace ( '.',
                                                                                      '/',
                                                                                      $nonReadyItem[ 'path' ] ) . '/index' ;
            $dashboardReadyItem[ 'title' ]  = $nonReadyItem[ 'title' ] ;
            $dashboardReadyItem[ 'target' ] = '_parent' ;

            $dashboardReadyItem[ 'icon' ] = \f\ifm::app ()->fileBaseUrl . $nonReadyItem[ 'icon_id' ] ;
            $dashboardReadyItem[ 'path' ] = $nonReadyItem[ 'path' ].'.index';
            $dashboardReadyList[]         = $dashboardReadyItem ;
        }

        return $dashboardReadyList ;
    }
    
    public function urlToPath($url)
    {
       
        $baseUrl=\f\ifm::app()->baseUrl;
        $urlWithoutBase=str_replace($baseUrl, '', $url);
        return str_replace ( '/','.',$urlWithoutBase ) ;
    }

}
