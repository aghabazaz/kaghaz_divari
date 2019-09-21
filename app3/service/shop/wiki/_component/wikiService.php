<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \shop\wiki
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class wikiService extends \f\service
{

    /**
     *
     * @var shortcutMapper 
     */
    private $mapper ;

    public function __construct ()
    {
        $this->mapper = \f\dalFactory::make ( 'shop.wiki' ) ;
    }

    public function wikiList ()
    {
        return \f\ttt::dal ( 'shop.wiki.wikiList',
                             $this->request->getAssocParams () ) ;
    }

    public function wikiSave ()
    {
        $params = $this->request->getAssocParams () ;
        if ( $params[ 'id' ] )
        {
            $result = \f\ttt::dal ( 'shop.wiki.wikiSaveEdit', $params ) ;
            $msg    = \f\ifm::t ( 'wikiSaveEdit' ) ;
            $reset  = FALSE ;
        }
        else
        {
            $result = \f\ttt::dal ( 'shop.wiki.wikiSave', $params ) ;
            $msg    = \f\ifm::t ( 'wikiSave' ) ;
            $reset  = TRUE ;
        }

        if ( $result )
        {
            $data = array ( 'result'  => 'success', 'message' => $msg, 'reset'   => $reset ) ;
        }
        else
        {
            $data = array ( 'result'  => 'error', 'message' => \f\ifm::t ( 'dbError' ) ) ;
        }

        return $data ;
    }

    public function wikiDelete ()
    {
        return \f\ttt::dal ( 'shop.wiki.wikiDelete',
                             $this->request->getAssocParams () ) ;
    }

    public function wikiStatus ()
    {
        return \f\ttt::dal ( 'shop.wiki.wikiStatus',
                             $this->request->getAssocParams () ) ;
    }

    public function getWikiById ()
    {
        return \f\ttt::dal ( 'shop.wiki.getWikiById',
                             $this->request->getAssocParams () ) ;
    }
    public function getWikiByOwnerId ()
    {
        return \f\ttt::dal ( 'shop.wiki.getWikiByOwnerId',
                             $this->request->getAssocParams () ) ;
    }

}