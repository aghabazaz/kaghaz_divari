<?php

class authView extends \f\view
{

    public function loginForm($failed = false)
    {
        return $this->render('loginForm',
                             array (
                    'failed' => $failed
                )) ;
    }

}
