<?php

class memberMapper extends \f\dal
{

    public $sqlEngine ;
    private $dataTable ;
    private $member_tbl = 'member' ;

    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
        $this->dataTable = \f\dalFactory::make ( 'core.dataTable' ) ;
    }

    //ok
    public function memberListList ()
    {
        $pr               = $this->request->getAssocParams () ;
        $requestDataTable = $pr[ 'dataTableParams' ] ;
        $columns          = array (
            array (
                'db' => $this->member_tbl . '.id', //column name selected
                'dt' => 0, //column num
            ),
            array (
                'db' => $this->member_tbl . '.username',
                'dt' => 1,
            ),
            array (
                'db' => $this->member_tbl . '.name',
                'dt' => 2,
            ),
            array (
                'db' => $this->member_tbl . '.mobile',
                'dt' => 3,
            ),
            array (
                'db' => $this->member_tbl . '.email',
                'dt' => 4,
            ),
            array (
                'db' => $this->member_tbl . '.date_register',
                'dt' => 5,
            ),
            array (
                'db' => $this->member_tbl . '.status',
                'dt' => 6,
            ),
                ) ;
        $whereJoin        = array (
            'id>0 and type_user="'.$pr['type_user'].'" and status_reg="complete"' ) ;

        $result = array (
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->member_tbl,
            'primaryKey'      => $this->member_tbl . '.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins          = array (),
            'whereJoin'       => $whereJoin
                ) ;

        $out = $this->dataTable->getDataTable ( $result ) ;
        return $out ;
    }
    //ok
    public function memberListSave ()
    {
        $params   = $this->request->getAssocParams () ;
        $memberSetting = \f\ttt::service( 'member.memberSetting.getSettings' );
        $creditPurchaseFloor=(($params['type_user']=='seller' && $params['statusAccount']=='goodAccount')?(($params['creditPurchaseFloor']>0 and $params['creditPurchaseFloor'])?$params['creditPurchaseFloor']:$memberSetting['leastBuyUser']):NULL);
        $creditPurchaseCeiling=(($params['type_user']=='seller' && $params['statusAccount']=='goodAccount')?(($params['creditPurchaseCeiling']>0 and $params['creditPurchaseCeiling'])?$params['creditPurchaseCeiling']:$memberSetting['mostBuyUser']):NULL);
        $date_settlement=(($params['type_user']=='seller' && $params['statusAccount']=='goodAccount')? (($params['day_settlement']>0 and $params['day_settlement'])?$params['day_settlement']:$memberSetting['day_settlement']):NULL);
        $conditional_number=(($params['type_user']=='seller' && $params['statusAccount']=='goodAccount')?(($params['conditional_number']>0 and $params['conditional_number'])?$params['conditional_number']:1):NULL);
        $minPurchase=(($params['type_user']=='seller')?(($params['minPurchase']>0 and $params['minPurchase'])?$params['minPurchase']:$memberSetting['minPurchase']):NULL);
        $creditPurchaseFloor = str_replace(',', '', $creditPurchaseFloor);
        $creditPurchaseCeiling = str_replace(',', '', $creditPurchaseCeiling);
        $minPurchase = str_replace(',', '',  $minPurchase);

      //  \f\pre($params);

        $params[ 'date_register' ] = time () ;

        $arr_save = array (
            'name'                  => $params[ 'name' ],
            'national_code'         => $params[ 'national_code' ],
            'shop_name'             => $params[ 'shop_name' ],
            'phone'                 => $params[ 'phone' ],
            'fax'                   => $params[ 'fax' ],
            'mobile'                => $params[ 'mobile' ],
            'address'               => $params[ 'address' ],
            'gender'                => $params[ 'gender' ],
            'state_id'              => $params[ 'state_id' ],
            'city_id'               => $params[ 'city_id' ],
            'birthday'              => $params[ 'birthday' ],
            'postal_code'           => $params[ 'postal_code' ],
            'type_user'             => $params['type_user'],
            'email'                 => $params['email'],
            'day_settlement'        => $date_settlement,
            'minPurchase'           => $minPurchase,
            'creditPurchaseFloor'   => $creditPurchaseFloor,
            'creditPurchaseCeiling' => $creditPurchaseCeiling,
            'statusAccount'         => ($params['type_user']=='seller'?$params['statusAccount']:Null),
            'conditional_number'    => $conditional_number,
            'wallet_credit'         => $params['wallet_credit'],
            'status_reg'            =>'complete',
            'username'              =>$params['username'],
            'date_register'         =>$params[ 'date_register' ]
        ) ;

        if ( $params['password']==$params['password_re'] and $params['password']!='' and $params['password']!=NULL)
        {
            $coding                 = \f\gadgetFactory::make ( 'coding' ) ;
            $arr_save[ 'password' ] = $coding->encode ( $params [ 'password' ] ) ;
        }

        $result = $this->sqlEngine->save ( $this->member_tbl,$arr_save) ;

    return $result ;
    }

    public function saveAsCompleteMember(){
        $params = $this->request->getAssocParams () ;
        $this->sqlEngine->save ( $this->member_tbl,
            array (
                'status_reg'      =>'complete'
            ),
            array (
                'mobile=?',
                array (
                    $_SESSION[ 'mobile' ] ) )
        ) ;
      //  \f\pr($_SESSION[ 'mobile' ]);
       // \f\pr($this->sqlEngine->last_query());
    }
    public function checkMobileNumber(){
        $params = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ()
            ->From ( $this->member_tbl )
            ->where('mobile=?',$params['mobile']);
          //  ->andWhere('status_reg=?','complete');
        $this->sqlEngine->Run () ;
       // \f\pre($this->sqlEngine->getRow());
        return $this->sqlEngine->getRow() ;
    }

    public function checkMobileNumberForConfCode(){
        $params = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ()
            ->From ( $this->member_tbl )
            ->where('mobile=?',$params['mobile']);
           // ->andWhere('status_reg=?','complete');
        $this->sqlEngine->Run () ;

        return $this->sqlEngine->getRow () ;
    }

    public  function walletMemberUpdate(){
        $params = $this->request->getAssocParams () ;
        $result = $this->sqlEngine->save ( $this->member_tbl,
            array (
                'wallet_credit'        => $params[ 'priceSet' ],
            ),
            array (
                'id=?',
                array (
                    $params[ 'member_info' ]['id'] ) )
        ) ;
    }
    public  function deleteLicenseBuy(){
        $params = $this->request->getAssocParams () ;
        $params['conditional_number'] = '0';
        $result = $this->sqlEngine->save ( $this->member_tbl,
            array (
                'conditional_number'        => $params[ 'conditional_number' ],
            ),
            array (
                'id=?',
                array (
                    $params[ 'member_info' ]['id'] ) )
        ) ;
    }

    public function memberMobileSave ()
    {
        $params = $this->request->getAssocParams () ;
        if($params['type']=='update'){
            $result = $this->sqlEngine->save ( $this->member_tbl,
                array (
                    'active_code'        => $params[ 'code' ],
                ),
                array (
                    'mobile=?',
                    array (
                        $params[ 'mobile' ] ) )
            ) ;
        }else if($params['type']=='insert'){
            if ( $params[ 'password' ] != NULL )
            {
                $coding                 = \f\gadgetFactory::make ( 'coding' ) ;
                $password = $coding->encode ( $params [ 'password' ] ) ;
            }

            $result = $this->sqlEngine->save ( $this->member_tbl,
                array (
                    'mobile'          => $params[ 'mobile' ],
                    'active_code'        => $params[ 'code' ],
                    'email'=>$params['email'],
                    'password'=>$password,
                    'date_register'=>time()
                )
            ) ;
        }
        $this->sqlEngine->Select ()
            ->From ( $this->member_tbl )
            ->where('mobile=?',$params['mobile']);
        $this->sqlEngine->Run () ;
        $rowUser=$this->sqlEngine->getRow();
        $_SESSION['user_id_temp']=$rowUser['id'];
        $_SESSION['type_user']=$rowUser['type_user'];
        return $result ;
    }

    public function saveCompleteInfo(){
        $params = $this->request->getAssocParams () ;
      //  \f\pr($params);
        $userNameInfo=$this->memberCheckUsername2($params['username']);
        $params[ 'date_register' ] = time () ;
        if(!empty($userNameInfo)){
            $result = array('result'=>'error','message'=>'نام کاربری تکراری است');
        }else{
            if ( $params[ 'password' ] != NULL )
            {
                $coding                 = \f\gadgetFactory::make ( 'coding' ) ;
                $password = $coding->encode ( $params [ 'password' ] ) ;
            }

             $this->sqlEngine->save ( $this->member_tbl,
                array (
                    'name'            => $params[ 'name' ],
                    'email'            => $params[ 'email' ],
                    'password'        => $password,
                    'username'        => $params[ 'username' ],
                    'date_register'   =>$params[ 'date_register' ],
                    'status_reg'      =>'complete'
                ),
                array (
                    'mobile=?',
                    array (
                        $_SESSION[ 'mobile' ] ) )
            ) ;
            $result=array('result'=>'success','message'=>'کاربر با موفقیت ثبت نام شد.');
            $result['url']= \f\ifm::app()->siteUrl . 'account' ;
        }

        return $result;
    }
    /*public function getConfirmationCode(){
        $params = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ()
            ->From ( $this->member_tbl )
            ->where('mobile=?',$params['mobile']);
        $this->sqlEngine->Run () ;
        return $this->sqlEngine->getRow () ;
    }*/
    //ok
    public function memberListAddInfoSaveEdit ()
    {
        $params   = $this->request->getAssocParams () ;
        $arr_save = array (
            'name'          => $params[ 'name' ],
            'national_code' => $params[ 'national_code' ],
            'phone'         => $params[ 'phone' ],
            'fax'           => $params[ 'fax' ],
            'shop_name'      => $params[ 'shop_name' ],
            'mobile'        => $params[ 'mobile' ],
            'address'       => $params[ 'address' ],
            'gender'        => $params[ 'gender' ],
            'state_id'      => $params[ 'state_id' ],
            'city_id'       => $params[ 'city_id' ],
            'birthday'      => $params[ 'birthday' ],
            'card'          => $params[ 'card' ],
        ) ;
        if ( $params[ 'password' ] != NULL )
        {
            $coding                 = \f\gadgetFactory::make ( 'coding' ) ;
            $arr_save[ 'password' ] = $coding->encode ( $params [ 'password' ] ) ;
        }
        $result = $this->sqlEngine->save ( $this->member_tbl, $arr_save,
            array (
                'id=?',
                array (
                    $params[ 'id' ] ) ) ) ;

        return $result ;
    }
    public function memberListSaveEdit ()
    {
        $params   = $this->request->getAssocParams () ;

       // \f\pre($params);
        $memberSetting = \f\ttt::service( 'member.memberSetting.getSettings' );
        $creditPurchaseFloor=(($params['type_user']=='seller' && $params['statusAccount']=='goodAccount')?(($params['creditPurchaseFloor']>0 and $params['creditPurchaseFloor'])?$params['creditPurchaseFloor']:$memberSetting['leastBuyUser']):NULL);
        $creditPurchaseCeiling=(($params['type_user']=='seller' && $params['statusAccount']=='goodAccount')?(($params['creditPurchaseCeiling']>0 and $params['creditPurchaseCeiling'])?$params['creditPurchaseCeiling']:$memberSetting['mostBuyUser']):NULL);
        $date_settlement=(($params['type_user']=='seller' && $params['statusAccount']=='goodAccount')? (($params['day_settlement']>0 and $params['day_settlement'])?$params['day_settlement']:$memberSetting['day_settlement']):NULL);
        $conditional_number=(($params['type_user']=='seller' && $params['statusAccount']=='goodAccount')?(($params['day_settlement']>0 and $params['day_settlement'])?$params['conditional_number']:1):NULL);
        $minPurchase=(($params['type_user']=='seller')?(($params['minPurchase']>0 and $params['minPurchase'])?$params['minPurchase']:$memberSetting['minPurchase']):NULL);
       
        $creditPurchaseFloor = str_replace(',', '', $creditPurchaseFloor);
        $creditPurchaseCeiling = str_replace(',', '', $creditPurchaseCeiling);
        $minPurchase = str_replace(',', '',  $minPurchase);
        $params['wallet_credit'] = str_replace(',', '',  $params['wallet_credit']);

        $arr_save = array (
            'name'                  => $params[ 'name' ],
            'mobile'                => $params[ 'mobile' ],
            'address'               => $params[ 'address' ],
            'type_user'             => $params['type_user'],
            'day_settlement'        => $date_settlement,
            'minPurchase'           => $minPurchase,
            'creditPurchaseFloor'   => $creditPurchaseFloor,
            'creditPurchaseCeiling' => $creditPurchaseCeiling,
            'statusAccount'         => ($params['type_user']=='seller'?$params['statusAccount']:Null),
            'conditional_number'    => $conditional_number,
            'wallet_credit'         => $params['wallet_credit'],
        ) ;

        if ( $params['password']==$params['password_re'] and $params['password']!='' and $params['password']!=NULL)
        {
            $coding                 = \f\gadgetFactory::make ( 'coding' ) ;
            $arr_save[ 'password' ] = $coding->encode ( $params [ 'password' ] ) ;
        }

        $result = $this->sqlEngine->save ( $this->member_tbl, $arr_save,
                                           array (
            'id=?',
            array (
                $params[ 'id' ] ) ) ) ;

        return $result ;
    }
    //ok
    public function memberListDelete ()
    {
        $param = $this->request->getAssocParams () ;
        $id    = $param[ 'id' ] ;
        $this->sqlEngine->remove ( $this->member_tbl,
                                   array (
            'id=?',
            array (
                $id ) ) ) ;

        return array (
            'result' => 'success',
            'func'   => 'remove' ) ;
    }
    //ok
    public function memberListStatus ()
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

        $this->sqlEngine->save ( $this->member_tbl,
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
                ->From ( $this->member_tbl ) ;
        if ( $param[ 'status' ] )
        {
            $this->sqlEngine->Where ( 'status=?', $param[ 'status' ] ) ;
        }
        $this->sqlEngine->Run () ;
        return $this->sqlEngine->getRows () ;
    }

    //ok
    public function getNormMemberList ()
    {
        $param = $this->request->getAssocParams () ;
        //\f\pr($param);
        $this->sqlEngine->Select ()
            ->From ( $this->member_tbl ) ;
        if ( $param[ 'status' ] )
        {
            $this->sqlEngine->Where ( 'status=?', $param[ 'status' ] ) ;
        }
       // $this->sqlEngine->andWhere('type_user=?','seller');
        $this->sqlEngine->Run () ;
        return $this->sqlEngine->getRows () ;
    }
    //ok
    public function getMemberById ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ('t1.*,t2.title AS state,t3.title AS city')
                ->From ( $this->member_tbl . ' AS t1' )
                ->leftJoin ( 'state AS t2')
                ->On ('t1.state_id=t2.id')
                ->leftJoin ( 'state_city AS t3')
                ->On ('t1.city_id=t3.id')
                ->Where ( 't1.id=?', $param[ 'id' ] )
                ->Run () ;
       // \f\pre($this->sqlEngine->getRow ());
        return $this->sqlEngine->getRow () ;
    }
    public function getUserInfoByEmailAddress ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ('t1.*')
                ->From ( $this->member_tbl . ' AS t1' )
                ->Where ( 't1.email=?', $param[ 'email' ] )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function getUserInfoByUsername ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ('t1.*')
            ->From ( $this->member_tbl . ' AS t1' )
            ->Where ( 't1.mobile=?', $param[ 'username' ] )
            ->orWhere ( 't1.email=?', $param[ 'username' ] )
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
                ->From ( $this->member_tbl . ' AS t1' )
                ->Where ( 'status=?', 'enabled' )
                ->OrderBy ( 'name ASC' )
                ->Run () ;
        return $this->sqlEngine->getRows () ;
    }

    public function memberCheckUsername ()
    {
        $param = $this->request->getAssocParams () ;
        //\f\pr($param);
        $this->sqlEngine->Select ( 't1.id,t1.name,t1.picture,t1.status,t1.email' )
                ->From ( $this->member_tbl . ' AS t1' )
                ->Where ( '(t1.mobile=?', $param[ 'username' ] )
                ->orWhere('t1.email=?)',$param['username'])
                ->andWhere('t1.status_reg=?','complete')
                ->Run () ;
        //\f\pr($this->sqlEngine->last_query());
        //\f\pre($this->sqlEngine->getRow());
        return $this->sqlEngine->getRow () ;
    }
    public function memberCheckUsername2 ($params)
    {
        $this->sqlEngine->Select ( 't1.id,t1.name,t1.picture,t1.status,t1.email' )
            ->From ( $this->member_tbl . ' AS t1' )
            ->Where ( 't1.mobile=?', $params[ 'username' ] )
            ->Run () ;
        return $this->sqlEngine->getRow () ;
    }
    public function checkPasswordLogin ()
    {
        $params = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ( 't1.*' )
                ->From ( $this->member_tbl . ' AS t1' )
                ->Where ( '(t1.mobile=?', $params[ 'username' ] )
                ->orWhere ( 't1.username=?)', $params[ 'username' ] )
                ->Run () ;

        return $this->sqlEngine->getRow () ;
    }

    public function saveRememberCode ()
    {
        $params = $this->request->getAssocParams () ;
        $id     = $params[ 'id' ] ;
        unset ( $params[ 'id' ] ) ;
        $this->sqlEngine->save ( $this->member_tbl, $params,
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
                ->From ( $this->member_tbl . ' AS t1' )
                ->Where ( 't1.id=?', $params[ 'user_id' ] )
                ->Run () ;
      /*  \f\pr($params);
        \f\pre($this->sqlEngine->last_query());*/
        return $this->sqlEngine->getRow () ;
    }

    public function editPassword ()
    {
        $params = $this->request->getAssocParams () ;
        //\f\pr($params);
        $coding = \f\gadgetFactory::make ( 'coding' ) ;
        $pass   = $coding->encode ( $params [ 'newPassword' ] ) ;
        $result = $this->sqlEngine->save ( $this->member_tbl,
                                           array (
            'password' => $pass
                ),
                                           array (
            'id=?',
            array (
                $params[ 'user_id' ] ) ) ) ;
       /* \f\pr($pass);
        \f\pr($params);
        \f\pr($result);
        \f\pr($this->sqlEngine->last_query());*/
        return $result ;
    }

    public function memberCheckActiveCode ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ( 't1.id,t1.email,t1.name' )
                ->From ( $this->member_tbl . ' AS t1' )
                ->Where ( 't1.active_code=?', $param[ 'active_code' ] )
                ->andWhere ( 't1.email=?', $param[ 'email' ] )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function getMembersByParam ()
    {
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ( 't1.*,t2.title AS state_title,t3.title AS city_title' )
                ->From ( $this->member_tbl . ' AS t1' )
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

    public function changeUserType(){
        $param = $this->request->getAssocParams () ;
        $result = $this->sqlEngine->save ( $this->member_tbl,
            array (
                'type_user' => $param['type_user'],
                'shop_address'=>$param['address'],
                'shop_name'=>$param['shop_name']
            ),
            array (
                'id=?',
                array (
                    $param[ 'id' ] ) ) ) ;
        return $result ;
    }

    public function getUserType(){
        $param = $this->request->getAssocParams () ;
        $this->sqlEngine->Select ( 't1.type_user' )
            ->From ( $this->member_tbl . ' AS t1' )
            ->where('t1.id=?',$param['user_id'])
            ->Run();
        return $this->sqlEngine->getRow();
    }

    public function getSellerByUserId ()
    {
        $param = $this->request->getAssocParams () ;
         $param['type_user'] = 'seller';
        $this->sqlEngine->Select ('t1.id')
            ->From ( $this->member_tbl . ' AS t1' )
            ->Where ( 't1.id=?', $param[ 'user_id' ] )
            ->andWhere('t1.type_user=?', $param['type_user'])
            ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function saveWallet(){
        $param= $this->request->getAssocParams () ;
        //\f\pr($param);
        $this->sqlEngine->Select ('t1.wallet_credit')
            ->From ( $this->member_tbl . ' AS t1' )
            ->Where ( 't1.id=?', $param[ 'user_id' ] )
            ->Run () ;
        $wallet=$this->sqlEngine->getRow () ;
        $result = $this->sqlEngine->save ( $this->member_tbl,
            array (
                'wallet_credit' => ($param['price']+$wallet['wallet_credit']),
            ),
            array (
                'id=?',
                array (
                    $param[ 'user_id' ] ) ) ) ;
        return $result ;
    }


}
