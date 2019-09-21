<?php

class shopSettingView extends \f\view
{
    function renderEmailSetting ()
    {
        $shopSetting = \f\ttt::service ( 'shop.shopSetting.getSettings' ) ;
        return $this->render ( 'shopSetting',
                               array (
                    'shopSetting' => $shopSetting
                ) ) ;
    }
}
