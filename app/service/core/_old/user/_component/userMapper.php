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
    public function __construct()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
        $this->dataTable = \f\dalFactory::make('core.dataTable') ;

        $this->data_table            = 'core_user' ;
        $this->data_table_info       = 'core_user_info' ;
        $this->data_table_info_legal = 'core_user_info_legal' ;
        $this->country_table         = 'country' ;
        $this->city_table            = 'cityworld' ;
        $this->job_table             = 'newsletter_job' ;
    }

    public function defaultGetList()
    {
        $pr               = $this->request->getAssocParams() ;
        $requestDataTable = $pr[ 'dataTableParams' ] ; //$this->request->getParam( 'dataTableParams' ) ;
        $param            = $pr[ 'param' ] ; //$this->request->getParam('param');
        $ownerId          = $this->getOwner() ; //$this->request->getParam('ownerId');
        //\f\pr($requestDataTable);
        $tableJoin        = ($param == 'colleagueUser') ? $this->data_table_info_legal : $this->data_table_info ;

        $columns = array (
            array (
                'db' => $this->data_table . '.id', //column name selected
                'dt' => 0, //column num
            ),
            array (
                'db' => $this->data_table . '.status',
                'dt' => 1,
            ),
            array (
                'db' => $tableJoin . '.name',
                'dt' => 2,
            ),
            array (
                'db' => $tableJoin . '.phone',
                'dt' => 3,
            ),
            array (
                'db' => $tableJoin . '.email',
                'dt' => 4,
            ),
                ) ;

        switch ( $param )
        {
            case 'mainUser':
                $result = $this->showMainUser($requestDataTable) ;
                $out    = $this->dataTable->getDataMultipleTable($result) ;
                break ;
            case 'siteUser':
                $result = $this->showSiteUser($requestDataTable, $columns,
                                              $ownerId) ;
                $out    = $this->dataTable->getDataTable($result) ;
                break ;
            case 'colleagueUser':
                $result = $this->showColleagueUser($requestDataTable, $columns,
                                                   $ownerId) ;
                $out    = $this->dataTable->getDataTable($result) ;
                break ;
            case 'memberUser':
                $result = $this->showMemberUser($requestDataTable, $columns,
                                                $ownerId) ;
                $out    = $this->dataTable->getDataTable($result) ;
                break ;
        }

        return $out ;
    }

    private function showMainUser($requestDataTable)
    {
        $arrInfo = array ( $this->realUserShowInfo(), $this->legalUserShowInfo() ) ;

        return array (
            'requestDataTble' => $requestDataTable,
            'arrInfo'         => $arrInfo,
            'searchTxt'       => $search           = '',
            'limit'           => $limit            = ''
                ) ;
    }

    private function realUserShowInfo()
    {
        return array (
            "tablename"      => $this->data_table,
            "column"         => array (
                $this->data_table      => array (
                    "id"     => "id",
                    "status" => "status",
                ),
                $this->data_table_info => array (
                    "name"  => "name",
                    "phone" => "phone",
                    "email" => "email",
                )
            ),
            "join"           => array (
                array (
                    "typeJoin"      => 'inner',
                    "table"         => $this->data_table_info,
                    "on"            => $this->data_table_info . ".core_userid = " . $this->data_table . ".id",
                    "searchingJoin" => array ( 'name', 'email' )
                ) ),
            "mainWhere"      => "(" . $this->data_table . ".owner_id = " . $this->data_table . ".id AND " . $this->data_table . ".type = 'backend' )",
            "searchingBy"    => array (
                "id"
            ),
            "searchinglevel" => array (
                "name"  => 1,
                "email" => 2 ),
                ) ;
    }

    private function legalUserShowInfo()
    {
        return array (
            "tablename"      => $this->data_table,
            "column"         => array (
                $this->data_table            => array (
                    "id"     => "id",
                    "status" => "status"
                ),
                $this->data_table_info_legal => array (
                    "name"  => "name",
                    "phone" => "phone",
                    "email" => "email",
                )
            ),
            "join"           => array (
                array (
                    "typeJoin"      => 'inner',
                    "table"         => $this->data_table_info_legal,
                    "on"            => $this->data_table_info_legal . ".core_userid = " . $this->data_table . ".id",
                    "searchingJoin" => array ( 'name', 'email' )
                ) ),
            "mainWhere"      => "(" . $this->data_table . ".owner_id = " . $this->data_table . ".id AND " . $this->data_table . ".type = 'backend')",
            "searchingBy"    => array (
                "id"
            ),
            "searchinglevel" => array (
                "name"  => 1,
                "email" => 2 ),
                ) ;
        //$this->dataTable->
    }

    private function showSiteUser($requestDataTable, $columns, $ownerId)
    {
        return array (
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->data_table,
            'primaryKey'      => $this->data_table . '.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins          = array (
        $this->data_table_info ),
            'whereJoin'       => $whereJoin        = array (
        $this->data_table_info . '.core_userid = ' . $this->data_table . '.id', $this->data_table . ".owner_id = '" . $ownerId . "'",
        $this->data_table . ".id <> '" . $ownerId . "'", $this->data_table . ".type = 'backend'" ),
                ) ;
    }

    private function showColleagueUser($requestDataTable, $columns, $ownerId)
    {
        return array (
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->data_table,
            'primaryKey'      => $this->data_table . '.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins          = array (
        $this->data_table_info_legal ),
            'whereJoin'       => $whereJoin        = array (
        $this->data_table_info_legal . '.core_userid = ' . $this->data_table . '.id',
        $this->data_table . ".owner_id = '" . $ownerId . "'", $this->data_table . ".id <> '" . $ownerId . "'",
        $this->data_table . ".type = 'frontend'", $this->data_table . ".personality = 'legal'" ),
                ) ;
    }

    private function showMemberUser($requestDataTable, $columns, $ownerId)
    {
        return array (
            'requestDataTble' => $requestDataTable,
            'tableName'       => $this->data_table,
            'primaryKey'      => $this->data_table . '.id',
            'columnsArray'    => $columns,
            'tableJoinName'   => $tbjoins          = array (
        $this->data_table_info ),
            'whereJoin'       => $whereJoin        = array (
        $this->data_table_info . '.core_userid = ' . $this->data_table . '.id', $this->data_table . ".owner_id = '" . $ownerId . "'",
        $this->data_table . ".id <> '" . $ownerId . "'", $this->data_table . ".type = 'frontend'",
        $this->data_table . ".personality = 'real'" ),
                ) ;
    }

    public function country()
    {
        $this->sqlEngine->Select('code,countryName' . $this->lang() . ' as name')
                ->From($this->country_table)
                ->Run() ;
        return $this->sqlEngine->getRows() ;
    }

    public function city()
    {
        $codeCountry = $this->request->getParam('country') ;

        $this->sqlEngine->Select('id,cityName' . $this->lang() . ' as name')
                ->From($this->city_table)
                ->Where(" country = '" . $codeCountry . "'")
                ->Run() ;
        return $this->sqlEngine->getRows() ;
    }

    public function jobGroup()
    {
        $this->sqlEngine->Select('id,title')
                ->From($this->job_table)
                ->Run() ;
        return $this->sqlEngine->getRows() ;
    }

    public function userSave()
    {
        $params = $this->request->getAssocParams() ;

        $editId   = $params[ 'id' ] ;
        $typeUser = $params[ 'typeUser' ] ;
        unset($params[ 'id' ]) ;
        unset($params[ 'typeUser' ]) ;
        $repeat   = $this->sqlEngine->check_unique(array ( 'table' => $this->data_table,
            'check' => array ( 'username' => $params[ 'username' ] ) )) ;

        if ( ! $editId )
        {
            if ( ! $repeat )
            {
                $userId  = $this->sqlEngine->save($this->data_table, $params) ;
                $ownerId = ($typeUser == 'mainUser') ? $userId : $this->getOwner() ;
                $this->sqlEngine->save($this->data_table,
                                       array ( 'owner_id' => $ownerId ),
                                       array (
                    'id=?', array ( $userId )
                )) ;
                settype($userId, 'integer') ;
                $out     = $userId ? $userId : 'db' ;
            }
            else
            {
                $out = 'repeat' ;
            }
        }
        else
        {
            $out = $this->userEdit($params, $editId, $repeat) ;
        }
        return $out ;
    }

    private function userEdit($params, $editId, $repeat)
    {
        unset($params[ 'type' ]) ;
        $repeatEdit = $this->sqlEngine->check_unique(array ( 'table' => $this->data_table,
            'check' => array ( 'username' => $params[ 'username' ], 'id' => $editId ) )) ;
        if ( ( ! $repeat) || ($repeat == 1 && $repeatEdit == 1) )
        {
            $this->sqlEngine->save($this->data_table, $params,
                                   array (
                'id=?', array ( $editId )
            )) ;
            $this->sqlEngine->remove($this->data_table_info,
                                     array ( 'core_userid=?', array ( $editId ) )) ;
            $this->sqlEngine->remove($this->data_table_info_legal,
                                     array ( 'core_userid=?', array ( $editId ) )) ;

            settype($editId, 'integer') ;
            $out = $editId ;
        }
        else
        {
            $out = 'repeat' ;
        }
        return $out ;
    }

    public function saveReal()
    {
        return $this->sqlEngine->save($this->data_table_info,
                                      $this->request->getAssocParams()) ;
    }

    public function saveLegal()
    {
        return $this->sqlEngine->save($this->data_table_info_legal,
                                      $this->request->getAssocParams()) ;
    }

    public function userInfo()
    {
        $id     = $this->request->getParam('id') ;
        $real   = $this->realUserInfo($id) ? $this->realUserInfo($id) : array () ;
        $legal  = $this->legalUserInfo($id) ? $this->legalUserInfo($id) : array () ;
        $result = array_merge($real, $legal) ;

        $result[ 'id' ] = $id ;
        return $result ;
    }

    public function realUserInfo($id = '')
    {
        $userId = $id ? $id : $this->request->getParam('id') ;

        $this->sqlEngine->Select()
                ->From($this->data_table . ' AS t1')
                ->innerJoin($this->data_table_info . ' AS t2')
                ->On("t1.id = t2.core_userid ")
                ->Where(" t1.id = '" . $userId . "' ")
                ->Run() ;
        return $this->sqlEngine->getRow() ;
    }

    public function legalUserInfo($id = '')
    {
        $userId = $id ? $id : $this->request->getParam('id') ;

        $this->sqlEngine->Select()
                ->From($this->data_table . ' AS t1')
                ->innerJoin($this->data_table_info_legal . ' AS t2')
                ->On("t1.id = t2.core_userid ")
                ->Where(" t1.id = '" . $userId . "' ")
                ->Run() ;
        return $this->sqlEngine->getRow() ;
    }

    public function userRemove()
    {

        $this->sqlEngine->remove($this->data_table,
                                 array ( 'id=?', array ( $this->request->getParam('id') ) )) ;

        return array (
            'func' => 'remove'
                ) ;
    }

    public function userActive()
    {

        $status = ($this->request->getParam('status') == "enabled") ? 'disabled' : 'enabled' ;

        $this->sqlEngine->Update($this->data_table)
                ->setField('status=?', array ( $status ))
                ->where('id=?', $this->request->getParam('id'))
                ->Run() ;
        return array ( 'status' => $status ) ;
    }

    public function changePasswordInfo()
    {

        $userId = ($this->request->getParam('id')) ;

        $this->sqlEngine->Select()
                ->From($this->data_table)
                ->Where(" id = '" . $userId . "' ")
                ->Run() ;
        return $this->sqlEngine->getRow() ;
    }

    public function viewUser()
    {
        $userName = ($this->request->getParam('username')) ;

        $this->sqlEngine->Select()
                ->From($this->data_table)
                ->Where(" username = '" . $userName . "' ")
                ->Run() ;
        return $this->sqlEngine->getRow() ;
    }

    public function saveChangePassword()
    {

        $result = $this->sqlEngine->Update($this->data_table)
                ->setField('password=?',
                           array ( $this->request->getParam('newPassword') ))
                ->where('username=?', $this->request->getParam('username'))
                ->Run() ;

        return array ( 'success', \f\ifm::t('changed') ) ;
    }

    private function lang()
    {
        return 'Fa' ;
    }

    private function getOwner()
    {
        $this->registerGadgets(array ( 'v' => 'validator' )) ;
        //$_SESSION[ 'ownerId' ] = '60' ;
        //return $_SESSION[ 'ownerId' ] ;
        return \f\ttt::dal('core.auth.getUserOwner') ;
        //$this->dataTable->
    }

    public function getActiveFrontUser()
    {
        $ownerId = \f\ttt::dal('core.auth.getUserOwner') ;

        $this->sqlEngine->Select('t1.id,t2.name AS realName,t3.name AS legalName,t4.core_userid')
                ->From('core_user AS t1')
                ->leftJoin('core_user_info AS t2')
                ->On('t1.id=t2.core_userid')
                ->leftJoin('core_user_info_legal AS t3')
                ->On('t1.id=t3.core_userid')
                ->leftJoin('cclub_user AS t4')
                ->On('t1.id=t4.core_userid')
                ->Where('t1.owner_id=?', $ownerId)
                ->andWhere('t1.type=?', 'frontend')
                ->andWhere('t1.status=?', 'enabled')
                ->OrderBy('t1.personality ASC')
                ->Run() ;

        //echo $this->sqlEngine->last_query();

        return $this->sqlEngine->getRows() ;
    }

    public function getIdByUserName()
    {
        $userName = ($this->request->getParam('userName')) ;

        $this->sqlEngine->Select('id')
                ->From('core_user')
                ->Where(" username = ?", $userName)
                ->Run() ;
        $userInfo = $this->sqlEngine->getRow() ;
        return $userInfo[ 'id' ] ;
    }

    public function createEmptyFrontEndUser()
    {
        $username = $this->request->getParam('username') ;

        $this->sqlEngine->save('core_user',
                               array (
            'username'    => $username,
            'type'        => 'frontend',
            'personality' => 'real',
            'owner_id'    => \f\ttt::service('core.auth.getUserOwner'),
            'password'    => ''
        )) ;

        $userId = $this->sqlEngine->last_id() ;
        return $userId ;
    }

    public function getFrontendUserInfo()
    {
        $ownerId = \f\ttt::dal('core.auth.getUserOwner') ;
        $param   = $this->request->getAssocParams() ;

        $this->sqlEngine->Select()
                ->From('core_user')
                ->Where('username=?', $param[ 'userName' ])
                ->andWhere('owner_id=?', $ownerId)
                ->andWhere('type=?', 'frontend')
                ->Run() ;

        return $this->sqlEngine->getRow() ;
    }

    public function saveUserFromOldSystem()
    {
        $param   = $this->request->getAssocParams() ;
        $ownerId = \f\ttt::dal('core.auth.getUserOwner') ;

        $this->sqlEngine->Select('t1.*,t2.type')
                ->From('members AS t1')
                ->Join('member_group AS t2')
                ->Where('t1.nationalCode=?', $param[ 'userName' ])
                ->andWhere('t1.agencyID=?', $param[ 'agencyId' ])
                ->andWhere('t1.memberGroup=t2.id')
                ->Run() ;
        $row = $this->sqlEngine->getRow() ;

        $this->sqlEngine->Select()
                ->From('member_companies')
                ->Where('mc_manager_code=?', $param[ 'userName' ])
                ->andWhere('agencyID=?', $param[ 'agencyId' ])
                ->Run() ;

        $row1    = $this->sqlEngine->getRow() ;
        $company = $this->sqlEngine->numRows() ;

        $personality = ($row[ 'type' ] == 'member' || $company == 0) ? 'real' : 'legal' ;

        $this->sqlEngine->save('core_user',
                               array (
            'owner_id'    => $ownerId,
            'username'    => $row[ 'nationalCode' ],
            'password'    => $row[ 'password' ],
            'regdate'     => date('Y-m-d H:i:s'),
            'status'      => 'enabled',
            'type'        => 'frontend',
            'personality' => $personality,
        )) ;

        $id = $this->sqlEngine->last_id() ;



        if ( $personality == 'real' )
        {
            $this->sqlEngine->save('core_user_info',
                                   array (
                'core_userid' => $id,
                'name'        => $row[ 'firstName' ] . ' ' . $row[ 'lastName' ],
                'email'       => $row[ 'email' ],
                'phone'       => $row[ 'phone' ],
                'mobile'      => $row[ 'mobile' ],
                'fax'         => $row[ 'fox' ],
                'birthday'    => date('Y-m-d', $row[ 'birthday' ])
            )) ;
        }
        else
        {
            $this->sqlEngine->save('core_user_info_legal',
                                   array (
                'core_userid' => $id,
                'name'        => $row1[ 'mc_companyName' ],
                'ceo'         => $row1[ 'mc_manager_first_name' ] . ' ' . $row1[ 'mc_manager_last_name' ],
                'phone'       => $row1[ 'mc_phone' ],
                'ceo_mobile'  => $row1[ 'mc_manager_mobile' ],
                'address'     => $row1[ 'mc_address' ],
                'email'       => $row1[ 'mc_manager_email' ]
            )) ;
        }
    }

}
