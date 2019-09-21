<?php

/**
 * Database
 */
class dataTableMapper extends \f\dal
{

    public function __construct ()
    {
        $this->sqlEngine = new \f\sqlStorageEngine ;
    }

    public function getDataTable ( $param = array ( ) )
    {
        /* SERCHING AND PAGINATION AND ORDERING IN TABLE WITH JOIN : ORDERING IS CUSTOM BY $requestDataTble FIELD */
        $requestDataTble = $param[ 'requestDataTble' ] ; // DATA :: $requestDataTble _POST DATA FROM DATATABLE SCRIPT 
        $table           = $param[ 'tableName' ] ;
        $primaryKey      = $param[ 'primaryKey' ] ;
        $columnsArray    = $param[ 'columnsArray' ] ;
        /* DATA :: $columnsArray = array(
          array(
          'db' => 'users.userName',//column name selected
          'dt' => 0,//column num++ FORM 0
          ), */
        $tbjoins         = $param[ 'tableJoinName' ] ;
        $whereJoin       = !empty($param[ 'whereJoin' ])?$param[ 'whereJoin' ]:array(1) ;
        $groupBy         = $param[ 'groupBy' ] ;
        $joinType        = $param[ 'joinType' ] ;
        $onJoin          = $param[ 'onJoin' ] ;
        $request         = $requestDataTble ;
        $columns         = $columnsArray ; //
        $bindings        = array ( ) ;
        // Build the SQL query string from the request
        
        //\f\pr($whereJoin);

        $limit          = $request ? self::limit ( $request, $columns ) : '' ;
        $order          = $request ? self::order ( $request, $columns ) : '' ;
        $where          = $request ? self::filter ( $request, $columns,
                                                    $bindings ) : '' ;
        $data[ 'draw' ] = $request ? $request[ 'draw' ] : 1 ;

        $join = self::wherej ( $where, $whereJoin, $tbjoins ) ;
        
        //\f\pr($table);
        //echo $table;
        if ( $joinType === 'left' )
        {
            $i=0;
            foreach ($tbjoins AS $data1)
            {
                $table.=' LEFT JOIN ' . $data1 . ' ON ' . $onJoin[$i] ;
                $i++;
            }
            
        }
        else
        {
            $table .= $join[ 0 ] ;
        }
        //\f\pr($table);

        if ( $join[ 1 ] )
        {
            if ( $where )
            {
                $where .= ' AND ' ;
            }
            $where .= ' (' . $join[ 1 ] . ')' ;
        }
        //echo $table;
        $data[ 'data' ]  = self::data_output ( $table, $columns, $where, $order,
                                               $limit, $groupBy ) ;
        
         //\f\pr($data['data']);
        $data[ 'total' ] = self::total ( $primaryKey, $param[ 'tableName' ], $where ) ;
        return $data ;
    }

