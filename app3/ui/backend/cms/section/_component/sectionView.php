<?php

class sectionView extends \f\view
{
    
    public $type;
    public function __construct()
    {
        $this->type=array(
        'state'=>\f\ifm::t('state'),
        'electorate'=>\f\ifm::t('electorate'),
        'parties'=>\f\ifm::t('parties'),
        'election'=>\f\ifm::t('election')
        );
    }
    public function renderGrid()
    {
        
         return $this->render ( 'sectionList', array (
                ) ) ;
    }
    public function renderSectionAdd ( $id = '' )
    {
        
        $section = \f\ttt::service ( 'cms.section.getSectionByOwnerId',array('parent_id'=>0) ) ;
        
        $sectionArr=array();
        $sectionArr['NULL']=  \f\ifm::t('mainSection');
        foreach ($section AS $data)
        {
            $sectionArr[$data['id']]=$data['title'];
        }
       
        if ( $id )
        {
            $row = \f\ttt::service ( 'cms.section.getSectionById',
                                     array (
                        'id' => $id ) ) ;
        }

        return $this->render ( 'sectionAdd',
                               array (
                    'row' => $row,
                    'type'=>  $this->type,
                    'section'=>  $sectionArr,               
                ) ) ;
    }
    
    public function renderSectionGrid ( $requestDataTble )
    {

        /** Get group list * */
        $this->registerGadgets(array('dateG'=>'date'));
       
        
        $sectionList = \f\ttt::service ( 'cms.section.sectionList',
                                       array (
                    'dataTableParams' => $requestDataTble ) ) ;

        foreach ( $sectionList[ 'data' ] as $key => $value )
        {

            $tdContent = $this->createActionButtons ( $value, 'section' ) ;


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
                        'class' => 'tdsearch',
                    ),
                    'style' => array (
                        'border'    => 'none'
                    ),
                    'formatter' =>  $this->dateG->dateTime($value[ 'date_register' ],2)
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
        $row[ 'total' ] = $sectionList[ 'total' ] ;
        $row[ 'draw' ]  = $sectionList[ 'draw' ] ;
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
                'href' => \f\ifm::app ()->baseUrl . "cms/section/" . $section . "Edit/" . $data[ 'id' ]
            ),
            array (
                'type'           => 'status',
                'confirm'        => TRUE,
                'id'             => 's' . $data[ 'id' ],
                'status'         => $data[ 'status' ],
                'action'         => 'cms.section.' . $section . 'Status',
                'clientCallBack' => 'toggleEnable',
                'params'         => array (
                    'id'     => $data[ 'id' ],
                    'status' => "\"{$data[ 'status' ]}\""
                ),
            ),
            array (
                'type'           => 'delete',
                'confirm'        => true,
                'action'         => 'cms.section.' . $section . 'Delete',
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
