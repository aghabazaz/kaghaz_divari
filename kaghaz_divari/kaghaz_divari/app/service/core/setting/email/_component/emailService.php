<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \chartex\core\emailCenter
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class emailService extends \f\service
{

    public function emailSettingSave ()
    {
        $param = $this->request->getAssocParams () ;

        \f\ttt::service ( 'core.setting.saveKeyGroup',
                          array (
            'keyValues' => $param,
            'params'    => array (
                'userId'      => \f\ttt::dal ( 'core.auth.getUserOwner' ),
                'componentId' => 'emailSetting' ) ) ) ;

        $data = array (
            'result'  => 'success',
            'message' => \f\ifm::t ( 'saveSettings' ) ) ;

        return $data ;
    }

     //--------------------------------------------------------------------------
    public function getEmailSetting ()
    {
        $ownerId=\f\ttt::dal ( 'core.auth.getUserOwner' );
        
        if(!$ownerId)
        {
            $ownerId = \f\ttt::dal ( 'core.auth.getOwnerFront' ) ;
        }
        
        return \f\ttt::service ( 'core.setting.getKeyGroup',
                                 array (
                    'keys' => array ( ),
                    'params' => array (
                        'userId'      => $ownerId,
                        'componentId' => 'emailSetting' ) ) ) ;
    }

    //--------------------------------------------------------------------------
    public function sendEmail ()
    {
        $params = $this->request->getAssocParams () ;

        $headers = "MIME-Version: 1.0" . "\r\n" ;
        $headers .= "Content-type:text/html;charset=utf-8" . "\r\n" ;
        $headers .= "From: <" . $params[ 'fromAddress' ] . ">" . "\r\n" ;

        mail ( $params[ 'toAddress' ], $params[ 'title' ], $params[ 'content' ],
               $headers ) ;
    }

    //--------------------------------------------------------------------------
    public function sendEmailSmtp ()
    {
        $params = $this->request->getAssocParams () ;
        require(\f\ifm::app ()->baseDir . "/ifm/lib/phpmailer/class.phpmailer.php") ;
        require(\f\ifm::app ()->baseDir . "/ifm/lib/phpmailer/class.smtp.php") ;
        require(\f\ifm::app ()->baseDir . "/ifm/lib/phpmailer/class.pop3.php") ;


        $toAddress = $params[ 'toAddress' ] ;
        $content   = $params[ 'content' ] ;
        $title     = $params[ 'title' ] ;
        $fromName  = $params[ 'fromName' ]?$params[ 'fromName' ]:'CNCKAV' ;
        $toName    = $params[ 'toName' ]?$params[ 'toName' ]:'' ;

        $setting = $this->getEmailSetting () ;
        
        //\f\pre($setting);
        //\f\pr($params);
        //Create a new PHPMailer instance
        $mail = new PHPMailer ;

        $mail->CharSet = 'UTF-8' ;
        $mail->IsSMTP();
        $mail->Host       = $setting[ 'address' ] ;
        $mail->SMTPSecure = 'tls';
        $mail->Port       = $setting[ 'port' ] ;
        $mail->SMTPDebug  = 0;
        $mail->SMTPAuth   = true;
        
        $mail->SMTPOptions = array (
            'ssl' => array (
                'verify_peer'       => false,
                'verify_peer_name'  => false,
                'allow_self_signed' => true
            )
        ) ;


        $mail->Username   = $setting[ 'email' ] ;
        $mail->Password   = $setting[ 'passWord' ] ;

        $mail->SetFrom($setting[ 'email' ], $fromName);
        $mail->AddReplyTo( $setting[ 'email' ], $fromName);
        $mail->Subject    = $title ;
        $mail->MsgHTML($this->tempEmail ( $content ));

        $mail->AddAddress($toAddress, $toName);

        


        if ( ! $mail->Send () )
        {
            return array ( FALSE, $mail->ErrorInfo ) ;
        }
        else
        {
            return true ;
        }
    }
    //--------------------------------------------------------------------------
    public function sendGroupEmailSmtp ()
    {
        $params = $this->request->getAssocParams () ;
        require(\f\ifm::app ()->baseDir . "/ifm/lib/phpmailer/class.phpmailer.php") ;
        require(\f\ifm::app ()->baseDir . "/ifm/lib/phpmailer/class.smtp.php") ;
        require(\f\ifm::app ()->baseDir . "/ifm/lib/phpmailer/class.pop3.php") ;


        $recipients = $params[ 'toAddress' ] ;
        $content   = $params[ 'content' ] ;
        $title     = $params[ 'title' ] ;
        $fromName  = $params[ 'fromName' ]?$params[ 'fromName' ]:'CNCKAV' ;
        //$toName    = $params[ 'toName' ]?$params[ 'toName' ]:'' ;

        $setting = $this->getEmailSetting () ;
        
        //Create a new PHPMailer instance
        $mail = new PHPMailer ;

        $mail->CharSet = 'UTF-8' ;
        $mail->IsSMTP();
        $mail->Host       = $setting[ 'address' ] ;
        $mail->SMTPSecure = 'tls';
        $mail->Port       = $setting[ 'port' ] ;
        $mail->SMTPDebug  = 0;
        $mail->SMTPAuth   = true;

        $mail->Username   = $setting[ 'email' ] ;
        $mail->Password   = $setting[ 'passWord' ] ;

        $mail->SetFrom($setting[ 'email' ], $fromName);
        $mail->AddReplyTo( $setting[ 'email' ], $fromName);
        $mail->Subject    = $title ;
        $mail->MsgHTML($this->tempEmail ( $content ));

        //$mail->AddAddress($toAddress, $toName);

        foreach($recipients as $email => $name)
        {
           $mail->addBCC($email, $name);
        }


        if ( ! $mail->Send () )
        {
            return array ( FALSE, $mail->ErrorInfo ) ;
        }
        else
        {
            return true ;
        }
    }

    public function tempEmail ( $content )
    {
                $body = '
            <center>
    <div style="width:600px;border:1px solid #6f6f6f;background-color:#ffffff;border-radius:5px">

        <div style="height:40px;padding:5px;background-color:#2980B9;color:#fff">				
           
            <div Style="font:bold 16px Arial;padding-top:10px;text-align:right">
               CNCKAV
            </div>
        </div>

        <div style="padding:15px 8px;text-align:right;direction:rtl;font:11px Tahoma">

            </br>
            <div>
                ' . $content . '
            </div>


        </div>


      


    </div>
</center>' ;
        
        return $body;
    }

}
