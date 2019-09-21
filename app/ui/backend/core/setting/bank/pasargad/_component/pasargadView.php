<?php

class pasargadView extends \f\view
{
    function renderPasargadBankSetting ()
    {
        $settings = \f\ttt::service ( 'core.setting.bank.pasargad.getPasargadBankSetting' ) ;

        return $this->render ( 'pasargadBankSetting',
                               array (
                    'settings' => $settings
                ) ) ;
    }
    
    
    
}
