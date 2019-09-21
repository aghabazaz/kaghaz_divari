<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \newsletter
 * @items component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class newsletterService extends \f\service
{

    /**
     *
     * @var shortcutMapper 
     */
    private $mapper ;

    public function __construct ()
    {
        $this->mapper = \f\dalFactory::make ( 'newsletter' ) ;
    }

    public function nlMemberList ()
    {

        return \f\ttt::dal ( 'newsletter.nlMemberList',
                             $this->request->getAssocParams () ) ;
    }

    public function newsletterSave ()
    {
        $params     = $this->request->getAssocParams () ;
        $checkIsset = \f\ttt::dal ( 'newsletter.checkIssetEmailMobile', $params ) ;
        if ( ! empty ( $checkIsset ) )
        {
            return array (
                'result'  => 'error',
                'message' => \f\ifm::t ( 'repeatInputEmailOrMobile' ) ) ;
                $reset  = TRUE ;
        }
        if ( empty ( $checkIsset ) )
        {
            //\f\pre ( $params ) ;
            $result = \f\ttt::dal ( 'newsletter.newsletterSave', $params ) ;
            $msg    = \f\ifm::t ( 'newsletterSave' ) ;
            $reset  = TRUE ;
        }
        else if ( $params[ 'id' ] )
        {
            //in  backend for edit admin
            $result = \f\ttt::dal ( 'newsletter.newsletterSaveEdit', $params ) ;
            $msg    = \f\ifm::t ( 'newsletterSaveEdit' );
            $reset  = TRUE  ;
        }
        else
        {
            //if disable mob or email and enter that then enable
            $params[ 'old_info' ] = $checkIsset ;
            $result               = \f\ttt::dal ( 'newsletter.enableNewsletter',
                                                  $params ) ;
            $msg                  = \f\ifm::t ( 'newsletterSave' ) ;
            $reset                = TRUE ;
        }
//        }


        if ( $result )
        {
            $data = array (
                'result'  => 'success',
                'message' => $msg,
                'reset'   => $reset ) ;
        }
        else
        {
            $data = array (
                'result'  => 'error',
                'message' => $msgErr,
                'reset'   => $reset ) ;
        }
        return $data ;
    }

    public function nlMemberDelete ()
    {
        return \f\ttt::dal ( 'newsletter.nlMemberDelete',
                             $this->request->getAssocParams () ) ;
    }

    public function nlMemberStatus ()
    {
        return \f\ttt::dal ( 'newsletter.nlMemberStatus',
                             $this->request->getAssocParams () ) ;
    }

    public function getNlMemberById ()
    {
        return \f\ttt::dal ( 'newsletter.getNlMemberById',
                             $this->request->getAssocParams () ) ;
    }

    public function getCatNlMemberById ()
    {
        return \f\ttt::dal ( 'newsletter.getCatNlMemberById',
                             $this->request->getAssocParams () ) ;
    }

    public function getEmailsMobiles ()
    {

        $params             = $this->request->getAssocParams () ;
        $result_emails_mobs = \f\ttt::dal ( 'newsletter.getEmailsMobiles',
                                            $params ) ;
        \f\pre($params);
        //\f\pre ( $result_emails_mobs ) ;
        $result_template    = \f\ttt::service ( 'newsletter.templateSend.getTemplateLast',
                                                $params ) ;
        //\f\pre ( $result_template ) ;
        unset ( $params[ 'template_cat' ] ) ;
        $text               = $result_template[ 'template' ] ;
        foreach ( $params AS $key => $val )
        {
            $text = str_replace ( "#$key#", $val, $text ) ;
        }

        foreach ( $result_emails_mobs as $data )
        {
            $arrEmails [ $data[ 'email' ] ] = $data[ 'name' ] ;
            $arrMobile []                   = $data[ 'mobile' ] ;
            $arrMobileTxt []                = $text ;
        }

        if ( $params[ 'type' ] == 'email' )
        {
            //\f\pre($params);
            $title                  = 'محصول جدید در RAYSANCO:' . $params[ 'title' ] ;
            $result [ 'toAddress' ] = $arrEmails ;
            $result [ 'content' ]   = $text ;
            $result [ 'title' ]     = $title ;
            $result [ 'fromName' ]  = 'RaysanCo.com' ;
            \f\ttt::service ( 'core.setting.email.sendGroupEmailSmtp', $result ) ;
        }
        if ( $params [ 'type' ] == 'mobile' )
        {
            $result [ 'receiver' ] = $arrMobile ;
            $result [ 'txt' ]      = $arrMobileTxt ;
            //\f\pre($result);
            \f\ttt::service ( 'core.setting.sms.sendGroupSms', $result ) ;
        }
    }

}
