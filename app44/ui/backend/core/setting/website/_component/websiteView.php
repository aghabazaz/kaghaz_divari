<?php

class websiteView extends \f\view
{
    function renderWebsiteSetting ()
    {

       
        $settings = \f\ttt::service ( 'core.setting.website.getWebsiteInfo' ) ;
        
        //\f\pr($settings);

        return $this->render ( 'websiteSetting',
                               array (
                    'settings' => $settings
                ) ) ;
    }
}
