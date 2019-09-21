<?php

class smsView extends \f\view
{
    function renderSmsSetting ()
    {

        $settings = array ( ) ;
        $settings = \f\ttt::service ( 'core.setting.sms.getSmsSetting' ) ;

        return $this->render ( 'smsSetting',
                               array (
                    'settings' => $settings
                ) ) ;
    }
}
