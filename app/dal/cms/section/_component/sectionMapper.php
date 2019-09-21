<?php

class sectionMapper extends \f\dal
{

    public $sqlEngine ;
    private $dataTable ;
    private $section_tbl = 'cms_category' ;

    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
        $this->dataTable = \f\dalFactory::make ( 'core.dataTable' ) ;
    }

    public function sectionList ()
    {
        $pr               = $this->request->getAssocParams () ;
        $requestDataTable = $pr[ 'dataTableParams' ] ;
        $accountId        = $pr[ 'account_id' ] ;
        $ownerId          = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;
        $admin            = \f\ttt::service ( 'core.auth.isAdmin' ) ;
        $userId           = \f\ttt::dal ( 'core.auth.getUserId' ) ;

        $columns = array (
            array (
                'db' => $this->section_tbl . '.id', //column name selected
                'dt' => 0, //column num
            ),
            array (
                'db' => $this->section_tbl . '.title',
                'dt' => 1,
            ),
            array (
                'db' => $this->section_tbl . '.date_register',
                'dt' => 2,
            ),
           
            array (
                'db' => $this->section_tbl . '.status',
                'dt' => 3,
            ),
            
          
            
                ) ;


        $whereJoin = array (
            'owner_id = ' . $ownerId,
                ) ;
        if ( $ownerId != $userId && ! $admin )
        {

            $whereJoin = array (
                'owner_id = ' . $ownerId . ' OR created_by=' . $userId,
                    ) ;
        }



        $result = array (
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->section_tbl,
            'primaryKey'      => $this->section_tbl . '.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins          = array (),
            'whereJoin'       => $whereJoin
                ) ;

        $out = $this->dataTable->getDataTable ( $result ) ;
        return $out ;
    }

    public function sectionSave ()
    {
        $params = $this->request->getAssocParams () ;

        $ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;
        $userId  = \f\ttt::dal ( 'core.auth.getUserId' ) ;
        
        //\f\pr($params);

        $result = $this->sqlEngine->save ( $this->section_tbl,
                                           array (
            'owner_id'             => $ownerId,
            'created_by'           => $userId,
            'title'                => $params[ 'title' ],                               
            'date_register'        => time (),
                ) ) ;

        return $result ;
    }

    public function sectionSaveEdit ()
    {
        $params  = $this->request->getAssocParams () ;
        $ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;
        $userId  = \f\ttt::dal ( 'core.auth.getUserId' ) ;


        $result = $this->sqlEngine->save ( $this->section_tbl,
                                           array (
              'title'                => $params[ 'title' ],
                ),
                                           array (
            'id=?',
            array (
                $params[ 'id' ] ) ) ) ;

        return $result ;
    }

    public function sectionDelete ()
    {
        $param = $this->request->getAssocParams () ;
        $id    = $param[ 'id' ] ;
        $this->sqlEngine->remove ( $this->section_tbl,
                                   array (
            'id=?',
            array (
                $id ) ) ) ;

        return array (
            'result' => 'success',
            'func'   => 'remove' ) ;
    }

    public function sectionStatus ()
    {
        $param  = $this->request->getAssocParams () ;
        $id     = $param[ 'id' ] ;
        $status = $param[ 'status' ] == 'enabled' ? 'disabled' : 'enabled' ;

        $this->sqlEngine->save ( $this->section_tbl,
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

    public function getSectionById ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ()
                ->From ( $this->section_tbl )
                ->Where ( 'id=?', $param[ 'id' ] )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function getSectionByOwnerId ()
    {
        $ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;
        if ( ! $ownerId )
        {
            $ownerId = \f\ttt::dal ( 'core.auth.getOwnerFront' ) ;
        }
        $param = $this->request->getAssocParams () ;
        
        //echo $ownerId;
        
        $this->sqlEngine->Select ()
                ->From ( $this->section_tbl )
                ->Where ( 'owner_id=?', $ownerId )
                ->andWhere ( 'status=?', 'enabled' );
                if($param['parent_id'])
                {
                    $this->sqlEngine ->andWhere ('parent_id='.$param['parent_id']);
                }
               
                $this->sqlEngine->OrderBy('title ASC')
                ->Run () ;
        return $this->sqlEngine->getRows () ;
    }
    
    public function getListSectionFront ()
    {
        $ownerId = \f\ttt::dal ( 'core.auth.getOwnerFront' ) ;
       
        
        $this->sqlEngine->Select ('title,type,id')
                ->From ( $this->section_tbl )
                ->Where ( 'owner_id=?', $ownerId )
                ->andWhere ( 'status=?', 'enabled' )
                ->andWhere ('parent_id=0')
                ->OrderBy('title ASC')
                ->Run () ;
        return $this->sqlEngine->getRows () ;
    }

}
