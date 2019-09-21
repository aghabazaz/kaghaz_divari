<?php

class advertisementMapper extends \f\dal
{

    public  $sqlEngine;
    private $dataTable;
    private $advertisement_tbl = 'cms_advertise';
    private $request_tbl       = 'cms_advertise_request';

    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine;
        $this->dataTable = \f\dalFactory::make( 'core.dataTable' );
    }

    public function advertisementList ()
    {
        $pr               = $this->request->getAssocParams();
        $requestDataTable = $pr['dataTableParams'];
        $ownerId          = \f\ttt::dal( 'core.auth.getUserOwner' );
        $admin            = \f\ttt::service( 'core.auth.isAdmin' );
        $userId           = \f\ttt::dal( 'core.auth.getUserId' );

        $columns = [
            [
                'db' => $this->advertisement_tbl . '.id', //column name selected
                'dt' => 0, //column num
            ],
            [
                'db' => $this->advertisement_tbl . '.name',
                'dt' => 1,
            ],
            [
                'db' => $this->advertisement_tbl . '.email',
                'dt' => 2,
            ],
            [
                'db' => $this->advertisement_tbl . '.phone',
                'dt' => 3,
            ],
            [
                'db' => $this->advertisement_tbl . '.date_credit',
                'dt' => 4,
            ],
            [
                'db' => $this->advertisement_tbl . '.status',
                'dt' => 5,
            ],
            [
                'db' => $this->advertisement_tbl . '.plan',
                'dt' => 6,
            ],
        ];


        $whereJoin = [
            'owner_id = ' . $ownerId,
        ];


        $result = [
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->advertisement_tbl,
            'primaryKey'      => $this->advertisement_tbl . '.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins = [],
            'whereJoin'       => $whereJoin
        ];

        $out = $this->dataTable->getDataTable( $result );
        return $out;
    }

    public function advertisementSave ()
    {
        $params = $this->request->getAssocParams();


        $ownerId = \f\ttt::dal( 'core.auth.getUserOwner' );

        $params['owner_id'] = $ownerId;

        //\f\pr($params);


        $result = $this->sqlEngine->save( $this->advertisement_tbl,$params );

        return $result;
    }

    public function advertisementSaveEdit ()
    {
        $params = $this->request->getAssocParams();
        $result = $this->sqlEngine->save( $this->advertisement_tbl,$params,
            [
                'id=?',
                [
                    $params['id'] ] ] );

        return $result;
    }

    public function advertisementDelete ()
    {
        $param = $this->request->getAssocParams();
        $id    = $param['id'];
        $this->sqlEngine->remove( $this->advertisement_tbl,
            [
                'id=?',
                [
                    $id ] ] );

        return [
            'result' => 'success',
            'func'   => 'remove' ];
    }

    public function advertisementStatus ()
    {
        $param  = $this->request->getAssocParams();
        $id     = $param['id'];
        $status = $param['status'] == 'enabled' ? 'disabled' : 'enabled';

        $this->sqlEngine->save( $this->advertisement_tbl,
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

    public function getAdvertisementById ()
    {
        $param = $this->request->getAssocParams();
        $this->sqlEngine->Select()
            ->From( $this->advertisement_tbl )
            ->Where( 'id=?',$param['id'] )
            ->Run();
        return $this->sqlEngine->getRow();
    }

    public function requestSave ()
    {
        $params = $this->request->getAssocParams();

        //\f\pr($params);
        //$ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;


        $result = $this->sqlEngine->save( 'cms_advertise_request',
            [
                'name'          => $params['name'] ? $params['name'] : '',
                'email'         => $params['email'] ? $params['email'] : '',
                'phone'         => $params['phone'] ? $params['phone'] : '',
                'plan'          => $params['plan'],
                'date_register' => time(),
            ] );

        return $result;
    }

    public function requestList ()
    {
        $pr               = $this->request->getAssocParams();
        $requestDataTable = $pr['dataTableParams'];

        //\f\pr('ok');

        $columns = [
            [
                'db' => $this->request_tbl . '.id', //column name selected
                'dt' => 0, //column num
            ],
            [
                'db' => $this->request_tbl . '.name',
                'dt' => 1,
            ],
            [
                'db' => $this->request_tbl . '.email',
                'dt' => 2,
            ],
            [
                'db' => $this->request_tbl . '.phone',
                'dt' => 3,
            ],
            [
                'db' => $this->request_tbl . '.plan',
                'dt' => 4,
            ],
            [
                'db' => $this->request_tbl . '.date_register',
                'dt' => 5,
            ],
        ];

        $ownerId   = \f\ttt::dal( 'core.auth.getUserOwner' );
        $whereJoin = [
            '1',
        ];


        $result = [
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->request_tbl,
            'primaryKey'      => $this->request_tbl . '.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins = [],
            'whereJoin'       => $whereJoin
        ];


        $out = $this->dataTable->getDataTable( $result );

        return $out;
    }

    public function requestDelete ()
    {
        $param = $this->request->getAssocParams();
        $id    = $param['id'];
        $this->sqlEngine->remove( $this->request_tbl,
            [
                'id=?',
                [
                    $id ] ] );

        return [
            'result' => 'success',
            'func'   => 'remove' ];
    }

    public function getListAdvertiseByPlan ()
    {
        $param = $this->request->getAssocParams();
        //\f\pre($param);
        $this->sqlEngine->Select( 't1.link,t2.name,t2.mime_type,t1.plan' )
            ->From( $this->advertisement_tbl . ' AS t1' )
            ->Join( 'core_file AS t2' )
            ->Where( 't1.plan=?',$param['plan'] )
            ->andWhere( 't1.status=?','enabled' )
            ->andWhere( 't1.picture=t2.id' )
            ->andWhere( 't1.date_credit>=?',$param['date'] );
        if ( $param['section'] )
        {
            $this->sqlEngine->andWhere( 't1.section=?',$param['section'] );
        }
        if ( $param['location'] )
        {
            $this->sqlEngine->OrderBy( 't1.id ASC' );
        } else
        {
            $this->sqlEngine->OrderBy( 'rand()' );
        }
        $this->sqlEngine->Limit( $param['limit'] )
            ->Run();
        return $this->sqlEngine->getRows();
    }

    public function getListAdvertise ()
    {
        $param = $this->request->getAssocParams();
        //\f\pr($param);
        $this->sqlEngine->Select( ' t1.picture,t1.name,t1.link' )
            ->From( $this->advertisement_tbl . ' AS t1' )
            ->where( 't1.plan=?',$param['plan'] );
        $this->sqlEngine->Limit( 5 );
        $this->sqlEngine->Run();
        //\f\pre($this->sqlEngine->getRows());
        return $this->sqlEngine->getRows();
    }

    public function getListSocialAdvertise ()
    {
        $param = $this->request->getAssocParams();
      //  \f\pr($param);
        $this->sqlEngine->Select( ' t1.picture,t1.name,t1.plan,t1.link' )
            ->From( $this->advertisement_tbl . ' AS t1' );
        if ( $param['plan2']=='topAdver' )
        {
            $this->sqlEngine->where( 't1.plan=?',$param['plan'] )
                ->andWhere( 't1.date_credit>=?',$param['today'] );
        }elseif ($param['plan2']=='sideAdver'){
            $this->sqlEngine->where( 't1.plan=?',$param['plan'] )
                ->andWhere( 't1.date_credit>=?',$param['today'] )
                ->Limit(1);
        } elseif ( $param['MainPlan'] )
        {
            $this->sqlEngine->where( 't1.plan=?',$param['plan'] )
                            ->andWhere( 't1.date_credit>=?',$param['today'] )
                            ->Limit( 2 );
        }else
        {
            $this->sqlEngine->where( 't1.plan=?',$param['plan'] )
                            ->andWhere( 't1.date_credit>=?',$param['today'] )
                            ->Limit( 2 );
        }
        $this->sqlEngine->Run();
//        //\f\pre( $this->sqlEngine->last_query() );
        return $this->sqlEngine->getRows();
    }

}
