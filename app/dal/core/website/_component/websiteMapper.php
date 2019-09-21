<?php

/**
 * Database
 */
class websiteMapper extends \f\dal
{

    private $dataTable ;

    /**
     * 
     * @var dataTable 
     */
    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
        $this->dataTable = \f\dalFactory::make ( 'core.dataTable' ) ;

        $this->data_table                 = 'core_website' ;
        $this->data_table_user            = 'core_user' ;
        $this->data_table_user_info       = 'core_user_info' ;
        $this->data_table_user_info_legal = 'core_user_info_legal' ;
        $this->data_table_language        = 'core_lang' ;
        $this->data_table_template        = 'core_template' ;
        $this->data_table_template_lang   = 'core_default_template_lang' ;
        $this->data_table_site_template   = 'core_website_core_template' ;
        $this->data_table_site_info       = 'core_website_info' ;
        $this->data_table_site_domain     = 'core_domain' ;
    }

    public function getSiteList ()
    {
        $pr               = $this->request->getAssocParams () ;
        $requestDataTable = $pr[ 'dataTableParams' ] ; //$this->request->getParam( 'dataTableParams' ) ;


        $result = $this->showSiteList ( $requestDataTable ) ;
        $out    = $this->dataTable->getDataMultipleTable ( $result ) ;

        return $out ;
    }

    private function showSiteList ( $requestDataTable )
    {
        $arrInfo = array ( $this->realUserShowInfo (), $this->legalUserShowInfo () ) ;

        return array (
            'requestDataTble' => $requestDataTable,
            'arrInfo'         => $arrInfo,
            'searchTxt'       => $search           = '',
            'limit'           => $limit            = ''
                ) ;
    }

    private function realUserShowInfo ()
    {
        return array (
            "tablename" => $this->data_table,
            "column"    => array (
                $this->data_table => array (
                    "id"                        => "id",
                    "title"                     => "title",
                    "status"                    => "status",
                ),
                $this->data_table_user_info => array (
                    "name"  => "name",
                    "phone" => "phone",
                    "email" => "email",
                )
            ),
            "join"  => array (
                array (
                    "typeJoin"      => 'inner',
                    "table"         => $this->data_table_user_info,
                    "on"            => $this->data_table_user_info . ".core_userid = " . $this->data_table . ".core_userid",
                    "searchingJoin" => array ( 'name', 'email' )
                ) ),
            "mainWhere"   => "",
            "searchingBy" => array (
                "title"
            ),
            "searchinglevel" => array (
                "title" => 1,
                "name"  => 2,
                "email" => 3 ),
                ) ;
    }

    private function legalUserShowInfo ()
    {
        return array (
            "tablename" => $this->data_table,
            "column"    => array (
                $this->data_table => array (
                    "id"                              => "id",
                    "title"                           => "title",
                    "status"                          => "status"
                ),
                $this->data_table_user_info_legal => array (
                    "name"  => "name",
                    "phone" => "phone",
                    "email" => "email",
                )
            ),
            "join"  => array (
                array (
                    "typeJoin"      => 'inner',
                    "table"         => $this->data_table_user_info_legal,
                    "on"            => $this->data_table_user_info_legal . ".core_userid = " . $this->data_table . ".core_userid",
                    "searchingJoin" => array ( 'name', 'email' )
                ) ),
            "mainWhere"   => "",
            "searchingBy" => array (
                "title"
            ),
            "searchinglevel" => array (
                "title" => 1,
                "name"  => 2,
                "email" => 3 ),
                ) ;
    }

    public function siteRemove ()
    {

        $param = $this->request->getAssocParams () ;
        $id    = $param[ 'id' ] ;
        $this->sqlEngine->remove ( $this->data_table,
                                   array (
            'id=?',
            array (
                $id ) ) ) ;

        return array (
            'result' => 'success',
            'func'   => 'remove' ) ;
    }

    public function siteActive ()
    {
        $param  = $this->request->getAssocParams () ;
        $id     = $param[ 'id' ] ;
        $status = $param[ 'status' ] == 'enabled' ? 'disabled' : 'enabled' ;

        $this->sqlEngine->save ( $this->data_table,
                                 array (
            'status' => $status
                ),
                                 array (
            'id=?',
            array (
                $id ) ) ) ;

        return array (
            'result' => 'success',
            'status' => $status,
            'id'     => $id,
            'func'   => 'status' ) ;

       

      
    }

    public function getUserList ()
    {
        $this->sqlEngine->Select ( 't1.id,t2.name as name1,t3.name as name2' )
                ->From ( $this->data_table_user . ' as t1' )
                ->leftJoin ( $this->data_table_user_info . ' as t2' )
                ->on ( "t2.core_userid =  t1.id" )
                ->leftJoin ( $this->data_table_user_info_legal . ' as t3' )
                ->on ( "t3.core_userid = t1.id" )
                ->Where ( "t1.owner_id = t1.id" )
                ->Run () ;
        return $this->sqlEngine->getRows () ;
    }

    public function checkDomain ()
    {
        if ( $this->request->getParam ( 'websiteId' ) )
        {
            $repeatwebsiteId = $this->sqlEngine->check_unique ( array ( 'table' => $this->data_table_site_domain, 'check' => array ( 'domain'         => $this->request->getParam ( 'domain' ), 'core_websiteid' => $this->request->getParam ( 'websiteId' ) ) ) ) ;
            if ( $repeatwebsiteId == 0 )
            {
                return $this->checkSaveDomain ( $this->request->getParam ( 'domain' ) ) ;
            }
            else
            {
                return array ( 'result'  => 'success', 'message' => 'valid' ) ;
            }
        }
        else
        {
            return $this->checkSaveDomain ( $this->request->getParam ( 'domain' ) ) ;
        }
    }

    private function checkSaveDomain ()
    {
        $repeat = $this->sqlEngine->check_unique ( array ( 'table' => $this->data_table_site_domain, 'check' => array ( 'domain' => $this->request->getParam ( 'domain' ) ) ) ) ;

        if ( ! $repeat )
        {
            return array ( 'result'  => 'success', 'message' => 'valid' ) ;
        }
        else
        {
            return array ( 'result'  => 'error', 'message' => 'repeat' ) ;
        }
    }

    public function getLanguage ()
    {
        $this->sqlEngine->Select ()
                ->From ( $this->data_table_language )
                ->Where ( " status = 'enabled'" )
                ->Run () ;
        return $this->sqlEngine->getRows () ;
    }

    public function getTemplate ()
    {
        $languageId = $this->request->getParam ( 'languageId' ) ;

        $this->sqlEngine->Select ()
                ->From ( $this->data_table_template . " as t1" )
                ->innerJoin ( $this->data_table_template_lang . ' as t2' )
                ->on ( "t2.core_templateid =  t1.id" )
                ->Where ( " t2.core_langid = " . $languageId )
                ->andWhere ( " t1.status = 'enabled'" )
                ->Run () ;
        return $this->sqlEngine->getRows () ;
    }

    public function saveSite ()
    {
        if ( $this->request->getParam ( 'id' ) )
        {
            $values = $this->request->getParam ( 'values' ) ;

            return $this->sqlEngine->save ( $this->data_table, $values,
                                            array (
                        'id=?', array ( $this->request->getParam ( 'id' ) )
                    ) ) ;
        }
        else
        {
            return $this->sqlEngine->save ( $this->data_table,
                                            $this->request->getParam ( 'values' ) ) ;
        }
    }

    public function saveSiteTemplate ()
    {
        return $this->sqlEngine->save ( $this->data_table_site_template,
                                        $this->request->getParam ( 'values' ) ) ;
    }

    public function saveSiteInfo ()
    {
        return $this->sqlEngine->save ( $this->data_table_site_info,
                                        $this->request->getParam ( 'values' ) ) ;
    }

    public function saveSiteDomain ()
    {
        return $this->sqlEngine->save ( $this->data_table_site_domain,
                                        $this->request->getParam ( 'values' ) ) ;
    }

    public function deletePartInfo ()
    {

        $this->sqlEngine->remove ( $this->data_table_site_template,
                                   array ( 'core_websiteid=?', array ( $this->request->getParam ( 'id' ) ) ) ) ;

        $this->sqlEngine->remove ( $this->data_table_site_info,
                                   array ( 'core_websiteid=?', array ( $this->request->getParam ( 'id' ) ) ) ) ;

        $this->sqlEngine->remove ( $this->data_table_site_domain,
                                   array ( 'core_websiteid=?', array ( $this->request->getParam ( 'id' ) ) ) ) ;
    }

    public function getSiteInfo ()
    {
        $id = $this->request->getParam ( 'id' ) ;

        $this->sqlEngine->Select ( 'id,expire_date,core_userid,status' )
                ->From ( $this->data_table )
                ->Where ( " id = " . $id )
                ->Run () ;
        $resultMain = $this->sqlEngine->getRow () ;

        $out = array (
            'resultMain'     => $resultMain,
            'resultDomain'   => $this->getSiteInfoDomain ( $id ),
            'resultLangInfo' => $this->getSiteInfoLang ( $id ),
                ) ;

        return $out ;
    }

    private function getSiteInfoLang ( $id )
    {

        $this->sqlEngine->Select ()
                ->From ( $this->data_table_site_template . ' as t1' )
                ->innerJoin ( $this->data_table_site_info . ' as t2' )
                ->on ( "t2.core_websiteid =  t1.core_websiteid AND t2.core_langid =  t1.core_langid" )
                ->Where ( " t1.core_websiteid = " . $id )
                ->Run () ;
        $resultLangInfo = $this->sqlEngine->getRows () ;

        foreach ( $resultLangInfo as $res )
        {
            $resLangInfo[ $res[ 'core_langid' ] ] = $res ;
        }
        $out = ($resLangInfo) ? $resLangInfo : array();
        return $out ;
    }

    private function getSiteInfoDomain ( $id )
    {

        $this->sqlEngine->Select ( 'domain' )
                ->From ( $this->data_table_site_domain )
                ->Where ( " core_websiteid = " . $id )
                ->Run () ;
        $resultDomain = $this->sqlEngine->getRows () ;

        $out = ($resultDomain) ? $resultDomain : array();
        return $out ;
    }
    
    public function getSiteNameByOwnerId()
    {
        $ownerId = \f\ttt::dal('core.auth.getUserOwner') ;
        $this->sqlEngine->Select ( 'title' )
                ->From ( 'core_website' )
                ->Where ( " core_userid = " . $ownerId )
                ->Run () ;
        $result = $this->sqlEngine->getRow () ;

        $out = ($result) ? $result['title'] : NULL;
        return $out ;
    }

}