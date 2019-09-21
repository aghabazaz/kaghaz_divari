<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \core\seo
 * @category component
 * @author Mojtaba Rajabzadeh <mjr.rajabzadeh@gmail.com>
 */
class seoService extends \f\service
{

    public function saveParameter ()
    {
        $params = $this->request->getAssocParams () ;

        if ( ! $params[ 'id' ] )
        {
            $row = \f\ttt::dal ( 'core.seo.getPageInfo', $params ) ;
            if ( $row[ 'id' ] )
            {
                $params[ 'id' ] = $row[ 'id' ] ;
            }
        }

        if ( $params[ 'id' ] )
        {
            $result = \f\ttt::dal ( 'core.seo.saveParameterEdit', $params ) ;
            $msg    = \f\ifm::t ( 'saveParameterEdit' ) ;
            $reset  = FALSE ;
        }
        else
        {
            $result = \f\ttt::dal ( 'core.seo.saveParameter', $params ) ;
            $msg    = \f\ifm::t ( 'saveParameter' ) ;
            $reset  = FALSE ;
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

    public function getPageInfo ()
    {
        $params               = $this->request->getAssocParams () ;
        $row                  = \f\ttt::dal ( 'core.seo.getPageInfo', $params ) ;
        $params[ 'link' ]       = $_SERVER[ 'REQUEST_URI' ] ;
        $params[ 'id' ]         = $row[ 'id' ] ;
        $params[ 'num_visit' ]  = $row[ 'num_visit' ] + 1 ;
        $params[ 'last_visit' ] = time () ;
        //\f\pre($params);
        if ( ! $row[ 'id' ] )
        {
            \f\ttt::dal ( 'core.seo.saveParameter', $params ) ;
        }
        else
        {
            \f\ttt::dal ( 'core.seo.saveParameterEdit', $params ) ;
        }
        if ( isset ( $_SERVER[ 'HTTP_REFERER' ] ) )
        {
            preg_match ( '#^(?:http://|https://)?([^/]+)#i',
                         $_SERVER[ 'HTTP_REFERER' ], $siteName ) ;
            $backlinkDomain = str_replace ( 'www.', '', $siteName[ 1 ] ) ;
            $backlinkDomainArr = explode ( '.', $backlinkDomain ) ;
            
            $backLinkInfo=\f\ttt::dal('core.seo.getBacklinkInfo',array(
                'core_seo_page_id'=>$row['id'],
                'link'=>$_SERVER[ 'HTTP_REFERER' ]
            ));
            $backLinkParams=array(
                'core_seo_page_id'=>$row['id'],
                'domain'=>$backlinkDomain,
                'name'=>$backlinkDomainArr[0],
                'link'=>$_SERVER[ 'HTTP_REFERER' ],
                'last_visit'=> time (),
                'num_visit'=>$row['num_visit']+1
            );
            
            if($backLinkInfo['id'])
            {
                \f\ttt::dal('core.seo.saveEditBacklinkInfo',$backLinkParams);
            }
            else
            {
                \f\ttt::dal('core.seo.saveBacklinkInfo',$backLinkParams);
            }
            
            

                
        }

        return $row ;
    }

}
