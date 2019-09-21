<?php

class memberUpgradeMapper extends \f\dal
{

    public $sqlEngine ;
    private $dataTable ;
    private $member_upgrade_tbl = 'member_upgrade' ;
    private $member_tbl = 'member' ;

    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
        $this->dataTable = \f\dalFactory::make ( 'core.dataTable' ) ;
    }

    //ok
    public function memberUpgradeList ()
    {
        $pr               = $this->request->getAssocParams () ;
        $requestDataTable = $pr[ 'dataTableParams' ] ;
        $columns          = array (
            array (
                'db' => $this->member_upgrade_tbl . '.id', //column name selected
                'dt' => 0, //column num
            ),
            array (
                'db' => $this->member_upgrade_tbl . '.shop_name',
                'dt' => 1,
            ),
            array (
                'db' => $this->member_upgrade_tbl . '.status',
                'dt' => 2,
            ),
                ) ;
        $whereJoin        = array ( 1 ) ;

        $result = array (
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->member_upgrade_tbl,
            'primaryKey'      => $this->member_upgrade_tbl . '.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins          = array (),
            'whereJoin'       => $whereJoin
                ) ;

        $out = $this->dataTable->getDataTable ( $result ) ;
        return $out ;
    }
    //ok
    public function memberUpgradeSave ()
    {
        $params                    = $this->request->getAssocParams () ;
        if($params['confirmation']=='no'){

        }else if($params['confirmation']=='yes'){
            $result = $this->sqlEngine->save ( $this->member_upgrade_tbl,
                array (
                    'shop_name'   => $params[ 'shop_name' ],
                    'address'     => $params['address'],
                    'user_id'     => $params['user_id'],
                    'confirmation' => $params['confirmation']
                )
            ) ;
        $id=$params['id'];
            $params['id']=$params['user_id'];
            $params['type_user']='seller';
            $result2= \f\ttt::dal ( 'member.changeUserType', $params ) ;
            $result3 = $this->sqlEngine->remove ( $this->member_upgrade_tbl,
                array (
                    'id=?',
                    array (
                        $id ) ) ) ;
        }else{
            $result = $this->sqlEngine->save ( $this->member_upgrade_tbl,
                array (
                    'shop_name'   => $params[ 'shop_name' ],
                    'address'     => $params['address'],
                    'user_id'     => $params['user_id'],
                    'confirmation' => $params['confirmation'],
                    'status'=>'enabled'
                )
            ) ;
        }

        return $result ;
    }

    //ok
    public function memberUpgradeSaveEdit ()
    {
        $params   = $this->request->getAssocParams () ;
        $memberSetting = \f\ttt::service( 'member.memberSetting.getSettings' );
        if($params['confirmation']=='no'){
            $result = $this->sqlEngine->remove ( $this->member_upgrade_tbl,
                array (
                    'id=?',
                    array (
                        $params['id'] ) ) ) ;
        }else if($params['confirmation']=='yes'){
            $result = $this->sqlEngine->save ( $this->member_upgrade_tbl, array (
                'shop_name'   => $params[ 'shop_name' ],
                'address'     => $params['address'],
                'user_id'     => $params['user_id'],
                'confirmation' => $params['confirmation'],
                'status'=>'enabled'
            ),
                array (
                    'id=?',
                    array (
                        $params[ 'id' ] ) ) ) ;
            $result = $this->sqlEngine->save ( $this->member_tbl, array (
              //  'creditPurchaseCeiling'   => $memberSetting[ 'leastBuyUser' ],
              //  'creditPurchaseFloor'     => $memberSetting['mostBuyUser'],
             //   'day_settlement'     => $memberSetting['day_settlement'],
                'minPurchase' => $memberSetting['minPurchase'],
            ),
                array (
                    'id=?',
                    array (
                        $params[ 'user_id' ] ) ) ) ;



            $params['type_user']='seller';
            $id=$params['id'];
            $params['id']=$params['user_id'];

            $result2=  \f\ttt::dal ( 'member.changeUserType', $params ) ;
            $result3 = $this->sqlEngine->remove ( $this->member_upgrade_tbl,
                array (
                    'id=?',
                    array (
                        $id ) ) ) ;
        }else{
            $result = $this->sqlEngine->save ( $this->member_upgrade_tbl, array (
                'shop_name'   => $params[ 'shop_name' ],
                'address'     => $params['address'],
                'user_id'     => $params['user_id'],
                'confirmation' => $params['confirmation']
            ),
                array (
                    'id=?',
                    array (
                        $params[ 'id' ] ) ) ) ;
        }

        return $result ;
    }
    //ok
    public function memberUpgradeDelete ()
    {
        $param = $this->request->getAssocParams () ;
        $id    = $param[ 'id' ] ;
        $this->sqlEngine->remove ( $this->member_upgrade_tbl,
                                   array (
            'id=?',
            array (
                $id ) ) ) ;

        return array (
            'result' => 'success',
            'func'   => 'remove' ) ;
    }
    //ok
    public function memberUpgradeStatus ()
    {
        $param = $this->request->getAssocParams () ;
        $id    = $param[ 'id' ] ;

        if ( $param[ 'name' ] && $param[ 'email' ] )
        {
            $status = 'enabled' ;
        }
        else
        {
            $status = $param[ 'status' ] == 'enabled' ? 'disabled' : 'enabled' ;
        }

        $this->sqlEngine->save ( $this->member_upgrade_tbl,
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

    public function getMemberListList ()
    {
        $param = $this->request->getAssocParams () ;
        //\f\pr($param);
        $this->sqlEngine->Select ()
                ->From ( $this->member_upgrade_tbl ) ;
        if ( $param[ 'status' ] )
        {
            $this->sqlEngine->Where ( 'status=?', $param[ 'status' ] ) ;
        }
        $this->sqlEngine->Run () ;
        return $this->sqlEngine->getRows () ;
    }
    //ok
    public function getMemberUpgradeById ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ()
                ->From ( $this->member_upgrade_tbl . ' AS t1' )
                ->Where ( 't1.id=?', $param[ 'id' ] )
                ->Run () ;

        return $this->sqlEngine->getRow () ;
    }
    public function getRequestByUserId ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ()
                ->From ( $this->member_upgrade_tbl . ' AS t1' )
                ->Where ( 't1.user_id=?', $param[ 'user_id' ] )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }
    public function getMemberByOwnerId ()
    {
        $ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;

        if ( ! $ownerId )
        {
            $ownerId = \f\ttt::dal ( 'core.auth.getOwnerFront' ) ;
        }

        $this->sqlEngine->Select ()
                ->From ( $this->member_upgrade_tbl . ' AS t1' )
                ->Where ( 'status=?', 'enabled' )
                ->OrderBy ( 'name ASC' )
                ->Run () ;
        return $this->sqlEngine->getRows () ;
    }

    public function memberCheckUsername ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ( 't1.id,t1.name,t1.picture,t1.status,t1.email' )
                ->From ( $this->member_upgrade_tbl . ' AS t1' )
                ->Where ( 't1.username=?', $param[ 'username' ] )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function checkPasswordLogin ()
    {
        $params = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ( 't1.*' )
                ->From ( $this->member_upgrade_tbl . ' AS t1' )
                ->Where ( 't1.email=?', $params[ 'email' ] )
                ->Run () ;

        return $this->sqlEngine->getRow () ;
    }

    public function saveRememberCode ()
    {
        $params = $this->request->getAssocParams () ;
        $id     = $params[ 'id' ] ;
        unset ( $params[ 'id' ] ) ;
        $this->sqlEngine->save ( $this->member_upgrade_tbl, $params,
                                 array (
            'id=?',
            array (
                $id )
        ) ) ;
    }

    public function changePassword ()
    {

        $params = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ( 't1.password' )
                ->From ( $this->member_upgrade_tbl . ' AS t1' )
                ->Where ( 't1.email=?', $params[ 'email' ] )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function editPassword ()
    {
        $params = $this->request->getAssocParams () ;
        $coding = \f\gadgetFactory::make ( 'coding' ) ;
        $pass   = $coding->encode ( $params [ 'newPassword' ] ) ;
        $result = $this->sqlEngine->save ( $this->member_upgrade_tbl,
                                           array (
            'password' => $pass
                ),
                                           array (
            'email=?',
            array (
                $params[ 'email' ] ) ) ) ;

        return $result ;
    }

    public function memberCheckActiveCode ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ( 't1.id,t1.email,t1.name' )
                ->From ( $this->member_upgrade_tbl . ' AS t1' )
                ->Where ( 't1.active_code=?', $param[ 'active_code' ] )
                ->andWhere ( 't1.email=?', $param[ 'email' ] )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function getMembersByParam ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ( 't1.*,t2.title AS state_title,t3.title AS city_title' )
                ->From ( $this->member_upgrade_tbl . ' AS t1' )
                ->leftJoin ( 'state' . ' AS t2' )
                ->on ( 't1.state_id = t2.id' )
                ->leftJoin ( 'state_city' . ' AS t3' )
                ->on ( 't1.city_id = t3.id' )
                ->Where ( 1 ) ;
        if ( $param[ 'id' ] )
        {
            $this->sqlEngine->andWhere ( 't1.id=?', $param[ 'id' ] ) ;
        }
        if ( $param[ 'status' ] )
        {
            $this->sqlEngine->andWhere ( 't1.status=?', $param[ 'status' ] ) ;
        }
        $this->sqlEngine->Run () ;
        return $this->sqlEngine->getRows () ;
    }




    public function memberUpgradeRequestSave ()
    {
        $params                    = $this->request->getAssocParams () ;
            $result = $this->sqlEngine->save ( $this->member_upgrade_tbl,
                array (
                    'shop_name'   => $params[ 'shop_name' ],
                    'address'     => $params['address'],
                    'user_id'     => $params['user_id'],
                )
            ) ;
        return $result ;
    }
}
