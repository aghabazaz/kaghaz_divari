<?php

class paymentMapper extends \f\dal
{

    private $pay_bank = 'pay_bank' ;

    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
    }

    public function paymentSave ()
    {
        $params                    = $this->request->getAssocParams () ;
        $params[ 'date_register' ] = time () ;
        $params[ 'name' ]          = $params[ 'name' ] ? $params[ 'name' ] : NULL ;
        $params[ 'price' ]         = str_replace ( ',', '', $params[ 'price' ] ) ;
        $params[ 'status' ]        = $params[ 'status' ] ? $params[ 'status' ] : 'unpayed' ;
        //\f\pre($params);
        $result                    = $this->sqlEngine->save ( $this->$pay_bank,
                                                              array (
            'name'          => $params[ 'name' ],
            'user_id'       => $params[ 'user_id' ],
            'price'         => $params[ 'price' ],
            'bankid'        => $params[ 'bankid' ],
            'orderid'       => $params[ 'orderid' ],
            'comment'       => $params[ 'comment' ],
            'date_register' => $params[ 'date_register' ],
            'type'          => $params[ 'type' ],
            'status'        => $params[ 'status' ],
                ) ) ;
        return $result ;
    }

    public function paymentSaveEdit ()
    {
        $params                    = $this->request->getAssocParams () ;
        $params[ 'date_register' ] = time () ;
        $params[ 'name' ]          = $params[ 'name' ] ? $params[ 'name' ] : NULL ;
        $params[ 'price' ]         = str_replace ( ',', '', $params[ 'price' ] ) ;
        $params[ 'status' ]        = $params[ 'status' ] ? $params[ 'status' ] : 'unpayed' ;
        $result                    = $this->sqlEngine->save ( $this->$pay_bank,
                                                              array (
            'name'          => $params[ 'name' ],
            'user_id'       => $params[ 'user_id' ],
            'price'         => $params[ 'price' ],
            'bankid'        => $params[ 'bankid' ],
            'orderid'       => $params[ 'orderid' ],
            'comment'       => $params[ 'comment' ],
            'date_register' => $params[ 'date_register' ],
            'type'          => $params[ 'type' ],
            'status'        => $params[ 'status' ],
                ),
                                                              array (
            'id=?',
            array (
                $params[ 'id' ] ) ) ) ;

        return $result ;
    }

    public function saveTransactionAndTurns ()
    {
        $params = $this->request->getAssocParams () ;

        $this->sqlEngine->Select ()
                ->From ( $this->pay_tbl )
                ->Where ( 'orderid=?', $params[ 'orderId' ] )
                ->Run () ;
        $row = $this->sqlEngine->getRow () ;

        //\f\pr($row);

        $result = $this->sqlEngine->save ( $this->pay_tbl,
                                           array (
            'status'     => 'payed',
            'refrenceid' => $params[ 'refrenceId' ]
                ),
                                           array (
            'orderid=?',
            array (
                $params[ 'orderId' ] ) ) ) ;
        return $result ;
    }

}

?>
