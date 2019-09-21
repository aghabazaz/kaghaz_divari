<?php

class aboutView extends \f\view
{
    function renderAboutSetting ()
    {
        $settings = \f\ttt::service ( 'cms.about.getAboutSetting' ) ;

        return $this->render ( 'aboutSetting',
                               array (
                    'settings' => $settings
                ) ) ;
    }
}
