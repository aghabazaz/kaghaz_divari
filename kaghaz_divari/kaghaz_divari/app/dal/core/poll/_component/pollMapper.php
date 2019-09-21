<?php

/**
 * Database
 */
class pollMapper extends \f\dal
{

    /**
     *
     * @var \f\g\validator
     */
    private $v ;
    private $dataTable ;

    /**
     *
     * @var dataTable 
     */
    public function __construct()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
        $this->dataTable = \f\dalFactory::make('core.dataTable') ;
    }

    public function defaultGetList()
    {
        $pr               = $this->request->getAssocParams() ;
        $requestDataTable = $pr[ 'dataTableParams' ] ; //$this->request->getParam( 'dataTableParams' ) ;

        $ownerId = \f\ttt::dal('core.auth.getUserOwner') ; //$this->request->getParam('ownerId');

        $columns = array (
            array (
                'db' => 'core_poll.id', //column name selected
                'dt' => 0,
            ),
            array (
                'db' => 'core_poll.status',
                'dt' => 1,
            ),
            array (
                'db' => 'core_poll.title',
                'dt' => 2,
            ),
            array (
                'db' => 'core_poll.show_start_date',
                'dt' => 3,
            ),
            array (
                'db' => 'core_poll.show_end_date',
                'dt' => 4,
            ),
                ) ;

        $queryArray    = $this->showPoll($requestDataTable, $columns, $ownerId) ;
        $pollListArray = $this->dataTable->getDataTable($queryArray) ;

        return $pollListArray ;
    }

    private function showPoll($requestDataTable, $columns, $ownerId)
    {
        return array (
            'requestDataTble' => $requestDataTable,
            'tableName'       => 'core_poll',
            'primaryKey'      => 'core_poll.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => array (),
            'whereJoin'       => array ( "core_poll.core_userid = '" . $ownerId . "'" ),
                ) ;
    }

    public function pollSave()
    {
        $params = $this->request->getAssocParams() ;

        $editId = $params[ 'id' ] ;
        unset($params[ 'id' ]) ;

        if ( ! $editId )
        {
            $pollId = $this->sqlEngine->save('core_poll', $params) ;
        }
        else
        {
            $this->sqlEngine->save('core_poll', $params,
                                   array (
                'id=?', array ( $editId )
            )) ;
            $pollId = $editId ;
        }
        settype($pollId, 'integer') ;
        $idPoll = $pollId ? $pollId : 'db' ;
        return $idPoll ;
    }

    public function questionSave()
    {
        $params = $this->request->getAssocParams() ;

        $editId = $params[ 'id' ] ;
        unset($params[ 'id' ]) ;

        if ( ! $editId )
        {
            $resId = $this->sqlEngine->save('core_poll_question', $params) ;
        }
        else
        {
            $this->sqlEngine->save('core_poll_question', $params,
                                   array (
                'id=?', array ( $editId )
            )) ;
            $resId = $editId ;

            if ( $params[ 'type' ] == 'descriptive' || $params[ 'type' ] == 'descriptiveArea' )
            {
                $this->removeFieldByQuestionId($editId) ;
            }
        }
        settype($resId, 'integer') ;
        $questionId = $resId ? $resId : 'db' ;
        return $questionId ;
    }

    public function fieldSave()
    {
        $params = $this->request->getAssocParams() ;

        $editId = $params[ 'id' ] ;
        unset($params[ 'id' ]) ;

        if ( ! $editId )
        {
            $resId = $this->sqlEngine->save('core_poll_question_choice', $params) ;
        }
        else
        {
            $this->sqlEngine->save('core_poll_question_choice', $params,
                                   array (
                'id=?', array ( $editId )
            )) ;
            $resId = $editId ;
        }
        settype($resId, 'integer') ;
        $fieldId = $resId ? $resId : 'db' ;
        return $fieldId ;
    }

    public function getAllQuestionId()
    {
        $this->sqlEngine->Select('id')
                ->From('core_poll_question')
                ->Where("core_pollid = ? ", $this->request->getParam('id'))
                ->Run() ;
        return $this->sqlEngine->getRows() ;
    }

    public function getAllQuestionFeildId()
    {
        $this->sqlEngine->Select('id')
                ->From('core_poll_question_choice')
                ->Where("core_poll_questionid = ? ",
                        $this->request->getParam('id'))
                ->Run() ;
        return $this->sqlEngine->getRows() ;
    }

    public function pollRemove()
    {

        $this->sqlEngine->remove('core_poll',
                                 array ( 'id=?', array ( $this->request->getParam('id') ) )) ;

        return array (
            'result' => 'success',
            'func'   => 'remove' ) ;
    }

    public function removeQuestion()
    {

        $this->sqlEngine->remove('core_poll_question',
                                 array ( 'id=?', array ( $this->request->getParam('id') ) )) ;
    }

    public function removeField($id = '')
    {
        $this->sqlEngine->remove('core_poll_question_choice',
                                 array ( 'id=?', array ( $this->request->getParam('id') ) )) ;
    }

    public function removeFieldByQuestionId($id = '')
    {
        $qId = ($id) ? $id : $this->request->getParam('id') ;
        $this->sqlEngine->remove('core_poll_question_choice',
                                 array ( 'core_poll_questionid=?', array ( $qId ) )) ;
    }

    public function pollActive()
    {

        $status = ($this->request->getParam('status') == "enabled") ? 'disabled' : 'enabled' ;

        $this->sqlEngine->Update('core_poll')
                ->setField('status=?', array ( $status ))
                ->where('id=?', $this->request->getParam('id'))
                ->Run() ;

        return array (
            'result' => 'success',
            'status' => $status,
            'id'     => $this->request->getParam('id'),
            'func'   => 'status' ) ;
    }

    public function pollInfo()
    {
        $pollId     = $this->request->getParam('id') ;
        $this->sqlEngine->Select()
                ->From('core_poll')
                ->Where("id = ? ", $pollId)
                ->Run() ;
        $resultMain = $this->sqlEngine->getRow() ;

        $this->sqlEngine->Select()
                ->From('core_poll_question')
                ->Where("core_pollid = ? ", $pollId)
                ->Run() ;
        $resultQuestion = $this->sqlEngine->getRows() ;

        $i = 0 ;
        foreach ( $resultQuestion as $result )
        {
            $this->sqlEngine->Select()
                    ->From('core_poll_question_choice')
                    ->Where("core_poll_questionid = ? ", $result[ 'id' ])
                    ->Run() ;
            $resultField = $this->sqlEngine->getRows() ;

            $resultNew[ $i ]            = $result ;
            $resultNew[ $i ][ 'field' ] = $resultField ;
            $i ++ ;
        }

        $resultMain[ 'question' ] = $resultNew ;

        return $resultMain ;
    }

    //-------------------------------------- front -----------------------------
    public function getPollActive()
    {

        $this->sqlEngine->Select()
                ->From('core_poll')
                ->Where("core_userid = ? ",\f\ttt::dal('core.auth.getUserOwner'))
                ->andWhere(" status = 'enabled' ")
                ->Run() ;
        $listPoll = $this->sqlEngine->getRows() ;


        return $listPoll ;
    }

    public function savePollUser()
    {
        $pollUserId = $this->sqlEngine->save('core_user_core_poll',
                                             $this->request->getAssocParams()) ;
        return $pollUserId ;
    }

    public function savePollAnswer()
    {
        $pollAnswerId = $this->sqlEngine->save('core_user_core_poll_question',
                                               $this->request->getAssocParams()) ;
        return $pollAnswerId ;
    }
    
    public function defaultGetPollAnswerList(){
        $pr               = $this->request->getAssocParams() ;
        $pollId           = $pr[ 'pollId' ] ;
        $requestDataTable = $pr[ 'dataTableParams' ] ; 

        $columns = array (
            array (
                'db' => 'core_user_core_poll.id', //column name selected
                'dt' => 0,
            ),
            array (
                'db' => 'core_user_core_poll.register_date',
                'dt' => 1,
            ),
                ) ;

        $queryArray    = $this->showPollAnswerList($requestDataTable, $columns, $pollId) ;
        $pollListArray = $this->dataTable->getDataTable($queryArray) ;

        return $pollListArray ;
    }
    
    private function showPollAnswerList($requestDataTable, $columns, $pollId)
    {
        return array (
            'requestDataTble' => $requestDataTable,
            'tableName'       => 'core_user_core_poll',
            'primaryKey'      => 'core_user_core_poll.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => array (),
            'whereJoin'       => array ( "core_user_core_poll.core_pollid = '" . $pollId . "'" ),
                ) ;
    }
    
    public function pollAnswerRemove()
    {

        $this->sqlEngine->remove('core_user_core_poll',
                                 array ( 'id=?', array ( $this->request->getParam('id') ) )) ;

        return array (
            'result' => 'success',
            'func'   => 'remove' ) ;
    }
    
    public function getPollAnswerDetails(){
     
        $answerId     = $this->request->getParam('answerId') ;
        
        $this->sqlEngine->Select('p.*,t2.name as userName,t3.name as userName')
                ->From('core_user_core_poll as t1')
                ->innerJoin('core_poll as p')
                ->On('p.id = t1.core_pollid')
                ->leftJoin('core_user_info as t2')
                ->On('t2.core_userid = t1.core_userid')
                ->leftJoin('core_user_info_legal as t3')
                ->On('t3.core_userid = t1.core_userid')
                ->Where("t1.id = ? ", $answerId)
                ->Run() ;
        $resultMain = $this->sqlEngine->getRow() ;
       
        
        $this->sqlEngine->Select('t2.title,t2.type,t1.answer')
                ->From('core_poll_question as t2')
                ->leftJoin('core_user_core_poll_question as t1')
                ->On(' t2.id = t1.core_poll_questionid ')
                ->Where("t2.core_pollid = ? ", $resultMain['id'])
                ->andWhere("t1.core_user_core_poll_id = ? ", $answerId)
                ->Run() ;
        $resultQuestion = $this->sqlEngine->getRows() ;

        $i = 0 ;
        foreach ( $resultQuestion as $key => $result )
        {
            if($result['type'] == 'multiple' || $result['type'] == 'single'){
              $answers = explode(',', $result['answer']);
              $answerArray = array();
              foreach($answers as $resAnswer){
                  
                    $this->sqlEngine->Select('title')
                    ->From('core_poll_question_choice')
                    ->Where("id = ? ", $resAnswer)
                    ->Run() ;
                    $resultAnswerTitle = $this->sqlEngine->getRow() ;
                    $answerArray[] = $resultAnswerTitle['title'];
                    
                    
              }  
              $resultQuestion[$key]['answer'] = $answerArray;
            }
        }

            return array(
                'info' => $resultMain,
                'details' => $resultQuestion,
            );
    }

}
