<?php

class memberSettingView extends \f\view
{
    function renderEmailSetting ()
    {
        $memberSetting = \f\ttt::service ( 'member.memberSetting.getSettings' ) ;
        //\f\pre($memberSetting);
        return $this->render ( 'memberSetting',
                               array (
                    'memberSetting' => $memberSetting
                ) ) ;
    }
}
