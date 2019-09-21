<?php

class webpageMapper extends \f\dal
{

    public $sqlEngine ;
    private $dataTable ;
    private $webpage_tbl        = 'core_seo_page' ;
    private $heading_tbl        = 'core_seo_page_heading' ;
    private $link_tbl           = 'core_seo_page_link' ;
    private $words_tbl          = 'core_seo_page_words' ;
    private $words_backlink_tbl = 'core_seo_page_backlink' ;

    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
        $this->dataTable = \f\dalFactory::make ( 'core.dataTable' ) ;
    }

    public function webpageList ()
    {
        $pr               = $this->request->getAssocParams () ;
        $requestDataTable = $pr[ 'dataTableParams' ] ;



        $columns = array (
            array (
                'db' => $this->webpage_tbl . '.id', //column name selected
                'dt' => 0, //column num
            ),
            array (
                'db' => $this->webpage_tbl . '.title',
                'dt' => 1,
            ),
            array (
                'db' => $this->webpage_tbl . '.link',
                'dt' => 2,
            ),
            array (
                'db' => $this->webpage_tbl . '.component_id',
                'dt' => 3,
            ),
            array (
                'db' => $this->webpage_tbl . '.item_id',
                'dt' => 4,
            ),
                ) ;


        $whereJoin = array (
            1 ) ;




        $result = array (
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->webpage_tbl,
            'primaryKey'      => $this->webpage_tbl . '.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins          = array (),
            'whereJoin'       => $whereJoin
                ) ;

        $out = $this->dataTable->getDataTable ( $result ) ;
        return $out ;
    }

    public function saveUpdateInfo ()
    {
        $params = $this->request->getAssocParams () ;



        $result = $this->sqlEngine->save ( $this->webpage_tbl,
                                           array (
            'date_update' => $params[ 'date_update' ],
            'size_page'   => $params[ 'size_page' ],
            'size_text'   => $params[ 'size_text' ],
                ),
                                           array (
            'id=?',
            array (
                $params[ 'id' ] )
                ) ) ;

        return $result ;
    }

    public function webpageDelete ()
    {
        $param = $this->request->getAssocParams () ;
        $id    = $param[ 'id' ] ;
        $this->sqlEngine->remove ( $this->webpage_tbl,
                                   array (
            'id=?',
            array (
                $id ) ) ) ;

        return array (
            'result' => 'success',
            'func'   => 'remove' ) ;
    }

    public function getWebpageById ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ()
                ->From ( $this->webpage_tbl )
                ->Where ( 'id=?', $param[ 'id' ] )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function getHeadingByPageId ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ()
                ->From ( $this->heading_tbl )
                ->Where ( 'core_seo_page_id=?', $param[ 'id' ] )
                ->OrderBy ( 'type ASC' )
                ->Run () ;
        $rows  = $this->sqlEngine->getRows () ;

        return $rows ;
    }

    public function removeHeading ()
    {
        $param = $this->request->getAssocParams () ;

        $this->sqlEngine->remove ( $this->heading_tbl,
                                   array (
            'core_seo_page_id=?',
            array (
                $param[ 'id' ] )
        ) ) ;
    }

    public function saveHeading ()
    {
        $param = $this->request->getAssocParams () ;
        //\f\pr ( $param ) ;

        $this->sqlEngine->save ( $this->heading_tbl, $param ) ;
    }

    public function removeLink ()
    {
        $param = $this->request->getAssocParams () ;

        $this->sqlEngine->remove ( $this->link_tbl,
                                   array (
            'core_seo_page_id=?',
            array (
                $param[ 'id' ] )
        ) ) ;
    }

    public function saveLink ()
    {
        $param = $this->request->getAssocParams () ;
        //\f\pr ( $param ) ;

        $this->sqlEngine->save ( $this->link_tbl, $param ) ;
    }

    public function removeWords ()
    {
        $param = $this->request->getAssocParams () ;

        $this->sqlEngine->remove ( $this->words_tbl,
                                   array (
            'core_seo_page_id=?',
            array (
                $param[ 'id' ] )
        ) ) ;
    }

    public function checkWordsInHeading ()
    {
        $param = $this->request->getAssocParams () ;

        $this->sqlEngine->Select ( 'text' )
                ->From ( $this->heading_tbl )
                ->Where ( 'core_seo_page_id=?', $param[ 'id' ] )
                ->andWhere ( 'text LIKE "%' . $param[ 'word' ] . '%"' )
                ->Run () ;

        $row = $this->sqlEngine->getRow () ;

        if ( empty ( $row ) )
        {
            return 'no' ;
        }
        else
        {
            return 'yes' ;
        }
    }

    public function saveWordsDensity ()
    {
        $param = $this->request->getAssocParams () ;
        //\f\pr ( $param ) ;

        $this->sqlEngine->save ( $this->words_tbl, $param ) ;
    }

    public function getLinkByPageId ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ()
                ->From ( $this->link_tbl )
                ->Where ( 'core_seo_page_id=?', $param[ 'id' ] )
                ->Run () ;
        $rows  = $this->sqlEngine->getRows () ;

        return $rows ;
    }

    public function getWordsByPageId ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ()
                ->From ( $this->words_tbl )
                ->Where ( 'core_seo_page_id=?', $param[ 'id' ] )
                ->Run () ;
        $rows  = $this->sqlEngine->getRows () ;

        return $rows ;
    }

    public function getBacklinkByPageId ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ()
                ->From ( $this->words_backlink_tbl )
                ->Where ( 'core_seo_page_id=?', $param[ 'id' ] )
                ->OrderBy ( 'num_visit DESC' )
                ->Run () ;
        $rows  = $this->sqlEngine->getRows () ;

        return $rows ;
    }
    

}