    public function getDataMultipleTable ( $param = array ( ) )
    {
        /* SERCHING AND PAGINATION BETWEEN MULTIPLE TABLE WITH MULTIPLE INNER JOIN : ORDERING IS DEFULT BY LEVEL COLUMN */

        $requestDataTble = $param [ 'requestDataTble' ] ; //DATA :: $requestDataTble THIS FUNCTION CAN GET PARAMS LIMIT & SEARCHWORD FROM _POST OR DATATABLE SCRIPT ( BUT WITHOUT CUSTOM ORDER , ORDERING IS DEFULT)
        $arrInfo         = $param [ 'arrInfo' ] ;
        /* DATA :: $arrInfo IS =
          $where = "( SATATEMENT OF WHERE MAIN )" ;
          $arrInfo = MULTIPLE ARRAY FROM INFO TABLE ARRAY , SAMPLE :
          array(array(
          "tablename" => '',
          "column" => array("id" => "id" ,... : LIST OF SELECTED COLUMNS IN TABLE FOR VIEW RESULT ),
          "join" => array(
          array(
          "table" => '' ,
          "on" => '' ,
          "searchingJoin" => array( "title" ,... : LIST OF SEARCHING COLUMNS IN JOINED TABLE  )
          )),
          "mainWhere" => $where,
          "searchingBy" => array("title","content",... : LIST OF SEARCHING COLUMNS IN TABLE ),
          "searchinglevel" => array("title" => 1,"keywords" => 2,... : LEVEL RESULT ORDERING FOR COLUMNS SEARCHED (int from 1 - 5) ),
          ),
          );
         */
        $txt             = $param [ 'searchTxt' ] ; //DATA :: $txt STRING OF SEARCH ELEMENT CUSTOM
        $limit           = $param [ 'limit' ] ; //DATA :: $limit RESULT LIMIT CUSTOM


        $order   = '' ;
        $request = $requestDataTble ;

        if ( isset ( $request[ 'search' ] ) && $request[ 'search' ][ 'value' ] != '' )
        {
            $txt = $request[ 'search' ][ 'value' ] ;
        }


        //1 get all column and set in array
        //
        $a1 = array ( ) ;
        foreach ( $arrInfo as $rtable )
        {
            // array_push($a,$rtable['searchingBy'],$rtable['column']);
            foreach ( $rtable[ 'searchingBy' ] as $key => $value )
            {
                array_push ( $a1, $value ) ;
            }
        }
        $a = array_unique ( $a1 ) ;
        $l = array ( ) ;
        //pr($a);
        //
        //
        ///////////////////////////////////sorting order by level
        foreach ( $arrInfo as $rtable )
        {
            foreach ( $a as $allc )
            {
                if ( in_array ( $allc, $rtable[ 'searchingBy' ] ) !== 0 )
                {
                    $l[ $allc ][ ] = $rtable[ 'searchinglevel' ][ $allc ] ;
                }
            }
        }
        foreach ( $l as $ke => $coll )
        {

            $v = $coll ;
            if ( min ( $coll ) )
            {
                $m = min ( $coll ) ;
            }
            else
            {
                $m                 = $coll[ 0 ] ;
            }
            $min               = $m ;
            $l[ $ke ][ 'min' ] = $min ;
            $l[ $ke ][ 'rep' ] = 0 ;

            foreach ( $coll as $cc )
            {
                if ( $cc == $min )
                {
                    $l[ $ke ][ 'rep' ] = $l[ $ke ][ 'rep' ] + 1 ;
                }
            }

            // $c = array_count_values($stuff); 
            // $val = array_search(max($c), $c);
        }

        $sort = array ( ) ;
        foreach ( $l as $k => $v )
        {
            $sort[ 'min' ][ $k ] = $v[ 'min' ] ;
            $sort[ 'rep' ][ $k ] = $v[ 'rep' ] ;
        }
        # sort by event_type desc and then title asc
        array_multisort ( $sort[ 'min' ], SORT_ASC, $sort[ 'rep' ], SORT_DESC,
                          $l ) ;


        //pr($l);
        //die;
        //
        //
        //
        //2 create select statement for table
        //3 order level

        $union    = "" ;
        $unionpre = " UNION ALL " ;

        $i = 0 ;
        $r = "" ;
        foreach ( $arrInfo as $rtable )
        {


            $colt = array ( ) ;
            //column table
            $this->sqlEngine->Select ()
                    ->From ( $rtable[ 'tablename' ] )
                    ->Run () ;
            $r = $this->sqlEngine->getRow () ;
            if ( $r )
            {
                foreach ( $r as $key => $val )
                {
                    $colt[ ] = $key ;
                }
            }
            if ( $i == 0 )
            {

                //1:main 
                //
                $selectMain = "'" . $rtable[ 'tablename' ] . "' as tableName" ;
                $nc         = 0 ;
                foreach ( $rtable[ 'column' ] as $keyt => $tbcol )
                {
                    foreach ( $rtable[ 'column' ][ $keyt ] as $key => $col )
                    {
                        // . $rtable[ 'tablename' ] . "." 
                        $selectMain .= "," . $keyt . "." . $col . " as " . $key ;
                        $colNew[ ]   = $col ;
                        $colOrder[ ] = array ( 'db' => $col, 'dt' => $nc ) ;

                        $nc ++ ;
                    }
                }

                foreach ( $a as $columnS )
                {
                    if ( in_array ( $columnS, $colNew ) == 0 )
                    {
                        //check if in table columns:$columnS
                        if ( in_array ( $columnS, $colt ) == 0 )
                        {
                            $selectMain .= ",null as " . $columnS ;
                        }
                        else
                        {
                            //else:null
                            $selectMain .= "," . $rtable[ 'tablename' ] . "." . $columnS . " as " . $columnS ;
                        }
                        $colOrder[ ] = array ( 'db' => $columnS, 'dt' => $nc ) ;
                        $nc ++ ;
                    }
                }

                $fromMain  = $rtable[ 'tablename' ] ;
                $joinMain  = "" ;
                $whereMain = " " ;
                $wheremse  = "" ;



                //----------------------------------join
                if ( $rtable[ 'join' ] )
                {

                    $k = 1 ;

                    if ( $rtable[ 'mainWhere' ] )
                    {
                        $whereMain .= "( " ;
                    }

                    foreach ( $rtable[ 'join' ] as $rjoin )
                    {
                        if ( $rjoin[ 'typeJoin' ] == 'inner' )
                        {
                            $typeJoin = 'INNER ' ;
                        }
                        else if ( $rjoin[ 'typeJoin' ] == 'left' )
                        {
                            $typeJoin = 'LEFT ' ;
                        }
                        else if ( $rjoin[ 'typeJoin' ] == 'right' )
                        {
                            $typeJoin = 'RIGHT ' ;
                        }
                        else
                        {
                            $typeJoin = 'INNER ' ;
                        }

                        $joinMain .= $typeJoin . " JOIN " . $rjoin[ 'table' ] . " ON " . $rjoin[ 'on' ] . " " ;

                        $whereC = "" ;
                        $j      = 1 ;

                        $crsj = count ( $rjoin[ 'searchingJoin' ] ) ;

                        if ( $k !== 1 && $k !== $crsj )
                        {
                            $whereC .= " AND " ;
                        }
                        $k ++ ;
                        foreach ( $rjoin[ 'searchingJoin' ] as $rsj )
                        {

                            $pieces = explode ( " ", $txt ) ;
                            $words  = count ( $pieces ) ;

                            $whereC .= " ( ( " . $rjoin[ 'table' ] . "." . $rsj . " LIKE  '%" . $txt . "%' ) " ;

                            if ( $words > 1 )
                            {
                                $whereC .= " OR ( ( " . $rjoin[ 'table' ] . "." . $rsj . " LIKE  '%" . $pieces[ 0 ] . "%' )" ;
                            }

                            for ( $i = 1 ; $i < $words ; $i ++  )
                            {
                                $like = $pieces[ $i ] ;

                                $whereC .= " AND ( " . $rjoin[ 'table' ] . "." . $rsj . " LIKE  '%" . $like . "%' )" ;
                            }
                            if ( $words > 1 )
                            {
                                $whereC .= " ) " ;
                            }
                            $whereC .= " ) " ;
                            if ( $j !== $crsj )
                            {
                                $whereC .= " OR " ;
                            }
                            $j ++ ;
                            $whereMain .= $whereC ;
                        }
                    }
                    if ( $rtable[ 'mainWhere' ] && ! $rtable[ 'searchingBy' ] )
                    {
                        if ( $rjoin[ 'searchingJoin' ] )
                        {
                            $s = ' AND  ' ;
                        }
                        else
                        {
                            $s = '' ;
                        }
                        //AND clear
                        $whereMain .= $s . $rtable[ 'mainWhere' ] . " )" ;
                    }
                }

                ////2
                //-----------------------------------search main
                $bet    = "" ;
                $whereC = "" ;


                if ( $rtable[ 'searchingBy' ] )
                {
                    if ( $rtable[ 'join' ] )
                    {
                        $whereC .= " OR " ; //(
                    }

                    if ( $rtable[ 'join' ] )
                    {
                        $mpre = $rtable[ 'tablename' ] . '.' ;
                    }
                    else
                    {
                        $mpre = '' ;
                    }


                    $j    = 1 ;
                    $crsj = count ( $rtable[ 'searchingBy' ] ) ;

                    $pieces = explode ( " ", $txt ) ;
                    $words  = count ( $pieces ) ;



                    foreach ( $rtable[ 'searchingBy' ] as $mse )
                    {

                        $whereC .= " ( ( " . $mpre . $mse . " LIKE  '%" . $txt . "%' ) " ;

                        if ( $words > 1 )
                        {
                            $whereC .= " OR ( ( " . $mpre . $mse . " LIKE  '%" . $pieces[ 0 ] . "%' )" ;
                        }

                        for ( $i = 1 ; $i < $words ; $i ++  )
                        {
                            $like = $pieces[ $i ] ;

                            $whereC .= " AND ( " . $mpre . $mse . " LIKE  '%" . $like . "%' )" ;
                        }

                        if ( $words > 1 )
                        {
                            $whereC .= " ) " ;
                        }

                        $whereC .= " ) " ;

                        if ( $j !== $crsj )
                        {
                            $whereC .= " OR " ;
                        }
                        $j ++ ;
                    }

                    $wheremse .= $whereC ;
                    if ( $rtable[ 'join' ] && $rtable[ 'mainWhere' ] )
                    {
                        $wheremse .= " )" ;
                    }
                    if ( $rtable[ 'mainWhere' ] )
                    {
                        $wheremse .= " AND  " . $rtable[ 'mainWhere' ] ;
                    }
                }
            }
            else
            {
                //--------------------------------------other search union
                //2:other
                //
                $selectMain2 = "'" . $rtable[ 'tablename' ] . "' as tableName" ;
                //. $rtable['tablename'] . ".id as id," . $rtable['title'] . " as title," . $rtable['pic'] . " as pic";

                foreach ( $rtable[ 'column' ] as $keyt => $tbcol )
                {
                    foreach ( $rtable[ 'column' ][ $keyt ] as $key => $col )
                    {
                        // . $rtable[ 'tablename' ] . "." 
                        $selectMain2 .= "," . $keyt . "." . $col . " as " . $key ;
                        $colNew[ ] = $col ;
                    }
                }
                foreach ( $a as $columnS )
                {
                    if ( in_array ( $columnS, $colNew ) == 0 )
                    {
                        //check if in table columns:$columnS
                        if ( in_array ( $columnS, $colt ) == 0 )
                        {
                            $selectMain2 .= ",null as " . $columnS ;
                        }
                        else
                        {
                            //else:null
                            $selectMain2 .= "," . $rtable[ 'tablename' ] . "." . $columnS . " as " . $columnS ;
                        }
                    }
                }

                //print_r ( $columnsNew ) ;
//$selectMain2 = "'" . $rtable['tablename'] . "' as tableName," . $rtable['tablename'] . ".id as id," . $rtable['title'] . " as title," . $rtable['pic'] . " as pic";
                $fromMain2  = $rtable[ 'tablename' ] ;
                $joinMain2  = "" ;
                $whereMain2 = " WHERE " ;
                $wheremse2  = "" ;


                //----------------------------------join
                if ( $rtable[ 'join' ] )
                {

                    $k2 = 1 ;

                    if ( $rtable[ 'mainWhere' ] )
                    {
                        $whereMain2 .= "( " ;
                    }

                    if ( $rjoin[ 'typeJoin' ] == 'inner' )
                    {
                        $typeJoin = 'INNER ' ;
                    }
                    else if ( $rjoin[ 'typeJoin' ] == 'left' )
                    {
                        $typeJoin = 'LEFT ' ;
                    }
                    else if ( $rjoin[ 'typeJoin' ] == 'right' )
                    {
                        $typeJoin = 'RIGHT ' ;
                    }
                    else
                    {
                        $typeJoin = 'INNER ' ;
                    }

                    foreach ( $rtable[ 'join' ] as $rjoin2 )
                    {
                        $joinMain2 .= $typeJoin . "JOIN " . $rjoin2[ 'table' ] . " ON " . $rjoin2[ 'on' ] . " " ;

                        $whereC2 = "" ;
                        $j2      = 1 ;

                        $crsj2 = count ( $rjoin2[ 'searchingJoin' ] ) ;

                        if ( $k2 !== 1 && $k2 !== $crsj2 )
                        {
                            $whereC2 .= " AND " ;
                        }
                        $k2 ++ ;
                        foreach ( $rjoin2[ 'searchingJoin' ] as $rsj2 )
                        {

                            $pieces2 = explode ( " ", $txt ) ;
                            $words2  = count ( $pieces2 ) ;

                            $whereC2 .= " ( ( " . $rjoin2[ 'table' ] . "." . $rsj2 . " LIKE  '%" . $txt . "%' ) " ;

                            if ( $words2 > 1 )
                            {
                                $whereC2 .= " OR ( ( " . $rjoin2[ 'table' ] . "." . $rsj2 . " LIKE  '%" . $pieces2[ 0 ] . "%' )" ;
                            }

                            for ( $i2 = 1 ; $i2 < $words2 ; $i2 ++  )
                            {
                                $like2 = $pieces2[ $i2 ] ;

                                $whereC2 .= " AND ( " . $rjoin2[ 'table' ] . "." . $rsj2 . " LIKE  '%" . $like2 . "%' )" ;
                            }
                            if ( $words2 > 1 )
                            {
                                $whereC2 .= " ) " ;
                            }
                            $whereC2 .= " ) " ;
                            if ( $j2 !== $crsj2 )
                            {
                                $whereC2 .= " OR " ; //aND
                            }
                            $j2 ++ ;
                            $whereMain2 .= $whereC2 ;
                        }
                    }
                    if ( $rtable[ 'mainWhere' ] && ! $rtable[ 'searchingBy' ] )
                    {
                        $whereMain2 .= " AND  " . $rtable[ 'mainWhere' ] . " )" ;
                    }
                }

                //-----------------------------------search main
                $bet2    = "" ;
                $whereC2 = "" ;


                if ( $rtable[ 'searchingBy' ] )
                {
                    if ( $rtable[ 'join' ] )
                    {
                        $whereC2 .= " OR " ; //(
                    }

                    if ( $rtable[ 'join' ] )
                    {
                        $mpre2 = $rtable[ 'tablename' ] . '.' ;
                    }
                    else
                    {
                        $mpre2 = '' ;
                    }


                    $j2    = 1 ;
                    $crsj2 = count ( $rtable[ 'searchingBy' ] ) ;

                    $pieces2 = explode ( " ", $txt ) ;
                    $words2  = count ( $pieces2 ) ;



                    foreach ( $rtable[ 'searchingBy' ] as $mse2 )
                    {

                        $whereC2 .= " ( ( " . $mpre2 . $mse2 . " LIKE  '%" . $txt . "%' ) " ;

                        if ( $words2 > 1 )
                        {
                            $whereC2 .= " OR ( ( " . $mpre2 . $mse2 . " LIKE  '%" . $pieces2[ 0 ] . "%' )" ;
                        }

                        for ( $i2 = 1 ; $i < $words2 ; $i2 ++  )
                        {
                            $like2 = $pieces2[ $i2 ] ;

                            $whereC2 .= " AND ( " . $mpre2 . $mse2 . " LIKE  '%" . $like2 . "%' )" ;
                        }

                        if ( $words2 > 1 )
                        {
                            $whereC2 .= " ) " ;
                        }

                        $whereC2 .= " ) " ;

                        if ( $j2 !== $crsj2 )
                        {
                            $whereC2 .= " OR " ;
                        }
                        $j2 ++ ;
                    }

                    $wheremse2 .= $whereC2 ;
                    if ( $rtable[ 'join' ] && $rtable[ 'mainWhere' ] )
                    {
                        $wheremse2 .= " )" ;
                    }
                    if ( $rtable[ 'mainWhere' ] )
                    {
                        $wheremse2 .= " AND  " . $rtable[ 'mainWhere' ] ;
                    }
                }



                $union .= $unionpre . " SELECT " . $selectMain2 . " FROM " . $fromMain2 . " " . $joinMain2 . " " . $whereMain2 . " " . $wheremse2 ;
            }

            $i ++ ;
        }

        //-------------------------------order 
        if ( isset ( $request[ 'order' ] ) && $arrInfo )
        {
            $order = self::order ( $request, $colOrder ) ; //$colOrder//$columnsNew
            $order = implode ( ',', $order ) ;
        }
        else
        {
            $pieces3 = explode ( " ", $txt ) ;
            $words3  = count ( $pieces3 ) ;


            //order by all column searching by level 
            foreach ( $l as $keyl => $vall )
            {

                $order .= $keyl . " LIKE '" . $txt . "%' DESC," ;
                $order .= $keyl . " LIKE '%" . $txt . "%' DESC," ;
                if ( $words3 > 1 )
                {
                    $order .= $keyl . " LIKE  '%" . $pieces3[ 0 ] . "%' DESC," ;
                    //$order = ", LOCATE('".$pieces3[0]."',title) DESC";
                }

                for ( $i = 1 ; $i < $words3 ; $i ++  )
                {
                    $like3 = $pieces3[ $i ] ;

                    $order .= $keyl . " LIKE  '%" . $like3 . "%' DESC," ;
                }
            }
            $order = mb_substr ( $order, 0, -1 ) ;
        }
        //limit
        if ( isset ( $request[ 'start' ] ) && $request[ 'length' ] != -1 )
        {
            $limit = " " . intval ( $request[ 'start' ] ) . ", " . intval ( $request[ 'length' ] ) ;
        }
        else
        {
            $limit = "" ;
        }


        $this->sqlEngine->Select ( $selectMain )
                ->From ( $fromMain . " " . $joinMain )
                ->Where ( $whereMain . " " . $wheremse . " " . $union )
                ->OrderBy ( $order ) ;
        if ( $limit )
        {
            $this->sqlEngine->Limit ( $limit ) ;
        }
        $this->sqlEngine->Run () ;
        $data[ 'data' ] = $this->sqlEngine->getRows () ;

        //echo $this->sqlEngine->last_query () ;
        // Total data set length

        $this->sqlEngine->Select ( $selectMain )
                ->From ( $fromMain . " " . $joinMain )
                ->Where ( $whereMain . " " . $wheremse . " " . $union )
                ->Run () ;

        $resTotalLength = $this->sqlEngine->getRows () ;

        $recordsTotal = count ( $resTotalLength ) ;

        $data[ 'total' ] = $recordsTotal ;
        if ( $request )
        {
            $data[ 'draw' ] = $request[ 'draw' ] ;
        }
        else
        {
            $data[ 'draw' ] = 1 ;
        }

        return $data ;
    }

