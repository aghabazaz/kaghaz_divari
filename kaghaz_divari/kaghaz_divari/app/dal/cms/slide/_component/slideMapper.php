<?php

class slideMapper extends \f\dal
{

    public $sqlEngine ;
    private $dataTable ;
    private $slide_tbl = 'cms_slide' ;

    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
        $this->dataTable = \f\dalFactory::make ( 'core.dataTable' ) ;
    }

    public function slideList ()
    {
        $pr               = $this->request->getAssocParams () ;
        $requestDataTable = $pr[ 'dataTableParams' ] ;



        $columns = array (
            array (
                'db' => $this->slide_tbl . '.id', //column name selected
                'dt' => 0, //column num
            ),
            array (
                'db' =>$this->slide_tbl . '.title',
                'dt' => 1,
            ),
            array (
                'db' => $this->slide_tbl . '.status',
                'dt' => 3,
            ),
                ) ;

        $ownerId   = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;
        $whereJoin = array (
            'owner_id=' . $ownerId ) ;




        $result = array (
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->slide_tbl,
            'primaryKey'      => $this->slide_tbl . '.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins          = array (),
            'whereJoin'       => $whereJoin
                ) ;

        $out = $this->dataTable->getDataTable ( $result ) ;
        return $out ;
    }

    public function slideSave ()
    {
        $params = $this->request->getAssocParams () ;

        $ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;

        $result = $this->sqlEngine->save ( $this->slide_tbl,
                                           array (
           // 'top_title'   => $params[ 'top_title' ],
            'title'       => $params[ 'title' ],
           // 'icon'        => $params[ 'icon' ],
           // 'comment'     => $params[ 'comment' ],
           // 'link'        => $params[ 'link' ],
           // 'color'       => $params[ 'color' ],
            'picture'     => $params[ 'picture' ],
           // 'picture_url' => $params[ 'picture_url' ],
            'owner_id'    => $ownerId
                ) ) ;

        return $result ;
    }

    public function slideSaveEdit ()
    {
        $params = $this->request->getAssocParams () ;

        $result = $this->sqlEngine->save ( $this->slide_tbl,
                                           array (
            'top_title'   => $params[ 'top_title' ],
            'title'       => $params[ 'title' ],
            'comment'     => $params[ 'comment' ],
            'icon'        => $params[ 'icon' ],
            'link'        => $params[ 'link' ],
            'color'       => $params[ 'color' ],
            'picture'     => $params[ 'picture' ],
            'picture_url' => $params[ 'picture_url' ]
                ),
                                           array (
            'id=?',
            array (
                $params[ 'id' ] ) ) ) ;

        return $result ;
    }

    public function slideDelete ()
    {
        $param = $this->request->getAssocParams () ;
        $id    = $param[ 'id' ] ;
        $this->sqlEngine->remove ( $this->slide_tbl,
                                   array (
            'id=?',
            array (
                $id ) ) ) ;

        return array (
            'result' => 'success',
            'func'   => 'remove' ) ;
    }

    public function slideStatus ()
    {
        $param  = $this->request->getAssocParams () ;
        $id     = $param[ 'id' ] ;
        $status = $param[ 'status' ] == 'enabled' ? 'disabled' : 'enabled' ;

        $this->sqlEngine->save ( $this->slide_tbl,
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

    public function getSlideById ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ()
                ->From ( $this->slide_tbl )
                ->Where ( 'id=?', $param[ 'id' ] )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function getSlideList ()
    {
        $param = $this->request->getAssocParams () ;
//        \f\pr($param);
        $this->sqlEngine->Select ()
                ->From ( $this->slide_tbl ) ;
        if ( $param[ 'status' ] )
        {
            $this->sqlEngine->Where ( 'status=?', 'enabled' ) ;
        }
        $this->sqlEngine->Limit ( 7 ) ;
        $this->sqlEngine->Run () ;
        //\f\pre($this->sqlEngine->getRows());
        return $this->sqlEngine->getRows () ;
    }

}
