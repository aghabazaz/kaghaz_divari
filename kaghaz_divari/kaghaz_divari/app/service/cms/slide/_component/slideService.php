<?php
/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \chartex\crm\marketing\slide
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class slideService extends \f\service
{
    /**
     *
     * @var shortcutMapper 
     */
    private $mapper ;

    public function __construct ()
    {
        $this->mapper = \f\dalFactory::make ( 'cms.slide' ) ;
    }
    public function slideList ()
    {
        return \f\ttt::dal ( 'cms.slide.slideList',
                             $this->request->getAssocParams () ) ;
    }
    public function slideSave()
    {
        $params = $this->request->getAssocParams () ;
        
        $params['picture_url']= \f\ttt::service('core.fileManager.getFileUrlById',array(
            'fileId'=>$params['picture']
        ));
        
        //\f\pre($params);
        if($params['id'])
        {
             $result = \f\ttt::dal ( 'cms.slide.slideSaveEdit', $params ) ;
             $msg=\f\ifm::t ( 'slideSaveEdit' );
             $reset=FALSE;
        }
        else
        {
             $result = \f\ttt::dal ( 'cms.slide.slideSave', $params ) ;
             $msg=\f\ifm::t ( 'slideSave' );
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
     public function slideDelete ()
    {
        return \f\ttt::dal ( 'cms.slide.slideDelete',
                             $this->request->getAssocParams () ) ;
    }

    public function slideStatus ()
    {
        return \f\ttt::dal ( 'cms.slide.slideStatus',
                             $this->request->getAssocParams () ) ;
    }
    
    public function getSlideById ()
    {
        return \f\ttt::dal ( 'cms.slide.getSlideById',
                             $this->request->getAssocParams () ) ;
    }
    
    public function getSlideList ()
    {
        return \f\ttt::dal ( 'cms.slide.getSlideList',
                             $this->request->getAssocParams () ) ;
    }
   
    
   

   

}