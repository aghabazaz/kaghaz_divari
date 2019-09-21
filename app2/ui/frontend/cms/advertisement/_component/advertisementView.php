<?php

class advertisementView extends \f\view
{

    public function __construct ()
    {

    }

    public function renderGetAdvertisementList ( $param )
    {

        $row = \f\ttt::service( 'cms.content.getAdvertisementList',
            $param
            ,true );
        if ( $param['type'] == 'main' )
        {
            return $this->render( 'mainAdvertisement',
                [
                    'row' => $row ] );
        } else
        {
            return $this->render( 'contentList_1',
                [
                    'row' => $row ] );
        }
    }

    public function renderAdvertise ( $param )
    {
        $this->registerGadgets( [
            'dateG' => 'date' ] );
        $param['date'] = $this->dateG->today();
        $row           = \f\ttt::dal( 'cms.advertisement.getListAdvertise',
            $param,true );
        //\f\pr($row);
        return $this->render( 'advertise',
            [
                'row'  => $row,
                'plan' => $param['plan']
            ] );
    }

    public function renderGetSocialAdvertise ( $param )
    {
        $this->registerGadgets( [
            'dateG' => 'date' ] );
        $param['today'] = $this->dateG->today();
        $row           = \f\ttt::dal( 'cms.advertisement.getListSocialAdvertise',
            $param,true );
       //\f\pre($param);
        if ( $param['plan2'] )
        {
            if ( $param['plan'] == 'A' )
            {
                $this->registerGadgets(array(
                    'dateG' => 'date'));
                $todayDate = $this->dateG->today();
                $amazingProducts = \f\ttt::service('shop.product.getAmazingProducts',
                    array(
                        'today' => $todayDate,
                        'limit' => $param['limit']));
                if(!empty($amazingProducts[0])){
                    $resultShow=true;
                }else{
                    $resultShow=false;
                }
                return $this->render( 'socialAdvertiseTop',
                    [
                        'row'        => $row,
                        'plan'       => $param['plan'],
                        'resultShow' => $resultShow
                        ] );

            }elseif($param['plan']=='B'){
                //\f\pr($row);
                return $this->render( 'advertise',
                    [
                        'row'        => $row,
                        'plan'       => $param['plan'],
                    ] );
            }elseif($param['plan']=='C'){
                return $this->render( 'socialAdvertise',
                    [
                        'row' => $row,
                    ] );
            } else
            {

                return $this->render( 'socialAdvertise',
                    [
                        'row'        => $row,
                        'plan'       => $param['plan'],
                    ] );
            }
        }

        //\f\pre($adverA['0']);
    }

    public function renderGetAdvertisementDetail ( $params )
    {
        $advertisementList       = \f\ttt::service( 'cms.advertisement.getAdvertisementList',
            [
                'status' => 'enabled',
                'limit'  => 5
            ],true );
        $advertisementDetailList = \f\ttt::service( 'cms.advertisement.getAdvertisementDetail',
            [
                'status' => 'enabled',
                'limit'  => 5,
                'id'     => $params
            ],true );
        //\f\pr($advertisementList);
        return $this->render( 'advertisementDetail',
            [
                'advertisementDetailList' => $advertisementDetailList,
                'advertisementList'       => $advertisementList[0],
            ] );
    }

    public function renderAdvertisementListDetail ( $params )
    {
        if ( $params[0] == 'page' )
        {
            $page = $params[1];
        }
        $numPerPage = 10;
        if ( !$page )
        {
            $page = 1;
        }
        $advertisementList = \f\ttt::service( 'cms.advertisement.getAdvertisementList',
            [
                'status'   => 'enabled',
                'limit'    => 5,
                'num_page' => $numPerPage,
                'page'     => $page
            ],true );

        $row = $advertisementList[0];
        $num = $advertisementList[1];
        return $this->render( 'advertisementList',
            [
                'advertisementList' => $row,
                'num'               => $num,
                'num_page'          => $numPerPage,
                'page'              => $page,
            ] );
    }

    public function filePath ( $path )
    {
        $path = \f\ifm::app()->siteUrl . 'upload/' . ( str_replace( '-','.',
                str_replace( '.',
                    '/',
                    $path ) ) );
        return $path;
    }

    public function renderAdvertisementList ()
    {
        $advertisementList = \f\ttt::service( 'cms.advertisement.getAdvertisementList',
            [
                'status' => 'enabled',
                'limit'  => 5
            ],true );
        //\f\pre($advertisementList);
        return $this->render( 'advertisement',
            [
                'advertisementList' => $advertisementList[0],
            ] );
    }

    public function renderGetPersonnel ( $params )
    {
        $row = \f\ttt::service( 'cms.advertisement.personnel.getPersonnelByParam',
            $params );

        //\f\pre($params);
        return $this->render( 'personnel',
            [
                'row' => $row
            ]
        );
    }

}
