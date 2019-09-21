<?php

class newsView extends \f\view
{
    

    public function renderContentList()
    {
         return $this->render ( 'newsList', array (
                ) ) ;
    }
    public function renderContentGrid ( $requestDataTble )
    {

        /** Get group list * */
        $this->registerGadgets(array('dateG'=>'date'));
        
        //$this->dateG->
       
        
        $newsList = \f\ttt::service ( 'cms.news.newsList',
                                       array (
                    'dataTableParams' => $requestDataTble ) ) ;

        foreach ( $newsList[ 'data' ] as $key => $value )
        {

            $tdContent = $this->createActionButtons ( $value, 'news' ) ;


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
                    'formatter' => '<div style="text-align:right">'.$value[ 'title' ].'</div>'
                ),
               array (
                    'htmlOptions' => array (
                        'id'    => 'bgparent',
                    ),
                    'style' => array (
                        'border'    => 'none',
                        'color'     => 'red !important'
                    ),
                    'formatter' => $value[ 'visit' ]
                ),
                array (
                    'htmlOptions' => array (
                        'class' => 'tdsearch',
                    ),
                    'style' => array (
                        'border'    => 'none'
                    ),
                    'formatter' =>  $this->dateG->dateTime($value[ 'date_register' ],2).' ساعت : '.date('H:i',$value[ 'date_register' ])
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
        $row[ 'total' ] = $newsList[ 'total' ] ;
        $row[ 'draw' ]  = $newsList[ 'draw' ] ;
        /* @var $table \f\w\table */
        $table          = \f\widgetFactory::make ( 'table' ) ;

        $userListRow = $table->renderRow ( $row ) ;
        return $userListRow ;
    }

    private function createActionButtons ( $data, $news )
    {
        $buttonsParam = array (
//            array (
//                'type' => 'list',
//                'href'=>'#'
//                //'href' => \f\ifm::app ()->baseUrl . "crm/inventory/product/" . $news . "Detail/" . $data[ 'id' ]
//            ),
            array (
                'type' => 'edit',
                'href' => \f\ifm::app ()->baseUrl . "cms/news/" . $news . "Edit/" . $data[ 'id' ]
            ),
            array (
                'type'           => 'status',
                'confirm'        => TRUE,
                'id'             => 's' . $data[ 'id' ],
                'status'         => $data[ 'status' ],
                'action'         => 'cms.news.' . $news . 'Status',
                'clientCallBack' => 'toggleEnable',
                'params'         => array (
                    'id'     => $data[ 'id' ],
                    'status' => "\"{$data[ 'status' ]}\""
                ),
            ),
            array (
                'type'           => 'delete',
                'confirm'        => true,
                'action'         => 'cms.news.' . $news . 'Delete',
                'clientCallback' => 'remove',
                'params'         => array (
                    'id'       => $data[ 'id' ],
                    'selector' => "\"#f{$data[ 'id' ]}\""
                )
            ),
            array (
                'type'         => 'custom',
                'title'        => 'سئو و بهینه سازی سایت',
                'icon'         => 'fa fa-paw fa-lg',
                'id'           => "ps_" . $data[ 'id' ],
                'clientAction' => array (
                    'display' => 'dialog',
                    'params'  => array (
                        'targetRoute'    => "core.seo.editParameterDialog",
                        'triggerElement' => "ps_" . $data[ 'id' ],
                        'dialogTitle'    => 'سئو و بهینه سازی سایت',
                        'ajaxParams'     => array (
                            'component_id' => 'newsItems',
                            'item_id'      => $data[ 'id' ]
                        )
                    )
                )
            )
                ) ;
        return \f\html::gridButton ( $buttonsParam ) ;
    }
    public function renderContentAdd ( $id = '' )
    {
        if ( $id )
        {
            $row = \f\ttt::service ( 'cms.news.getContentById',
                                     array (
                        'id' => $id ) ) ;
            
           
        }
        
      
        
        //\f\pr($section);

        return $this->render ( 'newsAdd',
                               array (
                    'row' => $row,
                                   
                ) ) ;
    }
    
    public function renderElectorate ()
    {
        
        $row=\f\ttt::service ( 'cms.news.getElectorate');
        //\f\pre($row);
        return $this->render ( 'electorate',
                               array (
                    'row' => $row,
                                    
                ) ) ;
    }
	

}
