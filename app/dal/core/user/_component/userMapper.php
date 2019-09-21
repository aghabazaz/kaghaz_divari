<?php

/**
 * Database
 */
class userMapper extends \f\dal
{

    /**
     *
     * @var \f\g\validator
     */
    private $v ;
    private $dataTable ;

    /**
     *
     * @var dataTable 
     */
    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
        $this->dataTable = \f\dalFactory::make ( 'core.dataTable' ) ;
    }

    public function defaultGetList ()
    {
        $pr               = $this->request->getAssocParams () ;
        $requestDataTable = $pr[ 'dataTableParams' ] ;
        $param            = $pr[ 'param' ] ;

        $enterdUserInfo = \f\ifm::app ()->getUserInfo () ;

        $ownerId = $enterdUserInfo[ 'owner_id' ] ;
        $userId  = $enterdUserInfo[ 'id' ] ;

        //\f\pr($enterdUserInfo);

        switch ( $param )
        {
            case 'mainUser':
                if ( $enterdUserInfo[ 'userType' ] === 'superadmin' )
                {
                    $select = 'U.id, UI.name, UI.phone, UI.email, U.status, U.personality,
                               UIL.name as l_name, UIl.phone as l_phone, UIL.email as l_email' ;
                    $this->sqlEngine->Select ( $select )
                            ->From ( 'core_user as U' )
                            ->leftJoin ( 'core_user_info as UI' )
                            ->On ( 'U.id = UI.core_userid' )
                            ->leftJoin ( 'core_user_info_legal as UIL' )
                            ->On ( 'U.id = UIL.core_userid' )
                            ->Where ( 'U.owner_id = ' . $userId )
                            ->orWhere ( 'U.id = ' . $ownerId )
                            ->Run () ;
                }
                else if ( $enterdUserInfo[ 'userType' ] === 'siteAdmin' )
                {
                    $this->sqlEngine->Select ( 'U.id, UI.name, UI.phone, UI.email, U.status' )
                            ->From ( 'core_user as U' )
                            ->leftJoin ( 'core_user_info as UI' )
                            ->On ( 'U.id = UI.core_userid' )
                            ->Where ( 'U.id = ' . $ownerId )
                            ->Run () ;
                }
                else
                {
                    $this->sqlEngine->Select ( 'U.id, UI.name, UI.phone, UI.email, U.status' )
                            ->From ( 'core_user as U' )
                            ->leftJoin ( 'core_user_info as UI' )
                            ->On ( 'U.id = UI.core_userid' )
                            ->Where ( 'U.id = ' . $ownerId )
                            ->andWhere ( 'U.id != ' . $userId )
                            ->Run () ;
                }
                return array (
                    'data' => $this->sqlEngine->getRows ()
                        ) ;
            case 'siteUser':

                $this->sqlEngine->Select ( 'U.id, UI.name, UI.phone, UI.email, U.status' )
                        ->From ( 'core_user as U' )
                        ->Join ( 'core_user_info AS UI' )
                        ->Where ( 'U.type = "backend"' )
                        ->andWhere ( 'U.owner_id=?', $ownerId )
                        ->andWhere ( 'U.id=UI.core_userid' )
                        ->Run () ;
                return array (
                    'data' => $this->sqlEngine->getRows ()
                        ) ;
            case 'colleagueUser':
                $result = $this->showColleagueUser ( $requestDataTable,
                                                     $columns, $ownerId ) ;
                $out    = $this->dataTable->getDataTable ( $result ) ;
                break ;
            case 'memberUser':
                $result = $this->showMemberUser ( $requestDataTable, $columns,
                                                  $ownerId ) ;
                $out    = $this->dataTable->getDataTable ( $result ) ;
                break ;
        }


        $tableJoin = $param == 'colleagueUser' ? 'core_user_info_legal' : 'core_user_info' ;

        $columns = array (
            array (
                'db' => 'core_user.id', //column name selected
                'dt' => 0, //column num
            ),
            array (
                'db' => $tableJoin . '.name',
                'dt' => 1,
            ),
            array (
                'db' => $tableJoin . '.phone',
                'dt' => 2,
            ),
            array (
                'db' => $tableJoin . '.email',
                'dt' => 3,
            ),
            array (
                'db' => 'core_user.status',
                'dt' => 4,
            ),
                ) ;

        return $out ;
    }

    private function showMainUser ( $requestDataTable, $userId )
    {

        $arrInfo = array (
            $this->realUserShowInfo ( $userId ),
            $this->legalUserShowInfo ( $userId ) ) ;

        return array (
            'requestDataTble' => $requestDataTable,
            'arrInfo'         => $arrInfo,
            'searchTxt'       => $search           = '',
            'limit'           => $limit            = ''
                ) ;
    }

    private function realUserShowInfo ( $userId )
    {

        return array (
            "tablename"      => 'core_user',
            "column"         => array (
                'core_user'      => array (
                    "id"     => "id",
                    "status" => "status",
                ),
                'core_user_info' => array (
                    "name"  => "name",
                    "phone" => "phone",
                    "email" => "email",
                )
            ),
            "join"           => array (
                array (
                    "typeJoin"      => 'inner',
                    "table"         => 'core_user_info',
                    "on"            => "core_user_info.core_userid = core_user.id",
                    "searchingJoin" => array (
                        'name',
                        'email' )
                ) ),
            "mainWhere"      => "(core_user.owner_id = " . $userId . " AND core_user.type = 'backend' )",
            "searchingBy"    => array (
                "id"
            ),
            "searchinglevel" => array (
                "name"  => 1,
                "email" => 2 ),
                ) ;
    }

    private function legalUserShowInfo ()
    {
        return array (
            "tablename"      => 'core_user',
            "column"         => array (
                'core_user'            => array (
                    "id"     => "id",
                    "status" => "status"
                ),
                'core_user_info_legal' => array (
                    "name"  => "name",
                    "phone" => "phone",
                    "email" => "email",
                )
            ),
            "join"           => array (
                array (
                    "typeJoin"      => 'inner',
                    "table"         => 'core_user_info_legal',
                    "on"            => "core_user_info_legal.core_userid = core_user.id",
                    "searchingJoin" => array (
                        'name',
                        'email' )
                ) ),
            "mainWhere"      => "(core_user.owner_id = core_user.id AND core_user.type = 'backend')",
            "searchingBy"    => array (
                "id"
            ),
            "searchinglevel" => array (
                "name"  => 1,
                "email" => 2 ),
                ) ;
        //$this->dataTable->
    }

    private function showSiteUser ( $requestDataTable, $columns, $ownerId )
    {

        return array (
            'requestDataTble' => $requestDataTable,
            'tableName'       => 'core_user',
            'primaryKey'      => 'core_user.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins          = array (
        'core_user_info'
            ),
            'whereJoin'       => $whereJoin        = array (
        'core_user_info.core_userid = core_user.id',
        "core_user.owner_id = '" . $ownerId . "'",
        "core_user.id <> " . $ownerId . "'",
        "core_user.type = 'frontend'"
            ),
                ) ;
    }

    private function showColleagueUser ( $requestDataTable, $columns, $ownerId )
    {
        return array (
            'requestDataTble' => $requestDataTable,
            'tableName'       => 'core_user',
            'primaryKey'      => 'core_user.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins          = array (
        'core_user_info_legal'
            ),
            'whereJoin'       => $whereJoin        = array (
        'core_user_info_legal.core_userid = core_user.id',
        "core_user.owner_id = '" . $ownerId . "'",
        "core_user.id <> '" . $ownerId . "'",
        "core_user.type = 'frontend'",
        "core_user.personality = 'legal'"
            ),
                ) ;
    }

    private function showMemberUser ( $requestDataTable, $columns, $ownerId )
    {
        return array (
            'requestDataTble' => $requestDataTable,
            'tableName'       => 'core_user',
            'primaryKey'      => 'core_user.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins          = array (
        'core_user_info' ),
            'whereJoin'       => $whereJoin        = array (
        'core_user_info.core_userid = ' . "core_user.id",
        "core_user.owner_id = '" . $ownerId . "'",
        "core_user.id <> '" . $ownerId . "'",
        "core_user.type = 'frontend'",
        "core_user.personality = 'real'" ),
                ) ;
    }

    public function country ()
    {
        $this->sqlEngine->Select ( 'code,countryName' . $this->lang () . ' as name' )
                ->From ( 'country' )
                ->Run () ;
        return $this->sqlEngine->getRows () ;
    }

    public function city ()
    {
        $codeCountry = $this->request->getParam ( 'country' ) ;

        $this->sqlEngine->Select ( 'id,cityName' . $this->lang () . ' as name' )
                ->From ( 'cityworld' )
                ->Where ( " country = '" . $codeCountry . "'" )
                ->Run () ;
        return $this->sqlEngine->getRows () ;
    }

    public function jobGroup ()
    {
        $this->sqlEngine->Select ( 'id,title' )
                ->From ( 'newsletter_job' )
                ->Run () ;
        return $this->sqlEngine->getRows () ;
    }

    public function userSave ()
    {
        $params = $this->request->getAssocParams () ;

        $editId   = $params[ 'id' ] ;
        $typeUser = $params[ 'typeUser' ] ;
        unset ( $params[ 'id' ] ) ;
        unset ( $params[ 'typeUser' ] ) ;
        $repeat   = $this->sqlEngine->check_unique ( array (
            'table' => 'core_user',
            'check' => array (
                'username' => $params[ 'username' ] ) ) ) ;

        if ( ! $editId )
        {
            if ( ! $repeat )
            {
                $loggedInUserInfo = \f\ttt::dal ( 'core.auth.getLoginInfo' ) ;

                if ( $typeUser === 'mainUser' )
                {
                    $params[ 'owner_id' ] = $loggedInUserInfo[ 'id' ] ;
                }
                else
                {
                    $params[ 'owner_id' ] = $this->getOwner () ;
                }

                $userId = $this->sqlEngine->save ( 'core_user', $params ) ;


//                $ownerId = $typeUser === 'mainUser' ? $this->getOwner() : $userId  ;
//                $this->sqlEngine->save('core_user',
//                                       array ( 'owner_id' => $ownerId ),
//                                       array (
//                    'id=?', array ( $userId )
//                )) ;
                settype ( $userId, 'integer' ) ;
                $out = $userId ? $userId : 'db' ;
            }
            else
            {
                $out = 'repeat' ;
            }
        }
        else
        {
            $out = $this->userEdit ( $params, $editId, $repeat ) ;
        }
        return $out ;
    }

    private function userEdit ( $params, $editId, $repeat )
    {
        unset ( $params[ 'type' ] ) ;
        //\f\pr($params);
        $repeatEdit = $this->sqlEngine->check_unique ( array (
            'table' => 'core_user',
            'check' => array (
                'username' => $params[ 'username' ],
                'id'       => $editId ) ) ) ;
        if ( ( ! $repeat) || ($repeat == 1 && $repeatEdit == 1) )
        {
            $this->sqlEngine->save ( 'core_user', $params,
                                     array (
                'id=?',
                array (
                    $editId )
            ) ) ;
            $this->sqlEngine->remove ( 'core_user_info',
                                       array (
                'core_userid=?',
                array (
                    $editId ) ) ) ;
            $this->sqlEngine->remove ( 'core_user_info_legal',
                                       array (
                'core_userid=?',
                array (
                    $editId ) ) ) ;

            settype ( $editId, 'integer' ) ;
            $out = $editId ;
        }
        else
        {
            $out = 'repeat' ;
        }
        return $out ;
    }

    public function saveReal ()
    {
        return $this->sqlEngine->save ( 'core_user_info',
                                        $this->request->getAssocParams () ) ;
    }

    public function saveLegal ()
    {
        return $this->sqlEngine->save ( 'core_user_info_legal',
                                        $this->request->getAssocParams () ) ;
    }

    public function userInfo ()
    {
        $id     = $this->request->getParam ( 'id' ) ;
        $real   = $this->realUserInfo ( $id ) ? $this->realUserInfo ( $id ) : array () ;
        $legal  = $this->legalUserInfo ( $id ) ? $this->legalUserInfo ( $id ) : array () ;
        $result = array_merge ( $real, $legal ) ;

        $result[ 'id' ] = $id ;
        return $result ;
    }

    public function realUserInfo ( $id = '' )
    {
        $userId = $id ? $id : $this->request->getParam ( 'id' ) ;

        $this->sqlEngine->Select ()
                ->From ( 'core_user AS t1' )
                ->innerJoin ( 'core_user_info AS t2' )
                ->On ( "t1.id = t2.core_userid " )
                ->Where ( " t1.id = '" . $userId . "' " )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function legalUserInfo ( $id = '' )
    {
        $userId = $id ? $id : $this->request->getParam ( 'id' ) ;

        $this->sqlEngine->Select ()
                ->From ( 'core_user AS t1' )
                ->innerJoin ( 'core_user_info_legal AS t2' )
                ->On ( "t1.id = t2.core_userid " )
                ->Where ( " t1.id = '" . $userId . "' " )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function userRemove ()
    {
        $param = ($this->request->getAssocParams () ) ;
        $this->sqlEngine->remove ( 'core_user',
                                   array (
            'id=?',
            array (
                $param[ 'id' ] ) ) ) ;

        return array (
            'func' => 'remove'
                ) ;
    }

    public function userActive ()
    {
        $param  = $this->request->getAssocParams () ;
        $id     = $param[ 'id' ] ;
        $status = $param[ 'status' ] == 'enabled' ? 'disabled' : 'enabled' ;

        $this->sqlEngine->save ( 'core_user',
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

    public function changePasswordInfo ()
    {

        $userId = ($this->request->getParam ( 'id' )) ;

        $this->sqlEngine->Select ()
                ->From ( 'core_user' )
                ->Where ( " id = '" . $userId . "' " )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function viewUser ()
    {
        $userName = ($this->request->getParam ( 'username' )) ;

        $this->sqlEngine->Select ()
                ->From ( 'core_user' )
                ->Where ( " username = '" . $userName . "' " )
                ->Run () ;
        return $this->sqlEngine->getRow () ;
    }

    public function saveChangePassword ()
    {

        $result = $this->sqlEngine->Update ( 'core_user' )
                ->setField ( 'password=?',
                             array (
                    $this->request->getParam ( 'newPassword' ) ) )
                ->where ( 'username=?', $this->request->getParam ( 'username' ) )
                ->Run () ;

        return array (
            'success',
            \f\ifm::t ( 'changed' ) ) ;
    }

    private function lang ()
    {
        return 'Fa' ;
    }

    private function getOwner ()
    {
        $this->registerGadgets ( array (
            'v' => 'validator' ) ) ;
        //$_SESSION[ 'ownerId' ] = '60' ;
        //return $_SESSION[ 'ownerId' ] ;
        return \f\ttt::dal ( 'core.auth.getUserOwner' ) ;
        //$this->dataTable->
    }

    public function getActiveFrontUser ()
    {
        $ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;

        $this->sqlEngine->Select ( 't1.id,t2.name AS realName,t3.name AS legalName,t4.core_userid' )
                ->From ( 'core_user AS t1' )
                ->leftJoin ( 'core_user_info AS t2' )
                ->On ( 't1.id=t2.core_userid' )
                ->leftJoin ( 'core_user_info_legal AS t3' )
                ->On ( 't1.id=t3.core_userid' )
                ->leftJoin ( 'cclub_user AS t4' )
                ->On ( 't1.id=t4.core_userid' )
                ->Where ( 't1.owner_id=?', $ownerId )
                ->andWhere ( 't1.type=?', 'frontend' )
                ->andWhere ( 't1.status=?', 'enabled' )
                ->OrderBy ( 't1.personality ASC' )
                ->Run () ;

        //echo $this->sqlEngine->last_query();

        return $this->sqlEngine->getRows () ;
    }

    public function getIdByUserName2 ()
    {
        $userName = ($this->request->getParam ( 'userName' )) ;

        $this->sqlEngine->Select ( 'id' )
                ->From ( 'core_user' )
                ->Where ( " username = ?", $userName )
                ->Run () ;
        $userInfo = $this->sqlEngine->getRow () ;

        if ( empty ( $userInfo ) )
        {
            return null ;
        }
        return $userInfo[ 'id' ] ;
    }

    public function getSuperadmin ()
    {
        $params = $this->request->getAssocParams () ;

        $this->sqlEngine->Select ()
                ->From ( 'core_user' )
                ->Where ( 'username = ?', $params[ 'username' ] )
                ->andWhere ( 'owner_id is null' )
                ->Run () ;

        return $this->sqlEngine->getRow () ;
    }

    public function getIdByUserName ()
    {
        $userName = ($this->request->getParam ( 'userName' )) ;
        $ownerId  = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;
        $this->sqlEngine->Select ( 'id' )
                ->From ( 'core_user' )
                ->Where ( " username = ?", $userName )
                ->andWhere ( 'owner_id = ?', $ownerId )
                ->Run () ;
        $userInfo = $this->sqlEngine->getRow () ;

        if ( empty ( $userInfo ) )
        {
            return null ;
        }
        return $userInfo[ 'id' ] ;
    }

    public function createEmptyFrontEndUser ()
    {
        $username = $this->request->getParam ( 'username' ) ;

        $this->sqlEngine->save ( 'core_user',
                                 array (
            'username'    => $username,
            'type'        => 'frontend',
            'personality' => 'real',
            'owner_id'    => \f\ttt::service ( 'core.auth.getUserOwner' ),
            'password'    => ''
        ) ) ;

        $userId = $this->sqlEngine->last_id () ;
        return $userId ;
    }

    public function getFrontendUserInfo ()
    {
        $ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;
        $param   = $this->request->getAssocParams () ;

        $this->sqlEngine->Select ()
                ->From ( 'core_user' )
                ->Where ( 'username=?', $param[ 'userName' ] )
                ->andWhere ( 'owner_id=?', $ownerId )
                ->andWhere ( 'type=?', 'frontend' )
                ->Run () ;

        return $this->sqlEngine->getRow () ;
    }

    public function saveUserFromOldSystem ()
    {
        $param   = $this->request->getAssocParams () ;
        $ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;

        $this->sqlEngine->Select ( 't1.*,t2.type' )
                ->From ( 'members AS t1' )
                ->Join ( 'member_group AS t2' )
                ->Where ( 't1.nationalCode=?', $param[ 'userName' ] )
                ->andWhere ( 't1.agencyID=?', $param[ 'agencyId' ] )
                ->andWhere ( 't1.memberGroup=t2.id' )
                ->Run () ;
        $row = $this->sqlEngine->getRow () ;

        $this->sqlEngine->Select ()
                ->From ( 'member_companies' )
                ->Where ( 'mc_manager_code=?', $param[ 'userName' ] )
                ->andWhere ( 'agencyID=?', $param[ 'agencyId' ] )
                ->Run () ;

        $row1    = $this->sqlEngine->getRow () ;
        $company = $this->sqlEngine->numRows () ;

        $personality = ($row[ 'type' ] == 'member' || $company == 0) ? 'real' : 'legal' ;

        $this->sqlEngine->save ( 'core_user',
                                 array (
            'owner_id'    => $ownerId,
            'username'    => $row[ 'nationalCode' ],
            'password'    => $row[ 'password' ],
            'regdate'     => date ( 'Y-m-d H:i:s' ),
            'status'      => 'enabled',
            'type'        => 'frontend',
            'personality' => $personality,
        ) ) ;

        $id = $this->sqlEngine->last_id () ;



        if ( $personality == 'real' )
        {
            $this->sqlEngine->save ( 'core_user_info',
                                     array (
                'core_userid' => $id,
                'name'        => $row[ 'firstName' ] . ' ' . $row[ 'lastName' ],
                'email'       => $row[ 'email' ],
                'phone'       => $row[ 'phone' ],
                'mobile'      => $row[ 'mobile' ],
                'fax'         => $row[ 'fox' ],
                'birthday'    => date ( 'Y-m-d', $row[ 'birthday' ] )
            ) ) ;
        }
        else
        {
            $this->sqlEngine->save ( 'core_user_info_legal',
                                     array (
                'core_userid' => $id,
                'name'        => $row1[ 'mc_companyName' ],
                'ceo'         => $row1[ 'mc_manager_first_name' ] . ' ' . $row1[ 'mc_manager_last_name' ],
                'phone'       => $row1[ 'mc_phone' ],
                'ceo_mobile'  => $row1[ 'mc_manager_mobile' ],
                'address'     => $row1[ 'mc_address' ],
                'email'       => $row1[ 'mc_manager_email' ]
            ) ) ;
        }
    }

    public function updatePassword ()
    {
        $param   = $this->request->getAssocParams () ;
        $ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;

        $this->sqlEngine->Select ( 'password' )
                ->From ( 'members' )
                ->Where ( 'nationalCode=?', $param[ 'userName' ] )
                ->andWhere ( 'agencyID=?', $param[ 'agencyId' ] )
                ->Run () ;
        $row = $this->sqlEngine->getRow () ;

        $result = $this->sqlEngine->Update ( 'core_user' )
                ->setField ( 'password=?',
                             array (
                    $row[ 'password' ] ) )
                ->where ( 'username=?', $param[ 'userName' ] )
                ->Run () ;
    }

    public function registerLegacyMainUser ()
    {
        $username = $this->request->getParam ( 'agencyID' ) ;
        $password = $this->request->getParam ( 'password' ) ;

        $this->sqlEngine->save ( 'core_user',
                                 array (
            'owner_id'    => 29, # admin
            'username'    => $username,
            'password'    => $password,
            'regdate'     => date ( 'Y-m-d H:i:s' ),
            'status'      => 'enabled',
            'type'        => 'backend',
            'personality' => 'real'
        ) ) ;

        $userId = $this->sqlEngine->last_id () ;

        $this->sqlEngine->save ( 'core_user_info',
                                 array (
            'name'        => $username,
            'core_userid' => $userId
        ) ) ;
    }

    public function registerLegacyFrontUser ()
    {
        $params   = $this->request->getAssocParams () ;
        $username = $params[ 'nationalCode' ] ;
        $password = $params[ 'password' ] ;
        $ownerId  = $params[ 'ownerId' ] ;

        $this->sqlEngine->save ( 'core_user',
                                 array (
            'owner_id'    => $ownerId,
            'username'    => $username,
            'password'    => $password,
            'regdate'     => date ( 'Y-m-d H:i:s' ),
            'status'      => 'enabled',
            'type'        => 'frontend',
            'personality' => 'real'
        ) ) ;

        $userId = $this->sqlEngine->last_id () ;

        $this->sqlEngine->save ( 'core_user_info',
                                 array (
            'name'           => $params[ 'firstName' ] . ' ' . $params[ 'lastName' ],
            'gender'         => $params[ 'gender' ],
            'marital_status' => $params[ 'marital_status' ],
            'marriage_date'  => $params[ 'marriage_date' ],
            'email'          => $params[ 'email' ],
            'phone'          => $params[ 'phone' ],
            'mobile'         => $params[ 'mobile' ],
            'fax'            => $params[ 'fax' ],
            'birthday'       => $params[ 'birthdayGa' ],
            'company'        => $params[ 'company' ],
            'core_userid'    => $userId
        ) ) ;
    }

    public function getUserByOwnerId ()
    {
        $ownerId = \f\ttt::dal ( 'core.auth.getUserOwner' ) ;
        $this->sqlEngine->Select ( 't1.id,t2.name,t3.name AS name_legal,t1.profile_pic' )
                ->From ( 'core_user AS t1' )
                ->leftJoin ( 'core_user_info AS t2' )
                ->On ( 't1.id=t2.core_userid' )
                ->leftJoin ( 'core_user_info_legal AS t3' )
                ->On ( 't1.id=t3.core_userid' )
                ->Where ( '( t1.owner_id=?', $ownerId )
                ->orWhere ( 't1.id=? )', $ownerId )
                ->andWhere ( 't1.type=?', 'backend' )
                ->Run () ;

        return $this->sqlEngine->getRows () ;
    }

}
