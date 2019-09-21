<?php

namespace f\g ;

class validator
{

    public $message = array ( ) ;

    private function checkAccused ( $params )
    {
        if ( ! isset ( $params[ 'object' ] ) )
        {
            throw new \f\publicException ( "Object expected !" ) ;
        }
    }

    public function number ( $params )
    {
        $this->checkAccused ( $params ) ;
        if ( ! is_int ( $params[ 'object' ] ) )
        {
            $this->message[ $params[ 'object' ] ][ ] = 'not integer' ;
            return false ;
        }
        if ( isset ( $params[ 'range' ] ) )
        {
            $this->range ( $params ) ;
            if ( isset ( $params[ 'range' ][ 'min' ] ) && $params[ 'object' ] < $params[ 'range' ][ 'min' ] )
            {
                $this->message[ $params[ 'object' ] ][ ] = 'not in range' ;
                return false ;
            }
            if ( isset ( $params[ 'range' ][ 'max' ] ) && $params[ 'object' ] > $params[ 'range' ][ 'max' ] )
            {
                $this->message[ $params[ 'object' ] ][ ] = 'not in range' ;
                return false ;
            }
        }
        return true ;
    }

    public function string ( $params )
    {
        $this->checkAccused ( $params ) ;

        if ( ! is_string ( $params[ 'object' ] ) )
        {
            $this->message[ $params[ 'object' ] ][ ] = 'not string' ;
            return false ;
        }
        if ( isset ( $params[ 'range' ] ) )
        {
            $this->range ( $params ) ;
            if ( isset ( $params[ 'range' ][ 'min' ] ) && strlen ( $params[ 'object' ] ) < $params[ 'range' ][ 'min' ] )
            {
                $this->message[ $params[ 'object' ] ][ ] = 'not in range' ;
                return false ;
            }
            if ( isset ( $params[ 'range' ][ 'max' ] ) && strlen ( $params[ 'object' ] ) > $params[ 'range' ][ 'max' ] )
            {
                $this->message[ $params[ 'object' ] ][ ] = 'not in range' ;
                return false ;
            }
        }

        return true ;
    }

    public function email ( $params )
    {
        $this->checkAccused ( $params ) ;
        if ( ! filter_var ( $params[ 'object' ], FILTER_VALIDATE_EMAIL ) )
        {
            $this->message[ $params[ 'object' ] ][ ] = 'incorrect email' ;
            return false ;
        }
        return true ;
    }

    public function mobile ( $params )
    {
        $this->checkAccused ( $params ) ;
        $pattern = '/^(((\+|00)98)|0)?9[123]\d{8}$/' ;
        if ( preg_match ( $pattern, $params[ 'object' ] ) == false )
        {
            $this->message[ $params[ 'object' ] ][ ] = 'incorect mobile' ;
            return false ;
        }
        return true ;
    }

    public function file ( $params )
    {
        $this->checkAccused ( $params ) ;
        $temp      = explode ( ".", $_FILES[ $params[ 'object' ] ][ 'name' ] ) ;
        $extension = end ( $temp ) ;
        if ( ! in_array ( $extension, $params[ 'range' ][ 'allowedExts' ] ) )
        {
            $this->message[ $params[ 'object' ] ][ ] = 'invalid ext' ;
            return false ;
        }
        if ( isset ( $params[ 'range' ] ) )
        {
            $this->range ( $params ) ;
            if ( isset ( $params[ 'range' ][ 'min' ] ) && filesize ( $_FILES[ $params[ 'object' ] ][ 'tmp_name' ] ) * 1024 < $params[ 'range' ][ 'min' ] )
            {
                $this->message[ $params[ 'object' ] ][ ] = 'invalid size of file' ;
                return false ;
            }
            if ( isset ( $params[ 'range' ][ 'max' ] ) && filesize ( $_FILES[ $params[ 'object' ] ][ 'tmp_name' ] ) * 1024 > $params[ 'range' ][ 'max' ] )
            {
                $this->message[ $params[ 'object' ] ][ ] = 'invalid size of file' ;
                return false ;
            }
        }
        return true ;
    }

