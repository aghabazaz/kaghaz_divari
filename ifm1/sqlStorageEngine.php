<?php

namespace f ;

class sqlStorageEngine
{

    private $_pdo ;
    private $_query  = '' ;
    private $_stmt ;
    private $_value  = array () ;
    protected $table = '' ;
    protected $pk    = '' ;

    function query($query)
    {
        $this->_query = $query ;
        return $this ;
    }

    function __construct($dbName = '')
    {
        $this->_query = '' ;

        $driver   = ifm::app()->database[ 'driver' ] ;
        $dbName   = $dbName != '' ? $dbName : ifm::app()->database[ 'dbName' ] ;
        $username = ifm::app()->database[ 'username' ] ;
        $password = ifm::app()->database[ 'password' ] ;
        $hostName = ifm::app()->database[ 'hostName' ] ;

        if ( $this->table == '' )
        {
            $this->table = get_class($this) ;
        }

        $this->_pdo = new \PDO($driver . ':host=' . $hostName . ';dbname=' . $dbName,
                               $username, $password) ;

        $this->_pdo->exec("set names utf8") ;
    }

    public function addToQuery($queryPart)
    {
        $this->_query .= $queryPart ;
        return $this;
    }

    //------------------------------------------------------------------------------------------------
    function __destruct()
    {
        $this->_pdo = NULL ;
    }

    //------------------------------------------------------------------------------------------------
    /**
     * 
     * @param type $where
     * @param type $value
     * @return \Model
     */
    function Where($where, $value = '')
    {
        $this->_query.="WHERE $where " ;
        if ( $value )
        {
            array_push($this->_value, $value) ;
        }

        return $this ;
    }

    //------------------------------------------------------------------------------------------------
    function WhereCondition($where, $value = array ())
    {
        $this->_query.="WHERE $where " ;
        if ( ! empty($value) )
        {
            foreach ( $value as $var )
            {

                $this->_value[] = $var ;
            }
        }

        return $this ;
    }

    //------------------------------------------------------------------------------------------------
    function andWhere($where, $value = '')
    {
        $this->_query.="AND $where " ;
        if ( $value )
        {
            array_push($this->_value, $value) ;
        }

        return $this ;
    }

    //------------------------------------------------------------------------------------------------
    function orWhere($where, $value = '')
    {
        $this->_query.="OR $where " ;
        if ( $value )
        {
            array_push($this->_value, $value) ;
        }

        return $this ;
    }

    //------------------------------------------------------------------------------------------------
    function OrderBy($order)
    {
        $this->_query .= "ORDER BY $order " ;
        return $this ;
    }

    //------------------------------------------------------------------------------------------------
    function GroupBy($order)
    {
        $this->_query .= "GROUP BY $order " ;
        return $this ;
    }

    //------------------------------------------------------------------------------------------------
    function addOrderBy($order)
    {
        $this->_query .= ",$order " ;
        return $this ;
    }

    //------------------------------------------------------------------------------------------------
    function Limit($limit)
    {
        $this->_query .= "LIMIT $limit " ;
        return $this ;
    }

    //------------------------------------------------------------------------------------------------
    function union($union)
    {
        $this->_query .= "UNION $union " ;
        return $this ;
    }

    //------------------------------------------------------------------------------------------------
    function From($table)
    {
        if ( $table )
        {
            $this->_query.="FROM $table " ;
        }
        else
        {
            $this->_query.="FROM {$this->table} " ;
        }
        return $this ;
    }

    //------------------------------------------------------------------------------------------------
    function setField($fields, $values = '')
    {
        $this->_query.="SET $fields " ;
        if ( $values ) $this->_value = $values ;

        return $this ;
    }

    //------------------------------------------------------------------------------------------------
    function Join($table)
    {

        $this->_query.=", $table " ;
        return $this ;
    }

    //------------------------------------------------------------------------------------------------
    function innerJoin($table)
    {

        $this->_query.="INNER JOIN $table " ;
        return $this ;
    }

    function joinTable($table)
    {
        $this->_query.="JOIN $table " ;
        return $this ;
    }

    function leftJoin($table)
    {
        $this->_query .= "LEFT JOIN $table " ;
        return $this ;
    }

