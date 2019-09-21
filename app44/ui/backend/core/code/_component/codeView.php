<?php

class codeView extends \f\view
{

    public function showTree()
    {
        /** Get Apps list * */
        $componentsArray = \f\ttt::service('core.code.getAllRunnableCodes') ;

        /** Make treeView object * */
        require_once \f\ifm::app()->componentBaseDir . \f\DS . 'view' . \f\DS . 'treeView.php' ;
        $treeViewObj = new treeView ;

        //\f\pr($componentsArray);

        $treeMarkup = $treeViewObj->getTreeRecursive($componentsArray,
                                                     array (
            'service' => true,
            'ui'      => true
                ), 'document') ;

        return $this->render('projectTreeView',
                             array (
                    'treeMarkup' => $treeMarkup
                )) ;
    }

    public function componentDocTab($path, $type, $typeComp)
    {
        $row = array () ;
        $row = ($type == 'service') ? \f\ttt::service('core.code.getApp',
                                                      array ( 'path' => $path )) : \f\ttt::service('core.code.getUI',
                                                                                                   array (
                    'path' => $path )) ;

        if ( ! $row )
        {
            $primaryPath = $this->getPrimaryPath($path) ;
            $name        = $this->getName($path) ;
            if ( $primaryPath )
                    $parent      = ($type == 'service') ? \f\ttt::service('core.code.getAppParent',
                                                                          array (
                            'paramName' => $primaryPath )) : \f\ttt::service('core.code.getParentUI',
                                                                             array (
                            'paramName' => $primaryPath )) ;
            else $parent      = array () ;
        }
        else
        {

            $parent[ 'id' ] = $row[ 'parent_id' ] ;
        }

        if ( $type == 'service' )
        {
            $typeArr = array ( 'component' => \f\ifm::t('component'), 'module'    => \f\ifm::t('module'),
                'plugin'    => \f\ifm::t('plugin') ) ;
        }
        else
        {
            $typeArr = array ( 'frontend' => \f\ifm::t('frontend'), 'backend'  => \f\ifm::t('backend'),
                'mix'      => \f\ifm::t('mix') ) ;
        }

        $form = $this->render('componentDocumentForm',
                              array ( 'type'     => $type, 'path'     => $path, 'typeComp' => $typeComp,
            'row'      => $row, 'parent'   => $parent, 'name'     => $name, 'typeArr'  => $typeArr )) ;

        // $paramForm = $this->render('paramForm');
        /* @var $tabWidget \f\w\tab */
        return $form ;
    }

    public function methodDocTab($path, $type, $typeComp)
    {

        $row    = array () ;
        $row_pr = array () ;
        $row    = ($type == 'service') ? \f\ttt::service('core.code.getService',
                                                         array ( 'path' => $path )) : \f\ttt::service('core.code.getAction',
                                                                                                      array (
                    'path' => $path )) ;

        $core_uiid = ($type == 'ui') ? $row[ 'core_uiid' ] : '' ;
        $filters   = ($type == 'ui') ? \f\ttt::service('core.code.getfilterActions',
                                                       array ( 'core_uiid' => $core_uiid )) : '' ;

        if ( ! $row )
        {
            $primaryPath = $this->getPrimaryPath($path) ;

            $name = $this->getName($path) ;

            if ( $primaryPath )
                    $parent = ($type == 'service') ? \f\ttt::service('core.code.getApp',
                                                                     array ( 'path' => $primaryPath )) : \f\ttt::service('core.code.getUI',
                                                                                                                         array (
                            'path' => $primaryPath )) ;
            else $parent = array () ;
        }
        else
        {
            $row_pr         = ($type == 'service') ? \f\ttt::service('core.code.getServiceParams',
                                                                     array ( 'seviceId' => $row[ 'id' ] )) : \f\ttt::service('core.code.getActionParams',
                                                                                                                             array (
                        'actionId' => $row[ 'id' ] )) ;
            $parent[ 'id' ] = ($type == 'service') ? $row[ 'core_appid' ] : $row[ 'core_uiid' ] ;
        }

        if ( $type == 'service' )
        {
            $typeArr = array ( 'general'  => \f\ifm::t('general'), 'external' => \f\ifm::t('external'),
                'internal' => \f\ifm::t('internal') ) ;
        }
        else
        {

            $typeArr = array ( 'ajax' => \f\ifm::t('ajax'), 'nonAjax' => \f\ifm::t('nonAjax') ) ;
        }
        if ( $filters )
        {
            foreach ( $filters as $val )
            {
                $filterAction[ $val[ 'id' ] ] = $val[ 'title' ] ;
            }
        }
        else
        {
            $filterAction = array () ;
        }


        $form = $this->render('methodDocumentForm',
                              array ( 'type'         => $type, 'path'         => $path,
            'typeComp'     => $typeComp,
            'row'          => $row, 'row_pr'       => $row_pr, 'parent'       => $parent,
            'name'         => $name,
            'typeArr'      => $typeArr, 'filterAction' => $filterAction )) ;

        // $paramForm = $this->render('paramForm');

        return $form ;
    }

    //------------------------------------------------------------------------------

    function getPrimaryPath($path)
    {

        $paths       = explode('.', $path) ;
        $primaryPath = '' ;
        for ( $i = 0 ; $i < count($paths) - 1 ; $i ++ )
        {
            $primaryPath .= ($i == 0) ? $paths[ $i ] : '.' . $paths[ $i ] ;
        }
        //$primaryPath = ($primaryPath == '') ? false : $primaryPath;
        return $primaryPath ;
    }

    //-----------------------------------------------------------------------------

    function getName($path)
    {
        $paths = explode('.', $path) ;

        return $paths[ count($paths) - 1 ] ;
    }

    //--------------------------------------------------------------------------

    function renderTreeDialog($param, $includeResources = false)
    {
        //\f\pr(\f\ifm::app()->getUserType() );

        if ( \f\ifm::app()->getUserType() === 'superadmin' )
        {
            $componentsArray = \f\ttt::service('core.code.getAllRunnableCodes',
                                               array (
                        'mode' => 'select'
                    )) ;
        }
        else
        {
            $componentsArray = \f\ttt::service('core.code.getAllRunnableCodes',
                                               array (
                        'mode' => 'select'
                    )) ;
        }
        
        //\f\pr($componentsArray);


        /** Make treeView object * */
        require_once __DIR__ . \f\DS . 'view' . \f\DS . 'treeView.php' ;
        $treeViewObj = new treeView ;

        $treeMarkup = $treeViewObj->getTreeRecursive($componentsArray,
                                                     $param[ 'tiers' ],
                                                     'select',
                                                     $param[ 'treeid' ], !$includeResources) ;

        return $this->render('treeDialog',
                             array (
                    'treeMarkup'       => $treeMarkup,
                    'treeid'           => $param[ 'treeid' ],
                    'tiers'            => $param[ 'tiers' ],
                    'includeResources' => $includeResources
                )) ;
    }

    //--------------------------------------------------------------------------
    public function renderFilterForm($setting)
    {

        return $this->render('filterForm', array ( 'setting' => $setting )) ;
    }

}
