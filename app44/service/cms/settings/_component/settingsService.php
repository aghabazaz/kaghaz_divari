<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \chartex\core\settingsCenter
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class settingsService extends \f\service
{

    public function settingSave ()
    {
        $param = $this->request->getAssocParams () ;

        \f\ttt::service ( 'core.setting.saveKeyGroup',
                          array (
            'keyValues' => $param,
            'params'    => array (
                'userId'      => \f\ttt::dal ( 'core.auth.getUserOwner' ),
                'componentId' => 'cmsSetting' ) ) ) ;

        $data = array (
            'result'  => 'success',
            'message' => \f\ifm::t ( 'saveSettings' ) ) ;

        return $data ;
    }

    //--------------------------------------------------------------------------
    public function getSettings ()
    {
        $ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;

        if ( ! $ownerId )
        {
            $ownerId = \f\ttt::dal ( 'core.auth.getOwnerFront' ) ;
        }

        return \f\ttt::service ( 'core.setting.getKeyGroup',
                                 array (
                    'keys' => array ( ),
                    'params' => array (
                        'userId'      => $ownerId,
                        'componentId' => 'cmsSetting' ) ) ) ;
    }


}
?>