    function rightJoin($table)
    {
        $this->_query .= "RIGHT JOIN $table " ;
        return $this ;
    }

    //------------------------------------------------------------------------------------------------
    function On($where, $value = '')
    {
        $this->_query.="ON $where " ;
        if ( $value )
        {
            array_push($this->_value, $value) ;
        }

        return $this ;
    }

    //------------------------------------------------------------------------------------------------
    function getRows($returnArrayType = \PDO::FETCH_ASSOC)
    {
        return $this->_stmt->fetchAll($returnArrayType) ;
    }

    //------------------------------------------------------------------------------------------------
    function getRow($returnArrayType = \PDO::FETCH_ASSOC)
    {

        return $this->_stmt->fetch($returnArrayType) ;
    }

    //------------------------------------------------------------------------------------------------
    function Delete($table)
    {
        $this->_query = '' ;
        $this->_value = array () ;
        if ( $table )
        {
            $this->_query = "DELETE FROM $table " ;
        }
        else
        {
            $this->_query = "DELETE FROM {$this->table} " ;
        }




        return $this ;
    }

    //------------------------------------------------------------------------------------------------
    function Update($table)
    {
        $this->_query = '' ;
        $this->_value = array () ;
        if ( $table )
        {
            $this->_query .= "UPDATE $table " ;
        }
        else
        {
            $this->_query .= "UPDATE {$this->table} " ;
        }

        return $this ;
    }

    //------------------------------------------------------------------------------------------------
    function Select($fields = '*')
    {
        $this->_query = '' ;
        $this->_value = array () ;
        $this->_query .= "SELECT $fields " ;

        return $this ;
    }

    //------------------------------------------------------------------------------------------------
    function Insert($table, $fields, $value, $data)
    {

        $this->_query = '' ;
        $this->_value = array () ;
        $i            = 0 ;
        $qq           = '' ;
        while ( $i < $value )
        {
            if ( $i == 0 )
            {
                $qq.='?' ;
            }
            else
            {
                $qq.=',?' ;
            }
            $i ++ ;
        }
        if ( $table )
        {
            $this->_query.="INSERT INTO $table " ;
        }
        else
        {
            $this->_query.="INSERT INTO {$this->table} " ;
        }
        $this->_query.="($fields) VALUES ($qq)" ;
        $this->_value = $data ;

        return $this ;
    }

    //------------------------------------------------------------------------------------------------
    function Run()
    {

        $this->_stmt = $this->_pdo->prepare($this->_query) ;

        if ( substr_count($this->_query, '?') == 0 )
        {
            $this->_value = array () ;
        }

        if ( substr_count($this->_query, '?') != count($this->_value) )
        {
            return false ;
        }
        else
        {
            $result = $this->_stmt->execute($this->_value) ;
        }

        return $result ;
    }

//--------------------------------------------------------------------------------
    function _prepare($sql)
    {
        return $this->_pdo->prepare($sql) ;
    }

    //------------------------------------------------------------------------------------------------
    function Execute($query)
    {

        $result = $this->_pdo->exec($query) ;


        return $result ;
    }

    //------------------------------------------------------------------------------------------------
    function last_query()
    {
        return $this->_query ;
    }

    //------------------------------------------------------------------------------------------------
    function numRows()
    {
        return $this->_stmt->rowCount() ;
    }

    //------------------------------------------------------------------------------------------------
    function last_id()
    {
        return $this->_pdo->lastInsertId() ;
    }

    //------------------------------------------------------------------------------------------------
    function truncate($table)
    {
        $this->_query = 'TRUNCATE TABLE ' . $table ;
        return $this ;
    }

    //--------------------------------------------------------------------------
    function extract_fields($fields)
    {
        $count = 0 ;

        foreach ( $fields AS $k => $val )
        {
            $key[]   = $k ;
            $value[] = $val ;
            $count ++ ;
        }

        return array (
            'key'   => $key,
            'value' => $value,
            'count' => $count
                ) ;
    }

