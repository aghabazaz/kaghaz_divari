<?php

class settingMapper extends \f\dal
{

    public function __construct()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
    }

    public function getKey()
    {
        $key    = $this->request->getParam('key') ;
        $params = $this->request->getParam('params') ;

        $stringifyParams = $this->stringifyParamValues($params) ;

        $paramsLike = $this->paramsToLike($stringifyParams) ;

        $this->sqlEngine->Select()
                ->From('core_setting')
                ->Where("`key` = ? and $paramsLike", $key)
                ->Run() ;

        $keyValueRecord = $this->sqlEngine->getRow() ;

        return array (
            'key'   => $keyValueRecord[ 'key' ],
            'value' => $keyValueRecord[ 'value' ]
                ) ;
    }

    private function paramsToLike($params)
    {
        $like = '' ;
        $i    = 0 ;
        foreach ( $params as $key => $value )
        {
            $like .= "params like '%\"$key\":\"$value\"%'" ;
            if ( ++ $i < count($params) )
            {
                $like .= ' and ' ;
            }
        }
        return $like ;
    }

    private function stringifyParamValues($params)
    {
        $stringified = array () ;
        foreach ( $params as $key => $value )
        {
            $stringified[ $key ] = $value . '' ;
        }
        return $stringified ;
    }

    public function saveKey()
    {
        $params            = $this->request->getParam('params') ;
        $stringifiedParams = $this->stringifyParamValues($params) ;

        $paramsLike = $this->paramsToLike($stringifiedParams) ;

        $key   = $this->request->getParam('key') ;
        $value = $this->request->getParam('value') ;

        $valueToSave = $value ;
        if ( is_array($value) )
        {
            $valueToSave = json_encode($value) ;
        }

        $this->sqlEngine->Select()
                ->From('core_setting')
                ->Where("`key` = ? and $paramsLike", $key)
                ->Run() ;

        if ( $this->sqlEngine->numRows() > 0 )
        {
            $this->sqlEngine->save('core_setting',
                                   array (
                '`value`' => $valueToSave
                    ),
                                   array ( "`key` = ? and $paramsLike",
                array ( $key ) )) ;
        }
        else
        {
            $this->sqlEngine->save('core_setting',
                                   array (
                'key'    => $key,
                'value'  => $valueToSave,
                'params' => json_encode($stringifiedParams)
            )) ;
        }
    }

    public function getKeyGroup()
    {

        $keyValueRecords = $this->getGroup() ;

        $finalKeyValues = array () ;
        
        //\f\pre($keyValueRecords);

        foreach ( $keyValueRecords as $keyValueRecord )
        {
            $value = $keyValueRecord[ 'value' ] ;
            //\f\pr($value);

            $valueDecoded = json_decode($value,TRUE) ;
            
            

            if ( is_array($valueDecoded) && json_last_error() == JSON_ERROR_NONE )
            {
                $value = $valueDecoded ;
            }

            $finalKeyValues[ $keyValueRecord[ 'key' ] ] = $value ;
        }

        return $finalKeyValues ;
    }

    public function getKeyGroupPart()
    {
        $keyValueRecords = $this->getGroup() ;

        $finalKeyValues = array () ;

        foreach ( $keyValueRecords as $keyValueRecord )
        {
            $finalKeyValues[ $keyValueRecord[ 'key' ] ][] = $keyValueRecord[ 'value' ] ;
        }

        return $finalKeyValues ;
    }

    private function getGroup()
    {
        $keys   = $this->request->getParam('keys') ;
        $params = $this->request->getParam('params') ;

        $stringifyParams = $this->stringifyParamValues($params) ;

        $paramsLike = $this->paramsToLike($stringifyParams) ;

        $keyValueRecords = array () ;

        if ( empty($keys) )
        {

            $this->sqlEngine->Select()
                    ->From('core_setting')
                    ->Where("$paramsLike")
                    ->Run() ;

            $keyValueRecords = $this->sqlEngine->getRows() ;
        }
        else
        {
            foreach ( $keys as $key )
            {

                $this->sqlEngine->Select()
                        ->From('core_setting')
                        ->Where("`key` = ? and $paramsLike", $key)
                        ->Run() ;

                $keyValueRecords[] = $this->sqlEngine->getRow() ;
            }
        }

        return $keyValueRecords ;
    }

    public function saveKeyGroup()
    {
        $keyValues = $this->request->getParam('keyValues') ;
        $params    = $this->request->getParam('params') ;

        foreach ( $keyValues as $key => $value )
        {
            $this->request->addAssocParam(array (
                'key'    => $key,
                'value'  => $value,
                'params' => $params
            )) ;
            $this->saveKey() ;
        }
    }

    public function deleteKeyGroup()
    {
        $key    = $this->request->getParam('key') ;
        $params = $this->request->getParam('params') ;

        $stringifyParams = $this->stringifyParamValues($params) ;

        $paramsLike = $this->paramsToLike($stringifyParams) ;

        $this->sqlEngine->Delete('core_setting')
                ->Where("$paramsLike") ;

        if ( $key )
        {
            $this->sqlEngine->andWhere("`key` = ?", $key) ;
        }
        $this->sqlEngine->Run() ;
    }

}
