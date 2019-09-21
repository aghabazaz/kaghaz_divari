<?php
/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \chartex\crm\marketing\state
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class stateService extends \f\service
{
    /**
     *
     * @var shortcutMapper 
     */
    private $mapper ;

    public function __construct ()
    {
        $this->mapper = \f\dalFactory::make ( 'cms.place.state' ) ;
    }
    public function stateList ()
    {
        return \f\ttt::dal ( 'cms.place.state.stateList',
                             $this->request->getAssocParams () ) ;
    }
    public function stateSave()
    {
        $params = $this->request->getAssocParams () ;
        if($params['id'])
        {
             $result = \f\ttt::dal ( 'cms.place.state.stateSaveEdit', $params ) ;
             $msg=\f\ifm::t ( 'stateSaveEdit' );
             $reset=FALSE;
        }
        else
        {
             $result = \f\ttt::dal ( 'cms.place.state.stateSave', $params ) ;
             $msg=\f\ifm::t ( 'stateSave' );
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
     public function stateDelete ()
    {
        return \f\ttt::dal ( 'cms.place.state.stateDelete',
                             $this->request->getAssocParams () ) ;
    }

    public function stateStatus ()
    {
        return \f\ttt::dal ( 'cms.place.state.stateStatus',
                             $this->request->getAssocParams () ) ;
    }
    
    public function getStateById ()
    {
        return \f\ttt::dal ( 'cms.place.state.getStateById',
                             $this->request->getAssocParams () ) ;
    }
    
    public function getStateList ()
    {
       
        $param=$this->request->getAssocParams ();
        
        $row=\f\ttt::dal ( 'cms.place.state.getStateList',
                            $param ) ;
       
        
        return $row;
    }
    
   

   

}