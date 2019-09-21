<?php

class surveyMapper extends \f\dal
{

    public $sqlEngine ;
    private $dataTable ;
    private $survey_tbl          = 'cms_survey' ;
    private $question_survey_tbl = 'cms_survey_question' ;
    private $chooce_survey_tbl   = 'cms_survey_choose' ;
    private $answer_survey_tbl   = 'cms_survey_answer' ;

    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
        $this->dataTable = \f\dalFactory::make ( 'core.dataTable' ) ;
    }

    public function surveyList ()
    {
        $pr               = $this->request->getAssocParams () ;
        $requestDataTable = $pr[ 'dataTableParams' ] ;
        $columns          = array (
            array (
                'db' => 't1.id', //column name selected
                'dt' => 0, //column num
            ),
            array (
                'db' => 't1.title',
                'dt' => 1,
            ),
            array (
                'db' => 't1.typechoose',
                'dt' => 3,
            ),
            array (
                'db' => 't1.typevisitors',
                'dt' => 4,
            ),
            array (
                'db' => 't1.typechart',
                'dt' => 5,
            ),
            array (
                'db' => 't1.status',
                'dt' => 6,
            ),
                ) ;
        $whereJoin        = array (
            "t1.id>0" ) ;

        $result = array (
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->survey_tbl . ' AS t1',
            'primaryKey'      => $this->survey_tbl . '.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins          = array (),
            'whereJoin'       => $whereJoin
                ) ;
        $out    = $this->dataTable->getDataTable ( $result ) ;
        return $out ;
    }

    public function surveySave ()
    {
        $params      = $this->request->getAssocParams () ;
        $result      = $this->sqlEngine->save ( $this->survey_tbl,
                                                array (
            'title'        => $params[ 'title' ],
            'typechoose'   => $params[ 'typechoose' ],
            'typevisitors' => $params[ 'typevisitors' ],
            'typechart'    => $params[ 'typechart' ],
            'number'       => 0,
            'status'       => 'enabled',
                ) ) ;
        $survey_id   = $this->sqlEngine->last_id () ;
        $question    = $params[ 'question' ] ;
        $this->sqlEngine->save ( $this->question_survey_tbl,
                                 array (
            'title'     => $question,
            'survey_id' => $survey_id,
        ) ) ;
        $question_id = $this->sqlEngine->last_id () ;

        for ( $i = 0 ; $i < count ( $params[ 'answer' ] ) ; $i ++ )
        {
            $this->sqlEngine->save ( $this->chooce_survey_tbl,
                                     array (
                'title'       => $params[ 'answer' ][ $i ],
                'question_id' => $question_id,
                    )
            ) ;
        }
        return $result ;
    }

    public function surveySaveEdit ()
    {
        $params = $this->request->getAssocParams () ;
        $result = $this->sqlEngine->save ( $this->survey_tbl,
                                           array (
            'title'        => $params[ 'title' ],
            'typechoose'   => $params[ 'typechoose' ],
            'typevisitors' => $params[ 'typevisitors' ],
            'typechart'    => $params[ 'typechart' ],
            'status'       => 'enabled',
                ),
                                           array (
            'id=?',
            array (
                $params[ 'id' ] ) ) ) ;

        $question = $params[ 'question' ] ;
        $this->sqlEngine->Select ()
                ->From ( $this->question_survey_tbl )
                ->Where ( 'survey_id=?', $params[ 'id' ] )
                ->Run () ;

        $question_id = $this->sqlEngine->getRow () ;

        $this->sqlEngine->save ( $this->question_survey_tbl,
                                 array (
            'title' => $question,
                ),
                                 array (
            'survey_id=?',
            array (
                $params[ 'id' ] ) ) ) ;


        $ansId = implode ( ',', $params[ 'answerId' ] ) ;
        //\f\pre($ansId);

        $this->sqlEngine->remove ( $this->chooce_survey_tbl,
                                   array (
            'question_id=? AND id NOT IN (' . $ansId . ')',
            array (
                $question_id[ 'id' ] )
        ) ) ;

        for ( $i = 0 ; $i < count ( $params[ 'answer' ] ) ; $i ++ )
        {
            if ( $params[ 'answerId' ][ $i ] )
            {
                $this->sqlEngine->save ( $this->chooce_survey_tbl,
                                         array (
                    'title' => $params[ 'answer' ][ $i ],
                        ),
                                         array (
                    'id=?',
                    array (
                        $params[ 'answerId' ][ $i ] ) )
                ) ;
            }
            else
            {
                $this->sqlEngine->save ( $this->chooce_survey_tbl,
                                         array (
                    'title'       => $params[ 'answer' ][ $i ],
                    'question_id' => $question_id[ 'id' ],
                        )
                ) ;
            }
        }


        return $result ;
    }

    public function surveyDelete ()
    {
        $param = $this->request->getAssocParams () ;
        $id    = $param[ 'id' ] ;
        $this->sqlEngine->remove ( $this->survey_tbl,
                                   array (
            'id=?',
            array (
                $id ) ) ) ;

        return array (
            'result' => 'success',
            'func'   => 'remove' ) ;
    }

    public function surveyStatus ()
    {
        $param  = $this->request->getAssocParams () ;
        $id     = $param[ 'id' ] ;
        $status = $param[ 'status' ] == 'enabled' ? 'disabled' : 'enabled' ;

        $this->sqlEngine->save ( $this->survey_tbl,
                                 array (
            'status' => $status
                ),
                                 array (
            'id=?',
            array (
                $id ) ) ) ;

        return array (
            'result' => 'success',
            'status' => $status,
            'id'     => $id,
            'func'   => 'status' ) ;
    }

    public function getsurveyById ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ( 't1.*,t2.title AS question,t2.id AS questionId' )
                ->From ( $this->survey_tbl . ' AS t1' )
                ->leftJoin ( 'cms_survey_question AS t2' )
                ->On ( 't1.id=t2.survey_id' )
                ->Where ( 't1.id=?', $param[ 'id' ] )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function getAnswresById ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ()
                ->From ( $this->chooce_survey_tbl . ' AS t1' )
                ->Where ( 't1.question_id =?', $param[ 'id' ] )
                ->Run () ;
        return $this->sqlEngine->getRows () ;
    }

    //////////////front
    public function renderSurveyFrontend ()
    {
        $this->sqlEngine->Select ( 't1.*,t2.title AS question,t2.id AS questionId' )
                ->From ( $this->survey_tbl . ' AS t1' )
                ->leftJoin ( 'cms_survey_question AS t2' )
                ->On ( 't1.id=t2.survey_id' )
                ->Where ( 't1.status=?', 'enabled' )
                ->OrderBy ( 'id DESC' )
                ->Limit ( 1 )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function answerSurveySave ()
    {
        $param = $this->request->getAssocParams () ;

        $this->sqlEngine->Select ()
                ->From ( $this->answer_survey_tbl )
                ->Where ( 'user_id=?', $param[ 'user_id' ] )
                ->Run () ;
        $exitsurvey = $this->sqlEngine->getRow () ;

        if ( $exitsurvey || $_COOKIE[ 'poll' . $param[ 'poll_id' ] ] )
        {
            $result = 'surveyReserved' ;
        }
        else
        {
            if ( ! $param[ 'user_id' ] )
            {
                $param[ 'user_id' ] = NULL ;
            }

            for ( $i = 0 ; $i < count ( $param[ 'choice' ] ) ; $i ++ )
            {
                $result = $this->sqlEngine->save ( $this->answer_survey_tbl,
                                                   array (
                    'survey_id'   => $param[ 'poll_id' ],
                    'question_id' => $param[ 'question_id' ],
                    'choose_id'   => $param[ 'choice' ][ $i ],
                    'user_id'     => $param[ 'user_id' ]
                        )
                        ) ;
            }

            if ( $result )
            {
                $this->sqlEngine->Update ( $this->survey_tbl )
                        ->setField ( 'number=number+1' )
                        ->Where ( 'id=?', $param[ 'poll_id' ] )
                        ->Run () ;

                if (!$param[ 'user_id' ] )
                {
                    $cookie_user  = $param[ 'poll_id' ] ;
                    $cookie_value = $param[ 'poll_id' ] ;
                    setcookie ( 'poll' . $cookie_user, $cookie_value,
                                time () + (86400 * 30), "/" ) ;
                }
            }
        }
        return $result ;
    }

    public function getChartByCount ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ( 'count(t1.id) AS num,t2.id , t2.title' )
                ->From ( 'cms_survey_choose AS t2' )
                ->leftJoin ( $this->answer_survey_tbl . ' AS t1' )
                ->On ( 't2.id=t1.choose_id' )
                ->Where ( 't2.question_id =?', $param[ 'questionId' ] )
                ->GroupBy ( 't2.id' )
                ->Run () ;
        return $this->sqlEngine->getRows () ;
    }

}