    static function limit ( $request, $columns )
    {
        $limit = '' ;

        if ( isset ( $request[ 'start' ] ) && $request[ 'length' ] != -1 )
        {
            $limit = " " . intval ( $request[ 'start' ] ) . ", " . intval ( $request[ 'length' ] ) ;
        }

        return $limit ;
    }

    static function order ( $request, $columns )
    {
        $order = '' ;
        if ( isset ( $request[ 'order' ] ) && count ( $request[ 'order' ] ) )
        {
            $orderBy = array ( ) ;

            $dtColumns = self::pluck ( $columns, 'dt' ) ;

            for ( $i = 0, $ien = count ( $request[ 'order' ] ) ; $i < $ien ; $i ++  )
            {
                // Convert the column index into the column data property
                $columnIdx     = intval ( $request[ 'order' ][ $i ][ 'column' ] ) ;
                $requestColumn = $request[ 'columns' ][ $columnIdx ] ;

                $columnIdx = array_search ( $requestColumn[ 'data' ], $dtColumns ) ;
                $column    = $columns[ $columnIdx ] ;
                
                $arr=  explode(' AS ', $column['db']);
                //\f\pr($requestColumn);
                if(  count ( $arr)>1)
                {
                    $column[ 'db' ]=$arr[0];
                }

                if ( $requestColumn[ 'orderable' ] == 'true' )
                {
                    $dir = $request[ 'order' ][ $i ][ 'dir' ] === 'asc' ?
                            'ASC' :
                            'DESC' ;

                    $orderBy[ ] = '' . $column[ 'db' ] . ' ' . $dir ;
                }
            }

            $order = $orderBy ;
        }

        return $order ;
    }

