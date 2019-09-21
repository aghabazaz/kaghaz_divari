<?php

class paymentController extends \f\controller
{

    /**
     *
     * @var paymentView
     */
    private $view ;

    public function __construct ( $params )
    {
        include_once 'paymentView.php' ;
        $this->view = new paymentView ;
        parent::__construct ( $params ) ;
    }

    public function getdebtPayFormBlock ()
    {
        //$params = $this->request->getAssocParams () ;
        return $this->renderPartial ( $this->view->renderGetDebtPayFormBlock () ) ;
    }
    public function callBackBank ()
    {
        $params = $this->request->getAssocParams () ;
        $pr     = $this->request->getNonAssocParams () ;
        //\f\pre($pr);

        $content = $this->view->renderCallBackBankDetail ( $params, $pr[ 0 ] ) ;

        return $this->render ( array (
                    'content'     => $content,
                    'websiteInfo' => $params[ 'websiteInfo' ],
                    'title'       => 'بازگشت از بانک',
                    'description' => '',
                    'type'        => $pr[ 1 ] ) ) ;
    }
    public function paymentSave ()
    {
        $params = $this->request->getAssocParams () ;

        if ( $_SESSION[ 'user_id' ] )
        {
            $params[ 'user_id' ] = $_SESSION[ 'user_id' ] ;
        }
        else
        {
            $params[ 'user_id' ] = NULL ;
        }
        $params[ 'bankid' ] = $params[ 'bankid' ] ? $params[ 'bankid' ] : 'mellat' ;
        //$res = \f\ttt::service ( 'payment.paymentSave', $params ) ;
        //\f\pre($params);

        $result = \f\ttt::service ( 'core.setting.bank.' . $params[ 'bankid' ] . '.' . $params[ 'bankid' ] . 'Pay',
                                    array (
                    'price'       => $params[ 'price' ],
                    'callbackUrl' => \f\ifm::app ()->siteUrl . 'callBackBank/' . $params[ 'bankid' ] . '/',
                    'save'        => array (
                        'pay_bank',
                        array (
                            'type'            => 'deptPay',
                            'name'            => $params[ 'name' ],
                            'booking_user_id' => $params[ 'user_id' ],
                            'date_register'   => time (),
                            'status'          => 'unpayed',
                            'price'           => $params[ 'price' ],
                            'comment'         => $params[ 'comment' ],
                        )
                    )
                ) ) ;
        //\f\pre($result);
        return $this->response ( $result ) ;
    }

}
