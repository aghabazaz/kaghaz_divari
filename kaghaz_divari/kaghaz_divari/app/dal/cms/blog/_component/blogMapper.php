<?php

class blogMapper extends \f\dal
{

    public $sqlEngine ;
    private $dataTable ;
    private $blog_tbl = 'booking_blog' ;

    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
        $this->dataTable = \f\dalFactory::make ( 'core.dataTable' ) ;
    }

    public function getAccountById ()
    {

        $param = $this->request->getAssocParams () ;

        if ( $param[ 'type' ] == 'doctor' )
        {
            $this->sqlEngine->Select ( 't2.name AS accountName,t2.picture AS accountPic,t3.title AS accountspecial' )
                    ->From ( 'booking_doctor AS t2' )
                    ->leftJoin ('booking_doctor_speciality AS t3')
                    ->On ( 't2.speciality=t3.id')
                    ->Where ( 't2.id=?', $param[ 'id' ] )
                    ->Run () ;
        }
        if ( $param[ 'type' ] == 'hall' )
        {
            $this->sqlEngine->Select ( 't2.name AS accountName,t2.picture AS accountPic,t2.manager AS accountspecial' )
                    ->From ( 'booking_hall AS t2' )
                    ->Where ( 't2.id=?', $param[ 'id' ] )
                    ->Run () ;
        }

        return $this->sqlEngine->getRow () ;
    }

    public function getBlogById ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ( '*' )
                ->From ( $this->blog_tbl )
                ->Where ( 'id=?', $param[ 'id' ] )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function blogList ()
    {
        $pr               = $this->request->getAssocParams () ;
        $requestDataTable = $pr[ 'dataTableParams' ] ;
        $user_id          = $pr[ 'user_id' ] ;
        
        //\f\pre($pr);

        $columns = array (
            array (
                'db' => 't1.id', //column name selected
                'dt' => 0, //column num
            ),
            array (
                'db' => 't1.title',
                'dt' => 1,
            ),
            array (
                'db' => 't1.content',
                'dt' => 2,
            ),
            array (
                'db' => 't1.picture',
                'dt' => 3,
            ),
            array (
                'db' => 't1.date_register',
                'dt' => 4,
            ),
            array (
                'db' => 't1.account_id',
                'dt' => 5,
            ),
            array (
                'db' => 't1.booking_user_id',
                'dt' => 6,
            ),
            array (
                'db' => 't1.type',
                'dt' => 7,
            ),
            array (
                'db' => 't1.status',
                'dt' => 8,
            ),
                ) ;

        if ( $user_id )
        {
            $whereJoin = array ( 't1.booking_user_id=' . $user_id." AND type='".$pr['type']."' AND account_id=".$pr['accountId'] ) ;
        }
        else
        {
            $whereJoin = array ( 't1.id>0' ) ;
        }

        $result = array (
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->blog_tbl . ' AS t1',
            'primaryKey'      => 't1.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins          = array ( ),
            'whereJoin' => $whereJoin,
            'joinType'  => '',
            'onJoin'    => ''
                ) ;

        $out = $this->dataTable->getDataTable ( $result ) ;
        return $out ;
    }

    public function blogDelete ()
    {

        $param = $this->request->getAssocParams () ;
        $id    = $param[ 'id' ] ;
        $this->sqlEngine->remove ( $this->blog_tbl,
                                   array (
            'id=?',
            array (
                $id ) ) ) ;

        return array (
            'result' => 'success',
            'func'   => 'remove' ) ;
    }

    public function blogStatus ()
    {
        $param  = $this->request->getAssocParams () ;
        $id     = $param[ 'id' ] ;
        $status = $param[ 'status' ] == 'enabled' ? 'disabled' : 'enabled' ;
        $this->sqlEngine->save ( $this->blog_tbl,
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

    public function blogSave ()
    {
        $params = $this->request->getAssocParams () ;

        //\f\pre($params);
        $params[ 'date_register' ] = time () ;
        $params[ 'status' ]        = 'enabled' ;
        unset ( $params[ 'id' ] ) ;
        $result                    = $this->sqlEngine->save ( $this->blog_tbl,
                                                              $params
                ) ;
        $id                        = $this->sqlEngine->last_id () ;
        return $result ;
    }

    public function blogSaveEdit ()
    {
        $params = $this->request->getAssocParams () ;
        
        //\f\pre($params);
        $id     = $params[ 'id' ] ;
        unset ( $params[ 'id' ] ) ;
        $result = $this->sqlEngine->save ( $this->blog_tbl, $params,
                                           array (
            'id=?',
            array (
                $id ) ) ) ;
        return $result ;
    }
    public function getListBlog ()
    {
        $param = $this->request->getAssocParams () ;
        //\f\pre($param);
        $this->sqlEngine->Select ( 't1.*' )
                ->From ( 'booking_blog AS t1' ) ;
        if ( $param[ 'status' ] )
        {
            $this->sqlEngine->Where ( 't1.status=?', $param[ 'status' ] ) ;
            $flag = TRUE ;
        }
        if ( $param[ 'account_id' ] )
        {
            if ( $flag )
            {

                $this->sqlEngine->andWhere ( 't1.account_id=?',
                                             $param[ 'account_id' ] ) ;
            }
            else
            {
                $this->sqlEngine->Where ( 't1.acount_id=?',
                                          $param[ 'account_id' ] ) ;
            }
            $flag = TRUE ;
        }
        if ( $param[ 'type' ] )
        {
            if ( $flag )
            {

                $this->sqlEngine->andWhere ( 't1.type=?', $param[ 'type' ] ) ;
            }
            else
            {
                $this->sqlEngine->Where ( 't1.type=?', $param[ 'type' ] ) ;
            }
            $flag = TRUE ;
        }
        if ( $param[ 'user_id' ] )
        {
            if ( $flag )
            {

                $this->sqlEngine->andWhere ( 't1.booking_user_id=?',
                                             $param[ 'user_id' ] ) ;
            }
            else
            {
                $this->sqlEngine->Where ( 't1.booking_user_id=?',
                                          $param[ 'user_id' ] ) ;
            }
            $flag = TRUE ;
        }
        $this->sqlEngine->OrderBy ( 't1.date_register DESC' );
        if($param['limit'])
        {
            $this->sqlEngine->Limit($param['limit']);
        }
                $this->sqlEngine->Run () ;

        //\f\pr($this->sqlEngine->last_query());

        return $this->sqlEngine->getRows () ;
    }
    public function setVisit ()
    {
        $params = $this->request->getAssocParams () ;
        $result=$this->sqlEngine->Update($this->blog_tbl)
                ->setField('num_visit=num_visit+1')
                ->Where('id=?',$params['id'])
                ->Run();
        
        return $result;
    }


}