    static function pluck ( $a, $prop )
    {


        $out = array ( ) ;
        for ( $i = 0, $len = count ( $a ) ; $i < $len ; $i ++  )
        {
            $out[ ] = $a[ $i ][ $prop ] ;
        }
        return $out ;
    }

    static function filter ( $request, $columns, &$bindings )
    {

        $globalSearch = array ( ) ;
        $columnSearch = array ( ) ;
        $dtColumns = self::pluck ( $columns, 'dt' ) ;

        if ( isset ( $request[ 'search' ] ) && $request[ 'search' ][ 'value' ] != '' )
        {
            $str = $request[ 'search' ][ 'value' ] ;
//echo $str."***";
//pr($bindings);
            for ( $i = 0, $ien = count ( $request[ 'columns' ] ) ; $i < $ien ; $i ++  )
            {
                $requestColumn = $request[ 'columns' ][ $i ] ;
                
                $columnIdx     = array_search ( $requestColumn[ 'data' ],
                                                $dtColumns ) ;
                $column        = $columns[ $columnIdx ] ;
                
                $arr=  explode(' AS ', $column['db']);
                //\f\pr($requestColumn);
                if(  count ( $arr)>1)
                {
                    $column[ 'db' ]=$arr[0];
                }

                if ( $requestColumn[ 'searchable' ] == 'true' )
                {
                    $binding         = self::bind ( $bindings, '%' . $str . '%',
                                                    PDO::PARAM_STR ) ;
                    $globalSearch[ ] = "" . $column[ 'db' ] . " LIKE '" . '%' . $str . "%'" ;
                }
            }
        }

        // Individual column filtering
        for ( $i = 0, $ien = count ( $request[ 'columns' ] ) ; $i < $ien ; $i ++  )
        {
            $requestColumn = $request[ 'columns' ][ $i ] ;
            $columnIdx     = array_search ( $requestColumn[ 'data' ], $dtColumns ) ;
            $column        = $columns[ $columnIdx ] ;

            $str = $requestColumn[ 'search' ][ 'value' ] ;

            if ( $requestColumn[ 'searchable' ] == 'true' &&
                    $str != '' )
            {

                $binding         = self::bind ( $bindings, '%' . $str . '%',
                                                PDO::PARAM_STR ) ;
                $columnSearch[ ] = "" . $column[ 'db' ] . " LIKE '" . '%' . $str . "%'" ;
            }
        }

        // Combine the filters into a single string
        $where = '' ;

        if ( count ( $globalSearch ) )
        {
            $where = '(' . implode ( ' OR ', $globalSearch ) . ')' ;
        }

        if ( count ( $columnSearch ) )
        {
            $where = $where === '' ?
                    implode ( ' AND ', $columnSearch ) :
                    $where . ' AND ' . implode ( ' AND ', $columnSearch ) ;
        }

        if ( $where !== '' )
        {
            $where = ' ' . $where ;
        }
        
        //\f\pre($where);

        return $where ;
    }

