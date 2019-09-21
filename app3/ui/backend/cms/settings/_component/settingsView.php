<?php

class settingsView extends \f\view
{
    function renderEmailSetting ()
    {
        $settings = \f\ttt::service ( 'cms.settings.getSettings' ) ;

        return $this->render ( 'settings',
                               array (
                    'settings' => $settings
                ) ) ;
    }
}
