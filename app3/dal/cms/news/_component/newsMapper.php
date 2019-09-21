<?php

class newsMapper extends \f\dal
{

    public $sqlEngine ;
    private $dataTable ;
    private $news_tbl = 'cms_news' ;

    //private $news_people_tbl='wiki_people_cms';

    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
        $this->dataTable = \f\dalFactory::make ( 'core.dataTable' ) ;
    }

    public function newsList ()
    {
        $pr               = $this->request->getAssocParams () ;
        $requestDataTable = $pr[ 'dataTableParams' ] ;

        $ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;
        $admin   = \f\ttt::service ( 'core.auth.isAdmin' ) ;
        $userId  = \f\ttt::dal ( 'core.auth.getUserId' ) ;

        $columns = array (
            array (
                'db' => $this->news_tbl . '.id', //column name selected
                'dt' => 0, //column num
            ),
            array (
                'db' => $this->news_tbl . '.title',
                'dt' => 1,
            ),
            array (
                'db' => $this->news_tbl . '.date_register',
                'dt' => 3,
            ),
            array (
                'db' => $this->news_tbl . '.status',
                'dt' => 4,
            ),
            array (
                'db' => $this->news_tbl . '.visit',
                'dt' => 2,
            ),
                ) ;


        $whereJoin = array (
            'owner_id = ' . $ownerId,
                ) ;
        if ( $ownerId != $userId && ! $admin )
        {

            $whereJoin = array (
                'owner_id = ' . $ownerId . ' OR core_userid=' . $userId,
                    ) ;
        }



        $result = array (
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->news_tbl,
            'primaryKey'      => $this->news_tbl . '.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins          = array (),
            'whereJoin'       => $whereJoin
                ) ;

        $out = $this->dataTable->getDataTable ( $result ) ;
        return $out ;
    }

    public function newsSave ()
    {
        $params = $this->request->getAssocParams () ;





        $ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;
        $userId  = \f\ttt::dal ( 'core.auth.getUserId' ) ;

        // \f\pre($params);

        $result = $this->sqlEngine->save ( $this->news_tbl,
                                           array (
            'owner_id'       => $ownerId,
            'core_userid'    => $userId,
            'title'          => $params[ 'title' ],
            'short'          => $params[ 'short' ],
            'content'        => $params[ 'content' ],
            'picture'        => $params[ 'picture' ] ? $params[ 'picture' ] : 35,
            'date_update'    => time (),
            'user_update_id' => $userId,
            'date_register'  => time (),
                ) ) ;

        //$id = $this->sqlEngine->last_id () ;




        return $result ;
    }

    public function newsSaveEdit ()
    {
        $params = $this->request->getAssocParams () ;

        //\f\pre($params);
        //$ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;
        $userId = \f\ttt::dal ( 'core.auth.getUserId' ) ;


        $result = $this->sqlEngine->save ( $this->news_tbl,
                                           array (
            'title'   => $params[ 'title' ],
            'short'   => $params[ 'short' ],
            'content' => $params[ 'content' ],
            'picture' => $params[ 'picture' ] ? $params[ 'picture' ] : 35,
            'date_update'    => time (),
            'user_update_id' => $userId,
                ),
                                           array (
            'id=?',
            array (
                $params[ 'id' ] ) ) ) ;



        return $result ;
    }

    public function newsDelete ()
    {
        $param = $this->request->getAssocParams () ;
        $id    = $param[ 'id' ] ;
        $this->sqlEngine->remove ( $this->news_tbl,
                                   array (
            'id=?',
            array (
                $id ) ) ) ;

        return array (
            'result' => 'success',
            'func'   => 'remove' ) ;
    }

    public function newsStatus ()
    {
        $param  = $this->request->getAssocParams () ;
        $id     = $param[ 'id' ] ;
        $status = $param[ 'status' ] == 'enabled' ? 'disabled' : 'enabled' ;

        $this->sqlEngine->save ( $this->news_tbl,
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

    public function getContentById ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ( 't1.*,t4.name AS fileName,t4.path' )
                ->From ( $this->news_tbl . ' AS t1' )
                ->Join ( 'core_file AS t4' )
                ->Where ( 't1.id=?', $param[ 'id' ] )
                ->andWhere ( 't1.picture=t4.id' )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function getNewsList ()
    {
       
        $params = $this->request->getAssocParams () ;
        //\f\pre($params);
        $num   = $params[ 'num_page' ] ;
        $min   = ($params[ 'page' ] - 1) * $num ;
        $this->sqlEngine->Select ()
                ->From ( $this->news_tbl )
                ->Where ( 'status=?', $params[ 'status' ] )
                ->OrderBy ( 'id DESC' ) ;
        if ( $num )
        {
            $this->sqlEngine->Limit ( "$min,$num" ) ;
        }
        else
        {
            $this->sqlEngine->Limit ( $params[ 'limit' ] ) ;
        }
        $this->sqlEngine->Run () ;
        $newsList = $this->sqlEngine->getRows () ;

        $this->sqlEngine->Select ()
                ->From ( $this->news_tbl )
                ->Where ( 'status=?', $params[ 'status' ] )
                ->Run ();
        $number =  $this->sqlEngine->numRows () ;
        //\f\pre($number);
        return array (
            $newsList,
            $number ) ;
        
    }

    public function getNewsDetail ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ()
                ->From ( $this->news_tbl )
                ->Where ( 'status=?', $param[ 'status' ] )
                ->andWhere ( 'id=?', $param[ 'id' ] )
                ->OrderBy ( 'id DESC' )
                ->Limit ( $param[ 'limit' ] )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function setNewsVisit ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Update ( $this->news_tbl )
                ->setField ( 'visit=visit+1' )
                ->Where ( 'id=?', $param[ 'id' ] )
                ->Run () ;
    }

    public function getNews ()
    {
        //$ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;
        $param = $this->request->getAssocParams () ;
        $num   = $param[ 'numPerPage' ] ;
        $min   = ($param[ 'page' ] - 1) * $num ;

        //\f\pre($param);

        $this->sqlEngine->Select ()
                ->From ( $this->news_tbl )
                ->Where ( 'status=?', 'enabled' ) ;
        $this->sqlEngine->OrderBy ( 'id DESC' )
                ->Limit ( "$min,$num" )
                ->Run () ;
        $row = $this->sqlEngine->getRows () ;

        $this->sqlEngine->Select ( 'id' )
                ->From ( $this->news_tbl )
                ->Where ( 'status=?', 'enabled' ) ;
        $this->sqlEngine->OrderBy ( 'id DESC' )
                ->Run () ;

        $numRow = $this->sqlEngine->numRows () ;

        return array (
            $row,
            $numRow ) ;
    }
    public function setVisit ()
    {
        $params = $this->request->getAssocParams () ;
        $result=$this->sqlEngine->Update($this->news_tbl)
            ->setField('visit=visit+1')
            ->Where('id=?',$params['id'])
            ->Run();
        return $result;
    }
}
