<?php

class websiteView extends \f\view
{

    public function index ()
    {
        /* @var $dashboardWidget \f\w\dashboard */
        $dashboardWidget = \f\widgetFactory::make ( 'dashboard' ) ;

        $baseUrl   = \f\ifm::app ()->baseUrl . 'core/website/' ;
        $uploadUrl = \f\ifm::app ()->uploadUrl . 'icons/ui/website/' ;
        $items     = array (
            array ( 'url'    => $baseUrl . 'userView', 'title'  => \f\ifm::t ( 'userView' ),
                'target' => '_self', 'icon'   => $uploadUrl . 'siteinstall.png' ),
                ) ;
        return $dashboardWidget->renderGrid ( $items ) ;
    }

    public function renderGrid ()
    {
        return $this->render ( 'siteList', array (
                ) ) ;
    }

    public function renderSiteGrid ( $requestDataTble )
    {
        /** Get site list * */
        $siteList = \f\ttt::service ( 'core.website.getSiteList',
                                      array ( 'dataTableParams' => $requestDataTble ) ) ;

        /* @var $table \f\w\table */
        $table = \f\widgetFactory::make ( 'table' ) ;

        $row            = $this->setSiteList ( $siteList ) ;
        $row[ 'total' ] = $siteList[ 'total' ] ;
        $row[ 'draw' ]  = $siteList[ 'draw' ] ;

        $siteListRows = $table->renderRow ( $row ) ;
        return $siteListRows ;
    }

    private function setSiteList ( $siteList )
    {
        $row = array ( ) ;
        foreach ( $siteList[ 'data' ] as $key => $value )
        {
            $tdContent = $this->createActionButtons ( $value ) ;

            $field = array (
                array (
                    'style' => array (
                        'border'    => 'none',
                    ),
                    'formatter' => "<input id='c" . $value[ 'id' ] . "' type='checkbox' class='checkBox'/>"
                ),
                array (
                    'htmlOptions' => array (
                        'id'    => 'bgparent',
                    ),
                    'style' => array (
                        'border'    => 'none',
                        'color'     => 'red !important'
                    ),
                    'formatter' => $value[ 'title' ]
                ),
                array (
                    'htmlOptions' => array (
                        'id'    => 'bgparent',
                    ),
                    'style' => array (
                        'border'    => 'none',
                        'color'     => 'red !important'
                    ),
                    'formatter' => $value[ 'name' ]
                ),
                array (
                    'htmlOptions' => array (
                        'class' => 'tdsearch',
                    ),
                    'style' => array (
                        'border'    => 'none'
                    ),
                    'formatter' => $value[ 'phone' ]
                ),
                array (
                    'htmlOptions' => array (
                        'class' => 'tdsearch',
                    ),
                    'style' => array (
                        'border'    => 'none'
                    ),
                    'formatter' => $value[ 'email' ]
                ),
                array (
                    'htmlOptions' => array (
                        'class' => 'act',
                    ),
                    'style' => array (
                        'border'    => 'none'
                    ),
                    'formatter' => $tdContent,
                ),
                    ) ;
            // tr make
            $row[ ]      = array (
                'htmlOptions' => array (
                    'id'    => '',
                    'class' => 'c' . $value[ 'id' ],
                ),
                'td'    => $field
                    ) ;
        }
        return $row ;
    }

    private function createActionButtons ( $data )
    {
        $buttonsParam = array (
//            array (
//                'type' => 'list',
//                'href'=>'#'
//                //'href' => \f\ifm::app ()->baseUrl . "crm/inventory/product/" . $content . "Detail/" . $data[ 'id' ]
//            ),
            array (
                'type' => 'edit',
                'href' => \f\ifm::app ()->baseUrl . "core/website/siteEdit/" . $data[ 'id' ]
            ),
            array (
                'type'           => 'status',
                'confirm'        => TRUE,
                'id'             => 's' . $data[ 'id' ],
                'status'         => $data[ 'status' ],
                'action'         => 'core.website.active',
                'clientCallBack' => 'toggleEnable',
                'params'         => array (
                    'id'     => $data[ 'id' ],
                    'status' => "\"{$data[ 'status' ]}\""
                ),
            ),
            array (
                'type'           => 'delete',
                'confirm'        => true,
                'action'         => 'core.website.remove',
                'clientCallback' => 'remove',
                'params'         => array (
                    'id'       => $data[ 'id' ],
                    'selector' => "\"#f{$data[ 'id' ]}\""
                )
            ),
                ) ;
        return \f\html::gridButton ( $buttonsParam ) ;
    }

    public function renderSiteAdd ( $editId = '' )
    {
        $userList = \f\ttt::service ( 'core.website.getUserList' ) ;
        $lang     = \f\ttt::service ( 'core.website.getLanguage' ) ;
        $row      = ($editId) ? \f\ttt::service ( 'core.website.getSiteInfo',
                                                  array ( 'id' => $editId ) ) : '' ;

        $settings = \f\ttt::service ( 'core.website.getSettings',
                                      array (
                    'websiteId' => $editId
                ) ) ;

        foreach ( $lang as $resLang )
        {
            $title              = \f\ifm::t ( $resLang[ 'code' ] ) ;
            $language[ $title ] = $resLang[ 'id' ] ;
            $result             = \f\ttt::service ( 'core.website.getTemplate',
                                                    array ( 'languageId' => $resLang[ 'id' ] ) ) ;
            foreach ( $result as $resTemplate )
            {
                $temp[ $resTemplate[ 'id' ] ] = $resTemplate[ 'title' ] ;
            }
            $template[ $resLang[ 'id' ] ] = $temp ;
        }
        return $this->render ( 'siteAdd',
                               array (
                    'row'      => $row,
                    'userList' => $userList,
                    'language' => $language,
                    'template' => $template,
                    'settings' => $settings
                ) ) ;
    }

}
