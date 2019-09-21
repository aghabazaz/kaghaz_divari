<?php

class newsletterMapper extends \f\dal
{

    public $sqlEngine ;
    private $dataTable ;
    private $newsletter_tbl          = 'newsletter_list' ;
    private $newsletter_category_tbl = 'newsletter_list_category' ;

    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
        $this->dataTable = \f\dalFactory::make ( 'core.dataTable' ) ;
    }

    public function newsletterSave ()
    {
        $params               = $this->request->getAssocParams () ;
        $params[ 'owner_id' ] = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;
        if ( ! $params[ 'owner_id' ] )
        {
            $params[ 'owner_id' ] = \f\ttt::dal ( 'core.auth.getOwnerFront' ) ;
        }
        $params[ 'date_register' ] = time () ;

//        if ( $params[ 'mobile' ] != NULL )
//        {
//            $params[ 'mobile_status' ] = 'enabled' ;
//        }
//        else
//        {
//            $params[ 'mobile_status' ] = 'disabled' ;
//        }
        if ( $params[ 'email' ] != NULL )
        {
            $params[ 'email_status' ] = 'enabled' ;
        }
        else
        {
            $params[ 'email_status' ] = 'disabled' ;
        }
        $result = $this->sqlEngine->save ( $this->newsletter_tbl,
                                           array (
            'owner_id'      => $params[ 'owner_id' ],
            'email'         => $params[ 'email' ],
            'date_register' => $params[ 'date_register' ],
            'email_status'  => $params[ 'email_status' ],
                ) ) ;
//        $id     = $this->sqlEngine->last_id () ;
//        $this->save_related_param ( $params, $id ) ;
        return $result ;
    }

    public function newsletterSaveEdit ()
    {
        $param = $this->request->getAssocParams () ;

        if ( $params[ 'mobile' ] != NULL )
        {
            $params[ 'mobile_status' ] = 'enabled' ;
        }
        else
        {
            $params[ 'mobile_status' ] = 'disabled' ;
        }
        if ( $params[ 'email' ] != NULL )
        {
            $params[ 'email_status' ] = 'enabled' ;
        }
        else
        {
            $params[ 'email_status' ] = 'disabled' ;
        }

        $id     = $param[ 'id' ] ;
        //\f\pre($param);
        $result = $this->sqlEngine->save ( $this->newsletter_tbl,
                                           array (
            'name'          => $param[ 'name' ],
            'email'         => $param[ 'email' ],
            'mobile'        => $param[ 'mobile' ],
            'mobile_status' => $param[ 'mobile_status' ],
            'email_status'  => $param[ 'email_status' ],
                ),
                                           array (
            'id=?',
            array (
                $id )
                ) ) ;
//        $this->delete_related_param ( $id ) ;
//        $this->save_related_param ( $param, $id ) ;
        return $result ;
    }

