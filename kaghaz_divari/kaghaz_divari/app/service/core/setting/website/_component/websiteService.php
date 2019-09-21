<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \chartex\core\websiteCenter
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class websiteService extends \f\service
{

    public function websiteSettingSave ()
    {
        $param = $this->request->getAssocParams () ;
       
        
        $param['logo_url']= \f\ttt::service('core.fileManager.getFileUrlById',array(
            'fileId'=>$param['logo']
        ));
        
       $param['logo_footer_url']= \f\ttt::service('core.fileManager.getFileUrlById',array(
            'fileId'=>$param['logo_footer']
        ));

        \f\ttt::dal ( 'core.setting.website.websiteSettingSave',
                          $param) ;

        $data = array ( 'result'  => 'success', 'message' => \f\ifm::t ( 'saveSettings' ) ) ;

        return $data ;
    }
   

    public function getWebsiteInfo ()
    {
        $ownerId=\f\ttt::dal ( 'core.auth.getUserOwner' );
        //\f\pre($ownerId);
        
        return \f\ttt::dal ( 'core.setting.website.getWebsiteInfo',
                                 array ('ownerId'=>$ownerId) ) ;
    }

   

}