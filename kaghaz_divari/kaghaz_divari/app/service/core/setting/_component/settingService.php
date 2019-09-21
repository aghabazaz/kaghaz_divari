<?php

/**
 * The settings component manages hole settings of the application.
 * 
 * @author Yuness Mehdian <mehdian.y@gmail.com>
 * @package core.setting
 * @category component
 */
class settingService extends \f\service
{

    public function getKey()
    {
        return \f\ttt::dal('core.setting.getKey', $this->request) ;
    }

    public function saveKey()
    {
        \f\ttt::dal('core.setting.saveKeyGroup', $this->request) ;
    }

    public function getKeyGroup()
    {
        return \f\ttt::dal('core.setting.getKeyGroup', $this->request) ;
    }

    public function saveKeyGroup()
    {
        //\f\pr($this->request);
        \f\ttt::dal('core.setting.saveKeyGroup', $this->request) ;
    }

    public function deleteKeyGroup()
    {
        return \f\ttt::dal('core.setting.deleteKeyGroup', $this->request) ;
    }
    
    public function getKeyGroupPart(){
        return \f\ttt::dal('core.setting.getKeyGroupPart', $this->request) ;
    }

}
