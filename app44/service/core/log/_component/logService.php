<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \chartex\core\log
 * @category plugin
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */

class logService extends \f\service
{
    
    public function getListLog()
    {
        return \f\ttt::dal('core.log.getListLog',
                           $this->request->getAssocParams()) ;
    }
}
