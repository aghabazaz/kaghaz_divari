<?php

class contactMapper extends \f\dal
{

    public $sqlEngine ;
    private $dataTable ;
    private $contact_tbl = 'cms_contact' ;

    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
        $this->dataTable = \f\dalFactory::make ( 'core.dataTable' ) ;
    }

    public function contactList ()
    {
        $pr               = $this->request->getAssocParams () ;
        $requestDataTable = $pr[ 'dataTableParams' ] ;

        $ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;
        $admin   = \f\ttt::service ( 'core.auth.isAdmin' ) ;
        $userId  = \f\ttt::dal ( 'core.auth.getUserId' ) ;

        $columns = array (
            array (
                'db' => $this->contact_tbl . '.id', //column name selected
                'dt' => 0, //column num
            ),
            array (
                'db' => $this->contact_tbl . '.name',
                'dt' => 1,
            ),
            array (
                'db' => $this->contact_tbl . '.email',
                'dt' => 2,
            ),
            array (
                'db' => $this->contact_tbl . '.message',
                'dt' => 3,
            ),
            array (
                'db' => $this->contact_tbl . '.date_register',
                'dt' => 4,
            ),
            array (
                'db' => $this->contact_tbl . '.status',
                'dt' => 5,
            ),
                ) ;


        $whereJoin = array (
            'owner_id = ' . $ownerId,
                ) ;




        $result = array (
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->contact_tbl,
            'primaryKey'      => $this->contact_tbl . '.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins          = array (),
            'whereJoin'       => $whereJoin
                ) ;

        $out = $this->dataTable->getDataTable ( $result ) ;
        return $out ;
    }

    public function contactSave ()
    {
        $params = $this->request->getAssocParams () ;



        $ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;


        $result = $this->sqlEngine->save ( $this->contact_tbl,
                                           array (
            'owner_id'      => $ownerId ? $ownerId : 8,
            'name'          => $params[ 'name' ] ? $params[ 'name' ] : '',
            'email'         => $params[ 'email' ] ? $params[ 'email' ] : '',
            'message'       => $params[ 'message' ] ? $params[ 'message' ] : '',
            'ip'            => $_SERVER[ 'REMOTE_ADDR' ] ? $_SERVER[ 'REMOTE_ADDR' ] : 'mobile',
            'date_register' => time (),
                ) ) ;
      //  \f\pr($params);
      //  \f\pre($this->sqlEngine->last_query());
        return $result ;
    }

    public function contactDelete ()
    {
        $param = $this->request->getAssocParams () ;
        $id    = $param[ 'id' ] ;
        $this->sqlEngine->remove ( $this->contact_tbl,
                                   array (
            'id=?',
            array (
                $id ) ) ) ;

        return array (
            'result' => 'success',
            'func'   => 'remove' ) ;
    }

    public function getContactById ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ()
                ->From ( $this->contact_tbl )
                ->Where ( 'id=?', $param[ 'id' ] )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function getContentList ()
    {
        $params = $this->request->getAssocParams () ;
        //\f\pre($params);
        $num   = $params[ 'num_page' ] ;
        $min   = ($params[ 'page' ] - 1) * $num ;
        $this->sqlEngine->Select ()
            ->From ( $this->cms_contact )
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
        //\f\pre($this->sqlEngine->getRows ());
        $newsList = $this->sqlEngine->getRows () ;
        return $newsList ;
    }
}
