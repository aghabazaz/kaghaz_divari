<?php
/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \shop\marketing\baseInfo
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class baseInfoService extends \f\service
{
    /**
     *
     * @var shortcutMapper 
     */
    private $mapper ;

    public function __construct ()
    {
        $this->mapper = \f\dalFactory::make ( 'shop.baseInfo' ) ;
    }
    public function baseInfoList ()
    {
        return \f\ttt::dal ( 'shop.baseInfo.baseInfoList',
                             $this->request->getAssocParams () ) ;
    }
    public function baseInfoSave()
    {
        $params = $this->request->getAssocParams () ;
        if($params['id'])
        {
             $result = \f\ttt::dal ( 'shop.baseInfo.baseInfoSaveEdit', $params ) ;
             $msg=\f\ifm::t ( 'baseInfoSaveEdit' );
        }
        else
        {
             $result = \f\ttt::dal ( 'shop.baseInfo.baseInfoSave', $params ) ;
             $msg=\f\ifm::t ( 'baseInfoSave' );
        }
       
        
        if ( $result )
        {
            $data = array ( 'result'  => 'success', 'message' => $msg ) ;
        }
        else
        {
            $data = array ( 'result'  => 'error', 'message' => \f\ifm::t ( 'dbError' ) ) ;
        }
        
        return $data;
    }
     public function baseInfoDelete ()
    {
        return \f\ttt::dal ( 'shop.baseInfo.baseInfoDelete',
                             $this->request->getAssocParams () ) ;
    }

    public function baseInfoStatus ()
    {
        return \f\ttt::dal ( 'shop.baseInfo.baseInfoStatus',
                             $this->request->getAssocParams () ) ;
    }
    
    public function getBaseInfoById ()
    {
        return \f\ttt::dal ( 'shop.baseInfo.getBaseInfoById',
                             $this->request->getAssocParams () ) ;
    }
    
    public function getBaseInfoByOwner ()
    {
        return \f\ttt::dal ( 'shop.baseInfo.getBaseInfoByOwner',
                             $this->request->getAssocParams () ) ;
    }
    
   

   

}