<?php

class ratingOptionsView extends \f\view
{

    public function renderGrid ()
    {

        return $this->render ( 'ratingOptionsList', array (
                ) ) ;
    }

    public function renderRatingOptionsAdd ( $id = '' )
    {

        if ( $id )
        {
            $row = \f\ttt::service ( 'shop.ratingOptions.getRatingOptionsById',
                                     array (
                        'id' => $id ) ) ;
            
        }


        $feature = \f\ttt::service ( 'shop.feature.getFeatureByOwnerId' ) ;

        foreach ( $feature AS $data )
        {
            $fArr[ $data[ 'id' ] ] = $data[ 'title_long' ] ;
        }

        return $this->render ( 'ratingOptionsAdd',
                               array (
                    'row'       => $row,
                    'sort'      => $sort,
                    'feature'   => $fArr,
                    'parameter' => $parameter
                ) ) ;
    }

    public function sort_ratingOptions ( $ratingOptions, $parentId, &$sort )
    {
        foreach ( $ratingOptions AS $data )
        {
            if ( $data[ 'parent_id' ] == $parentId )
            {
                $sort[ $data[ 'id' ] ] = $data[ 'title' ] ;
                $this->sort_ratingOptions ( $ratingOptions, $data[ 'id' ], $sort ) ;
            }
        }
        return $sort ;
    }

    public function renderRatingOptionsGrid ( $requestDataTble )
    {

        $ratingOptionsList = \f\ttt::service ( 'shop.ratingOptions.ratingOptionsList') ;
        foreach ( $ratingOptionsList[ 'data' ] as $key => $value )
        {

            $tdContent = $this->createActionButtons ( $value, 'ratingOptions' ) ;

            $field = array (
                array (
                    'style'     => array (
                        'border' => 'none',
                    ),
                    'formatter' => "<div class='simple-checkbox'><input id='f" . $value[ 'id' ] . "' type='checkbox' class='checkBox'/><label for='f" . $value[ 'id' ] . "'></label></div>"
                ),
                array (
                    'htmlOptions' => array (
                        'id' => 'bgparent',
                    ),
                    'style'       => array (
                        'border' => 'none',
                        'color'  => 'red !important'
                    ),
                    'formatter'   => $value[ 'title' ]
                ),
                array (
                    'htmlOptions' => array (
                        'class' => 'act',
                    ),
                    'style'       => array (
                        'border' => 'none'
                    ), //onclick='widgetHelper.remove(\"" . $value[ 'id' ] . "\",\"c\",\"core.user.remove\" )'
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
        $row[ 'total' ] = $ratingOptionsList[ 'total' ] ;
        $row[ 'draw' ]  = $ratingOptionsList[ 'draw' ] ;
        /* @var $table \f\w\table */
        $table          = \f\widgetFactory::make ( 'table' ) ;

        $userListRow = $table->renderRow ( $row ) ;
        return $userListRow ;
    }

    private function createActionButtons ( $data, $section )
    {
        $buttonsParam = array (
            array (
                'type' => 'edit',
                'href' => \f\ifm::app ()->baseUrl . "shop/ratingOptions/" . $section . "Edit/" . $data[ 'id' ]
            ),
            array (
                'type'           => 'status',
                'confirm'        => TRUE,
                'id'             => 's' . $data[ 'id' ],
                'status'         => $data[ 'status' ],
                'action'         => 'shop.ratingOptions.' . $section . 'Status',
                'clientCallBack' => 'toggleEnable',
                'params'         => array (
                    'id'     => $data[ 'id' ],
                    'status' => "\"{$data[ 'status' ]}\""
                ),
            ),
            array (
                'type'           => 'delete',
                'confirm'        => true,
                'action'         => 'shop.ratingOptions.' . $section . 'Delete',
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
