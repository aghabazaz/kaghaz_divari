<?php

class advertisementController extends \f\controller
{

    /**
     *
     * @var advertisementView
     */
    private $view ;

    public function __construct ( $params )
    {
        include_once 'advertisementView.php' ;
        $this->view = new advertisementView ;
        parent::__construct ( $params ) ;
    }

    public function getAdvertisementtList ()
    {
       
        $params = $this->request->getAssocParams () ;
        return $this->renderPartial ( $this->view->renderGetAdvertisementList ( $params ) ) ;
    }
    public function getAdvertise ()
    {
        //\f\pre('salam');
        $param = $this->request->getAssocParams () ;
        return $this->renderPartial ( $this->view->renderAdvertise ( $param ) ) ;
    }
    public function getSocialAdvertise ()
    {
        //\f\pre('salam');
        $param = $this->request->getAssocParams () ;
        return $this->renderPartial ( $this->view->renderGetSocialAdvertise( $param ) ) ;
    }
//    public function advertisementList ()
//    {
//        $params = $this->request->getNonAssocParams () ;
//        $param  = $this->request->getAssocParams () ;
//
//        $array = $this->view->renderGetAdvertisement ( $params ) ;
//        return $this->render ( array (
//                    'content'     => $array[ 0 ],
//                    'websiteInfo' => $param[ 'websiteInfo' ],
//                    'title'       => $array[ 1 ][ 'title' ],
//                ) ) ;
//    }

    public function getAdvertisementDetail ()
    {
        $pr = $this->request->getNonAssocParams();
        $params = $this->request->getAssocParams () ;
        return $this->render ( array (
                    'content'     => $this->view->renderGetAdvertisementDetail ($pr[0]),
                    'websiteInfo' => $params[ 'websiteInfo' ],
                ) ) ;
    }
    public function advertisementListDetail ()
    {
        $pr = $this->request->getNonAssocParams();
        $params = $this->request->getAssocParams () ;
        return $this->render ( array (
                    'content'     => $this->view->renderAdvertisementListDetail ($pr),
                    'websiteInfo' => $params[ 'websiteInfo' ],
                ) ) ;
    }
    
    public function getPersonnel ()
    {
        $params = $this->request->getAssocParams () ;
        
        


        return $this->renderPartial ( $this->view->renderGetPersonnel ( $params ) ) ;
    }
    




public function advertisementList ()
    {   
        $params = $this->request->getAssocParams () ;
        return $this->renderPartial ( $this->view->renderAdvertisementList ( $params ) ) ;
    }

}
