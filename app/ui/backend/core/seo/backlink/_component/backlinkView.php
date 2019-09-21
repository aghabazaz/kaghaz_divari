<?php

class backlinkView extends \f\view
{

    public function renderListBacklink ()
    {
        return $this->render ( 'backlinkList', array (
                ) ) ;
    }

    public function renderBacklinkGrid ( $requestDataTble )
    {

        /** Get group list * */
        $this->registerGadgets ( array (
            'dateG' => 'date' ) ) ;


        $backlinkList = \f\ttt::service ( 'core.seo.backlink.backlinkList',
                                          array (
                    'dataTableParams' => $requestDataTble ) ) ;

        foreach ( $backlinkList[ 'data' ] as $key => $value )
        {

            $tdContent = $this->createActionButtons ( $value, 'backlink' ) ;
            $field     = array (
                array (
                    'style'     => array (
                        'border' => 'none',
                    ),
                    'formatter' => "<div class='simple-checkbox'><input id='f" . $value[ 'id' ] . "' type='checkbox' class='checkBox'/><label for='f" . $value[ 'id' ] . "'></label></div>"
                ),
                array (
                    'formatter' => $value[ 'name' ]
                ),
                array (
                    'formatter' => $value[ 'domain' ]
                ),
                array (
                    'formatter' => $value[ 'num_visit' ]
                ),
                array (
                    'formatter' => ($value[ 'alexa_world_rank' ]?number_format($value['alexa_world_rank']):'N/A')
                ),
                array (
                    'formatter' => ($value[ 'alexa_country_rank' ]?'<div class="flag flag-'.$value[ 'alexa_country_code' ].'"></div> '.number_format($value['alexa_country_rank']):'N/A')
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
            $row[]     = array (
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
        $row[ 'total' ] = $backlinkList[ 'total' ] ;
        $row[ 'draw' ]  = $backlinkList[ 'draw' ] ;
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
                'href' => \f\ifm::app ()->baseUrl . "core/seo/backlink/" . $section . "Detail/" . $data[ 'name' ]
            ),
            array (
                'type'           => 'delete',
                'confirm'        => true,
                'action'         => 'core.seo.backlink.' . $section . 'Delete',
                'clientCallback' => 'remove',
                'params'         => array (
                    'id'       => "\"{$data[ 'name' ]}\"",
                    'selector' => "\"#f{$data[ 'id' ]}\""
                )
            )
                ) ;
        return \f\html::gridButton ( $buttonsParam ) ;
    }

    public function renderBacklinkDetail ( $id = '' )
    {
        $row = \f\ttt::service ( 'core.seo.backlink.getBacklinkById',
                                 array (
                    'id' => $id ) ) ;

        return $this->render ( 'backlinkDetail',
                               array (
                    'row'      => $row
                ) ) ;
    }

}
