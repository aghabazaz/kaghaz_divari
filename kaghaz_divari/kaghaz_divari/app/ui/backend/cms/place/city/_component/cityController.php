<?php

class cityController extends \f\controller
{

    /**
     *
     * @var \f\cityView
     */
    private $view ;

    public function __construct()
    {
        require_once 'cityView.php' ;
        $this->view = new cityView ;
        parent::__construct() ;
    }

      public function index()
    {
        return $this->render(array (
                    'breadcrumb' => 'cms.place.city.index',
                    'content'    => $this->view->renderGrid()
                )) ;
    }
    public function cityAdd ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'cms.place.city.cityAdd',
                    'content'    => $this->view->renderCityAdd ()
                ) ) ;
    }
    public function citySave ()
    {
        return $this->response ( \f\ttt::service ( 'cms.place.city.citySave',
                                                   $this->request->getAssocParams () ) ) ;
    }
    
    public function cityList ()
    {
        $requestDataTble = $this->request->getAssocParams () ;
        return $this->response ( $this->view->renderCityGrid ( $requestDataTble ) ) ;
    }
    public function cityEdit ()
    {
        return $this->render ( array (
                    'breadcrumb' => 'cms.place.city.cityEdit',
                    'content'    => $this->view->renderCityAdd ( $this->request->getParam ( 0 ) )
                ) ) ;
    }
    
    public function cityDelete ()
    {
        return $this->response ( \f\ttt::service ( 'cms.place.city.cityDelete',
                                                   $this->request->getAssocParams () ) ) ;
    }

    public function cityStatus ()
    {
        return $this->response ( \f\ttt::service ( 'cms.place.city.cityStatus',
                                                   $this->request->getAssocParams () ) ) ;
    }
    
     public function getListCity()
    {
        $param=$this->request->getAssocParams ();
        $group=  \f\ttt::service('cms.place.city.getCityList',array('id'=>$param['state_id'],'status'=>'enabled'));
        $content='<option></option>';
        foreach ($group AS $data)
        {
            $content.='<option value="'.$data['id'].'">'.$data['title'].'</option>';
        }
        return $this->response (array('content'=>$content));
    }


}
