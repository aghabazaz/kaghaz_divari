<?php

class mellatView extends \f\view
{
    function renderMellatBankSetting ()
    {
        $settings = \f\ttt::service ( 'core.setting.bank.mellat.getMellatBankSetting' ) ;

        return $this->render ( 'mellatBankSetting',
                               array (
                    'settings' => $settings
                ) ) ;
    }
    
}