    //--------------------------------------------------------------------------
    function save($tableName, $fieldsArray, $condition = array ())
    {

//        error_reporting(E_ALL);
        $arr = $this->extract_fields($fieldsArray) ;

        //  pr($arr);
        if ( empty($condition) )
        {

//pr('inserting');
            $result  = $this->Insert(
                            $tableName,
                            '`' . implode('`,`', $arr[ 'key' ]) . '`',
                                          $arr[ 'count' ], $arr[ 'value' ]
                    )
                    ->Run() ;
//            pr($this->  last_query());
//            pr($this->  getValue());
            //var_dump($result);
            $result1 = $this->last_id() ;
//            pr($result1);
            if ( $result1 > 0 )
            {
                $result = $result1 ;
            }
        }
        else
        {


            $key    = implode('=?,', $arr[ 'key' ]) . '=?' ;

            $result = $this->Update($tableName)
                    ->setField($key, $arr[ 'value' ])
                    ->WhereCondition($condition[ 0 ], $condition[ 1 ])
                    ->Run() ;
        }

        return $result ;
    }

    //--------------------------------------------------------------------------
    function remove($tableName, $condition = array ())
    {

        $result=$this->Delete($tableName)
                ->WhereCondition($condition[ 0 ], $condition[ 1 ])
                ->Run() ;
        return $result;
    }

    //--------------------------------------------------------------------------
    function tableExists($tableName)
    {
        $this->_query = "SHOW TABLES LIKE '$tableName'" ;

        $this->Run() ;

        $result = $this->getRows() ;

        if ( count($result) ) return true ;
        else return false ;
    }

    function dropTable($tableName)
    {
        $this->_query = "DROP TABLE IF EXISTS $tableName" ;
        $this->Run() ;
    }

    function columnTable($tableName)
    {
        $result       = $this->_query = "DESCRIBE $tableName" ;
        return $result ;
    }

    function createTable($tableName, $fieldsArray)
    {
        //$fields  = 'id INT NOT NULL AUTO_INCREMENT, ';
        $fields .= implode(", ", $fieldsArray) ;
        //$fields .= " varchar(200), PRIMARY KEY ( id )";

        $this->_query = "CREATE TABLE IF NOT EXISTS $tableName($fields)" ;
        $this->Run() ;
    }

    function getValue()
    {
        return $this->_value ;
    }

    //--------------------------------------------------------------------------

    /**
     * Escape String
     *
     * @access	public
     * @param	string
     * @param	bool	whether or not the string will be used in a LIKE condition
     * @return	string
     */
    function escape_str($str, $like = FALSE)
    {
        if ( is_array($str) )
        {
            foreach ( $str as $key => $val )
            {
                $str[ $key ] = $this->escape_str($val, $like) ;
            }

            return $str ;
        }

        // Escape single quotes
        $str = str_replace("'", "''", remove_invisible_characters($str)) ;

        // escape LIKE condition wildcards
        if ( $like === TRUE )
        {
            $str = str_replace(
                    array (
                $this->_like_escape_chr,
                '%',
                '_' ),
                    array (
                $this->_like_escape_chr . $this->_like_escape_chr,
                $this->_like_escape_chr . '%',
                $this->_like_escape_chr . '_' ), $str
                    ) ;
        }

        return $str ;
    }

    //--------------------------------------------------------------------------
    function table()
    {
        $this->_query = "SHOW TABLES" ;

        $this->Run() ;

        $result = $this->getRows(PDO::FETCH_NUM) ;

        return $result ;
    }

    //--------------------------------------------------------------------------
    function show_cr_satatment($table)
    {
        $this->_query = "SHOW CREATE TABLE " . $table ;

        $this->Run() ;

        $result = $this->getRow(PDO::FETCH_NUM) ;

        return $result ;
    }

    public function getQuery()
    {
        return $this->_query ;
    }

    //--------------------------------------------------------------------------
    function check_unique($params)
    {
        $i = 0 ;
        $this->Select()
                ->From($params[ 'table' ]) ;
        foreach ( $params[ 'check' ] as $key => $value )
        {
            if ( $i == 0 )
            {
                $this->where("`" . $key . "` = '" . $value . "'") ;
            }
            else
            {
                $this->andWhere("`" . $key . "` = '" . $value . "'") ;
            }
            $i ++ ;
        }
        $this->Run() ;
        $out = $this->getRows() ? true : false ;
        return $out ;
    }

//    public function affectedRows(){
//        return $this->_pdo->
//    }
}
