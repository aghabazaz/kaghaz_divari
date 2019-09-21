<?php

class webpageView extends \f\view
{

    public function renderListWebpage ()
    {
        return $this->render ( 'webpageList', array (
                ) ) ;
    }

    public function renderWebpageDetail ( $id = '' )
    {
        $row = \f\ttt::service ( 'core.seo.webpage.getWebpageById',
                                 array (
                    'id' => $id ) ) ;

        $heading = \f\ttt::service ( 'core.seo.webpage.getHeadingByPageId',
                                     array (
                    'id' => $id ) ) ;

        $link      = \f\ttt::service ( 'core.seo.webpage.getLinkByPageId',
                                       array (
                    'id' => $id ) ) ;
        $words     = \f\ttt::service ( 'core.seo.webpage.getWordsByPageId',
                                       array (
                    'id' => $id ) ) ;
        $backlink = \f\ttt::service ( 'core.seo.webpage.getBacklinkByPageId',
                                       array (
                    'id' => $id ) ) ;

        //\f\pr($link);
        return $this->render ( 'webpageDetail',
                               array (
                    'row'       => $row,
                    'heading'   => $heading,
                    'link'      => $link,
                    'words'     => $words,
                    'backlink' => $backlink,
                ) ) ;
    }

    public function renderWebpageGrid ( $requestDataTble )
    {

        /** Get group list * */
        $this->registerGadgets ( array (
            'dateG' => 'date' ) ) ;


        $webpageList = \f\ttt::service ( 'core.seo.webpage.webpageList',
                                         array (
                    'dataTableParams' => $requestDataTble ) ) ;

        foreach ( $webpageList[ 'data' ] as $key => $value )
        {

            $tdContent = $this->createActionButtons ( $value, 'webpage' ) ;

            if ( $value[ 'link' ] )
            {
                $link = '<a href="' . \f\ifm::app ()->siteUrl . $value[ 'link' ] . '" target="_blank" style="direction:ltr">' . \f\ifm::app ()->siteUrl . urldecode($value[ 'link' ]) . '</a>' ;
            }
            else
            {
                $link = 'N/A' ;
            }
            $field = array (
                array (
                    'style'     => array (
                        'border' => 'none',
                    ),
                    'formatter' => "<div class='simple-checkbox'><input id='f" . $value[ 'id' ] . "' type='checkbox' class='checkBox'/><label for='f" . $value[ 'id' ] . "'></label></div>"
                ),
                array (
                    'formatter' => $value[ 'title' ]
                ),
                array (
                    'formatter' => $link
                ),
                array (
                    'formatter' => $value[ 'component_id' ]
                ),
                array (
                    'formatter' => $value[ 'item_id' ]
                ),
                array (
                    'htmlOptions' => array (
                        'class' => 'act',
                    ),
                    'style'       => array (
                        'border' => 'none'
                    ),
                    'formatter'   => $tdContent,
                ),
                    ) ;
            // tr make
            // data-on-confirm='hi'
            $row[] = array (
                'htmlOptions' => array (
                    'id'    => '',
                    'class' => 'c' . $value[ 'id' ],
                ),
                'style'       => array (
                    'background' => 'red !important'
                ),
                'td'          => $field
                    ) ;
        }
        $row[ 'total' ] = $webpageList[ 'total' ] ;
        $row[ 'draw' ]  = $webpageList[ 'draw' ] ;
        /* @var $table \f\w\table */
        $table          = \f\widgetFactory::make ( 'table' ) ;

        $userListRow = $table->renderRow ( $row ) ;
        return $userListRow ;
    }

    private function createActionButtons ( $data, $section )
    {
        $buttonsParam = array (
            array (
                'type' => 'list',
                'href' => \f\ifm::app ()->baseUrl . "core/seo/webpage/" . $section . "Detail/" . $data[ 'id' ]
            ),
            array (
                'type'         => 'custom',
                'title'        => 'سئو و بهینه سازی سایت',
                'icon'         => 'fa fa-edit fa-lg',
                'id'           => "ps_" . $data[ 'id' ],
                'clientAction' => array (
                    'display' => 'dialog',
                    'params'  => array (
                        'targetRoute'    => "core.seo.editParameterDialog",
                        'triggerElement' => "ps_" . $data[ 'id' ],
                        'dialogTitle'    => 'سئو و بهینه سازی سایت',
                        'ajaxParams'     => array (
                            'component_id' => $data[ 'component_id' ],
                            'item_id'      => $data[ 'item_id' ]
                        )
                    )
                )
            ),
            array (
                'type'           => 'delete',
                'confirm'        => true,
                'action'         => 'core.seo.webpage.' . $section . 'Delete',
                'clientCallback' => 'remove',
                'params'         => array (
                    'id'       => $data[ 'id' ],
                    'selector' => "\"#f{$data[ 'id' ]}\""
                )
            )
                ) ;
        return \f\html::gridButton ( $buttonsParam ) ;
    }

}