    static function bind ( &$a, $val, $type )
    {
        $key = ':binding_' . count ( $a ) ;

        $a[ ] = array (
            'key'  => $key,
            'val'  => $val,
            'type' => $type
                ) ;

        return $key ;
    }

    private function wherej ( $where, $whereJoin, $tbjoins )
    {
        // \f\pr($whereJoin);
        $tb     = '' ;
        $wherej = '' ;
        if ( is_array ( $tbjoins ) or is_array ( $whereJoin ) )
        {

            if ( preg_match ( '/^WHERE/', $where ) )
            {
                $wherej = ' and ' ;
            }
            else
            {
                $wherej = ' ' ;
            }
            if ( is_array ( $tbjoins ) )
            {
                for ( $i = 0 ; $i < count ( $tbjoins ) ; $i ++  )
                {
                    $tb .= ',' . $tbjoins[ $i ] ;
                }
            }
            for ( $j = 0 ; $j < count ( $whereJoin ) ; $j ++  )
            {
                $and = ($j == 0) ? '' : ' and ' ;
                $wherej .= $and . $whereJoin[ $j ] ;
            }
        }
        //   \f\pr($wherej);
        return array ( $tb, $wherej ) ;
    }

    private function data_output ( $table, $columns, $where, $order, $limit,
                                   $groupBy = '' )
    {
        //\f\pr($order);
        //$order='t2.title ASC';
        // Main query to actually get the data
        $this->sqlEngine->Select ( implode ( ", ",
                                             self::pluck ( $columns, 'db' ) ) )
                ->From ( $table ) ;
        if ( $where )
        {
            $this->sqlEngine->Where ( $where ) ;
        }
        if ( $groupBy )
        {
            $this->sqlEngine->GroupBy ( $groupBy ) ;
        }
        if ( $order )
        {
            $this->sqlEngine->OrderBy ( implode ( ', ', $order ) ) ;
        }
        if ( $limit )
        {
            $this->sqlEngine->Limit ( $limit ) ;
        }
        $this->sqlEngine->Run () ;

   //  \f\pre($this->sqlEngine->last_query());
        return $this->sqlEngine->getRows () ;

        //\f\pr($this->sqlEngine->last_query());
    }

