<?php

namespace f\w ;

class breadcrumb extends \f\widget
{

    public function autoGenerate($actionCatalog)
    {
        if ( is_array($actionCatalog) )
        {
            throw new \f\publicException("Dot separated String expected for 'actionCatalog' !") ;
        }

        $action       = \f\ttt::service('core.code.getAction',
                                        array (
                    'path' => $actionCatalog
                )) ;
        $parentsParts = explode('.', $actionCatalog) ;
        unset($parentsParts[ count($parentsParts) - 1 ]) ;
        $parents      = \f\ttt::service('core.code.getMultiUI',
                                        array (
                    'parents' => $parentsParts
                )) ;
        $parents[]    = $action ;
        $chain        = $this->dashboardReady($parents) ;

        $this->registerGadgets(array (
            'sessionG' => 'session'
        )) ;
        if ( ! $this->sessionG->exists('singleApp') )
        {
            array_unshift($chain, $this->defaultRoot()) ;
        }
        return $this->renderTexty($chain) ;
    }

    public function renderTexty($chainList)
    {
        $markup  = '' ;
        $markup .= '<ul class="breadcrumb">' ;
        $counter = 1 ;
        foreach ( $chainList as $key => $b )
        {
            if ( ! isset($b[ 'target' ]) )
            {
                $b[ 'target' ] = '_self' ;
            }
            if ( count($chainList) > $key + 1 )
            {
                if ( $counter == 1 && ! isset($b[ 'homeSimple' ]) )
                {
                    $home = "<i class='fa fa-home'></i>" ;
                }
                else
                {
                    $home = '' ;
                }

                $markup .= "<li> $home <a target='{$b[ 'target' ]}' href = '{$b[ 'url' ]}'>{$b[ 'title' ]}</a></li>" ;
            }
            else
            {
                $markup .= "<li class='active'>{$b[ 'title' ]}</li>" ;
            }
            $counter ++ ;
        }
        $markup .= "<div class='clear'></div>" ;
        $markup .= "</ul>" ;

        return $markup ;
    }

    private function dashboardReady($chain)
    {
        $readyChain = array () ;
        foreach ( $chain as $key => $ch )
        {
            $rChain = array () ;

            $rChain[ 'url' ]    = \f\ifm::app()->baseUrl . str_replace('.', '/',
                                                                       $ch[ 'path' ]) ;
            $rChain[ 'url' ] .= count($chain) - 1 > $key ? '/index' : '' ;
            $rChain[ 'target' ] = '_parent' ;
            $rChain[ 'title' ]  = $ch[ 'title' ] ;
            $readyChain[]       = $rChain ;
        }
        return $readyChain ;
    }

    private function defaultRoot()
    {

        $loginTo = \f\ttt::service('core.auth.loginTo') ;

        if ( $loginTo === 'newPortal' )
        {
            $dashboardUrl = \f\ifm::app()->baseUrl . 'core/dashboard/index' ;
        }
        else
        {
            $dashboardUrl = \f\ifm::app()->legacyBaseUrl . 'cms/content/manage/' ;
        }

        return array (
            'url'    => $dashboardUrl,
            'title'  => \f\ifm::t('admin'),
            'target' => '_parent'
                ) ;
    }

}
