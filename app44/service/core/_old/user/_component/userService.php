<?php

/**
 * This component detects modules/components/plugins/legacy from
 * project source code structure and manages them.
 * 
 * @package \chartex\core\user
 * @category component
 * @author Akram Gharakhani <akramgharakhani@yahoo.com>
 */
class userService extends \f\service
{

    public function getUsers()
    {
        return \f\ttt::dal('core.user.defaultGetList',
                           $this->request->getAssocParams()) ;
    }

    public function getCountry()
    {
        return \f\ttt::dal('core.user.country') ;
    }

    public function getCity()
    {
        return \f\ttt::dal('core.user.city',
                           array ( 'country' => $this->request->getParam('country') )) ;
    }

    public function getJobGroup()
    {
        return \f\ttt::dal('core.user.jobGroup') ;
    }

    public function userSave()
    {
        $params = $this->request->getAssocParams() ;
        $valid  = $this->valid($params) ;
        if ( ! is_array($valid) )
        {
            $result = $this->saveMain($params) ;
            if ( is_int($result) )
            {
                $userId = $result ;
                if ( $params[ 'personality' ] == 'real' )
                {
                    $this->saveReal($params, $userId) ;
                }
                else
                {
                    $this->saveLegal($params, $userId) ;
                }
                $message = ($params [ 'id' ]) ? \f\ifm::t('userEditSuccess') : \f\ifm::t('userSaveSuccess') ;
                $out     = array ( 'success', $message ) ;
            }
            else
            {
                $out = array ( 'error', $result ) ;
            }
        }
        else
        {
            $out = array ( 'error', $valid ) ;
        }
        return $out ;
    }

    private function saveMain($params)
    {
        /* @var $coding \f\g\coding */
        $coding = \f\gadgetFactory::make('coding') ;

        /* @var $date \f\g\date */
        $date = \f\gadgetFactory::make('date') ;

        if ( $params[ 'typeUser' ] == 'mainUser' || $params[ 'typeUser' ] == 'siteUser' )
        {
            $type = 'backend' ;
        }
        else if ( $params[ 'typeUser' ] == 'memberUser' || $params[ 'typeUser' ] == 'colleagueUser' )
        {
            $type = 'frontend' ;
        }

        $updateArray = array (
            'id'          => $params [ 'id' ] ? $params [ 'id' ] : '',
            'personality' => $params [ 'personality' ],
            'username'    => $params [ 'username' ],
            'profile_pic' => $params[ 'profilePic' ],
            'expire_date' => $date->dateJaToGr($params [ 'expire_date' ], 1), //$date->dateTime($date->timeDate($params [ 'expire_date' ], 2), 1)
            'status'      => 'enabled',
            'type'        => $type
                ) ;
        if ( $params [ 'password' ] )
        {
            $updateArray[ 'password' ] = $coding->encode($params [ 'password' ]) ;
        }
        $updateArray[ 'typeUser' ] = $params [ 'typeUser' ] ;
        return \f\ttt::dal('core.user.userSave', $updateArray) ;
    }

    private function saveReal($params, $userId)
    {
        /* @var $date \f\g\date */
        $date = \f\gadgetFactory::make('date') ;

        $updateArray = array (
            'name'        => $params[ 'nameReal' ],
            'father_name' => $params[ 'fatherName' ],
            'gender'      => $params[ 'gender' ],
            'email'       => $params[ 'email' ],
            'mobile'      => $params[ 'mobile' ],
            'phone'       => $params[ 'phone' ],
            'fax'         => $params[ 'fax' ],
            'country_id'  => $params[ 'country_id' ],
            'city_id'     => $params[ 'city_id' ],
            'address'     => $params[ 'address' ],
            'postal_code' => $params[ 'postal_code' ],
            'birthday'    => $date->dateJaToGr($params [ 'birthday' ], 1),
            'job_group'   => $params[ 'job_group' ],
            'job'         => $params[ 'job' ],
            'company'     => $params[ 'company' ],
            'degree'      => $params[ 'degree' ],
            'study'       => $params[ 'study' ],
            'core_userid' => $userId
                ) ;
        return \f\ttt::dal('core.user.saveReal', $updateArray) ;
    }

    private function saveLegal($params, $userId)
    {
        /* @var $date \f\g\date */
        $date = \f\gadgetFactory::make('date') ;

        $updateArray = array (
            'name'          => $params[ 'nameLegal' ],
            'activity_type' => $params[ 'activityType' ],
            'reg'           => $params[ 'reg' ],
            'reg_date'      => $date->dateJaToGr($params [ 'regDate' ], 1),
            'ceo'           => $params[ 'ceo' ],
            'email'         => $params[ 'email' ],
            'website'       => $params[ 'website' ],
            'ceo_mobile'    => $params[ 'mobile' ],
            'phone'         => $params[ 'phone' ],
            'fax'           => $params[ 'fax' ],
            'country_id'    => $params[ 'country_id' ],
            'city_id'       => $params[ 'city_id' ],
            'address'       => $params[ 'address' ],
            'postal_code'   => $params[ 'postal_code' ],
            'core_userid'   => $userId
                ) ;
        return \f\ttt::dal('core.user.saveLegal', $updateArray) ;
    }

