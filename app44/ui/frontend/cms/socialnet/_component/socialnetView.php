<?php

class socialnetView extends \f\view
{

    public function rendersocialnetFrontend ($params='')
    {
        $social = \f\ttt::service ( 'cms.socialnet.getSocialnetSetting',
                                    array (
                ) ) ;
        $view   = $params[ 'type' ] ? $params[ 'type' ] : 'index' ;
        return $this->render ( $view,
                               array (
                    'row' => $social,
                ) ) ;
    }

}

?>