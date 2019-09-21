<?php

class mabnaView extends \f\view
{
    function renderMabnaBankSetting ()
    {
        $settings = \f\ttt::service ( 'core.setting.bank.mabna.getMabnaBankSetting' ) ;

        return $this->render ( 'mabnaBankSetting',
                               array (
                    'settings' => $settings
                ) ) ;
    }
    
}
