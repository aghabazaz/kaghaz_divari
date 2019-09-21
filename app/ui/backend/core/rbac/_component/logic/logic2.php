<?php

class logic2 extends \f\view
{

    public function run ()
    {
        
    }

    public function renderSetting ( $param )
    {

        if ( $param[ 'pl_id' ] || $param[ 'upl_id' ])
        {
            $param[ 'keys' ] = array ( 'value', 'time' ) ;
            if ( $param[ 'type' ] == 'permission' )
            {
                $param[ 'params' ] = array ( 'PL_ID'   => $param[ 'pl_id' ], 'logicid' => $param[ 'logicID' ] ) ;
            }
            if ( $param[ 'type' ] == 'role' )
            {
                $param[ 'params' ] = array ( 'RPL_ID'   => $param[ 'pl_id' ], 'roleid'   => $param[ 'roleid' ], 'rlogicid' => $param[ 'logicID' ] ) ;
            }

            if ( $param[ 'type' ] == 'userPR' )
            {
                $param[ 'params' ] = array ( 'UPL_ID'   => $param[ 'upl_id' ], 'userid'   => $param[ 'userid' ], 'ulogicid' => $param[ 'logicID' ] ) ;
            }

            $setting = \f\ttt::service ( 'core.setting.getKeyGroup', $param ) ;
        }

        $url = $param[ 'postUrl' ] ;
        return $this->render ( 'logic' . \f\DS . 'testLogicForm',
                               array ( 'param'   => $param, 'setting' => $setting, 'url'     => $url ) ) ;
    }

}
