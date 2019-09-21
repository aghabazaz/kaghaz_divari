<?php

class zarinpalView extends \f\view
{
    function renderZarinpalBankSetting ()
    {
        $settings = \f\ttt::service ( 'core.setting.bank.zarinpal.getZarinpalBankSetting' ) ;

        return $this->render ( 'zarinpalBankSetting',
                               array (
                    'settings' => $settings
                ) ) ;
    }
    
}
