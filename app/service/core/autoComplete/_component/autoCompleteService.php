<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \chartex\agency\hotel
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class autoCompleteService extends \f\service
{

    public function getData ()
    {
        //\f\pr( $this->request->getAssocParams ());
        return \f\ttt::dal ( 'core.autoComplete.getData',
        $this->request->getAssocParams ()) ;
    }

}