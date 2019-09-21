<?php

class surveyView extends \f\view
{

    public function renderGrid ()
    {

        return $this->render ( 'surveyList', array (
                ) ) ;
    }

    public function renderSurveyAdd ( $id = '' )
    {

        if ( $id )
        {
            $row = \f\ttt::service ( 'cms.survey.getsurveyById',
                                     array (
                        'id'     => $id ) ) ;
            $choices = \f\ttt::service ( 'cms.survey.getAnswresById',
                                         array (
                        'id'                             => $row[ 'questionId' ] ) ) ;
            
        }
        $chossArr[ 'یک انتخابی' ]        = 'one' ;
        $chossArr[ 'چند انتخابی' ]       = 'multi' ;
        $visitArr[ 'تمام کاربران سایت' ] = 'all' ;
        $visitArr[ 'فقط اعضای سایت' ]    = 'login' ;
        $chartArr[ 'غیرفعال' ]           = 'hide' ;
        $chartArr[ 'فعال' ]              = 'show' ;



        return $this->render ( 'surveyAdd',
                               array (
                    'row'      => $row,
                    'choices'  => $choices,
                    'chossArr' => $chossArr,
                    'visitArr' => $visitArr,
                    'chartArr' => $chartArr
                ) ) ;
    }

    public function renderSurveyGrid ( $requestDataTble )
    {

        /** Get group list * */
        $this->registerGadgets ( array ( 'dateG' => 'date' ) ) ;


        $surveyList = \f\ttt::service ( 'cms.survey.surveyList',
                                        array (
                    'dataTableParams' => $requestDataTble ) ) ;
        foreach ( $surveyList[ 'data' ] as $key => $value )
        {

            $tdContent = $this->createActionButtons ( $value, 'survey' ) ;

            if ( $value[ 'typechoose' ] == 'multi' )
            {
                $typechoose = 'چند انتخابی' ;
            }
            else
            {
                $typechoose = 'یک انتخابی' ;
            }
            if ( $value[ 'typevisitors' ] == 'login' )
            {
                $typevisitors = 'فقط اعضای سایت' ;
            }
            else
            {
                $typevisitors = 'تمام کاربران سایت' ;
            }


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
                    'formatter' => $typechoose
                ),
                array (
                    'htmlOptions' => array (
                        'id'    => 'bgparent',
                    ),
                    'style' => array (
                        'border'    => 'none',
                        'color'     => 'red !important'
                    ),
                    'formatter' => $typevisitors
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
        $row[ 'total' ] = $surveyList[ 'total' ] ;
        $row[ 'draw' ]  = $surveyList[ 'draw' ] ;
        /* @var $table \f\w\table */
        $table          = \f\widgetFactory::make ( 'table' ) ;

        $userListRow = $table->renderRow ( $row ) ;
        return $userListRow ;
    }

    private function createActionButtons ( $data, $section )
    {

        $typecharticone = array (
            'type' => 'custom',
            'href' => \f\ifm::app ()->baseUrl . "cms/survey/" . $section . "Chart/" . $data[ 'id' ],
            'icon' => 'fa fa-area-chart'
                ) ;


        $buttonsParam = array (
            array (
                'type' => 'edit',
                'href' => \f\ifm::app ()->baseUrl . "cms/survey/" . $section . "Edit/" . $data[ 'id' ]
            ),
            array (
                'type'           => 'status',
                'confirm'        => TRUE,
                'id'             => 's' . $data[ 'id' ],
                'status'         => $data[ 'status' ],
                'action'         => 'cms.survey.' . $section . 'Status',
                'clientCallBack' => 'toggleEnable',
                'params'         => array (
                    'id'     => $data[ 'id' ],
                    'status' => "\"{$data[ 'status' ]}\""
                ),
            ),
            array (
                'type'           => 'delete',
                'confirm'        => true,
                'action'         => 'cms.survey.' . $section . 'Delete',
                'clientCallback' => 'remove',
                'params'         => array (
                    'id'       => $data[ 'id' ],
                    'selector' => "\"#f{$data[ 'id' ]}\""
                )
            ),
            $typecharticone,
                ) ;
        return \f\html::gridButton ( $buttonsParam ) ;
    }

    public function renderSurveyChart ( $poll_id )
    {
        if ( $poll_id )
        {
            $row = \f\ttt::service ( 'cms.survey.getsurveyById',
                                     array (
                        'id'     => $poll_id ) ) ;
            $answres = \f\ttt::service ( 'cms.survey.getAnswresById',
                                         array (
                        'id' => $row[ 'questionId' ] ) ) ;
        }
        return $this->render ( 'surveyChart',
                               array (
                    'answres' => $answres,
                    'survey'  => $row,
                ) ) ;
    }

}
