<?php

class cityView extends \f\view
{

    public function renderGrid()
    {
        
         return $this->render ( 'cityList', array (
                ) ) ;
    }
    public function renderCityAdd ( $id = '' )
    {
       
        if ( $id )
        {
            $row = \f\ttt::service ( 'cms.place.city.getCityById',
                                     array (
                        'id' => $id ) ) ;
        }
        
        $state=  \f\ttt::service('cms.place.state.getStateList');
        
        foreach ($state AS $data)
        {
            $stArr[$data['id']]=$data['title'];
        }

        return $this->render ( 'cityAdd',
                               array (
                    'row' => $row,
                    'state' => $stArr               
                ) ) ;
    }
    
    public function renderCityGrid ( $requestDataTble )
    {

        /** Get group list * */
        $this->registerGadgets(array('dateG'=>'date'));
       
        
        $cityList = \f\ttt::service ( 'cms.place.city.cityList',
                                       array (
                    'dataTableParams' => $requestDataTble ) ) ;

        foreach ( $cityList[ 'data' ] as $key => $value )
        {

            $tdContent = $this->createActionButtons ( $value, 'city' ) ;


            $field = array (
                array (
                    'style' => array (
                        'border'    => 'none',
                    ),
                    'formatter' => "<div class='simple-checkbox'><input id='f" . $value[ 'id' ] . "' type='checkbox' class='checkBox'/><label for='f" . $value[ 'id' ] . "'></label></div>"
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
                    'formatter' => $value[ 'stTitle' ]
                ),
               
               
                array (
                    'htmlOptions' => array (
                        'class' => 'act',
                    ),
                    'style' => array (
                        'border'    => 'none'
                    ), //onclick='widgetHelper.remove(\"" . $value[ 'id' ] . "\",\"c\",\"core.user.remove\" )'
                    'formatter' => $tdContent,
                ),
                    ) ;
            // tr make
            // data-on-confirm='hi'
            $row[ ]     = array (
                'htmlOptions' => array (
                    'id'    => '',
                    'class' => 'c' . $value[ 'id' ],
                ),
                'style' => array (
                    'background'    => 'red !important'
                ),
                'td'            => $field
                    ) ;
        }
        $row[ 'total' ] = $cityList[ 'total' ] ;
        $row[ 'draw' ]  = $cityList[ 'draw' ] ;
        /* @var $table \f\w\table */
        $table          = \f\widgetFactory::make ( 'table' ) ;

        $userListRow = $table->renderRow ( $row ) ;
        return $userListRow ;
    }

    private function createActionButtons ( $data, $section )
    {
        $buttonsParam = array (
//            array (
//                'type' => 'list',
//                'href'=>'#'
//                //'href' => \f\ifm::app ()->baseUrl . "crm/inventory/product/" . $section . "Detail/" . $data[ 'id' ]
//            ),
            array (
                'type' => 'edit',
                'href' => \f\ifm::app ()->baseUrl . "cms.place/city/" . $section . "Edit/" . $data[ 'id' ]
            ),
            array (
                'type'           => 'status',
                'confirm'        => TRUE,
                'id'             => 's' . $data[ 'id' ],
                'status'         => $data[ 'status' ],
                'action'         => 'cms.place.city.' . $section . 'Status',
                'clientCallBack' => 'toggleEnable',
                'params'         => array (
                    'id'     => $data[ 'id' ],
                    'status' => "\"{$data[ 'status' ]}\""
                ),
            ),
            array (
                'type'           => 'delete',
                'confirm'        => true,
                'action'         => 'cms.place.city.' . $section . 'Delete',
                'clientCallback' => 'remove',
                'params'         => array (
                    'id'       => $data[ 'id' ],
                    'selector' => "\"#f{$data[ 'id' ]}\""
                )
            ),
                ) ;
        return \f\html::gridButton ( $buttonsParam ) ;
    }

}
