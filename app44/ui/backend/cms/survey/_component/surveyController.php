<?php

class surveyController extends \f\controller
{

    /**
     *
     * @var \f\slideView
     */
    private $view ;

    public function __construct ()
    {
        require_once 'surveyView.php' ;
        $this->view = new surveyView ;
        parent::__construct () ;
    }

    public function index ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'cms.survey.index',
                    'content'    => $this->view->renderGrid ()
                ) ) ;
    }

    public function surveyList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderSurveyGrid ( $requestDataTble ) ) ;
    }

    public function surveyAdd ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'cms.survey.surveyAdd',
                    'content'    => $this->view->renderSurveyAdd ()
                ) ) ;
    }

    public function surveySave ()
    {
        return $this->response ( \f\ttt::service ( 'cms.survey.surveySave',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function surveyEdit ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'cms.survey.surveyEdit',
                    'content'    => $this->view->renderSurveyAdd ( $this->request->getParam ( 0 ) )
                ) ) ;
    }

    public function surveyDelete ()
    {
        return $this->response ( \f\ttt::service ( 'cms.survey.surveyDelete',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function surveyStatus ()
    {
        return $this->response ( \f\ttt::service ( 'cms.survey.surveyStatus',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function surveyChart ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'cms.survey.surveyChart',
                    'content'    => $this->view->renderSurveyChart ( $this->request->getParam ( 0 ) )
                ) ) ;
    }

    public function getChartByCount ()
    {
        return $this->response (
                        array (
                            'data' => \f\ttt::service ( 'cms.survey.getChartByCount',
                                                        $this->request->getAssocParams () ),
                        )
                ) ;
    }

}
