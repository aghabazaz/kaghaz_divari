<?php
/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \chartex\crm\marketing\tag
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class tagService extends \f\service
{
    /**
     *
     * @var shortcutMapper 
     */
    private $mapper ;

    public function __construct ()
    {
        $this->mapper = \f\dalFactory::make ( 'cms.tag' ) ;
    }
    public function tagList ()
    {
        return \f\ttt::dal ( 'cms.tag.tagList',
                             $this->request->getAssocParams () ) ;
    }
    public function tagSave()
    {
        $params = $this->request->getAssocParams () ;
        if($params['id'])
        {
             $result = \f\ttt::dal ( 'cms.tag.tagSaveEdit', $params ) ;
             $msg=\f\ifm::t ( 'tagSaveEdit' );
             $reset=FALSE;
        }
        else
        {
             $result = \f\ttt::dal ( 'cms.tag.tagSave', $params ) ;
             $msg=\f\ifm::t ( 'tagSave' );
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
     public function tagDelete ()
    {
        return \f\ttt::dal ( 'cms.tag.tagDelete',
                             $this->request->getAssocParams () ) ;
    }

    public function tagStatus ()
    {
        return \f\ttt::dal ( 'cms.tag.tagStatus',
                             $this->request->getAssocParams () ) ;
    }
    
    public function getTagById ()
    {
        return \f\ttt::dal ( 'cms.tag.getTagById',
                             $this->request->getAssocParams () ) ;
    }
    
    public function getTagByOwnerId ()
    {
        
        return \f\ttt::dal ( 'cms.tag.getTagByOwnerId',
                             $this->request->getAssocParams () ) ;
    }
    
   

   

}