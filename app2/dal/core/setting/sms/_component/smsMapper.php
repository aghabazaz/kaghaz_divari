<?php

class smsMapper extends \f\dal
{

    public function __construct()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
    }

    public function saveMessage()
    {
        $params=  $this->request->getAssocParams();
        $this->sqlEngine->save('core_sms_message',array(
            'owner_id'=>$params['owner_id'],
            'text'=>$params['txt'],
            'reciever_number'=>$params['receiver'],
            'send_sms_id'=>$params['result'], 
        ));
    }

}
?>
