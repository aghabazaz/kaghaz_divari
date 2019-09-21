<?php
/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \chartex\crm\marketing\section
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class sectionService extends \f\service
{
    /**
     *
     * @var shortcutMapper 
     */
    private $mapper ;

    public function __construct ()
    {
        $this->mapper = \f\dalFactory::make ( 'cms.section' ) ;
    }
    public function sectionList ()
    {
        return \f\ttt::dal ( 'cms.section.sectionList',
                             $this->request->getAssocParams () ) ;
    }
    public function sectionSave()
    {
        $params = $this->request->getAssocParams () ;
        
        
        if($params['id'])
        {
             $result = \f\ttt::dal ( 'cms.section.sectionSaveEdit', $params ) ;
             $msg=\f\ifm::t ( 'sectionSaveEdit' );
             $reset=FALSE;
        }
        else
        {
             $result = \f\ttt::dal ( 'cms.section.sectionSave', $params ) ;
             $msg=\f\ifm::t ( 'sectionSave' );
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
     public function sectionDelete ()
    {
        return \f\ttt::dal ( 'cms.section.sectionDelete',
                             $this->request->getAssocParams () ) ;
    }

    public function sectionStatus ()
    {
        return \f\ttt::dal ( 'cms.section.sectionStatus',
                             $this->request->getAssocParams () ) ;
    }
    
    public function getSectionById ()
    {
        return \f\ttt::dal ( 'cms.section.getSectionById',
                             $this->request->getAssocParams () ) ;
    }
    
    public function getSectionByOwnerId ()
    {
        return \f\ttt::dal ( 'cms.section.getSectionByOwnerId',
                             $this->request->getAssocParams () ) ;
    }
    
    public function getListSectionFront ()
    {
        return \f\ttt::dal ( 'cms.section.getListSectionFront',
                             $this->request->getAssocParams () ) ;
    }
    
   

   

}