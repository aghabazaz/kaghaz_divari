<?php

class bankMapper extends \f\dal
{

    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
    }

    public function savePay ()
    {
        $save = $this->request->getAssocParams () ;
        if ( ! isset ( $save[ 2 ] ) )
        {

            $result = $this->sqlEngine->save ( $save[ 0 ], $save[ 1 ] ) ;
        }
        else
        {
            $result = $this->sqlEngine->save ( $save[ 0 ], $save[ 1 ],
                                               $save[ 2 ] ) ;
        }

        //\f\pr($save);
        //\f\pre($this->sqlEngine->last_query());
        return $result ;
    }
    public function getInfoPay ()
    {
        $params = $this->request->getAssocParams () ;

        $this->sqlEngine->Select ()
                ->From ( $params[ 'tbl' ] )
                ->Where ( 'orderid=?', $params[ 'Authority' ] )
                ->Run () ;

        return $this->sqlEngine->getRow () ;
    }

}

?>
