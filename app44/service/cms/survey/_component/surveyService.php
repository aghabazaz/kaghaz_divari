<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \chartex\crm\marketing\slide
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class surveyService extends \f\service
{

    /**
     *
     * @var shortcutMapper 
     */
    private $mapper ;

    public function __construct ()
    {
        $this->mapper = \f\dalFactory::make ( 'cms.survey' ) ;
    }

    public function surveyList ()
    {
        return \f\ttt::dal ( 'cms.survey.surveyList',
                             $this->request->getAssocParams () ) ;
    }

    public function surveySave ()
    {
        $params = $this->request->getAssocParams () ;
        if ( $params[ 'id' ] )
        {
            $result = \f\ttt::dal ( 'cms.survey.surveySaveEdit', $params ) ;
            $msg    = \f\ifm::t ( 'surveySaveEdit' ) ;
            $reset  = FALSE ;
        }
        else
        {
            $result = \f\ttt::dal ( 'cms.survey.surveySave', $params ) ;
            $msg    = \f\ifm::t ( 'surveySave' ) ;
            $reset  = TRUE ;
        }

        if ( $result )
        {
            $data = array (
                'result'  => 'success',
                'message' => $msg,
                'reset'   => $reset ) ;
        }
        else
        {
            $data = array (
                'result'  => 'error',
                'message' => \f\ifm::t ( 'dbError' ) ) ;
        }

        return $data ;
    }

    public function surveyDelete ()
    {
        return \f\ttt::dal ( 'cms.survey.surveyDelete',
                             $this->request->getAssocParams () ) ;
    }

    public function surveyStatus ()
    {
        return \f\ttt::dal ( 'cms.survey.surveyStatus',
                             $this->request->getAssocParams () ) ;
    }

    public function getsurveyById ()
    {
        return \f\ttt::dal ( 'cms.survey.getsurveyById',
                             $this->request->getAssocParams () ) ;
    }

    public function getAnswresById ()
    {
        return \f\ttt::dal ( 'cms.survey.getAnswresById',
                             $this->request->getAssocParams () ) ;
    }

    ////////////////////front
    public function renderSurveyFrontend ()
    {
        return \f\ttt::dal ( 'cms.survey.renderSurveyFrontend',
                             $this->request->getAssocParams () ) ;
    }

    public function answerSurveySave ()
    {
        $params = $this->request->getAssocParams () ;
        if ( ! empty ( $params[ 'choice' ] ) )
        {
            $result = \f\ttt::dal ( 'cms.survey.answerSurveySave', $params ) ;
            if ( $result )
            {
                if ( $result == 'surveyReserved' )
                {
                    $data = array (
                        'result'  => 'error',
                        'message' => \f\ifm::t ( 'surveyReserved' ) ) ;
                }
                else
                {
                    $data = array (
                        'result'  => 'success',
                        'message' => \f\ifm::t ( 'surveyanswered' ),
                        'reset'   => TRUE ) ;
                }
            }
            else
            {
                $data = array (
                    'result'  => 'error',
                    'message' => \f\ifm::t ( 'dbError' ) ) ;
            }
        }
        else
        {
            $data = array (
                    'result'  => 'error',
                    'message' => \f\ifm::t ( 'choiceError' ) ) ;
        }

        return $data ;
    }

    public function getChartByCount ()
    {
        $params = $this->request->getAssocParams () ;
        $row    = \f\ttt::dal ( 'cms.survey.getChartByCount', $params ) ;


        foreach ( $row AS $data )
        {
            $mainArray[] = array (
                'columns' => $data[ 'title' ],
                'rows'    => $data[ 'num' ] ) ;
        }
        return array (
            $mainArray ) ;
    }

}
