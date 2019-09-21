<?php

class testLogic4 extends \f\view
{
    public function run(){
        
    }
    
    public function renderSetting($param){
        if($param['pl_id']){
            $param['keys'] = array('value','time');
            if($param['type'] == 'permission'){
                $param['params'] = array('PL_ID' => $param['pl_id']);
            }
            if($param['type'] == 'role'){
                $param['params'] = array('RPL_ID' => $param['pl_id'],'roleid' => $param['roleid'], 'logicid' => $param['logicID']);
            }

            $setting = \f\ttt::service ( 'core.setting.getKeyGroup',$param ) ;
        }
       
        $url = $param['postUrl'];
        return $this->render ( 'logic'.\f\DS.'testLogicForm', array('param' => $param, 'setting' => $setting , 'url' => $url) ) ;
    }
}
