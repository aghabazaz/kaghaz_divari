<?php

class socialnetView extends \f\view
{

    public function renderGrid ()
    {
        $settings = \f\ttt::service ( 'cms.socialnet.getSocialnetSetting' ) ;

        return $this->render ( 'socialnetform',
                               array (
                    'settings' => $settings
                ) ) ;
    }

    
    
}
