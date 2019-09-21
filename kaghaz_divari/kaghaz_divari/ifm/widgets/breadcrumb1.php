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

        array_unshift($chain, $this->defaultRoot()) ;
        return $this->renderTexty($chain) ;
    }

    public function renderTexty($chainList)
    {
		//\f\pr($chainList);
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
        return array (
            'url'    => \f\ifm::app()->baseUrl,
            'title'  => 'خانه',
            'target' => '_parent'
                ) ;
    }

}
