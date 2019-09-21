<?php
/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \chartex\crm\marketing\city
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class cityService extends \f\service
{
    /**
     *
     * @var shortcutMapper 
     */
    private $mapper ;

    public function __construct ()
    {
        $this->mapper = \f\dalFactory::make ( 'cms.place.city' ) ;
    }
    public function cityList ()
    {
        return \f\ttt::dal ( 'cms.place.city.cityList',
                             $this->request->getAssocParams () ) ;
    }
    public function citySave()
    {
        $params = $this->request->getAssocParams () ;
        if($params['id'])
        {
             $result = \f\ttt::dal ( 'cms.place.city.citySaveEdit', $params ) ;
             $msg=\f\ifm::t ( 'citySaveEdit' );
             $reset=FALSE;
        }
        else
        {
             $result = \f\ttt::dal ( 'cms.place.city.citySave', $params ) ;
             $msg=\f\ifm::t ( 'citySave' );
             $reset=TRUE;
        }
       
        
        if ( $result )
        {
            $data = array ( 'result'  => 'success', 'message' => $msg, 'reset' => $reset ) ;
        }
        else
        {
            $data = array ( 'result'  => 'error', 'message' => \f\ifm::t ( 'dbError' ) ) ;
        }
        
        return $data;
    }
     public function cityDelete ()
    {
        return \f\ttt::dal ( 'cms.place.city.cityDelete',
                             $this->request->getAssocParams () ) ;
    }

    public function cityStatus ()
    {
        return \f\ttt::dal ( 'cms.place.city.cityStatus',
                             $this->request->getAssocParams () ) ;
    }
    
    public function getCityById ()
    {
        return \f\ttt::dal ( 'cms.place.city.getCityById',
                             $this->request->getAssocParams () ) ;
    }
    
    public function getCityList ()
    {
        
        return \f\ttt::dal ( 'cms.place.city.getCityList',
                             $this->request->getAssocParams () ) ;
    }
   
    
   

   

}