    private function valid($params)
    {
        /* @var $validator \f\g\validator */
        $validator   = \f\gadgetFactory::make('validator') ;
        $paramGroupV = array (
            'defult'  => array (
                array (
                    'rule' => 'checkEmpty'
                )
            ),
            'objects' => array (
                array (
                    'rule'   => array (
                        array (
                            'name' => 'mobile'
                        )
                    ),
                    'object' => array ( $params[ 'mobile' ] )
                ),
                array (
                    'rule'   => array (
                        array (
                            'name' => 'email'
                        )
                    ),
                    'object' => array ( $params [ 'email' ] )
                ),
                array (
                    'rule'   => array (
                        array (
                            'name'  => 'password',
                            'range' => array (
                                'min' => 4
                            )
                        )
                    ),
                    'object' => array ( $params[ 'password' ] )
                )
            )
                ) ;
        if ( $validator->group($paramGroupV) === false )
        {
            return $validator->getMessage() ;
        }
        else
        {
            return true ;
        }
    }

    public function getUserInfo()
    {
        return \f\ttt::dal('core.user.userInfo',
                           array ( 'id' => $this->request->getParam('id') )) ;
    }

    public function changePasswordInfo()
    {
        return \f\ttt::dal('core.user.changePasswordInfo',
                           array ( 'id' => $this->request->getParam('id') )) ;
    }

    public function saveChangePassword()
    {
        /* @var $coding \f\g\coding */
        $coding = \f\gadgetFactory::make('coding') ;
        $params = $this->request->getAssocParams() ;

        $row = \f\ttt::dal('core.user.viewUser', $params) ;

        $password = md5(sha1(md5($params[ 'password' ]))) ;
        $salt1    = substr($row[ 'password' ], 0, 9) ;
        $salt2    = substr($row[ 'password' ], -5) ;
        $password = $salt1 . $password . $salt2 ;

        $params[ 'newPassword' ] = $coding->encode($params [ 'newPassword' ]) ;
        if ( $password === $row[ 'password' ] )
        {
            return \f\ttt::dal('core.user.saveChangePassword', $params) ;
        }
        else
        {
            return array ( 'error', \f\ifm::t('oldPasswordIncorect') ) ;
        }
    }

    public function userRemove()
    {
        return \f\ttt::dal('core.user.userRemove',
                           array ( 'id' => $this->request->getParam('id') )) ;
    }

    public function userActive()
    {
        return \f\ttt::dal('core.user.userActive',
                           array ( 'id' => $this->request->getParam('id'), 'status' => $this->request->getParam('status') )) ;
    }

    public function getActiveFrontUser()
    {
        return \f\ttt::dal('core.user.getActiveFrontUser', array ()) ;
    }

    public function getIdByUserName()
    {

        return \f\ttt::dal('core.user.getIdByUserName',
                           array ( 'userName' => $this->request->getParam('userName') )) ;
    }

    public function getFrontendUserInfo()
    {
        $userInfo = \f\ttt::dal('core.user.getFrontendUserInfo',
                                $this->request->getAssocParams()) ;
        return $userInfo ;
    }

    public function saveUserFromOldSystem()
    {
        \f\ttt::dal('core.user.saveUserFromOldSystem',
                    $this->request->getAssocParams()) ;
    }

    public function signUp()
    {

        $userOwnerId = \f\ttt::dal('core.user.getIdByUserName',
                                   array (
                    'userName' => $this->request->getParam('agencyId')
                )) ;

        $this->registerGadgets(array (
            'codingG' => 'coding'
        )) ;

        # If main user not exists then register it
        if ( empty($userOwnerId) )
        {

            \f\ttt::dal('core.user.registerLegacyMainUser',
                        array (
                'agencyID' => $this->request->getParam('agencyId'),
                'password' => $this->codingG->encode('raz@22')
            )) ;

            $userOwnerId = \f\ttt::dal('core.user.getIdByUserName',
                                       array (
                        'userName' => $this->request->getParam('agencyId')
                    )) ;
        }

        $unencodedPassword = $this->request->getParam('password') ;
        $password          = $this->codingG->encode($unencodedPassword) ;

        $userArray = $this->request->getAssocParams() ;

        $userArray[ 'password' ] = $password ;
        $userArray[ 'ownerId' ]  = $userOwnerId ;
        return \f\ttt::dal('core.user.registerLegacyFrontUser', $userArray) ;
//
//        $this->propagateRegister(array (
//            'nationalCode' => $this->request->getParam('nationalCode')
//        )) ;
//
//        //up password
//        \f\ttt::dal('core.user.updatePassword',
//                    array (
//            'userName' => $this->request->getParam('nationalCode'),
//            'agencyId' => $this->request->getParam('agencyId')
//        )) ;
    }

    private function propagateRegister($userArray)
    {
        # Standardization the Register activity record,
        # This is because all softwares can process the activity 
        # in a general way.

        $activity = array () ;

        $activity[ 'nationalID' ] = $userArray[ 'nationalCode' ] ;
        $activity[ 'date' ]       = time() ;

        # Propagating the standarded event
        \f\ifm::propagate(array (
            'path'      => 'core.user.signUp',
            'eventName' => 'register',
            'signal'    => $activity
        )) ;
    }

}
