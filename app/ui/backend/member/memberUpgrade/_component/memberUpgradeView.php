<?php

class memberUpgradeView extends \f\view
{

    public function renderGrid ()
    {
        return $this->render ( 'memberUpgradeList' ) ;
    }

    public function renderMemberUpgradeGrid ( $requestDataTble )
    {
        /** Get group list * */
        $this->registerGadgets(array('dateG'=>'date'));

        $memberUpgradeList = \f\ttt::dal ( 'member.memberUpgrade.memberUpgradeList',
            array (
                'dataTableParams' => $requestDataTble,
                ) ) ;

        $this->registerGadgets(array(
            'dateG' => 'date'));

        foreach ( $memberUpgradeList[ 'data' ] as $key => $value )
        {
            $tdContent = $this->createActionButtons ( $value, 'memberUpgrade' ) ;

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
                    'formatter' => $value[ 'shop_name' ]
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
        $row[ 'total' ] = $memberUpgradeList[ 'total' ] ;
        $row[ 'draw' ]  = $memberUpgradeList[ 'draw' ] ;
        /* @var $table \f\w\table */
        $table          = \f\widgetFactory::make ( 'table' ) ;


        $userListRow = $table->renderRow ( $row ) ;
        return $userListRow ;
    }

    private function createActionButtons ( $data, $content )
    {
        $buttonsParam = array (
            array (
                'type' => 'edit',
                'href' => \f\ifm::app ()->baseUrl . "member/memberUpgrade/" . $content . "Edit/" . $data[ 'id' ]
            ),
            array (
                'type'           => 'status',
                'confirm'        => TRUE,
                'id'             => 's' . $data[ 'id' ],
                'status'         => $data[ 'status' ],
                'action'         => 'member.memberUpgrade.' . $content . 'Status',
                'clientCallBack' => 'toggleEnable',
                'params'         => array (
                    'id'     => $data[ 'id' ],
                    'status' => "\"{$data[ 'status' ]}\""
                ),
            ),
            array (
                'type'           => 'delete',
                'confirm'        => true,
                'action'         => 'member.memberUpgrade.' . $content . 'Delete',
                'clientCallback' => 'remove',
                'params'         => array (
                    'id'       => $data[ 'id' ],
                    'selector' => "\"#f{$data[ 'id' ]}\""
                )
            )
                ) ;
        return \f\html::gridButton ( $buttonsParam ) ;
    }

    public function renderMemberUpgradeAdd ( $id = '' )
    {
        if ( $id )
        {
            $row = \f\ttt::dal ( 'member.memberUpgrade.getMemberUpgradeById',
                                     array (
                        'id' => $id ) ) ;
        }
        $rows=\f\ttt::dal ( 'member.getNormMemberList',
            array (
                'status' => 'enabled'
            )
        ) ;
        $nameUserArray=array_column($rows,'name','id');
        return $this->render ( 'memberUpgradeAdd',
                               array (
                    'row' => $row,
                    'users'=>$nameUserArray
                ) ) ;
    }

}
