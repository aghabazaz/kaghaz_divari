<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \chartex\core\websiteCenter
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class socialnetService extends \f\service
{

//    public function websiteSettingSave ()
//    {
//        $param = $this->request->getAssocParams () ;
//        
//       
//
//        \f\ttt::dal ( 'core.setting.website.websiteSettingSave',
//                          $param) ;
//
//        $data = array ( 'result'  => 'success', 'message' => \f\ifm::t ( 'saveSettings' ) ) ;
//
//        return $data ;
//    }
   

//    public function getSocialnetInfo ()
//    {
//        $ownerId=\f\ttt::dal ( 'core.auth.getUserOwner' );
//        
//        return \f\ttt::dal ( 'core.setting.website.getWebsiteInfo',
//                                 array ('ownerId'=>$ownerId) ) ;
//    }

    
        public function SocialnetSettingSave ()
    {
        $param = $this->request->getAssocParams () ;

        \f\ttt::service ( 'core.setting.saveKeyGroup',
                          array (
            'keyValues' => $param,
            'params'    => array (
                'userId'      => \f\ttt::dal ( 'core.auth.getUserOwner' ),
                'componentId' => 'SocialnetSetting' ) ) ) ;

        $data = array (
            'result'  => 'success',
            'message' => \f\ifm::t ( 'saveSettings' ) ) ;

        return $data ;
    }

     //--------------------------------------------------------------------------
    public function getSocialnetSetting ()
    {
        $ownerId=\f\ttt::dal ( 'core.auth.getUserOwner' );
        
        if(!$ownerId)
        {
            $ownerId = \f\ttt::dal ( 'core.auth.getOwnerFront' ) ;
        }
        
        return \f\ttt::service ( 'core.setting.getKeyGroup',
                                 array (
                    'keys' => array ( ),
                    'params' => array (
                        'userId'      => $ownerId,
                        'componentId' => 'SocialnetSetting' ) ) ) ;
    }

   

}