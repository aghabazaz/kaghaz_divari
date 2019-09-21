<?php

namespace f\g ;

class coding
{

    const leftRandomLen  = 9 ;
    const rightRandomLen = 5 ;

    public function encode($param)
    {

        $leftRandomPart  = $this->generatePassword(self::leftRandomLen, 1) ;
        $rightRandomPart = $this->generatePassword(self::rightRandomLen, 1) ;
        return $leftRandomPart . md5(sha1(md5($param))) . $rightRandomPart ;
    }

    public function compareEncodedPasswords($leftPassword, $rightPassword)
    {

        $leftPassLen  = strlen($leftPassword) ;
        $rightPassLen = strlen($rightPassword) ;

        # +1 and -1: because of starting string indexes from 0 
        # and string lenght from 1 in PHP.
        $leftClearedPass = substr($leftPassword, self::leftRandomLen,
                                  $leftPassLen - (self::rightRandomLen + self::leftRandomLen)) ;

        $rightClearedPass = substr($rightPassword, self::leftRandomLen,
                                   $rightPassLen - (self::rightRandomLen + self::leftRandomLen)) ;
        
        if ( $leftClearedPass === $rightClearedPass )
        {
            return true ;
        }
        return false ;
    }

    private function generatePassword($length, $level)
    {

        list($usec, $sec) = explode(' ', microtime()) ;
        srand(( float ) $sec + (( float ) $usec * 100000)) ;

        $validchars[ 1 ] = "0123456789abcdfghjkmnpqrstvwxyz" ;
        $validchars[ 2 ] = "0123456789abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ" ;
        $validchars[ 3 ] = "0123456789_!@#$%&*()-=+/abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_!@#$%&*()-=+/" ;

        $password = "" ;
        $counter  = 0 ;

        while ( $counter < $length )
        {
            $actChar = substr($validchars[ $level ],
                              rand(0, strlen($validchars[ $level ]) - 1), 1) ;

            // All character must be different
            if ( ! strstr($password, $actChar) )
            {
                $password .= $actChar ;
                $counter ++ ;
            }
        }
        return $password ;
    }

    public function generateRandomString($length = 10)
    {
        $characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ' ;
        $charactersLength = strlen($characters) ;
        $randomString     = '' ;
        for ( $i = 0 ; $i < $length ; $i ++ )
        {
            $randomString .= $characters[ rand(0, $charactersLength - 1) ] ;
        }
        return $randomString ;
    }

}
