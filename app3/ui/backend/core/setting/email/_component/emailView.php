<?php

class emailView extends \f\view
{
    function renderEmailSetting ()
    {
        $settings = \f\ttt::service ( 'core.setting.email.getEmailSetting' ) ;

        return $this->render ( 'emailSetting',
                               array (
                    'settings' => $settings
                ) ) ;
    }
}