    public function checkEmpty ( $params )
    {
        $this->checkAccused ( $params ) ;
        if ( empty ( $params[ 'object' ] ) )
        {
            $this->message[ $params[ 'object' ] ][ ] = 'object is empty' ;
            return false ;
        }
        return true ;
    }

    public function url ( $params )
    {
        $this->checkAccused ( $params ) ;
        if ( ! filter_var ( $params[ 'object' ], FILTER_VALIDATE_URL ) )
        {
            $this->message[ $params[ 'object' ] ][ ] = 'invalid url' ;
            return false ;
        }
        return true ;
    }

    public function persian ( $params )
    {
        $this->checkAccused ( $params ) ;
        if ( preg_match (
                        '/^[پچجحخهعغفقثصضشسیبلاتنمکگوئدذرزطظژؤإأءًٌٍَُِّ\s\n\r\t\d\(\)\[\]\{\}.,،;\-؛]+$/',
                        $params [ 'object' ] ) == false )
        {
            $this->message[ $params[ 'object' ] ][ ] = 'not persian' ;
            return false ;
        }
        return true ;
    }

    public function password ( $params )
    {
        $this->checkAccused ( $params ) ;

        if ( isset ( $params[ 'range' ] ) )
        {
            if ( isset ( $params[ 'range' ][ 'min' ] ) && preg_match ( '$\S*(?=\S{' . $params[ 'range' ][ 'min' ] . ',})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$',
                                                                       $params[ 'object' ] ) == false )
            {
                $this->message[ $params[ 'object' ] ][ ] = 'invalid password' ;
                return false ;
            }
        }
        return true ;
    }

    public function range ( $params )
    {
        if ( isset ( $params[ 'range' ][ 'min' ] ) && isset ( $params[ 'range' ][ 'max' ] ) && $params[ 'range' ][ 'min' ] > $params[ 'range' ][ 'max' ] )
        {
            $this->message[ $params[ 'object' ] ][ ] = 'incorrect range' ;
            return false ;
        }
        return true ;
    }

    public function group ( $params )
    {
        foreach ( $params[ 'objects' ] as $listObject )
        {
            $this->objectGroup ( $listObject, $params ) ;
        }
    }

    private function objectGroup ( $listObject, $params )
    {
        foreach ( $listObject[ 'rule' ] as $objRule )
        {
            foreach ( $listObject[ 'object' ] as $object )
            {
                $range = isset ( $objRule[ 'range' ] ) ? $objRule[ 'range' ] : '' ;
                $this->$objRule[ 'name' ] ( array ( 'object' => $object, 'range'  => $range ) ) ;

                $this->defultGroup ( $object, $params ) ;
            }
        }
    }

    private function defultGroup ( $object, $params )
    {
        if ( isset ( $params[ 'defult' ] ) )
        {
            foreach ( $params[ 'defult' ] as $defultRules )
            {
                $rangeDefult = isset ( $defultRules[ 'range' ] ) ? $defultRules[ 'range' ] : '' ;
                $this->$defultRules[ 'rule' ] ( array ( 'object' => $object, 'range'  => $rangeDefult ) ) ;
            }
        }
    }

    public function getMessage ()
    {
        if ( $this->message )
        {
            return  $this->message ; //print_r ( $this->message ) ;
        }
    }
    public function url_exists($strURL) {
    $resURL = curl_init();
    curl_setopt($resURL, CURLOPT_URL, $strURL);
    curl_setopt($resURL, CURLOPT_BINARYTRANSFER, 1);
    curl_setopt($resURL, CURLOPT_HEADERFUNCTION, 'curlHeaderCallback');
    curl_setopt($resURL, CURLOPT_FAILONERROR, 1);
 
    curl_exec ($resURL);
 
    $intReturnCode = curl_getinfo($resURL, CURLINFO_HTTP_CODE);
    curl_close ($resURL);
 
    IF ($intReturnCode != 200 && $intReturnCode != 302 && $intReturnCode != 304) {
        RETURN FALSE;
    } ELSE {
        RETURN TRUE;
    }
    }

}