//    public function save_related_param ( $params, $id )
//    {
//
//        if ( is_array ( $params[ 'category' ] ) )
//        {
//            foreach ( $params[ 'category' ] AS $data )
//            {
//                $result = $this->sqlEngine->save ( $this->newsletter_category_tbl,
//                                                   array (
//                    'newsletter_id' => $id,
//                    'category_id'   => $data,
//                        )
//                        ) ;
//            }
//        }
//    }

    public function checkIssetEmailMobile ()
    {
        $param             = $this->request->getAssocParams () ;
        $param[ 'status' ] = $param[ 'status' ] ? $param[ 'status' ] : 'enabled' ;
        $this->sqlEngine->Select ( 't1.*' )
                ->From ( $this->newsletter_tbl . ' AS t1' ) ;
        //->Where('status=?', $param['status']);
        $flag              = TRUE ;
        if ( $param[ 'email' ] )
        {
            if ( $flag )
            {
                $this->sqlEngine->Where ( 'email=?', $param[ 'email' ] ) ;
                $flag = FALSE ;
            }
            else
            {
                $this->sqlEngine->orWhere ( 'email=?', $param[ 'email' ] ) ;
            }
        }
//        if ( $param[ 'mobile' ] )
//        {
//            if ( $flag )
//            {
//                $this->sqlEngine->Where ( 'mobile=?', $param[ 'mobile' ] ) ;
//            }
//            else
//            {
//                $this->sqlEngine->orWhere ( 'mobile=?', $param[ 'mobile' ] ) ;
//            }
//        }
        $this->sqlEngine->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    //active status_mob or email  TBL and old shop_category delete, then category shop Update
    public function enableNewsletter ()
    {
        $param = $this->request->getAssocParams () ;
        //\f\pre($param['old_info']['email']);
        if ( $param[ 'mobile' ] != NULL )
        {
            $param[ 'mobile_status' ] = 'enabled' ;
        }
        else
        {
            $param[ 'mobile_status' ] = 'disabled' ;
        }
        if ( $param[ 'email' ] != NULL )
        {
            $param[ 'email_status' ] = 'enabled' ;
        }
        else
        {
            $param[ 'email_status' ] = 'disabled' ;
        }
        $result = $this->sqlEngine->save ( $this->newsletter_tbl,
                                           array (
            'name'          => $param[ 'name' ],
            'email'         => $param[ 'email' ] ? $param[ 'email' ] : $param[ 'old_info' ][ 'email' ],
            'mobile'        => $param[ 'mobile' ] ? $param[ 'mobile' ] : $param[ 'old_info' ][ 'mobile' ],
            'mobile_status' => $param[ 'mobile_status' ],
            'email_status'  => $param[ 'email_status' ],
                ),
                                           array (
            'id=?',
            array (
                $param[ 'old_info' ][ 'id' ] )
                ) ) ;
        //\f\pre($param['old_info']['id']);
        $id     = $param[ 'old_info' ][ 'id' ] ;
        $this->delete_related_param ( $id ) ;
        $this->save_related_param ( $param, $id ) ;
        return $result ;
    }

//    public function delete_related_param ( $id )
//    {
//        $this->sqlEngine->remove ( $this->newsletter_category_tbl,
//                                   array (
//            'newsletter_id=?',
//            array (
//                $id ) ) ) ;
//    }

    //cancel newsletter => status mob or email = disabled
    public function cancelNewsletter ()
    {
        $param = $this->request->getAssocParams () ;

        if ( $param[ 'mobile' ] && $param[ 'email' ] )
        {
            $param[ 'mobile_status' ] = 'disabled' ;
            $param[ 'email_status' ]  = 'disabled' ;
        }
        else if ( $param[ 'mobile' ] )
        {
            $param[ 'mobile_status' ] = 'disabled' ;
            $param[ 'email_status' ]  = 'enabled' ;
        }
        else
        {
            $param[ 'email_status' ]  = 'disabled' ;
            $param[ 'mobile_status' ] = 'enabled' ;
        }
        $result = $this->sqlEngine->save ( $this->newsletter_tbl,
                                           array (
            'mobile_status' => $param[ 'mobile_status' ],
            'email_status'  => $param[ 'email_status' ],
                ),
                                           array (
            'id=?',
            array (
                $param[ 'user_id' ] )
                ) ) ;
        return $result ;
    }

    //in backend ,admin del each user
    public function newsletterDelete ()
    {
        $param = $this->request->getAssocParams () ;
        $id    = $param[ 'id' ] ;
        $this->sqlEngine->remove ( $this->newsletter_tbl,
                                   array (
            'id=?',
            array (
                $id ) ) ) ;

        return array (
            'result' => 'success',
            'func'   => 'remove' ) ;
    }

    public function nlMemberStatus ()
    {
        $param  = $this->request->getAssocParams () ;
        $id     = $param[ 'id' ] ;
        $status = $param[ 'status' ] == 'enabled' ? 'disabled' : 'enabled' ;

        $this->sqlEngine->save ( $this->newsletter_tbl,
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

    public function nlMemberList ()
    {
        $pr = $this->request->getAssocParams () ;

        $requestDataTable = $pr[ 'dataTableParams' ] ;
        $columns          = array (
            array (
                'db' => 't1.id', //column name selected
                'dt' => 0, //column num
            ),
            array (
                'db' => 't1.email',
                'dt' => 2,
            ),
            array (
                'db' => 't1.status',
                'dt' => 5,
            ),
                ) ;
        $ownerId          = \f\ttt::service ( 'core.auth.getUserOwner' ) ;
        if ( ! $ownerId )
        {
            $ownerId = \f\ttt::dal ( 'core.auth.getOwnerFront' ) ;
        }
        if ( $pr[ 'user_id' ] )
        {
            $whereJoin = array (
                "t1.owner_id=" . $ownerId . " AND t1.user_id=" . $pr[ 'user_id' ] ) ;
        }
        else
        {
            $whereJoin = array (
                "t1.owner_id=" . $ownerId ) ;
        }


        $result = array (
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->newsletter_tbl . ' AS t1',
            'primaryKey'      => 't1.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins          = array (),
            'whereJoin'       => $whereJoin
                ) ;
        $out    = $this->dataTable->getDataTable ( $result ) ;
        return $out ;
    }

    public function getNlMemberById ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ()
                ->From ( $this->newsletter_tbl . ' AS t1' )
                ->Where ( 't1.id=?', $param[ 'id' ] )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function getCatNlMemberById ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ( 't1.category_id AS category' )
                ->From ( $this->newsletter_category_tbl . ' AS t1' )
                ->Where ( 't1.newsletter_id=?', $param[ 'id' ] )
                ->Run () ;
        return $this->sqlEngine->getRows () ;
    }

    public function getEmailsMobiles ()
    {
        $param = $this->request->getAssocParams () ;
        // if $param[ 'type' ] == email get rows email else get rows mobile
        $this->sqlEngine->Select ( 't1.' . $param[ 'type' ].',t1.name' )
                ->From ( $this->newsletter_tbl . ' AS t1' )
//                ->leftJoin ( $this->newsletter_category_tbl . ' AS t2' )
//                ->On ( 't1.id=t2.newsletter_id' )
//                ->Where ( 't2.category_id=?', $param [ 'cat_id' ] )
                ->Where ( 't1.status=?', 'enabled' ) ;
        if ( $param[ 'type' ] == 'email' )
        {
            $this->sqlEngine->andWhere ( 't1.email_status=?', 'enabled' ) ;
        }
        else
        {
            $this->sqlEngine->andWhere ( 't1.mobile_status=?', 'enabled' ) ;
        }
        $this->sqlEngine->Run () ;
        return $this->sqlEngine->getRows () ;
    }

}
