<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \newsletter.templateSend\
 * @temp component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class templateSendService extends \f\service
{

    /**
     *
     * @var shortcutMapper 
     */
    private $mapper ;

    public function __construct ()
    {
        $this->mapper = \f\dalFactory::make ( 'newsletter.templateSend' ) ;
    }

    public function tempList ()
    {
        //\f\pre($this->request->getAssocParams ());
        return \f\ttt::dal ( 'newsletter.templateSend.tempList',
                             $this->request->getAssocParams () ) ;
    }

    public function tempSave ()
    {
        $params = $this->request->getAssocParams () ;

        if ( $params[ 'id' ] )
        {
            $result = \f\ttt::dal ( 'newsletter.templateSend.tempSaveEdit',
                                    $params ) ;
            $msg    = \f\ifm::t ( 'tempSaveEdit' ) ;
            $reset  = FALSE ;
        }
        else
        {
            $result = \f\ttt::dal ( 'newsletter.templateSend.tempSave', $params ) ;
            $msg    = \f\ifm::t ( 'tempSave' ) ;
            $reset  = TRUE ;
        }

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
                'message' => \f\ifm::t ( 'dbError' ) ) ;
        }


        return $data ;
    }

    public function tempDelete ()
    {
        return \f\ttt::dal ( 'newsletter.templateSend.tempDelete',
                             $this->request->getAssocParams () ) ;
    }

    public function tempStatus ()
    {
        return \f\ttt::dal ( 'newsletter.templateSend.tempStatus',
                             $this->request->getAssocParams () ) ;
    }

    public function getTempById ()
    {
        return \f\ttt::dal ( 'newsletter.templateSend.getTempById',
                             $this->request->getAssocParams () ) ;
    }

    public function getTempByOwnerId ()
    {
        return \f\ttt::dal ( 'newsletter.templateSend.getTempByOwnerId',
                             $this->request->getAssocParams () ) ;
    }

    public function getTempByParam ()
    {
        return \f\ttt::dal ( 'newsletter.templateSend.getTempByParam',
                             $this->request->getAssocParams () ) ;
    }

    public function getCategoryAll ()
    {
        return \f\ttt::dal ( 'newsletter.templateSend.getCategoryAll' ) ;
    }

    public function getTemplateLast ()
    {
        return \f\ttt::dal ( 'newsletter.templateSend.getTemplateLast',
                             $this->request->getAssocParams () ) ;
    }

}
