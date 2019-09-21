<?php

class makerMapper extends \f\dal
{

    public  $sqlEngine;
    private $dataTable;
    private $maker_tbl = 'shop_maker';

    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine;
        $this->dataTable = \f\dalFactory::make( 'core.dataTable' );
    }

    public function makerList ()
    {
        $pr               = $this->request->getAssocParams();
        $requestDataTable = $pr['dataTableParams'];
        $ownerId          = \f\ttt::service( 'core.auth.getUserOwner' );

        $columns   = [
            [
                'db' => 't1.id', //column name selected
                'dt' => 0, //column num
            ],
            [
                'db' => 't1.title_fa',
                'dt' => 1,
            ],
            [
                'db' => 't1.title_en',
                'dt' => 2,
            ],
            [
                'db' => 't1.logo',
                'dt' => 3,
            ],
            [
                'db' => 't1.owner_id',
                'dt' => 4,
            ],
            [
                'db' => 't1.status',
                'dt' => 5,
            ],
        ];
        $whereJoin = [
            "t1.owner_id=" . $ownerId ];

        $result = [
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->maker_tbl . ' AS t1',
            'primaryKey'      => 't1.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins = [],
            'whereJoin'       => $whereJoin
        ];
        $out    = $this->dataTable->getDataTable( $result );
        return $out;
    }

    public function makerSave ()
    {
        $params             = $this->request->getAssocParams();
        $params['owner_id'] = \f\ttt::dal( 'core.auth.getUserOwner' );
        $params['status']   = 'enabled';
        unset ( $params['id'] );
        $result = $this->sqlEngine->save( $this->maker_tbl,
            $params
        );
        return $result;
    }

    public function makerSaveEdit ()
    {
        $params = $this->request->getAssocParams();
        $id     = $params['id'];
        unset ( $params['id'] );
        $result = $this->sqlEngine->save( $this->maker_tbl,
            $params
            ,
            [
                'id=?',
                [
                    $id ] ] );
        return $result;
    }

    public function makerDelete ()
    {
        $param = $this->request->getAssocParams();
        $id    = $param['id'];
        $this->sqlEngine->remove( $this->maker_tbl,
            [
                'id=?',
                [
                    $id ] ] );

        return [
            'result' => 'success',
            'func'   => 'remove' ];
    }

    public function makerStatus ()
    {
        $param  = $this->request->getAssocParams();
        $id     = $param['id'];
        $status = $param['status'] == 'enabled' ? 'disabled' : 'enabled';

        $this->sqlEngine->save( $this->maker_tbl,
            [
                'status' => $status
            ],
            [
                'id=?',
                [
                    $id ] ] );

        return [
            'result' => 'success',
            'status' => $status,
            'id'     => $id,
            'func'   => 'status' ];
    }

    public function getMakerById ()
    {
        $param = $this->request->getAssocParams();
        $this->sqlEngine->Select()
            ->From( $this->maker_tbl . ' AS t1' )
            ->Where( 't1.id=?',$param['id'] );
        if ( $param['status'] )
        {
            $this->sqlEngine->andWhere( 't1.status=?',$param['status'] );
        }
        $this->sqlEngine->Run();
        return $this->sqlEngine->getRow();
    }

    public function getMakerListFront ()
    {
        $param = $this->request->getAssocParams();
        $this->sqlEngine->Select()
            ->From( $this->maker_tbl . ' AS t1' )
            ->Where( 't1.status=?',$param['special'] )
            ->OrderBy( 'id DESC' )
            ->Limit( $param['limit'] )
            ->Run();
        return $this->sqlEngine->getRows();
    }

    public function getMakerByOwnerId ()
    {
        $ownerId = \f\ttt::dal( 'core.auth.getUserOwner' );

        if ( !$ownerId )
        {
            $ownerId = \f\ttt::dal( 'core.auth.getOwnerFront' );
        }

        $this->sqlEngine->Select()
            ->From( $this->maker_tbl . ' AS t1' )
            ->Where( 't1.owner_id=?',$ownerId )
            ->andWhere( 'status=?','enabled' )
            ->OrderBy( 'title_fa ASC' )
            ->Run();
        return $this->sqlEngine->getRows();
    }

    public function getMakersByAjaxSearch ()
    {
        $param = $this->request->getAssocParams();
        $this->sqlEngine->Select( 'id,title_fa,title_en,logo' )
            ->From( $this->maker_tbl )
            ->Where( 'status=?','enabled' )
            ->andWhere( "title_fa LIKE '%" . $param['keyword'] . "%'" )
            ->orWhere( "title_en LIKE '%" . $param['keyword'] . "%'" );
        $this->sqlEngine->OrderBy( 'id DESC' );
        if ( $param['limit'] )
        {
            $this->sqlEngine->Limit( $param['limit'] );
        }
        $this->sqlEngine->Run();
        return $this->sqlEngine->getRows();
    }

    public function getMakerByParam ()
    {
        $param = $this->request->getAssocParams();
        if ( $param['selects'] )
        {
            $select = $param['selects'];
        } else
        {
            $select = '*';
        }
        $this->sqlEngine->Select( $select )
            ->From( $this->maker_tbl . ' AS t1' )
            ->Where( 1 );
        if ( $param['title_en'] )
        {
            $this->sqlEngine->andWhere( 't1.title_en=?',$param['title_en'] );
        }
        if ( $param['id'] )
        {
            $this->sqlEngine->andWhere( 't1.id=?',$param['id'] );
        }
        $this->sqlEngine->Run();
        return $this->sqlEngine->getRow();
    }

}