    private function total ( $primaryKey, $table, $where )
    {
        // Total data set length
        $this->sqlEngine
                ->Select ( ' COUNT(' . $primaryKey . ') as count ' )
                ->From ( $table ) ;
        if ( $where )
        {
            $this->sqlEngine->Where ( $where ) ;
        }

        $this->sqlEngine->Run () ;
        $resTotalLength = $this->sqlEngine->getRows () ;
        //echo $this->sqlEngine->last_query();
        //\f\pr($resTotalLength);
        if ( $resTotalLength )
        {
            return $resTotalLength[ 0 ][ 'count' ] ;
        }
        else
        {
            return 0 ;
        }
    }

    /*
      public function defaultGetList($requestDataTble){
      //print_r($requestDataTble);

      // Main query to actually get the data
      $this->sqlEngine->Select ( 'name,userName' )
      ->From ( $this->table )
      ->Limit ( $requestDataTble['start'].",".$requestDataTble['length'] )
      ->Run () ;

      $data['data'] = $this->sqlEngine->getRows () ;

      // get count all data
      $this->sqlEngine
      ->Select ( ' COUNT(`userName`) as count ' )
      ->From ( $this->table )
      ->Run () ;
      $resTotalLength = $this->sqlEngine->getRows () ;

      $recordsTotal = $resTotalLength[ 0 ][ 'count' ] ;

      $data[ 'total' ] = $recordsTotal ;
      if($requestDataTble){
      $data[ 'draw' ] = $requestDataTble['draw'];
      }else{
      $data[ 'draw' ] = 1 ;
      }
      return $data ;
      }
     */
}
